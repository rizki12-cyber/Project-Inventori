<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// ✅ Import middleware kamu
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ✅ Daftarkan alias middleware custom
        $middleware->alias([
            'role' => RoleMiddleware::class, // Middleware untuk cek role (admin/petugas)
        ]);

        // ✅ (Opsional) Jika kamu ingin RoleMiddleware aktif global:
        // $middleware->web(append: [
        //     RoleMiddleware::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
