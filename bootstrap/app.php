<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Platform seperti Railway meng-terminasi TLS di proxy, sehingga PHP
        // melihat HTTP biasa. Tanpa trusted proxy, X-Forwarded-Proto diabaikan
        // dan cookie session/CSRF bisa hilang -> 419.
        //
        // Percayakan semua proxy ('*'). Di Laravel, '*' berarti mempercayai
        // IP pemanggil langsung (proxy PaaS seperti Railway).
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO,
        );

        // Validasi CSRF tetap aktif untuk semua route grup "web".
        // Jangan menambahkan route ke validateCsrfTokens(except: ...)
        // kecuali benar-benar diperlukan (misal webhook).
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();