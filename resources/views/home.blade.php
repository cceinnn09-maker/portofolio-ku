<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['site_title'] ?? 'Portofolio | Nurhaina' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Animasi halaman: HANYA opacity, tanpa transform,
           supaya elemen position: fixed tetap menempel di layar. */
        body {
            opacity: 0;
            animation: pageFadeIn 0.5s ease forwards;
        }
        body.page-leaving { animation: pageFadeOut 0.3s ease forwards; }
        @keyframes pageFadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes pageFadeOut { from { opacity: 1; } to { opacity: 0; } }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.6s ease, transform 0.6s ease;
            will-change: opacity, transform;
        }
        .reveal.revealed { opacity: 1; transform: translateY(0); }

        @keyframes toastIn { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .toast { animation: toastIn 0.35s ease; }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ============================================================
           IKON TEMA (dark / light)
           ============================================================ */
        .theme-icon {
            font-size: 13px;
            line-height: 1;
            transition: transform 0.4s ease;
        }
        .theme-toggle:hover .theme-icon { transform: rotate(25deg) scale(1.05); }

        /* ============================================================
           INDIKATOR NAVBAR AKTIF
           ============================================================ */
        .nav-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            transition: color 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
        }
        .nav-link.nav-active {
            color: #7c3aed;
            background-color: #f3e8ff;
            box-shadow: inset 0 0 0 1px #e9d5ff;
        }
        html.dark .nav-link.nav-active {
            color: #e9d5ff;
            background-color: rgba(124, 58, 237, 0.22);
            box-shadow: inset 0 0 0 1px rgba(167, 139, 250, 0.35);
        }
        .mobile-link.nav-active {
            color: #7c3aed;
            background-color: #faf5ff;
            font-weight: 700;
        }
        html.dark .mobile-link.nav-active {
            color: #e9d5ff;
            background-color: rgba(124, 58, 237, 0.18);
        }

        /* ============================================================
           LIGHT MODE: bayangan card lebih tegas & kontras lebih nyaman
           ============================================================ */
        html:not(.dark) body {
            background-color: #f7f4fd;
        }
        html:not(.dark) .shadow-sm {
            box-shadow:
                0 6px 22px -10px rgba(88, 28, 135, 0.28),
                0 2px 6px -3px rgba(88, 28, 135, 0.12);
        }
        html:not(.dark) .shadow-md {
            box-shadow:
                0 12px 30px -12px rgba(88, 28, 135, 0.32),
                0 4px 10px -4px rgba(88, 28, 135, 0.16);
        }
        html:not(.dark) .shadow-xl {
            box-shadow:
                0 26px 55px -20px rgba(88, 28, 135, 0.34),
                0 12px 24px -14px rgba(88, 28, 135, 0.18);
        }
        /* Garis tepi card sedikit lebih jelas di light mode */
        html:not(.dark) .border-purple-100 { border-color: #e6d9f8; }
        /* Teks sekunder dinaikkan kontrasnya agar tidak menyatu dengan background */
        html:not(.dark) .text-slate-400 { color: #64748b; }
        html:not(.dark) .text-slate-500 { color: #475569; }

        /* ============================================================
           HORMATI PREFERENSI REDUCED MOTION
           ============================================================ */
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            body { animation: none; opacity: 1; }
            .reveal { opacity: 1; transform: none; transition: none; }
        }
    </style>
</head>
<body class="bg-purple-50/30 dark:bg-slate-900 text-slate-800 dark:text-slate-100 font-[Poppins] transition-colors duration-300">

@php
    $photoUrl = asset('img/ennnaa.jpg');
    if ($profile && $profile->foto) {
        if (file_exists(public_path('img/profiles/' . $profile->foto))) {
            $photoUrl = asset('img/profiles/' . $profile->foto);
        } elseif (file_exists(public_path('img/' . $profile->foto))) {
            $photoUrl = asset('img/' . $profile->foto);
        }
    }
    $nama = $profile->nama_lengkap ?? 'Nurhaina';
    $hardSkills = $skills->where('kategori', 'hard');
    $softSkills = $skills->where('kategori', 'soft');
    $plkExperiences = $experiences->where('jenis', 'plk');
    $organisasiExperiences = $experiences->where('jenis', 'organisasi');
    $lombaExperiences = $experiences->where('jenis', 'lomba');
@endphp

<!-- NAVBAR -->
<header class="fixed top-0 left-0 w-full z-50 flex justify-center py-3 px-4">
    <nav class="w-full max-w-6xl relative">
        <!-- Desktop -->
        <ul class="hidden lg:flex items-center justify-center gap-0.5 bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl px-3 py-2 rounded-full shadow-lg shadow-purple-900/5 border border-purple-100/80 dark:border-slate-700/80 text-[13px]">
            <li><a href="#beranda" data-nav-link="beranda" class="nav-link px-3.5 py-2 font-medium text-slate-600 dark:text-slate-300 hover:text-purple-600 dark:hover:text-purple-300 hover:bg-purple-50 dark:hover:bg-slate-700/60 whitespace-nowrap">Beranda</a></li>
            <li><a href="#tentang" data-nav-link="tentang" class="nav-link px-3.5 py-2 font-medium text-slate-600 dark:text-slate-300 hover:text-purple-600 dark:hover:text-purple-300 hover:bg-purple-50 dark:hover:bg-slate-700/60 whitespace-nowrap">Tentang</a></li>
            <li><a href="#skills" data-nav-link="skills" class="nav-link px-3.5 py-2 font-medium text-slate-600 dark:text-slate-300 hover:text-purple-600 dark:hover:text-purple-300 hover:bg-purple-50 dark:hover:bg-slate-700/60 whitespace-nowrap">Skills</a></li>
            <li><a href="#project" data-nav-link="project" class="nav-link px-3.5 py-2 font-medium text-slate-600 dark:text-slate-300 hover:text-purple-600 dark:hover:text-purple-300 hover:bg-purple-50 dark:hover:bg-slate-700/60 whitespace-nowrap">Project</a></li>
            <li><a href="#sertifikat" data-nav-link="sertifikat" class="nav-link px-3.5 py-2 font-medium text-slate-600 dark:text-slate-300 hover:text-purple-600 dark:hover:text-purple-300 hover:bg-purple-50 dark:hover:bg-slate-700/60 whitespace-nowrap">Sertifikat</a></li>
            <li><a href="#pengalaman" data-nav-link="pengalaman" class="nav-link px-3.5 py-2 font-medium text-slate-600 dark:text-slate-300 hover:text-purple-600 dark:hover:text-purple-300 hover:bg-purple-50 dark:hover:bg-slate-700/60 whitespace-nowrap">Pengalaman</a></li>
            <li><a href="#cv" data-nav-link="cv" class="nav-link px-3.5 py-2 font-medium text-slate-600 dark:text-slate-300 hover:text-purple-600 dark:hover:text-purple-300 hover:bg-purple-50 dark:hover:bg-slate-700/60 whitespace-nowrap">CV</a></li>
            <li><a href="#blog" data-nav-link="blog" class="nav-link px-3.5 py-2 font-medium text-slate-600 dark:text-slate-300 hover:text-purple-600 dark:hover:text-purple-300 hover:bg-purple-50 dark:hover:bg-slate-700/60 whitespace-nowrap">Blog</a></li>
            <li><a href="#testimoni" data-nav-link="testimoni" class="nav-link px-3.5 py-2 font-medium text-slate-600 dark:text-slate-300 hover:text-purple-600 dark:hover:text-purple-300 hover:bg-purple-50 dark:hover:bg-slate-700/60 whitespace-nowrap">Testimoni</a></li>
            <li><a href="#kontak" data-nav-link="kontak" class="nav-link px-3.5 py-2 font-medium text-slate-600 dark:text-slate-300 hover:text-purple-600 dark:hover:text-purple-300 hover:bg-purple-50 dark:hover:bg-slate-700/60 whitespace-nowrap">Kontak</a></li>
            <li class="ml-1">
                <button type="button" onclick="toggleDarkMode()" class="theme-toggle group w-9 h-9 rounded-full bg-gradient-to-br from-purple-100 to-purple-200 dark:from-slate-700 dark:to-slate-800 text-purple-600 dark:text-amber-300 flex items-center justify-center ring-1 ring-purple-200/80 dark:ring-slate-600/80 hover:ring-purple-400 hover:scale-105 transition-all duration-300" title="Ganti Tema" aria-label="Ganti tema terang/gelap">
                    <i id="theme-icon" class="theme-icon fa-solid fa-moon"></i>
                </button>
            </li>
            @auth
                <li class="ml-1"><a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-full bg-purple-50 dark:bg-slate-700 text-purple-700 dark:text-purple-300 font-bold hover:bg-purple-100 dark:hover:bg-slate-600 transition whitespace-nowrap">Admin</a></li>
                <li class="border-l border-purple-200 dark:border-slate-700 pl-2 ml-1">
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 text-[11px] font-bold hover:underline">Logout</button>
                    </form>
                </li>
            @else
                <li class="ml-1"><a href="/login" class="bg-purple-500 text-white px-4 py-2 rounded-full text-[11px] font-bold hover:bg-purple-600 transition shadow-md shadow-purple-500/25 whitespace-nowrap">Login</a></li>
            @endauth
        </ul>

        <!-- Mobile -->
        <div class="lg:hidden flex items-center justify-between bg-white/90 dark:bg-slate-800/90 backdrop-blur-md px-5 py-3 rounded-full shadow-lg shadow-purple-900/5 border border-purple-100/80 dark:border-slate-700">
            <a href="#beranda" class="text-sm font-bold text-purple-600 dark:text-purple-300">{{ $nama }} ✦</a>
            <button type="button" onclick="toggleMobileMenu()" class="w-9 h-9 rounded-full bg-gradient-to-br from-purple-100 to-purple-200 dark:from-slate-700 dark:to-slate-800 flex items-center justify-center text-purple-600 dark:text-purple-300 ring-1 ring-purple-200/80 dark:ring-slate-600/80 transition" title="Menu" aria-label="Buka menu" aria-expanded="false">
                <i id="menu-icon" class="fa-solid fa-bars text-xs"></i>
            </button>
        </div>

        <!-- Dropdown mobile: absolute supaya mengambang di atas konten -->
        <div id="mobile-menu" class="lg:hidden hidden absolute top-full left-0 right-0 mt-2 z-50 bg-white dark:bg-slate-800 rounded-3xl shadow-2xl border border-purple-100 dark:border-slate-700 p-4 max-h-[75vh] overflow-y-auto">
            <ul class="flex flex-col text-xs font-medium divide-y divide-purple-50 dark:divide-slate-700">
                <li><a href="#beranda" data-nav-link="beranda" onclick="toggleMobileMenu()" class="mobile-link block px-3 py-2.5 rounded-xl hover:text-purple-500 transition">Beranda</a></li>
                <li><a href="#tentang" data-nav-link="tentang" onclick="toggleMobileMenu()" class="mobile-link block px-3 py-2.5 rounded-xl hover:text-purple-500 transition">Tentang</a></li>
                <li><a href="#skills" data-nav-link="skills" onclick="toggleMobileMenu()" class="mobile-link block px-3 py-2.5 rounded-xl hover:text-purple-500 transition">Skills</a></li>
                <li><a href="#project" data-nav-link="project" onclick="toggleMobileMenu()" class="mobile-link block px-3 py-2.5 rounded-xl hover:text-purple-500 transition">Project</a></li>
                <li><a href="#sertifikat" data-nav-link="sertifikat" onclick="toggleMobileMenu()" class="mobile-link block px-3 py-2.5 rounded-xl hover:text-purple-500 transition">Sertifikat</a></li>
                <li><a href="#pengalaman" data-nav-link="pengalaman" onclick="toggleMobileMenu()" class="mobile-link block px-3 py-2.5 rounded-xl hover:text-purple-500 transition">Pengalaman</a></li>
                <li><a href="#cv" data-nav-link="cv" onclick="toggleMobileMenu()" class="mobile-link block px-3 py-2.5 rounded-xl hover:text-purple-500 transition">CV Digital</a></li>
                <li><a href="#blog" data-nav-link="blog" onclick="toggleMobileMenu()" class="mobile-link block px-3 py-2.5 rounded-xl hover:text-purple-500 transition">Blog</a></li>
                <li><a href="#testimoni" data-nav-link="testimoni" onclick="toggleMobileMenu()" class="mobile-link block px-3 py-2.5 rounded-xl hover:text-purple-500 transition">Testimoni</a></li>
                <li><a href="#kontak" data-nav-link="kontak" onclick="toggleMobileMenu()" class="mobile-link block px-3 py-2.5 rounded-xl hover:text-purple-500 transition">Kontak</a></li>
            </ul>
            <div class="flex items-center justify-between pt-3 mt-2 border-t border-purple-50 dark:border-slate-700">
                <button type="button" onclick="toggleDarkMode(); toggleMobileMenu();" class="theme-toggle w-9 h-9 rounded-full bg-gradient-to-br from-purple-100 to-purple-200 dark:from-slate-700 dark:to-slate-800 flex items-center justify-center text-purple-600 dark:text-amber-300 ring-1 ring-purple-200/80 dark:ring-slate-600/80 transition" title="Ganti Tema" aria-label="Ganti tema terang/gelap">
                    <i class="theme-icon fa-solid fa-moon"></i>
                </button>
                @auth
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.dashboard') }}" class="text-[10px] bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 font-bold px-2 py-1 rounded-full">Dashboard Admin</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-red-500 text-[10px] font-bold hover:underline">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="/login" class="bg-purple-500 text-white px-4 py-1.5 rounded-full text-[10px] font-bold hover:bg-purple-600 transition shadow-sm">Login</a>
                @endauth
            </div>
        </div>
    </nav>
</header>

<!-- NOTIFIKASI -->
@if(session('success'))
    <div class="toast fixed bottom-5 right-5 z-[70] bg-purple-500 text-white px-6 py-3.5 rounded-2xl shadow-xl font-medium text-sm flex items-center gap-2">
        ✦ {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="toast fixed bottom-5 right-5 z-[70] bg-rose-500 text-white px-6 py-3.5 rounded-2xl shadow-xl font-medium text-sm flex items-center gap-2">
        {{ session('error') }}
    </div>
@endif

<!-- A. BERANDA -->
<section id="beranda" class="min-h-screen flex items-center justify-center pt-28 px-4 scroll-mt-24">
    <div class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl p-8 md:p-14 rounded-[3rem] shadow-xl max-w-5xl w-full border border-purple-100/50 dark:border-slate-700 flex flex-col md:flex-row items-center justify-between gap-10">
        <div class="space-y-4 text-center md:text-left">
            <p class="text-purple-400 font-medium text-lg">{{ $settings['hero_greeting'] ?? 'Hallo, Saya' }}</p>
            <h1 class="text-4xl md:text-5xl font-bold tracking-tight">{{ $nama }}</h1>
            <p class="text-slate-600 dark:text-slate-300 text-base md:text-lg font-light">
                {{ $settings['hero_subtitle'] ?? 'Siswi SMK Negeri 2 Banjarmasin' }}
                @if($profile && ($profile->kelas || $profile->kompetensi_keahlian))
                    <br>
                    <span class="text-purple-500 font-medium">
                        {{ $profile->kelas ? $profile->kelas . ' • ' : '' }}{{ $profile->kompetensi_keahlian }}
                    </span>
                @endif
            </p>
            <p class="text-xs text-slate-500 dark:text-slate-400 max-w-md">
                {{ $settings['hero_description'] ?? $profile->deskripsi_singkat ?? '' }}
            </p>

            <div class="flex flex-wrap gap-3 justify-center md:justify-start pt-2">
                <a href="#project" class="bg-purple-500 text-white px-6 py-3 rounded-2xl text-sm font-medium shadow-md hover:bg-purple-600 transition">
                    Lihat Portofolio
                </a>
                @if($profile && $profile->file_cv)
                    <button type="button" onclick="openCvModal()" class="bg-purple-100 dark:bg-slate-700 text-purple-700 dark:text-purple-300 px-6 py-3 rounded-2xl text-sm font-medium hover:bg-purple-200 transition flex items-center gap-2">
                        <i class="fa-solid fa-file-lines"></i> Lihat CV
                    </button>
                @else
                    <a href="#cv" class="bg-purple-100 dark:bg-slate-700 text-purple-700 dark:text-purple-300 px-6 py-3 rounded-2xl text-sm font-medium hover:bg-purple-200 transition flex items-center gap-2">
                        <i class="fa-solid fa-file-lines"></i> Lihat CV
                    </a>
                @endif
                <a href="#kontak" class="bg-white dark:bg-slate-800 border border-purple-200 dark:border-slate-700 text-purple-600 dark:text-purple-300 px-6 py-3 rounded-2xl text-sm font-medium shadow-sm hover:bg-purple-50 dark:hover:bg-slate-700 transition flex items-center gap-2">
                    <i class="fa-solid fa-envelope text-xs"></i> Hubungi Saya
                </a>
            </div>
        </div>
        <div class="w-52 h-52 md:w-64 md:h-64 rounded-full overflow-hidden border-4 border-purple-200 dark:border-purple-900 shadow-lg flex-shrink-0">
            <img src="{{ $photoUrl }}" alt="{{ $nama }}" class="w-full h-full object-cover">
        </div>
    </div>
</section>

<!-- B. TENTANG SAYA -->
<section id="tentang" class="py-24 bg-white dark:bg-slate-800/50 scroll-mt-24">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold">Tentang Saya <span class="text-purple-400">✦</span></h2>
            <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-sm md:text-base font-light max-w-2xl mx-auto mt-4">
                {{ $settings['about_intro'] ?? $profile->about_text ?? '' }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
            <!-- Biodata -->
            <div class="bg-purple-50/50 dark:bg-slate-800 p-6 rounded-3xl border border-purple-100 dark:border-slate-700">
                <h3 class="font-bold text-purple-600 dark:text-purple-400 mb-3"><i class="fa-solid fa-id-card mr-2"></i> Biodata Singkat</h3>
                <div class="space-y-1.5 text-xs text-slate-500 dark:text-slate-400">
                    <p><strong class="text-slate-700 dark:text-slate-200">Nama:</strong> {{ $nama }}</p>
                    <p><strong class="text-slate-700 dark:text-slate-200">Kelas:</strong> {{ $profile->kelas ?? '-' }}</p>
                    <p><strong class="text-slate-700 dark:text-slate-200">Kompetensi Keahlian:</strong> {{ $profile->kompetensi_keahlian ?? '-' }}</p>
                    <p><strong class="text-slate-700 dark:text-slate-200">Domisili:</strong> {{ $profile->alamat ?? 'Banjarmasin, Kalimantan Selatan' }}</p>
                    @if($profile && $profile->tempat_lahir)
                        <p><strong class="text-slate-700 dark:text-slate-200">Tempat Lahir:</strong> {{ $profile->tempat_lahir }}</p>
                    @endif
                    @if($profile && $profile->email)
                        <p><strong class="text-slate-700 dark:text-slate-200">Email:</strong> {{ $profile->email }}</p>
                    @endif
                </div>
            </div>

            <!-- Pendidikan -->
            <div class="bg-purple-50/50 dark:bg-slate-800 p-6 rounded-3xl border border-purple-100 dark:border-slate-700">
                <h3 class="font-bold text-purple-600 dark:text-purple-400 mb-3"><i class="fa-solid fa-graduation-cap mr-2"></i> Riwayat Pendidikan</h3>
                <div class="space-y-3">
                    @forelse($educations as $education)
                        <div class="flex items-start gap-3">
                            <span class="text-[9px] font-bold bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-2 py-1 rounded-full mt-0.5">{{ $education->jenjang }}</span>
                            <div>
                                <p class="text-xs font-semibold text-slate-700 dark:text-slate-200">{{ $education->institusi }}</p>
                                <p class="text-[10px] text-slate-400">{{ $education->periode ?: '—' }} @if($education->keterangan) • {{ $education->keterangan }} @endif</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic">Belum ada riwayat pendidikan.</p>
                    @endforelse
                </div>
            </div>

            <!-- Minat -->
            <div class="bg-purple-50/50 dark:bg-slate-800 p-6 rounded-3xl border border-purple-100 dark:border-slate-700">
                <h3 class="font-bold text-purple-600 dark:text-purple-400 mb-2"><i class="fa-solid fa-heart mr-2"></i> Minat & Teknologi Dikuasai</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    {{ $profile->minat_teknologi ?? 'UI/UX Design, Figma, HTML, CSS, Bootstrap, dasar Laravel, dan MySQL.' }}
                </p>
            </div>

            <!-- Keahlian utama -->
            <div class="bg-purple-50/50 dark:bg-slate-800 p-6 rounded-3xl border border-purple-100 dark:border-slate-700">
                <h3 class="font-bold text-purple-600 dark:text-purple-400 mb-2"><i class="fa-solid fa-wand-magic-sparkles mr-2"></i> Keahlian Utama</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    {{ $profile->keahlian_utama ?? 'UI/UX Wireframing & Design, User Research, dan Perancangan Layout Antarmuka.' }}
                </p>
            </div>

            <!-- Organisasi -->
            <div class="bg-purple-50/50 dark:bg-slate-800 p-6 rounded-3xl border border-purple-100 dark:border-slate-700">
                <h3 class="font-bold text-purple-600 dark:text-purple-400 mb-3"><i class="fa-solid fa-users mr-2"></i> Pengalaman Organisasi / Kepanitiaan</h3>
                <div class="space-y-3">
                    @forelse($organisasiExperiences as $org)
                        <div>
                            <p class="text-xs font-semibold text-slate-700 dark:text-slate-200">{{ $org->posisi ?: $org->judul }}</p>
                            <p class="text-[10px] text-purple-500 font-medium">{{ $org->institusi }} @if($org->periode) • {{ $org->periode }} @endif</p>
                            @if($org->deskripsi)
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">{{ $org->deskripsi }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic">Belum ada pengalaman organisasi.</p>
                    @endforelse
                </div>
            </div>

            <!-- Cita-cita -->
            <div class="bg-purple-50/50 dark:bg-slate-800 p-6 rounded-3xl border border-purple-100 dark:border-slate-700">
                <h3 class="font-bold text-purple-600 dark:text-purple-400 mb-2"><i class="fa-solid fa-rocket mr-2"></i> Cita-Cita / Tujuan Karir</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    {{ $profile->cita_cita ?? 'Menjadi UI/UX Designer profesional yang menghadirkan pengalaman pengguna yang intuitif dan menarik.' }}
                </p>
            </div>
        </div>

        <!-- Pengalaman PLK -->
        <div class="mt-6 bg-purple-50/50 dark:bg-slate-800 p-6 md:p-8 rounded-3xl border border-purple-100 dark:border-slate-700">
            <h3 class="font-bold text-purple-600 dark:text-purple-400 mb-4"><i class="fa-solid fa-briefcase mr-2"></i> Pengalaman PLK (Praktik Latihan Kerja)</h3>
            @forelse($plkExperiences as $plk)
                <div class="flex flex-col md:flex-row gap-5">
                    @if($plk->gambar)
                        <button type="button" onclick="openImagePreview('{{ asset('img/experiences/' . $plk->gambar) }}', '{{ addslashes($plk->judul) }}')" class="w-full md:w-56 h-40 rounded-2xl overflow-hidden bg-purple-100 dark:bg-slate-700 flex-shrink-0">
                            <img src="{{ asset('img/experiences/' . $plk->gambar) }}" alt="{{ $plk->judul }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        </button>
                    @endif
                    <div>
                        <h4 class="font-bold text-base">{{ $plk->judul }}</h4>
                        <p class="text-xs text-purple-500 font-medium mb-2">{{ $plk->posisi ? $plk->posisi . ' • ' : '' }}{{ $plk->institusi }} @if($plk->periode) • {{ $plk->periode }} @endif</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ $plk->deskripsi }}</p>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 italic">Belum ada pengalaman PLK.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- C. KEAHLIAN / SKILLS -->
<section id="skills" class="py-24 scroll-mt-24">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold">Keahlian & Skills <span class="text-purple-400">✦</span></h2>
            <p class="text-xs text-slate-400 mt-1">Hard skill dan soft skill yang saya kuasai</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] shadow-sm border border-purple-100 dark:border-slate-700 space-y-5">
                <h3 class="font-bold text-lg text-purple-600 dark:text-purple-400 mb-2">Hard Skills</h3>
                @forelse($hardSkills as $skill)
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1"><span>{{ $skill->nama }}</span><span>{{ $skill->persentase }}%</span></div>
                        <div class="w-full bg-purple-100 dark:bg-slate-700 h-2.5 rounded-full overflow-hidden"><div class="bg-purple-500 h-full rounded-full" style="width: {{ $skill->persentase }}%"></div></div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic">Belum ada hard skill.</p>
                @endforelse
            </div>

            <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] shadow-sm border border-purple-100 dark:border-slate-700 space-y-5">
                <h3 class="font-bold text-lg text-purple-600 dark:text-purple-400 mb-2">Soft Skills</h3>
                @forelse($softSkills as $skill)
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1"><span>{{ $skill->nama }}</span><span>{{ $skill->persentase }}%</span></div>
                        <div class="w-full bg-purple-100 dark:bg-slate-700 h-2.5 rounded-full overflow-hidden"><div class="bg-purple-400 h-full rounded-full" style="width: {{ $skill->persentase }}%"></div></div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic">Belum ada soft skill.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- D. GALERI PROJEK -->
<section id="project" class="py-24 bg-white dark:bg-slate-800/50 scroll-mt-24">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold">Project Saya <span class="text-purple-400">✦</span></h2>
            <p class="text-xs text-slate-400 mt-1">Koleksi karya desain UI/UX dan sistem aplikasi</p>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-10 max-w-3xl mx-auto">
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i class="fa-solid fa-search text-xs"></i></span>
                <input type="text" id="searchProject" onkeyup="filterProjects()" placeholder="Cari judul project..." class="w-full bg-purple-50/40 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-2xl pl-10 pr-4 py-3 text-xs outline-none focus:border-purple-400 transition">
            </div>
            <div class="flex flex-wrap gap-2 w-full md:w-auto justify-center">
                <button onclick="filterCategory('all')" data-filter="all" class="filter-btn px-5 py-2.5 rounded-2xl text-xs font-bold bg-purple-500 text-white transition shadow-sm">Semua</button>
                @foreach($projects->pluck('kategori')->filter()->unique() as $category)
                    <button onclick="filterCategory('{{ \Illuminate\Support\Str::slug($category) }}')" data-filter="{{ \Illuminate\Support\Str::slug($category) }}" class="filter-btn px-5 py-2.5 rounded-2xl text-xs font-bold bg-purple-100 dark:bg-slate-700 text-purple-600 dark:text-purple-300 transition hover:bg-purple-200">{{ $category }}</button>
                @endforeach
            </div>
        </div>

        <div id="projectGrid" class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($projects as $project)
                @php
                    $projectTitle = $project->judul ?? $project->nama_project ?? 'Project';
                    $projectImage = $project->gambar ? asset('img/projects/' . $project->gambar) : asset('img/ennnaa.jpg');
                    $projectData = [
                        'judul' => $projectTitle,
                        'kategori' => $project->kategori ?? 'Project',
                        'gambar' => $projectImage,
                        'deskripsi' => $project->deskripsi ?? '',
                        'permasalahan' => $project->permasalahan ?? '',
                        'tujuan' => $project->tujuan ?? '',
                        'teknologi' => $project->teknologi ?? '',
                        'peran' => $project->peran ?? '',
                        'fitur_fitur' => $project->fitur_fitur ?? '',
                        'link_demo' => $project->link_demo ?? '',
                        'link_github' => $project->link_github ?? '',
                        'dokumentasi' => $project->dokumentasi ?? '',
                        'detail' => $project->detail ?? '',
                        'feedback_user' => $project->feedback_user ?? '',
                    ];
                @endphp
                <div class="project-card bg-purple-50/30 dark:bg-slate-800 rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-purple-100 dark:border-slate-700 flex flex-col justify-between"
                     data-category="{{ \Illuminate\Support\Str::slug($project->kategori ?? 'project') }}"
                     data-title="{{ strtolower($projectTitle) }}">
                    <div>
                        <div class="relative h-60 overflow-hidden bg-purple-100 dark:bg-slate-700 group">
                            <img src="{{ $projectImage }}" alt="{{ $projectTitle }}" class="w-full h-full object-cover hover:scale-105 transition duration-500 cursor-pointer" onclick="openDetailModal({{ \Illuminate\Support\Js::from($projectData) }})">
                            <button type="button"
                                    onclick="event.stopPropagation(); openProjectPreview({{ \Illuminate\Support\Js::from($projectImage) }}, {{ \Illuminate\Support\Js::from($projectTitle) }}, {{ \Illuminate\Support\Js::from($project->link_demo ?? '') }})"
                                    class="absolute bottom-4 right-4 bg-white/90 dark:bg-slate-900/90 text-purple-600 dark:text-purple-300 text-[10px] font-bold px-3 py-2 rounded-xl shadow-lg opacity-100 md:opacity-0 md:group-hover:opacity-100 transition">
                                <i class="fa-solid fa-eye mr-1"></i> Preview
                            </button>
                        </div>
                        <div class="p-6">
                            <span class="text-[10px] font-bold bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-3 py-1 rounded-full uppercase tracking-wider">{{ $project->kategori ?? 'Project' }}</span>
                            <h3 class="text-xl font-bold mt-2 mb-2 hover:text-purple-500 transition cursor-pointer" onclick="openDetailModal({{ \Illuminate\Support\Js::from($projectData) }})">{{ $projectTitle }}</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-300 leading-relaxed font-light mb-4 line-clamp-2">{{ $project->deskripsi }}</p>
                            <div class="flex flex-wrap gap-2 mb-4">
                                @if($project->teknologi)
                                    <span class="text-[9px] font-semibold bg-white dark:bg-slate-700 px-2.5 py-1 rounded-full border border-purple-100 dark:border-slate-600">{{ $project->teknologi }}</span>
                                @endif
                                @if($project->peran)
                                    <span class="text-[9px] font-semibold bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-2.5 py-1 rounded-full">{{ $project->peran }}</span>
                                @endif
                            </div>
                            <div class="flex flex-wrap items-center gap-3">
                                <button type="button" onclick="openDetailModal({{ \Illuminate\Support\Js::from($projectData) }})" class="text-xs font-bold text-purple-500 hover:underline">Lihat Detail Lengkap →</button>
                                <button type="button"
                                        onclick="openProjectPreview({{ \Illuminate\Support\Js::from($projectImage) }}, {{ \Illuminate\Support\Js::from($projectTitle) }}, {{ \Illuminate\Support\Js::from($project->link_demo ?? '') }})"
                                        class="text-xs font-bold text-purple-600 dark:text-purple-300 bg-purple-100 dark:bg-slate-700 px-3 py-1.5 rounded-lg hover:bg-purple-200 transition">
                                    <i class="fa-solid fa-eye mr-1"></i> Preview
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-12 text-purple-400 italic bg-purple-50/20 dark:bg-slate-800 rounded-[2.5rem] border border-purple-100 dark:border-slate-700">
                    Belum ada karya project yang ditambahkan.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- E. SERTIFIKAT DAN PRESTASI -->
<section id="sertifikat" class="py-24 scroll-mt-24">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold">Sertifikat & Prestasi <span class="text-purple-400">✦</span></h2>
            <p class="text-xs text-slate-400 mt-1">Bukti kompetensi dan penghargaan selama masa pendidikan & PLK</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($certificates as $cert)
                <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] p-6 shadow-sm border border-purple-100 dark:border-slate-700 flex flex-col justify-between">
                    <div>
                        @if($cert->gambar)
                            <button type="button" class="w-full h-48 rounded-2xl overflow-hidden bg-purple-100 dark:bg-slate-700 mb-4" onclick="openCertModal('{{ asset('img/certificates/' . $cert->gambar) }}', '{{ addslashes($cert->nama_sertifikat) }}')">
                                <img src="{{ asset('img/certificates/' . $cert->gambar) }}" alt="{{ $cert->nama_sertifikat }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                            </button>
                        @else
                            <div class="w-full h-48 rounded-2xl bg-purple-50 dark:bg-slate-700 mb-4 flex items-center justify-center text-purple-300 text-3xl">
                                <i class="fa-solid fa-award"></i>
                            </div>
                        @endif
                        <div class="flex gap-2 mb-2">
                            <span class="text-[10px] font-bold bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-3 py-1 rounded-full uppercase tracking-wider">{{ $cert->jenis ?? 'Sertifikat' }}</span>
                            <span class="text-[10px] font-bold bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-300 px-3 py-1 rounded-full">{{ $cert->tahun ?? '2026' }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mt-2 mb-1">{{ $cert->nama_sertifikat }}</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $cert->pemberi }}</p>
                        @if($cert->deskripsi)
                            <p class="text-[11px] text-slate-400 mt-2 leading-relaxed">{{ $cert->deskripsi }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-purple-400 italic bg-purple-50/20 dark:bg-slate-800 rounded-[2.5rem] border border-purple-100 dark:border-slate-700">
                    Belum ada sertifikat atau prestasi yang ditambahkan.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- F. PENGALAMAN -->
<section id="pengalaman" class="py-24 bg-white dark:bg-slate-800/50 scroll-mt-24">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold">Pengalaman & Aktivitas <span class="text-purple-400">✦</span></h2>
            <p class="text-xs text-slate-400 mt-1">Pengalaman PLK, organisasi, dan lomba</p>
        </div>

        <div class="space-y-6">
            @forelse($experiences as $exp)
                <div class="bg-purple-50/40 dark:bg-slate-800 rounded-3xl border border-purple-100 dark:border-slate-700 shadow-sm flex flex-col md:flex-row items-stretch gap-0 overflow-hidden">
                    @if($exp->gambar)
                        <button type="button" onclick="openImagePreview('{{ asset('img/experiences/' . $exp->gambar) }}', '{{ addslashes($exp->judul) }}')" class="w-full md:w-52 h-44 md:h-auto flex-shrink-0 bg-purple-100 dark:bg-slate-700">
                            <img src="{{ asset('img/experiences/' . $exp->gambar) }}" alt="{{ $exp->judul }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        </button>
                    @endif
                    <div class="p-6 flex items-start gap-4">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 rounded-2xl flex items-center justify-center text-xl flex-shrink-0">
                            <i class="fa-solid {{ $exp->jenis === 'plk' ? 'fa-briefcase' : ($exp->jenis === 'lomba' ? 'fa-trophy' : 'fa-users') }}"></i>
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <h3 class="font-bold text-base">{{ $exp->judul }}</h3>
                                <span class="text-[9px] font-bold uppercase bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-2 py-0.5 rounded-full">{{ $exp->jenis }}</span>
                            </div>
                            <p class="text-xs text-purple-500 font-medium mb-1">
                                {{ $exp->posisi ? $exp->posisi . ' • ' : '' }}{{ $exp->institusi }} @if($exp->periode) • {{ $exp->periode }} @endif
                            </p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ $exp->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-purple-400 italic bg-purple-50/20 dark:bg-slate-800 rounded-[2.5rem] border border-purple-100 dark:border-slate-700">
                    Belum ada pengalaman yang ditambahkan.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- G. CV DIGITAL / RESUME -->
<section id="cv" class="py-24 scroll-mt-24">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold">CV Digital / Resume <span class="text-purple-400">✦</span></h2>
            <p class="text-xs text-slate-400 mt-2 max-w-xl mx-auto">{{ $settings['cv_note'] ?? 'Berikut CV digital saya.' }}</p>
        </div>

        @if($profile && $profile->file_cv)
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-purple-100 dark:border-slate-700 shadow-sm p-8 md:p-10 text-center">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-purple-100 dark:bg-slate-700 text-purple-500 flex items-center justify-center text-3xl mb-4">
                    <i class="fa-solid fa-file-pdf"></i>
                </div>
                <h3 class="font-bold text-base break-all">{{ $profile->file_cv }}</h3>
                <p class="text-[11px] text-slate-400 mt-1 max-w-md mx-auto">
                    CV dalam format PDF. Pratinjau tidak ditampilkan otomatis — klik tombol di bawah untuk melihat atau mengunduhnya.
                </p>
                <div class="flex flex-wrap justify-center gap-3 mt-6">
                    <button type="button" onclick="openCvModal()" class="bg-purple-100 dark:bg-slate-700 text-purple-700 dark:text-purple-300 px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-purple-200 dark:hover:bg-slate-600 transition inline-flex items-center gap-2">
                        <i class="fa-solid fa-eye"></i> Lihat CV
                    </button>
                    <a href="{{ route('cv.download') }}" download class="bg-purple-500 text-white px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-purple-600 transition shadow-md shadow-purple-500/25 inline-flex items-center gap-2">
                        <i class="fa-solid fa-download"></i> Download CV
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-dashed border-purple-200 dark:border-slate-700 p-12 text-center shadow-sm">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-purple-100 dark:bg-slate-700 text-purple-500 flex items-center justify-center text-2xl mb-4"><i class="fa-solid fa-file-pdf"></i></div>
                <h3 class="font-bold">CV belum diunggah</h3>
                <p class="text-xs text-slate-400 mt-1">Silakan hubungi saya melalui halaman kontak untuk mendapatkan CV terbaru.</p>
            </div>
        @endif
    </div>
</section>

<!-- H. BLOG / ARTIKEL -->
<section id="blog" class="py-24 bg-white dark:bg-slate-800/50 scroll-mt-24">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold">Blog & Catatan Desain <span class="text-purple-400">✦</span></h2>
            <p class="text-xs text-slate-400 mt-1">Artikel dan cerita proses perancangan antarmuka aplikasi</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($posts as $post)
                <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-purple-100 dark:border-slate-700 shadow-sm flex flex-col justify-between overflow-hidden">
                    @if($post->gambar)
                        <div class="h-44 overflow-hidden bg-purple-100 dark:bg-slate-700">
                            <img src="{{ asset('img/posts/' . $post->gambar) }}" alt="{{ $post->judul }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="p-8">
                        <span class="text-[10px] font-bold bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-3 py-1 rounded-full uppercase tracking-wider">{{ $post->kategori ?? 'Artikel' }}</span>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mt-3 mb-2">{{ $post->judul }}</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed font-light mb-6 line-clamp-2">{{ $post->ringkasan }}</p>
                        <div class="pt-4 border-t border-purple-100 dark:border-slate-700 flex items-center justify-between">
                            <span class="text-[10px] text-slate-400">{{ optional($post->tanggal)->format('d M Y') ?: $post->created_at->format('d M Y') }}</span>
                            <a href="{{ route('blog.show', $post->id) }}" class="text-xs font-bold text-purple-500 hover:underline">Baca Selengkapnya →</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-12 text-purple-400 italic bg-purple-50/20 dark:bg-slate-800 rounded-[2.5rem] border border-purple-100 dark:border-slate-700">
                    Belum ada artikel blog.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- I. TESTIMONI -->
<section id="testimoni" class="py-24 scroll-mt-24">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold">Testimoni & Ulasan <span class="text-purple-400">✦</span></h2>
            <p class="text-xs text-slate-400 mt-1">Kesan dan pesan dari guru pembimbing, rekan, tempat PLK, dan pengunjung</p>
        </div>

        @if($testimonis->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                @foreach($testimonis as $testi)
                    <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-purple-100 dark:border-slate-700 shadow-sm flex flex-col justify-between">
                        <div>
                            @if($testi->profesi)
                                <span class="text-[10px] font-bold bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-3 py-1 rounded-full uppercase tracking-wider">{{ $testi->profesi }}</span>
                            @endif
                            <div class="text-purple-400 text-2xl mt-4 mb-4"><i class="fa-solid fa-quote-left"></i></div>
                            <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed font-light mb-6">"{{ $testi->pesan }}"</p>
                        </div>
                        <div class="flex items-center gap-3 pt-4 border-t border-purple-100 dark:border-slate-700">
                            @if($testi->foto && file_exists(storage_path('app/public/' . $testi->foto)))
                                <img src="{{ asset('storage/' . $testi->foto) }}" alt="Foto {{ $testi->nama }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-purple-200 dark:ring-purple-900">
                            @else
                                <div class="w-10 h-10 rounded-full bg-purple-200 dark:bg-purple-900 flex items-center justify-center font-bold text-purple-700 dark:text-purple-300 text-xs uppercase">
                                    {{ mb_substr($testi->nama ?? 'P', 0, 2) }}
                                </div>
                            @endif
                            <div>
                                <h4 class="font-bold text-xs text-slate-800 dark:text-slate-100">{{ $testi->nama }}</h4>
                                <p class="text-[10px] text-purple-500 font-medium">{{ $testi->created_at ? $testi->created_at->diffForHumans() : 'Baru saja' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 text-purple-400 italic bg-white dark:bg-slate-800 rounded-[2.5rem] border border-dashed border-purple-200 dark:border-slate-700 mb-12">
                Belum ada testimoni. Testimoni akan muncul di sini setelah ada yang mengisi.
            </div>
        @endif

        <div class="max-w-xl mx-auto bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-purple-100 dark:border-slate-700 shadow-sm">
            <h3 class="text-lg font-bold text-center mb-2">Berikan Ulasan / Testimoni</h3>
            <p class="text-xs text-slate-400 text-center mb-6">Bagikan kesan atau pesanmu terhadap portofolio ini.</p>

            <form action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-600 dark:text-slate-300">Nama Anda</label>
                    <input type="text" name="nama" required value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso" class="w-full bg-purple-50/40 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs outline-none focus:border-purple-400 transition">
                    @error('nama') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-600 dark:text-slate-300">Anda Memberi Ulasan Sebagai</label>
                    <select name="profesi" class="w-full bg-purple-50/40 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs outline-none focus:border-purple-400 transition cursor-pointer">
                        <option value="Pengunjung" @selected(old('profesi') === 'Pengunjung')>Pengunjung / Pengguna</option>
                        <option value="Guru Pembimbing" @selected(old('profesi') === 'Guru Pembimbing')>Guru Pembimbing</option>
                        <option value="Teman" @selected(old('profesi') === 'Teman')>Teman / Rekan Kelompok</option>
                        <option value="Tempat PLK" @selected(old('profesi') === 'Tempat PLK')>Pembimbing Tempat PLK</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-600 dark:text-slate-300">Foto Profil <span class="text-slate-400 font-normal">(opsional)</span></label>
                    <input type="file" name="foto" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full bg-purple-50/40 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-2xl px-4 py-2.5 text-xs outline-none focus:border-purple-400 transition file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-purple-100 file:text-purple-700 dark:file:bg-slate-700 dark:file:text-purple-300">
                    <p class="text-[10px] text-slate-400 mt-1">Maksimal 2MB. Format JPG, PNG, atau WEBP.</p>
                    @error('foto') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1 text-slate-600 dark:text-slate-300">Pesan / Ulasan</label>
                    <textarea name="pesan" rows="3" required placeholder="Tuliskan ulasanmu di sini..." class="w-full bg-purple-50/40 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs outline-none focus:border-purple-400 transition">{{ old('pesan') }}</textarea>
                    @error('pesan') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full bg-purple-500 text-white font-bold py-3 rounded-2xl text-xs hover:bg-purple-600 transition shadow-md">Kirim Testimoni</button>
            </form>
        </div>
    </div>
</section>

<!-- J. KONTAK & KESAN PESAN -->
<section id="kontak" class="py-24 bg-white dark:bg-slate-800/50 scroll-mt-24">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold">Kesan, Pesan & Kontak <span class="text-purple-400">✦</span></h2>
            <p class="text-xs text-slate-400 mt-1">Sampaikan pesan atau terhubung langsung melalui sosial media</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">
            <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-purple-100 dark:border-slate-700 shadow-sm">
                <h3 class="font-bold text-lg mb-4 text-purple-600 dark:text-purple-400">Kirim Pesan</h3>
                <form action="{{ route('pesan.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Nama Pengirim</label>
                        <input type="text" name="nama_pengirim" class="w-full bg-purple-50/30 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-xl px-4 py-3 text-xs outline-none focus:border-purple-400 transition" required>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Email / Kontak (Opsional)</label>
                        <input type="text" name="email" class="w-full bg-purple-50/30 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-xl px-4 py-3 text-xs outline-none focus:border-purple-400 transition">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Pesan / Kesan</label>
                        <textarea name="pesan" rows="3" class="w-full bg-purple-50/30 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-xl px-4 py-3 text-xs outline-none focus:border-purple-400 transition resize-none" required></textarea>
                    </div>
                    <button type="submit" class="w-full bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 rounded-xl text-xs transition shadow-md shadow-purple-200 dark:shadow-none">Kirim Pesan</button>
                </form>
            </div>

            <div class="space-y-6 flex flex-col justify-center h-full pt-4">
                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $settings['contact_note'] ?? 'Hubungi saya secara langsung melalui platform di bawah ini:' }}</p>
                <div class="flex flex-wrap gap-4">
                    @if($profile && $profile->email)
                        <a href="mailto:{{ $profile->email }}" title="Email" class="w-14 h-14 bg-white dark:bg-slate-800 text-rose-500 rounded-2xl flex items-center justify-center text-2xl shadow-sm hover:bg-rose-500 hover:text-white transition-all duration-300 border border-purple-100 dark:border-slate-700">
                            <i class="fa-solid fa-envelope"></i>
                        </a>
                    @endif
                    @if($profile && $profile->github)
                        <a href="{{ $profile->github }}" target="_blank" title="GitHub" class="w-14 h-14 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 rounded-2xl flex items-center justify-center text-2xl shadow-sm hover:bg-slate-900 hover:text-white transition-all duration-300 border border-purple-100 dark:border-slate-700">
                            <i class="fa-brands fa-github"></i>
                        </a>
                    @endif
                    @if($profile && $profile->linkedin)
                        <a href="{{ $profile->linkedin }}" target="_blank" title="LinkedIn" class="w-14 h-14 bg-white dark:bg-slate-800 text-sky-600 rounded-2xl flex items-center justify-center text-2xl shadow-sm hover:bg-sky-600 hover:text-white transition-all duration-300 border border-purple-100 dark:border-slate-700">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                    @endif
                    @if($profile && $profile->instagram)
                        <a href="{{ $profile->instagram }}" target="_blank" rel="noopener" title="Instagram" class="w-14 h-14 bg-white dark:bg-slate-800 text-purple-500 rounded-2xl flex items-center justify-center text-2xl shadow-sm hover:bg-purple-500 hover:text-white transition-all duration-300 border border-purple-100 dark:border-slate-700">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    @endif
                </div>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-xs font-bold text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-slate-700 px-4 py-2.5 rounded-xl w-fit">
                        <i class="fa-solid fa-gauge"></i> Buka Dashboard Admin
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="py-8 border-t border-purple-100 dark:border-slate-800 text-center text-xs text-slate-400">
    {{ $settings['footer_text'] ?? '© 2026 Nurhaina Portfolio. All Rights Reserved.' }}
</footer>

<!-- TOMBOL KEMBALI KE ATAS (fixed & mengambang) -->
<button id="backToTop" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-6 left-6 z-[60] hidden w-11 h-11 rounded-full bg-purple-500 text-white shadow-lg hover:bg-purple-600 transition items-center justify-center" title="Kembali ke Atas" aria-label="Kembali ke atas">
    <i class="fa-solid fa-arrow-up text-sm"></i>
</button>

<!-- MODAL DETAIL PROJECT -->
<div id="detailModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[80] hidden items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] max-w-3xl w-full p-6 md:p-8 relative shadow-2xl border border-purple-100 dark:border-slate-700 space-y-4 max-h-[90vh] overflow-y-auto">
        <button onclick="closeDetailModal()" class="absolute top-5 right-6 text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold">✕</button>

        <span id="modalKategori" class="text-[10px] font-bold bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-3 py-1 rounded-full uppercase tracking-wider"></span>
        <h3 id="modalJudul" class="text-2xl font-bold text-slate-800 dark:text-slate-100 pr-8"></h3>

        <div class="h-60 md:h-72 rounded-2xl overflow-hidden bg-purple-100 dark:bg-slate-700">
            <img id="modalGambar" src="" alt="Detail Project" class="w-full h-full object-cover">
        </div>

        <div class="space-y-4 text-xs text-slate-600 dark:text-slate-300">
            <div>
                <h4 class="font-bold text-slate-700 dark:text-slate-200 mb-1">Deskripsi Proyek:</h4>
                <p id="modalDeskripsi" class="leading-relaxed"></p>
            </div>
            <div id="modalDetailContainer" class="hidden">
                <h4 class="font-bold text-slate-700 dark:text-slate-200 mb-1">Detail Proyek:</h4>
                <p id="modalDetail" class="leading-relaxed whitespace-pre-line"></p>
            </div>
            <div id="modalPermasalahanContainer" class="hidden">
                <h4 class="font-bold text-slate-700 dark:text-slate-200 mb-1">Permasalahan yang Diselesaikan:</h4>
                <p id="modalPermasalahan" class="leading-relaxed"></p>
            </div>
            <div id="modalTujuanContainer" class="hidden">
                <h4 class="font-bold text-slate-700 dark:text-slate-200 mb-1">Tujuan Pembuatan:</h4>
                <p id="modalTujuan" class="leading-relaxed"></p>
            </div>
            <div class="grid grid-cols-2 gap-4 pt-2">
                <div>
                    <h4 class="font-bold text-slate-700 dark:text-slate-200 mb-1">Teknologi / Tools:</h4>
                    <p id="modalTeknologi" class="font-medium text-purple-500"></p>
                </div>
                <div>
                    <h4 class="font-bold text-slate-700 dark:text-slate-200 mb-1">Peran Saya:</h4>
                    <p id="modalPeran" class="font-medium text-slate-700 dark:text-slate-300"></p>
                </div>
            </div>
            <div id="modalFiturContainer" class="hidden">
                <h4 class="font-bold text-slate-700 dark:text-slate-200 mb-1">Fitur-Fitur dalam Proyek:</h4>
                <p id="modalFitur" class="leading-relaxed whitespace-pre-line"></p>
            </div>
            <div id="modalDokumentasiContainer" class="hidden border-l-4 border-purple-200 dark:border-purple-900 pl-3">
                <h4 class="font-bold text-slate-700 dark:text-slate-200 mb-1">Dokumentasi Proses Pekerjaan:</h4>
                <p id="modalDokumentasi" class="leading-relaxed whitespace-pre-line"></p>
            </div>
            <div id="modalFeedbackContainer" class="hidden">
                <h4 class="font-bold text-slate-700 dark:text-slate-200 mb-1">Feedback User:</h4>
                <p id="modalFeedback" class="leading-relaxed italic text-purple-600 dark:text-purple-300"></p>
            </div>
            <div id="modalLinkContainer" class="flex flex-wrap gap-4 pt-3 border-t border-purple-100 dark:border-slate-700 hidden">
                <a id="modalDemo" href="#" target="_blank" class="hidden bg-purple-500 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-purple-600 transition">Lihat Demo →</a>
                <a id="modalGithub" href="#" target="_blank" class="hidden bg-slate-800 dark:bg-slate-700 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-slate-900 transition">Source Code GitHub →</a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PREVIEW GAMBAR / PROYEK -->
<div id="previewModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-[80] hidden items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] max-w-5xl w-full p-4 md:p-6 relative shadow-2xl border border-purple-100 dark:border-slate-700">
        <button onclick="closePreviewModal()" class="absolute top-4 right-5 text-slate-400 hover:text-slate-600 dark:hover:text-white text-xl font-bold z-10">✕</button>
        <h3 id="previewTitle" class="text-base font-bold text-slate-800 dark:text-slate-100 pr-10 mb-3"></h3>
        <div class="rounded-2xl overflow-hidden bg-purple-100 dark:bg-slate-700 max-h-[75vh] flex items-center justify-center">
            <img id="previewImage" src="" alt="Preview" class="w-full object-contain max-h-[72vh]">
        </div>
        <div class="flex justify-end pt-3">
            <a id="previewDemo" href="#" target="_blank" class="hidden bg-purple-500 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-purple-600 transition">Buka Demo Proyek →</a>
        </div>
    </div>
</div>

<!-- MODAL PREVIEW SERTIFIKAT -->
<div id="certModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-[80] hidden items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] max-w-3xl w-full p-6 relative shadow-2xl border border-purple-100 dark:border-slate-700 space-y-4">
        <button onclick="closeCertModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold">✕</button>
        <h3 id="certModalTitle" class="text-lg font-bold text-slate-800 dark:text-slate-100 pr-8"></h3>
        <div class="rounded-2xl overflow-hidden bg-purple-100 dark:bg-slate-700 max-h-[75vh] flex items-center justify-center">
            <img id="certModalImg" src="" alt="Preview Sertifikat" class="w-full object-contain max-h-[70vh]">
        </div>
    </div>
</div>

<!-- MODAL PREVIEW CV (iframe baru dimuat saat tombol diklik) -->
@if($profile && $profile->file_cv)
<div id="cvModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-[80] hidden items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-[2rem] max-w-4xl w-full p-4 md:p-6 relative shadow-2xl border border-purple-100 dark:border-slate-700">
        <button type="button" onclick="closeCvModal()" class="absolute top-4 right-5 text-slate-400 hover:text-slate-600 dark:hover:text-white text-xl font-bold z-10" aria-label="Tutup pratinjau CV">✕</button>
        <div class="flex flex-wrap items-center justify-between gap-3 pr-10 mb-3">
            <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100 truncate">CV Digital / Resume</h3>
            <a href="{{ route('cv.download') }}" download class="bg-purple-500 text-white px-4 py-2 rounded-xl text-[11px] font-bold hover:bg-purple-600 transition inline-flex items-center gap-2">
                <i class="fa-solid fa-download"></i> Download CV
            </a>
        </div>
        <div class="rounded-2xl overflow-hidden bg-purple-50 dark:bg-slate-900 border border-purple-100 dark:border-slate-700">
            <iframe id="cvFrame" src="about:blank" data-src="{{ asset('files/' . $profile->file_cv) }}#toolbar=0&navpanes=0&view=FitH" class="w-full h-[65vh] md:h-[75vh]" title="Preview CV Digital"></iframe>
        </div>
        <p class="text-[10px] text-slate-400 mt-2">Jika pratinjau tidak muncul di perangkatmu, gunakan tombol Download CV di atas.</p>
    </div>
</div>
@endif

<script>
    // ==========================================
    // FILTER PROJECT
    // ==========================================
    let currentCategory = 'all';

    function filterCategory(category) {
        currentCategory = category;

        document.querySelectorAll('.filter-btn').forEach(btn => {
            const activeClass = 'filter-btn px-5 py-2.5 rounded-2xl text-xs font-bold bg-purple-500 text-white transition shadow-sm';
            const inactiveClass = 'filter-btn px-5 py-2.5 rounded-2xl text-xs font-bold bg-purple-100 dark:bg-slate-700 text-purple-600 dark:text-purple-300 transition hover:bg-purple-200';

            btn.className = btn.dataset.filter === category ? activeClass : inactiveClass;
        });

        applyFilter();
    }

    function filterProjects() {
        applyFilter();
    }

    function applyFilter() {
        const searchInput = document.getElementById('searchProject');
        if (!searchInput) return;

        const searchQuery = searchInput.value.toLowerCase();
        document.querySelectorAll('.project-card').forEach(card => {
            const title = card.getAttribute('data-title') || '';
            const category = card.getAttribute('data-category') || '';
            const matchesSearch = title.includes(searchQuery);
            const matchesCategory = currentCategory === 'all' || category.includes(currentCategory);
            card.style.display = (matchesSearch && matchesCategory) ? 'flex' : 'none';
        });
    }

    // ==========================================
    // MODAL DETAIL PROJECT
    // ==========================================
    function openDetailModal(data) {
        document.getElementById('modalJudul').innerText = data.judul || '';
        document.getElementById('modalKategori').innerText = data.kategori || '';
        document.getElementById('modalGambar').src = data.gambar || '';
        document.getElementById('modalDeskripsi').innerText = data.deskripsi || '';

        setOptional('modalDetailContainer', 'modalDetail', data.detail);
        setOptional('modalPermasalahanContainer', 'modalPermasalahan', data.permasalahan);
        setOptional('modalTujuanContainer', 'modalTujuan', data.tujuan);
        setOptional('modalFiturContainer', 'modalFitur', data.fitur_fitur);
        setOptional('modalDokumentasiContainer', 'modalDokumentasi', data.dokumentasi);

        const feedbackWrap = document.getElementById('modalFeedbackContainer');
        if (data.feedback_user && data.feedback_user.trim() !== '') {
            document.getElementById('modalFeedback').innerText = '"' + data.feedback_user + '"';
            feedbackWrap.classList.remove('hidden');
        } else {
            feedbackWrap.classList.add('hidden');
        }

        document.getElementById('modalTeknologi').innerText = data.teknologi || '-';
        document.getElementById('modalPeran').innerText = data.peran || '-';

        const demoBtn = document.getElementById('modalDemo');
        const githubBtn = document.getElementById('modalGithub');
        const linkContainer = document.getElementById('modalLinkContainer');
        let hasLink = false;

        if (data.link_demo && data.link_demo.trim() !== '') {
            demoBtn.href = data.link_demo;
            demoBtn.classList.remove('hidden');
            hasLink = true;
        } else {
            demoBtn.classList.add('hidden');
        }

        if (data.link_github && data.link_github.trim() !== '') {
            githubBtn.href = data.link_github;
            githubBtn.classList.remove('hidden');
            hasLink = true;
        } else {
            githubBtn.classList.add('hidden');
        }

        linkContainer.classList.toggle('hidden', !hasLink);

        const modal = document.getElementById('detailModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function setOptional(wrapperId, textId, value) {
        const wrapper = document.getElementById(wrapperId);
        if (value && value.trim() !== '') {
            document.getElementById(textId).innerText = value;
            wrapper.classList.remove('hidden');
        } else {
            wrapper.classList.add('hidden');
        }
    }

    function closeDetailModal() {
        const modal = document.getElementById('detailModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // ==========================================
    // PREVIEW PROJECT / GAMBAR
    // ==========================================
    function openProjectPreview(image, title, demoLink) {
        document.getElementById('previewImage').src = image;
        document.getElementById('previewTitle').innerText = title;

        const demoBtn = document.getElementById('previewDemo');
        if (demoLink && demoLink.trim() !== '') {
            demoBtn.href = demoLink;
            demoBtn.classList.remove('hidden');
        } else {
            demoBtn.classList.add('hidden');
        }

        const modal = document.getElementById('previewModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function openImagePreview(image, title) {
        openProjectPreview(image, title, '');
    }

    function closePreviewModal() {
        const modal = document.getElementById('previewModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // ==========================================
    // PREVIEW SERTIFIKAT
    // ==========================================
    function openCertModal(imgSrc, title) {
        document.getElementById('certModalImg').src = imgSrc;
        document.getElementById('certModalTitle').innerText = title;
        const modal = document.getElementById('certModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeCertModal() {
        const modal = document.getElementById('certModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // ==========================================
    // PREVIEW CV (dimuat hanya saat diklik)
    // ==========================================
    function openCvModal() {
        const modal = document.getElementById('cvModal');
        const frame = document.getElementById('cvFrame');
        if (!modal || !frame) return;

        // src diisi saat pertama kali dibuka, jadi PDF tidak ikut ter-load
        // saat halaman utama dibuka.
        if (frame.dataset.src && frame.getAttribute('src') !== frame.dataset.src) {
            frame.setAttribute('src', frame.dataset.src);
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeCvModal() {
        const modal = document.getElementById('cvModal');
        const frame = document.getElementById('cvFrame');
        if (!modal) return;

        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.body.style.overflow = '';

        // Hentikan pemuatan PDF agar memori tidak menumpuk.
        if (frame) frame.setAttribute('src', 'about:blank');
    }

    // Tutup modal dengan tombol Escape
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeDetailModal();
            closePreviewModal();
            closeCertModal();
            closeCvModal();
        }
    });

    // ==========================================
    // MENU MOBILE (HAMBURGER)
    // ==========================================
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('menu-icon');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            icon.className = 'fa-solid fa-xmark text-xs';
        } else {
            menu.classList.add('hidden');
            icon.className = 'fa-solid fa-bars text-xs';
        }

        const trigger = icon.closest('button');
        if (trigger) {
            trigger.setAttribute('aria-expanded', menu.classList.contains('hidden') ? 'false' : 'true');
        }
    }

    // ==========================================
    // DARK / LIGHT MODE
    // ==========================================
    function applyTheme(theme) {
        const isDark = theme === 'dark';
        document.documentElement.classList.toggle('dark', isDark);

        document.querySelectorAll('.theme-icon').forEach(icon => {
            icon.classList.toggle('fa-moon', !isDark);
            icon.classList.toggle('fa-sun', isDark);
        });
    }

    function toggleDarkMode() {
        const nextTheme = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
        localStorage.theme = nextTheme;
        applyTheme(nextTheme);
    }

    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        applyTheme('dark');
    } else {
        applyTheme('light');
    }

    // ==========================================
    // TOMBOL KEMBALI KE ATAS
    // ==========================================
    window.addEventListener('scroll', function () {
        const backToTop = document.getElementById('backToTop');
        if (!backToTop) return;

        if (window.scrollY > 300) {
            backToTop.classList.remove('hidden');
            backToTop.classList.add('flex');
        } else {
            backToTop.classList.add('hidden');
            backToTop.classList.remove('flex');
        }
    });

    // ==========================================
    // ANIMASI REVEAL SAAT SCROLL (fade-in + slide-up)
    // ==========================================
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!prefersReducedMotion && 'IntersectionObserver' in window) {
        document.querySelectorAll('section').forEach(sec => {
            Array.from(sec.children).forEach((child, index) => {
                child.classList.add('reveal');
                child.style.transitionDelay = Math.min(index * 0.08, 0.4) + 's';
            });
        });

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));
    }

    // ==========================================
    // INDIKATOR NAVBAR AKTIF SAAT SCROLL
    // ==========================================
    const navLinks = Array.from(document.querySelectorAll('[data-nav-link]'));
    const navSections = navLinks
        .map(link => document.getElementById(link.dataset.navLink))
        .filter((section, index, list) => section && list.indexOf(section) === index);

    function updateActiveNav() {
        if (navSections.length === 0) return;

        // Garis acuan: sedikit di bawah navbar.
        const referenceLine = window.innerHeight * 0.25;
        let currentSection = navSections[0];

        navSections.forEach(section => {
            const rect = section.getBoundingClientRect();
            if (rect.top <= referenceLine) {
                currentSection = section;
            }
        });

        // Kalau sudah mentok di bawah, aktifkan section terakhir.
        if ((window.innerHeight + window.scrollY) >= (document.body.offsetHeight - 4)) {
            currentSection = navSections[navSections.length - 1];
        }

        navLinks.forEach(link => {
            const isActive = link.dataset.navLink === currentSection.id;
            link.classList.toggle('nav-active', isActive);
            if (isActive) {
                link.setAttribute('aria-current', 'true');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    }

    window.addEventListener('scroll', updateActiveNav, { passive: true });
    window.addEventListener('resize', updateActiveNav);
    window.addEventListener('load', updateActiveNav);
    updateActiveNav();

    // ==========================================
    // ANIMASI GANTI HALAMAN
    // ==========================================
    document.querySelectorAll('a[href]').forEach(link => {
        const href = link.getAttribute('href');
        if (!href) return;

        const isSamePage = href.startsWith('#') || href.startsWith('/#');
        const isNewTab = link.getAttribute('target') === '_blank';
        const isDownload = link.hasAttribute('download');
        const isSpecial = href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript:');

        if (!isSamePage && !isNewTab && !isDownload && !isSpecial) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                document.body.classList.add('page-leaving');
                setTimeout(() => window.location.href = href, 250);
            });
        }
    });
</script>
</body>
</html>
