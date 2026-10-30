<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $lampiran = config('ekonsul.lampiran');

        return [
            'isi' => ['required', 'string', 'min:5', 'max:5000'],

            'lampiran'   => ['nullable', 'array'],
            'lampiran.*' => [
                'file',
                'mimes:' . implode(',', $lampiran['ekstensi']),
                'max:' . $lampiran['maks_ukuran_kb'],
            ],

            'minta_info' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'isi.required'     => 'Isi balasan wajib diisi.',
            'isi.min'          => 'Isi balasan minimal 5 karakter.',
            'lampiran.*.mimes' => 'Format berkas harus salah satu dari: ' . implode(', ', config('ekonsul.lampiran.ekstensi')) . '.',
            'lampiran.*.max'   => 'Ukuran tiap berkas maksimal ' . round(config('ekonsul.lampiran.maks_ukuran_kb') / 1024, 1) . ' MB.',
        ];
    }
}
