<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Asset;
use Illuminate\Http\Request;
use Phpml\Clustering\DBSCAN;
use Phpml\Association\Apriori;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Phpml\Regression\LeastSquares;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AnalyticController extends Controller
{

    public function index()
    {


        $averageProductsPerDay = round($this->averageAssets());
        //list($isVirtual, $isNotVirtual) = $this->virtualCategories();
        list($perYear, $yearCount) = $this->assetsPerDate();
        $rules = $this->patterns();
        return view('statistics.index', ['averageProductsPerDay' => $averageProductsPerDay, 'perYear' => json_encode($perYear), 'yearCount' => json_encode($yearCount), 'apriori' => json_encode($apriori)]);
    }






    public function assetsPerDate()
    {
        try {
            $prevNextFiveYears = Date('Y') + 5;
            $multi_array = array();
            $productsCount = Asset::selectRaw('EXTRACT(YEAR FROM created_at) AS date, COUNT(*) AS count')
                ->groupBy('date')
                ->take(5000)->get();
            if (count($productsCount)) {
                foreach ($productsCount as $productPerYear) {
                    $perYear[] = $productPerYear->date;
                    $yearCount[] = $productPerYear->count;
                }
                foreach ($perYear as $year) {
                    $multi_array[] = array($year);
                }
                $regression = new LeastSquares();
                $regression->train($multi_array, $yearCount);
                $predict_value = $regression->predict([$prevNextFiveYears]);
                array_push($yearCount, $predict_value);
                array_push($perYear, $prevNextFiveYears);
                return array($yearCount, $perYear);
            }
        } catch (Exception $e) {
            dd($e);
            Redirect::to('/')->withErrors([$e->getMessage()]);
        }
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

    /* public function virtualCategories()
    {

        $virtualCount = Category::select('category_name', 'virtuality')->groupBy('category_name', 'virtuality')->cursor();
        $isVirtual = [];
        $isNotVirtual = [];
        foreach ($virtualCount as $virtual) {
            if ($virtual->virtuality == 1) {
                $isVirtual[] = $virtual->category_name;
            } else {
                $isNotVirtual[] = $virtual->category_name;
            }
        }

        return array(count($isVirtual), count($isNotVirtual));
    }*/

    public function runPythonScript()
    {
        $arg1 = "potato";
        $arg2 = "fdjdf";
        $result = shell_exec("python /path/to/your/python/script.py " . escapeshellarg($arg1) . " " . escapeshellarg($arg2));
        return $result;
    }
    public function patterns()
    {
        $asset = Asset::select('filetype')
            ->groupBy('filetype')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(10)->get()->pluck('filetype');
        dd($asset);
    }
}
