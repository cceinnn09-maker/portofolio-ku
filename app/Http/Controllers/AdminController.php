<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Testimonial;
use App\Models\Post;
use App\Models\Message;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    // Menampilkan Dashboard Admin beserta semua data termasuk sertifikat & pesan
    public function index() {
        $projects = Project::all();
        $profile = Profile::first();
        $skills = Skill::all();
        $certificates = Certificate::all();
        $messages = Message::latest()->get();
        $testimonials = Testimonial::latest()->get();

        return view('home', compact('projects', 'profile', 'skills', 'certificates', 'messages', 'testimonials'));
    }

    // --- SIMPAN PESAN DARI PENGUNJUNG ---
    public function storeMessage(Request $request)
    {
        $request->validate([
            'nama_pengirim' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        Message::create([
            'nama_pengirim' => $request->nama_pengirim,
            'email' => $request->email,
            'pesan' => $request->pesan,
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }

    // --- CRUD TESTIMONI ---
    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'profesi' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        Testimonial::create([
            'nama' => $request->nama,
            'profesi' => $request->profesi,
            'pesan' => $request->pesan,
        ]);

        return redirect('/#testimoni')->with('success', 'Testimoni berhasil ditambahkan!');
    }

    public function destroyTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return redirect('/#testimoni')->with('success', 'Testimoni berhasil dihapus!');
    }

    // --- CRUD PROYEK ---
    public function storeProject(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $project = new Project();
        $project->judul = $request->judul;
        $project->kategori = $request->kategori;
        $project->deskripsi = $request->deskripsi;
        $project->permasalahan = $request->permasalahan;
        $project->tujuan = $request->tujuan;
        $project->teknologi = $request->teknologi;
        $project->peran = $request->peran;
        $project->link_demo = $request->link_demo;
        $project->link_github = $request->link_github;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/projects'), $filename);
            $project->gambar = $filename;
        }

        $project->save();

        return redirect('/#project')->with('success', 'Project baru berhasil ditambahkan!');
    }

    public function updateProject(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $project = Project::findOrFail($id);
        $project->judul = $request->judul;
        $project->kategori = $request->kategori;
        $project->deskripsi = $request->deskripsi;
        $project->permasalahan = $request->permasalahan;
        $project->tujuan = $request->tujuan;
        $project->teknologi = $request->teknologi;
        $project->peran = $request->peran;
        $project->link_demo = $request->link_demo;
        $project->link_github = $request->link_github;

        if ($request->hasFile('gambar')) {
            if ($project->gambar && file_exists(public_path('img/projects/' . $project->gambar))) {
                @unlink(public_path('img/projects/' . $project->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/projects'), $filename);
            $project->gambar = $filename;
        }

        $project->save();

        return redirect('/#project')->with('success', 'Project berhasil diperbarui!');
    }

    public function destroyProject($id)
    {
        $project = Project::findOrFail($id);
        if ($project->gambar && file_exists(public_path('img/projects/' . $project->gambar))) {
            @unlink(public_path('img/projects/' . $project->gambar));
        }
        $project->delete();

        return redirect('/#project')->with('success', 'Project berhasil dihapus!');
    }

    // --- CRUD SERTIFIKAT & PRESTASI ---
    public function storeCertificate(Request $request) {
        $request->validate([
            'nama_sertifikat' => 'required',
            'pemberi' => 'required',
            'tahun' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imgName = 'cert_' . time() . '.' . $request->gambar->extension();
        $request->gambar->move(public_path('img/certificates'), $imgName);

        Certificate::create([
            'nama_sertifikat' => $request->nama_sertifikat,
            'pemberi' => $request->pemberi,
            'tahun' => $request->tahun,
            'gambar' => $imgName,
        ]);

        return redirect('/#sertifikat')->with('success', 'Sertifikat berhasil ditambahkan!');
    }

    public function destroyCertificate($id) {
        $cert = Certificate::findOrFail($id);
        $path = public_path('img/certificates/' . $cert->gambar);
        if (File::exists($path)) {
            File::delete($path);
        }
        $cert->delete();
        
        return redirect('/#sertifikat')->with('success', 'Sertifikat berhasil dihapus!');
    }

    // --- KELOLA PROFIL & UPLOAD CV DIGITAL ---
    public function updateProfile(Request $request)
    {
        $request->validate([
            'file_cv' => 'required|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file_cv')) {
            $file = $request->file('file_cv');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            $file->move(public_path('files'), $filename);

            $profile = Profile::first();
            if (!$profile) {
                $profile = new Profile();
            }

            if ($profile->file_cv && file_exists(public_path('files/' . $profile->file_cv))) {
                @unlink(public_path('files/' . $profile->file_cv));
            }

            $profile->file_cv = $filename;
            $profile->save();
        }

        return redirect()->back()->with('success', 'CV Digital berhasil diperbarui!');
    }
}