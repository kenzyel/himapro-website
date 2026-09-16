<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PengurusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pengurusId = $this->route('pengurus')?->id;

        return [
            'departemen_id' => [
                'nullable',
                'integer',
                'exists:departemens,id',
            ],

            'parent_id' => [
                'nullable',
                'integer',
                'exists:pengurus,id',
                Rule::notIn([$pengurusId]),
            ],

            'is_bph' => [       // ✅ baru
                'nullable',
                'boolean',
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'jabatan' => [
                'required',
                'string',
                'max:150',
            ],

            'tipe_jabatan' => [
                'required',
                'string',
                'max:50',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'bio' => [
                'nullable',
                'string',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'telepon' => [
                'nullable',
                'string',
                'max:50',
            ],

            'periode' => [
                'required',
                'string',
                'max:20',
            ],

            'urutan' => [
                'required',
                'integer',
                'min:1',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_bph' => $this->boolean('is_bph'),
        ]);
    }
}