@extends('layouts.panel')
@section('title', 'Kelola Harga')
@section('page-title', 'Kelola Harga Tiket & Layanan')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
</script>
@endif

<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Harga Tiket & Layanan</h1>
            <p class="text-sm text-gray-500 mt-1">Tambah, edit, atau hapus harga tiket dan layanan</p>
        </div>
        <button onclick="openModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-lg font-semibold flex items-center gap-2">
            <span class="material-symbols-outlined">add</span>
            Tambah Harga
        </button>
    </div>

    <!-- List Harga -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($prices as $price)
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <span class="inline-block px-2 py-1 bg-{{ $price['category'] === 'tiket' ? 'blue' : ($price['category'] === 'layanan' ? 'purple' : 'amber') }}-100 text-{{ $price['category'] === 'tiket' ? 'blue' : ($price['category'] === 'layanan' ? 'purple' : 'amber') }}-700 text-xs rounded-full font-semibold mb-2">
                        {{ ucfirst($price['category']) }}
                    </span>
                    <h3 class="font-bold text-gray-800">{{ $price['name'] }}</h3>
                </div>
                <div class="flex gap-2">
                    <button onclick="editPrice('{{ $price['id'] }}', '{{ $price['name'] }}', {{ $price['price'] }}, '{{ $price['category'] }}')" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-lg">edit</span>
                    </button>
                    <form method="POST" action="{{ route('admin.prices.delete', $price['id']) }}" class="inline" onsubmit="return confirm('Hapus harga ini?')">
                        @csrf
                        <button class="text-red-600 hover:bg-red-50 p-1.5 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                    </form>
                </div>
            </div>
            <div class="text-2xl font-bold text-emerald-600">Rp {{ number_format($price['price'], 0, ',', '.') }}</div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 bg-gray-50 rounded-xl">
            <span class="material-symbols-outlined text-4xl text-gray-400 mb-2">payments</span>
            <p class="text-gray-500">Belum ada harga yang ditambahkan.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Tambah/Edit -->
<div id="priceModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
        <h3 class="text-xl font-bold mb-4" id="modalTitle">Tambah Harga</h3>
        <form id="priceForm" method="POST" action="{{ route('admin.prices.add') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan/Tiket</label>
                <input type="text" name="name" id="priceName" required class="w-full border border-gray-300 rounded-lg p-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                <input type="number" name="price" id="priceValue" required min="0" class="w-full border border-gray-300 rounded-lg p-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category" id="priceCategory" required class="w-full border border-gray-300 rounded-lg p-2.5">
                    <option value="tiket">Tiket Masuk</option>
                    <option value="layanan">Layanan</option>
                    <option value="parking">Parkir</option>
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal()" class="flex-1 border border-gray-300 text-gray-700 py-2.5 rounded-lg font-semibold hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 bg-emerald-600 text-white py-2.5 rounded-lg font-semibold hover:bg-emerald-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('priceModal').classList.remove('hidden');
    document.getElementById('modalTitle').textContent = 'Tambah Harga';
    document.getElementById('priceForm').action = "{{ route('admin.prices.add') }}";
    document.getElementById('priceName').value = '';
    document.getElementById('priceValue').value = '';
    document.getElementById('priceCategory').value = 'tiket';
}

function closeModal() {
    document.getElementById('priceModal').classList.add('hidden');
}

function editPrice(id, name, price, category) {
    document.getElementById('priceModal').classList.remove('hidden');
    document.getElementById('modalTitle').textContent = 'Edit Harga';
    document.getElementById('priceForm').action = "{{ url('admin/prices') }}/" + id;
    document.getElementById('priceName').value = name;
    document.getElementById('priceValue').value = price;
    document.getElementById('priceCategory').value = category;
}
</script>
@endsection