<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->string('judul')->nullable();
            $table->string('posisi')->nullable();
            $table->string('institusi')->nullable();
            $table->string('periode')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->string('jenis')->default('organisasi');
            $table->unsignedInteger('urutan')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->dropColumn([
                'judul', 'posisi', 'institusi', 'periode',
                'deskripsi', 'gambar', 'jenis', 'urutan',
            ]);
        });
    }
};
