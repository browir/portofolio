<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::post('/contact', [PortfolioController::class, 'sendMessage'])->name('portfolio.contact');

Route::post('/comments', [CommentController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('comments.store');

// TEMPORARY: diagnosing a CSRF/session cookie mismatch on Vercel. Remove
// once resolved.
Route::get('/__debug-session', function () {
    return response()->json([
        'app_name_env' => env('APP_NAME'),
        'app_name_config' => config('app.name'),
        'session_driver' => config('session.driver'),
        'session_cookie_name' => config('session.cookie'),
        'session_encrypt' => config('session.encrypt'),
        'session_expire_on_close' => config('session.expire_on_close'),
        'session_lifetime' => config('session.lifetime'),
        'session_same_site' => config('session.same_site'),
        'session_secure' => config('session.secure'),
        'session_domain' => config('session.domain'),
        'session_partitioned' => config('session.partitioned'),
        'app_key_set' => ! empty(env('APP_KEY')),
        'app_key_length' => strlen((string) env('APP_KEY')),
        'request_secure' => request()->isSecure(),
        'request_host' => request()->getHost(),
        'trusted_proxies' => request()->getTrustedProxies(),
        'config_cached' => app()->configurationIsCached(),
        'config_cache_path' => app()->getCachedConfigPath(),
    ]);
});
