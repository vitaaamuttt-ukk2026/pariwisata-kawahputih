@extends('layouts.pengelola')

@section('title', 'Operasional')

@section('content')
<!-- SECTION 2: Update Operational Info -->
<div class="flex flex-col gap-4 mb-8">
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 pb-1">
    <div>
      <h2 class="text-xl text-slate-900 font-bold tracking-tight">Pembaruan Informasi Operasional</h2>
      <p class="text-xs text-slate-500">Siarkan peringatan kondisi lingkungan real-time dan sesuaikan batas kapasitas antar sektor kawasan</p>
    </div>
  </div>
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Card 1: Weather -->
    <div class="flex flex-col justify-between p-6 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
      <div>
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
          <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
              <span class="material-symbols-outlined text-[22px]">sunny</span>
            </div>
            <div class="flex flex-col">
              <span class="text-sm font-bold text-slate-900">Kondisi Cuaca</span>
              <span class="text-xs text-slate-400">Stasiun Cuaca Dermaga</span>
            </div>
          </div>
          <span class="px-2.5 py-0.5 rounded-full bg-sky-50 text-sky-700 text-xs font-bold border border-sky-100">Siaran Langsung</span>
        </div>
        <div class="my-4 p-4 rounded-xl bg-gradient-to-br from-sky-50/70 to-teal-50/40 border border-sky-100 flex items-center justify-between">
          <div>
            <span class="text-3xl text-slate-900 font-extrabold">28°C</span>
            <span class="text-slate-400 text-sm font-medium">/ 82°F</span>
            <div class="flex items-center gap-1.5 mt-1 text-slate-700">
              <span class="material-symbols-outlined text-[16px] text-teal-600">air</span>
              <span class="text-xs font-semibold">Angin Pesisir Tenang</span>
            </div>
          </div>
        </div>
        <div class="flex flex-col gap-2">
          <label class="text-xs font-bold text-slate-700">Status Siaran Kondisi</label>
          <div class="relative">
            <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-semibold rounded-xl p-3 appearance-none focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 cursor-pointer">
              <option selected="">Cerah &amp; Tenang (Operasional Normal)</option>
              <option>Berawan Sebagian (Protokol Standar)</option>
              <option>Hujan Tropis / Angin Kencang (Peringatan)</option>
            </select>
            <span class="material-symbols-outlined absolute right-3 top-3 pointer-events-none text-slate-400 text-[18px]">expand_more</span>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Card 2: Quotas -->
    <div class="flex flex-col justify-between p-6 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
      <div>
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
          <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
              <span class="material-symbols-outlined text-[22px]">reduce_capacity</span>
            </div>
            <div class="flex flex-col">
              <span class="text-sm font-bold text-slate-900">Kuota Pengunjung</span>
              <span class="text-xs text-slate-400">Batas Daya Tampung</span>
            </div>
          </div>
          <span class="px-2.5 py-0.5 rounded-full bg-slate-900 text-white text-xs font-bold">850 / 1.200</span>
        </div>
        <div class="my-4 p-4 rounded-xl bg-slate-50 border border-slate-100 flex flex-col gap-2.5">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-slate-700">Batas Wilayah Suaka</span>
            <span class="text-base font-extrabold text-slate-900">70,8%</span>
          </div>
          <div class="w-full bg-slate-200/80 rounded-full h-3 overflow-hidden p-0.5">
            <div class="bg-gradient-to-r from-emerald-500 to-amber-500 h-full rounded-full transition-all" style="width: 70.8%"></div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Card 3: Field Info -->
    <div class="flex flex-col justify-between p-6 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
      <div>
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
          <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
              <span class="material-symbols-outlined text-[22px]">campaign</span>
            </div>
            <div class="flex flex-col">
              <span class="text-sm font-bold text-slate-900">Arahan Petugas Lapangan</span>
              <span class="text-xs text-slate-400">Instruksi Ranger &amp; Pemandu</span>
            </div>
          </div>
        </div>
        <div class="flex flex-col gap-1.5 mt-2">
          <label class="text-xs font-bold text-slate-700">Buletin Lapangan Aktif</label>
          <textarea class="w-full bg-slate-50 text-slate-800 text-xs rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 resize-none font-medium leading-relaxed" rows="4">Jalur 4 (Jembatan Kayu Mangrove) dibuka dengan peringatan jembatan licin. Seluruh kapal beroperasi sesuai jadwal interval 45 menit.</textarea>
        </div>
      </div>
      <div class="mt-6 pt-4 border-t border-slate-100">
        <button class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold flex items-center justify-center gap-2 shadow-sm shadow-emerald-600/30 transition-all">
          <span class="material-symbols-outlined text-[18px]">sync</span>
          <span>Perbarui &amp; Siarkan Sekarang</span>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- SECTION 4: Update Kunjungan -->
<div class="flex flex-col gap-5 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
  <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-3 border-b border-slate-100">
    <div class="flex flex-col">
      <div class="flex items-center gap-2.5">
        <span class="w-9 h-9 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center shrink-0">
          <span class="material-symbols-outlined text-[22px]">directions_walk</span>
        </span>
        <div class="flex items-center gap-3">
          <h2 class="text-xl text-slate-900 font-bold tracking-tight">Update Kunjungan (Pembaruan Arus Pengunjung Langsung)</h2>
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Siaran Masuk Langsung
          </span>
        </div>
      </div>
      <p class="text-xs text-slate-500 mt-1 ml-11">Monitoring lalu lintas terminal kapal, pencatatan masuk pos, serta penyesuaian daya dukung ekowisata</p>
    </div>
  </div>
  
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pt-1">
    <div class="lg:col-span-7 flex flex-col justify-between p-5 bg-slate-50/70 border border-slate-200/70 rounded-2xl gap-4">
      <div class="flex flex-col gap-3">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-teal-700 text-[20px]">anchor</span>
            <span class="text-sm font-bold text-slate-900">Pintu Masuk &amp; Dermaga (Status Gerbang Kedatangan)</span>
          </div>
          <span class="text-xs text-slate-400 font-medium">Pembaruan 10:52 WIB</span>
        </div>
        <div class="flex flex-col gap-2.5">
          <div class="flex items-center justify-between p-3 rounded-xl bg-white border border-slate-200/60 shadow-xs">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[18px]">directions_boat</span>
              </div>
              <div class="flex flex-col">
                <div class="flex items-center gap-2">
                  <span class="text-xs font-bold text-slate-800">Dermaga Utama (Ferry Marina)</span>
                  <span class="text-slate-400 text-[11px]">• 10:35 WIB</span>
                </div>
                <span class="text-xs text-slate-500">Kapal Ferry Sentosa (142 penumpang tiba)</span>
              </div>
            </div>
            <span class="px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">Selesai Boarding</span>
          </div>
        </div>
      </div>
    </div>
    
    <div class="lg:col-span-5 flex flex-col justify-between p-5 bg-slate-50/70 border border-slate-200/70 rounded-2xl gap-4">
      <div class="flex flex-col gap-3">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-emerald-700 text-[20px]">pie_chart</span>
            <span class="text-sm font-bold text-slate-900">Distribusi Zona Aktif</span>
          </div>
        </div>
        <div class="flex flex-col gap-3 mt-1">
          <div class="flex flex-col gap-1.5 p-3 rounded-xl bg-white border border-slate-200/60 shadow-xs">
            <div class="flex items-center justify-between text-xs">
              <span class="text-slate-800 font-semibold flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-500"></span>Zona Terumbu Karang</span>
              <span class="font-bold text-amber-700">320 / 400 <span class="text-slate-400 font-normal">(80% Siaga)</span></span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
              <div class="bg-amber-500 h-full rounded-full" style="width: 80%"></div>
            </div>
          </div>
          <div class="flex flex-col gap-1.5 p-3 rounded-xl bg-white border border-slate-200/60 shadow-xs">
            <div class="flex items-center justify-between text-xs">
              <span class="text-slate-800 font-semibold flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-teal-600"></span>Hutan Mangrove &amp; Kayak</span>
              <span class="font-bold text-teal-800">180 / 250 <span class="text-slate-400 font-normal">(72% Normal)</span></span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
              <div class="bg-teal-600 h-full rounded-full" style="width: 72%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
