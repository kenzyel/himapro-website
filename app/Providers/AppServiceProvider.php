<?php

namespace App\Providers;

use App\Models\Agenda;
use App\Models\Anggaran;
use App\Models\Departemen;
use App\Models\Dokumen;
use App\Models\Gallery;
use App\Models\GalleryItem;
use App\Models\Keuangan;
use App\Models\LandingSection;
use App\Models\Notulensi;
use App\Models\Partner;
use App\Models\Pesan;
use App\Models\Pengumuman;
use App\Models\Pengurus;
use App\Models\ProgramKerja;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Surat;
use App\Models\User;
use App\Observers\ActivityLogObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL; // <--- Import facade URL
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Force HTTPS (Fix Mixed Content di Tunneling / Ngrok / VS Code Ports)
        |--------------------------------------------------------------------------
        */
        if (request()->server('HTTP_X_FORWARDED_PROTO') == 'https' || str_contains(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        Paginator::defaultView('vendor.pagination.himapro');
        Paginator::defaultSimpleView('vendor.pagination.himapro');


        /*
        |--------------------------------------------------------------------------
        | Activity Log Observer
        |--------------------------------------------------------------------------
        */

        $models = [
            Pengurus::class,
            Departemen::class,
            ProgramKerja::class,
            Agenda::class,
            Pengumuman::class,
            Gallery::class,
            GalleryItem::class,
            Partner::class,
            Pesan::class,
            Notulensi::class,
            Dokumen::class,
            Surat::class,
            Anggaran::class,
            Keuangan::class,
            User::class,
            Role::class,
            Setting::class,
        ];

        foreach ($models as $model) {
            $model::observe(ActivityLogObserver::class);
        }


        /*
        |--------------------------------------------------------------------------
        | Share data ke semua view
        |--------------------------------------------------------------------------
        */

        View::composer('*', function ($view) {
            // Settings
            try {
                $settings = Setting::pluck('value', 'key')->toArray();
            } catch (\Throwable $e) {
                $settings = [];
            }

            // Unread pesan count (hanya kalau user login)
            $unreadPesanCount = 0;
            try {
                if (auth()->check()) {
                    $unreadPesanCount = Pesan::where('status', 'unread')->count();
                }
            } catch (\Throwable $e) {
                $unreadPesanCount = 0;
            }

            // Navbar & Footer section (untuk frontend)
            $navbarSection = null;
            $footerSection = null;

            try {
                $navbarSection = LandingSection::get('navbar');
                $footerSection = LandingSection::get('footer');
            } catch (\Throwable $e) {
                // Abaikan kalau tabel belum ada
            }

            $view->with([
                'appSettings' => $settings,
                'unreadPesanCount' => $unreadPesanCount,
                'navbarSection' => $navbarSection,
                'footerSection' => $footerSection,
            ]);
        });
    }
}