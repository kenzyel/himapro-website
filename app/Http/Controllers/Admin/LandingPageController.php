<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LandingPageRequest;
use App\Models\LandingSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    /**
     * Daftar semua section landing page.
     */
    public function index(): View
    {
        $sections = LandingSection::orderBy('urutan')->get();

        return view('admin.landing-page.index', compact('sections'));
    }

    /**
     * Form edit section.
     */
    public function edit(LandingSection $landingPage): View
    {
        return view('admin.landing-page.edit', [
            'section' => $landingPage,
        ]);
    }

    /**
     * Update section.
     */
    public function update(LandingPageRequest $request, LandingSection $landingPage): RedirectResponse
    {
        $data = $request->validated();

        $landingPage->update([
            'title' => $data['title'] ?? $landingPage->title,
            'subtitle' => $data['subtitle'] ?? $landingPage->subtitle,
            'content' => $data['content'] ?? $landingPage->content,
            'is_active' => $data['is_active'],
        ]);

        return redirect()
            ->route('admin.landing-page.index')
            ->with('success', 'Section "' . $landingPage->name . '" berhasil diperbarui.');
    }

    /**
     * Toggle aktif/non-aktif.
     */
    public function toggle(LandingSection $landingPage): RedirectResponse
    {
        $landingPage->update([
            'is_active' => ! $landingPage->is_active,
        ]);

        $status = $landingPage->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', 'Section "' . $landingPage->name . '" berhasil ' . $status . '.');
    }

    /**
     * Reorder sections — dipanggil via AJAX drag & drop.
     */
    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:landing_sections,id'],
        ]);

        foreach ($request->input('order') as $index => $id) {
            LandingSection::where('id', $id)->update([
                'urutan' => $index + 1,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan section berhasil disimpan.',
        ]);
    }

    /**
     * Reset section ke default (dari seeder).
     */
    public function resetSection(LandingSection $landingPage): RedirectResponse
    {
        $defaults = $this->getDefaultSections();
        $default = collect($defaults)->firstWhere('key', $landingPage->key);

        if (! $default) {
            return back()->with('error', 'Data default untuk section ini tidak ditemukan.');
        }

        $landingPage->update([
            'title' => $default['title'],
            'subtitle' => $default['subtitle'],
            'content' => $default['content'],
        ]);

        return redirect()
            ->route('admin.landing-page.edit', $landingPage)
            ->with('success', 'Section "' . $landingPage->name . '" berhasil di-reset ke default.');
    }

    /**
     * Data default section (dari seeder).
     */
    protected function getDefaultSections(): array
    {
        return [
            'hero' => [
                'key' => 'hero',
                'title' => 'Wadah Mahasiswa Teknologi Informasi untuk Berkarya',
                'subtitle' => 'Himpunan Mahasiswa Program Studi Teknologi Informasi SAKTI — tempat tumbuh, berkolaborasi, dan berkontribusi nyata untuk kemajuan bersama.',
                'content' => [
                    'label' => 'Selamat Datang di HIMAPRO TI SAKTI',
                    'title' => 'Wadah Mahasiswa <span class="accent">Teknologi Informasi</span> untuk Berkarya',
                    'description' => 'Himpunan Mahasiswa Program Studi Teknologi Informasi SAKTI — tempat tumbuh, berkolaborasi, dan berkontribusi nyata untuk kemajuan bersama.',
                    'cta1_text' => 'Jelajahi Sekarang',
                    'cta1_link' => '#about',
                    'cta1_icon' => 'bi-compass',
                    'cta2_text' => 'Hubungi Kami',
                    'cta2_link' => '/kontak',
                    'cta2_icon' => 'bi-chat-dots',
                    'show_stats' => true,
                    'floating_cards' => [
                        [
                            'icon' => 'bi-code-slash',
                            'title' => 'Kolaborasi',
                            'description' => 'Tumbuh bersama',
                            'color' => 'primary',
                            'is_active' => true,
                        ],
                        [
                            'icon' => 'bi-lightbulb-fill',
                            'title' => 'Inovasi',
                            'description' => 'Karya nyata',
                            'color' => 'green',
                            'is_active' => true,
                        ],
                        [
                            'icon' => 'bi-rocket-takeoff-fill',
                            'title' => 'Berkembang',
                            'description' => 'Potensi maksimal',
                            'color' => 'blue',
                            'is_active' => true,
                        ],
                    ],
                ],
            ],
            'about' => [
                'key' => 'about',
                'title' => 'Tentang Kami',
                'subtitle' => 'Lebih dari Sekadar Organisasi',
                'content' => [
                    'label' => 'Tentang Kami',
                    'title' => 'Lebih dari Sekadar <span class="accent">Organisasi</span>',
                    'description' => 'HIMAPRO TI SAKTI adalah rumah bagi mahasiswa Teknologi Informasi untuk berkembang, berkarya, dan berkontribusi. Kami percaya bahwa kolaborasi adalah kunci untuk menciptakan dampak yang berkelanjutan.',
                    'features' => [
                        ['icon' => 'bi-check-lg', 'title' => 'Visi yang Jelas', 'description' => 'Menjadi organisasi mahasiswa yang inovatif dan berdampak.'],
                        ['icon' => 'bi-check-lg', 'title' => 'Misi yang Nyata', 'description' => 'Mengembangkan potensi, kompetensi, dan karakter mahasiswa.'],
                        ['icon' => 'bi-check-lg', 'title' => 'Program yang Berdampak', 'description' => 'Berbagai program kerja yang mendukung pengembangan mahasiswa.'],
                    ],
                    'quote' => 'Bersama kita tumbuh, bersama kita berkarya.',
                    'quote_author' => 'HIMAPRO TI SAKTI',
                    'stat1_value' => '100+',
                    'stat1_label' => 'Mahasiswa Terlibat',
                    'stat2_value' => '20+',
                    'stat2_label' => 'Program Terlaksana',
                ],
            ],
            'program_kerja' => [
                'key' => 'program_kerja',
                'title' => 'Program Kerja Terbaru',
                'subtitle' => 'Program Unggulan',
                'content' => [
                    'label' => 'Program Unggulan',
                    'title' => 'Program Kerja <span class="accent">Terbaru</span>',
                    'description' => 'Inisiatif dan kegiatan yang kami jalankan untuk mendukung pengembangan mahasiswa.',
                    'limit' => 3,
                ],
            ],
            'agenda' => [
                'key' => 'agenda',
                'title' => 'Kegiatan Mendatang',
                'subtitle' => 'Agenda',
                'content' => [
                    'label' => 'Agenda',
                    'title' => 'Kegiatan <span class="accent">Mendatang</span>',
                    'description' => 'Jangan lewatkan agenda dan kegiatan terbaru HIMAPRO TI SAKTI.',
                    'limit' => 3,
                ],
            ],
            'pengumuman' => [
                'key' => 'pengumuman',
                'title' => 'Info Terbaru',
                'subtitle' => 'Pengumuman',
                'content' => [
                    'label' => 'Pengumuman',
                    'title' => 'Info <span class="accent">Terbaru</span>',
                    'description' => 'Berita dan pengumuman terkini dari HIMAPRO TI SAKTI.',
                    'limit' => 3,
                ],
            ],
            'gallery' => [
                'key' => 'gallery',
                'title' => 'Momen Berharga',
                'subtitle' => 'Gallery',
                'content' => [
                    'label' => 'Gallery',
                    'title' => 'Momen <span class="accent">Berharga</span>',
                    'description' => 'Dokumentasi kegiatan dan kebersamaan HIMAPRO TI SAKTI.',
                    'limit' => 4,
                    'show_cta' => true,
                    'cta_text' => 'Lihat Semua Gallery',
                    'cta_link' => '/gallery',
                ],
            ],
            'partner' => [
                'key' => 'partner',
                'title' => 'Didukung oleh',
                'subtitle' => 'Partner & Sponsor',
                'content' => [
                    'label' => 'Partner & Sponsor',
                    'title' => 'Didukung oleh',
                ],
            ],
            'cta' => [
                'key' => 'cta',
                'title' => 'Punya Pertanyaan atau Ingin Berkolaborasi?',
                'subtitle' => 'Mari Terhubung',
                'content' => [
                    'label' => 'Mari Terhubung',
                    'title' => 'Punya Pertanyaan atau Ingin <span class="accent">Berkolaborasi</span>?',
                    'description' => 'Kami terbuka untuk diskusi, kolaborasi, maupun pertanyaan seputar HIMAPRO TI SAKTI. Hubungi kami dan mari ciptakan sesuatu yang berdampak.',
                    'cta1_text' => 'Kirim Pesan',
                    'cta1_link' => '/kontak',
                    'cta1_icon' => 'bi-envelope-fill',
                    'cta2_text' => 'Ikuti Kami',
                    'cta2_link' => '#',
                    'cta2_icon' => 'bi-instagram',
                ],
            ],
            'about_page' => [
                'key' => 'about_page',
                'title' => 'Kenali HIMAPRO TI SAKTI Lebih Dekat',
                'subtitle' => 'Halaman /tentang',
                'content' => [
                    'title' => 'Kenali <span class="accent">HIMAPRO TI SAKTI</span> Lebih Dekat',
                    'description' => 'Himpunan Mahasiswa Program Studi Teknologi Informasi SAKTI — wadah pengembangan potensi, kolaborasi, dan kontribusi mahasiswa.',
                    'intro_label' => 'Siapa Kami',
                    'intro_title' => 'Rumah untuk <span class="accent">Tumbuh & Berkarya</span>',
                    'intro_paragraphs' => [
                        'HIMAPRO TI SAKTI adalah organisasi mahasiswa yang menjadi wadah bagi mahasiswa Program Studi Teknologi Informasi untuk mengembangkan potensi, berkolaborasi, dan berkontribusi nyata.',
                        'Kami percaya bahwa setiap mahasiswa memiliki potensi unik yang perlu diwadahi dengan tepat — melalui program kerja yang berdampak, lingkungan yang suportif, dan kolaborasi yang bermakna.',
                        'Melalui tiga departemen utama — Internal, Eksternal, dan Minat Bakat — kami membangun ekosistem yang mendukung pertumbuhan holistik mahasiswa.',
                    ],
                    'values_label' => 'Nilai Kami',
                    'values_title' => 'Nilai yang <span class="accent">Kami Pegang</span>',
                    'values' => [
                        ['icon' => 'bi-people-fill', 'title' => 'Kolaborasi', 'description' => 'Kami percaya kolaborasi adalah kunci untuk menciptakan dampak yang berkelanjutan.'],
                        ['icon' => 'bi-lightbulb-fill', 'title' => 'Inovasi', 'description' => 'Kami mendorong setiap anggota untuk berpikir kreatif dan menghasilkan karya yang inovatif.'],
                        ['icon' => 'bi-rocket-takeoff-fill', 'title' => 'Berkembang', 'description' => 'Kami berkomitmen untuk mendukung pertumbuhan potensi setiap anggota.'],
                    ],
                ],
            ],
            'visi_misi' => [
                'key' => 'visi_misi',
                'title' => 'Visi & Misi HIMAPRO TI SAKTI',
                'subtitle' => 'Halaman /tentang/visi-misi',
                'content' => [
                    'title' => 'Arah & <span class="accent">Tujuan Kami</span>',
                    'description' => 'Visi dan misi yang menjadi fondasi setiap langkah HIMAPRO TI SAKTI.',
                    'visi' => 'Menjadi organisasi mahasiswa yang inovatif, kolaboratif, dan berdampak dalam pengembangan mahasiswa Teknologi Informasi yang unggul dan berkarakter.',
                    'misi' => [
                        ['title' => 'Mengembangkan Potensi Mahasiswa', 'description' => 'Menyediakan wadah pengembangan soft skill dan hard skill.'],
                        ['title' => 'Membangun Kolaborasi', 'description' => 'Menjalin kerja sama dengan berbagai pihak untuk memperluas dampak.'],
                        ['title' => 'Mendorong Inovasi', 'description' => 'Mendorong budaya inovasi dan kreativitas di kalangan mahasiswa.'],
                        ['title' => 'Berkontribusi untuk Masyarakat', 'description' => 'Mengimplementasikan ilmu untuk memberikan manfaat nyata.'],
                    ],
                ],
            ],
            'sejarah' => [
                'key' => 'sejarah',
                'title' => 'Perjalanan HIMAPRO TI SAKTI',
                'subtitle' => 'Halaman /tentang/sejarah',
                'content' => [
                    'title' => 'Perjalanan <span class="accent">HIMAPRO TI SAKTI</span>',
                    'description' => 'Jejak langkah dan tonggak sejarah yang membentuk kami hari ini.',
                    'intro' => 'HIMAPRO TI SAKTI lahir dari semangat mahasiswa Program Studi Teknologi Informasi untuk memiliki wadah yang mampu mengakomodasi aspirasi, mengembangkan potensi, dan mempererat kebersamaan.',
                    'timeline_label' => 'Timeline',
                    'timeline_title' => 'Tonggak <span class="accent">Perjalanan</span>',
                    'timeline' => [
                        ['year' => 'Awal Berdiri', 'title' => 'Fondasi HIMAPRO TI SAKTI', 'description' => 'Berawal dari diskusi sekelompok mahasiswa Teknologi Informasi yang menginginkan wadah kolaborasi.'],
                        ['year' => 'Pengembangan Struktur', 'title' => 'Pembentukan Departemen', 'description' => 'Dibentuk tiga departemen utama: Internal, Eksternal, dan Minat Bakat.'],
                        ['year' => 'Ekspansi Program', 'title' => 'Program Kerja Berdampak', 'description' => 'Berbagai program kerja mulai dirancang dan dijalankan.'],
                        ['year' => 'Hari Ini', 'title' => 'Terus Berkembang', 'description' => 'HIMAPRO TI SAKTI terus berbenah dan berinovasi.'],
                    ],
                ],
            ],
            'contact_page' => [
                'key' => 'contact_page',
                'title' => 'Mari Terhubung',
                'subtitle' => 'Halaman /kontak',
                'content' => [
                    'title' => 'Mari <span class="accent">Terhubung</span>',
                    'description' => 'Punya pertanyaan, ingin berkolaborasi, atau sekadar menyapa? Kami siap mendengarkan.',
                    'form_title' => 'Kirim Pesan',
                    'form_description' => 'Isi form di bawah ini dan kami akan segera merespons.',
                ],
            ],
        ];
    }
}