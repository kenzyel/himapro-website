<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerRequest;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PartnerController extends Controller
{
    /**
     * Menampilkan daftar partner.
     */
    public function index(Request $request): View
    {
        $query = Partner::query();

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

        $partners = $query
            ->orderBy('urutan')
            ->orderBy('nama')
            ->paginate(15)
            ->withQueryString();

        return view('admin.partner.index', compact('partners'));
    }

    /**
     * Menampilkan form tambah partner.
     */
    public function create(): View
    {
        return view('admin.partner.create');
    }

    /**
     * Menyimpan partner baru.
     */
    public function store(PartnerRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama']);
        }

        // Pastikan slug unik
        $originalSlug = $data['slug'];
        $counter = 1;

        while (Partner::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        Partner::create($data);

        return redirect()
            ->route('admin.partner.index')
            ->with('success', 'Partner berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail partner.
     */
    public function show(Partner $partner): View
    {
        return view('admin.partner.show', compact('partner'));
    }

    /**
     * Menampilkan form edit partner.
     */
    public function edit(Partner $partner): View
    {
        return view('admin.partner.edit', compact('partner'));
    }

    /**
     * Memperbarui partner.
     */
    public function update(PartnerRequest $request, Partner $partner): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama']);
        }

        // Pastikan slug unik, kecuali milik partner ini sendiri
        $originalSlug = $data['slug'];
        $counter = 1;

        while (
            Partner::where('slug', $data['slug'])
                ->where('id', '!=', $partner->id)
                ->exists()
        ) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }

            $data['logo'] = $request->file('logo')->store('partners', 'public');
        } else {
            unset($data['logo']);
        }

        $partner->update($data);

        return redirect()
            ->route('admin.partner.index')
            ->with('success', 'Partner berhasil diperbarui.');
    }

    /**
     * Menghapus partner.
     */
    public function destroy(Partner $partner): RedirectResponse
    {
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()
            ->route('admin.partner.index')
            ->with('success', 'Partner berhasil dihapus.');
    }
}