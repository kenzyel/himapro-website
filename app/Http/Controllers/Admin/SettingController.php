<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(SettingRequest $request): RedirectResponse
    {
        $data = $request->validated()['settings'] ?? [];

        /*
        |--------------------------------------------------------------------------
        | Handle upload site_logo
        |--------------------------------------------------------------------------
        */

        // Hapus logo kalau diminta
        if ($request->boolean('remove_site_logo')) {
            $old = Setting::where('key', 'site_logo')->value('value');

            if ($old) {
                Storage::disk('public')->delete($old);
            }

            Setting::where('key', 'site_logo')->update(['value' => null]);
        }

        // Upload logo baru
        if ($request->hasFile('site_logo_file')) {
            $old = Setting::where('key', 'site_logo')->value('value');

            if ($old) {
                Storage::disk('public')->delete($old);
            }

            $path = $request->file('site_logo_file')->store('logo', 'public');

            Setting::where('key', 'site_logo')->update(['value' => $path]);

            // Hapus dari array settings biar tidak konflik
            unset($data['site_logo']);
        }

        /*
        |--------------------------------------------------------------------------
        | Handle upload site_favicon
        |--------------------------------------------------------------------------
        */

        if ($request->boolean('remove_site_favicon')) {
            $old = Setting::where('key', 'site_favicon')->value('value');

            if ($old) {
                Storage::disk('public')->delete($old);
            }

            Setting::where('key', 'site_favicon')->update(['value' => null]);
        }

        if ($request->hasFile('site_favicon_file')) {
            $old = Setting::where('key', 'site_favicon')->value('value');

            if ($old) {
                Storage::disk('public')->delete($old);
            }

            $path = $request->file('site_favicon_file')->store('favicon', 'public');

            Setting::where('key', 'site_favicon')->update(['value' => $path]);

            unset($data['site_favicon']);
        }

        /*
        |--------------------------------------------------------------------------
        | Update setting text lainnya
        |--------------------------------------------------------------------------
        */

        foreach ($data as $key => $value) {

            // Lewati field yang di-handle khusus
            if (in_array($key, ['site_logo', 'site_favicon'], true)) {
                continue;
            }

            Setting::where('key', $key)->update([
                'value' => is_array($value) ? json_encode($value) : $value,
            ]);
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }
}