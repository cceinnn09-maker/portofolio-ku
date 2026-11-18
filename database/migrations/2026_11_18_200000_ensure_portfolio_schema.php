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
            // Tabel dasar dulu, supaya aman kalau ada tabel yang belum ada.
            '2026_05_12_144014_create_projects_table',
            '2026_11_16_035500_create_profiles_table',
            '2026_11_16_035512_create_skills_table',
            '2026_11_16_035748_create_certificates_table',
            '2026_11_16_035804_create_experiences_table',
            '2026_11_16_035832_create_testimonials_table',
            '2026_11_16_035846_create_posts_table',
            '2026_11_16_045900_create_messages_table',

            // Kolom & tabel tambahan.
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
            '2026_11_18_210000_add_foto_to_testimonials_table',
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
