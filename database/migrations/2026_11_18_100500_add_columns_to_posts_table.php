<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom tambahan untuk tabel posts (idempoten).
     */
    public function up(): void
    {
        $columns = [
            'judul' => fn (Blueprint $table) => $table->string('judul')->nullable(),
            'slug' => fn (Blueprint $table) => $table->string('slug')->nullable()->unique(),
            'kategori' => fn (Blueprint $table) => $table->string('kategori')->nullable(),
            'ringkasan' => fn (Blueprint $table) => $table->text('ringkasan')->nullable(),
            'konten' => fn (Blueprint $table) => $table->longText('konten')->nullable(),
            'gambar' => fn (Blueprint $table) => $table->string('gambar')->nullable(),
            'penulis' => fn (Blueprint $table) => $table->string('penulis')->nullable(),
            'tanggal' => fn (Blueprint $table) => $table->date('tanggal')->nullable(),
            'published' => fn (Blueprint $table) => $table->boolean('published')->default(true),
        ];

        Schema::table('posts', function (Blueprint $table) use ($columns) {
            foreach ($columns as $name => $definition) {
                if (! Schema::hasColumn('posts', $name)) {
                    $definition($table);
                }
            }
        });
    }

    public function down(): void
    {
        $existing = array_values(array_filter(
            ['judul', 'slug', 'kategori', 'ringkasan', 'konten', 'gambar', 'penulis', 'tanggal', 'published'],
            fn (string $column) => Schema::hasColumn('posts', $column)
        ));

        if ($existing === []) {
            return;
        }

        Schema::table('posts', function (Blueprint $table) use ($existing) {
            $table->dropColumn($existing);
        });
    }
};
