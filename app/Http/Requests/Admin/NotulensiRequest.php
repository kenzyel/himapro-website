<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NotulensiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'tanggal' => [
                'required',
                'date',
            ],

            'tempat' => [
                'nullable',
                'string',
                'max:255',
            ],

            'agenda' => [
                'nullable',
                'string',
            ],

            'peserta' => [
                'nullable',
                'string',
            ],

            'isi' => [
                'required',
                'string',
            ],

            'file' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx',
                'max:5120',
            ],

            'status' => [
                'required',
                Rule::in(['draft', 'final', 'archived']),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'judul' => 'judul notulensi',
            'tanggal' => 'tanggal',
            'tempat' => 'tempat',
            'agenda' => 'agenda',
            'peserta' => 'peserta',
            'isi' => 'isi notulensi',
            'file' => 'file',
            'status' => 'status',
        ];
    }
}