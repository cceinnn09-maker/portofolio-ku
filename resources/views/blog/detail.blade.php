<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Artikel | Blog Pengembang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-purple-50/30 dark:bg-slate-900 text-slate-800 dark:text-slate-100 font-[Poppins] min-h-screen py-20 px-4">
    <div class="max-w-3xl mx-auto bg-white dark:bg-slate-800 p-8 md:p-12 rounded-[2.5rem] shadow-xl border border-purple-100 dark:border-slate-700 space-y-6">
        <a href="/#blog" class="inline-flex items-center gap-2 text-xs font-bold text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-slate-700 px-4 py-2 rounded-xl transition hover:bg-purple-100">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>

        @if(isset($id) && $id == 2)
            <!-- KONTEN ARTIKEL 2 -->
            <span class="text-[10px] font-bold bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-3 py-1 rounded-full uppercase tracking-wider">Kolaborasi Tim</span>
            <h1 class="text-3xl md:text-4xl font-bold">Pengalaman Kerja Tim PPLG SMKN 2 Banjarmasin</h1>
            <p class="text-xs text-slate-400">Dipublikasikan oleh Nurhaina • 14 November 2026</p>

            <div class="space-y-4 text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-light pt-4 border-t border-purple-100 dark:border-slate-700">
                <p>
                    Bekerja dalam tim pengembangan perangkat lunak memberikan pengalaman nyata tentang bagaimana dinamika industri IT bekerja. Di jurusan PPLG SMK Negeri 2 Banjarmasin, proyek kelompok menuntut pembagian tugas yang jelas antara pemrogram (*programmer*), pengelola database, dan perancang antarmuka (*UI/UX Designer*).
                </p>
                <p>
                    Sebagai UI/UX Designer dalam tim, tantangan utama saya adalah menerjemahkan ide-ide abstrak dari rekan kelompok menjadi cetak biru (*wireframe*) yang terstruktur di Figma. Komunikasi yang intensif dengan anggota tim memastikan bahwa setiap fitur yang dirancang dapat diimplementasikan dengan baik menggunakan Laravel dan MySQL.
                </p>
                <p>
                    Pengalaman kolaborasi ini mengajarkan saya arti penting dari toleransi, kedisiplinan tenggat waktu, dan saling melengkapi keahlian demi mencapai tujuan proyek yang solutif dan berkualitas tinggi.
                </p>
            </div>
        @else
            <!-- KONTEN ARTIKEL 1 (DEFAULT) -->
            <span class="text-[10px] font-bold bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-3 py-1 rounded-full uppercase tracking-wider">UI/UX Workflow</span>
            <h1 class="text-3xl md:text-4xl font-bold">Pentingnya User Flow dalam Perancangan Aplikasi</h1>
            <p class="text-xs text-slate-400">Dipublikasikan oleh Nurhaina • 16 November 2026</p>

            <div class="space-y-4 text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-light pt-4 border-t border-purple-100 dark:border-slate-700">
                <p>
                    Dalam proses pengembangan portofolio dan proyek aplikasi ini, tahapan riset pengguna dan perancangan alur (*user flow*) di Figma memegang peran yang sangat krusial. Sebagai seorang UI/UX Designer, fokus utama saya adalah memastikan bahwa setiap halaman aplikasi mudah dipahami, memiliki hierarki visual yang jelas, serta nyaman dipandang oleh pengguna.
                </p>
                <p>
                    User flow membantu kita memetakan langkah-langkah yang harus dilalui oleh pengguna untuk mencapai tujuan mereka di dalam aplikasi, sehingga meminimalisir kebingungan antarmuka sebelum tahap pengkodean Laravel dimulai.
                </p>
                <p>
                    Melalui catatan blog pengembang ini, saya mendokumentasikan setiap langkah perjalanan kreatif, mulai dari penentuan palet warna ungu pastel, penyusunan struktur navigasi, hingga uji coba antarmuka agar standar kualitas UKK dapat terpenuhi secara maksimal.
                </p>
            </div>
        @endif

        <div class="pt-6 border-t border-purple-100 dark:border-slate-700 flex justify-between items-center text-xs text-slate-400">
            <span>SMK Negeri 2 Banjarmasin</span>
            <a href="/" class="font-bold text-purple-500 hover:underline">Nurhaina Portfolio ✦</a>
        </div>
    </div>
</body>
</html>