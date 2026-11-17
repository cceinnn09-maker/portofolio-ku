<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio | Nurhaina</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-purple-50/30 dark:bg-slate-900 text-slate-800 dark:text-slate-100 font-[Poppins] transition-colors duration-300">

    <!-- NAVBAR -->
    <header class="fixed top-0 left-0 w-full z-50 flex justify-center py-4 px-4">
        <nav>
            <ul class="flex items-center gap-4 bg-white/80 dark:bg-slate-800/85 backdrop-blur-md px-5 py-3 rounded-full shadow-md border border-purple-100 dark:border-slate-700 text-[11px]">
                <li><a href="#beranda" class="hover:text-purple-500 font-medium transition">Beranda</a></li>
                <li><a href="#tentang" class="hover:text-purple-500 font-medium transition">Tentang</a></li>
                <li><a href="#skills" class="hover:text-purple-500 font-medium transition">Skills</a></li>
                <li><a href="#project" class="hover:text-purple-500 font-medium transition">Project</a></li>
                <li><a href="#sertifikat" class="hover:text-purple-500 font-medium transition">Sertifikat</a></li>
                <li><a href="#pengalaman" class="hover:text-purple-500 font-medium transition">Pengalaman</a></li>
                <li><a href="#blog" class="hover:text-purple-500 font-medium transition">Blog</a></li>
                <li><a href="#testimoni" class="hover:text-purple-500 font-medium transition">Testimoni</a></li>
                <li><a href="#kontak" class="hover:text-purple-500 font-medium transition">Kontak</a></li>

                <!-- Tombol Dark/Light Mode -->
                <li>
                    <button onclick="toggleDarkMode()" class="w-6 h-6 rounded-full bg-purple-100 dark:bg-slate-700 flex items-center justify-center text-purple-600 dark:text-yellow-400 transition" title="Ganti Tema">
                        <i id="theme-icon" class="fa-solid fa-moon text-[9px]"></i>
                    </button>
                </li>

                @auth
                    <li><a href="#kelola-karya" class="text-purple-600 dark:text-purple-400 font-bold transition">Admin</a></li>
                    <li class="border-l border-purple-200 dark:border-slate-700 pl-2 flex items-center gap-2">
                        <span class="text-[8px] bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 font-bold px-1.5 py-0.5 rounded-full">Admin</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-red-500 text-[10px] font-bold hover:underline">Logout</button>
                        </form>
                    </li>
                @else
                    <li>
                        <a href="/login" class="bg-purple-400 text-white px-3 py-1 rounded-full text-[10px] font-bold hover:bg-purple-500 transition shadow-sm">
                            Login
                        </a>
                    </li>
                @endauth
            </ul>
        </nav>
    </header>

    <!-- NOTIFIKASI FLASH -->
    @if(session('success'))
        <div class="fixed bottom-5 right-5 z-50 bg-purple-500 text-white px-6 py-3.5 rounded-2xl shadow-xl font-medium text-sm flex items-center gap-2">
            ✦ {{ session('success') }}
        </div>
    @endif

    <!-- A. BERANDA -->
    <section id="beranda" class="min-h-screen flex items-center justify-center pt-28 px-4">
        <div class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl p-10 md:p-14 rounded-[3rem] shadow-xl max-w-4xl w-full border border-purple-100/50 dark:border-slate-700 flex flex-col md:flex-row items-center justify-between gap-10">
            <div class="space-y-4 text-center md:text-left">
                <p class="text-purple-400 font-medium text-lg">Hallo, Saya</p>
                <h1 class="text-4xl md:text-5xl font-bold tracking-tight">Nurhaina</h1>
                <p class="text-slate-600 dark:text-slate-300 text-base md:text-lg font-light">
                    Siswi SMK Negeri 2 Banjarmasin <br>
                    <span class="text-purple-500 font-medium">Pengembangan Perangkat Lunak dan Gim (PPLG)</span>
                </p>
                <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm">Berfokus khusus pada perancangan <strong>UI/UX Design</strong> dan antarmuka aplikasi digital yang solutif serta estetis.</p>
                
                <div class="flex flex-wrap gap-3 justify-center md:justify-start pt-2">
                    <a href="#project" class="bg-purple-500 text-white px-6 py-3 rounded-2xl text-sm font-medium shadow-md hover:bg-purple-600 transition">Lihat Portofolio</a>
                    
                    @if(isset($profile->file_cv) && $profile->file_cv)
                        <a href="{{ asset('files/' . $profile->file_cv) }}" download class="bg-purple-100 dark:bg-slate-700 text-purple-700 dark:text-purple-300 px-6 py-3 rounded-2xl text-sm font-medium hover:bg-purple-200 transition flex items-center gap-2">
                            <i class="fa-solid fa-download"></i> Download CV
                        </a>
                    @else
                        <a href="#tentang" class="bg-purple-100 dark:bg-slate-700 text-purple-700 dark:text-purple-300 px-6 py-3 rounded-2xl text-sm font-medium hover:bg-purple-200 transition">Tentang Saya</a>
                    @endif
                </div>
            </div>
            <div class="w-56 h-56 md:w-64 md:h-64 rounded-full overflow-hidden border-4 border-purple-200 dark:border-purple-900 shadow-lg flex-shrink-0">
                <img src="{{ asset('img/' . ($profile->foto ?? 'ennnaa.jpg')) }}" alt="Nurhaina" class="w-full h-full object-cover">
            </div>
        </div>
    </section>

    <!-- B. TENTANG SAYA -->
    <section id="tentang" class="py-28 bg-white dark:bg-slate-800/50">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6">Tentang Saya <span class="text-purple-400">✦</span></h2>
            <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-base md:text-lg font-light max-w-2xl mx-auto mb-10">
                Saya adalah siswi kelas PPLG di SMK Negeri 2 Banjarmasin. Berfokus mendalami bidang UI/UX Design, berpengalaman Praktik Latihan Kerja (PLK) di instansi pemerintahan, serta terbiasa berkolaborasi dalam tim untuk merancang sistem aplikasi.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                <div class="bg-purple-50/50 dark:bg-slate-800 p-6 rounded-3xl border border-purple-100 dark:border-slate-700">
                    <h3 class="font-bold text-purple-600 dark:text-purple-400 mb-2"><i class="fa-solid fa-graduation-cap mr-2"></i> Pendidikan</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">SMK Negeri 2 Banjarmasin<br>Jurusan PPLG (Software Engineering & Game Dev)</p>
                </div>
                <div class="bg-purple-50/50 dark:bg-slate-800 p-6 rounded-3xl border border-purple-100 dark:border-slate-700">
                    <h3 class="font-bold text-purple-600 dark:text-purple-400 mb-2"><i class="fa-solid fa-bullseye mr-2"></i> Keahlian Utama</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">UI/UX Wireframing & Design, User Research, dan Perancangan Layout Antarmuka.</p>
                </div>
                <div class="bg-purple-50/50 dark:bg-slate-800 p-6 rounded-3xl border border-purple-100 dark:border-slate-700">
                    <h3 class="font-bold text-purple-600 dark:text-purple-400 mb-2"><i class="fa-solid fa-rocket mr-2"></i> Tujuan Karir</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Menjadi UI/UX Designer profesional yang menghadirkan pengalaman pengguna yang intuitif dan menarik.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- C. KEAHLIAN / SKILLS -->
    <section id="skills" class="py-28">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold">Keahlian & Skills <span class="text-purple-400">✦</span></h2>
                <p class="text-xs text-slate-400 mt-1">Fokus keahlian khusus di bidang UI/UX Design</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Hard Skills -->
                <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] shadow-sm border border-purple-100 dark:border-slate-700 space-y-5">
                    <h3 class="font-bold text-lg text-purple-600 dark:text-purple-400 mb-2">Hard Skills (UI/UX)</h3>
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1"><span>UI/UX Wireframing & Design</span><span>85%</span></div>
                        <div class="w-full bg-purple-100 dark:bg-slate-700 h-2.5 rounded-full overflow-hidden"><div class="bg-purple-500 h-full rounded-full" style="width: 85%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1"><span>Layout & Visual Hierarchy</span><span>80%</span></div>
                        <div class="w-full bg-purple-100 dark:bg-slate-700 h-2.5 rounded-full overflow-hidden"><div class="bg-purple-500 h-full rounded-full" style="width: 80%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1"><span>User Research & Flow</span><span>85%</span></div>
                        <div class="w-full bg-purple-100 dark:bg-slate-700 h-2.5 rounded-full overflow-hidden"><div class="bg-purple-500 h-full rounded-full" style="width: 85%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1"><span>Color Theory & Typography</span><span>80%</span></div>
                        <div class="w-full bg-purple-100 dark:bg-slate-700 h-2.5 rounded-full overflow-hidden"><div class="bg-purple-500 h-full rounded-full" style="width: 80%"></div></div>
                    </div>
                </div>

                <!-- Soft Skills -->
                <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] shadow-sm border border-purple-100 dark:border-slate-700 space-y-5">
                    <h3 class="font-bold text-lg text-purple-600 dark:text-purple-400 mb-2">Soft Skills</h3>
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1"><span>Kerjasama Tim & Kolaborasi</span><span>85%</span></div>
                        <div class="w-full bg-purple-100 dark:bg-slate-700 h-2.5 rounded-full overflow-hidden"><div class="bg-purple-400 h-full rounded-full" style="width: 85%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1"><span>Problem Solving</span><span>80%</span></div>
                        <div class="w-full bg-purple-100 dark:bg-slate-700 h-2.5 rounded-full overflow-hidden"><div class="bg-purple-400 h-full rounded-full" style="width: 80%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1"><span>Manajemen Waktu</span><span>80%</span></div>
                        <div class="w-full bg-purple-100 dark:bg-slate-700 h-2.5 rounded-full overflow-hidden"><div class="bg-purple-400 h-full rounded-full" style="width: 80%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1"><span>Komunikasi Efektif</span><span>85%</span></div>
                        <div class="w-full bg-purple-100 dark:bg-slate-700 h-2.5 rounded-full overflow-hidden"><div class="bg-purple-400 h-full rounded-full" style="width: 85%"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- D. GALERI PROJEK / MY PROJECT -->
    <section id="project" class="py-28 bg-white dark:bg-slate-800/50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Project Saya <span class="text-purple-400">✦</span></h2>
                <p class="text-xs text-slate-400 mt-1">Koleksi karya desain UI/UX dan sistem kolaborasi tim</p>
            </div>

            <!-- KOTAK PENCARIAN & TOMBOL FILTER PROJEK -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-10 max-w-2xl mx-auto">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"><i class="fa-solid fa-search text-xs"></i></span>
                    <input type="text" id="searchProject" onkeyup="filterProjects()" placeholder="Cari judul project..." class="w-full bg-purple-50/40 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-2xl pl-10 pr-4 py-3 text-xs outline-none focus:border-purple-400 transition">
                </div>
                <div class="flex gap-2 w-full md:w-auto justify-center">
                    <button onclick="filterCategory('all')" id="btn-all" class="px-5 py-2.5 rounded-2xl text-xs font-bold bg-purple-500 text-white transition shadow-sm">Semua</button>
                    <button onclick="filterCategory('ui/ux')" id="btn-uiux" class="px-5 py-2.5 rounded-2xl text-xs font-bold bg-purple-100 dark:bg-slate-700 text-purple-600 dark:text-purple-300 transition hover:bg-purple-200">UI/UX Design</button>
                </div>
            </div>

            <!-- GRID PROJEK -->
            <div id="projectGrid" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @isset($projects)
                    @forelse($projects as $project)
                        <div class="project-card bg-purple-50/30 dark:bg-slate-800 rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-purple-100 dark:border-slate-700 flex flex-col justify-between" data-category="{{ strtolower($project->kategori ?? 'ui/ux') }}" data-title="{{ strtolower($project->judul ?? $project->nama_project) }}">
                            <div class="cursor-pointer" onclick="openDetailModal(
                                '{{ addslashes($project->judul ?? $project->nama_project) }}', 
                                '{{ $project->kategori ?? 'UI/UX Design' }}', 
                                '{{ asset('img/projects/' . $project->gambar) }}', 
                                '{{ addslashes($project->deskripsi) }}',
                                '{{ addslashes($project->permasalahan ?? 'Tidak ada data') }}',
                                '{{ addslashes($project->tujuan ?? 'Tidak ada data') }}',
                                '{{ addslashes($project->teknologi ?? 'Figma') }}',
                                '{{ addslashes($project->peran ?? 'UI/UX Designer (Tim Kolaborasi)') }}',
                                '{{ $project->link_demo ?? '' }}',
                                '{{ $project->link_github ?? '' }}'
                            )">
                                <div class="h-60 overflow-hidden bg-purple-100 dark:bg-slate-700">
                                    <img src="{{ asset('img/projects/' . $project->gambar) }}" alt="Project" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                                </div>
                                <div class="p-6">
                                    <span class="text-[10px] font-bold bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-3 py-1 rounded-full uppercase tracking-wider">{{ $project->kategori ?? 'UI/UX' }}</span>
                                    <h3 class="text-xl font-bold mt-2 mb-2 hover:text-purple-500 transition">{{ $project->judul ?? $project->nama_project }}</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-300 leading-relaxed font-light mb-4 line-clamp-2">{{ $project->deskripsi }}</p>
                                    <span class="text-xs font-bold text-purple-500 hover:underline">Lihat Detail Lengkap →</span>
                                </div>
                            </div>
                            
                            <div class="px-6 pb-6 pt-2">
                                @auth
                                    <div class="flex gap-2 border-t border-purple-100 dark:border-slate-700 pt-4">
                                        <button type="button" 
                                                onclick="focusAndEdit(
                                                    '{{ $project->id }}', 
                                                    '{{ addslashes($project->judul ?? $project->nama_project) }}', 
                                                    '{{ addslashes($project->kategori ?? '') }}', 
                                                    '{{ addslashes($project->deskripsi) }}',
                                                    '{{ addslashes($project->permasalahan ?? '') }}',
                                                    '{{ addslashes($project->tujuan ?? '') }}',
                                                    '{{ addslashes($project->teknologi ?? '') }}',
                                                    '{{ addslashes($project->peran ?? '') }}',
                                                    '{{ addslashes($project->link_demo ?? '') }}',
                                                    '{{ addslashes($project->link_github ?? '') }}'
                                                )" 
                                                class="text-xs font-bold text-purple-600 bg-purple-50 hover:bg-purple-100 dark:bg-slate-700 dark:text-purple-300 px-4 py-2 rounded-xl transition">
                                            Edit Karya
                                        </button>
                                        <form action="{{ route('projects.delete', $project->id) }}" method="POST" onsubmit="return confirm('Hapus project ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 dark:bg-red-950 dark:text-red-300 px-4 py-2 rounded-xl transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-12 text-purple-400 italic bg-purple-50/20 dark:bg-slate-800 rounded-[2.5rem] border border-purple-100 dark:border-slate-700">
                            Belum ada karya project yang ditambahkan di database.
                        </div>
                    @endforelse
                @endisset
            </div>
        </div>
    </section>

    <!-- E. SERTIFIKAT DAN PRESTASI -->
    <section id="sertifikat" class="py-28">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold">Sertifikat & Prestasi <span class="text-purple-400">✦</span></h2>
                <p class="text-xs text-slate-400 mt-1">Bukti kompetensi dan penghargaan selama masa pendidikan & PLK</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @isset($certificates)
                    @forelse($certificates as $cert)
                        <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] p-6 shadow-sm border border-purple-100 dark:border-slate-700 flex flex-col justify-between">
                            <div>
                                @if($cert->gambar)
                                    <div class="h-48 rounded-2xl overflow-hidden bg-purple-100 dark:bg-slate-700 mb-4 cursor-pointer" onclick="openCertModal('{{ asset('img/certificates/' . $cert->gambar) }}', '{{ addslashes($cert->nama_sertifikat) }}')">
                                        <img src="{{ asset('img/certificates/' . $cert->gambar) }}" alt="{{ $cert->nama_sertifikat }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                                    </div>
                                @endif
                                <span class="text-[10px] font-bold bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-3 py-1 rounded-full uppercase tracking-wider">{{ $cert->tahun ?? '2026' }}</span>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mt-3 mb-1">{{ $cert->nama_sertifikat }}</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $cert->pemberi }}</p>
                            </div>

                            @auth
                                <div class="mt-6 pt-4 border-t border-purple-100 dark:border-slate-700 flex justify-end">
                                    <form action="{{ route('certificates.delete', $cert->id) }}" method="POST" onsubmit="return confirm('Hapus sertifikat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 dark:bg-red-950 dark:text-red-300 px-3 py-1.5 rounded-xl transition">
                                            Hapus Sertifikat
                                        </button>
                                    </form>
                                </div>
                            @endauth
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12 text-purple-400 italic bg-purple-50/20 dark:bg-slate-800 rounded-[2.5rem] border border-purple-100 dark:border-slate-700">
                            Belum ada sertifikat atau prestasi yang ditambahkan.
                        </div>
                    @endforelse
                @endisset
            </div>
        </div>
    </section>

    <!-- F. PENGALAMAN -->
    <section id="pengalaman" class="py-28 bg-white dark:bg-slate-800/50">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold">Pengalaman & Aktivitas <span class="text-purple-400">✦</span></h2>
            </div>

            <div class="space-y-6">
                <div class="bg-purple-50/40 dark:bg-slate-800 p-6 rounded-3xl border border-purple-100 dark:border-slate-700 shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 rounded-2xl flex items-center justify-center text-xl flex-shrink-0">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-base">Praktik Latihan Kerja (PLK)</h3>
                        <p class="text-xs text-purple-500 font-medium mb-1">Kantor Kelurahan / Instansi Lokal</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Mendukung operasional administrasi perkantoran, pengelolaan data digital, serta pelayanan masyarakat secara profesional.</p>
                    </div>
                </div>

                <div class="bg-purple-50/40 dark:bg-slate-800 p-6 rounded-3xl border border-purple-100 dark:border-slate-700 shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 rounded-2xl flex items-center justify-center text-xl flex-shrink-0">
                        <i class="fa-solid fa-users-viewfinder"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-base">Kolaborasi Proyek Perangkat Lunak (Tim PPLG)</h3>
                        <p class="text-xs text-purple-500 font-medium mb-1">SMK Negeri 2 Banjarmasin</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Berperan sebagai <strong>UI/UX Designer</strong> dalam tim kelompok untuk merancang tata letak antarmuka aplikasi, wireframe, serta alur pengalaman pengguna secara kolaboratif.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- N. BLOG PENGEMBANG / ARTIKEL -->
    <section id="blog" class="py-28">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold">Blog & Catatan Desain <span class="text-purple-400">✦</span></h2>
                <p class="text-xs text-slate-400 mt-1">Artikel dan cerita proses perancangan antarmuka aplikasi</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Artikel 1 -->
                <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-purple-100 dark:border-slate-700 shadow-sm flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-bold bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-3 py-1 rounded-full uppercase tracking-wider">UI/UX Workflow</span>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mt-3 mb-2">Pentingnya User Flow dalam Perancangan Aplikasi</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed font-light mb-6">
                            Bagaimana menyusun alur pengguna (*user flow*) yang intuitif sebelum mulai membuat wireframe di Figma agar aplikasi nyaman digunakan.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-purple-100 dark:border-slate-700 flex items-center justify-between">
                        <span class="text-[10px] text-slate-400">16 November 2026</span>
                        <a href="/blog/1" class="text-xs font-bold text-purple-500 hover:underline">Baca Selengkapnya →</a>
                    </div>
                </div>

                <!-- Artikel 2 -->
                <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-purple-100 dark:border-slate-700 shadow-sm flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] font-bold bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-3 py-1 rounded-full uppercase tracking-wider">Kolaborasi Tim</span>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mt-3 mb-2">Pengalaman Kerja Tim PPLG SMKN 2 Banjarmasin</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed font-light mb-6">
                            Cerita seru di balik layar saat berkolaborasi bersama tim kelompok dalam merancang sistem manajemen sekolah berbasis web.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-purple-100 dark:border-slate-700 flex items-center justify-between">
                        <span class="text-[10px] text-slate-400">14 November 2026</span>
                        <a href="/blog/2" class="text-xs font-bold text-purple-500 hover:underline">Baca Selengkapnya →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- M. TESTIMONI & FORM ULASAN PUBLIK -->
    <section id="testimoni" class="py-28 bg-white dark:bg-slate-800/50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold">Testimoni & Ulasan <span class="text-purple-400">✦</span></h2>
                <p class="text-xs text-slate-400 mt-1">Kesan dan pesan dari guru pembimbing, rekan kerja, dan pengunjung</p>
            </div>

            <!-- Grid Card Testimoni (Dinamis dari Database) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Testimoni Statis Bawaan -->
                <div class="bg-purple-50/40 dark:bg-slate-800 p-8 rounded-[2.5rem] border border-purple-100 dark:border-slate-700 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="text-purple-400 text-2xl mb-4"><i class="fa-solid fa-quote-left"></i></div>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed font-light mb-6">
                            "Nurhaina menunjukkan dedikasi yang sangat baik dalam spesialisasi desain UI/UX. Kreatif, teliti, dan hasil rancangannya sangat membantu pengembangan aplikasi tim."
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-purple-100 dark:border-slate-700">
                        <div class="w-10 h-10 rounded-full bg-purple-200 dark:bg-purple-900 flex items-center justify-center font-bold text-purple-700 dark:text-purple-300 text-xs">IM</div>
                        <div>
                            <h4 class="font-bold text-xs text-slate-800 dark:text-slate-100">Ibu Mariani, S.Pd.</h4>
                            <p class="text-[10px] text-purple-500 font-medium">Guru Pembimbing / Wali Kelas</p>
                        </div>
                    </div>
                </div>

                <!-- Testimoni Dinamis dari Database -->
                @isset($testimonis)
                    @if($testimonis->count() > 0)
                        @foreach($testimonis as $testi)
                            <div class="bg-purple-50/40 dark:bg-slate-800 p-8 rounded-[2.5rem] border border-purple-100 dark:border-slate-700 shadow-sm flex flex-col justify-between">
                                <div>
                                    <div class="text-purple-400 text-2xl mb-4"><i class="fa-solid fa-quote-left"></i></div>
                                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed font-light mb-6">
                                        "{{ $testi->pesan ?? $testi->testimonial ?? $testi->content }}"
                                    </p>
                                </div>
                                <div class="flex items-center gap-3 pt-4 border-t border-purple-100 dark:border-slate-700">
                                    <div class="w-10 h-10 rounded-full bg-purple-200 dark:bg-purple-900 flex items-center justify-center font-bold text-purple-700 dark:text-purple-300 text-xs uppercase">
                                        {{ substr($testi->nama ?? $testi->name ?? 'P', 0, 2) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs text-slate-800 dark:text-slate-100">
                                            {{ $testi->nama ?? $testi->name ?? 'Pengunjung' }}
                                        </h4>
                                        <p class="text-[10px] text-purple-500 font-medium">
                                            {{ $testi->created_at ? $testi->created_at->diffForHumans() : 'Baru saja' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endisset
            </div>

            <!-- Form Tambah Testimoni untuk Pengunjung -->
            <div class="max-w-xl mx-auto bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-purple-100 dark:border-slate-700 shadow-sm">
                <h3 class="text-lg font-bold text-center mb-2">Berikan Ulasan / Testimoni</h3>
                <p class="text-xs text-slate-400 text-center mb-6">Bagikan kesan atau pesanmu terhadap portofolio ini.</p>
                
                <form action="{{ route('testimonial.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-600 dark:text-slate-300">Nama Anda</label>
                        <input type="text" name="nama" required placeholder="Contoh: Budi Santoso" class="w-full bg-purple-50/40 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs outline-none focus:border-purple-400 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1 text-slate-600 dark:text-slate-300">Pesan / Ulasan</label>
                        <textarea name="pesan" rows="3" required placeholder="Tuliskan ulasanmu di sini..." class="w-full bg-purple-50/40 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs outline-none focus:border-purple-400 transition"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-purple-500 text-white font-bold py-3 rounded-2xl text-xs hover:bg-purple-600 transition shadow-md">
                        Kirim Testimoni
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- FORMULIR KONTAK -->
    <section id="kontak" class="py-28">
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
                        <button type="submit" class="w-full bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 rounded-xl text-xs transition shadow-md shadow-purple-200 dark:shadow-none">
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                <div class="space-y-6 flex flex-col justify-center h-full pt-4">
                    <p class="text-xs text-slate-500 dark:text-slate-400">Hubungi saya secara langsung melalui platform di bawah ini:</p>
                    <div class="flex gap-4">
                        <a href="https://www.instagram.com/ainnaanr__" target="_blank" title="Instagram"
                           class="w-14 h-14 bg-white dark:bg-slate-800 text-purple-500 rounded-2xl flex items-center justify-center text-2xl shadow-sm hover:bg-purple-500 hover:text-white transition-all duration-300 border border-purple-100 dark:border-slate-700">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="https://www.tiktok.com/@iniii.ena" target="_blank" title="TikTok"
                           class="w-14 h-14 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 rounded-2xl flex items-center justify-center text-xl shadow-sm hover:bg-slate-900 hover:text-white transition-all duration-300 border border-purple-100 dark:border-slate-700">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ======================================================== -->
    <!-- PANEL KHUSUS ADMIN (Hanya Muncul Saat Login / @auth)      -->
    <!-- ======================================================== -->
    @auth
    <section id="kelola-karya" class="py-28 border-t border-purple-200 dark:border-slate-700 bg-purple-50/50 dark:bg-slate-900">
        <div class="max-w-4xl mx-auto px-6 space-y-12">
            
            <div class="text-center">
                <span class="px-3 py-1 bg-purple-500 text-white text-[10px] font-bold rounded-full uppercase tracking-wider">Mode Admin Aktif</span>
                <h2 class="text-2xl font-bold mt-2">Panel Kontrol & Kelola Data</h2>
                <p class="text-xs text-slate-500 mt-1">Tambah, edit project, sertifikat, profil, serta pantau pesan dan testimoni.</p>
            </div>

            <!-- 1. Form Kelola Proyek -->
            <div class="bg-white dark:bg-slate-800 p-10 rounded-[2.5rem] shadow-xl border border-purple-100 dark:border-slate-700">
                <h2 id="form-title" class="text-xl font-bold mb-1 text-center text-slate-800 dark:text-slate-100">Tambah Project Baru ✦</h2>
                <p id="form-subtitle" class="text-xs text-slate-400 text-center mb-8">Panel kendali CRUD data portofolio</p>
                
                <form id="project-form" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div id="method-container"></div>

                    <div>
                        <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Judul Project</label>
                        <input type="text" id="judul" name="judul" class="w-full bg-purple-50/30 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-400 transition" required>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Kategori</label>
                        <input type="text" id="kategori" name="kategori" placeholder="Contoh: UI/UX Design" class="w-full bg-purple-50/30 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-400 transition" required>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Deskripsi Singkat</label>
                        <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full bg-purple-50/30 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-400 transition resize-none" required></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Permasalahan yang Diselesaikan</label>
                            <textarea id="permasalahan" name="permasalahan" rows="2" class="w-full bg-purple-50/30 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-400 transition resize-none"></textarea>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Tujuan Pembuatan</label>
                            <textarea id="tujuan" name="tujuan" rows="2" class="w-full bg-purple-50/30 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-400 transition resize-none"></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Teknologi / Tools</label>
                            <input type="text" id="teknologi" name="teknologi" placeholder="Contoh: Figma" class="w-full bg-purple-50/30 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-400 transition">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Peran Saya</label>
                            <input type="text" id="peran" name="peran" placeholder="Contoh: UI/UX Designer" class="w-full bg-purple-50/30 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-400 transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Link Demo (Opsional)</label>
                            <input type="text" id="link_demo" name="link_demo" placeholder="https://..." class="w-full bg-purple-50/30 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-400 transition">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Link GitHub (Opsional)</label>
                            <input type="text" id="link_github" name="link_github" placeholder="https://github.com/..." class="w-full bg-purple-50/30 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm outline-none focus:border-purple-400 transition">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">File Gambar / Mockup Proyek</label>
                        <input type="file" id="gambar" name="gambar" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 cursor-pointer" required>
                        <p id="gambar-help" class="text-[10px] text-purple-500 mt-1 hidden">*Biarkan kosong jika gambar tidak ingin diubah</p>
                    </div>

                    <div class="flex flex-col gap-2 pt-2">
                        <button type="submit" id="submit-btn" class="w-full bg-purple-500 hover:bg-purple-600 text-white text-sm font-bold py-3.5 rounded-xl transition shadow-md">
                            Simpan Project Baru
                        </button>
                        <button type="button" id="cancel-btn" onclick="resetToStoreMode()" class="w-full bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 text-slate-600 dark:text-slate-300 text-sm font-semibold py-2.5 rounded-xl transition hidden">
                            Batal Edit
                        </button>
                    </div>
                </form>
            </div>

            <!-- 2. Form Sertifikat -->
            <div class="bg-white dark:bg-slate-800 p-10 rounded-[2.5rem] shadow-xl border border-purple-100 dark:border-slate-700">
                <h2 class="text-xl font-bold mb-1 text-center text-slate-800 dark:text-slate-100">Tambah Sertifikat / Prestasi ✦</h2>
                <form action="{{ route('certificates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 mt-4">
                    @csrf
                    <div>
                        <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Nama Sertifikat</label>
                        <input type="text" name="nama_sertifikat" placeholder="Contoh: Sertifikat Kompetensi" class="w-full bg-purple-50/30 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-xl px-4 py-3 text-xs outline-none focus:border-purple-400 transition" required>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Pemberi / Lembaga</label>
                        <input type="text" name="pemberi" placeholder="Contoh: SMK Negeri 2 Banjarmasin" class="w-full bg-purple-50/30 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-xl px-4 py-3 text-xs outline-none focus:border-purple-400 transition" required>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">Tahun</label>
                        <input type="text" name="tahun" placeholder="2026" class="w-full bg-purple-50/30 dark:bg-slate-900 border border-purple-100 dark:border-slate-700 rounded-xl px-4 py-3 text-xs outline-none focus:border-purple-400 transition" required>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 block mb-1">File Gambar Sertifikat</label>
                        <input type="file" name="gambar" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 cursor-pointer" required>
                    </div>
                    <button type="submit" class="w-full bg-purple-500 hover:bg-purple-600 text-white text-xs font-bold py-3.5 rounded-xl transition shadow-md">
                        Simpan Sertifikat
                    </button>
                </form>
            </div>

            <!-- 3. Kotak Masuk Pesan Pengunjung (Admin) -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-purple-100 dark:border-slate-700 overflow-hidden p-6">
                <h3 class="text-base font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-purple-600"></span>
                    Kotak Masuk Pesan Pengunjung ({{ isset($messages) ? $messages->count() : 0 }})
                </h3>
                @isset($messages)
                    @if($messages->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700 text-xs">
                                <thead class="bg-gray-50 dark:bg-slate-900 text-gray-500 font-semibold">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Nama</th>
                                        <th class="px-4 py-3 text-left">Email</th>
                                        <th class="px-4 py-3 text-left">Pesan</th>
                                        <th class="px-4 py-3 text-right">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                                    @foreach($messages as $msg)
                                        <tr class="hover:bg-purple-50/30 transition-colors">
                                            <td class="px-4 py-3 font-semibold text-slate-900 dark:text-white whitespace-nowrap">{{ $msg->nama_pengirim }}</td>
                                            <td class="px-4 py-3 text-slate-500 whitespace-nowrap">{{ $msg->email ?? '-' }}</td>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-300 max-w-xs truncate">{{ $msg->pesan }}</td>
                                            <td class="px-4 py-3 text-right text-slate-400 whitespace-nowrap">{{ $msg->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-slate-400 text-xs text-center py-4">Belum ada pesan masuk.</p>
                    @endif
                @endisset
            </div>

            <!-- 4. Kelola Testimoni Pengunjung (Admin dengan Tombol Hapus) -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-purple-100 dark:border-slate-700 overflow-hidden p-6">
                <h3 class="text-base font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                    Kelola Testimoni ({{ isset($testimonis) ? $testimonis->count() : 0 }})
                </h3>
                @isset($testimonis)
                    @if($testimonis->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700 text-xs">
                                <thead class="bg-gray-50 dark:bg-slate-900 text-gray-500 font-semibold">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Pengirim</th>
                                        <th class="px-4 py-3 text-left">Isi Testimoni</th>
                                        <th class="px-4 py-3 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
                                    @foreach($testimonis as $testi)
                                        <tr class="hover:bg-indigo-50/30 transition-colors">
                                            <td class="px-4 py-3 font-semibold text-slate-900 dark:text-white whitespace-nowrap">{{ $testi->nama ?? $testi->name ?? 'Tanpa Nama' }}</td>
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-300 max-w-md">"{{ $testi->pesan ?? $testi->testimonial ?? $testi->content }}"</td>
                                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                                <form action="{{ route('testimonial.delete', $testi->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus testimoni ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2.5 py-1 bg-red-50 text-red-600 hover:bg-red-100 font-bold rounded-lg transition">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-slate-400 text-xs text-center py-4">Belum ada testimoni masuk.</p>
                    @endif
                @endisset
            </div>

        </div>
    </section>
    @endauth

    <!-- FOOTER -->
    <footer class="py-8 border-t border-purple-100 dark:border-slate-800 text-center text-xs text-slate-400">
        © 2026 Nurhaina Portfolio. All Rights Reserved.
    </footer>

    <!-- TOMBOL KEMBALI KE ATAS -->
    <button id="backToTop" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-6 left-6 z-40 hidden w-11 h-11 rounded-full bg-purple-500 text-white shadow-lg hover:bg-purple-600 transition items-center justify-center" title="Kembali ke Atas">
        <i class="fa-solid fa-arrow-up text-sm"></i>
    </button>

    <!-- MODAL DETAIL PROJECT -->
    <div id="detailModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] max-w-2xl w-full p-8 relative shadow-2xl border border-purple-100 dark:border-slate-700 space-y-4 max-h-[90vh] overflow-y-auto">
            <button onclick="closeDetailModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold">✕</button>
            
            <span id="modalKategori" class="text-[10px] font-bold bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-3 py-1 rounded-full uppercase tracking-wider"></span>
            <h3 id="modalJudul" class="text-2xl font-bold text-slate-800 dark:text-slate-100 pr-8"></h3>
            
            <div class="h-64 rounded-2xl overflow-hidden bg-purple-100 dark:bg-slate-700">
                <img id="modalGambar" src="" alt="Detail Project" class="w-full h-full object-cover">
            </div>

            <div class="space-y-3 text-xs text-slate-600 dark:text-slate-300">
                <div>
                    <h4 class="font-bold text-slate-700 dark:text-slate-200 mb-1">Deskripsi Proyek:</h4>
                    <p id="modalDeskripsi" class="leading-relaxed"></p>
                </div>
                <div>
                    <h4 class="font-bold text-slate-700 dark:text-slate-200 mb-1">Permasalahan yang Diselesaikan:</h4>
                    <p id="modalPermasalahan" class="leading-relaxed"></p>
                </div>
                <div>
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
                <div id="modalLinkContainer" class="flex gap-4 pt-3 border-t border-purple-100 dark:border-slate-700 hidden">
                    <a id="modalDemo" href="#" target="_blank" class="hidden bg-purple-500 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-purple-600 transition">Lihat Demo →</a>
                    <a id="modalGithub" href="#" target="_blank" class="hidden bg-slate-800 dark:bg-slate-700 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-slate-900 transition">Source Code GitHub →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PREVIEW SERTIFIKAT -->
    <div id="certModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] max-w-3xl w-full p-6 relative shadow-2xl border border-purple-100 dark:border-slate-700 space-y-4">
            <button onclick="closeCertModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold">✕</button>
            <h3 id="certModalTitle" class="text-lg font-bold text-slate-800 dark:text-slate-100 pr-8"></h3>
            <div class="rounded-2xl overflow-hidden bg-purple-100 dark:bg-slate-700 max-h-[75vh] flex items-center justify-center">
                <img id="certModalImg" src="" alt="Preview Sertifikat" class="w-full object-contain max-h-[70vh]">
            </div>
        </div>
    </div>

    <!-- SCRIPT -->
    @auth
    <script>
        function focusAndEdit(id, judul, kategori, deskripsi, permasalahan, tujuan, teknologi, peran, link_demo, link_github) {
            document.getElementById('kelola-karya').scrollIntoView({ behavior: 'smooth' });

            document.getElementById('form-title').innerText = "Edit Project Anda ✦";
            document.getElementById('submit-btn').innerText = "Simpan Perubahan Project";
            document.getElementById('submit-btn').className = "w-full bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold py-3.5 rounded-xl transition shadow-lg shadow-blue-200";
            
            document.getElementById('cancel-btn').classList.remove('hidden');
            document.getElementById('gambar-help').classList.remove('hidden');
            document.getElementById('gambar').required = false;

            document.getElementById('judul').value = judul;
            document.getElementById('kategori').value = kategori;
            document.getElementById('deskripsi').value = deskripsi;
            document.getElementById('permasalahan').value = permasalahan;
            document.getElementById('tujuan').value = tujuan;
            document.getElementById('teknologi').value = teknologi;
            document.getElementById('peran').value = peran;
            document.getElementById('link_demo').value = link_demo;
            document.getElementById('link_github').value = link_github;

            document.getElementById('project-form').action = "/admin/update/" + id;
            document.getElementById('method-container').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        }

        function resetToStoreMode() {
            document.getElementById('form-title').innerText = "Tambah Project Baru ✦";
            document.getElementById('submit-btn').innerText = "Simpan Project Baru";
            document.getElementById('submit-btn').className = "w-full bg-purple-500 hover:bg-purple-600 text-white text-sm font-bold py-3.5 rounded-xl transition shadow-lg shadow-purple-200 dark:shadow-none";
            
            document.getElementById('cancel-btn').classList.add('hidden');
            document.getElementById('gambar-help').classList.add('hidden');
            document.getElementById('gambar').required = true;

            document.getElementById('project-form').reset();
            document.getElementById('project-form').action = "{{ route('projects.store') }}";
            document.getElementById('method-container').innerHTML = '';
        }
    </script>
    @endauth

    <script>
        let currentCategory = 'all';

        function filterCategory(category) {
            currentCategory = category;
            const btnAll = document.getElementById('btn-all');
            const btnUiux = document.getElementById('btn-uiux');

            if (category === 'all') {
                btnAll.className = "px-5 py-2.5 rounded-2xl text-xs font-bold bg-purple-500 text-white transition shadow-sm";
                btnUiux.className = "px-5 py-2.5 rounded-2xl text-xs font-bold bg-purple-100 dark:bg-slate-700 text-purple-600 dark:text-purple-300 transition hover:bg-purple-200";
            } else {
                btnUiux.className = "px-5 py-2.5 rounded-2xl text-xs font-bold bg-purple-500 text-white transition shadow-sm";
                btnAll.className = "px-5 py-2.5 rounded-2xl text-xs font-bold bg-purple-100 dark:bg-slate-700 text-purple-600 dark:text-purple-300 transition hover:bg-purple-200";
            }
            applyFilter();
        }

        function filterProjects() {
            applyFilter();
        }

        function applyFilter() {
            const searchQuery = document.getElementById('searchProject').value.toLowerCase();
            const cards = document.querySelectorAll('.project-card');

            cards.forEach(card => {
                const title = card.getAttribute('data-title');
                const category = card.getAttribute('data-category');

                const matchesSearch = title.includes(searchQuery);
                const matchesCategory = (currentCategory === 'all' || category.includes(currentCategory));

                if (matchesSearch && matchesCategory) {
                    card.style.display = "flex";
                } else {
                    card.style.display = "none";
                }
            });
        }

        function openDetailModal(judul, kategori, gambar, deskripsi, permasalahan, tujuan, teknologi, peran, link_demo, link_github) {
            document.getElementById('modalJudul').innerText = judul;
            document.getElementById('modalKategori').innerText = kategori;
            document.getElementById('modalGambar').src = gambar;
            document.getElementById('modalDeskripsi').innerText = deskripsi;
            document.getElementById('modalPermasalahan').innerText = permasalahan;
            document.getElementById('modalTujuan').innerText = tujuan;
            document.getElementById('modalTeknologi').innerText = teknologi;
            document.getElementById('modalPeran').innerText = peran;

            const demoBtn = document.getElementById('modalDemo');
            const githubBtn = document.getElementById('modalGithub');
            const linkContainer = document.getElementById('modalLinkContainer');

            let hasLink = false;
            if (link_demo && link_demo !== '') {
                demoBtn.href = link_demo;
                demoBtn.classList.remove('hidden');
                hasLink = true;
            } else {
                demoBtn.classList.add('hidden');
            }

            if (link_github && link_github !== '') {
                githubBtn.href = link_github;
                githubBtn.classList.remove('hidden');
                hasLink = true;
            } else {
                githubBtn.classList.add('hidden');
            }

            if (hasLink) {
                linkContainer.classList.remove('hidden');
            } else {
                linkContainer.classList.add('hidden');
            }

            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function openCertModal(imgSrc, title) {
            document.getElementById('certModalImg').src = imgSrc;
            document.getElementById('certModalTitle').innerText = title;
            const modal = document.getElementById('certModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeCertModal() {
            const modal = document.getElementById('certModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        window.addEventListener('scroll', function() {
            const backToTop = document.getElementById('backToTop');
            if (window.scrollY > 300) {
                backToTop.classList.remove('hidden');
                backToTop.classList.add('flex');
            } else {
                backToTop.classList.add('hidden');
                backToTop.classList.remove('flex');
            }
        });

        function toggleDarkMode() {
            const html = document.documentElement;
            const icon = document.getElementById('theme-icon');
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
                icon.className = "fa-solid fa-moon text-[9px]";
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
                icon.className = "fa-solid fa-sun text-[9px] text-yellow-400";
            }
        }

        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            document.getElementById('theme-icon').className = "fa-solid fa-sun text-[9px] text-yellow-400";
        }
    </script>
</body>
</html>