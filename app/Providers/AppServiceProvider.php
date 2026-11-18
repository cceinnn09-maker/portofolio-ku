<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Output\BufferedOutput;

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

        // Jalankan setelah logging diarahkan ke stderr agar error migrasi
        // otomatis langsung terlihat di Deploy Logs.
        $this->ensurePortfolioSchemaIsReady();

        // Saat APP_URL memakai HTTPS, paksa URL yang di-generate juga HTTPS.
        // Ini mencegah redirect/asset/cookie yang salah skema di balik proxy TLS.
        // Lewati saat environment "local" agar `php artisan serve` tetap memakai HTTP.
        if (! app()->environment('local') && str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Pastikan tabel/kolom baru benar-benar ada saat aplikasi pertama kali
     * melayani request.
     *
     * Ini pengaman kalau start command Railway tidak menjalankan
     * `php artisan migrate` (mis. start command di dashboard menimpa
     * Dockerfile). Migrasi `2026_11_18_200000_ensure_portfolio_schema`
     * akan memperbaiki kolom yang hilang, dan hasilnya ditandai dengan file
     * sentinel agar pengecekan tidak dijalankan di setiap request.
     */
    protected function ensurePortfolioSchemaIsReady(): void
    {
        if (app()->runningInConsole()) {
            return;
        }

        $sentinel = storage_path('framework/portfolio-schema-ok');

        if (is_file($sentinel)) {
            return;
        }

        // Lock sederhana agar beberapa request yang datang bersamaan tidak
        // menjalankan migrasi secara paralel.
        $lock = storage_path('framework/portfolio-schema.lock');

        if (! @mkdir($lock, 0777, true) && ! is_dir($lock)) {
            return;
        }

        try {
            // Selalu jalankan migrate pada request pertama container.
            // Jika start command Railway tidak menjalankan migrasi, langkah ini
            // yang menyelamatkan; jika sudah dijalankan, migrate hanya
            // melaporkan "Nothing to migrate" (cepat).
            Log::info('Memastikan migrasi database sudah dijalankan...');

            $output = new BufferedOutput();
            $exitCode = Artisan::call('migrate', ['--force' => true], $output);

            if ($exitCode !== 0) {
                Log::error("Migrasi otomatis gagal (exit {$exitCode}):\n".$output->fetch());
            }

            if ($this->portfolioSchemaIsReady()) {
                @file_put_contents($sentinel, now()->toDateTimeString());
            }
        } catch (\Throwable $e) {
            Log::error('Gagal memeriksa/menjalankan migrasi otomatis: '.$e->getMessage());
        } finally {
            @rmdir($lock);
        }
    }

    /**
     * Cek cepat beberapa tabel/kolom inti yang dipakai halaman utama.
     */
    protected function portfolioSchemaIsReady(): bool
    {
        try {
            return Schema::hasTable('educations')
                && Schema::hasTable('settings')
                && Schema::hasColumn('profiles', 'kelas')
                && Schema::hasColumn('skills', 'kategori')
                && Schema::hasColumn('skills', 'urutan')
                && Schema::hasColumn('experiences', 'jenis')
                && Schema::hasColumn('posts', 'konten')
                && Schema::hasColumn('testimonials', 'is_visible')
                && Schema::hasColumn('certificates', 'jenis');
        } catch (\Throwable $e) {
            return false;
        }
    }
}
