@extends('layouts.panel')
@section('title', 'Kelola Tips')
@section('page-title', 'Kelola Tips Pengunjung')

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
            <h1 class="text-2xl font-bold text-gray-800">Kelola Tips Pengunjung</h1>
            <p class="text-sm text-gray-500 mt-1">Tambah, edit, atau hapus tips untuk pengunjung</p>
        </div>
        <button onclick="openModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-lg font-semibold flex items-center gap-2">
            <span class="material-symbols-outlined">add</span>
            Tambah Tips
        </button>
    </div>

    <!-- List Tips -->
    <div class="space-y-3">
        @forelse($tips as $tip)
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-2xl">{{ $tip['icon'] ?? 'lightbulb' }}</span>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 mb-1">{{ $tip['title'] }}</h3>
                    <p class="text-sm text-gray-600">{{ $tip['content'] }}</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="editTip('{{ $tip['id'] }}', '{{ $tip['title'] }}', '{{ $tip['content'] }}', '{{ $tip['icon'] ?? 'lightbulb' }}')" class="text-blue-600 hover:bg-blue-50 p-2 rounded-lg transition-colors">
                        <span class="material-symbols-outlined">edit</span>
                    </button>
                    <form method="POST" action="{{ route('admin.tips.delete', $tip['id']) }}" class="inline" onsubmit="return confirm('Hapus tips ini?')">
                        @csrf
                        <button class="text-red-600 hover:bg-red-50 p-2 rounded-lg transition-colors">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-gray-50 rounded-xl">
            <span class="material-symbols-outlined text-4xl text-gray-400 mb-2">tips_and_updates</span>
            <p class="text-gray-500">Belum ada tips yang ditambahkan.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Tambah/Edit -->
<div id="tipModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-lg mx-4">
        <h3 class="text-xl font-bold mb-4" id="modalTitle">Tambah Tips</h3>
        <form id="tipForm" method="POST" action="{{ route('admin.tips.add') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Tips</label>
                <input type="text" name="title" id="tipTitle" required class="w-full border border-gray-300 rounded-lg p-2.5" placeholder="Contoh: Pakaian Hangat">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Isi Tips</label>
                <textarea name="content" id="tipContent" required rows="3" class="w-full border border-gray-300 rounded-lg p-2.5" placeholder="Deskripsi lengkap tips..."></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Icon (Material Symbols)</label>
                <input type="text" name="icon" id="tipIcon" class="w-full border border-gray-300 rounded-lg p-2.5" placeholder="lightbulb, info, warning, etc">
                <p class="text-xs text-gray-500 mt-1">Kosongkan untuk default (lightbulb)</p>
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
    document.getElementById('tipModal').classList.remove('hidden');
    document.getElementById('modalTitle').textContent = 'Tambah Tips';
    document.getElementById('tipForm').action = "{{ route('admin.tips.add') }}";
    document.getElementById('tipTitle').value = '';
    document.getElementById('tipContent').value = '';
    document.getElementById('tipIcon').value = '';
}

function closeModal() {
    document.getElementById('tipModal').classList.add('hidden');
}

function editTip(id, title, content, icon) {
    document.getElementById('tipModal').classList.remove('hidden');
    document.getElementById('modalTitle').textContent = 'Edit Tips';
    document.getElementById('tipForm').action = "{{ url('admin/tips') }}/" + id;
    document.getElementById('tipTitle').value = title;
    document.getElementById('tipContent').value = content;
    document.getElementById('tipIcon').value = icon;
}
</script>
@endsection