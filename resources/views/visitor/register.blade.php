<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Kawah Putih</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-teal-100 via-cyan-100 to-blue-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Card Register -->
        <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-2xl p-8 border border-white/50">
            
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-1">Buat Akun Baru</h1>
                <p class="text-gray-600 text-sm">Daftar untuk booking tiket Kawah Putih</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 space-y-2">
                    @foreach($errors->all() as $error)
                        <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded">
                            <p class="text-red-700 text-sm">{{ $error }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Register Form -->
            <form action="{{ route('visitor.register') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all outline-none text-sm"
                           placeholder="Nama sesuai KTP">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email (Gmail)</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all outline-none text-sm"
                           placeholder="nama@gmail.com">
                </div>

                <!-- No HP -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp</label>
                    <input type="text" 
                           name="no_hp" 
                           value="{{ old('no_hp') }}" 
                           required 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all outline-none text-sm"
                           placeholder="081234567890">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" 
                           name="password" 
                           required 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all outline-none text-sm"
                           placeholder="Minimal 8 karakter">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" 
                           name="password_confirmation" 
                           required 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all outline-none text-sm"
                           placeholder="Ulangi password">
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-semibold py-3 px-4 rounded-xl hover:from-teal-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 mt-6">
                    Daftar Akun
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('visitor.login') }}" class="font-semibold text-teal-600 hover:text-teal-700 transition-colors">
                        Login di sini
                    </a>
                </p>
            </div>

            <!-- Back to Home -->
            <div class="mt-4 text-center">
                <a href="{{ route('pengunjung.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                    ← Kembali ke beranda
                </a>
            </div>
        </div>
    </div>

</body>
</html>