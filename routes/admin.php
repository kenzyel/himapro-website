<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PengurusController;
use App\Http\Controllers\Admin\DepartemenController;
use App\Http\Controllers\Admin\ProgramKerjaController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PesanController;
use App\Http\Controllers\Admin\NotulensiController;
use App\Http\Controllers\Admin\DokumenController;
use App\Http\Controllers\Admin\SuratController;
use App\Http\Controllers\Admin\AnggaranController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\SearchController;


/*
|==========================================================================
| ADMIN AUTHENTICATION — GUEST
|==========================================================================
*/

Route::middleware('guest')->group(function () {

    Route::get('/admin/login', [AuthController::class, 'showLogin'])
        ->name('admin.login');

    Route::post('/admin/login', [AuthController::class, 'login'])
        ->name('admin.login.submit');

});


/*
|==========================================================================
| ADMIN PANEL
|==========================================================================
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |----------------------------------------------------------------------
        | Dashboard
        |----------------------------------------------------------------------
        */

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');


        /*
        |----------------------------------------------------------------------
        | Global Search
        |----------------------------------------------------------------------
        */

        Route::get('/search', [SearchController::class, 'search'])
            ->name('search');


        /*
        |----------------------------------------------------------------------
        | Profile
        |----------------------------------------------------------------------
        */

        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
            ->name('profile.password');


        /*
        |----------------------------------------------------------------------
        | Organisasi
        |----------------------------------------------------------------------
        */

        // Pengurus
        Route::get('/pengurus', [PengurusController::class, 'index'])
            ->middleware('permission:pengurus.view')->name('pengurus.index');
        Route::get('/pengurus/create', [PengurusController::class, 'create'])
            ->middleware('permission:pengurus.create')->name('pengurus.create');
        Route::post('/pengurus', [PengurusController::class, 'store'])
            ->middleware('permission:pengurus.create')->name('pengurus.store');
        Route::get('/pengurus/{pengurus}', [PengurusController::class, 'show'])
            ->middleware('permission:pengurus.view')->name('pengurus.show');
        Route::get('/pengurus/{pengurus}/edit', [PengurusController::class, 'edit'])
            ->middleware('permission:pengurus.update')->name('pengurus.edit');
        Route::put('/pengurus/{pengurus}', [PengurusController::class, 'update'])
            ->middleware('permission:pengurus.update')->name('pengurus.update');
        Route::delete('/pengurus/{pengurus}', [PengurusController::class, 'destroy'])
            ->middleware('permission:pengurus.delete')->name('pengurus.destroy');

        // Departemen
        Route::get('/departemen', [DepartemenController::class, 'index'])
            ->middleware('permission:departemen.view')->name('departemen.index');
        Route::get('/departemen/create', [DepartemenController::class, 'create'])
            ->middleware('permission:departemen.create')->name('departemen.create');
        Route::post('/departemen', [DepartemenController::class, 'store'])
            ->middleware('permission:departemen.create')->name('departemen.store');
        Route::get('/departemen/{departemen}', [DepartemenController::class, 'show'])
            ->middleware('permission:departemen.view')->name('departemen.show');
        Route::get('/departemen/{departemen}/edit', [DepartemenController::class, 'edit'])
            ->middleware('permission:departemen.update')->name('departemen.edit');
        Route::put('/departemen/{departemen}', [DepartemenController::class, 'update'])
            ->middleware('permission:departemen.update')->name('departemen.update');
        Route::delete('/departemen/{departemen}', [DepartemenController::class, 'destroy'])
            ->middleware('permission:departemen.delete')->name('departemen.destroy');

        // Program Kerja
        Route::get('/program-kerja', [ProgramKerjaController::class, 'index'])
            ->middleware('permission:program-kerja.view')->name('program-kerja.index');
        Route::get('/program-kerja/create', [ProgramKerjaController::class, 'create'])
            ->middleware('permission:program-kerja.create')->name('program-kerja.create');
        Route::post('/program-kerja', [ProgramKerjaController::class, 'store'])
            ->middleware('permission:program-kerja.create')->name('program-kerja.store');
        Route::get('/program-kerja/{program_kerja}', [ProgramKerjaController::class, 'show'])
            ->middleware('permission:program-kerja.view')->name('program-kerja.show');
        Route::get('/program-kerja/{program_kerja}/edit', [ProgramKerjaController::class, 'edit'])
            ->middleware('permission:program-kerja.update')->name('program-kerja.edit');
        Route::put('/program-kerja/{program_kerja}', [ProgramKerjaController::class, 'update'])
            ->middleware('permission:program-kerja.update')->name('program-kerja.update');
        Route::delete('/program-kerja/{program_kerja}', [ProgramKerjaController::class, 'destroy'])
            ->middleware('permission:program-kerja.delete')->name('program-kerja.destroy');


        /*
        |----------------------------------------------------------------------
        | Konten
        |----------------------------------------------------------------------
        */

        // Agenda
        Route::get('/agenda', [AgendaController::class, 'index'])
            ->middleware('permission:agenda.view')->name('agenda.index');
        Route::get('/agenda/create', [AgendaController::class, 'create'])
            ->middleware('permission:agenda.create')->name('agenda.create');
        Route::post('/agenda', [AgendaController::class, 'store'])
            ->middleware('permission:agenda.create')->name('agenda.store');
        Route::get('/agenda/{agenda}', [AgendaController::class, 'show'])
            ->middleware('permission:agenda.view')->name('agenda.show');
        Route::get('/agenda/{agenda}/edit', [AgendaController::class, 'edit'])
            ->middleware('permission:agenda.update')->name('agenda.edit');
        Route::put('/agenda/{agenda}', [AgendaController::class, 'update'])
            ->middleware('permission:agenda.update')->name('agenda.update');
        Route::delete('/agenda/{agenda}', [AgendaController::class, 'destroy'])
            ->middleware('permission:agenda.delete')->name('agenda.destroy');

        // Pengumuman
        Route::get('/pengumuman', [PengumumanController::class, 'index'])
            ->middleware('permission:pengumuman.view')->name('pengumuman.index');
        Route::get('/pengumuman/create', [PengumumanController::class, 'create'])
            ->middleware('permission:pengumuman.create')->name('pengumuman.create');
        Route::post('/pengumuman', [PengumumanController::class, 'store'])
            ->middleware('permission:pengumuman.create')->name('pengumuman.store');
        Route::get('/pengumuman/{pengumuman}', [PengumumanController::class, 'show'])
            ->middleware('permission:pengumuman.view')->name('pengumuman.show');
        Route::get('/pengumuman/{pengumuman}/edit', [PengumumanController::class, 'edit'])
            ->middleware('permission:pengumuman.update')->name('pengumuman.edit');
        Route::put('/pengumuman/{pengumuman}', [PengumumanController::class, 'update'])
            ->middleware('permission:pengumuman.update')->name('pengumuman.update');
        Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])
            ->middleware('permission:pengumuman.delete')->name('pengumuman.destroy');

        // Partner
        Route::get('/partner', [PartnerController::class, 'index'])
            ->middleware('permission:partner.view')->name('partner.index');
        Route::get('/partner/create', [PartnerController::class, 'create'])
            ->middleware('permission:partner.create')->name('partner.create');
        Route::post('/partner', [PartnerController::class, 'store'])
            ->middleware('permission:partner.create')->name('partner.store');
        Route::get('/partner/{partner}', [PartnerController::class, 'show'])
            ->middleware('permission:partner.view')->name('partner.show');
        Route::get('/partner/{partner}/edit', [PartnerController::class, 'edit'])
            ->middleware('permission:partner.update')->name('partner.edit');
        Route::put('/partner/{partner}', [PartnerController::class, 'update'])
            ->middleware('permission:partner.update')->name('partner.update');
        Route::delete('/partner/{partner}', [PartnerController::class, 'destroy'])
            ->middleware('permission:partner.delete')->name('partner.destroy');

        // Gallery
        Route::get('/gallery', [AdminGalleryController::class, 'index'])
            ->middleware('permission:gallery.view')->name('gallery.index');
        Route::get('/gallery/create', [AdminGalleryController::class, 'create'])
            ->middleware('permission:gallery.create')->name('gallery.create');
        Route::post('/gallery', [AdminGalleryController::class, 'store'])
            ->middleware('permission:gallery.create')->name('gallery.store');
        Route::get('/gallery/{gallery}', [AdminGalleryController::class, 'show'])
            ->middleware('permission:gallery.view')->name('gallery.show');
        Route::get('/gallery/{gallery}/edit', [AdminGalleryController::class, 'edit'])
            ->middleware('permission:gallery.update')->name('gallery.edit');
        Route::put('/gallery/{gallery}', [AdminGalleryController::class, 'update'])
            ->middleware('permission:gallery.update')->name('gallery.update');
        Route::delete('/gallery/{gallery}', [AdminGalleryController::class, 'destroy'])
            ->middleware('permission:gallery.delete')->name('gallery.destroy');

        // Gallery Items
        Route::get('/gallery/{gallery}/items/create', [GalleryItemController::class, 'create'])
            ->middleware('permission:gallery.create')->name('gallery.items.create');
        Route::post('/gallery/{gallery}/items', [GalleryItemController::class, 'store'])
            ->middleware('permission:gallery.create')->name('gallery.items.store');
        Route::get('/gallery/{gallery}/items/{galleryItem}/edit', [GalleryItemController::class, 'edit'])
            ->middleware('permission:gallery.update')->name('gallery.items.edit');
        Route::put('/gallery/{gallery}/items/{galleryItem}', [GalleryItemController::class, 'update'])
            ->middleware('permission:gallery.update')->name('gallery.items.update');
        Route::delete('/gallery/{gallery}/items/{galleryItem}', [GalleryItemController::class, 'destroy'])
            ->middleware('permission:gallery.delete')->name('gallery.items.destroy');


        /*
        |----------------------------------------------------------------------
        | Administrasi
        |----------------------------------------------------------------------
        */

        // Notulensi
        Route::get('/notulensi', [NotulensiController::class, 'index'])
            ->middleware('permission:notulensi.view')->name('notulensi.index');
        Route::get('/notulensi/create', [NotulensiController::class, 'create'])
            ->middleware('permission:notulensi.create')->name('notulensi.create');
        Route::post('/notulensi', [NotulensiController::class, 'store'])
            ->middleware('permission:notulensi.create')->name('notulensi.store');
        Route::get('/notulensi/{notulensi}', [NotulensiController::class, 'show'])
            ->middleware('permission:notulensi.view')->name('notulensi.show');
        Route::get('/notulensi/{notulensi}/edit', [NotulensiController::class, 'edit'])
            ->middleware('permission:notulensi.update')->name('notulensi.edit');
        Route::put('/notulensi/{notulensi}', [NotulensiController::class, 'update'])
            ->middleware('permission:notulensi.update')->name('notulensi.update');
        Route::delete('/notulensi/{notulensi}', [NotulensiController::class, 'destroy'])
            ->middleware('permission:notulensi.delete')->name('notulensi.destroy');

        // Dokumen
        Route::get('/dokumen', [DokumenController::class, 'index'])
            ->middleware('permission:dokumen.view')->name('dokumen.index');
        Route::get('/dokumen/create', [DokumenController::class, 'create'])
            ->middleware('permission:dokumen.create')->name('dokumen.create');
        Route::post('/dokumen', [DokumenController::class, 'store'])
            ->middleware('permission:dokumen.create')->name('dokumen.store');
        Route::get('/dokumen/{dokumen}', [DokumenController::class, 'show'])
            ->middleware('permission:dokumen.view')->name('dokumen.show');
        Route::get('/dokumen/{dokumen}/edit', [DokumenController::class, 'edit'])
            ->middleware('permission:dokumen.update')->name('dokumen.edit');
        Route::put('/dokumen/{dokumen}', [DokumenController::class, 'update'])
            ->middleware('permission:dokumen.update')->name('dokumen.update');
        Route::delete('/dokumen/{dokumen}', [DokumenController::class, 'destroy'])
            ->middleware('permission:dokumen.delete')->name('dokumen.destroy');

        // Surat
        Route::get('/surat', [SuratController::class, 'index'])
            ->middleware('permission:surat.view')->name('surat.index');
        Route::get('/surat/create', [SuratController::class, 'create'])
            ->middleware('permission:surat.create')->name('surat.create');
        Route::post('/surat', [SuratController::class, 'store'])
            ->middleware('permission:surat.create')->name('surat.store');
        Route::get('/surat/{surat}', [SuratController::class, 'show'])
            ->middleware('permission:surat.view')->name('surat.show');
        Route::get('/surat/{surat}/edit', [SuratController::class, 'edit'])
            ->middleware('permission:surat.update')->name('surat.edit');
        Route::put('/surat/{surat}', [SuratController::class, 'update'])
            ->middleware('permission:surat.update')->name('surat.update');
        Route::delete('/surat/{surat}', [SuratController::class, 'destroy'])
            ->middleware('permission:surat.delete')->name('surat.destroy');


        /*
        |----------------------------------------------------------------------
        | Keuangan
        |----------------------------------------------------------------------
        */

        // Anggaran
        Route::get('/anggaran', [AnggaranController::class, 'index'])
            ->middleware('permission:anggaran.view')->name('anggaran.index');
        Route::get('/anggaran/create', [AnggaranController::class, 'create'])
            ->middleware('permission:anggaran.create')->name('anggaran.create');
        Route::post('/anggaran', [AnggaranController::class, 'store'])
            ->middleware('permission:anggaran.create')->name('anggaran.store');
        Route::get('/anggaran/{anggaran}', [AnggaranController::class, 'show'])
            ->middleware('permission:anggaran.view')->name('anggaran.show');
        Route::get('/anggaran/{anggaran}/edit', [AnggaranController::class, 'edit'])
            ->middleware('permission:anggaran.update')->name('anggaran.edit');
        Route::put('/anggaran/{anggaran}', [AnggaranController::class, 'update'])
            ->middleware('permission:anggaran.update')->name('anggaran.update');
        Route::delete('/anggaran/{anggaran}', [AnggaranController::class, 'destroy'])
            ->middleware('permission:anggaran.delete')->name('anggaran.destroy');

        // Keuangan
        Route::get('/keuangan', [KeuanganController::class, 'index'])
            ->middleware('permission:keuangan.view')->name('keuangan.index');
        Route::get('/keuangan/create', [KeuanganController::class, 'create'])
            ->middleware('permission:keuangan.create')->name('keuangan.create');
        Route::post('/keuangan', [KeuanganController::class, 'store'])
            ->middleware('permission:keuangan.create')->name('keuangan.store');
        Route::get('/keuangan/{keuangan}', [KeuanganController::class, 'show'])
            ->middleware('permission:keuangan.view')->name('keuangan.show');
        Route::get('/keuangan/{keuangan}/edit', [KeuanganController::class, 'edit'])
            ->middleware('permission:keuangan.update')->name('keuangan.edit');
        Route::put('/keuangan/{keuangan}', [KeuanganController::class, 'update'])
            ->middleware('permission:keuangan.update')->name('keuangan.update');
        Route::delete('/keuangan/{keuangan}', [KeuanganController::class, 'destroy'])
            ->middleware('permission:keuangan.delete')->name('keuangan.destroy');

        // Laporan
        Route::middleware('permission:laporan.view')->group(function () {
            Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
            Route::get('/laporan/keuangan', [LaporanController::class, 'keuangan'])->name('laporan.keuangan');
            Route::get('/laporan/keuangan/pdf', [LaporanController::class, 'keuanganPdf'])->name('laporan.keuangan.pdf');
            Route::get('/laporan/program-kerja', [LaporanController::class, 'programKerja'])->name('laporan.program-kerja');
            Route::get('/laporan/program-kerja/pdf', [LaporanController::class, 'programKerjaPdf'])->name('laporan.program-kerja.pdf');
            Route::get('/laporan/agenda', [LaporanController::class, 'agenda'])->name('laporan.agenda');
            Route::get('/laporan/agenda/pdf', [LaporanController::class, 'agendaPdf'])->name('laporan.agenda.pdf');
        });


        /*
        |----------------------------------------------------------------------
        | Komunikasi — Pesan
        |----------------------------------------------------------------------
        */

        Route::middleware('permission:pesan.view')->group(function () {
            Route::patch('/pesan/mark-all-read', [PesanController::class, 'markAllRead'])
                ->name('pesan.mark-all-read');
            Route::patch('/pesan/{pesan}/status', [PesanController::class, 'updateStatus'])
                ->name('pesan.update-status');
            Route::get('/pesan', [PesanController::class, 'index'])->name('pesan.index');
            Route::get('/pesan/{pesan}', [PesanController::class, 'show'])->name('pesan.show');
        });

        Route::delete('/pesan/{pesan}', [PesanController::class, 'destroy'])
            ->middleware('permission:pesan.delete')->name('pesan.destroy');


        /*
        |----------------------------------------------------------------------
        | Sistem
        |----------------------------------------------------------------------
        */

        // Users
        Route::get('/users', [UserController::class, 'index'])
            ->middleware('permission:user.view')->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])
            ->middleware('permission:user.create')->name('users.create');
        Route::post('/users', [UserController::class, 'store'])
            ->middleware('permission:user.create')->name('users.store');
        Route::get('/users/{user}', [UserController::class, 'show'])
            ->middleware('permission:user.view')->name('users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])
            ->middleware('permission:user.update')->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])
            ->middleware('permission:user.update')->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])
            ->middleware('permission:user.delete')->name('users.destroy');

        // Roles
        Route::get('/roles', [RoleController::class, 'index'])
            ->middleware('permission:role.view')->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])
            ->middleware('permission:role.create')->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])
            ->middleware('permission:role.create')->name('roles.store');
        Route::get('/roles/{role}', [RoleController::class, 'show'])
            ->middleware('permission:role.view')->name('roles.show');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])
            ->middleware('permission:role.update')->name('roles.edit');
        Route::put('/roles/{role}', [RoleController::class, 'update'])
            ->middleware('permission:role.update')->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])
            ->middleware('permission:role.delete')->name('roles.destroy');

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])
            ->middleware('permission:settings.view')->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])
            ->middleware('permission:settings.update')->name('settings.update');

        // Landing Page CMS
        Route::get('/landing-page', [LandingPageController::class, 'index'])
            ->middleware('permission:settings.view')
            ->name('landing-page.index');

        Route::post('/landing-page/reorder', [LandingPageController::class, 'reorder'])
            ->middleware('permission:settings.update')
            ->name('landing-page.reorder');

        Route::get('/landing-page/{landingPage}/edit', [LandingPageController::class, 'edit'])
            ->middleware('permission:settings.view')
            ->name('landing-page.edit');

        Route::put('/landing-page/{landingPage}', [LandingPageController::class, 'update'])
            ->middleware('permission:settings.update')
            ->name('landing-page.update');

        Route::patch('/landing-page/{landingPage}/toggle', [LandingPageController::class, 'toggle'])
            ->middleware('permission:settings.update')
            ->name('landing-page.toggle');

        Route::patch('/landing-page/{landingPage}/reset', [LandingPageController::class, 'resetSection'])
            ->middleware('permission:settings.update')
            ->name('landing-page.reset');

        // Backup Database
        Route::get('/backup', [BackupController::class, 'index'])
            ->middleware('permission:settings.update')
            ->name('backup.index');

        Route::post('/backup', [BackupController::class, 'create'])
            ->middleware('permission:settings.update')
            ->name('backup.create');

        Route::get('/backup/{filename}/download', [BackupController::class, 'download'])
            ->middleware('permission:settings.update')
            ->name('backup.download');

        Route::delete('/backup/{filename}', [BackupController::class, 'destroy'])
            ->middleware('permission:settings.update')
            ->name('backup.destroy');

        // Activity Log
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])
            ->middleware('permission:activity-log.view')->name('activity-logs.index');
        Route::get('/activity-logs/{activityLog}', [ActivityLogController::class, 'show'])
            ->middleware('permission:activity-log.view')->name('activity-logs.show');


        /*
        |----------------------------------------------------------------------
        | Logout
        |----------------------------------------------------------------------
        */

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    });