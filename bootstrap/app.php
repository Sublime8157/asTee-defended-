<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
        ]);

        // Authenticated visitors hitting a guest-only page land here. Preserves
        // the behaviour of the old RouteServiceProvider::HOME constant.
        $middleware->redirectUsersTo('/home');

        // The storefront login lives at '/', not at a route named 'login'.
        // Auth::routes() used to register that name; it no longer does.
        $middleware->redirectGuestsTo('/');

        $middleware->alias([
            'admin' => \App\Http\Middleware\admin::class,
        ]);

        $middleware->throttleApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
