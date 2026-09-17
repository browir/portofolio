<?php
/**
 * Serverless function entry for Vercel (vercel-php runtime).
 * Delegates straight to Laravel's normal public entrypoint.
 */

// TEMPORARY diagnostic net: if something fatals before Laravel's own
// exception handler is wired up, print it instead of a blank 500.
// Safe to leave briefly since this app has no secrets in its content.
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        if (! headers_sent()) {
            http_response_code(500);
            header('Content-Type: text/plain');
        }
        echo "FATAL: {$error['message']}\nFILE: {$error['file']}\nLINE: {$error['line']}\n";
    }
});

try {
    require __DIR__.'/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain');
    echo "CAUGHT: ".get_class($e).": {$e->getMessage()}\n";
    echo "FILE: {$e->getFile()}:{$e->getLine()}\n";
    echo $e->getTraceAsString();
}
