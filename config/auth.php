<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Menentukan guard dan password reset default untuk aplikasi.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Setiap guard memiliki driver dan provider masing-masing.
    | Kita menambahkan guard khusus untuk admin dan petugas.
    |
    */

    'guards' => [
        // Guard default (tidak dipakai langsung)
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // 🔹 Guard untuk Admin
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        // 🔹 Guard untuk Petugas
        'petugas' => [
            'driver' => 'session',
            'provider' => 'petugas',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Provider menentukan bagaimana user diambil dari database.
    | Kita pakai model yang sama (User) tapi provider berbeda.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'petugas' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset
    |--------------------------------------------------------------------------
    |
    | Pengaturan token reset password.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Jumlah detik sebelum konfirmasi password kadaluarsa.
    | Default: 3 jam (10800 detik)
    |
    */

    'password_timeout' => 10800,

];
