<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
     * Menyimpan banyak foto sekaligus.
     */
    public function store(Request $request, Gallery $gallery): RedirectResponse
    {
        $request->validate([
            'files' => [
                'required',
                'array',
                'max:10',
            ],
            'files.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'files.required' => 'Minimal pilih 1 foto untuk di-upload.',
            'files.array' => 'Format file tidak valid.',
            'files.max' => 'Maksimal 10 foto per upload.',
            'files.*.image' => 'Semua file harus berupa gambar.',
            'files.*.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'files.*.max' => 'Ukuran tiap foto maksimal 5 MB.',
        ]);

        $lastUrutan = (int) $gallery->items()->max('urutan');

        $uploadedCount = 0;

        foreach ($request->file('files') as $index => $file) {

            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $judul = Str::limit($originalName, 200, '');

            $path = $file->store('gallery/items', 'public');

            GalleryItem::create([
                'gallery_id' => $gallery->id,
                'file' => $path,
                'judul' => $judul,
                'caption' => null,
                'urutan' => $lastUrutan + $index + 1,
            ]);

            $uploadedCount++;
        }

        return redirect()
            ->route('admin.gallery.show', $gallery)
            ->with('success', $uploadedCount . ' foto berhasil di-upload ke gallery.');
    }

    /**
     * Menampilkan form edit foto.
     */
    public function edit(Gallery $gallery, GalleryItem $galleryItem): View
    {
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
        abort_unless(
            $galleryItem->gallery_id === $gallery->id,
            404
        );

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