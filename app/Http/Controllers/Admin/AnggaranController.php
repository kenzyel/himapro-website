<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnggaranRequest;
use App\Models\Anggaran;
use App\Models\Departemen;
use App\Models\ProgramKerja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnggaranController extends Controller
{
    public function index(Request $request): View
    {
        $query = Anggaran::with(['departemen', 'programKerja']);

        if ($request->filled('search')) {
            $search = (string) $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('departemen_id')) {
            $query->where('departemen_id', $request->integer('departemen_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('periode')) {
            $query->where('periode', $request->input('periode'));
        }

        $anggarans = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => Anggaran::count(),
            'total_jumlah' => Anggaran::sum('jumlah'),
            'approved' => Anggaran::where('status', 'approved')->count(),
            'realized' => Anggaran::where('status', 'realized')->count(),
        ];

        $departemens = Departemen::where('status', 'active')->orderBy('urutan')->get();

        return view('admin.anggaran.index', compact(
            'anggarans',
            'stats',
            'departemens'
        ));
    }

    public function create(): View
    {
        return view('admin.anggaran.create', [
            'departemens' => Departemen::where('status', 'active')
                ->orderBy('urutan')
                ->get(),
            'programKerjas' => ProgramKerja::orderBy('nama')->get(),
        ]);
    }

    public function store(AnggaranRequest $request): RedirectResponse
    {
        Anggaran::create($request->validated());

        return redirect()
            ->route('admin.anggaran.index')
            ->with('success', 'Anggaran berhasil ditambahkan.');
    }

    public function show(Anggaran $anggaran): View
    {
        $anggaran->load(['departemen', 'programKerja']);

        return view('admin.anggaran.show', compact('anggaran'));
    }

    public function edit(Anggaran $anggaran): View
    {
        return view('admin.anggaran.edit', [
            'anggaran' => $anggaran,
            'departemens' => Departemen::where('status', 'active')
                ->orderBy('urutan')
                ->get(),
            'programKerjas' => ProgramKerja::orderBy('nama')->get(),
        ]);
    }

    public function update(AnggaranRequest $request, Anggaran $anggaran): RedirectResponse
    {
        $anggaran->update($request->validated());

        return redirect()
            ->route('admin.anggaran.index')
            ->with('success', 'Anggaran berhasil diperbarui.');
    }

    public function destroy(Anggaran $anggaran): RedirectResponse
    {
        $anggaran->delete();

        return redirect()
            ->route('admin.anggaran.index')
            ->with('success', 'Anggaran berhasil dihapus.');
    }
}