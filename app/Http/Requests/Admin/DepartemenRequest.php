<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DepartemenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $departemen = $this->route('departemen');

        $departemenId = $departemen instanceof \App\Models\Departemen
            ? $departemen->id
            : $departemen;

        return [
            'nama' => [
                'required',
                'string',
                'max:100',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:120',
                Rule::unique('departemens', 'slug')->ignore($departemenId),
            ],

            'kode' => [
                'required',
                'string',
                'max:20',
                Rule::unique('departemens', 'kode')->ignore($departemenId),
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'warna' => [
                'nullable',
                'string',
                'max:20',
            ],

            'icon' => [
                'nullable',
                'string',
                'max:100',
            ],

            'urutan' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                'in:active,inactive',
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

            'kode' => $this->filled('kode')
                ? strtoupper(trim($this->input('kode')))
                : null,

            'urutan' => $this->input('urutan') !== null
                ? (int) $this->input('urutan')
                : 0,
        ]);
    }
}