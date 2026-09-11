<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnggaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'departemen_id' => [
                'nullable',
                'integer',
                'exists:departemens,id',
            ],

            'program_kerja_id' => [
                'nullable',
                'integer',
                'exists:program_kerjas,id',
            ],

            'periode' => [
                'required',
                'string',
                'max:20',
            ],

            'jumlah' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in(['draft', 'approved', 'realized', 'cancelled']),
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'jumlah' => $this->input('jumlah') !== null && $this->input('jumlah') !== ''
                ? $this->input('jumlah')
                : 0,
        ]);
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama anggaran',
            'departemen_id' => 'departemen',
            'program_kerja_id' => 'program kerja',
            'periode' => 'periode',
            'jumlah' => 'jumlah',
            'status' => 'status',
            'keterangan' => 'keterangan',
        ];
    }
}