<?php

namespace App\Http\Controllers;

use App\Models\InfoContent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Booking;
use App\Models\Paket;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'pendapatan' => (int) Booking::lunas()->sum('total_bayar'),
            'lunas'      => Booking::lunas()->count(),
            'pending'    => Booking::where('status', 'pending')->count(),
            'dibatalkan' => Booking::batal()->count(),
        ];

        $chartLabels = [];
        $chartRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartRevenue[] = (int) Booking::whereDate('created_at', $date)
                ->lunas()
                ->sum('total_bayar');
        }

        $statusCounts = [
            'paid' => $stats['lunas'],
            'pending' => $stats['pending'],
            'cancelled' => $stats['dibatalkan'],
        ];

        $bookings = Booking::latest()->paginate(15);
        return view('admin.dashboard', compact('stats', 'chartLabels', 'chartRevenue', 'statusCounts', 'bookings'));
    }

    public function wisata(): View { return view('admin.wisata'); }
    public function penginapan(): View { return view('admin.penginapan'); }
    
    public function booking(): View
    {
        $bookings = Booking::latest()->get();
        return view('admin.booking', compact('bookings'));
    }

    public function verifyBooking($id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $booking = Booking::where('id', $id)->where('status', 'pending')->firstOrFail();
                $booking->update(['status' => Booking::STATUS_VERIFIED, 'paid_at' => now()]);
            });
            return back()->with('success', 'Booking berhasil diverifikasi! E-Tiket telah diterbitkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memverifikasi booking: ' . $e->getMessage());
        }
    }

    public function cancelBooking($id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $booking = Booking::where('id', $id)->whereIn('status', array_merge(['pending'], Booking::STATUS_LUNAS))->firstOrFail();
                $booking->update(['status' => Booking::STATUS_REJECTED]);
            });
            return back()->with('success', 'Booking berhasil dibatalkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membatalkan booking: ' . $e->getMessage());
        }
    }

    public function pengelola(): View
    {
        $pengelola = User::where('role', 'pengelola')->orderBy('name')->get();
        return view('admin.pengelola', compact('pengelola'));
    }

    public function storePengelola(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'pengelola',
        ]);

        return back()->with('success', "Akun pengelola {$data['name']} berhasil dibuat.");
    }

    public function destroyPengelola(User $user): RedirectResponse
    {
        abort_unless($user->role === 'pengelola', 404);
        $user->delete();
        return back()->with('success', "Akun {$user->name} dihapus.");
    }

    public function updatePengelola(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->role === 'pengelola', 404);
        $validated = $request->validate(['name' => ['required', 'string', 'max:255']]);
        $user->update($validated);
        return redirect()->route('admin.pengelola')->with('success', "Nama pengelola berhasil diubah.");
    }

    public function paketIndex(): View { return view('admin.paket.index', ['pakets' => Paket::orderBy('kategori')->orderBy('urutan')->get()]); }
    public function paketCreate(): View { return view('admin.paket.create'); }
    
    public function paketStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255', 'harga' => 'required|numeric|min:0',
            'kategori' => 'required|in:tiket_masuk,paket_bundle,transportasi,wahana,layanan',
            'urutan' => 'required|integer|min:0', 'icon' => 'nullable|string',
            'badge' => 'nullable|string|max:50', 'badge_color' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string', 'is_active' => 'boolean',
        ]);

        if (empty($validated['icon'])) {
            $defaults = ['tiket_masuk' => 'badge', 'paket_bundle' => 'card_travel', 'transportasi' => 'directions_bus', 'wahana' => 'sports_esports', 'layanan' => 'room_service'];
            $validated['icon'] = $defaults[$validated['kategori']] ?? 'info';
        }

        Paket::create($validated);
        return redirect()->route('admin.paket.index')->with('success', 'Paket wisata berhasil ditambahkan!');
    }
    
    public function paketEdit($id): View { return view('admin.paket.edit', ['paket' => Paket::findOrFail($id)]); }
    
    public function paketUpdate(Request $request, $id): RedirectResponse 
    { 
        $paket = Paket::findOrFail($id);
        $paket->update($request->all()); 
        return redirect()->route('admin.paket.index')->with('success', 'Paket wisata berhasil diperbarui!'); 
    }
    
    public function paketDestroy($id): RedirectResponse 
    { 
        Paket::findOrFail($id)->delete(); 
        return redirect()->route('admin.paket.index')->with('success', 'Paket wisata berhasil dihapus!'); 
    }

    // ==========================================
    // 1. EDIT INFORMASI (KHUSUS HALAMAN /info)
    // ==========================================
        public function editInfo(): View
    {
        $info = InfoContent::all()->pluck('value', 'key')->toArray();
        
        $heroImage = $info['hero_image'] ?? '';
        $photoSpots = json_decode($info['photo_spots'] ?? '[]', true) ?: [];
        $hotels = json_decode($info['hotels'] ?? '[]', true) ?: [];
        $gallery = json_decode($info['gallery'] ?? '[]', true) ?: [];

        return view('admin.edit-info', compact('info', 'heroImage', 'photoSpots', 'hotels', 'gallery'));
    }
    public function updateInfo(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'sejarah' => 'required|string', 'lokasi' => 'required|string',
                'jam_operasional' => 'required|string', 'fasilitas' => 'required|string',
                'tiket_domestik' => 'required|numeric', 'tiket_mancanegara' => 'required|numeric',
                'shuttle_price' => 'required|numeric', 'parkir_motor' => 'required|numeric',
                'parkir_mobil' => 'required|numeric', 'tips_1' => 'nullable|string',
                'tips_2' => 'nullable|string', 'tips_3' => 'nullable|string', 'tips_4' => 'nullable|string',
            ]);

            foreach ($validated as $key => $value) {
                InfoContent::set($key, $value);
            }

            return back()->with('success', 'Informasi teks berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    // ==========================================
    // 2. EDIT DASHBOARD (KHUSUS HALAMAN UTAMA /)
    // ==========================================
    public function editDashboard(): View
    {
        return view('admin.edit-dashboard', [
            'heroImage' => InfoContent::get('hero_image', ''),
            'photoSpots' => json_decode(InfoContent::get('photo_spots', '[]'), true) ?: [],
            'hotels' => json_decode(InfoContent::get('hotels', '[]'), true) ?: [],
            'gallery' => json_decode(InfoContent::get('gallery', '[]'), true) ?: [],
        ]);
    }

            public function updateDashboardHero(Request $request): RedirectResponse
    {
        try {
            // Debug: tampilkan semua data request
            \Log::info('Upload attempt:', [
                'has_file' => $request->hasFile('hero_image'),
                'all_input' => $request->all(),
                'files' => $request->file('hero_image'),
            ]);

            if (!$request->hasFile('hero_image')) {
                return back()->with('error', 'File tidak terdeteksi. Pastikan pilih file JPG/PNG.');
            }

            $file = $request->file('hero_image');
            
            if (!$file->isValid()) {
                return back()->with('error', 'File corrupt: ' . $file->getErrorMessage());
            }

            $fileName = time() . '_' . uniqid() . '.jpg';
            $destinationPath = public_path('hero');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $file->move($destinationPath, $fileName);
            InfoContent::set('hero_image', '/hero/' . $fileName);
            
            return back()->with('success', 'Foto berhasil diupload: ' . $fileName);
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ':' . $e->getLine());
        }
    }

    public function addDashboardPhotoSpot(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'spot_name' => 'required|string', 'spot_count' => 'required|string',
                'spot_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);

            $file = $request->file('spot_image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('photo-spots');
            
            if (!file_exists($destinationPath)) mkdir($destinationPath, 0777, true);
            $file->move($destinationPath, $fileName);
            
            $spots = json_decode(InfoContent::get('photo_spots', '[]'), true) ?: [];
            $spots[] = ['name' => $validated['spot_name'], 'count' => $validated['spot_count'], 'image' => '/photo-spots/' . $fileName];
            InfoContent::set('photo_spots', json_encode($spots));

            return back()->with('success', 'Spot foto berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function deleteDashboardPhotoSpot($index): RedirectResponse
    {
        $spots = json_decode(InfoContent::get('photo_spots', '[]'), true) ?: [];
        if (isset($spots[$index])) {
            array_splice($spots, $index, 1);
            InfoContent::set('photo_spots', json_encode($spots));
        }
        return back()->with('success', 'Spot foto dihapus!');
    }

    public function addDashboardHotel(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'hotel_name' => 'required|string', 'hotel_price' => 'required|string',
                'hotel_desc' => 'nullable|string', 'hotel_link' => 'nullable|url',
                'hotel_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);

            $file = $request->file('hotel_image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('hotels');
            
            if (!file_exists($destinationPath)) mkdir($destinationPath, 0777, true);
            $file->move($destinationPath, $fileName);
            
            $hotels = json_decode(InfoContent::get('hotels', '[]'), true) ?: [];
            $hotels[] = [
                'name' => $validated['hotel_name'], 'price' => $validated['hotel_price'],
                'desc' => $validated['hotel_desc'] ?? '', 'link' => $validated['hotel_link'] ?? '',
                'image' => '/hotels/' . $fileName,
            ];
            InfoContent::set('hotels', json_encode($hotels));

            return back()->with('success', 'Hotel berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function deleteDashboardHotel($index): RedirectResponse
    {
        $hotels = json_decode(InfoContent::get('hotels', '[]'), true) ?: [];
        if (isset($hotels[$index])) {
            array_splice($hotels, $index, 1);
            InfoContent::set('hotels', json_encode($hotels));
        }
        return back()->with('success', 'Hotel dihapus!');
    }

    public function addDashboardGallery(Request $request): RedirectResponse
    {
        try {
            $request->validate(['gallery_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120']);

            $file = $request->file('gallery_image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('gallery');
            
            if (!file_exists($destinationPath)) mkdir($destinationPath, 0777, true);
            $file->move($destinationPath, $fileName);
            
            $gallery = json_decode(InfoContent::get('gallery', '[]'), true) ?: [];
            $gallery[] = '/gallery/' . $fileName;
            InfoContent::set('gallery', json_encode($gallery));

            return back()->with('success', 'Foto galeri ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function deleteDashboardGallery($index): RedirectResponse
    {
        $gallery = json_decode(InfoContent::get('gallery', '[]'), true) ?: [];
        if (isset($gallery[$index])) {
            array_splice($gallery, $index, 1);
            InfoContent::set('gallery', json_encode($gallery));
        }
        return back()->with('success', 'Foto galeri dihapus!');
    }

        // ==========================================
    // MANAGE HARGA TIKET & LAYANAN (DINAMIS)
    // ==========================================
    public function managePrices(): View
    {
        $prices = json_decode(InfoContent::get('ticket_prices', '[]'), true) ?: [];
        return view('admin.manage-prices', compact('prices'));
    }

    public function addPrice(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'category' => 'required|in:tiket,layanan,parking',
            ]);

            $prices = json_decode(InfoContent::get('ticket_prices', '[]'), true) ?: [];
            $prices[] = [
                'id' => uniqid(),
                'name' => $validated['name'],
                'price' => $validated['price'],
                'category' => $validated['category'],
                'is_active' => true,
            ];
            InfoContent::set('ticket_prices', json_encode($prices));

            return back()->with('success', 'Harga berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function updatePrice($id, Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'category' => 'required|in:tiket,layanan,parking',
            ]);

            $prices = json_decode(InfoContent::get('ticket_prices', '[]'), true) ?: [];
            foreach ($prices as &$price) {
                if ($price['id'] === $id) {
                    $price['name'] = $validated['name'];
                    $price['price'] = $validated['price'];
                    $price['category'] = $validated['category'];
                    break;
                }
            }
            InfoContent::set('ticket_prices', json_encode($prices));

            return back()->with('success', 'Harga berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function deletePrice($id): RedirectResponse
    {
        try {
            $prices = json_decode(InfoContent::get('ticket_prices', '[]'), true) ?: [];
            $prices = array_filter($prices, function($price) use ($id) {
                return $price['id'] !== $id;
            });
            InfoContent::set('ticket_prices', json_encode(array_values($prices)));

            return back()->with('success', 'Harga berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    // ==========================================
    // MANAGE TIPS (DINAMIS)
    // ==========================================
    public function manageTips(): View
    {
        $tips = json_decode(InfoContent::get('tips_list', '[]'), true) ?: [];
        return view('admin.manage-tips', compact('tips'));
    }

    public function addTip(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'icon' => 'nullable|string|max:50',
            ]);

            $tips = json_decode(InfoContent::get('tips_list', '[]'), true) ?: [];
            $tips[] = [
                'id' => uniqid(),
                'title' => $validated['title'],
                'content' => $validated['content'],
                'icon' => $validated['icon'] ?? 'info',
                'is_active' => true,
            ];
            InfoContent::set('tips_list', json_encode($tips));

            return back()->with('success', 'Tips berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function updateTip($id, Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'icon' => 'nullable|string|max:50',
            ]);

            $tips = json_decode(InfoContent::get('tips_list', '[]'), true) ?: [];
            foreach ($tips as &$tip) {
                if ($tip['id'] === $id) {
                    $tip['title'] = $validated['title'];
                    $tip['content'] = $validated['content'];
                    $tip['icon'] = $validated['icon'] ?? 'info';
                    break;
                }
            }
            InfoContent::set('tips_list', json_encode($tips));

            return back()->with('success', 'Tips berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function deleteTip($id): RedirectResponse
    {
        try {
            $tips = json_decode(InfoContent::get('tips_list', '[]'), true) ?: [];
            $tips = array_filter($tips, function($tip) use ($id) {
                return $tip['id'] !== $id;
            });
            InfoContent::set('tips_list', json_encode(array_values($tips)));

            return back()->with('success', 'Tips berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}