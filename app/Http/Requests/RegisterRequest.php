<?php

namespace App\Http\Requests;

use App\Models\Opd;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:100'],

            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email'],

            'opd_id' => [
                'required',
                Rule::exists('opds', 'id')->where('is_active', true),
            ],

            'jabatan' => ['required', 'string', 'max:100'],

            'password' => ['required', 'string', 'min:8', 'confirmed'],

            // Hanya wajib bila pengaman kode pendaftaran diaktifkan
            'kode_pendaftaran' => [
                config('ekonsul.pendaftaran.wajib_kode') ? 'required' : 'nullable',
                'string',
                'max:20',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'             => 'nama lengkap',
            'email'            => 'email',
            'opd_id'           => 'perangkat daerah',
            'jabatan'          => 'jabatan',
            'password'         => 'kata sandi',
            'kode_pendaftaran' => 'kode pendaftaran',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'name.min'           => 'Nama lengkap minimal 3 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah terdaftar. Silakan masuk atau gunakan email lain.',
            'opd_id.required'    => 'Silakan pilih Perangkat Daerah Anda.',
            'opd_id.exists'      => 'Perangkat Daerah yang dipilih tidak tersedia.',
            'jabatan.required'   => 'Jabatan wajib diisi.',
            'password.required'  => 'Kata sandi wajib diisi.',
            'password.min'       => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'kode_pendaftaran.required' => 'Kode pendaftaran wajib diisi. Kode dapat diperoleh dari pimpinan atau operator Perangkat Daerah Anda.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email'            => strtolower(trim((string) $this->input('email'))),
            'kode_pendaftaran' => trim((string) $this->input('kode_pendaftaran')),
        ]);
    }

    /**
     * Pemeriksaan tambahan setelah aturan dasar lolos:
     * memastikan OPD masih membuka pendaftaran dan kodenya benar.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v) {
            if ($v->errors()->hasAny(['opd_id'])) {
                return;
            }

            $opd = Opd::find($this->input('opd_id'));

            if (! $opd) {
                return;
            }

            if (! $opd->pendaftaran_dibuka) {
                $v->errors()->add(
                    'opd_id',
                    'Pendaftaran akun untuk ' . $opd->nama_opd . ' sedang ditutup. Silakan hubungi Admin Inspektorat.'
                );

                return;
            }

            if (config('ekonsul.pendaftaran.wajib_kode')) {
                $kodeBenar = $opd->kode_pendaftaran;

                if (blank($kodeBenar) || ! hash_equals($kodeBenar, (string) $this->input('kode_pendaftaran'))) {
                    $v->errors()->add(
                        'kode_pendaftaran',
                        'Kode pendaftaran tidak sesuai dengan Perangkat Daerah yang dipilih.'
                    );
                }
            }
        });
    }
}
