<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom tambahan untuk tabel skills (idempoten).
     */
    public function up(): void
    {
        $columns = [
            'nama' => fn (Blueprint $table) => $table->string('nama')->nullable(),
            'persentase' => fn (Blueprint $table) => $table->unsignedTinyInteger('persentase')->default(0),
            'kategori' => fn (Blueprint $table) => $table->string('kategori')->default('hard'),
            'urutan' => fn (Blueprint $table) => $table->unsignedInteger('urutan')->default(0),
        ];

        Schema::table('skills', function (Blueprint $table) use ($columns) {
            foreach ($columns as $name => $definition) {
                if (! Schema::hasColumn('skills', $name)) {
                    $definition($table);
                }
            }
        });
    }

    public function down(): void
    {
        $existing = array_values(array_filter(
            ['nama', 'persentase', 'kategori', 'urutan'],
            fn (string $column) => Schema::hasColumn('skills', $column)
        ));

        if ($existing === []) {
            return;
        }

        Schema::table('skills', function (Blueprint $table) use ($existing) {
            $table->dropColumn($existing);
        });
    }
};
