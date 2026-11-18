<?php

namespace Tests\Feature;

use App\Models\Experience;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ContentUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_hard_skills_contain_only_the_three_requested_items(): void
    {
        $hardSkills = DB::table('skills')
            ->where('kategori', 'hard')
            ->orderBy('urutan')
            ->get()
            ->map(fn ($skill) => [$skill->nama, (int) $skill->persentase])
            ->all();

        $this->assertSame([
            ['UI/UX Wireframe & Design', 85],
            ['HTML', 80],
            ['CSS', 80],
        ], $hardSkills);
    }

    public function test_soft_skills_are_not_removed(): void
    {
        $this->assertSame(4, DB::table('skills')->where('kategori', 'soft')->count());
    }

    public function test_content_migration_renames_experience_and_keeps_photo(): void
    {
        $experience = Experience::create([
            'judul' => 'Lomba Kompetensi Desain Aplikasi',
            'posisi' => 'Peserta',
            'institusi' => 'Tingkat Pelajar',
            'deskripsi' => 'Deskripsi lama.',
            'gambar' => 'foto-lomba.jpg',
            'jenis' => 'lomba',
            'urutan' => 3,
        ]);

        DB::table('skills')->insert([
            'nama' => 'Skill Lama',
            'persentase' => 50,
            'kategori' => 'hard',
            'urutan' => 9,
        ]);

        $migration = require database_path('migrations/2026_11_19_100000_update_hard_skills_and_fashion_show_experience.php');
        $migration->up();

        $experience->refresh();

        $this->assertSame('Lomba Fashion Show Hari Kartini', $experience->judul);
        $this->assertSame('foto-lomba.jpg', $experience->gambar);
        $this->assertStringContainsString('Hari Kartini', $experience->deskripsi);

        $this->assertDatabaseMissing('skills', ['nama' => 'Skill Lama']);
        $this->assertSame(3, DB::table('skills')->where('kategori', 'hard')->count());
    }
}
