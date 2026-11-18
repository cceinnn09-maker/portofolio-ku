<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom tambahan untuk tabel certificates (idempoten).
     */
    public function up(): void
    {
        $columns = [
            'jenis' => fn (Blueprint $table) => $table->string('jenis')->default('Sertifikat'),
            'deskripsi' => fn (Blueprint $table) => $table->text('deskripsi')->nullable(),
        ];

        Schema::table('certificates', function (Blueprint $table) use ($columns) {
            foreach ($columns as $name => $definition) {
                if (! Schema::hasColumn('certificates', $name)) {
                    $definition($table);
                }
            }
        });
    }

    public function down(): void
    {
        $existing = array_values(array_filter(
            ['jenis', 'deskripsi'],
            fn (string $column) => Schema::hasColumn('certificates', $column)
        ));

        if ($existing === []) {
            return;
        }

        Schema::table('certificates', function (Blueprint $table) use ($existing) {
            $table->dropColumn($existing);
        });
    }
};
