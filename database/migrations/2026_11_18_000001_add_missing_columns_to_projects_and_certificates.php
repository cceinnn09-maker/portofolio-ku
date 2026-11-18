<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom-kolom yang dibutuhkan aplikasi
     * namun belum ada di tabel projects & certificates.
     *
     * Dibuat idempoten supaya aman dijalankan pada database yang
     * sudah termigrasi sebagian.
     */
    public function up(): void
    {
        $projectColumns = [
            'judul' => fn (Blueprint $table) => $table->string('judul')->nullable(),
            'kategori' => fn (Blueprint $table) => $table->string('kategori')->nullable(),
            'permasalahan' => fn (Blueprint $table) => $table->text('permasalahan')->nullable(),
            'tujuan' => fn (Blueprint $table) => $table->text('tujuan')->nullable(),
            'teknologi' => fn (Blueprint $table) => $table->string('teknologi')->nullable(),
            'peran' => fn (Blueprint $table) => $table->string('peran')->nullable(),
            'fitur_fitur' => fn (Blueprint $table) => $table->text('fitur_fitur')->nullable(),
            'link_demo' => fn (Blueprint $table) => $table->string('link_demo')->nullable(),
            'link_github' => fn (Blueprint $table) => $table->string('link_github')->nullable(),
            'dokumentasi' => fn (Blueprint $table) => $table->text('dokumentasi')->nullable(),
            'feedback_user' => fn (Blueprint $table) => $table->text('feedback_user')->nullable(),
        ];

        Schema::table('projects', function (Blueprint $table) use ($projectColumns) {
            foreach ($projectColumns as $name => $definition) {
                if (! Schema::hasColumn('projects', $name)) {
                    $definition($table);
                }
            }
        });

        $certificateColumns = [
            'nama_sertifikat' => fn (Blueprint $table) => $table->string('nama_sertifikat')->nullable(),
            'pemberi' => fn (Blueprint $table) => $table->string('pemberi')->nullable(),
            'tahun' => fn (Blueprint $table) => $table->string('tahun')->nullable(),
            'gambar' => fn (Blueprint $table) => $table->string('gambar')->nullable(),
        ];

        Schema::table('certificates', function (Blueprint $table) use ($certificateColumns) {
            foreach ($certificateColumns as $name => $definition) {
                if (! Schema::hasColumn('certificates', $name)) {
                    $definition($table);
                }
            }
        });

        // Kolom lama dibuat nullable agar fleksibel (aman diulang).
        Schema::table('projects', function (Blueprint $table) {
            $table->string('nama_project')->nullable()->change();
            $table->string('gambar')->nullable()->change();
        });
    }

    public function down(): void
    {
        $projectColumns = array_values(array_filter(
            [
                'judul', 'kategori', 'permasalahan', 'tujuan', 'teknologi', 'peran',
                'fitur_fitur', 'link_demo', 'link_github', 'dokumentasi', 'feedback_user',
            ],
            fn (string $column) => Schema::hasColumn('projects', $column)
        ));

        if ($projectColumns !== []) {
            Schema::table('projects', function (Blueprint $table) use ($projectColumns) {
                $table->dropColumn($projectColumns);
            });
        }

        $certificateColumns = array_values(array_filter(
            ['nama_sertifikat', 'pemberi', 'tahun', 'gambar'],
            fn (string $column) => Schema::hasColumn('certificates', $column)
        ));

        if ($certificateColumns !== []) {
            Schema::table('certificates', function (Blueprint $table) use ($certificateColumns) {
                $table->dropColumn($certificateColumns);
            });
        }
    }
};
