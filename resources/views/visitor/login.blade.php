<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengunjung - Kawah Putih</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-teal-100 via-cyan-100 to-blue-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Card Login -->
        <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-2xl p-8 border border-white/50">
            
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-1">Portal Wisatawan</h1>
                <p class="text-gray-600 text-sm">Kawah Putih Ciwidey</p>
            </div>

            <!-- Error Message -->
            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    <p class="text-red-700 text-sm">{{ $errors->first('email') }}</p>
                </div>
            @endif

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                    <p class="text-green-700 text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('visitor.login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all outline-none text-sm"
                               placeholder="nama@gmail.com">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input type="password" 
                               name="password" 
                               required 
                               class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all outline-none text-sm"
                               placeholder="••••••••">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="remember" 
                               class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm text-teal-600 hover:text-teal-700 font-medium">Lupa password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-semibold py-3 px-4 rounded-xl hover:from-teal-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Masuk ke Akun
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-6 relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">atau</span>
                </div>
            </div>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('visitor.register') }}" class="font-semibold text-teal-600 hover:text-teal-700 transition-colors">
                        Daftar sekarang
                    </a>
                </p>
            </div>

            <!-- Back to Home -->
            <div class="mt-6 text-center">
                <a href="{{ route('pengunjung.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                    ← Kembali ke beranda
                </a>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-gray-500 mt-6">
            © {{ date('Y') }} Kawah Putih Ciwidey. All rights reserved.
        </p>
    </div>

</body>
</html>