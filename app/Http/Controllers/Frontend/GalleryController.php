<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Gallery::where('status', 'published')
            ->with(['items', 'user']);

        if ($request->filled('search')) {
            $search = (string) $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $galleries = $query->latest('tanggal')
            ->latest('id')
            ->paginate(9)
            ->withQueryString();

        return view('frontend.gallery.index', compact('galleries'));
    }

    public function album(Gallery $gallery): View
    {
        // Hanya tampilkan yang published
        abort_unless($gallery->status === 'published', 404);

        $gallery->load([
            'items' => fn ($q) => $q->orderBy('urutan')->orderBy('id'),
        ]);

        // Album lainnya untuk rekomendasi
        $otherGalleries = Gallery::where('status', 'published')
            ->where('id', '!=', $gallery->id)
            ->with('items')
            ->latest('tanggal')
            ->limit(3)
            ->get();

        return view('frontend.gallery.album', compact('gallery', 'otherGalleries'));
    }
}