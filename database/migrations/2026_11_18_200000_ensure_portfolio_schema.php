<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Migrasi "penyelamat" untuk memastikan seluruh tabel & kolom baru
     * benar-benar ada.
     *
     * Kasus yang ditangani: tabel `migrations` sudah mencatat migrasi lama
     * sebagai "sudah jalan", tetapi kolomnya tidak ada (mis. deploy sebelumnya
     * gagal di tengah, atau database berasal dari import dump SQL). Karena
     * migrasi lama sudah idempoten, aman dijalankan ulang di sini.
     *
     * Seed konten juga idempoten dan tidak menimpa data yang sudah diedit admin.
     */
    public function up(): void
    {
        $migrations = [
            '2026_11_16_075438_add_file_cv_to_profiles_table',
            '2026_11_17_084025_add_fields_to_testimonials_table',
            '2026_11_18_000001_add_missing_columns_to_projects_and_certificates',
            '2026_11_18_100000_add_content_columns_to_profiles_table',
            '2026_11_18_100100_create_educations_table',
            '2026_11_18_100200_create_settings_table',
            '2026_11_18_100300_add_columns_to_skills_table',
            '2026_11_18_100400_add_columns_to_experiences_table',
            '2026_11_18_100500_add_columns_to_posts_table',
            '2026_11_18_100600_add_detail_to_projects_table',
            '2026_11_18_100700_add_columns_to_testimonials_table',
            '2026_11_18_100800_add_columns_to_certificates_table',
            '2026_11_18_100900_seed_default_portfolio_content',
        ];

        foreach ($migrations as $name) {
            $path = database_path("migrations/{$name}.php");

            if (! is_file($path)) {
                continue;
            }

            $migration = require $path;

            if (is_object($migration) && method_exists($migration, 'up')) {
                $migration->up();
            }
        }
    }

    public function down(): void
    {
        // Tidak menghapus apa pun: migrasi ini hanya memastikan schema lengkap.
    }
};
