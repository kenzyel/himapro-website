<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class GalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('nama') && ! $this->filled('slug')) {
            $this->merge([
                'slug' => Str::slug($this->input('nama')),
            ]);
        }
    }

    public function rules(): array
    {
        $galleryId = $this->route('gallery');

        if (is_object($galleryId)) {
            $galleryId = $galleryId->id;
        }

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
                'unique:galleries,slug,' . $galleryId,
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'cover' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            // Foto-foto gallery (multiple)
            'files' => [
                'nullable',
                'array',
                'max:10',
            ],

            'files.*' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'tanggal' => [
                'nullable',
                'date',
            ],

            'status' => [
                'required',
                'in:draft,published,archived',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama gallery',
            'slug' => 'slug',
            'deskripsi' => 'deskripsi',
            'cover' => 'cover',
            'files' => 'foto',
            'files.*' => 'foto',
            'tanggal' => 'tanggal',
            'status' => 'status',
        ];
    }

    public function messages(): array
    {
        return [
            'files.max' => 'Maksimal 10 foto per upload.',
            'files.*.image' => 'Semua file harus berupa gambar.',
            'files.*.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'files.*.max' => 'Ukuran tiap foto maksimal 5 MB.',
        ];
    }
}