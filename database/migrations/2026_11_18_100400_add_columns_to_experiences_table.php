<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom tambahan untuk tabel experiences (idempoten).
     */
    public function up(): void
    {
        $columns = [
            'judul' => fn (Blueprint $table) => $table->string('judul')->nullable(),
            'posisi' => fn (Blueprint $table) => $table->string('posisi')->nullable(),
            'institusi' => fn (Blueprint $table) => $table->string('institusi')->nullable(),
            'periode' => fn (Blueprint $table) => $table->string('periode')->nullable(),
            'deskripsi' => fn (Blueprint $table) => $table->text('deskripsi')->nullable(),
            'gambar' => fn (Blueprint $table) => $table->string('gambar')->nullable(),
            'jenis' => fn (Blueprint $table) => $table->string('jenis')->default('organisasi'),
            'urutan' => fn (Blueprint $table) => $table->unsignedInteger('urutan')->default(0),
        ];

        Schema::table('experiences', function (Blueprint $table) use ($columns) {
            foreach ($columns as $name => $definition) {
                if (! Schema::hasColumn('experiences', $name)) {
                    $definition($table);
                }
            }
        });
    }

    public function down(): void
    {
        $existing = array_values(array_filter(
            ['judul', 'posisi', 'institusi', 'periode', 'deskripsi', 'gambar', 'jenis', 'urutan'],
            fn (string $column) => Schema::hasColumn('experiences', $column)
        ));

        if ($existing === []) {
            return;
        }

        Schema::table('experiences', function (Blueprint $table) use ($existing) {
            $table->dropColumn($existing);
        });
    }
};
