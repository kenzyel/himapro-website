<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PengumumanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('judul') && !$this->filled('slug')) {
            $this->merge([
                'slug' => Str::slug($this->input('judul')),
            ]);
        }
    }

    public function rules(): array
    {
        $pengumumanId = $this->route('pengumuman');

        if (is_object($pengumumanId)) {
            $pengumumanId = $pengumumanId->id;
        }

        return [
            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:pengumumans,slug,' . $pengumumanId,
            ],

            'ringkasan' => [
                'nullable',
                'string',
                'max:500',
            ],

            'isi' => [
                'required',
                'string',
            ],

            'status' => [
                'required',
                'in:draft,published,archived',
            ],

            'is_published' => [
                'required',
                'boolean',
            ],

            'published_at' => [
                'nullable',
                'date',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'judul' => 'judul pengumuman',
            'slug' => 'slug',
            'ringkasan' => 'ringkasan',
            'isi' => 'isi pengumuman',
            'status' => 'status',
            'is_published' => 'status publikasi',
            'published_at' => 'tanggal publikasi',
        ];
    }
}