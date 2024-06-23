<?php

namespace App\Tables;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ProtoneMedia\Splade\SpladeTable;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;

class Trashed extends AbstractTable
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
        $trashed = Asset::where('user_id', Auth::user()->id)->onlyTrashed();

        return $trashed;
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
            /*     ->rowLink(function (Asset $asset) {

                return route('assets.show', $asset);
            }) */
            ->column(key: 'name', searchable: true, sortable: true)
            ->column(key: 'description', searchable: true, sortable: true)
            ->column(key: 'slug', searchable: true, sortable: true)
            ->column(key: 'filesize', searchable: true, sortable: true, label: 'FILESIZE (MB)')
            ->column(key: 'filetype', searchable: true, sortable: true)
            ->column(key: 'created_at', searchable: true, sortable: true, as: fn ($created_at, $assets) => $created_at->diffForHumans())
            ->column(key: 'deleted_at', searchable: true, sortable: true, as: fn ($deleted_at, $assets) => $deleted_at->diffForHumans())
            ->column(label: 'Actions', exportAs: false,  alignment: 'left')
            ->bulkAction(
                label: 'Delete assets',
                each: fn ($trashed) => $trashed->forceDelete(),
                before: fn () => info('Deleting assets'),
                after: fn () => Toast::info('Assets yeeted!'),
                confirm: 'Permanently delete',
                confirmText: 'Are you sure you want to permanently delete all assets?',
                confirmButton: 'Yes, delete all!',
                cancelButton: 'No, do not delete!',
                requirePassword: true

            )
            ->bulkAction(
                label: 'Restore Assets',
                each: fn ($trashed) => $trashed->restore(),
                before: fn () => info('Restoring assets'),
                after: fn () => Toast::info('Assets restored!'),
                confirm: 'Restore',
                confirmText: 'Are you sure you want to restore all assets?',
                confirmButton: 'Yes, restore all!',
                cancelButton: 'No, do not restore!',
                requirePassword: true
            )
            ->withGlobalSearch(columns: ['name'])
            ->paginate(8)
            ->export();
    }
}
