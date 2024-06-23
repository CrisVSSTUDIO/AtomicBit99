<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('splade', [
            \ProtoneMedia\Splade\Http\SpladeMiddleware::class,
        ]);
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'setlocale' => \App\Http\Middleware\SetLocale::class,

        ]);
        /*  $middleware->group('role', [
            \Spatie\Permission\Middleware\RoleMiddleware::class,
        ]);
        $middleware->group('permission', [
            \Spatie\Permission\Middleware\PermissionMiddleware::class,
        ]);
        $middleware->group('role_or_permission', [
            \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]); */
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(\ProtoneMedia\Splade\SpladeCore::exceptionHandler($exceptions->handler));
    })
    ->create();
