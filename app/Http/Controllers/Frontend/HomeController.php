<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Departemen;
use App\Models\Gallery;
use App\Models\LandingSection;
use App\Models\Partner;
use App\Models\Pengumuman;
use App\Models\Pengurus;
use App\Models\ProgramKerja;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil semua section landing page dari database
        |--------------------------------------------------------------------------
        */

        $sections = LandingSection::getActive()
            ->keyBy('key');

        /*
        |--------------------------------------------------------------------------
        | Statistik untuk hero
        |--------------------------------------------------------------------------
        */

        $stats = [
            'pengurus' => Pengurus::where('status', 'active')->count(),
            'departemen' => Departemen::where('status', 'active')->count(),
            'program_kerja' => ProgramKerja::count(),
            'agenda' => Agenda::where('is_public', true)->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Program kerja unggulan
        |--------------------------------------------------------------------------
        */

        $limitProgramKerja = $sections->get('program_kerja')?->content['limit'] ?? 3;

        $programKerjas = ProgramKerja::with('departemen')
            ->latest()
            ->limit($limitProgramKerja)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Agenda terbaru
        |--------------------------------------------------------------------------
        */

        $limitAgenda = $sections->get('agenda')?->content['limit'] ?? 3;

        $agendas = Agenda::where('is_public', true)
            ->where('tanggal_mulai', '>=', now())
            ->orderBy('tanggal_mulai')
            ->limit($limitAgenda)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Pengumuman terbaru
        |--------------------------------------------------------------------------
        */

        $limitPengumuman = $sections->get('pengumuman')?->content['limit'] ?? 3;

        $pengumumans = Pengumuman::where('status', 'published')
            ->orderByDesc('published_at')
            ->limit($limitPengumuman)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Gallery preview
        |--------------------------------------------------------------------------
        */

        $limitGallery = $sections->get('gallery')?->content['limit'] ?? 4;

        $galleries = Gallery::where('status', 'published')
            ->with('items')
            ->latest()
            ->limit($limitGallery)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Partner aktif
        |--------------------------------------------------------------------------
        */

        $partners = Partner::where('status', 'active')
            ->orderBy('urutan')
            ->get();

        return view('frontend.home', compact(
            'sections',
            'stats',
            'programKerjas',
            'agendas',
            'pengumumans',
            'galleries',
            'partners'
        ));
    }
}