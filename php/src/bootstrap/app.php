<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // web: __DIR__.'/../routes/web.php',
        // commands: __DIR__.'/../routes/console.php',
        // health: '/up',
        //@Todo delete comment APIルーティングを有効:php artisan install:api
        commands: __DIR__.'/../routes/console.php',
        using: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
    
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->redirectUsersTo('/auth');
 
        // Using a closure...
        $middleware->redirectUsersTo(fn (Request $request) => route('login'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
