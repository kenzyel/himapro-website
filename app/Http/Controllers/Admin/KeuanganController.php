<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KeuanganRequest;
use App\Models\Departemen;
use App\Models\Keuangan;
use App\Models\ProgramKerja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class KeuanganController extends Controller
{
    /**
     * Daftar kategori transaksi.
     */
    protected array $kategoriList = [
        'operasional' => 'Operasional',
        'konsumsi' => 'Konsumsi',
        'transportasi' => 'Transportasi',
        'perlengkapan' => 'Perlengkapan',
        'hadiah' => 'Hadiah & Doorprize',
        'sponsorship' => 'Sponsorship',
        'dana_kegiatan' => 'Dana Kegiatan',
        'lainnya' => 'Lainnya',
    ];

    public function index(Request $request): View
    {
        $query = Keuangan::with(['user', 'departemen', 'programKerja']);

        if ($request->filled('search')) {
            $search = (string) $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->input('jenis'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('departemen_id')) {
            $query->where('departemen_id', $request->integer('departemen_id'));
        }

        if ($request->filled('from')) {
            $query->whereDate('tanggal', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('tanggal', '<=', $request->input('to'));
        }

        $keuangans = $query->latest('tanggal')->paginate(15)->withQueryString();

        $totalPemasukan = Keuangan::where('jenis', 'pemasukan')
            ->where('status', 'approved')
            ->sum('jumlah');

        $totalPengeluaran = Keuangan::where('jenis', 'pengeluaran')
            ->where('status', 'approved')
            ->sum('jumlah');

        $stats = [
            'pemasukan' => $totalPemasukan,
            'pengeluaran' => $totalPengeluaran,
            'saldo' => $totalPemasukan - $totalPengeluaran,
            'pending' => Keuangan::where('status', 'pending')->count(),
        ];

        $departemens = Departemen::where('status', 'active')->orderBy('urutan')->get();
        $kategoris = $this->kategoriList;

        return view('admin.keuangan.index', compact(
            'keuangans',
            'stats',
            'departemens',
            'kategoris'
        ));
    }

    public function create(): View
    {
        return view('admin.keuangan.create', [
            'departemens' => Departemen::where('status', 'active')->orderBy('urutan')->get(),
            'programKerjas' => ProgramKerja::orderBy('nama')->get(),
            'kategoris' => $this->kategoriList,
        ]);
    }

    public function store(KeuanganRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        if ($request->hasFile('bukti')) {
            $data['bukti_path'] = $request->file('bukti')->store('bukti-keuangan', 'public');
        }

        unset($data['bukti']);

        Keuangan::create($data);

        return redirect()
            ->route('admin.keuangan.index')
            ->with('success', 'Transaksi keuangan berhasil ditambahkan.');
    }

    public function show(Keuangan $keuangan): View
    {
        $keuangan->load(['user', 'departemen', 'programKerja']);

        return view('admin.keuangan.show', compact('keuangan'));
    }

    public function edit(Keuangan $keuangan): View
    {
        return view('admin.keuangan.edit', [
            'keuangan' => $keuangan,
            'departemens' => Departemen::where('status', 'active')->orderBy('urutan')->get(),
            'programKerjas' => ProgramKerja::orderBy('nama')->get(),
            'kategoris' => $this->kategoriList,
        ]);
    }

    public function update(KeuanganRequest $request, Keuangan $keuangan): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('bukti')) {
            if ($keuangan->bukti_path) {
                Storage::disk('public')->delete($keuangan->bukti_path);
            }

            $data['bukti_path'] = $request->file('bukti')->store('bukti-keuangan', 'public');
        }

        unset($data['bukti']);

        $keuangan->update($data);

        return redirect()
            ->route('admin.keuangan.index')
            ->with('success', 'Transaksi keuangan berhasil diperbarui.');
    }

    public function destroy(Keuangan $keuangan): RedirectResponse
    {
        if ($keuangan->bukti_path) {
            Storage::disk('public')->delete($keuangan->bukti_path);
        }

        $keuangan->delete();

        return redirect()
            ->route('admin.keuangan.index')
            ->with('success', 'Transaksi keuangan berhasil dihapus.');
    }
}