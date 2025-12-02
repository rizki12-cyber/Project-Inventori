<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class LogUserLogin
{
    public function handle(Login $event)
    {
        logAktivitas("Login ke sistem");
    }
}
