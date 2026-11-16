<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Portofolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="bg-purple-50/30 font-[Poppins] min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-10 rounded-[2.5rem] shadow-xl border border-purple-100/70 max-w-md w-full text-center">
        <h2 class="text-3xl font-bold text-slate-800 mb-2">Selamat Datang!</h2>
        <p class="text-sm text-slate-400 mb-8">Masuk untuk melihat atau mengelola project.</p>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 text-xs px-4 py-3 rounded-2xl text-left">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5 text-left">
            @csrf
            
            <div>
                <label class="text-xs font-semibold text-slate-500 block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email anda" 
                       class="w-full bg-purple-50/30 border border-purple-100 rounded-2xl px-4 py-3.5 text-sm text-slate-700 outline-none focus:border-purple-400 transition" required autofocus>
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-500 block mb-1">Password</label>
                <input type="password" name="password" placeholder="••••••••" 
                       class="w-full bg-purple-50/30 border border-purple-100 rounded-2xl px-4 py-3.5 text-sm text-slate-700 outline-none focus:border-purple-400 transition" required>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-purple-500 hover:bg-purple-600 text-white text-sm font-bold py-3.5 rounded-2xl transition shadow-lg shadow-purple-200">
                    Masuk
                </button>
            </div>
        </form>

        <div class="mt-8">
            <a href="{{ route('home') }}" class="text-xs font-medium text-purple-400 hover:text-purple-500 hover:underline">
                ← Kembali ke Website
            </a>
        </div>
    </div>

</body>
</html>