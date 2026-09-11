<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use Illuminate\View\View;

class StrukturController extends Controller
{
    public function index(): View
    {
        // Ambil pengurus aktif, dikelompokkan berdasarkan tipe jabatan
        $penguruses = Pengurus::where('status', 'active')
            ->with(['departemen', 'parent'])
            ->orderBy('urutan')
            ->get();

        // Kelompok utama
        $pembina = $penguruses->where('tipe_jabatan', 'pembina');
        $pimpinan = $penguruses->where('tipe_jabatan', 'pimpinan');
        $sekretaris = $penguruses->where('tipe_jabatan', 'sekretaris');
        $bendahara = $penguruses->where('tipe_jabatan', 'bendahara');
        $co = $penguruses->where('tipe_jabatan', 'co');
        $agt = $penguruses->where('tipe_jabatan', 'agt');

        return view('frontend.struktur.index', compact(
            'pembina',
            'pimpinan',
            'sekretaris',
            'bendahara',
            'co',
            'agt'
        ));
    }

    public function detail(Pengurus $pengurus): View
    {
        $pengurus->load(['departemen', 'parent', 'children']);

        return view('frontend.struktur.detail', compact('pengurus'));
    }
}