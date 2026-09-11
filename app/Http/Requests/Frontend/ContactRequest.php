<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'telepon' => [
                'nullable',
                'string',
                'max:50',
            ],

            'subjek' => [
                'required',
                'string',
                'max:255',
            ],

            'pesan' => [
                'required',
                'string',
                'min:10',
                'max:5000',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama',
            'email' => 'email',
            'telepon' => 'telepon',
            'subjek' => 'subjek',
            'pesan' => 'pesan',
        ];
    }

    public function messages(): array
    {
        return [
            'pesan.min' => 'Pesan minimal 10 karakter.',
            'pesan.max' => 'Pesan maksimal 5000 karakter.',
        ];
    }
}