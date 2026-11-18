<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Railway (dan PaaS serupa) menyediakan variabel RAILWAY_*.
        // Paksa log ke stderr supaya pesan error lengkap muncul di Deploy Logs,
        // meskipun LOG_CHANNEL/LOG_STACK di dashboard diisi nilai lain.
        $onRailway = env('RAILWAY_ENVIRONMENT')
            || env('RAILWAY_ENVIRONMENT_NAME')
            || env('RAILWAY_PROJECT_ID')
            || env('RAILWAY_SERVICE_ID')
            || env('RAILWAY_PUBLIC_DOMAIN');

        if ($onRailway) {
            config([
                'logging.default' => 'stderr',
                'logging.channels.stack.channels' => ['stderr'],
            ]);
        }

        // Saat APP_URL memakai HTTPS, paksa URL yang di-generate juga HTTPS.
        // Ini mencegah redirect/asset/cookie yang salah skema di balik proxy TLS.
        // Lewati saat environment "local" agar `php artisan serve` tetap memakai HTTP.
        if (! app()->environment('local') && str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
