<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->string('nama')->nullable();
            $table->unsignedTinyInteger('persentase')->default(0);
            $table->string('kategori')->default('hard');
            $table->unsignedInteger('urutan')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->dropColumn(['nama', 'persentase', 'kategori', 'urutan']);
        });
    }
};
