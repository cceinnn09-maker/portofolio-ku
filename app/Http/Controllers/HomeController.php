<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'profile' => Profile::first(),
            'projects' => Project::latest()->get(),
            'skills' => Skill::orderBy('kategori')->orderBy('urutan')->get(),
            'certificates' => Certificate::latest()->get(),
            'experiences' => Experience::orderBy('urutan')->get(),
            'educations' => Education::orderBy('urutan')->get(),
            'posts' => Post::where('published', true)->orderByDesc('tanggal')->orderByDesc('id')->get(),
            'testimonis' => Testimonial::where('is_visible', true)->latest()->get(),
            'settings' => Setting::asArray(),
        ]);
    }

    public function blogShow($id)
    {
        $post = Post::where('published', true)->findOrFail($id);

        return view('blog.detail', [
            'post' => $post,
            'profile' => Profile::first(),
            'settings' => Setting::asArray(),
        ]);
    }

    public function downloadCv()
    {
        $profile = Profile::first();

        if ($profile && $profile->file_cv) {
            $path = public_path('files/' . $profile->file_cv);

            if (is_file($path)) {
                // Direct download: browser tidak berpindah halaman dan tidak
                // membuka tab baru yang kosong.
                $namaFile = 'CV-' . Str::slug($profile->nama_lengkap ?: 'Nurhaina') . '.pdf';

                return response()->download($path, $namaFile, [
                    'Content-Type' => 'application/pdf',
                ]);
            }
        }

        return redirect('/#cv')->with('error', 'File CV belum tersedia.');
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'nama_pengirim' => 'required|string|max:255',
            'email' => 'nullable|string|max:255',
            'pesan' => 'required|string',
        ]);

        Message::create([
            'nama_pengirim' => $request->nama_pengirim,
            'email' => $request->email,
            'pesan' => $request->pesan,
        ]);

        return redirect('/#kontak')->with('success', 'Pesan berhasil dikirim!');
    }

    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'profesi' => 'nullable|string|max:255',
            'pesan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'foto.image' => 'Foto profil harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        // Foto profil opsional: disimpan di storage/app/public/testimonials.
        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('testimonials', 'public');
        }

        Testimonial::create([
            'nama' => $request->nama,
            'profesi' => $request->input('profesi', 'Pengunjung'),
            'pesan' => $request->pesan,
            'foto' => $foto,
            'sumber' => 'pengunjung',
            'is_visible' => true,
        ]);

        return redirect('/#testimoni')->with('success', 'Terima kasih! Testimoni kamu sudah dikirim.');
    }
}
