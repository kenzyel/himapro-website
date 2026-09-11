<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PengurusRequest;
use App\Models\Departemen;
use App\Models\Pengurus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengurusController extends Controller
{
    /**
     * Menampilkan daftar pengurus.
     */
    public function index(Request $request): View
    {
        $query = Pengurus::with('departemen')
            ->orderBy('urutan');

        if ($request->filled('departemen_id')) {
            $query->where(
                'departemen_id',
                $request->integer('departemen_id')
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->string('status')
            );
        }

        if ($request->filled('search')) {
            $search = $request->string('search');

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        $penguruses = $query
            ->paginate(15)
            ->withQueryString();

        $departemens = Departemen::where('status', 'active')
            ->orderBy('urutan')
            ->get();

        return view('admin.pengurus.index', [
            'penguruses' => $penguruses,
            'departemens' => $departemens,
        ]);
    }

    /**
     * Menampilkan form tambah pengurus.
     */
    public function create(): View
    {
        return view('admin.pengurus.create', [
            'departemens' => Departemen::where('status', 'active')
                ->orderBy('urutan')
                ->get(),

            'parents' => Pengurus::where('status', 'active')
                ->orderBy('urutan')
                ->get(),
        ]);
    }

    /**
     * Menyimpan pengurus baru.
     */
    public function store(PengurusRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request
                ->file('foto')
                ->store('pengurus', 'public');
        }

        Pengurus::create($data);

        return redirect()
            ->route('admin.pengurus.index')
            ->with('success', 'Pengurus berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail pengurus.
     */
    public function show(Pengurus $pengurus): View
    {
        $pengurus->load([
            'departemen',
            'parent',
            'children',
        ]);

        return view('admin.pengurus.show', [
            'pengurus' => $pengurus,
        ]);
    }

    /**
     * Menampilkan form edit pengurus.
     */
    public function edit(Pengurus $pengurus): View
    {
        return view('admin.pengurus.edit', [
            'pengurus' => $pengurus,

            'departemens' => Departemen::where('status', 'active')
                ->orderBy('urutan')
                ->get(),

            'parents' => Pengurus::where('status', 'active')
                ->whereKeyNot($pengurus->id)
                ->orderBy('urutan')
                ->get(),
        ]);
    }

    /**
     * Memperbarui pengurus.
     */
    public function update(
        PengurusRequest $request,
        Pengurus $pengurus
    ): RedirectResponse {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($pengurus->foto) {
                Storage::disk('public')->delete($pengurus->foto);
            }

            $data['foto'] = $request
                ->file('foto')
                ->store('pengurus', 'public');
        }

        $pengurus->update($data);

        return redirect()
            ->route('admin.pengurus.index')
            ->with('success', 'Data pengurus berhasil diperbarui.');
    }

    /**
     * Menghapus pengurus.
     */
    public function destroy(Pengurus $pengurus): RedirectResponse
    {
        if ($pengurus->children()->exists()) {
            return redirect()
                ->route('admin.pengurus.index')
                ->with('error', 'Pengurus tidak dapat dihapus karena masih menjadi parent pengurus lain.');
        }

        if ($pengurus->foto) {
            Storage::disk('public')->delete($pengurus->foto);
        }

        $pengurus->delete();

        return redirect()
            ->route('admin.pengurus.index')
            ->with('success', 'Pengurus berhasil dihapus.');
    }
}