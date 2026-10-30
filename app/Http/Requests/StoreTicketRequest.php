<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isOpd() ?? false;
    }

    public function rules(): array
    {
        $lampiran = config('ekonsul.lampiran');

        return [
            'judul'       => ['required', 'string', 'min:8', 'max:200'],
            'category_id' => ['required', Rule::exists('categories', 'id')->where('is_active', true)],
            'pertanyaan'  => ['required', 'string', 'min:20', 'max:5000'],

            'lampiran'   => ['nullable', 'array'],
            'lampiran.*' => [
                'file',
                'mimes:' . implode(',', $lampiran['ekstensi']),
                'max:' . $lampiran['maks_ukuran_kb'],
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'judul'       => 'judul',
            'category_id' => 'kategori',
            'pertanyaan'  => 'uraian pertanyaan',
            'lampiran'    => 'lampiran',
            'lampiran.*'  => 'berkas lampiran',
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required'       => 'Judul konsultasi wajib diisi.',
            'judul.min'             => 'Judul minimal 8 karakter agar cukup jelas.',
            'category_id.required' => 'Silakan pilih kategori konsultasi.',
            'category_id.exists'   => 'Kategori yang dipilih tidak tersedia.',
            'pertanyaan.required'  => 'Uraian pertanyaan wajib diisi.',
            'pertanyaan.min'       => 'Uraian pertanyaan minimal 20 karakter, jelaskan konteksnya secara ringkas.',
            'lampiran.*.mimes'     => 'Format berkas harus salah satu dari: ' . implode(', ', config('ekonsul.lampiran.ekstensi')) . '.',
            'lampiran.*.max'       => 'Ukuran tiap berkas maksimal ' . round(config('ekonsul.lampiran.maks_ukuran_kb') / 1024, 1) . ' MB.',
        ];
    }
}
