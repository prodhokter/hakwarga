<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\ExtortionCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExtortionReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $categories = array_map(fn (ExtortionCategory $c) => $c->value, ExtortionCategory::cases());

        return [
            'region_id' => ['required', 'integer', 'exists:regions,id'],
            'category' => ['required', 'string', Rule::in($categories)],
            'amount_claimed' => ['nullable', 'integer', 'min:0', 'max:100000000'],
            'description' => ['required', 'string', 'min:20', 'max:3000'],
            'honeypot' => ['nullable', 'max:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'region_id.required' => 'Wilayah terjadinya pungutan wajib dipilih.',
            'category.required' => 'Bentuk potongan atau pungli wajib dipilih.',
            'description.required' => 'Uraian kejadian wajib diisi.',
            'description.min' => 'Uraian kejadian minimal 20 karakter agar dapat ditelaah.',
            'honeypot.max' => 'Pengiriman formulir terdeteksi otomatis oleh bot.',
        ];
    }
}
