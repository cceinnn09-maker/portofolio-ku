<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('judul')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('kategori')->nullable();
            $table->text('ringkasan')->nullable();
            $table->longText('konten')->nullable();
            $table->string('gambar')->nullable();
            $table->string('penulis')->nullable();
            $table->date('tanggal')->nullable();
            $table->boolean('published')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'judul', 'slug', 'kategori', 'ringkasan', 'konten',
                'gambar', 'penulis', 'tanggal', 'published',
            ]);
        });
    }
};
