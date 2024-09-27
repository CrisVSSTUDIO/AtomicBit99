<?php

namespace App\Http\Controllers;

use App\Tables\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class RoleController extends Controller implements HasMiddleware
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
        return view('roles.index', [
            'roles' => Roles::class
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create', [
            'permissions' => Permission::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
            ->withSuccess('New role is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $rolePermissions = Permission::join("role_has_permissions", "permission_id", "=", "id")
            ->where("role_id", $role->id)
            ->select('name')
            ->get();
        return view('roles.show', [
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        if ($role->name == 'Super Admin') {
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE EDITED');
        }

        $rolePermissions = DB::table("role_has_permissions")->where("role_id", $role->id)
            ->pluck('permission_id')
            ->all();

        return view('roles.edit', [
            'role' => $role,
            'permissions' => Permission::get(),
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $input = $request->only('name');

        $role->update($input);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
            ->withSuccess('Role is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->name == 'Super Admin') {
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
        }
        if (Auth::user()->hasRole($role->name)) {
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }
        $role->delete();
        return redirect()->route('roles.index')
            ->withSuccess('Role is deleted successfully.');
    }
}
