<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteContent;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index(): View
    {
        $contents = WebsiteContent::all()->groupBy('section');
        return view('admin.contents.index', compact('contents'));
    }

    public function edit($section): View
    {
        $contents = WebsiteContent::where('section', $section)
            ->orderBy('order')
            ->get();
        
        return view('admin.contents.edit', compact('section', 'contents'));
    }

    public function update(Request $request, $section): RedirectResponse
    {
        $validated = $request->validate([
            'contents' => 'required|array',
            'contents.*.key' => 'required|string',
            'contents.*.value' => 'nullable',
            'contents.*.type' => 'required|in:text,number,image,json',
            'contents.*.order' => 'required|integer',
            'contents.*.is_active' => 'boolean',
        ]);

        foreach ($validated['contents'] as $item) {
            $value = $item['value'];
            
            // Handle file upload untuk image
            if ($item['type'] === 'image' && $request->hasFile('file_' . $item['key'])) {
                $file = $request->file('file_' . $item['key']);
                $path = $file->store('website-contents', 'public');
                $value = Storage::url($path);
            }
            
            WebsiteContent::updateOrCreate(
                ['section' => $section, 'key' => $item['key']],
                [
                    'value' => $value,
                    'type' => $item['type'],
                    'order' => $item['order'],
                    'is_active' => $item['is_active'] ?? true,
                ]
            );
        }

        return redirect()->route('admin.contents.index')->with('success', 'Konten berhasil diperbarui!');
    }

    public function storeHero(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'background_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('background_image')) {
            $path = $request->file('background_image')->store('hero', 'public');
            WebsiteContent::set('hero', 'background_image', Storage::url($path), 'image');
        }

        WebsiteContent::set('hero', 'title', $validated['title']);
        WebsiteContent::set('hero', 'subtitle', $validated['subtitle'] ?? '');
        WebsiteContent::set('hero', 'description', $validated['description'] ?? '');

        return back()->with('success', 'Hero section berhasil diperbarui!');
    }

    public function storePhotoSpot(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo_count' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('photo-spots', 'public');
        
        $spots = WebsiteContent::getJson('photo_spots', 'spots');
        $spots[] = [
            'name' => $validated['name'],
            'photo_count' => $validated['photo_count'],
            'image' => Storage::url($path),
        ];

        WebsiteContent::setJson('photo_spots', 'spots', $spots);

        return back()->with('success', 'Spot foto berhasil ditambahkan!');
    }

    public function updatePhotoSpot(Request $request, $index): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo_count' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $spots = WebsiteContent::getJson('photo_spots', 'spots');
        
        if (isset($spots[$index])) {
            $spots[$index]['name'] = $validated['name'];
            $spots[$index]['photo_count'] = $validated['photo_count'];
            
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('photo-spots', 'public');
                $spots[$index]['image'] = Storage::url($path);
            }
            
            WebsiteContent::setJson('photo_spots', 'spots', $spots);
        }

        return back()->with('success', 'Spot foto berhasil diperbarui!');
    }

    public function deletePhotoSpot($index): RedirectResponse
    {
        $spots = WebsiteContent::getJson('photo_spots', 'spots');
        
        if (isset($spots[$index])) {
            array_splice($spots, $index, 1);
            WebsiteContent::setJson('photo_spots', 'spots', $spots);
        }

        return back()->with('success', 'Spot foto berhasil dihapus!');
    }

    public function storeHotel(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('hotels', 'public');
        
        $hotels = WebsiteContent::getJson('hotels', 'list');
        $hotels[] = [
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? '',
            'image' => Storage::url($path),
        ];

        WebsiteContent::setJson('hotels', 'list', $hotels);

        return back()->with('success', 'Rekomendasi hotel berhasil ditambahkan!');
    }

    public function updateHotel(Request $request, $index): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $hotels = WebsiteContent::getJson('hotels', 'list');
        
        if (isset($hotels[$index])) {
            $hotels[$index]['name'] = $validated['name'];
            $hotels[$index]['price'] = $validated['price'];
            $hotels[$index]['description'] = $validated['description'] ?? '';
            
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('hotels', 'public');
                $hotels[$index]['image'] = Storage::url($path);
            }
            
            WebsiteContent::setJson('hotels', 'list', $hotels);
        }

        return back()->with('success', 'Hotel berhasil diperbarui!');
    }

    public function deleteHotel($index): RedirectResponse
    {
        $hotels = WebsiteContent::getJson('hotels', 'list');
        
        if (isset($hotels[$index])) {
            array_splice($hotels, $index, 1);
            WebsiteContent::setJson('hotels', 'list', $hotels);
        }

        return back()->with('success', 'Hotel berhasil dihapus!');
    }

    public function storeMoodRecommendation(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'icon' => 'required|string',
            'color' => 'required|string',
        ]);

        $moods = WebsiteContent::getJson('mood_recommendations', 'list');
        $moods[] = [
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? '',
            'icon' => $validated['icon'],
            'color' => $validated['color'],
        ];

        WebsiteContent::setJson('mood_recommendations', 'list', $moods);

        return back()->with('success', 'Rekomendasi mood berhasil ditambahkan!');
    }

    public function updateMoodRecommendation(Request $request, $index): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'icon' => 'required|string',
            'color' => 'required|string',
        ]);

        $moods = WebsiteContent::getJson('mood_recommendations', 'list');
        
        if (isset($moods[$index])) {
            $moods[$index] = $validated;
            WebsiteContent::setJson('mood_recommendations', 'list', $moods);
        }

        return back()->with('success', 'Rekomendasi mood berhasil diperbarui!');
    }

    public function deleteMoodRecommendation($index): RedirectResponse
    {
        $moods = WebsiteContent::getJson('mood_recommendations', 'list');
        
        if (isset($moods[$index])) {
            array_splice($moods, $index, 1);
            WebsiteContent::setJson('mood_recommendations', 'list', $moods);
        }

        return back()->with('success', 'Rekomendasi mood berhasil dihapus!');
    }
}