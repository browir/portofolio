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

// Vercel's filesystem is read-only except /tmp. We detect this by attempting
// a real write instead of trusting is_writable() (permission bits can say
// "writable" even on a read-only Lambda-style mount) or a custom env var
// (vercel.json's top-level "env" block isn't reliably applied to community
// runtimes, and dashboard-configured vars can silently miss one or two).
$probeFile = dirname(__DIR__).'/storage/framework/.write_probe';
$canWrite = @file_put_contents($probeFile, '1') !== false;
if ($canWrite) {
    @unlink($probeFile);
}

if (! $canWrite) {
    $app->useStoragePath('/tmp/storage');

    foreach (['framework/cache/data', 'framework/sessions', 'framework/views', 'framework/testing', 'logs', 'app/public'] as $dir) {
        $path = '/tmp/storage/'.$dir;
        if (! is_dir($path)) {
            @mkdir($path, 0775, true);
        }
    }

    // Force stateless-safe config in code (not just .env) so a missing
    // platform env var can't silently fall back to "database" session/cache
    // drivers, which would crash since there's no writable DB here.
    foreach ([
        'SESSION_DRIVER' => 'cookie',
        'CACHE_STORE' => 'array',
        'QUEUE_CONNECTION' => 'sync',
        'LOG_CHANNEL' => 'stderr',
    ] as $key => $value) {
        if (getenv($key) === false) {
            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}

return $app;
