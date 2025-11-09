<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// ✅ Import middleware custom
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {
        /**
         * ------------------------------------------------------------
         * 🔹 REGISTER CUSTOM MIDDLEWARE
         * ------------------------------------------------------------
         * Middleware alias ini bisa langsung dipakai di route:
         * Route::middleware(['role:admin'])->group(...);
         */
        $middleware->alias([
            'role' => RoleMiddleware::class, // Middleware untuk cek role (admin/petugas/kabeng)
        ]);

        /**
         * ------------------------------------------------------------
         * 🔹 OPSIONAL: Tambahkan global middleware (jika dibutuhkan)
         * ------------------------------------------------------------
         * Contoh:
         * $middleware->web(append: [
         *     \App\Http\Middleware\VerifyCsrfToken::class,
         * ]);
         */
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        /**
         * ------------------------------------------------------------
         * 🔹 CUSTOM EXCEPTION HANDLER (opsional)
         * ------------------------------------------------------------
         * Di sini kamu bisa mengatur logging atau respon error kustom.
         * Misalnya:
         * $exceptions->render(function (Throwable $e, $request) {
         *     return response()->view('errors.custom', [], 500);
         * });
         */
    })

    ->create();
