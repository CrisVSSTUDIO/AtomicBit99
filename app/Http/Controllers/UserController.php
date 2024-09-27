<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Tables\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            /*             'role_or_permission:manager|edit articles',
 */
            new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('Super Admin'), except: ['show']),
            /*             new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete records,api'), only: ['destroy']), 
 */
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index', [
            'users' => Users::class,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create', [
            'roles' => Role::pluck('name')->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        $user = User::create($input);
        $user->assignRole($request->roles);

        return redirect()->route('users.index')
            ->withSuccess('New user is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')) {
            if ($user->id != Auth::id()) {
                abort(403, 'You dont have the required permissions!');
            }
        }
        return view('users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all(),
            'availableClasses' => Auth::user()->classroom
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $input = $request->all();

        if (!empty($request->password)) {
            $input['password'] = Hash::make($request->password);
        } else {
            $input = $request->except('password');
        }
        $user->syncRoles($request->roles);

        $user->classroom()->sync($request->availableClasses);
        return redirect()->route('users.index')
            ->withSuccess('User is updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('Super Admin') || $user->id == Auth::id()) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->delete();
        return redirect()->route('users.index')
            ->withSuccess('User is deleted successfully.');
    }
}
