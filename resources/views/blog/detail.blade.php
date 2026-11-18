<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->judul }} | {{ $settings['site_title'] ?? 'Portofolio Nurhaina' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { opacity: 0; animation: pageFadeIn .5s ease forwards; }
        body.page-leaving { animation: pageFadeOut .3s ease forwards; }
        @keyframes pageFadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes pageFadeOut { from { opacity: 1; } to { opacity: 0; } }
    </style>
</head>
<body class="bg-purple-50/30 dark:bg-slate-900 text-slate-800 dark:text-slate-100 font-[Poppins] min-h-screen py-16 px-4">
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    <article class="max-w-3xl mx-auto bg-white dark:bg-slate-800 p-8 md:p-12 rounded-[2.5rem] shadow-xl border border-purple-100 dark:border-slate-700 space-y-6">
        <div class="flex items-center justify-between gap-3">
            <a href="{{ route('home') }}#blog" class="inline-flex items-center gap-2 text-xs font-bold text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-slate-700 px-4 py-2 rounded-xl transition hover:bg-purple-100">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
            </a>
            <button type="button" onclick="toggleTheme()" class="w-9 h-9 rounded-xl bg-purple-50 dark:bg-slate-700 text-purple-600 dark:text-yellow-400 flex items-center justify-center" title="Ganti tema">
                <i id="theme-icon" class="fa-solid fa-moon text-xs"></i>
            </button>
        </div>

        <div>
            @if($post->kategori)
                <span class="text-[10px] font-bold bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 px-3 py-1 rounded-full uppercase tracking-wider">{{ $post->kategori }}</span>
            @endif
            <h1 class="text-3xl md:text-4xl font-bold mt-4">{{ $post->judul }}</h1>
            <p class="text-xs text-slate-400 mt-2">
                Dipublikasikan oleh {{ $post->penulis ?: 'Nurhaina' }}
                @if($post->tanggal)
                    • {{ $post->tanggal->format('d M Y') }}
                @endif
            </p>
        </div>

        @if($post->gambar)
            <div class="rounded-2xl overflow-hidden bg-purple-100 dark:bg-slate-700">
                <img src="{{ asset('img/posts/' . $post->gambar) }}" alt="{{ $post->judul }}" class="w-full max-h-[420px] object-cover">
            </div>
        @endif

        @if($post->ringkasan)
            <p class="text-sm text-slate-500 dark:text-slate-300 leading-relaxed font-medium border-l-4 border-purple-300 dark:border-purple-800 pl-4">
                {{ $post->ringkasan }}
            </p>
        @endif

        <div class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-light space-y-4 pt-4 border-t border-purple-100 dark:border-slate-700">
            {!! nl2br(e($post->konten)) !!}
        </div>

        <div class="pt-6 border-t border-purple-100 dark:border-slate-700 flex flex-wrap gap-3">
            <a href="{{ route('home') }}#blog" class="bg-purple-500 text-white px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-purple-600 transition">Kembali ke Daftar Artikel</a>
            <a href="{{ route('home') }}#kontak" class="bg-purple-100 dark:bg-slate-700 text-purple-700 dark:text-purple-300 px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-purple-200 transition">Hubungi Saya</a>
        </div>
    </article>

    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const icon = document.getElementById('theme-icon');
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
                icon.className = 'fa-solid fa-moon text-xs';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
                icon.className = 'fa-solid fa-sun text-xs text-yellow-400';
            }
        }

        if (document.documentElement.classList.contains('dark')) {
            document.getElementById('theme-icon').className = 'fa-solid fa-sun text-xs text-yellow-400';
        }

        document.querySelectorAll('a[href]').forEach(link => {
            const href = link.getAttribute('href');
            if (!href) return;
            const isSamePage = href.startsWith('#') || href.includes('#');
            const isNewTab = link.getAttribute('target') === '_blank';
            if (!isSamePage && !isNewTab) {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    document.body.classList.add('page-leaving');
                    setTimeout(() => window.location.href = href, 250);
                });
            }
        });
    </script>
</body>
</html>
