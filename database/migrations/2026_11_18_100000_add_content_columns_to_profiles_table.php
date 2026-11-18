<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('nama_lengkap')->nullable();
            $table->string('kelas')->nullable();
            $table->string('kompetensi_keahlian')->nullable();
            $table->text('deskripsi_singkat')->nullable();
            $table->string('foto')->nullable();
            $table->string('email')->nullable();
            $table->string('github')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('alamat')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('about_text')->nullable();
            $table->text('minat_teknologi')->nullable();
            $table->text('keahlian_utama')->nullable();
            $table->text('cita_cita')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'nama_lengkap', 'kelas', 'kompetensi_keahlian', 'deskripsi_singkat',
                'foto', 'email', 'github', 'instagram', 'linkedin', 'tiktok',
                'alamat', 'tempat_lahir', 'tanggal_lahir', 'about_text',
                'minat_teknologi', 'keahlian_utama', 'cita_cita',
            ]);
        });
    }
};
