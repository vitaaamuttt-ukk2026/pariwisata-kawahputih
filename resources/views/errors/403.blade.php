<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-100 via-red-50 to-rose-100 text-slate-800">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-3xl w-full rounded-3xl border border-white/60 bg-white/80 backdrop-blur-xl shadow-2xl overflow-hidden">
            <div class="grid md:grid-cols-2">
                <div class="p-8 md:p-12 bg-gradient-to-br from-red-500 to-rose-500 text-white">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]">
                        Error 403
                    </div>
                    <h1 class="mt-6 text-5xl font-black leading-none">403</h1>
                    <p class="mt-4 text-xl font-semibold">Akses ditolak</p>
                    <p class="mt-3 text-sm text-red-50/90">
                        Anda tidak memiliki izin untuk membuka halaman ini.
                    </p>
                </div>

                <div class="p-8 md:p-12 flex flex-col justify-center">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-12 w-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m0-10v5m-7 8h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Kawah Putih</p>
                            <h2 class="text-2xl font-bold text-slate-800">Akses terbatas</h2>
                        </div>
                    </div>

                    <p class="text-slate-600 mb-6">
                        Silakan masuk menggunakan akun yang sesuai untuk halaman ini, atau kembali ke dashboard Anda.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-700">
                            Login ulang
                        </a>
                        <a href="{{ url('/') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Kembali ke beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
