<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Portofolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; opacity: 0; animation: fadeIn .4s ease forwards; }
        @keyframes fadeIn { to { opacity: 1; } }
        .field { width: 100%; background: #faf5ff; border: 1px solid #f3e8ff; border-radius: .85rem; padding: .7rem 1rem; font-size: .8rem; outline: none; transition: .2s; }
        .field:focus { border-color: #c084fc; background: #fff; }
        .dark .field { background: #0f172a; border-color: #334155; color: #e2e8f0; }
        .label { display: block; font-size: .68rem; font-weight: 600; color: #64748b; margin-bottom: .35rem; }
        .dark .label { color: #94a3b8; }
        .card { background: #fff; border: 1px solid #f3e8ff; border-radius: 1.75rem; padding: 1.5rem; }
        .dark .card { background: #1e293b; border-color: #334155; }
        .btn-primary { background: #a855f7; color: #fff; font-weight: 700; font-size: .75rem; padding: .75rem 1.25rem; border-radius: .85rem; transition: .2s; }
        .btn-primary:hover { background: #9333ea; }
        .btn-soft { background: #f3e8ff; color: #7e22ce; font-weight: 700; font-size: .7rem; padding: .45rem .8rem; border-radius: .7rem; transition: .2s; }
        .btn-soft:hover { background: #e9d5ff; }
        .dark .btn-soft { background: #334155; color: #d8b4fe; }
        .btn-danger { background: #fef2f2; color: #dc2626; font-weight: 700; font-size: .7rem; padding: .45rem .8rem; border-radius: .7rem; transition: .2s; }
        .btn-danger:hover { background: #fee2e2; }
        .dark .btn-danger { background: #450a0a; color: #fca5a5; }
        .nav-link { display: flex; align-items: center; gap: .7rem; padding: .7rem .9rem; border-radius: .9rem; font-size: .78rem; font-weight: 600; color: #64748b; transition: .2s; }
        .nav-link:hover { background: #faf5ff; color: #9333ea; }
        .nav-link.active { background: #a855f7; color: #fff; box-shadow: 0 10px 20px -12px #a855f7; }
        .dark .nav-link { color: #94a3b8; }
        .dark .nav-link:hover { background: #0f172a; color: #d8b4fe; }
        .dark .nav-link.active { background: #a855f7; color: #fff; }
        .th { font-size: .65rem; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; padding: .75rem; text-align: left; }
        .td { font-size: .75rem; padding: .75rem; border-top: 1px solid #f3e8ff; vertical-align: top; }
        .dark .td { border-color: #334155; }
    </style>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="bg-purple-50/40 dark:bg-slate-950 text-slate-800 dark:text-slate-100">

@php
    $navItems = [
        'profile' => ['label' => 'Informasi Pribadi', 'icon' => 'fa-user'],
        'settings' => ['label' => 'Konten Website', 'icon' => 'fa-layer-group'],
        'education' => ['label' => 'Riwayat Pendidikan', 'icon' => 'fa-graduation-cap'],
        'skills' => ['label' => 'Keahlian', 'icon' => 'fa-chart-simple'],
        'projects' => ['label' => 'Project', 'icon' => 'fa-folder-open'],
        'certificates' => ['label' => 'Sertifikat & Prestasi', 'icon' => 'fa-award'],
        'experiences' => ['label' => 'Pengalaman', 'icon' => 'fa-briefcase'],
        'blog' => ['label' => 'Blog / Artikel', 'icon' => 'fa-pen-nib'],
        'testimonials' => ['label' => 'Testimoni', 'icon' => 'fa-quote-left'],
        'messages' => ['label' => 'Pesan Masuk', 'icon' => 'fa-envelope'],
    ];
    $editEdu = $editType === 'education' ? $editItem : null;
    $editSkill = $editType === 'skill' ? $editItem : null;
    $editProject = $editType === 'project' ? $editItem : null;
    $editCert = $editType === 'certificate' ? $editItem : null;
    $editExp = $editType === 'experience' ? $editItem : null;
    $editPost = $editType === 'post' ? $editItem : null;
    $editTesti = $editType === 'testimonial' ? $editItem : null;
@endphp

<div class="min-h-screen lg:flex">
    <!-- SIDEBAR -->
    <aside class="lg:fixed lg:inset-y-0 lg:left-0 lg:w-72 bg-white dark:bg-slate-900 border-r border-purple-100 dark:border-slate-800 p-5 lg:overflow-y-auto">
        <a href="{{ route('home') }}" class="flex items-center gap-3 px-2 py-3">
            <span class="w-10 h-10 rounded-2xl bg-purple-500 text-white flex items-center justify-center font-bold">N</span>
            <span>
                <span class="block font-bold text-sm">Nurhaina</span>
                <span class="block text-[10px] text-slate-400">Panel Admin Portofolio</span>
            </span>
        </a>

        <nav class="mt-5 space-y-1">
            @foreach($navItems as $key => $item)
                <a href="{{ route('admin.dashboard', ['tab' => $key]) }}" class="nav-link {{ $tab === $key ? 'active' : '' }}">
                    <i class="fa-solid {{ $item['icon'] }} w-4 text-center"></i>
                    {{ $item['label'] }}
                    @if($key === 'messages')
                        <span class="ml-auto text-[10px] bg-purple-100 dark:bg-slate-700 text-purple-700 dark:text-purple-300 px-2 py-0.5 rounded-full">{{ $messages->count() }}</span>
                    @endif
                </a>
            @endforeach
        </nav>

        <div class="mt-6 pt-5 border-t border-purple-100 dark:border-slate-800 space-y-2">
            <a href="{{ route('home') }}" target="_blank" class="nav-link">
                <i class="fa-solid fa-globe w-4 text-center"></i> Lihat Website
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link w-full text-left text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/30">
                    <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 lg:ml-72 p-4 md:p-8">
        <div class="max-w-5xl mx-auto space-y-6">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-purple-500">Dashboard Admin</p>
                    <h1 class="text-2xl font-bold">{{ $navItems[$tab]['label'] ?? 'Dashboard' }}</h1>
                    <p class="text-xs text-slate-400 mt-1">Semua data di website bisa diubah dari halaman ini tanpa menyentuh kode.</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="toggleAdminTheme()" class="w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-purple-100 dark:border-slate-700 text-purple-600 dark:text-yellow-400 flex items-center justify-center" title="Ganti tema">
                        <i id="admin-theme-icon" class="fa-solid fa-moon text-xs"></i>
                    </button>
                    <a href="{{ route('home') }}" target="_blank" class="btn-primary">Buka Website</a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-900 text-emerald-700 dark:text-emerald-300 px-5 py-3.5 rounded-2xl text-xs font-medium">
                    <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-900 text-red-700 dark:text-red-300 px-5 py-3.5 rounded-2xl text-xs">
                    <p class="font-bold mb-1"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Periksa kembali data berikut:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ============================================================ --}}
            {{-- INFORMASI PRIBADI --}}
            {{-- ============================================================ --}}
            @if($tab === 'profile')
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="card space-y-5">
                    @csrf
                    @php
                        $adminPhoto = asset('img/ennnaa.jpg');
                        if ($profile->foto) {
                            if (file_exists(public_path('img/profiles/' . $profile->foto))) {
                                $adminPhoto = asset('img/profiles/' . $profile->foto);
                            } elseif (file_exists(public_path('img/' . $profile->foto))) {
                                $adminPhoto = asset('img/' . $profile->foto);
                            }
                        }
                    @endphp
                    <div class="flex items-center gap-4 pb-4 border-b border-purple-100 dark:border-slate-700">
                        <img src="{{ $adminPhoto }}" alt="Foto Profil" class="w-16 h-16 rounded-full object-cover border-4 border-purple-200 dark:border-slate-700">
                        <div>
                            <h2 class="font-bold">Informasi Pribadi</h2>
                            <p class="text-[11px] text-slate-400">Nama, kelas, kompetensi keahlian, kontak, foto, dan CV.</p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div><label class="label">Nama Lengkap</label><input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $profile->nama_lengkap ?? 'Nurhaina') }}" class="field" required></div>
                        <div><label class="label">Kelas</label><input type="text" name="kelas" value="{{ old('kelas', $profile->kelas) }}" placeholder="Contoh: XII PPLG 1" class="field"></div>
                        <div class="md:col-span-2"><label class="label">Kompetensi Keahlian</label><input type="text" name="kompetensi_keahlian" value="{{ old('kompetensi_keahlian', $profile->kompetensi_keahlian) }}" placeholder="Contoh: Pengembangan Perangkat Lunak dan Gim (PPLG)" class="field"></div>
                        <div class="md:col-span-2"><label class="label">Deskripsi Singkat / Personal Branding</label><textarea name="deskripsi_singkat" rows="2" class="field">{{ old('deskripsi_singkat', $profile->deskripsi_singkat) }}</textarea></div>
                        <div class="md:col-span-2"><label class="label">Tentang Saya (About)</label><textarea name="about_text" rows="3" class="field">{{ old('about_text', $profile->about_text) }}</textarea></div>
                        <div><label class="label">Minat & Teknologi Dikuasai</label><textarea name="minat_teknologi" rows="3" class="field">{{ old('minat_teknologi', $profile->minat_teknologi) }}</textarea></div>
                        <div><label class="label">Keahlian Utama</label><textarea name="keahlian_utama" rows="3" class="field">{{ old('keahlian_utama', $profile->keahlian_utama) }}</textarea></div>
                        <div class="md:col-span-2"><label class="label">Cita-Cita / Tujuan Karir</label><textarea name="cita_cita" rows="2" class="field">{{ old('cita_cita', $profile->cita_cita) }}</textarea></div>
                        <div><label class="label">Email</label><input type="text" name="email" value="{{ old('email', $profile->email) }}" class="field"></div>
                        <div><label class="label">Alamat</label><input type="text" name="alamat" value="{{ old('alamat', $profile->alamat) }}" class="field"></div>
                        <div><label class="label">Tempat Lahir</label><input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $profile->tempat_lahir) }}" class="field"></div>
                        <div><label class="label">Tanggal Lahir</label><input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $profile->tanggal_lahir) }}" class="field"></div>
                        <div><label class="label">GitHub</label><input type="text" name="github" value="{{ old('github', $profile->github) }}" class="field"></div>
                        <div><label class="label">Instagram</label><input type="text" name="instagram" value="{{ old('instagram', $profile->instagram) }}" class="field"></div>
                        <div><label class="label">LinkedIn</label><input type="text" name="linkedin" value="{{ old('linkedin', $profile->linkedin) }}" class="field"></div>
                        <div><label class="label">TikTok</label><input type="text" name="tiktok" value="{{ old('tiktok', $profile->tiktok) }}" class="field"></div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4 pt-2 border-t border-purple-100 dark:border-slate-700">
                        <div>
                            <label class="label">Foto Profil / Avatar</label>
                            <input type="file" name="foto" accept="image/*" class="field file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-purple-100 file:text-purple-700">
                            <p class="text-[10px] text-slate-400 mt-1">Biarkan kosong jika tidak ingin mengganti foto.</p>
                        </div>
                        <div>
                            <label class="label">CV Digital (PDF)</label>
                            <input type="file" name="file_cv" accept="application/pdf" class="field file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-purple-100 file:text-purple-700">
                            <p class="text-[10px] text-slate-400 mt-1">
                                @if($profile->file_cv)
                                    CV saat ini: <span class="text-purple-500 font-semibold">{{ $profile->file_cv }}</span>
                                @else
                                    Belum ada CV yang diunggah.
                                @endif
                            </p>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary w-full">Simpan Informasi Pribadi</button>
                </form>
            @endif

            {{-- ============================================================ --}}
            {{-- KONTEN WEBSITE --}}
            {{-- ============================================================ --}}
            @if($tab === 'settings')
                <div class="card space-y-4">
                    <div>
                        <h2 class="font-bold">Konten Teks Website</h2>
                        <p class="text-[11px] text-slate-400">Ubah teks beranda, tentang saya, CV, kontak, dan footer tanpa mengubah kode.</p>
                    </div>

                    <div class="space-y-3">
                        @forelse($settings as $setting)
                            <div class="border border-purple-100 dark:border-slate-700 rounded-2xl p-4">
                                <form action="{{ route('admin.settings.update', $setting->id) }}" method="POST" class="space-y-3">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="label">Label</label>
                                            <input type="text" name="label" value="{{ $setting->label }}" class="field" required>
                                        </div>
                                        <div>
                                            <label class="label">Key (tidak diubah)</label>
                                            <input type="text" value="{{ $setting->name }}" class="field opacity-60" disabled>
                                        </div>
                                        <div>
                                            <label class="label">Tipe</label>
                                            <select name="type" class="field">
                                                <option value="text" @selected($setting->type === 'text')>Teks Singkat</option>
                                                <option value="textarea" @selected($setting->type === 'textarea')>Paragraf</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="label">Isi Konten</label>
                                        @if($setting->type === 'textarea')
                                            <textarea name="value" rows="2" class="field">{{ $setting->value }}</textarea>
                                        @else
                                            <input type="text" name="value" value="{{ $setting->value }}" class="field">
                                        @endif
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="submit" class="btn-primary">Simpan</button>
                                    </div>
                                </form>
                                <form action="{{ route('admin.settings.delete', $setting->id) }}" method="POST" onsubmit="return confirm('Hapus konten ini?')" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger">Hapus Konten</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 text-center py-6">Belum ada konten website.</p>
                        @endforelse
                    </div>
                </div>

                <form action="{{ route('admin.settings.store') }}" method="POST" class="card space-y-4">
                    @csrf
                    <h3 class="font-bold">Tambah Konten Baru</h3>
                    <div class="grid md:grid-cols-3 gap-3">
                        <div><label class="label">Key (huruf kecil, tanpa spasi)</label><input type="text" name="name" placeholder="contoh_judul_baru" class="field" required></div>
                        <div><label class="label">Label</label><input type="text" name="label" placeholder="Judul Konten" class="field" required></div>
                        <div>
                            <label class="label">Tipe</label>
                            <select name="type" class="field">
                                <option value="text">Teks Singkat</option>
                                <option value="textarea">Paragraf</option>
                            </select>
                        </div>
                    </div>
                    <div><label class="label">Isi Konten</label><textarea name="value" rows="2" class="field"></textarea></div>
                    <button type="submit" class="btn-primary">Tambah Konten</button>
                </form>
            @endif

            {{-- ============================================================ --}}
            {{-- PENDIDIKAN --}}
            {{-- ============================================================ --}}
            @if($tab === 'education')
                <form action="{{ $editEdu ? route('admin.education.update', $editEdu->id) : route('admin.education.store') }}" method="POST" class="card space-y-4">
                    @csrf
                    @if($editEdu) @method('PUT') @endif
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold">{{ $editEdu ? 'Edit Riwayat Pendidikan' : 'Tambah Riwayat Pendidikan' }}</h2>
                        @if($editEdu)<a href="{{ route('admin.dashboard', ['tab' => 'education']) }}" class="btn-soft">Batal Edit</a>@endif
                    </div>
                    <div class="grid md:grid-cols-2 gap-3">
                        <div><label class="label">Jenjang</label><input type="text" name="jenjang" value="{{ old('jenjang', $editEdu->jenjang ?? '') }}" placeholder="TK / SD / SMP / SMK" class="field" required></div>
                        <div><label class="label">Nama Institusi</label><input type="text" name="institusi" value="{{ old('institusi', $editEdu->institusi ?? '') }}" placeholder="Nama sekolah" class="field" required></div>
                        <div><label class="label">Periode</label><input type="text" name="periode" value="{{ old('periode', $editEdu->periode ?? '') }}" placeholder="2024 - Sekarang" class="field"></div>
                        <div><label class="label">Urutan Tampil</label><input type="number" name="urutan" value="{{ old('urutan', $editEdu->urutan ?? 0) }}" class="field"></div>
                    </div>
                    <div><label class="label">Keterangan</label><textarea name="keterangan" rows="2" class="field">{{ old('keterangan', $editEdu->keterangan ?? '') }}</textarea></div>
                    <button type="submit" class="btn-primary">{{ $editEdu ? 'Simpan Perubahan' : 'Tambah Pendidikan' }}</button>
                </form>

                <div class="card overflow-x-auto">
                    <table class="min-w-full">
                        <thead><tr><th class="th">Jenjang</th><th class="th">Institusi</th><th class="th">Periode</th><th class="th text-right">Aksi</th></tr></thead>
                        <tbody>
                            @forelse($educations as $education)
                                <tr>
                                    <td class="td font-bold text-purple-600 dark:text-purple-400">{{ $education->jenjang }}</td>
                                    <td class="td">{{ $education->institusi }}<p class="text-[10px] text-slate-400">{{ $education->keterangan }}</p></td>
                                    <td class="td">{{ $education->periode ?: '-' }}</td>
                                    <td class="td text-right whitespace-nowrap">
                                        <a href="{{ route('admin.dashboard', ['tab' => 'education', 'type' => 'education', 'edit' => $education->id]) }}" class="btn-soft">Edit</a>
                                        <form action="{{ route('admin.education.delete', $education->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus riwayat ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="td text-center text-slate-400">Belum ada riwayat pendidikan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- ============================================================ --}}
            {{-- SKILLS --}}
            {{-- ============================================================ --}}
            @if($tab === 'skills')
                <form action="{{ $editSkill ? route('admin.skills.update', $editSkill->id) : route('admin.skills.store') }}" method="POST" class="card space-y-4">
                    @csrf
                    @if($editSkill) @method('PUT') @endif
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold">{{ $editSkill ? 'Edit Keahlian' : 'Tambah Keahlian' }}</h2>
                        @if($editSkill)<a href="{{ route('admin.dashboard', ['tab' => 'skills']) }}" class="btn-soft">Batal Edit</a>@endif
                    </div>
                    <div class="grid md:grid-cols-4 gap-3">
                        <div class="md:col-span-2"><label class="label">Nama Keahlian</label><input type="text" name="nama" value="{{ old('nama', $editSkill->nama ?? '') }}" class="field" required></div>
                        <div><label class="label">Persentase (%)</label><input type="number" name="persentase" min="0" max="100" value="{{ old('persentase', $editSkill->persentase ?? 80) }}" class="field" required></div>
                        <div>
                            <label class="label">Kategori</label>
                            <select name="kategori" class="field">
                                <option value="hard" @selected(($editSkill->kategori ?? 'hard') === 'hard')>Hard Skill</option>
                                <option value="soft" @selected(($editSkill->kategori ?? '') === 'soft')>Soft Skill</option>
                            </select>
                        </div>
                    </div>
                    <div><label class="label">Urutan Tampil</label><input type="number" name="urutan" value="{{ old('urutan', $editSkill->urutan ?? 0) }}" class="field"></div>
                    <button type="submit" class="btn-primary">{{ $editSkill ? 'Simpan Perubahan' : 'Tambah Keahlian' }}</button>
                </form>

                <div class="card overflow-x-auto">
                    <table class="min-w-full">
                        <thead><tr><th class="th">Nama</th><th class="th">Kategori</th><th class="th">Persentase</th><th class="th text-right">Aksi</th></tr></thead>
                        <tbody>
                            @forelse($skills as $skill)
                                <tr>
                                    <td class="td font-semibold">{{ $skill->nama }}</td>
                                    <td class="td"><span class="text-[10px] font-bold px-2 py-1 rounded-full {{ $skill->kategori === 'hard' ? 'bg-purple-100 text-purple-700' : 'bg-emerald-100 text-emerald-700' }}">{{ $skill->kategori === 'hard' ? 'Hard Skill' : 'Soft Skill' }}</span></td>
                                    <td class="td">{{ $skill->persentase }}%</td>
                                    <td class="td text-right whitespace-nowrap">
                                        <a href="{{ route('admin.dashboard', ['tab' => 'skills', 'type' => 'skill', 'edit' => $skill->id]) }}" class="btn-soft">Edit</a>
                                        <form action="{{ route('admin.skills.delete', $skill->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus keahlian ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="td text-center text-slate-400">Belum ada keahlian.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- ============================================================ --}}
            {{-- PROJECT --}}
            {{-- ============================================================ --}}
            @if($tab === 'projects')
                <form action="{{ $editProject ? route('projects.update', $editProject->id) : route('projects.store') }}" method="POST" enctype="multipart/form-data" class="card space-y-4">
                    @csrf
                    @if($editProject) @method('PUT') @endif
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold">{{ $editProject ? 'Edit Project' : 'Tambah Project Baru' }}</h2>
                        @if($editProject)<a href="{{ route('admin.dashboard', ['tab' => 'projects']) }}" class="btn-soft">Batal Edit</a>@endif
                    </div>

                    <div class="grid md:grid-cols-2 gap-3">
                        <div><label class="label">Judul Project</label><input type="text" name="judul" value="{{ old('judul', $editProject->judul ?? '') }}" class="field" required></div>
                        <div><label class="label">Kategori</label><input type="text" name="kategori" value="{{ old('kategori', $editProject->kategori ?? '') }}" placeholder="Contoh: UI/UX Design" class="field" required></div>
                        <div class="md:col-span-2"><label class="label">Deskripsi Proyek</label><textarea name="deskripsi" rows="2" class="field" required>{{ old('deskripsi', $editProject->deskripsi ?? '') }}</textarea></div>
                        <div><label class="label">Permasalahan yang Ingin Diselesaikan</label><textarea name="permasalahan" rows="2" class="field">{{ old('permasalahan', $editProject->permasalahan ?? '') }}</textarea></div>
                        <div><label class="label">Tujuan Dibuatnya Proyek</label><textarea name="tujuan" rows="2" class="field">{{ old('tujuan', $editProject->tujuan ?? '') }}</textarea></div>
                        <div><label class="label">Teknologi yang Digunakan</label><input type="text" name="teknologi" value="{{ old('teknologi', $editProject->teknologi ?? '') }}" class="field"></div>
                        <div><label class="label">Peran dalam Proyek</label><input type="text" name="peran" value="{{ old('peran', $editProject->peran ?? '') }}" class="field"></div>
                        <div class="md:col-span-2"><label class="label">Fitur-Fitur Proyek</label><textarea name="fitur_fitur" rows="2" class="field">{{ old('fitur_fitur', $editProject->fitur_fitur ?? '') }}</textarea></div>
                        <div class="md:col-span-2"><label class="label">Detail Proyek</label><textarea name="detail" rows="3" class="field">{{ old('detail', $editProject->detail ?? '') }}</textarea></div>
                        <div><label class="label">Link Demo</label><input type="text" name="link_demo" value="{{ old('link_demo', $editProject->link_demo ?? '') }}" class="field"></div>
                        <div><label class="label">Link Source Code GitHub</label><input type="text" name="link_github" value="{{ old('link_github', $editProject->link_github ?? '') }}" class="field"></div>
                        <div><label class="label">Dokumentasi Proses Pekerjaan</label><textarea name="dokumentasi" rows="2" class="field">{{ old('dokumentasi', $editProject->dokumentasi ?? '') }}</textarea></div>
                        <div><label class="label">Feedback User</label><textarea name="feedback_user" rows="2" class="field">{{ old('feedback_user', $editProject->feedback_user ?? '') }}</textarea></div>
                    </div>

                    <div>
                        <label class="label">Gambar / Screenshot Aplikasi</label>
                        <input type="file" name="gambar" accept="image/*" class="field file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-purple-100 file:text-purple-700">
                        @if($editProject && $editProject->gambar)
                            <div class="mt-2 flex items-center gap-3">
                                <img src="{{ asset('img/projects/' . $editProject->gambar) }}" class="w-24 h-16 rounded-xl object-cover" alt="Gambar project">
                                <span class="text-[10px] text-slate-400">Gambar saat ini. Unggah file baru untuk mengganti.</span>
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn-primary">{{ $editProject ? 'Simpan Perubahan Project' : 'Simpan Project Baru' }}</button>
                </form>

                <div class="card overflow-x-auto">
                    <table class="min-w-full">
                        <thead><tr><th class="th">Project</th><th class="th">Kategori</th><th class="th text-right">Aksi</th></tr></thead>
                        <tbody>
                            @forelse($projects as $project)
                                <tr>
                                    <td class="td">
                                        <div class="flex items-center gap-3">
                                            @if($project->gambar)
                                                <img src="{{ asset('img/projects/' . $project->gambar) }}" class="w-14 h-10 rounded-lg object-cover" alt="">
                                            @else
                                                <div class="w-14 h-10 rounded-lg bg-purple-100 dark:bg-slate-700 flex items-center justify-center text-purple-400"><i class="fa-regular fa-image"></i></div>
                                            @endif
                                            <div>
                                                <p class="font-semibold">{{ $project->judul ?? $project->nama_project }}</p>
                                                <p class="text-[10px] text-slate-400 line-clamp-1 max-w-xs">{{ $project->deskripsi }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="td">{{ $project->kategori }}</td>
                                    <td class="td text-right whitespace-nowrap">
                                        <a href="{{ route('admin.dashboard', ['tab' => 'projects', 'type' => 'project', 'edit' => $project->id]) }}" class="btn-soft">Edit</a>
                                        <form action="{{ route('projects.delete', $project->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus project ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="td text-center text-slate-400">Belum ada project.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- ============================================================ --}}
            {{-- SERTIFIKAT --}}
            {{-- ============================================================ --}}
            @if($tab === 'certificates')
                <form action="{{ $editCert ? route('certificates.update', $editCert->id) : route('certificates.store') }}" method="POST" enctype="multipart/form-data" class="card space-y-4">
                    @csrf
                    @if($editCert) @method('PUT') @endif
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold">{{ $editCert ? 'Edit Sertifikat / Prestasi' : 'Tambah Sertifikat / Prestasi' }}</h2>
                        @if($editCert)<a href="{{ route('admin.dashboard', ['tab' => 'certificates']) }}" class="btn-soft">Batal Edit</a>@endif
                    </div>
                    <div class="grid md:grid-cols-2 gap-3">
                        <div><label class="label">Nama Sertifikat / Prestasi</label><input type="text" name="nama_sertifikat" value="{{ old('nama_sertifikat', $editCert->nama_sertifikat ?? '') }}" class="field" required></div>
                        <div><label class="label">Pemberi / Lembaga</label><input type="text" name="pemberi" value="{{ old('pemberi', $editCert->pemberi ?? '') }}" class="field" required></div>
                        <div><label class="label">Tahun</label><input type="text" name="tahun" value="{{ old('tahun', $editCert->tahun ?? '') }}" class="field" required></div>
                        <div>
                            <label class="label">Jenis</label>
                            <select name="jenis" class="field">
                                <option value="Sertifikat" @selected(($editCert->jenis ?? 'Sertifikat') === 'Sertifikat')>Sertifikat</option>
                                <option value="Prestasi" @selected(($editCert->jenis ?? '') === 'Prestasi')>Prestasi</option>
                            </select>
                        </div>
                        <div class="md:col-span-2"><label class="label">Deskripsi / Dokumentasi</label><textarea name="deskripsi" rows="2" class="field">{{ old('deskripsi', $editCert->deskripsi ?? '') }}</textarea></div>
                    </div>
                    <div>
                        <label class="label">Gambar Sertifikat / Dokumentasi</label>
                        <input type="file" name="gambar" accept="image/*" class="field file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-purple-100 file:text-purple-700">
                        @if($editCert && $editCert->gambar)
                            <img src="{{ asset('img/certificates/' . $editCert->gambar) }}" class="mt-2 w-28 h-20 rounded-xl object-cover" alt="Sertifikat">
                        @endif
                    </div>
                    <button type="submit" class="btn-primary">{{ $editCert ? 'Simpan Perubahan' : 'Simpan Sertifikat' }}</button>
                </form>

                <div class="card overflow-x-auto">
                    <table class="min-w-full">
                        <thead><tr><th class="th">Sertifikat</th><th class="th">Tahun</th><th class="th text-right">Aksi</th></tr></thead>
                        <tbody>
                            @forelse($certificates as $cert)
                                <tr>
                                    <td class="td">
                                        <div class="flex items-center gap-3">
                                            @if($cert->gambar)
                                                <img src="{{ asset('img/certificates/' . $cert->gambar) }}" class="w-14 h-10 rounded-lg object-cover" alt="">
                                            @endif
                                            <div>
                                                <p class="font-semibold">{{ $cert->nama_sertifikat }}</p>
                                                <p class="text-[10px] text-slate-400">{{ $cert->pemberi }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="td">{{ $cert->tahun }}</td>
                                    <td class="td text-right whitespace-nowrap">
                                        <a href="{{ route('admin.dashboard', ['tab' => 'certificates', 'type' => 'certificate', 'edit' => $cert->id]) }}" class="btn-soft">Edit</a>
                                        <form action="{{ route('certificates.delete', $cert->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus sertifikat ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="td text-center text-slate-400">Belum ada sertifikat.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- ============================================================ --}}
            {{-- PENGALAMAN --}}
            {{-- ============================================================ --}}
            @if($tab === 'experiences')
                <form action="{{ $editExp ? route('admin.experiences.update', $editExp->id) : route('admin.experiences.store') }}" method="POST" enctype="multipart/form-data" class="card space-y-4">
                    @csrf
                    @if($editExp) @method('PUT') @endif
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold">{{ $editExp ? 'Edit Pengalaman' : 'Tambah Pengalaman' }}</h2>
                        @if($editExp)<a href="{{ route('admin.dashboard', ['tab' => 'experiences']) }}" class="btn-soft">Batal Edit</a>@endif
                    </div>
                    <div class="grid md:grid-cols-2 gap-3">
                        <div><label class="label">Judul Pengalaman</label><input type="text" name="judul" value="{{ old('judul', $editExp->judul ?? '') }}" placeholder="Contoh: Praktik Latihan Kerja (PLK)" class="field" required></div>
                        <div>
                            <label class="label">Jenis</label>
                            <select name="jenis" class="field">
                                <option value="plk" @selected(($editExp->jenis ?? 'plk') === 'plk')>PLK</option>
                                <option value="organisasi" @selected(($editExp->jenis ?? '') === 'organisasi')>Organisasi</option>
                                <option value="lomba" @selected(($editExp->jenis ?? '') === 'lomba')>Lomba</option>
                            </select>
                        </div>
                        <div><label class="label">Posisi</label><input type="text" name="posisi" value="{{ old('posisi', $editExp->posisi ?? '') }}" class="field"></div>
                        <div><label class="label">Institusi / Tempat</label><input type="text" name="institusi" value="{{ old('institusi', $editExp->institusi ?? '') }}" class="field"></div>
                        <div><label class="label">Periode</label><input type="text" name="periode" value="{{ old('periode', $editExp->periode ?? '') }}" placeholder="2024 - 2025" class="field"></div>
                        <div><label class="label">Urutan Tampil</label><input type="number" name="urutan" value="{{ old('urutan', $editExp->urutan ?? 0) }}" class="field"></div>
                        <div class="md:col-span-2"><label class="label">Deskripsi</label><textarea name="deskripsi" rows="3" class="field">{{ old('deskripsi', $editExp->deskripsi ?? '') }}</textarea></div>
                    </div>
                    <div>
                        <label class="label">Foto Bukti / Dokumentasi</label>
                        <input type="file" name="gambar" accept="image/*" class="field file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-purple-100 file:text-purple-700">
                        @if($editExp && $editExp->gambar)
                            <img src="{{ asset('img/experiences/' . $editExp->gambar) }}" class="mt-2 w-28 h-20 rounded-xl object-cover" alt="Dokumentasi">
                        @endif
                    </div>
                    <button type="submit" class="btn-primary">{{ $editExp ? 'Simpan Perubahan' : 'Tambah Pengalaman' }}</button>
                </form>

                <div class="card overflow-x-auto">
                    <table class="min-w-full">
                        <thead><tr><th class="th">Pengalaman</th><th class="th">Jenis</th><th class="th text-right">Aksi</th></tr></thead>
                        <tbody>
                            @forelse($experiences as $exp)
                                <tr>
                                    <td class="td">
                                        <div class="flex items-center gap-3">
                                            @if($exp->gambar)
                                                <img src="{{ asset('img/experiences/' . $exp->gambar) }}" class="w-14 h-10 rounded-lg object-cover" alt="">
                                            @endif
                                            <div>
                                                <p class="font-semibold">{{ $exp->judul }}</p>
                                                <p class="text-[10px] text-slate-400">{{ $exp->institusi }} {{ $exp->periode ? '• ' . $exp->periode : '' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="td uppercase text-[10px] font-bold">{{ $exp->jenis }}</td>
                                    <td class="td text-right whitespace-nowrap">
                                        <a href="{{ route('admin.dashboard', ['tab' => 'experiences', 'type' => 'experience', 'edit' => $exp->id]) }}" class="btn-soft">Edit</a>
                                        <form action="{{ route('admin.experiences.delete', $exp->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengalaman ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="td text-center text-slate-400">Belum ada pengalaman.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- ============================================================ --}}
            {{-- BLOG --}}
            {{-- ============================================================ --}}
            @if($tab === 'blog')
                <form action="{{ $editPost ? route('admin.posts.update', $editPost->id) : route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="card space-y-4">
                    @csrf
                    @if($editPost) @method('PUT') @endif
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold">{{ $editPost ? 'Edit Artikel Blog' : 'Tambah Artikel Blog' }}</h2>
                        @if($editPost)<a href="{{ route('admin.dashboard', ['tab' => 'blog']) }}" class="btn-soft">Batal Edit</a>@endif
                    </div>
                    <div class="grid md:grid-cols-2 gap-3">
                        <div class="md:col-span-2"><label class="label">Judul Artikel</label><input type="text" name="judul" value="{{ old('judul', $editPost->judul ?? '') }}" class="field" required></div>
                        <div><label class="label">Kategori</label><input type="text" name="kategori" value="{{ old('kategori', $editPost->kategori ?? '') }}" placeholder="UI/UX Workflow" class="field"></div>
                        <div><label class="label">Penulis</label><input type="text" name="penulis" value="{{ old('penulis', $editPost->penulis ?? 'Nurhaina') }}" class="field"></div>
                        <div><label class="label">Tanggal</label><input type="date" name="tanggal" value="{{ old('tanggal', optional($editPost->tanggal ?? null)->format('Y-m-d')) }}" class="field"></div>
                        <div class="flex items-end pb-2">
                            <label class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-300">
                                <input type="checkbox" name="published" value="1" class="rounded" @checked(!$editPost || $editPost->published)>
                                Tampilkan di website
                            </label>
                        </div>
                        <div class="md:col-span-2"><label class="label">Ringkasan</label><textarea name="ringkasan" rows="2" class="field">{{ old('ringkasan', $editPost->ringkasan ?? '') }}</textarea></div>
                        <div class="md:col-span-2"><label class="label">Isi Artikel</label><textarea name="konten" rows="8" class="field" required>{{ old('konten', $editPost->konten ?? '') }}</textarea></div>
                    </div>
                    <div>
                        <label class="label">Gambar Artikel (opsional)</label>
                        <input type="file" name="gambar" accept="image/*" class="field file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-purple-100 file:text-purple-700">
                        @if($editPost && $editPost->gambar)
                            <img src="{{ asset('img/posts/' . $editPost->gambar) }}" class="mt-2 w-28 h-20 rounded-xl object-cover" alt="Artikel">
                        @endif
                    </div>
                    <button type="submit" class="btn-primary">{{ $editPost ? 'Simpan Perubahan' : 'Simpan Artikel' }}</button>
                </form>

                <div class="card overflow-x-auto">
                    <table class="min-w-full">
                        <thead><tr><th class="th">Artikel</th><th class="th">Tanggal</th><th class="th">Status</th><th class="th text-right">Aksi</th></tr></thead>
                        <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td class="td"><p class="font-semibold">{{ $post->judul }}</p><p class="text-[10px] text-slate-400">{{ $post->kategori }}</p></td>
                                    <td class="td">{{ optional($post->tanggal)->format('d M Y') ?: '-' }}</td>
                                    <td class="td"><span class="text-[10px] font-bold px-2 py-1 rounded-full {{ $post->published ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $post->published ? 'Tampil' : 'Draft' }}</span></td>
                                    <td class="td text-right whitespace-nowrap">
                                        <a href="{{ route('blog.show', $post->id) }}" target="_blank" class="btn-soft">Lihat</a>
                                        <a href="{{ route('admin.dashboard', ['tab' => 'blog', 'type' => 'post', 'edit' => $post->id]) }}" class="btn-soft">Edit</a>
                                        <form action="{{ route('admin.posts.delete', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus artikel ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="td text-center text-slate-400">Belum ada artikel.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- ============================================================ --}}
            {{-- TESTIMONI --}}
            {{-- ============================================================ --}}
            @if($tab === 'testimonials')
                <div class="bg-purple-100/60 dark:bg-purple-950/30 border border-purple-200 dark:border-purple-900 text-purple-700 dark:text-purple-300 px-5 py-3.5 rounded-2xl text-xs">
                    Testimoni yang tampil di website hanya testimoni asli yang dikirim pengunjung atau yang kamu tambahkan di sini. Tidak ada testimoni contoh.
                </div>

                <form action="{{ $editTesti ? route('admin.testimonials.update', $editTesti->id) : route('admin.testimonials.store') }}" method="POST" class="card space-y-4">
                    @csrf
                    @if($editTesti) @method('PUT') @endif
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold">{{ $editTesti ? 'Edit Testimoni' : 'Tambah Testimoni' }}</h2>
                        @if($editTesti)<a href="{{ route('admin.dashboard', ['tab' => 'testimonials']) }}" class="btn-soft">Batal Edit</a>@endif
                    </div>
                    <div class="grid md:grid-cols-3 gap-3">
                        <div><label class="label">Nama</label><input type="text" name="nama" value="{{ old('nama', $editTesti->nama ?? '') }}" class="field" required></div>
                        <div>
                            <label class="label">Profesi / Peran</label>
                            <select name="profesi" class="field">
                                @foreach(['Pengunjung', 'Guru Pembimbing', 'Teman', 'Tempat PLK'] as $profesi)
                                    <option value="{{ $profesi }}" @selected(($editTesti->profesi ?? 'Pengunjung') === $profesi)>{{ $profesi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="label">Sumber</label>
                            <select name="sumber" class="field">
                                <option value="admin" @selected(($editTesti->sumber ?? 'admin') === 'admin')>Admin</option>
                                <option value="pengunjung" @selected(($editTesti->sumber ?? '') === 'pengunjung')>Pengunjung</option>
                            </select>
                        </div>
                        <div class="md:col-span-3"><label class="label">Isi Testimoni</label><textarea name="pesan" rows="3" class="field" required>{{ old('pesan', $editTesti->pesan ?? '') }}</textarea></div>
                    </div>
                    <label class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-300">
                        <input type="checkbox" name="is_visible" value="1" class="rounded" @checked(!$editTesti || $editTesti->is_visible)>
                        Tampilkan testimoni di website
                    </label>
                    <button type="submit" class="btn-primary">{{ $editTesti ? 'Simpan Perubahan' : 'Tambah Testimoni' }}</button>
                </form>

                <div class="card overflow-x-auto">
                    <table class="min-w-full">
                        <thead><tr><th class="th">Nama</th><th class="th">Testimoni</th><th class="th">Status</th><th class="th text-right">Aksi</th></tr></thead>
                        <tbody>
                            @forelse($testimonials as $testi)
                                <tr>
                                    <td class="td"><p class="font-semibold">{{ $testi->nama }}</p><p class="text-[10px] text-slate-400">{{ $testi->profesi }}</p></td>
                                    <td class="td max-w-sm"><p class="line-clamp-2 text-slate-500 dark:text-slate-300">"{{ $testi->pesan }}"</p></td>
                                    <td class="td"><span class="text-[10px] font-bold px-2 py-1 rounded-full {{ $testi->is_visible ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $testi->is_visible ? 'Tampil' : 'Disembunyikan' }}</span></td>
                                    <td class="td text-right whitespace-nowrap">
                                        <a href="{{ route('admin.dashboard', ['tab' => 'testimonials', 'type' => 'testimonial', 'edit' => $testi->id]) }}" class="btn-soft">Edit</a>
                                        <form action="{{ route('testimonial.delete', $testi->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus testimoni ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="td text-center text-slate-400">Belum ada testimoni masuk.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- ============================================================ --}}
            {{-- PESAN MASUK --}}
            {{-- ============================================================ --}}
            @if($tab === 'messages')
                <div class="card overflow-x-auto">
                    <table class="min-w-full">
                        <thead><tr><th class="th">Pengirim</th><th class="th">Email</th><th class="th">Pesan</th><th class="th">Waktu</th><th class="th text-right">Aksi</th></tr></thead>
                        <tbody>
                            @forelse($messages as $msg)
                                <tr>
                                    <td class="td font-semibold whitespace-nowrap">{{ $msg->nama_pengirim }}</td>
                                    <td class="td whitespace-nowrap">{{ $msg->email ?: '-' }}</td>
                                    <td class="td max-w-md text-slate-500 dark:text-slate-300">{{ $msg->pesan }}</td>
                                    <td class="td whitespace-nowrap text-slate-400">{{ $msg->created_at->diffForHumans() }}</td>
                                    <td class="td text-right whitespace-nowrap">
                                        <form action="{{ route('pesan.delete', $msg->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pesan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="td text-center text-slate-400">Belum ada pesan masuk.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            <footer class="text-center text-[10px] text-slate-400 py-4">
                Dashboard Admin Portofolio • Nurhaina
            </footer>
        </div>
    </main>
</div>

<script>
    function toggleAdminTheme() {
        const html = document.documentElement;
        const icon = document.getElementById('admin-theme-icon');
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.theme = 'light';
            if (icon) icon.className = 'fa-solid fa-moon text-xs';
        } else {
            html.classList.add('dark');
            localStorage.theme = 'dark';
            if (icon) icon.className = 'fa-solid fa-sun text-xs text-yellow-400';
        }
    }

    const adminThemeIcon = document.getElementById('admin-theme-icon');
    if (document.documentElement.classList.contains('dark') && adminThemeIcon) {
        adminThemeIcon.className = 'fa-solid fa-sun text-xs text-yellow-400';
    }
</script>
</body>
</html>
