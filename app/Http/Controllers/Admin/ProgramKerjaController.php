<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProgramKerjaRequest;
use App\Models\Departemen;
use App\Models\ProgramKerja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProgramKerjaController extends Controller
{
    /**
     * Menampilkan daftar program kerja.
     */
    public function index(Request $request): View
    {
        $search = (string) $request->string('search');

        $departemenId = $request->input('departemen_id');

        $status = $request->input('status');

        $programKerjas = ProgramKerja::query()
            ->with('departemen')

            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('nama', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%")
                        ->orWhere('tujuan', 'like', "%{$search}%")
                        ->orWhere('target', 'like', "%{$search}%")
                        ->orWhere('periode', 'like', "%{$search}%");
                });
            })

            ->when($departemenId, function ($query) use ($departemenId) {
                $query->where('departemen_id', $departemenId);
            })

            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })

            ->orderByDesc('tanggal_mulai')
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        $departemens = Departemen::query()
            ->where('status', 'active')
            ->orderBy('urutan')
            ->orderBy('nama')
            ->get();

        return view('admin.program-kerja.index', compact(
            'programKerjas',
            'departemens',
            'search',
            'departemenId',
            'status'
        ));
    }

    /**
     * Menampilkan form tambah program kerja.
     */
    public function create(): View
    {
        $departemens = Departemen::query()
            ->where('status', 'active')
            ->orderBy('urutan')
            ->orderBy('nama')
            ->get();

        return view('admin.program-kerja.create', compact(
            'departemens'
        ));
    }

    /**
     * Menyimpan program kerja baru.
     */
    public function store(ProgramKerjaRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama']);
        }

        ProgramKerja::create($data);

        return redirect()
            ->route('admin.program-kerja.index')
            ->with('success', 'Program kerja berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail program kerja.
     */
    public function show(ProgramKerja $programKerja): View
    {
        $programKerja->load([
            'departemen',
            'agendas',
            'anggarans',
            'keuangans',
        ]);

        return view(
            'admin.program-kerja.show',
            compact('programKerja')
        );
    }

    /**
     * Menampilkan form edit program kerja.
     */
    public function edit(ProgramKerja $programKerja): View
    {
        $departemens = Departemen::query()
            ->where('status', 'active')
            ->orWhere('id', $programKerja->departemen_id)
            ->orderBy('urutan')
            ->orderBy('nama')
            ->get();

        return view(
            'admin.program-kerja.edit',
            compact(
                'programKerja',
                'departemens'
            )
        );
    }

    /**
     * Memperbarui program kerja.
     */
    public function update(
        ProgramKerjaRequest $request,
        ProgramKerja $programKerja
    ): RedirectResponse {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama']);
        }

        $programKerja->update($data);

        return redirect()
            ->route('admin.program-kerja.index')
            ->with('success', 'Program kerja berhasil diperbarui.');
    }

    /**
     * Menghapus program kerja.
     */
    public function destroy(
        ProgramKerja $programKerja
    ): RedirectResponse {
        $jumlahAgenda = $programKerja->agendas()->count();
        $jumlahAnggaran = $programKerja->anggarans()->count();
        $jumlahKeuangan = $programKerja->keuangans()->count();

        if (
            $jumlahAgenda > 0 ||
            $jumlahAnggaran > 0 ||
            $jumlahKeuangan > 0
        ) {
            return redirect()
                ->route('admin.program-kerja.index')
                ->with(
                    'error',
                    'Program kerja tidak dapat dihapus karena masih memiliki data agenda, anggaran, atau transaksi keuangan.'
                );
        }

        $programKerja->delete();

        return redirect()
            ->route('admin.program-kerja.index')
            ->with(
                'success',
                'Program kerja berhasil dihapus.'
            );
    }
}