<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminPaketController extends Controller
{
    public function index(): View
    {
        $pakets = Paket::orderBy('kategori')->orderBy('urutan')->get();
        return view('admin.paket.index', compact('pakets'));
    }

    public function create(): View
    {
        return view('admin.paket.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|integer|min:0',
            'kategori' => 'required|in:tiket_masuk,paket_bundle,transportasi,wahana,layanan',
            'icon' => 'nullable|string|max:50',
            'badge' => 'nullable|string|max:50',
            'badge_color' => 'nullable|in:primary,secondary,tertiary',
            'is_active' => 'boolean',
            'urutan' => 'integer|min:0',
        ]);

        Paket::create($validated);

        return redirect()->route('admin.paket.index')->with('success', 'Paket wisata berhasil ditambahkan!');
    }

    public function edit($id): View
    {
        $paket = Paket::findOrFail($id);
        return view('admin.paket.edit', compact('paket'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $paket = Paket::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|integer|min:0',
            'kategori' => 'required|in:tiket_masuk,paket_bundle,transportasi,wahana,layanan',
            'icon' => 'nullable|string|max:50',
            'badge' => 'nullable|string|max:50',
            'badge_color' => 'nullable|in:primary,secondary,tertiary',
            'is_active' => 'boolean',
            'urutan' => 'integer|min:0',
        ]);

        $paket->update($validated);

        return redirect()->route('admin.paket.index')->with('success', 'Paket wisata berhasil diperbarui!');
    }

    public function destroy($id): RedirectResponse
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();

        return redirect()->route('admin.paket.index')->with('success', 'Paket wisata berhasil dihapus!');
    }
}