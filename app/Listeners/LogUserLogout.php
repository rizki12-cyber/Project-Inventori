<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class LogUserLogout
{
    public function handle(Logout $event)
    {
        logAktivitas("Logout dari sistem");
    }
}
