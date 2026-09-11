<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\LandingSection;
use App\Models\Pengurus;
use App\Models\ProgramKerja;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Halaman utama /tentang.
     */
    public function index(): View
    {
        $section = LandingSection::get('about_page');

        abort_unless($section && $section->is_active, 404);

        $stats = [
            'pengurus' => Pengurus::where('status', 'active')->count(),
            'departemen' => Departemen::where('status', 'active')->count(),
            'program_kerja' => ProgramKerja::count(),
        ];

        $departemens = Departemen::where('status', 'active')
            ->orderBy('urutan')
            ->get();

        return view('frontend.about.index', compact('section', 'stats', 'departemens'));
    }

    /**
     * Halaman /tentang/visi-misi.
     */
    public function visiMisi(): View
    {
        $section = LandingSection::get('visi_misi');

        abort_unless($section && $section->is_active, 404);

        return view('frontend.about.visi-misi', compact('section'));
    }

    /**
     * Halaman /tentang/sejarah.
     */
    public function sejarah(): View
    {
        $section = LandingSection::get('sejarah');

        abort_unless($section && $section->is_active, 404);

        return view('frontend.about.sejarah', compact('section'));
    }
}