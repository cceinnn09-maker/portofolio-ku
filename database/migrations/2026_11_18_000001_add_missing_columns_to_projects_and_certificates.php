<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom-kolom yang dibutuhkan aplikasi
     * namun belum ada di tabel projects & certificates.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('judul')->nullable()->after('id');
            $table->string('kategori')->nullable()->after('nama_project');
            $table->text('permasalahan')->nullable()->after('deskripsi');
            $table->text('tujuan')->nullable()->after('permasalahan');
            $table->string('teknologi')->nullable()->after('tujuan');
            $table->string('peran')->nullable()->after('teknologi');
            $table->text('fitur_fitur')->nullable()->after('peran');
            $table->string('link_demo')->nullable()->after('fitur_fitur');
            $table->string('link_github')->nullable()->after('link_demo');
            $table->text('dokumentasi')->nullable()->after('link_github');
            $table->text('feedback_user')->nullable()->after('dokumentasi');

            // Kolom lama dibuat nullable agar fleksibel
            $table->string('nama_project')->nullable()->change();
            $table->string('gambar')->nullable()->change();
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->string('nama_sertifikat')->nullable()->after('id');
            $table->string('pemberi')->nullable()->after('nama_sertifikat');
            $table->string('tahun')->nullable()->after('pemberi');
            $table->string('gambar')->nullable()->after('tahun');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'judul', 'kategori', 'permasalahan', 'tujuan', 'teknologi', 'peran',
                'fitur_fitur', 'link_demo', 'link_github', 'dokumentasi', 'feedback_user',
            ]);
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn(['nama_sertifikat', 'pemberi', 'tahun', 'gambar']);
        });
    }
};
