<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    /**
     * Ambil nilai setting dari database.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, mixed $default = null): mixed
    {
        static $cache = [];

        if (array_key_exists($key, $cache)) {
            return $cache[$key];
        }

        $setting = Setting::where('key', $key)->first();

        $value = $setting?->value;

        if ($value === null || $value === '') {
            $value = $default;
        }

        // Cast berdasarkan type
        if ($setting && $setting->type === 'boolean') {
            $value = (bool) $value;
        }

        $cache[$key] = $value;

        return $value;
    }
}