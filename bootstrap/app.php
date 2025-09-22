<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'check.login' => \App\Http\Middleware\CheckLogin::class,
            'check.guest' => \App\Http\Middleware\CheckGuest::class,
            'auto.update.status' => \App\Http\Middleware\AutoUpdatePeminjamanStatus::class,
            'prevent.back' => \App\Http\Middleware\PreventBackHistory::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
