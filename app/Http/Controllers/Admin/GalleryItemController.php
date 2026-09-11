<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryItemController extends Controller
{
    /**
     * Menampilkan form tambah foto.
     */
    public function create(Gallery $gallery): View
    {
        $nextUrutan = ((int) $gallery->items()->max('urutan')) + 1;

        return view('admin.gallery.items.create', compact(
            'gallery',
            'nextUrutan'
        ));
    }

    /**
     * Menyimpan foto baru.
     */
    public function store(
        Request $request,
        Gallery $gallery
    ): RedirectResponse {
        $validated = $request->validate([
            'file' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'judul' => [
                'nullable',
                'string',
                'max:255',
            ],
            'caption' => [
                'nullable',
                'string',
            ],
            'urutan' => [
                'required',
                'integer',
                'min:0',
            ],
        ], [
            'file.required' => 'Foto wajib dipilih.',
            'file.image' => 'File yang dipilih harus berupa gambar.',
            'file.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'file.max' => 'Ukuran foto maksimal 5 MB.',
            'judul.max' => 'Judul foto maksimal 255 karakter.',
            'urutan.required' => 'Urutan foto wajib diisi.',
            'urutan.integer' => 'Urutan foto harus berupa angka.',
            'urutan.min' => 'Urutan foto tidak boleh kurang dari 0.',
        ]);

        /*
         * Upload foto ke:
         * storage/app/public/gallery/items
         */
        $path = $request->file('file')->store(
            'gallery/items',
            'public'
        );

        $validated['gallery_id'] = $gallery->id;
        $validated['file'] = $path;

        GalleryItem::create($validated);

        return redirect()
            ->route('admin.gallery.show', $gallery)
            ->with('success', 'Foto berhasil ditambahkan ke gallery.');
    }

    /**
     * Menampilkan form edit foto.
     */
    public function edit(
        Gallery $gallery,
        GalleryItem $galleryItem
    ): View {
        /*
         * Pastikan foto memang milik gallery yang sedang dibuka.
         */
        abort_unless(
            $galleryItem->gallery_id === $gallery->id,
            404
        );

        return view('admin.gallery.items.edit', compact(
            'gallery',
            'galleryItem'
        ));
    }

    /**
     * Memperbarui foto.
     */
    public function update(
        Request $request,
        Gallery $gallery,
        GalleryItem $galleryItem
    ): RedirectResponse {
        /*
         * Pastikan foto memang milik gallery yang sedang dibuka.
         */
        abort_unless(
            $galleryItem->gallery_id === $gallery->id,
            404
        );

        $validated = $request->validate([
            'file' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'judul' => [
                'nullable',
                'string',
                'max:255',
            ],
            'caption' => [
                'nullable',
                'string',
            ],
            'urutan' => [
                'required',
                'integer',
                'min:0',
            ],
        ], [
            'file.image' => 'File yang dipilih harus berupa gambar.',
            'file.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'file.max' => 'Ukuran foto maksimal 5 MB.',
            'judul.max' => 'Judul foto maksimal 255 karakter.',
            'urutan.required' => 'Urutan foto wajib diisi.',
            'urutan.integer' => 'Urutan foto harus berupa angka.',
            'urutan.min' => 'Urutan foto tidak boleh kurang dari 0.',
        ]);

        /*
         * Jika user memilih foto baru,
         * hapus foto lama kemudian simpan foto baru.
         */
        if ($request->hasFile('file')) {

            if ($galleryItem->file) {
                Storage::disk('public')->delete(
                    $galleryItem->file
                );
            }

            $validated['file'] = $request->file('file')->store(
                'gallery/items',
                'public'
            );
        } else {
            unset($validated['file']);
        }

        /*
         * gallery_id tidak boleh berubah.
         */
        unset($validated['gallery_id']);

        $galleryItem->update($validated);

        return redirect()
            ->route('admin.gallery.show', $gallery)
            ->with('success', 'Foto berhasil diperbarui.');
    }

    /**
     * Menghapus foto.
     */
    public function destroy(
        Gallery $gallery,
        GalleryItem $galleryItem
    ): RedirectResponse {
        /*
         * Pastikan foto memang milik gallery yang sedang dibuka.
         */
        abort_unless(
            $galleryItem->gallery_id === $gallery->id,
            404
        );

        /*
         * Hapus file fisik dari storage.
         */
        if ($galleryItem->file) {
            Storage::disk('public')->delete(
                $galleryItem->file
            );
        }

        $galleryItem->delete();

        return redirect()
            ->route('admin.gallery.show', $gallery)
            ->with('success', 'Foto berhasil dihapus dari gallery.');
    }
}