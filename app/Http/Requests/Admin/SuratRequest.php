<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SuratRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $suratId = $this->route('surat')?->id;
        $isEdit = $suratId !== null;

        return [
            'jenis' => [
                'required',
                Rule::in(['masuk', 'keluar']),
            ],

            'nomor_surat' => [
                'required',
                'string',
                'max:150',
                Rule::unique('surats', 'nomor_surat')->ignore($suratId),
            ],

            'tanggal_surat' => [
                'required',
                'date',
            ],

            'tanggal_terima' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_surat',
            ],

            'pengirim' => [
                'nullable',
                'string',
                'max:255',
            ],

            'penerima' => [
                'nullable',
                'string',
                'max:255',
            ],

            'perihal' => [
                'required',
                'string',
                'max:255',
            ],

            'file' => [
                $isEdit ? 'nullable' : 'nullable',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:5120',
            ],

            'status' => [
                'required',
                Rule::in(['draft', 'sent', 'received', 'archived']),
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'jenis' => 'jenis surat',
            'nomor_surat' => 'nomor surat',
            'tanggal_surat' => 'tanggal surat',
            'tanggal_terima' => 'tanggal terima',
            'pengirim' => 'pengirim',
            'penerima' => 'penerima',
            'perihal' => 'perihal',
            'file' => 'file',
            'status' => 'status',
            'keterangan' => 'keterangan',
        ];
    }
}