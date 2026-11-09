<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Sedang Bermasalah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-cyan-50 to-blue-100 text-slate-800">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-3xl w-full rounded-3xl border border-white/60 bg-white/80 backdrop-blur-xl shadow-2xl overflow-hidden">
            <div class="grid md:grid-cols-2">
                <div class="p-8 md:p-12 bg-gradient-to-br from-cyan-500 to-blue-600 text-white">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]">
                        Error 500
                    </div>
                    <h1 class="mt-6 text-5xl font-black leading-none">500</h1>
                    <p class="mt-4 text-xl font-semibold">Layanan sedang terganggu</p>
                    <p class="mt-3 text-sm text-cyan-50/90">
                        Tim kami sedang menanganinya. Mohon coba kembali beberapa saat lagi.
                    </p>
                </div>

                <div class="p-8 md:p-12 flex flex-col justify-center">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-12 w-12 rounded-2xl bg-cyan-100 text-cyan-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Kawah Putih</p>
                            <h2 class="text-2xl font-bold text-slate-800">Kami sedang memperbaiki sistem</h2>
                        </div>
                    </div>

                    <p class="text-slate-600 mb-6">
                        {{ $message ?? 'Terjadi masalah pada sistem. Tim teknis telah menerima laporan dan sedang memperbaiki masalah ini.' }}
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ url('/') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-700">
                            Kembali ke beranda
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Login ulang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
