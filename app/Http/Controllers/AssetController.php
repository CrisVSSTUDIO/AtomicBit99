<?php


namespace App\Http\Controllers;


use splade;
use Exception;
use ZipArchive;
use App\Models\Tag;
use App\Models\User;
use App\Models\Asset;
use App\Tables\Assets;
use Phpml\Math\Matrix;
use App\Models\Category;
use Phpml\Regression\SVR;
use Chumper\Zipper\Zipper;
use Phpml\Metric\Accuracy;
use Illuminate\Support\Str;
use App\Tables\SharedAssets;
use Illuminate\Http\Request;
use Phpml\Clustering\DBSCAN;
use Phpml\Clustering\KMeans;
use Phpml\Classification\SVC;
use Illuminate\Testing\Assert;
use Phpml\Math\Statistic\Mean;
use Phpml\Dataset\ArrayDataset;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Phpml\Regression\LeastSquares;
use Illuminate\Support\Facades\Log;
use Phpml\Preprocessing\Normalizer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Phpml\Classification\NaiveBayes;
use ProtoneMedia\Splade\SpladeTable;
use Phpml\Metric\ClassificationReport;
use Phpml\SupportVectorMachine\Kernel;
use ProtoneMedia\Splade\Facades\Toast;
use Illuminate\Support\Facades\Storage;
use Phpml\Classification\MLPClassifier;
use Phpml\FeatureSelection\SelectKBest;
use App\Http\Requests\StoreAssetRequest;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UpdateAssetRequest;
use App\Mail\SharedAsset;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Tokenization\WhitespaceTokenizer;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use ProtoneMedia\Splade\FileUploads\ExistingFile;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AssetController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->authorizeResource(Asset::class, 'asset');
    }
    public function index()
    {

        return view('products.index', [
            'assets' => Assets::class,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssetRequest $request)
    {
        // Assuming 'upload' is a required field and validated by StoreAssetRequest
        collect($request->file('upload'))->each(function ($file) use ($request) {
            $path = $file->store();
            Asset::create([
                'name' =>  Str::take($file->getClientOriginalName(), 16),
                'description' => $request->description ?? '-',
                'filesize' => round($file->getSize() / 1048576, 2), // Convert bytes to megabytes
                'filetype' => $file->extension(),
                'slug' => Str::slug($file->getClientOriginalName()),
                'upload' => $path,
                'user_id' => Auth::id() // Directly access the authenticated user's ID

            ]);
        });

        Toast::title('Asset inserted!')->autoDismiss(8);
        return back();
    }
    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        //
        /*   $asset = $asset->load('tags');
        $tags = Tag::select('id', 'tag_name')->get(); */

        //show related products
        $this->authorize('view', $asset);
        $users = User::select('id', 'name')->get();
        return view('products.show', compact('asset', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        //

        return view('products.edit', compact('asset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssetRequest $request, Asset $asset)
    {
        //
        $request->validated();
        if ($request->has('tags')) {
            $asset->tags()->sync($request->tags);
        }

        $asset->update([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'slug' => Str::slug($request->get('name')),
            'user_id' => Auth::id(),
            'upload' => $request->hasFile('upload') ? $request->file('upload')->store() : $asset->upload,
            'filetype' => $request->hasFile('upload') ? $request->file('upload')->extension() : $asset->filetype,
            'filesize' => round($request->hasFile('upload') ? $request->file('upload')->getSize() : $asset->filetype / 1048576, 2), // Convert bytes to megabytes

        ]);
        Toast::title('Asset updated!')->autoDismiss(8);

        return back();
    }
    public function patterns()
    {
        $mostPopular = Asset::select('filetype')->where('user_id', Auth::user()->id)
            ->groupBy('filetype')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(10)->get()->pluck('filetype');
        return $mostPopular;
    }
    /**
     * Remove the specified resource from storage.
     */
    public function restore($id)
    {
        $asset = Asset::onlyTrashed()->findOrFail($id);
        $asset->restore();
        Toast::title('Asset restored!')->autoDismiss(8);

        return back();
    }
    public function downloadAll()
    {
        $files = Asset::pluck('upload');
        $zipFile = 'files.zip';

        $zip = new ZipArchive();
        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            throw new Exception("Cannot open $zipFile");
        }

        foreach ($files as $file) {
            $filePath = storage_path("app/$file");
            // if (!Storage::exists($file)) {
            //     $zip->close();
            //     throw new Exception("File does not exist: $filePath");
            // }
            $zip->addFile($filePath, basename($file));
        }

        $zip->close();
        return response()->download($zipFile)->deleteFileAfterSend(true);
    }
    public function forceDelete($id)
    {
        $asset = Asset::onlyTrashed()->findOrFail($id);
        if ($asset->upload) {
            Storage::delete($asset->upload);
        }
        $asset->tags()->detach();
        $asset->forceDelete();
        Toast::title('Asset yeeted!')
            ->autoDismiss(8);
        return back();
    }
    public function destroy(Asset $asset)
    {
        //
        $asset->delete();
        Toast::title('Asset sent to the recycle center!')->autoDismiss(8);

        return redirect('assets.index');
    }
    public function downloadFile(Asset $asset)
    {
        $file = Asset::where('id', $asset->id)->value('upload');
        if (Storage::exists($file)) {
            return Storage::download($file);
        } else {
            return redirect('assets.index');

            Toast::warning('There is no file to download')->autoDismiss(8);
        }
    }
    public function sharePage(Asset $asset)
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('products.share.index', compact('asset', 'users'));
    }
    public function shareFiles(Request $request, Asset $asset)
    {
        $asset->users()->sync($request->users);
        //get user emails
        $userEmails = User::whereIn('id', $request->users)->pluck('email');
        Mail::to($userEmails)->send(new SharedAsset($asset));
        Toast::title('Shared with success!')->autoDismiss(8);

        return back();
    }
    public function naiveBayes()
    {
        try {
            // Retrieve file types and sizes from the database
            $files = Asset::select('id', 'filetype', 'filesize')
                ->where('user_id', Auth::user()->id)
                ->whereNull('deleted_at')
                ->orderBy('filesize')
                ->take(500)
                ->get();
            // Check if files collection is not empty
            if ($files->isEmpty()) {
                Toast::warning('No files for the classifier!')->autoDismiss(8);
                return back();
            }

            // Prepare the dataset
            $samples = $files->pluck('filesize')->map(function ($size) {
                return [$size];
            })->all();
            $labels = $files->pluck('filetype')->all();

            // Create the dataset
            $dataset = new ArrayDataset($samples, $labels);

            // Split the dataset
            $split = new StratifiedRandomSplit($dataset);

            // Create and Test the Naive Bayes classifier
            $classifier = new NaiveBayes();
            $classifier->train($split->getTrainSamples(), $split->getTrainLabels());

            // Predict file types for test samples
            $predictions = $classifier->predict($samples);
            $classificationRport = new ClassificationReport($labels, $predictions);
            $accuracy = Accuracy::score($labels, $predictions);

            // Update database records with predictions
            foreach ($predictions as $index => $prediction) {
                DB::table('assets')
                    ->where('id', $files[$index]->id)
                    ->update(['filetype_prediction' => $prediction]);
            }
            // Return accuracy and predictions
            Toast::title('Asset classification done!')->autoDismiss(8);
            return back();
        } catch (\Exception $e) {

            Toast::warning($e)->autoDismiss(8);
            return back();
        }
        /*         return ['accuracy' => $accuracy, 'predictions' => $predictions];
 */
    }

    public function SelectKBest()
    {
        $samples = [];
        $labels = [];
        // Retrieve file types and sizes from the database
        $files = Asset::select('filesize', 'filetype')
            ->where('user_id', Auth::user()->id)
            ->whereNull('deleted_at')
            ->orderBy('filesize')
            ->get();

        // Check if files collection is not empty
        if ($files->isEmpty()) {
            Toast::warning('No files for the classifier!')->autoDismiss(8);
            return back();
        }
        // Prepare the data for clustering
        foreach ($files as $file) {
            $samples[] = [$file->filesize]; // Each sample should be an array of features
            $labels[] = $file->filetype;
        }

        // Use KMeans or another suitable clustering algorithm
        $kmeans = new KMeans(2); // Specify the number of clusters
        $clusters = $kmeans->cluster($samples);

        // Combine the clusters with labels
        $labeledClusters = [];
        foreach ($clusters as $clusterIndex => $cluster) {
            foreach ($cluster as $sampleIndex => $sample) {
                $labeledClusters[$labels[$sampleIndex]][] = $sample[0];
            }
        }
        return $labeledClusters;
    }
    public function textImportance()
    {
        $samples = [
            'Lorem ipsum dolor sit amet dolor',
            'Mauris placerat ipsum dolor',
            'Mauris diam eros fringilla diam',
        ];

        $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());

        // Build the dictionary.
        $vectorizer->fit($samples);

        // Transform the provided text samples into a vectorized list.
        $vectorizer->transform($samples);

        $transformer = new TfIdfTransformer($samples);
        $transformer->transform($samples);
        // return $samples = [
        //    [0 => 1, 1 => 1, 2 => 2, 3 => 1, 4 => 1],
        //    [5 => 1, 6 => 1, 1 => 1, 2 => 1],
        //    [5 => 1, 7 => 2, 8 => 1, 9 => 1],
        //];

    }
    public function averageAssets()
    {
        $productsCount = Asset::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->cursor();
        if (count($productsCount)) {
            $averageProductsPerDay = $productsCount->sum('count') / $productsCount->count();
            return $averageProductsPerDay;
        }
    }
    public function assetAnalytics()
    {
        $averageProductsPerDay = round($this->averageAssets());
        if ($averageProductsPerDay == 0) {
            Toast::warning('No files available for analytics!')->autoDismiss(8);
            return back();
        }
        $mostPopular = $this->patterns();
        list($perYear, $yearCount) = $this->assetsPerDate();
        $labeledClusters = $this->SelectKBest();


        $clusterKeys = array_keys($labeledClusters);
        $clusterValues = array_values($labeledClusters);


        return view('products.analytics.index', [
            'clusterKeys' => json_encode($clusterKeys) ?? [],
            'clusterValues' => json_encode($clusterValues) ?? [],
            'averageProductsPerDay' => json_encode($averageProductsPerDay),
            'perYear' => json_encode($perYear),
            'yearCount' => json_encode($yearCount),
            'mostPopular' => $mostPopular
        ]);
    }
    public function assetsPerDate()
    {

        $prevNextFiveYears = Date('Y') + 5;
        $multi_array = array();
        $productsCount = Asset::selectRaw('EXTRACT(YEAR FROM created_at) AS date, COUNT(*) AS count')
            ->groupBy('date')
            ->take(500)->get();
        if (count($productsCount)) {
            foreach ($productsCount as $productPerYear) {
                $perYear[] = $productPerYear->date;
                $yearCount[] = $productPerYear->count;
            }
            foreach ($perYear as $year) {
                $multi_array[] = array($year);
            }
            $regression =  new SVR();
            $regression->train($multi_array, $yearCount);
            $predict_value = $regression->predict([$prevNextFiveYears]);
            array_push($yearCount, $predict_value);
            array_push($perYear, $prevNextFiveYears);
            return array($yearCount, $perYear);
        }
    }
    public function assetsCardView()
    {

        $assets = Asset::select('id', 'name', 'description', 'slug', 'filesize', 'filetype', 'filetype_prediction', 'upload')->where('user_id', Auth::user()->id)->whereNull('deleted_at')->orderBy('filesize')->get();
        return view('products.card.index', compact('assets'));
    }
    public function sharedAssets()
    {
        return view('products.shared.index', [
            'sharedAssets' => SharedAssets::class,
        ]);
    }
}
