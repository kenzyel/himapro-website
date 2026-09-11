<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class AgendaRequest extends FormRequest
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
        $agendaId = $this->route('agenda');

        if (is_object($agendaId)) {
            $agendaId = $agendaId->id;
        }

        return [
            'program_kerja_id' => [
                'nullable',
                'integer',
                'exists:program_kerjas,id',
            ],

            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:agendas,slug,' . $agendaId,
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'lokasi' => [
                'nullable',
                'string',
                'max:255',
            ],

            'tanggal_mulai' => [
                'required',
                'date',
            ],

            'tanggal_selesai' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_mulai',
            ],

            'status' => [
                'required',
                'in:planned,ongoing,completed,cancelled',
            ],

            'is_public' => [
                'required',
                'boolean',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'program_kerja_id' => 'program kerja',
            'judul' => 'judul agenda',
            'slug' => 'slug',
            'deskripsi' => 'deskripsi',
            'lokasi' => 'lokasi',
            'tanggal_mulai' => 'tanggal mulai',
            'tanggal_selesai' => 'tanggal selesai',
            'status' => 'status',
            'is_public' => 'status publikasi',
        ];
    }
}