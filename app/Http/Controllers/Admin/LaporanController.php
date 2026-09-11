<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Anggaran;
use App\Models\Departemen;
use App\Models\Keuangan;
use App\Models\ProgramKerja;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(): View
    {
        $ringkasan = [
            'total_pengurus' => \App\Models\Pengurus::where('status', 'active')->count(),
            'total_departemen' => Departemen::where('status', 'active')->count(),
            'total_program_kerja' => ProgramKerja::count(),
            'total_agenda' => Agenda::count(),
            'total_anggaran' => Anggaran::sum('jumlah'),
            'total_pemasukan' => Keuangan::where('jenis', 'pemasukan')->where('status', 'approved')->sum('jumlah'),
            'total_pengeluaran' => Keuangan::where('jenis', 'pengeluaran')->where('status', 'approved')->sum('jumlah'),
        ];

        $ringkasan['saldo'] = $ringkasan['total_pemasukan'] - $ringkasan['total_pengeluaran'];

        return view('admin.laporan.index', compact('ringkasan'));
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN KEUANGAN
    |--------------------------------------------------------------------------
    */

    public function keuangan(Request $request): View
    {
        [$transaksis, $summary, $perKategori, $from, $to] = $this->getDataKeuangan($request);

        return view('admin.laporan.keuangan', compact(
            'transaksis',
            'summary',
            'perKategori',
            'from',
            'to'
        ));
    }

    public function keuanganPdf(Request $request)
    {
        [$transaksis, $summary, $perKategori, $from, $to] = $this->getDataKeuangan($request);

        $pdf = Pdf::loadView('admin.laporan.pdf.keuangan', compact(
            'transaksis',
            'summary',
            'perKategori',
            'from',
            'to'
        ));

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan-keuangan-' . now()->format('Y-m-d') . '.pdf');
    }

    protected function getDataKeuangan(Request $request): array
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $query = Keuangan::with(['departemen', 'programKerja', 'user'])
            ->where('status', 'approved');

        if ($from) $query->whereDate('tanggal', '>=', $from);
        if ($to) $query->whereDate('tanggal', '<=', $to);

        $transaksis = $query->orderBy('tanggal')->get();

        $totalPemasukan = $transaksis->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $transaksis->where('jenis', 'pengeluaran')->sum('jumlah');

        $summary = [
            'total_pemasukan' => $totalPemasukan,
            'total_pengeluaran' => $totalPengeluaran,
            'saldo' => $totalPemasukan - $totalPengeluaran,
            'jumlah_transaksi' => $transaksis->count(),
        ];

        $perKategori = $transaksis
            ->groupBy('kategori')
            ->map(function ($items, $kategori) {
                return [
                    'kategori' => $kategori,
                    'pemasukan' => $items->where('jenis', 'pemasukan')->sum('jumlah'),
                    'pengeluaran' => $items->where('jenis', 'pengeluaran')->sum('jumlah'),
                    'total' => $items->sum('jumlah'),
                ];
            })
            ->values();

        return [$transaksis, $summary, $perKategori, $from, $to];
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN PROGRAM KERJA
    |--------------------------------------------------------------------------
    */

    public function programKerja(Request $request): View
    {
        [$programKerjas, $summary, $departemens, $periodes, $periode, $departemenId, $status] = $this->getDataProgramKerja($request);

        return view('admin.laporan.program-kerja', compact(
            'programKerjas',
            'summary',
            'departemens',
            'periodes',
            'periode',
            'departemenId',
            'status'
        ));
    }

    public function programKerjaPdf(Request $request)
    {
        [$programKerjas, $summary, $departemens, $periodes, $periode, $departemenId, $status] = $this->getDataProgramKerja($request);

        $pdf = Pdf::loadView('admin.laporan.pdf.program-kerja', compact(
            'programKerjas',
            'summary',
            'periode',
            'status'
        ));

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan-program-kerja-' . now()->format('Y-m-d') . '.pdf');
    }

    protected function getDataProgramKerja(Request $request): array
    {
        $periode = $request->input('periode');
        $departemenId = $request->input('departemen_id');
        $status = $request->input('status');

        $query = ProgramKerja::with('departemen');

        if ($periode) $query->where('periode', $periode);
        if ($departemenId) $query->where('departemen_id', $departemenId);
        if ($status) $query->where('status', $status);

        $programKerjas = $query->orderBy('periode', 'desc')->orderBy('nama')->get();

        $summary = [
            'total' => $programKerjas->count(),
            'planned' => $programKerjas->where('status', 'planned')->count(),
            'ongoing' => $programKerjas->where('status', 'ongoing')->count(),
            'completed' => $programKerjas->where('status', 'completed')->count(),
            'cancelled' => $programKerjas->where('status', 'cancelled')->count(),
            'total_anggaran' => $programKerjas->sum('anggaran'),
        ];

        $departemens = Departemen::where('status', 'active')->orderBy('urutan')->get();
        $periodes = ProgramKerja::distinct()->pluck('periode')->sortDesc();

        return [$programKerjas, $summary, $departemens, $periodes, $periode, $departemenId, $status];
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN AGENDA
    |--------------------------------------------------------------------------
    */

    public function agenda(Request $request): View
    {
        [$agendas, $summary, $from, $to, $status] = $this->getDataAgenda($request);

        return view('admin.laporan.agenda', compact(
            'agendas',
            'summary',
            'from',
            'to',
            'status'
        ));
    }

    public function agendaPdf(Request $request)
    {
        [$agendas, $summary, $from, $to, $status] = $this->getDataAgenda($request);

        $pdf = Pdf::loadView('admin.laporan.pdf.agenda', compact(
            'agendas',
            'summary',
            'from',
            'to',
            'status'
        ));

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan-agenda-' . now()->format('Y-m-d') . '.pdf');
    }

    protected function getDataAgenda(Request $request): array
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $status = $request->input('status');

        $query = Agenda::with('programKerja');

        if ($from) $query->whereDate('tanggal_mulai', '>=', $from);
        if ($to) $query->whereDate('tanggal_mulai', '<=', $to);
        if ($status) $query->where('status', $status);

        $agendas = $query->orderBy('tanggal_mulai', 'desc')->get();

        $summary = [
            'total' => $agendas->count(),
            'planned' => $agendas->where('status', 'planned')->count(),
            'ongoing' => $agendas->where('status', 'ongoing')->count(),
            'completed' => $agendas->where('status', 'completed')->count(),
            'cancelled' => $agendas->where('status', 'cancelled')->count(),
        ];

        return [$agendas, $summary, $from, $to, $status];
    }
}