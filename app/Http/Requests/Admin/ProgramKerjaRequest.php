<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProgramKerjaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $programKerjaId = $this->route('programKerja')?->id;

        return [
            'departemen_id' => [
                'required',
                'integer',
                'exists:departemens,id',
            ],

            'nama' => [
                'required',
                'string',
                'max:150',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:180',
                Rule::unique('program_kerjas', 'slug')->ignore($programKerjaId),
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'tujuan' => [
                'nullable',
                'string',
            ],

            'target' => [
                'nullable',
                'string',
            ],

            'periode' => [
                'required',
                'string',
                'max:20',
            ],

            'status' => [
                'required',
                'in:planned,ongoing,completed,cancelled',
            ],

            'tanggal_mulai' => [
                'nullable',
                'date',
            ],

            'tanggal_selesai' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_mulai',
            ],

            'anggaran' => [
                'nullable',
                'numeric',
                'min:0',
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

            'periode' => trim((string) $this->input('periode')),

            'anggaran' => $this->input('anggaran') !== null &&
                $this->input('anggaran') !== ''
                ? $this->input('anggaran')
                : 0,
        ]);
    }
}