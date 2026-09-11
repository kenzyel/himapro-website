<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AgendaRequest;
use App\Models\Agenda;
use App\Models\ProgramKerja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgendaController extends Controller
{
    public function index(Request $request): View
    {
        $search = (string) $request->string('search');
        $programKerjaId = $request->input('program_kerja_id');
        $status = $request->input('status');
        $isPublic = $request->input('is_public');

        $agendas = Agenda::query()
            ->with('programKerja')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%")
                        ->orWhere('lokasi', 'like', "%{$search}%");
                });
            })
            ->when($programKerjaId, fn ($q) => $q->where('program_kerja_id', $programKerjaId))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($isPublic !== null && $isPublic !== '', fn ($q) => $q->where('is_public', $isPublic === '1'))
            ->orderByDesc('tanggal_mulai')
            ->paginate(10)
            ->withQueryString();

        $programKerjas = ProgramKerja::query()
            ->orderBy('nama')
            ->get();

        return view('admin.agenda.index', compact(
            'agendas',
            'programKerjas',
            'search'
        ));
    }

    public function create(): View
    {
        $programKerjas = ProgramKerja::query()
            ->orderBy('nama')
            ->get();

        return view('admin.agenda.create', compact('programKerjas'));
    }

    public function store(AgendaRequest $request): RedirectResponse
    {
        Agenda::create($request->validated());

        return redirect()
            ->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function show(Agenda $agenda): View
    {
        $agenda->load('programKerja');

        return view('admin.agenda.show', compact('agenda'));
    }

    public function edit(Agenda $agenda): View
    {
        $programKerjas = ProgramKerja::query()
            ->orderBy('nama')
            ->get();

        return view('admin.agenda.edit', compact(
            'agenda',
            'programKerjas'
        ));
    }

    public function update(
        AgendaRequest $request,
        Agenda $agenda
    ): RedirectResponse {
        $agenda->update($request->validated());

        return redirect()
            ->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda): RedirectResponse
    {
        $agenda->delete();

        return redirect()
            ->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil dihapus.');
    }
}