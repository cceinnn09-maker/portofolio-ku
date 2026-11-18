<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom konten untuk tabel profiles.
     *
     * Dibuat idempoten (hanya menambah kolom yang belum ada) supaya
     * database yang sudah termigrasi sebagian (mis. di Railway) tetap
     * bisa menyelesaikan migrasi tanpa error "Duplicate column name".
     */
    public function up(): void
    {
        $columns = [
            'nama_lengkap' => fn (Blueprint $table) => $table->string('nama_lengkap')->nullable(),
            'kelas' => fn (Blueprint $table) => $table->string('kelas')->nullable(),
            'kompetensi_keahlian' => fn (Blueprint $table) => $table->string('kompetensi_keahlian')->nullable(),
            'deskripsi_singkat' => fn (Blueprint $table) => $table->text('deskripsi_singkat')->nullable(),
            'foto' => fn (Blueprint $table) => $table->string('foto')->nullable(),
            'email' => fn (Blueprint $table) => $table->string('email')->nullable(),
            'github' => fn (Blueprint $table) => $table->string('github')->nullable(),
            'instagram' => fn (Blueprint $table) => $table->string('instagram')->nullable(),
            'linkedin' => fn (Blueprint $table) => $table->string('linkedin')->nullable(),
            'tiktok' => fn (Blueprint $table) => $table->string('tiktok')->nullable(),
            'alamat' => fn (Blueprint $table) => $table->string('alamat')->nullable(),
            'tempat_lahir' => fn (Blueprint $table) => $table->string('tempat_lahir')->nullable(),
            'tanggal_lahir' => fn (Blueprint $table) => $table->date('tanggal_lahir')->nullable(),
            'about_text' => fn (Blueprint $table) => $table->text('about_text')->nullable(),
            'minat_teknologi' => fn (Blueprint $table) => $table->text('minat_teknologi')->nullable(),
            'keahlian_utama' => fn (Blueprint $table) => $table->text('keahlian_utama')->nullable(),
            'cita_cita' => fn (Blueprint $table) => $table->text('cita_cita')->nullable(),
        ];

        Schema::table('profiles', function (Blueprint $table) use ($columns) {
            foreach ($columns as $name => $definition) {
                if (! Schema::hasColumn('profiles', $name)) {
                    $definition($table);
                }
            }
        });
    }

    public function down(): void
    {
        $columns = [
            'nama_lengkap', 'kelas', 'kompetensi_keahlian', 'deskripsi_singkat',
            'foto', 'email', 'github', 'instagram', 'linkedin', 'tiktok',
            'alamat', 'tempat_lahir', 'tanggal_lahir', 'about_text',
            'minat_teknologi', 'keahlian_utama', 'cita_cita',
        ];

        $existing = array_values(array_filter(
            $columns,
            fn (string $column) => Schema::hasColumn('profiles', $column)
        ));

        if ($existing === []) {
            return;
        }

        Schema::table('profiles', function (Blueprint $table) use ($existing) {
            $table->dropColumn($existing);
        });
    }
};
