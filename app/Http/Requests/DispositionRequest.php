<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DispositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'unit_irban_id' => ['required', Rule::exists('unit_irbans', 'id')->where('is_active', true)],
            'catatan'       => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'unit_irban_id.required' => 'Silakan pilih unit Irban tujuan.',
            'unit_irban_id.exists'   => 'Unit Irban yang dipilih tidak tersedia.',
        ];
    }
}
