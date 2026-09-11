<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DepartemenRequest;
use App\Models\Departemen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DepartemenController extends Controller
{
    /**
     * Menampilkan daftar departemen.
     */
    public function index(Request $request): View
    {
        $search = (string) $request->string('search');

        $departemens = Departemen::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('nama', 'like', "%{$search}%")
                        ->orWhere('kode', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->orderBy('urutan')
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.departemen.index', compact(
            'departemens',
            'search'
        ));
    }

    /**
     * Menampilkan form tambah departemen.
     */
    public function create(): View
    {
        return view('admin.departemen.create');
    }

    /**
     * Menyimpan departemen baru.
     */
    public function store(DepartemenRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama']);
        }

        Departemen::create($data);

        return redirect()
            ->route('admin.departemen.index')
            ->with('success', 'Departemen berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail departemen.
     */
    public function show(Departemen $departemen): View
    {
        $departemen->load([
            'pengurus',
            'programKerjas',
            'anggarans',
            'keuangans',
        ]);

        return view('admin.departemen.show', compact('departemen'));
    }

    /**
     * Menampilkan form edit departemen.
     */
    public function edit(Departemen $departemen): View
    {
        return view('admin.departemen.edit', compact('departemen'));
    }

    /**
     * Memperbarui departemen.
     */
    public function update(
        DepartemenRequest $request,
        Departemen $departemen
    ): RedirectResponse {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama']);
        }

        $departemen->update($data);

        return redirect()
            ->route('admin.departemen.index')
            ->with('success', 'Departemen berhasil diperbarui.');
    }

    /**
     * Menghapus departemen.
     */
    public function destroy(Departemen $departemen): RedirectResponse
    {
        $jumlahPengurus = $departemen->pengurus()->count();
        $jumlahProgramKerja = $departemen->programKerjas()->count();

        if ($jumlahPengurus > 0 || $jumlahProgramKerja > 0) {
            return redirect()
                ->route('admin.departemen.index')
                ->with(
                    'error',
                    'Departemen tidak dapat dihapus karena masih memiliki data pengurus atau program kerja.'
                );
        }

        $departemen->delete();

        return redirect()
            ->route('admin.departemen.index')
            ->with('success', 'Departemen berhasil dihapus.');
    }
}