<?php

namespace App\Tables;

use App\Models\Asset;
use App\Models\SharedAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ProtoneMedia\Splade\SpladeTable;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;

class SharedAssets extends AbstractTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        $sharedAssets = Asset::with('users')->whereHas('users', function ($q) {
            $q->select('name', 'email')->where('user_id', Auth::user()->id);
        });
        return $sharedAssets;
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
            ->column(key: 'description', searchable: true, sortable: true)
            ->column(key: 'slug', searchable: true, sortable: true, hidden: true,)
            ->column(key: 'filesize', searchable: true, sortable: true, label: 'FILESIZE (MB)', hidden: true)
            ->column(key: 'filetype', searchable: true, sortable: true)
            ->column(label:'Predicted', key: 'filetype_prediction', searchable: true, sortable: true)
            ->column(key: 'created_at', searchable: true, sortable: true, as: fn ($created_at, $sharedAssets) => $created_at->diffForHumans())
            ->column(key: 'updated_at', searchable: true, sortable: true, as: fn ($updated_at, $sharedAssets) => $updated_at->diffForHumans())
            // ->column(label: 'Actions', exportAs: false, alignment: 'left', hidden: true)
            ->column(label: 'Download', exportAs: false, hidden: true)
            // ->bulkAction(
            //     label: 'Delete assets',
            //     each: fn ($assets) => $assets->delete(),
            //     before: fn () => info('Deleting assets'),
            //     after: fn () => Toast::info('Assets sent to the recycle center!'),
            //     confirm: true
            // )
            ->withGlobalSearch(columns: ['name'])
            ->paginate(8)
            ->export()
            ->hidePaginationWhenResourceContainsOnePage();
    }
}
