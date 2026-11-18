<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TestimonialPhotoTest extends TestCase
{
    use RefreshDatabase;

    public function test_testimonial_can_be_submitted_without_photo(): void
    {
        Storage::fake('public');

        $this->post(route('testimonial.store'), [
            'nama' => 'Tanpa Foto',
            'profesi' => 'Pengunjung',
            'pesan' => 'Portofolionya bagus.',
        ])->assertRedirect('/#testimoni');

        $testimonial = Testimonial::where('nama', 'Tanpa Foto')->firstOrFail();

        $this->assertNull($testimonial->foto);
        $this->assertTrue($testimonial->is_visible);
    }

    public function test_testimonial_photo_is_stored_publicly(): void
    {
        Storage::fake('public');

        $this->post(route('testimonial.store'), [
            'nama' => 'Dengan Foto',
            'profesi' => 'Teman',
            'pesan' => 'Mantap!',
            'foto' => UploadedFile::fake()->image('avatar.jpg', 200, 200),
        ])->assertRedirect('/#testimoni');

        $testimonial = Testimonial::where('nama', 'Dengan Foto')->firstOrFail();

        $this->assertNotNull($testimonial->foto);
        $this->assertStringStartsWith('testimonials/', $testimonial->foto);
        Storage::disk('public')->assertExists($testimonial->foto);
    }

    public function test_testimonial_photo_must_be_a_valid_image(): void
    {
        Storage::fake('public');

        $this->post(route('testimonial.store'), [
            'nama' => 'File Salah',
            'pesan' => 'Test validasi.',
            'foto' => UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf'),
        ])->assertSessionHasErrors('foto');

        $this->assertDatabaseMissing('testimonials', ['nama' => 'File Salah']);
    }

    public function test_cv_download_is_sent_as_attachment(): void
    {
        $profile = Profile::first() ?: new Profile();
        $profile->nama_lengkap = 'Nurhaina';
        $profile->file_cv = 'cv-test.pdf';
        $profile->save();

        $directory = public_path('files');
        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $path = $directory . '/cv-test.pdf';
        file_put_contents($path, '%PDF-1.4 contoh');

        try {
            $response = $this->get(route('cv.download'));

            $response->assertOk();
            $response->assertHeader('content-type', 'application/pdf');
            $this->assertStringContainsString(
                'attachment',
                (string) $response->headers->get('content-disposition')
            );
        } finally {
            if (is_file($path)) {
                unlink($path);
            }
        }
    }

    public function test_cv_download_redirects_back_when_file_is_missing(): void
    {
        $profile = Profile::first() ?: new Profile();
        $profile->nama_lengkap = 'Nurhaina';
        $profile->file_cv = null;
        $profile->save();

        $this->get(route('cv.download'))
            ->assertRedirect('/#cv')
            ->assertSessionHas('error');
    }
}
