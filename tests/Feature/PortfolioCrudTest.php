<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class PortfolioCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_and_admin_pages_render(): void
    {
        $user = User::factory()->create();

        $this->get('/')->assertOk();
        $this->get('/blog/1')->assertOk();

        foreach (['profile', 'settings', 'education', 'skills', 'projects', 'certificates', 'experiences', 'blog', 'testimonials', 'messages'] as $tab) {
            $this->actingAs($user)->get('/admin?tab=' . $tab)->assertOk();
        }
    }

    public function test_all_admin_crud_actions_work(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Project tanpa gambar (dulu 500)
        $this->post(route('projects.store'), [
            'judul' => 'Test Project',
            'kategori' => 'UI/UX Design',
            'deskripsi' => 'Deskripsi project',
            'teknologi' => 'Figma',
            'peran' => 'Designer',
        ])->assertRedirect();
        $project = Project::where('judul', 'Test Project')->firstOrFail();
        $this->put(route('projects.update', $project->id), [
            'judul' => 'Test Project Updated',
            'kategori' => 'Web',
            'deskripsi' => 'Deskripsi baru',
        ])->assertRedirect();
        $this->assertDatabaseHas('projects', ['judul' => 'Test Project Updated']);

        // Sertifikat tanpa gambar (dulu 500)
        $this->post(route('certificates.store'), [
            'nama_sertifikat' => 'Sertifikat Test',
            'pemberi' => 'Sekolah',
            'tahun' => '2026',
            'jenis' => 'Prestasi',
        ])->assertRedirect();
        $this->assertDatabaseHas('certificates', ['nama_sertifikat' => 'Sertifikat Test']);

        // Pendidikan
        $this->post(route('admin.education.store'), [
            'jenjang' => 'SD',
            'institusi' => 'SD Test',
            'periode' => '2012 - 2018',
            'urutan' => 1,
        ])->assertRedirect();
        $this->assertDatabaseHas('educations', ['institusi' => 'SD Test']);

        // Skill
        $this->post(route('admin.skills.store'), [
            'nama' => 'Skill Test',
            'persentase' => 90,
            'kategori' => 'hard',
        ])->assertRedirect();
        $this->assertDatabaseHas('skills', ['nama' => 'Skill Test']);

        // Pengalaman
        $this->post(route('admin.experiences.store'), [
            'judul' => 'PLK Test',
            'jenis' => 'plk',
            'institusi' => 'Kantor',
            'deskripsi' => 'Pengalaman PLK',
        ])->assertRedirect();
        $this->assertDatabaseHas('experiences', ['judul' => 'PLK Test']);

        // Blog
        $this->post(route('admin.posts.store'), [
            'judul' => 'Artikel Test',
            'konten' => 'Isi artikel',
            'published' => 1,
        ])->assertRedirect();
        $this->assertDatabaseHas('posts', ['judul' => 'Artikel Test']);

        // Setting / konten website
        $this->post(route('admin.settings.store'), [
            'name' => 'test_content',
            'label' => 'Konten Test',
            'value' => 'Isi konten',
            'type' => 'text',
        ])->assertRedirect();
        $setting = Setting::where('name', 'test_content')->firstOrFail();

        $this->put(route('admin.settings.update', $setting->id), [
            'label' => 'Konten Test Updated',
            'value' => 'Isi baru',
            'type' => 'text',
        ])->assertRedirect();
        $this->assertDatabaseHas('settings', ['value' => 'Isi baru']);

        // Testimoni admin
        $this->post(route('admin.testimonials.store'), [
            'nama' => 'Testi Test',
            'profesi' => 'Teman',
            'pesan' => 'Bagus',
            'is_visible' => 1,
        ])->assertRedirect();
        $this->assertDatabaseHas('testimonials', ['nama' => 'Testi Test']);

        // Profil
        $this->post(route('admin.profile.update'), [
            'nama_lengkap' => 'Nurhaina Updated',
            'kelas' => 'XII PPLG 1',
            'kompetensi_keahlian' => 'PPLG',
        ])->assertRedirect();
        $this->assertDatabaseHas('profiles', ['nama_lengkap' => 'Nurhaina Updated']);

        // Pesan & testimoni publik
        $this->post(route('pesan.store'), [
            'nama_pengirim' => 'Pengunjung',
            'email' => 'a@b.com',
            'pesan' => 'Halo',
        ])->assertRedirect();
        $this->assertDatabaseHas('messages', ['nama_pengirim' => 'Pengunjung']);

        $this->post(route('testimonial.store'), [
            'nama' => 'Pengunjung Testi',
            'profesi' => 'Pengunjung',
            'pesan' => 'Mantap',
        ])->assertRedirect();
        $this->assertDatabaseHas('testimonials', ['nama' => 'Pengunjung Testi']);
    }

    public function test_file_uploads_work_for_every_image_field(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $created = [];

        // Project dengan gambar (penyebab 500 sebelumnya: folder tidak ada)
        $this->post(route('projects.store'), [
            'judul' => 'Project Bergambar',
            'kategori' => 'UI/UX Design',
            'deskripsi' => 'Deskripsi',
            'gambar' => UploadedFile::fake()->image('project.png', 640, 400),
        ])->assertRedirect();
        $project = Project::where('judul', 'Project Bergambar')->firstOrFail();
        $this->assertNotEmpty($project->gambar);
        $created[] = public_path('img/projects/' . $project->gambar);
        $this->assertFileExists(public_path('img/projects/' . $project->gambar));

        // Sertifikat dengan gambar
        $this->post(route('certificates.store'), [
            'nama_sertifikat' => 'Sertifikat Bergambar',
            'pemberi' => 'Sekolah',
            'tahun' => '2026',
            'jenis' => 'Sertifikat',
            'gambar' => UploadedFile::fake()->image('cert.png', 640, 400),
        ])->assertRedirect();
        $cert = Certificate::where('nama_sertifikat', 'Sertifikat Bergambar')->firstOrFail();
        $this->assertNotEmpty($cert->gambar);
        $created[] = public_path('img/certificates/' . $cert->gambar);

        // Pengalaman dengan foto bukti
        $this->post(route('admin.experiences.store'), [
            'judul' => 'PLK Bergambar',
            'jenis' => 'plk',
            'institusi' => 'Kantor Kelurahan',
            'deskripsi' => 'Deskripsi',
            'gambar' => UploadedFile::fake()->image('plk.png', 640, 400),
        ])->assertRedirect();
        $exp = Experience::where('judul', 'PLK Bergambar')->firstOrFail();
        $this->assertNotEmpty($exp->gambar);
        $created[] = public_path('img/experiences/' . $exp->gambar);

        // Artikel blog dengan gambar
        $this->post(route('admin.posts.store'), [
            'judul' => 'Artikel Bergambar',
            'konten' => 'Isi',
            'gambar' => UploadedFile::fake()->image('post.png', 640, 400),
        ])->assertRedirect();
        $post = \App\Models\Post::where('judul', 'Artikel Bergambar')->firstOrFail();
        $this->assertNotEmpty($post->gambar);
        $created[] = public_path('img/posts/' . $post->gambar);

        // Foto profil + CV
        $this->post(route('admin.profile.update'), [
            'nama_lengkap' => 'Nurhaina Foto',
            'foto' => UploadedFile::fake()->image('avatar.png', 300, 300),
            'file_cv' => UploadedFile::fake()->create('cv.pdf', 120, 'application/pdf'),
        ])->assertRedirect();
        $profile = Profile::first();
        $this->assertNotEmpty($profile->foto);
        $this->assertNotEmpty($profile->file_cv);
        $created[] = public_path('img/profiles/' . $profile->foto);
        $created[] = public_path('files/' . $profile->file_cv);

        // Hapus file uji supaya folder public tetap bersih
        foreach ($created as $path) {
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }
}
