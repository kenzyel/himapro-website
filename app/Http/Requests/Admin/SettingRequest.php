<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'settings' => [
                'required',
                'array',
            ],

            'settings.*' => [
                'nullable',
            ],

            // File upload khusus
            'site_logo_file' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,svg',
                'max:2048',
            ],

            'site_favicon_file' => [
                'nullable',
                'file',
                'mimes:ico,png,jpg,jpeg,svg,webp',
                'max:512',
            ],

            'remove_site_logo' => [
                'nullable',
                'boolean',
            ],

            'remove_site_favicon' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'remove_site_logo' => $this->boolean('remove_site_logo'),
            'remove_site_favicon' => $this->boolean('remove_site_favicon'),
        ]);
    }

    public function attributes(): array
    {
        return [
            'settings' => 'pengaturan',
            'site_logo_file' => 'logo',
            'site_favicon_file' => 'favicon',
        ];
    }

    public function messages(): array
    {
        return [
            'site_logo_file.mimes' => 'Logo harus berformat JPG, PNG, WEBP, atau SVG.',
            'site_logo_file.max' => 'Ukuran logo maksimal 2 MB.',
            'site_favicon_file.max' => 'Ukuran favicon maksimal 512 KB.',
        ];
    }
}