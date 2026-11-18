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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Dashboard admin dengan tab CRUD.
     */
    public function dashboard(Request $request)
    {
        $tab = $request->query('tab', 'profile');
        $editType = $request->query('type');
        $editId = $request->query('edit');
        $editItem = null;

        if ($editType && $editId) {
            $editItem = match ($editType) {
                'education' => Education::find($editId),
                'skill' => Skill::find($editId),
                'project' => Project::find($editId),
                'certificate' => Certificate::find($editId),
                'experience' => Experience::find($editId),
                'post' => Post::find($editId),
                'testimonial' => Testimonial::find($editId),
                'setting' => Setting::find($editId),
                default => null,
            };
        }

        return view('admin.dashboard', [
            'tab' => $tab,
            'editType' => $editType,
            'editItem' => $editItem,
            'profile' => Profile::first() ?: new Profile(),
            'educations' => Education::orderBy('urutan')->orderBy('id')->get(),
            'skills' => Skill::orderBy('kategori')->orderBy('urutan')->orderBy('id')->get(),
            'projects' => Project::latest()->get(),
            'certificates' => Certificate::latest()->get(),
            'experiences' => Experience::orderBy('urutan')->orderBy('id')->get(),
            'posts' => Post::latest('tanggal')->latest('id')->get(),
            'testimonials' => Testimonial::latest()->get(),
            'messages' => Message::latest()->get(),
            'settings' => Setting::orderBy('id')->get(),
        ]);
    }

    /**
     * Simpan file upload ke folder public dan hapus file lama bila ada.
     */
    private function uploadFile($file, string $folder, ?string $oldFile = null): ?string
    {
        if (!$file) {
            return $oldFile;
        }

        $directory = public_path($folder);
        File::ensureDirectoryExists($directory, 0755);

        $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());
        $filename = time() . '_' . Str::random(6) . '_' . $safeName;

        $file->move($directory, $filename);

        if ($oldFile && $oldFile !== $filename) {
            $this->deleteFile($folder, $oldFile);
        }

        return $filename;
    }

    private function deleteFile(string $folder, ?string $filename): void
    {
        if (!$filename) {
            return;
        }

        $path = public_path($folder . '/' . $filename);

        if (File::exists($path)) {
            File::delete($path);
        }
    }

    private function adminRedirect(string $tab, string $message)
    {
        return redirect()
            ->route('admin.dashboard', ['tab' => $tab])
            ->with('success', $message);
    }

    // ==========================================
    // PROFIL / INFORMASI PRIBADI
    // ==========================================
    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kelas' => 'nullable|string|max:255',
            'kompetensi_keahlian' => 'nullable|string|max:255',
            'deskripsi_singkat' => 'nullable|string',
            'email' => 'nullable|string|max:255',
            'github' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'about_text' => 'nullable|string',
            'minat_teknologi' => 'nullable|string',
            'keahlian_utama' => 'nullable|string',
            'cita_cita' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'file_cv' => 'nullable|mimes:pdf|max:4096',
        ]);

        $profile = Profile::first() ?: new Profile();

        $profile->fill($request->only([
            'nama_lengkap', 'kelas', 'kompetensi_keahlian', 'deskripsi_singkat',
            'email', 'github', 'instagram', 'linkedin', 'tiktok', 'alamat',
            'tempat_lahir', 'tanggal_lahir', 'about_text', 'minat_teknologi',
            'keahlian_utama', 'cita_cita',
        ]));

        $profile->foto = $this->uploadFile($request->file('foto'), 'img/profiles', $profile->foto);
        $profile->file_cv = $this->uploadFile($request->file('file_cv'), 'files', $profile->file_cv);
        $profile->save();

        return $this->adminRedirect('profile', 'Informasi pribadi berhasil diperbarui.');
    }

    // ==========================================
    // KONTEN WEBSITE (SETTINGS)
    // ==========================================
    public function storeSetting(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|alpha_dash|unique:settings,name',
            'label' => 'required|string|max:255',
            'value' => 'nullable|string',
            'type' => 'required|in:text,textarea',
        ]);

        Setting::create($request->only(['name', 'label', 'value', 'type']));

        return $this->adminRedirect('settings', 'Konten website berhasil ditambahkan.');
    }

    public function updateSetting(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'nullable|string',
            'type' => 'required|in:text,textarea',
        ]);

        $setting->update($request->only(['label', 'value', 'type']));

        return $this->adminRedirect('settings', 'Konten website berhasil diperbarui.');
    }

    public function destroySetting($id)
    {
        Setting::findOrFail($id)->delete();

        return $this->adminRedirect('settings', 'Konten website berhasil dihapus.');
    }

    // ==========================================
    // RIWAYAT PENDIDIKAN
    // ==========================================
    public function storeEducation(Request $request)
    {
        $request->validate([
            'jenjang' => 'required|string|max:50',
            'institusi' => 'required|string|max:255',
            'periode' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
            'urutan' => 'nullable|integer|min:0',
        ]);

        Education::create(array_merge(
            $request->only(['jenjang', 'institusi', 'periode', 'keterangan']),
            ['urutan' => (int) $request->input('urutan', 0)]
        ));

        return $this->adminRedirect('education', 'Riwayat pendidikan berhasil ditambahkan.');
    }

    public function updateEducation(Request $request, $id)
    {
        $education = Education::findOrFail($id);

        $request->validate([
            'jenjang' => 'required|string|max:50',
            'institusi' => 'required|string|max:255',
            'periode' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $education->update(array_merge(
            $request->only(['jenjang', 'institusi', 'periode', 'keterangan']),
            ['urutan' => (int) $request->input('urutan', 0)]
        ));

        return $this->adminRedirect('education', 'Riwayat pendidikan berhasil diperbarui.');
    }

    public function destroyEducation($id)
    {
        Education::findOrFail($id)->delete();

        return $this->adminRedirect('education', 'Riwayat pendidikan berhasil dihapus.');
    }

    // ==========================================
    // KEAHLIAN / SKILLS
    // ==========================================
    public function storeSkill(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'persentase' => 'required|integer|min:0|max:100',
            'kategori' => 'required|in:hard,soft',
            'urutan' => 'nullable|integer|min:0',
        ]);

        Skill::create([
            'nama' => $request->nama,
            'persentase' => $request->persentase,
            'kategori' => $request->kategori,
            'urutan' => $request->input('urutan', 0),
        ]);

        return $this->adminRedirect('skills', 'Keahlian berhasil ditambahkan.');
    }

    public function updateSkill(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'persentase' => 'required|integer|min:0|max:100',
            'kategori' => 'required|in:hard,soft',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $skill->update([
            'nama' => $request->nama,
            'persentase' => $request->persentase,
            'kategori' => $request->kategori,
            'urutan' => $request->input('urutan', 0),
        ]);

        return $this->adminRedirect('skills', 'Keahlian berhasil diperbarui.');
    }

    public function destroySkill($id)
    {
        Skill::findOrFail($id)->delete();

        return $this->adminRedirect('skills', 'Keahlian berhasil dihapus.');
    }

    // ==========================================
    // PROJECT
    // ==========================================
    public function storeProject(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'permasalahan' => 'nullable|string',
            'tujuan' => 'nullable|string',
            'teknologi' => 'nullable|string|max:255',
            'peran' => 'nullable|string|max:255',
            'fitur_fitur' => 'nullable|string',
            'link_demo' => 'nullable|string|max:255',
            'link_github' => 'nullable|string|max:255',
            'dokumentasi' => 'nullable|string',
            'detail' => 'nullable|string',
            'feedback_user' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $project = new Project();
        $project->fill($request->only([
            'judul', 'kategori', 'deskripsi', 'permasalahan', 'tujuan',
            'teknologi', 'peran', 'fitur_fitur', 'link_demo', 'link_github',
            'dokumentasi', 'detail', 'feedback_user',
        ]));
        $project->nama_project = $request->judul;
        $project->gambar = $this->uploadFile($request->file('gambar'), 'img/projects');
        $project->save();

        return $this->adminRedirect('projects', 'Project berhasil ditambahkan.');
    }

    public function updateProject(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'permasalahan' => 'nullable|string',
            'tujuan' => 'nullable|string',
            'teknologi' => 'nullable|string|max:255',
            'peran' => 'nullable|string|max:255',
            'fitur_fitur' => 'nullable|string',
            'link_demo' => 'nullable|string|max:255',
            'link_github' => 'nullable|string|max:255',
            'dokumentasi' => 'nullable|string',
            'detail' => 'nullable|string',
            'feedback_user' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $project->fill($request->only([
            'judul', 'kategori', 'deskripsi', 'permasalahan', 'tujuan',
            'teknologi', 'peran', 'fitur_fitur', 'link_demo', 'link_github',
            'dokumentasi', 'detail', 'feedback_user',
        ]));
        $project->nama_project = $request->judul;
        $project->gambar = $this->uploadFile($request->file('gambar'), 'img/projects', $project->gambar);
        $project->save();

        return $this->adminRedirect('projects', 'Project berhasil diperbarui.');
    }

    public function destroyProject($id)
    {
        $project = Project::findOrFail($id);
        $this->deleteFile('img/projects', $project->gambar);
        $project->delete();

        return $this->adminRedirect('projects', 'Project berhasil dihapus.');
    }

    // ==========================================
    // SERTIFIKAT & PRESTASI
    // ==========================================
    public function storeCertificate(Request $request)
    {
        $request->validate([
            'nama_sertifikat' => 'required|string|max:255',
            'pemberi' => 'required|string|max:255',
            'tahun' => 'required|string|max:50',
            'jenis' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        Certificate::create([
            'nama_sertifikat' => $request->nama_sertifikat,
            'pemberi' => $request->pemberi,
            'tahun' => $request->tahun,
            'jenis' => $request->input('jenis', 'Sertifikat'),
            'deskripsi' => $request->deskripsi,
            'gambar' => $this->uploadFile($request->file('gambar'), 'img/certificates'),
        ]);

        return $this->adminRedirect('certificates', 'Sertifikat / prestasi berhasil ditambahkan.');
    }

    public function updateCertificate(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);

        $request->validate([
            'nama_sertifikat' => 'required|string|max:255',
            'pemberi' => 'required|string|max:255',
            'tahun' => 'required|string|max:50',
            'jenis' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $certificate->fill([
            'nama_sertifikat' => $request->nama_sertifikat,
            'pemberi' => $request->pemberi,
            'tahun' => $request->tahun,
            'jenis' => $request->input('jenis', 'Sertifikat'),
            'deskripsi' => $request->deskripsi,
        ]);
        $certificate->gambar = $this->uploadFile($request->file('gambar'), 'img/certificates', $certificate->gambar);
        $certificate->save();

        return $this->adminRedirect('certificates', 'Sertifikat / prestasi berhasil diperbarui.');
    }

    public function destroyCertificate($id)
    {
        $certificate = Certificate::findOrFail($id);
        $this->deleteFile('img/certificates', $certificate->gambar);
        $certificate->delete();

        return $this->adminRedirect('certificates', 'Sertifikat / prestasi berhasil dihapus.');
    }

    // ==========================================
    // PENGALAMAN (PLK, ORGANISASI, LOMBA)
    // ==========================================
    public function storeExperience(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'posisi' => 'nullable|string|max:255',
            'institusi' => 'nullable|string|max:255',
            'periode' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:plk,organisasi,lomba',
            'urutan' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        Experience::create([
            'judul' => $request->judul,
            'posisi' => $request->posisi,
            'institusi' => $request->institusi,
            'periode' => $request->periode,
            'deskripsi' => $request->deskripsi,
            'jenis' => $request->jenis,
            'urutan' => $request->input('urutan', 0),
            'gambar' => $this->uploadFile($request->file('gambar'), 'img/experiences'),
        ]);

        return $this->adminRedirect('experiences', 'Pengalaman berhasil ditambahkan.');
    }

    public function updateExperience(Request $request, $id)
    {
        $experience = Experience::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'posisi' => 'nullable|string|max:255',
            'institusi' => 'nullable|string|max:255',
            'periode' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:plk,organisasi,lomba',
            'urutan' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $experience->fill([
            'judul' => $request->judul,
            'posisi' => $request->posisi,
            'institusi' => $request->institusi,
            'periode' => $request->periode,
            'deskripsi' => $request->deskripsi,
            'jenis' => $request->jenis,
            'urutan' => $request->input('urutan', 0),
        ]);
        $experience->gambar = $this->uploadFile($request->file('gambar'), 'img/experiences', $experience->gambar);
        $experience->save();

        return $this->adminRedirect('experiences', 'Pengalaman berhasil diperbarui.');
    }

    public function destroyExperience($id)
    {
        $experience = Experience::findOrFail($id);
        $this->deleteFile('img/experiences', $experience->gambar);
        $experience->delete();

        return $this->adminRedirect('experiences', 'Pengalaman berhasil dihapus.');
    }

    // ==========================================
    // BLOG / ARTIKEL
    // ==========================================
    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'artikel';
        $slug = $base;
        $counter = 2;

        while (Post::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function storePost(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'ringkasan' => 'nullable|string',
            'konten' => 'required|string',
            'penulis' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        Post::create([
            'judul' => $request->judul,
            'slug' => $this->uniqueSlug($request->judul),
            'kategori' => $request->kategori,
            'ringkasan' => $request->ringkasan,
            'konten' => $request->konten,
            'penulis' => $request->input('penulis', 'Nurhaina'),
            'tanggal' => $request->tanggal ?: now()->toDateString(),
            'published' => $request->boolean('published'),
            'gambar' => $this->uploadFile($request->file('gambar'), 'img/posts'),
        ]);

        return $this->adminRedirect('blog', 'Artikel blog berhasil ditambahkan.');
    }

    public function updatePost(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'ringkasan' => 'nullable|string',
            'konten' => 'required|string',
            'penulis' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $post->fill([
            'judul' => $request->judul,
            'slug' => $this->uniqueSlug($request->judul, $post->id),
            'kategori' => $request->kategori,
            'ringkasan' => $request->ringkasan,
            'konten' => $request->konten,
            'penulis' => $request->input('penulis', 'Nurhaina'),
            'tanggal' => $request->tanggal ?: now()->toDateString(),
            'published' => $request->boolean('published'),
        ]);
        $post->gambar = $this->uploadFile($request->file('gambar'), 'img/posts', $post->gambar);
        $post->save();

        return $this->adminRedirect('blog', 'Artikel blog berhasil diperbarui.');
    }

    public function destroyPost($id)
    {
        $post = Post::findOrFail($id);
        $this->deleteFile('img/posts', $post->gambar);
        $post->delete();

        return $this->adminRedirect('blog', 'Artikel blog berhasil dihapus.');
    }

    // ==========================================
    // TESTIMONI
    // ==========================================
    public function storeTestimonialAdmin(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'profesi' => 'nullable|string|max:255',
            'pesan' => 'required|string',
        ]);

        Testimonial::create([
            'nama' => $request->nama,
            'profesi' => $request->input('profesi', 'Pengunjung'),
            'pesan' => $request->pesan,
            'sumber' => $request->input('sumber', 'admin'),
            'is_visible' => $request->boolean('is_visible'),
        ]);

        return $this->adminRedirect('testimonials', 'Testimoni berhasil ditambahkan.');
    }

    public function updateTestimonial(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'profesi' => 'nullable|string|max:255',
            'pesan' => 'required|string',
        ]);

        $testimonial->update([
            'nama' => $request->nama,
            'profesi' => $request->input('profesi', 'Pengunjung'),
            'pesan' => $request->pesan,
            'sumber' => $request->input('sumber', 'admin'),
            'is_visible' => $request->boolean('is_visible'),
        ]);

        return $this->adminRedirect('testimonials', 'Testimoni berhasil diperbarui.');
    }

    public function destroyTestimonial($id)
    {
        Testimonial::findOrFail($id)->delete();

        return $this->adminRedirect('testimonials', 'Testimoni berhasil dihapus.');
    }

    // ==========================================
    // PESAN MASUK
    // ==========================================
    public function destroyMessage($id)
    {
        Message::findOrFail($id)->delete();

        return $this->adminRedirect('messages', 'Pesan berhasil dihapus.');
    }
}
