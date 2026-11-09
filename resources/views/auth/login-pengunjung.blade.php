<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengunjung - Kawah Putih</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body class="bg-gradient-to-br from-teal-50 to-emerald-100 min-h-screen flex items-center justify-center p-3 md:p-4">
    <div class="bg-white rounded-2xl shadow-xl p-5 md:p-8 w-full max-w-md mx-2">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-teal-100 mb-4">
                <span class="material-symbols-outlined text-4xl text-teal-600">travel_explore</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Login Pengunjung</h1>
            <p class="text-sm text-gray-500 mt-2">Kawah Putih Ciwidey</p>
        </div>

        <!-- Form Login -->
        <form method="POST" action="{{ route('pengunjung.login.post') }}" class="space-y-4">
            @csrf

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                    <p class="text-sm text-red-600">{{ $errors->first('email') }}</p>
                </div>
            @endif

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
         <input type="email" name="email" value="{{ old('email') }}" required
             class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 outline-none transition-all min-h-[44px] text-base"
             placeholder="nama@email.com">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent outline-none transition-all"
                    placeholder="••••••••">
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                    <span class="text-sm text-gray-600">Ingat saya</span>
                </label>
                <a href="#" class="text-sm text-teal-600 hover:underline">Lupa Password?</a>
            </div>

            <!-- Tombol Login -->
       <button type="submit"
           class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-lg transition-colors shadow-md min-h-[48px] text-base">
           Login
       </button>
        </form>

        <!-- Divider -->
        <div class="my-6 flex items-center">
            <div class="flex-1 border-t border-gray-300"></div>
            <span class="px-3 text-sm text-gray-500">atau</span>
            <div class="flex-1 border-t border-gray-300"></div>
        </div>

        <!-- Link Daftar -->
        <p class="text-center text-sm text-gray-600">
            Belum punya akun? 
            <a href="#" class="text-teal-600 font-semibold hover:underline">Daftar Sekarang</a>
        </p>

        <!-- Kembali ke Beranda -->
        <div class="mt-6 text-center">
            <a href="{{ route('pengunjung.info') }}" class="text-sm text-gray-500 hover:text-teal-600 transition-colors">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>