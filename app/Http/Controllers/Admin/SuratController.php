<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SuratRequest;
use App\Models\Surat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SuratController extends Controller
{
    public function index(Request $request): View
    {
        $query = Surat::with('user');

        if ($request->filled('search')) {
            $search = (string) $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('perihal', 'like', "%{$search}%")
                    ->orWhere('pengirim', 'like', "%{$search}%")
                    ->orWhere('penerima', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->input('jenis'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('from')) {
            $query->whereDate('tanggal_surat', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('tanggal_surat', '<=', $request->input('to'));
        }

        $surats = $query->latest('tanggal_surat')->paginate(15)->withQueryString();

        $stats = [
            'total' => Surat::count(),
            'masuk' => Surat::where('jenis', 'masuk')->count(),
            'keluar' => Surat::where('jenis', 'keluar')->count(),
            'draft' => Surat::where('status', 'draft')->count(),
        ];

        return view('admin.surat.index', compact('surats', 'stats'));
    }

    public function create(): View
    {
        return view('admin.surat.create');
    }

    public function store(SuratRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('surat', 'public');
        }

        unset($data['file']);

        Surat::create($data);

        return redirect()
            ->route('admin.surat.index')
            ->with('success', 'Surat berhasil ditambahkan.');
    }

    public function show(Surat $surat): View
    {
        $surat->load('user');

        return view('admin.surat.show', compact('surat'));
    }

    public function edit(Surat $surat): View
    {
        return view('admin.surat.edit', compact('surat'));
    }

    public function update(SuratRequest $request, Surat $surat): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($surat->file_path) {
                Storage::disk('public')->delete($surat->file_path);
            }

            $data['file_path'] = $request->file('file')->store('surat', 'public');
        }

        unset($data['file']);

        $surat->update($data);

        return redirect()
            ->route('admin.surat.index')
            ->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy(Surat $surat): RedirectResponse
    {
        if ($surat->file_path) {
            Storage::disk('public')->delete($surat->file_path);
        }

        $surat->delete();

        return redirect()
            ->route('admin.surat.index')
            ->with('success', 'Surat berhasil dihapus.');
    }
}