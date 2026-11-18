<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Foto profil (opsional) untuk testimoni pengunjung.
     * File disimpan di storage/app/public/testimonials.
     */
    public function up(): void
    {
        if (! Schema::hasTable('testimonials')) {
            return;
        }

        if (! Schema::hasColumn('testimonials', 'foto')) {
            Schema::table('testimonials', function (Blueprint $table) {
                $table->string('foto')->nullable()->after('pesan');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('testimonials') && Schema::hasColumn('testimonials', 'foto')) {
            Schema::table('testimonials', function (Blueprint $table) {
                $table->dropColumn('foto');
            });
        }
    }
};
