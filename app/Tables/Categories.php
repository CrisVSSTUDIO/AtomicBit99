<?php

namespace App\Tables;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ProtoneMedia\Splade\SpladeTable;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;

class Categories extends AbstractTable
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
        return Category::where('user_id', '=', Auth::user()->id);
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
            ->withGlobalSearch(columns: ['id'])
            ->defaultSort('id')
            ->column(key: 'category_name', searchable: true, sortable: true)
            ->column(key: 'category_description', searchable: true, sortable: true)
            ->column(label: 'Actions')
            ->bulkAction(
                label: 'Delete categories',
                each: fn ($categories) => $categories->delete(),
                before: fn () => info('Deleting categories'),
                after: fn () => Toast::info('Categories deleted'),
                confirm: true

            )
            ->paginate(5);
        // ->searchInput()
        // ->selectFilter()
        // ->withGlobalSearch()

        // ->bulkAction()
        // ->export()
    }
}
