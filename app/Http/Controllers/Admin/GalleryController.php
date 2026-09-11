<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * Menampilkan daftar gallery.
     */
    public function index(Request $request): View
    {
        $query = Gallery::query()
            ->with('user');

        if ($request->filled('search')) {
            $search = (string) $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $galleries = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Menampilkan form tambah gallery.
     */
    public function create(): View
    {
        return view('admin.gallery.create');
    }

    /**
     * Menyimpan gallery baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:galleries,slug',
            ],
            'deskripsi' => [
                'nullable',
                'string',
            ],
            'cover' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'tanggal' => [
                'nullable',
                'date',
            ],
            'status' => [
                'required',
                'in:draft,published,archived',
            ],
        ], [
            'nama.required' => 'Nama gallery wajib diisi.',
            'nama.max' => 'Nama gallery maksimal 255 karakter.',
            'slug.unique' => 'Slug tersebut sudah digunakan.',
            'cover.image' => 'Cover harus berupa gambar.',
            'cover.mimes' => 'Cover harus berformat JPG, JPEG, PNG, atau WEBP.',
            'cover.max' => 'Ukuran cover maksimal 5 MB.',
            'tanggal.date' => 'Tanggal tidak valid.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama']);
        }

        /*
         * Pastikan slug unik jika slug otomatis bentrok.
         */
        $originalSlug = $validated['slug'];
        $counter = 1;

        while (
            Gallery::where('slug', $validated['slug'])->exists()
        ) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        /*
         * User yang sedang login menjadi pemilik/pembuat gallery.
         */
        $validated['user_id'] = auth()->id();

        /*
         * Upload cover jika ada.
         */
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store(
                'gallery/covers',
                'public'
            );
        }

        $gallery = Gallery::create($validated);

        return redirect()
            ->route('admin.gallery.show', $gallery)
            ->with('success', 'Gallery berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail gallery.
     */
    public function show(Gallery $gallery): View
    {
        $gallery->load([
            'user',
            'items' => function ($query) {
                $query->orderBy('urutan')
                    ->orderBy('id');
            },
        ]);

        return view('admin.gallery.show', compact('gallery'));
    }

    /**
     * Menampilkan form edit gallery.
     */
    public function edit(Gallery $gallery): View
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Memperbarui gallery.
     */
    public function update(
        Request $request,
        Gallery $gallery
    ): RedirectResponse {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:galleries,slug,' . $gallery->id,
            ],
            'deskripsi' => [
                'nullable',
                'string',
            ],
            'cover' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'tanggal' => [
                'nullable',
                'date',
            ],
            'status' => [
                'required',
                'in:draft,published,archived',
            ],
        ], [
            'nama.required' => 'Nama gallery wajib diisi.',
            'nama.max' => 'Nama gallery maksimal 255 karakter.',
            'slug.unique' => 'Slug tersebut sudah digunakan.',
            'cover.image' => 'Cover harus berupa gambar.',
            'cover.mimes' => 'Cover harus berformat JPG, JPEG, PNG, atau WEBP.',
            'cover.max' => 'Ukuran cover maksimal 5 MB.',
            'tanggal.date' => 'Tanggal tidak valid.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama']);
        }

        /*
         * Pastikan slug tidak bentrok dengan gallery lain.
         */
        $originalSlug = $validated['slug'];
        $counter = 1;

        while (
            Gallery::where('slug', $validated['slug'])
                ->where('id', '!=', $gallery->id)
                ->exists()
        ) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        /*
         * Upload cover baru jika ada.
         */
        if ($request->hasFile('cover')) {

            if ($gallery->cover) {
                Storage::disk('public')->delete($gallery->cover);
            }

            $validated['cover'] = $request->file('cover')->store(
                'gallery/covers',
                'public'
            );
        } else {
            unset($validated['cover']);
        }

        /*
         * Jangan mengubah user_id saat edit.
         */
        unset($validated['user_id']);

        $gallery->update($validated);

        return redirect()
            ->route('admin.gallery.show', $gallery)
            ->with('success', 'Gallery berhasil diperbarui.');
    }

    /**
     * Menghapus gallery.
     */
    public function destroy(Gallery $gallery): RedirectResponse
    {
        /*
         * Jangan hapus gallery yang masih memiliki foto.
         */
        if ($gallery->items()->exists()) {
            return redirect()
                ->route('admin.gallery.index')
                ->with(
                    'error',
                    'Gallery tidak dapat dihapus karena masih memiliki foto.'
                );
        }

        /*
         * Hapus cover dari storage.
         */
        if ($gallery->cover) {
            Storage::disk('public')->delete($gallery->cover);
        }

        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Gallery berhasil dihapus.');
    }
}