<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-amber-50 to-orange-100 text-slate-800">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-3xl w-full rounded-3xl border border-white/60 bg-white/80 backdrop-blur-xl shadow-2xl overflow-hidden">
            <div class="grid md:grid-cols-2">
                <div class="p-8 md:p-12 bg-gradient-to-br from-amber-500 to-orange-500 text-white">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]">
                        Error 404
                    </div>
                    <h1 class="mt-6 text-5xl font-black leading-none">404</h1>
                    <p class="mt-4 text-xl font-semibold">Halaman tidak ditemukan</p>
                    <p class="mt-3 text-sm text-amber-50/90">
                        Halaman yang Anda cari mungkin sudah dipindahkan, dihapus, atau tidak tersedia saat ini.
                    </p>
                </div>

                <div class="p-8 md:p-12 flex flex-col justify-center">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-12 w-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Kawah Putih</p>
                            <h2 class="text-2xl font-bold text-slate-800">Oops, halaman ini tidak ada.</h2>
                        </div>
                    </div>

                    <p class="text-slate-600 mb-6">
                        Jangan khawatir. Anda tetap bisa melanjutkan aktivitas dengan kembali ke halaman utama atau menu yang sesuai.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ url('/') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-700">
                            Kembali ke beranda
                        </a>
                        <a href="{{ url()->previous() ?: url('/') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Halaman sebelumnya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
