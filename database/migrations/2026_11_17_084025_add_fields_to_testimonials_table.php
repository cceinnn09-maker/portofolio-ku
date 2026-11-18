<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom detail testimoni (idempoten).
     */
    public function up(): void
    {
        $columns = [
            'nama' => fn (Blueprint $table) => $table->string('nama')->nullable(),
            'profesi' => fn (Blueprint $table) => $table->string('profesi')->nullable(),
            'pesan' => fn (Blueprint $table) => $table->text('pesan')->nullable(),
        ];

        Schema::table('testimonials', function (Blueprint $table) use ($columns) {
            foreach ($columns as $name => $definition) {
                if (! Schema::hasColumn('testimonials', $name)) {
                    $definition($table);
                }
            }
        });
    }

    public function down(): void
    {
        $existing = array_values(array_filter(
            ['nama', 'profesi', 'pesan'],
            fn (string $column) => Schema::hasColumn('testimonials', $column)
        ));

        if ($existing === []) {
            return;
        }

        Schema::table('testimonials', function (Blueprint $table) use ($existing) {
            $table->dropColumn($existing);
        });
    }
};
