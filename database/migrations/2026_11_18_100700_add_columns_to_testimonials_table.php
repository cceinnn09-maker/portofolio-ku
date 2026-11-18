<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom tambahan untuk tabel testimonials (idempoten).
     */
    public function up(): void
    {
        $columns = [
            'is_visible' => fn (Blueprint $table) => $table->boolean('is_visible')->default(true),
            'sumber' => fn (Blueprint $table) => $table->string('sumber')->default('pengunjung'),
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
            ['is_visible', 'sumber'],
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
