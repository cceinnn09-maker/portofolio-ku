<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pembaruan konten:
     * 1. Hard Skills disederhanakan menjadi 3 item (UI/UX Wireframe & Design,
     *    HTML, CSS) beserta persentasenya.
     * 2. Pengalaman "Lomba Kompetensi Desain Aplikasi" diganti menjadi
     *    "Lomba Fashion Show Hari Kartini". Kolom `gambar` sengaja tidak
     *    disentuh agar foto yang sudah diunggah tetap tampil.
     *
     * Idempoten: aman dijalankan berulang.
     */
    public function up(): void
    {
        $this->updateHardSkills();
        $this->updateFashionShowExperience();
    }

    public function down(): void
    {
        // Perubahan konten tidak dikembalikan otomatis.
    }

    private function updateHardSkills(): void
    {
        if (! Schema::hasTable('skills') || ! Schema::hasColumn('skills', 'nama')) {
            return;
        }

        $hardSkills = [
            ['nama' => 'UI/UX Wireframe & Design', 'persentase' => 85, 'urutan' => 1],
            ['nama' => 'HTML', 'persentase' => 80, 'urutan' => 2],
            ['nama' => 'CSS', 'persentase' => 80, 'urutan' => 3],
        ];

        $names = array_column($hardSkills, 'nama');

        // Hapus hard skill lama yang tidak lagi dipakai.
        DB::table('skills')
            ->where('kategori', 'hard')
            ->whereNotIn('nama', $names)
            ->delete();

        foreach ($hardSkills as $skill) {
            $existing = DB::table('skills')
                ->where('kategori', 'hard')
                ->where('nama', $skill['nama'])
                ->first();

            if ($existing) {
                DB::table('skills')->where('id', $existing->id)->update([
                    'persentase' => $skill['persentase'],
                    'urutan' => $skill['urutan'],
                    'updated_at' => now(),
                ]);

                continue;
            }

            DB::table('skills')->insert($skill + [
                'kategori' => 'hard',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function updateFashionShowExperience(): void
    {
        if (! Schema::hasTable('experiences') || ! Schema::hasColumn('experiences', 'judul')) {
            return;
        }

        DB::table('experiences')
            ->where('judul', 'Lomba Kompetensi Desain Aplikasi')
            ->update([
                'judul' => 'Lomba Fashion Show Hari Kartini',
                'deskripsi' => 'Mengikuti Lomba Fashion Show dalam rangka memperingati Hari Kartini, menampilkan kreativitas dalam memadukan busana dan gaya, serta melatih rasa percaya diri tampil di depan juri dan penonton.',
                'updated_at' => now(),
            ]);
    }
};
