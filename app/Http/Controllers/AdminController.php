<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class AdminController extends Controller implements HasMiddleware
{
    //
    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            /*             'role_or_permission:manager|edit articles',
 */
                 new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('Super Admin'), except: ['show']),
/*             new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete records,api'), only: ['destroy']), 
 */        ];
    }
    public function index()
    {
        return view('layouts.admin');
    }
}
