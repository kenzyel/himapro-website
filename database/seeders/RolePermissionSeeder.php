<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ROLES
        |--------------------------------------------------------------------------
        */

        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super-admin', 'description' => 'Akses penuh ke seluruh sistem.', 'is_active' => true],
            ['name' => 'Ketua Umum', 'slug' => 'ketua-umum', 'description' => 'Pimpinan organisasi, akses semua modul kecuali sistem.', 'is_active' => true],
            ['name' => 'Wakil Ketua Umum', 'slug' => 'wakil-ketua', 'description' => 'Wakil pimpinan, setara Ketua Umum.', 'is_active' => true],
            ['name' => 'Sekretaris 1', 'slug' => 'sekretaris-1', 'description' => 'Administrasi organisasi.', 'is_active' => true],
            ['name' => 'Sekretaris 2', 'slug' => 'sekretaris-2', 'description' => 'Administrasi organisasi.', 'is_active' => true],
            ['name' => 'Bendahara 1', 'slug' => 'bendahara-1', 'description' => 'Pengelolaan keuangan & anggaran.', 'is_active' => true],
            ['name' => 'Bendahara 2', 'slug' => 'bendahara-2', 'description' => 'Pengelolaan keuangan & anggaran.', 'is_active' => true],
            ['name' => 'CO Internal', 'slug' => 'co-internal', 'description' => 'Koordinator Departemen Internal.', 'is_active' => true],
            ['name' => 'CO Eksternal', 'slug' => 'co-eksternal', 'description' => 'Koordinator Departemen Eksternal.', 'is_active' => true],
            ['name' => 'CO Minat Bakat', 'slug' => 'co-minat-bakat', 'description' => 'Koordinator Departemen Minat Bakat.', 'is_active' => true],
            ['name' => 'Anggota', 'slug' => 'anggota', 'description' => 'Anggota departemen, akses lihat saja.', 'is_active' => true],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['slug' => $role['slug']], $role);
        }


        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */

        $permissions = [
            // Dashboard
            ['name' => 'Lihat Dashboard', 'slug' => 'dashboard.view', 'module' => 'dashboard'],

            // Pengurus
            ['name' => 'Lihat Pengurus', 'slug' => 'pengurus.view', 'module' => 'pengurus'],
            ['name' => 'Tambah Pengurus', 'slug' => 'pengurus.create', 'module' => 'pengurus'],
            ['name' => 'Edit Pengurus', 'slug' => 'pengurus.update', 'module' => 'pengurus'],
            ['name' => 'Hapus Pengurus', 'slug' => 'pengurus.delete', 'module' => 'pengurus'],

            // Departemen
            ['name' => 'Lihat Departemen', 'slug' => 'departemen.view', 'module' => 'departemen'],
            ['name' => 'Tambah Departemen', 'slug' => 'departemen.create', 'module' => 'departemen'],
            ['name' => 'Edit Departemen', 'slug' => 'departemen.update', 'module' => 'departemen'],
            ['name' => 'Hapus Departemen', 'slug' => 'departemen.delete', 'module' => 'departemen'],

            // Program Kerja
            ['name' => 'Lihat Program Kerja', 'slug' => 'program-kerja.view', 'module' => 'program-kerja'],
            ['name' => 'Tambah Program Kerja', 'slug' => 'program-kerja.create', 'module' => 'program-kerja'],
            ['name' => 'Edit Program Kerja', 'slug' => 'program-kerja.update', 'module' => 'program-kerja'],
            ['name' => 'Hapus Program Kerja', 'slug' => 'program-kerja.delete', 'module' => 'program-kerja'],

            // Agenda
            ['name' => 'Lihat Agenda', 'slug' => 'agenda.view', 'module' => 'agenda'],
            ['name' => 'Tambah Agenda', 'slug' => 'agenda.create', 'module' => 'agenda'],
            ['name' => 'Edit Agenda', 'slug' => 'agenda.update', 'module' => 'agenda'],
            ['name' => 'Hapus Agenda', 'slug' => 'agenda.delete', 'module' => 'agenda'],

            // Pengumuman
            ['name' => 'Lihat Pengumuman', 'slug' => 'pengumuman.view', 'module' => 'pengumuman'],
            ['name' => 'Tambah Pengumuman', 'slug' => 'pengumuman.create', 'module' => 'pengumuman'],
            ['name' => 'Edit Pengumuman', 'slug' => 'pengumuman.update', 'module' => 'pengumuman'],
            ['name' => 'Hapus Pengumuman', 'slug' => 'pengumuman.delete', 'module' => 'pengumuman'],

            // Gallery
            ['name' => 'Lihat Gallery', 'slug' => 'gallery.view', 'module' => 'gallery'],
            ['name' => 'Tambah Gallery', 'slug' => 'gallery.create', 'module' => 'gallery'],
            ['name' => 'Edit Gallery', 'slug' => 'gallery.update', 'module' => 'gallery'],
            ['name' => 'Hapus Gallery', 'slug' => 'gallery.delete', 'module' => 'gallery'],

            // Partner
            ['name' => 'Lihat Partner', 'slug' => 'partner.view', 'module' => 'partner'],
            ['name' => 'Tambah Partner', 'slug' => 'partner.create', 'module' => 'partner'],
            ['name' => 'Edit Partner', 'slug' => 'partner.update', 'module' => 'partner'],
            ['name' => 'Hapus Partner', 'slug' => 'partner.delete', 'module' => 'partner'],

            // Dokumen
            ['name' => 'Lihat Dokumen', 'slug' => 'dokumen.view', 'module' => 'dokumen'],
            ['name' => 'Tambah Dokumen', 'slug' => 'dokumen.create', 'module' => 'dokumen'],
            ['name' => 'Edit Dokumen', 'slug' => 'dokumen.update', 'module' => 'dokumen'],
            ['name' => 'Hapus Dokumen', 'slug' => 'dokumen.delete', 'module' => 'dokumen'],

            // Notulensi
            ['name' => 'Lihat Notulensi', 'slug' => 'notulensi.view', 'module' => 'notulensi'],
            ['name' => 'Tambah Notulensi', 'slug' => 'notulensi.create', 'module' => 'notulensi'],
            ['name' => 'Edit Notulensi', 'slug' => 'notulensi.update', 'module' => 'notulensi'],
            ['name' => 'Hapus Notulensi', 'slug' => 'notulensi.delete', 'module' => 'notulensi'],

            // Surat
            ['name' => 'Lihat Surat', 'slug' => 'surat.view', 'module' => 'surat'],
            ['name' => 'Tambah Surat', 'slug' => 'surat.create', 'module' => 'surat'],
            ['name' => 'Edit Surat', 'slug' => 'surat.update', 'module' => 'surat'],
            ['name' => 'Hapus Surat', 'slug' => 'surat.delete', 'module' => 'surat'],

            // Anggaran
            ['name' => 'Lihat Anggaran', 'slug' => 'anggaran.view', 'module' => 'anggaran'],
            ['name' => 'Tambah Anggaran', 'slug' => 'anggaran.create', 'module' => 'anggaran'],
            ['name' => 'Edit Anggaran', 'slug' => 'anggaran.update', 'module' => 'anggaran'],
            ['name' => 'Hapus Anggaran', 'slug' => 'anggaran.delete', 'module' => 'anggaran'],

            // Keuangan
            ['name' => 'Lihat Keuangan', 'slug' => 'keuangan.view', 'module' => 'keuangan'],
            ['name' => 'Tambah Keuangan', 'slug' => 'keuangan.create', 'module' => 'keuangan'],
            ['name' => 'Edit Keuangan', 'slug' => 'keuangan.update', 'module' => 'keuangan'],
            ['name' => 'Hapus Keuangan', 'slug' => 'keuangan.delete', 'module' => 'keuangan'],

            // Laporan
            ['name' => 'Lihat Laporan', 'slug' => 'laporan.view', 'module' => 'laporan'],

            // Pesan
            ['name' => 'Lihat Pesan', 'slug' => 'pesan.view', 'module' => 'pesan'],
            ['name' => 'Hapus Pesan', 'slug' => 'pesan.delete', 'module' => 'pesan'],

            // User
            ['name' => 'Lihat User', 'slug' => 'user.view', 'module' => 'user'],
            ['name' => 'Tambah User', 'slug' => 'user.create', 'module' => 'user'],
            ['name' => 'Edit User', 'slug' => 'user.update', 'module' => 'user'],
            ['name' => 'Hapus User', 'slug' => 'user.delete', 'module' => 'user'],

            // Role
            ['name' => 'Lihat Role', 'slug' => 'role.view', 'module' => 'role'],
            ['name' => 'Tambah Role', 'slug' => 'role.create', 'module' => 'role'],
            ['name' => 'Edit Role', 'slug' => 'role.update', 'module' => 'role'],
            ['name' => 'Hapus Role', 'slug' => 'role.delete', 'module' => 'role'],

            // Settings
            ['name' => 'Lihat Settings', 'slug' => 'settings.view', 'module' => 'settings'],
            ['name' => 'Edit Settings', 'slug' => 'settings.update', 'module' => 'settings'],

            // Activity Log
            ['name' => 'Lihat Activity Log', 'slug' => 'activity-log.view', 'module' => 'activity-log'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['slug' => $permission['slug']], $permission);
        }


        /*
        |--------------------------------------------------------------------------
        | ROLE → PERMISSION
        |--------------------------------------------------------------------------
        */

        $all = Permission::pluck('id');

        // 1. SUPER ADMIN — semua
        Role::where('slug', 'super-admin')->first()
            ->permissions()->sync($all);

        // 2. KETUA UMUM — semua kecuali user, role, settings, activity-log
        $ketuaPermissions = Permission::whereNotIn('module', [
            'user', 'role', 'settings', 'activity-log',
        ])->pluck('id');

        Role::where('slug', 'ketua-umum')->first()
            ->permissions()->sync($ketuaPermissions);

        // 3. WAKIL KETUA — sama dengan Ketua
        Role::where('slug', 'wakil-ketua')->first()
            ->permissions()->sync($ketuaPermissions);

        // 4 & 5. SEKRETARIS 1 & 2 — administrasi
        $sekretarisModules = [
            'dashboard', 'pengurus', 'departemen', 'program-kerja',
            'agenda', 'pengumuman', 'dokumen', 'notulensi', 'surat', 'pesan',
        ];
        $sekretarisPermissions = Permission::whereIn('module', $sekretarisModules)
            ->where(function ($q) {
                // Hapus aksi delete untuk pesan (hanya view)
                $q->where('slug', '!=', 'pesan.delete');
            })
            ->pluck('id');

        Role::where('slug', 'sekretaris-1')->first()
            ->permissions()->sync($sekretarisPermissions);

        Role::where('slug', 'sekretaris-2')->first()
            ->permissions()->sync($sekretarisPermissions);

        // 6 & 7. BENDAHARA 1 & 2 — keuangan
        $bendaharaPermissions = Permission::whereIn('module', [
            'dashboard', 'program-kerja', 'agenda',
            'anggaran', 'keuangan', 'laporan',
        ])
            ->where(function ($q) {
                // Hanya view untuk program-kerja & agenda
                $q->where(function ($sub) {
                    $sub->whereNotIn('module', ['program-kerja', 'agenda'])
                        ->orWhere('slug', 'like', '%.view');
                });
            })
            ->pluck('id');

        Role::where('slug', 'bendahara-1')->first()
            ->permissions()->sync($bendaharaPermissions);

        Role::where('slug', 'bendahara-2')->first()
            ->permissions()->sync($bendaharaPermissions);

        // 8, 9, 10. CO (Internal / Eksternal / Minat Bakat) — sama
        $coPermissions = Permission::whereIn('module', [
            'dashboard', 'pengurus', 'departemen', 'program-kerja',
            'agenda', 'pengumuman', 'gallery', 'dokumen', 'notulensi',
        ])
            ->where(function ($q) {
                // pengumuman hanya view
                $q->where(function ($sub) {
                    $sub->where('module', '!=', 'pengumuman')
                        ->orWhere('slug', 'like', '%.view');
                });
            })
            ->pluck('id');

        foreach (['co-internal', 'co-eksternal', 'co-minat-bakat'] as $slug) {
            Role::where('slug', $slug)->first()
                ->permissions()->sync($coPermissions);
        }

        // 11. ANGGOTA — read only
        $anggotaPermissions = Permission::whereIn('module', [
            'dashboard', 'pengurus', 'departemen', 'program-kerja',
            'agenda', 'pengumuman', 'gallery', 'dokumen',
        ])
            ->where('slug', 'like', '%.view')
            ->pluck('id');

        Role::where('slug', 'anggota')->first()
            ->permissions()->sync($anggotaPermissions);
    }
}