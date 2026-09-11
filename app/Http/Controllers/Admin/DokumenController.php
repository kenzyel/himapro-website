<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DokumenRequest;
use App\Models\Dokumen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DokumenController extends Controller
{
    /**
     * Daftar kategori yang tersedia.
     */
    protected array $kategoriList = [
        'administrasi' => 'Administrasi',
        'keuangan' => 'Keuangan',
        'proposal' => 'Proposal',
        'laporan' => 'Laporan',
        'notulensi' => 'Notulensi',
        'surat' => 'Surat',
        'lainnya' => 'Lainnya',
    ];

    public function index(Request $request): View
    {
        $query = Dokumen::with('user');

        if ($request->filled('search')) {
            $search = (string) $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        if ($request->filled('is_public')) {
            $query->where('is_public', $request->input('is_public') === '1');
        }

        if ($request->filled('periode')) {
            $query->where('periode', $request->input('periode'));
        }

        $dokumens = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => Dokumen::count(),
            'public' => Dokumen::where('is_public', true)->count(),
            'private' => Dokumen::where('is_public', false)->count(),
            'total_size' => Dokumen::sum('file_size'),
        ];

        $kategoris = $this->kategoriList;

        return view('admin.dokumen.index', compact('dokumens', 'stats', 'kategoris'));
    }

    public function create(): View
    {
        return view('admin.dokumen.create', [
            'kategoris' => $this->kategoriList,
        ]);
    }

    public function store(DokumenRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $data['file_path'] = $file->store('dokumen', 'public');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['mime_type'] = $file->getMimeType();
        }

        unset($data['file']);

        Dokumen::create($data);

        return redirect()
            ->route('admin.dokumen.index')
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    public function show(Dokumen $dokumen): View
    {
        $dokumen->load('user');

        return view('admin.dokumen.show', compact('dokumen'));
    }

    public function edit(Dokumen $dokumen): View
    {
        return view('admin.dokumen.edit', [
            'dokumen' => $dokumen,
            'kategoris' => $this->kategoriList,
        ]);
    }

    public function update(DokumenRequest $request, Dokumen $dokumen): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($dokumen->file_path) {
                Storage::disk('public')->delete($dokumen->file_path);
            }

            $file = $request->file('file');

            $data['file_path'] = $file->store('dokumen', 'public');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['mime_type'] = $file->getMimeType();
        }

        unset($data['file']);

        $dokumen->update($data);

        return redirect()
            ->route('admin.dokumen.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Dokumen $dokumen): RedirectResponse
    {
        if ($dokumen->file_path) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $dokumen->delete();

        return redirect()
            ->route('admin.dokumen.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}