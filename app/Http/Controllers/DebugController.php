<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;

class DebugController extends Controller
{
    public function toggle($status)
    {
        if (!in_array($status, ['on', 'off'])) {
            return "Gunakan /debug/on atau /debug/off";
        }

        $value = $status === 'on' ? 'true' : 'false';

        // update .env value
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            file_put_contents($envPath, preg_replace(
                "/^APP_DEBUG=.*/m",
                "APP_DEBUG={$value}",
                file_get_contents($envPath)
            ));
        }

        // refresh config
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:cache');

        return "APP_DEBUG berhasil diubah ke: {$value}";
    }
}
