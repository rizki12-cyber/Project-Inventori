<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Guard dan password reset broker default untuk aplikasi.
    | Sekarang hanya pakai satu guard utama: "web".
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
    | Kita hanya butuh satu guard saja (web) untuk semua role:
    | admin, wakasek, dan kabeng.
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Jika nanti kamu ingin menambah API login (opsional)
        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Provider menentukan bagaimana user diambil dari database atau model.
    | Di sini kita hanya pakai satu model: App\Models\User
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // Jika ingin pakai query builder manual:
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset Configuration
    |--------------------------------------------------------------------------
    |
    | Pengaturan token reset password untuk user.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60, // dalam menit
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Waktu sebelum konfirmasi password kadaluarsa (dalam detik).
    | Default: 3 jam (10800 detik).
    |
    */

    'password_timeout' => 10800,

];
