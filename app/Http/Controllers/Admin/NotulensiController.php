<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NotulensiRequest;
use App\Models\Notulensi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class NotulensiController extends Controller
{
    public function index(Request $request): View
    {
        $query = Notulensi::with('user');

        if ($request->filled('search')) {
            $search = (string) $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('tempat', 'like', "%{$search}%")
                    ->orWhere('agenda', 'like', "%{$search}%")
                    ->orWhere('peserta', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('from')) {
            $query->whereDate('tanggal', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('tanggal', '<=', $request->input('to'));
        }

        $notulensis = $query->latest('tanggal')->paginate(15)->withQueryString();

        $stats = [
            'total' => Notulensi::count(),
            'draft' => Notulensi::where('status', 'draft')->count(),
            'final' => Notulensi::where('status', 'final')->count(),
            'archived' => Notulensi::where('status', 'archived')->count(),
        ];

        return view('admin.notulensi.index', compact('notulensis', 'stats'));
    }

    public function create(): View
    {
        return view('admin.notulensi.create');
    }

    public function store(NotulensiRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('notulensi', 'public');
        }

        unset($data['file']);

        Notulensi::create($data);

        return redirect()
            ->route('admin.notulensi.index')
            ->with('success', 'Notulensi berhasil ditambahkan.');
    }

    public function show(Notulensi $notulensi): View
    {
        $notulensi->load('user');

        return view('admin.notulensi.show', compact('notulensi'));
    }

    public function edit(Notulensi $notulensi): View
    {
        return view('admin.notulensi.edit', compact('notulensi'));
    }

    public function update(NotulensiRequest $request, Notulensi $notulensi): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($notulensi->file_path) {
                Storage::disk('public')->delete($notulensi->file_path);
            }

            $data['file_path'] = $request->file('file')->store('notulensi', 'public');
        }

        unset($data['file']);

        $notulensi->update($data);

        return redirect()
            ->route('admin.notulensi.index')
            ->with('success', 'Notulensi berhasil diperbarui.');
    }

    public function destroy(Notulensi $notulensi): RedirectResponse
    {
        if ($notulensi->file_path) {
            Storage::disk('public')->delete($notulensi->file_path);
        }

        $notulensi->delete();

        return redirect()
            ->route('admin.notulensi.index')
            ->with('success', 'Notulensi berhasil dihapus.');
    }
}