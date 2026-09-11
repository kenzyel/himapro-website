<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            /*
            |--------------------------------------------------------------------------
            | GENERAL
            |--------------------------------------------------------------------------
            */
            [
                'key' => 'site_name',
                'value' => 'HIMAPRO TI SAKTI',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Nama situs / organisasi',
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Himpunan Mahasiswa Program Studi Teknologi Informasi',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Tagline singkat organisasi',
            ],
            [
                'key' => 'site_description',
                'value' => 'Wadah pengembangan potensi, kolaborasi, dan kontribusi mahasiswa Program Studi Teknologi Informasi SAKTI.',
                'type' => 'textarea',
                'group' => 'general',
                'description' => 'Deskripsi singkat untuk SEO & about',
            ],
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
                'description' => 'Logo organisasi (opsional)',
            ],
            [
                'key' => 'site_favicon',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
                'description' => 'Favicon website (opsional)',
            ],

            /*
            |--------------------------------------------------------------------------
            | CONTACT
            |--------------------------------------------------------------------------
            */
            [
                'key' => 'contact_email',
                'value' => 'himapro@example.ac.id',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Email resmi organisasi',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 812-3456-7890',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Nomor telepon / WhatsApp',
            ],
            [
                'key' => 'contact_address',
                'value' => 'Kampus SAKTI, Jl. Pendidikan No. 1',
                'type' => 'textarea',
                'group' => 'contact',
                'description' => 'Alamat sekretariat',
            ],
            [
                'key' => 'contact_hours',
                'value' => 'Senin - Jumat: 08.00 - 17.00 WIB',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Jam operasional',
            ],
            [
                'key' => 'contact_maps',
                'value' => null,
                'type' => 'textarea',
                'group' => 'contact',
                'description' => 'Embed Google Maps (iframe HTML) — versi lama',
            ],
            [
                'key' => 'contact_maps_embed',
                'value' => null,
                'type' => 'textarea',
                'group' => 'contact',
                'description' => 'Kode embed Google Maps (iframe HTML) — paste dari Google Maps → Share → Embed a map',
            ],

            /*
            |--------------------------------------------------------------------------
            | SOCIAL MEDIA
            |--------------------------------------------------------------------------
            */
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/himapro',
                'type' => 'text',
                'group' => 'social',
                'description' => 'URL Instagram',
            ],
            [
                'key' => 'social_tiktok',
                'value' => 'https://tiktok.com/@himapro',
                'type' => 'text',
                'group' => 'social',
                'description' => 'URL TikTok',
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://youtube.com/@himapro',
                'type' => 'text',
                'group' => 'social',
                'description' => 'URL YouTube',
            ],
            [
                'key' => 'social_whatsapp',
                'value' => 'https://wa.me/6281234567890',
                'type' => 'text',
                'group' => 'social',
                'description' => 'URL WhatsApp',
            ],
            [
                'key' => 'social_facebook',
                'value' => null,
                'type' => 'text',
                'group' => 'social',
                'description' => 'URL Facebook (opsional)',
            ],

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */
            [
                'key' => 'seo_keywords',
                'value' => 'himapro, teknologi informasi, sakti, himpunan mahasiswa',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Meta keywords',
            ],
            [
                'key' => 'seo_author',
                'value' => 'HIMAPRO TI SAKTI',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Meta author',
            ],

            /*
            |--------------------------------------------------------------------------
            | SYSTEM
            |--------------------------------------------------------------------------
            */
            [
                'key' => 'system_maintenance',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'system',
                'description' => 'Mode maintenance (0 = off, 1 = on)',
            ],
            [
                'key' => 'system_periode_aktif',
                'value' => '2026/2027',
                'type' => 'text',
                'group' => 'system',
                'description' => 'Periode kepengurusan aktif',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}