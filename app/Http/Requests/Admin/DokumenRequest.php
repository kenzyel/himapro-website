<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DokumenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isEdit = $this->route('dokumen') !== null;

        return [
            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'kategori' => [
                'required',
                'string',
                'max:50',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'file' => [
                $isEdit ? 'nullable' : 'required',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar',
                'max:10240',
            ],

            'periode' => [
                'nullable',
                'string',
                'max:20',
            ],

            'is_public' => [
                'required',
                'boolean',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_public' => $this->boolean('is_public'),
        ]);
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama dokumen',
            'kategori' => 'kategori',
            'deskripsi' => 'deskripsi',
            'file' => 'file',
            'periode' => 'periode',
            'is_public' => 'status publikasi',
        ];
    }
}