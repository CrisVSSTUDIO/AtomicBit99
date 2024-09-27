<?php

namespace App\Tables;

use Exception;
use ZipArchive;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use ProtoneMedia\Splade\SpladeTable;
use Illuminate\Support\Facades\Cache;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AssetController;

class Assets extends AbstractTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user is authorized to perform bulk actions and exports.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return Auth::check();
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        $assets = Asset::where('user_id', Auth::user()->id)->whereNull('deleted_at')->latest();
        return $assets;
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
    {

        $table
            ->defaultSort('name')
            ->rowLink(function (Asset $asset) {
                
                return route('assets.show', $asset);
            })
            ->column(label: 'Upload', exportAs: false)
            ->column(key: 'name', searchable: true, sortable: true)
            ->column(key: 'description', searchable: true, sortable: true, hidden: true)
            ->column(key: 'slug', searchable: true, sortable: true, hidden: true,)
            ->column(key: 'filesize', searchable: true, sortable: true, label: 'FILESIZE (MB)', hidden: true)
            ->column(key: 'filetype', searchable: true, sortable: true)
            ->column(label: 'Predicted', key: 'filetype_prediction', searchable: true, sortable: true)
            ->column(key: 'created_at', searchable: true, sortable: true, as: fn ($created_at) => $created_at->diffForHumans())
            ->column(key: 'updated_at', searchable: true, sortable: true, as: fn ($updated_at) => $updated_at->diffForHumans())
            ->column(label: 'Actions', exportAs: false, alignment: 'center', hidden: true)
            ->column(label: 'Download', exportAs: false, hidden: false)
            ->bulkAction(
                label: 'Delete assets',
                each: fn ($assets) => $assets->delete(),
                before: fn () => info('Deleting assets'),
                after: fn () => Toast::info('Assets sent to the recycle center!'),
                confirm: true
            )
            ->bulkAction(
                label: 'Download assets',
                each: function ($assets) {
                    $assets = Asset::pluck('upload');
                    $zipFile = 'files.zip';

                    $zip = new ZipArchive();
                    if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
                        throw new Exception("Cannot open $zipFile");
                    }

                    foreach ($assets as $file) {
                        $filePath = storage_path("app/$file");
                        $zip->addFile($filePath, basename($file));
                    }

                    $zip->close();
                    return response()->download($zipFile)->deleteFileAfterSend(true);
                },
                before: fn () => info('Preparing assets for download'),
                after: fn () => Toast::info('Assets downloaded successfully!'),
                confirm: true
            )

            ->withGlobalSearch(columns: ['name'])
            ->export()
            ->hidePaginationWhenResourceContainsOnePage();
    }
}
