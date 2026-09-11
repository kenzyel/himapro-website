<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PartnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $partnerId = $this->route('partner')?->id;

        return [
            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('partners', 'slug')->ignore($partnerId),
            ],

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp,svg',
                'max:2048',
            ],

            'website' => [
                'nullable',
                'url',
                'max:255',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'urutan' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $nama = $this->input('nama');

        $this->merge([
            'slug' => $this->filled('slug')
                ? Str::slug($this->input('slug'))
                : ($nama ? Str::slug($nama) : null),

            'urutan' => $this->input('urutan') !== null
                ? (int) $this->input('urutan')
                : 0,
        ]);
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama partner',
            'slug' => 'slug',
            'logo' => 'logo',
            'website' => 'website',
            'deskripsi' => 'deskripsi',
            'urutan' => 'urutan',
            'status' => 'status',
        ];
    }
}