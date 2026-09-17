<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// Vercel's filesystem is read-only except /tmp. Redirect Laravel's writable
// storage there so view caching, logs, etc. don't fail on cold starts.
if (env('VERCEL')) {
    $app->useStoragePath('/tmp/storage');

    foreach (['framework/cache/data', 'framework/sessions', 'framework/views', 'framework/testing', 'logs', 'app/public'] as $dir) {
        $path = '/tmp/storage/'.$dir;
        if (! is_dir($path)) {
            @mkdir($path, 0775, true);
        }
    }
}

return $app;
