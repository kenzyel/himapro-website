<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KeuanganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenis' => [
                'required',
                Rule::in(['pemasukan', 'pengeluaran']),
            ],

            'tanggal' => [
                'required',
                'date',
            ],

            'kategori' => [
                'required',
                'string',
                'max:100',
            ],

            'deskripsi' => [
                'required',
                'string',
                'max:255',
            ],

            'jumlah' => [
                'required',
                'numeric',
                'min:0.01',
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

            'bukti' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'required',
                Rule::in(['pending', 'approved', 'rejected']),
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
            'jenis' => 'jenis transaksi',
            'tanggal' => 'tanggal',
            'kategori' => 'kategori',
            'deskripsi' => 'deskripsi',
            'jumlah' => 'jumlah',
            'departemen_id' => 'departemen',
            'program_kerja_id' => 'program kerja',
            'bukti' => 'bukti',
            'status' => 'status',
            'keterangan' => 'keterangan',
        ];
    }
}