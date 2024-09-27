<?php

namespace App\Tables;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ProtoneMedia\Splade\SpladeTable;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;

class Users extends AbstractTable
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
        $users = User::with('roles');
        return $users;
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
            ->rowLink(function (User $user) {
                return route('users.show', $user);
            })
            ->column(key: 'name', searchable: true, sortable: true)
            ->column(key: 'email', searchable: true, sortable: true)
            ->bulkAction(
                label: 'Delete users',
                each: fn($users) => $users->delete(),
                before: fn() => info('Deleting users'),
                after: fn() => Toast::info('users sent to the recycle center!'),
                confirm: true
            )
            ->withGlobalSearch(columns: ['name'])
            ->export()
            ->hidePaginationWhenResourceContainsOnePage();
    }
}
