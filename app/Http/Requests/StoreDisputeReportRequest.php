<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\DisputeCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDisputeReportRequest extends FormRequest
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
        $categories = array_map(fn (DisputeCategory $c) => $c->value, DisputeCategory::cases());

        return [
            'region_id' => ['required', 'integer', 'exists:regions,id'],
            'program_id' => ['required', 'integer', 'exists:aid_programs,id'],
            'category' => ['required', 'string', Rule::in($categories)],
            'target_beneficiary_name' => ['required', 'string', 'min:3', 'max:120'],
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
            'region_id.required' => 'Wilayah kelurahan/desa wajib dipilih.',
            'program_id.required' => 'Program bantuan sosial wajib dipilih.',
            'category.required' => 'Alasan sanggah kelayakan wajib dipilih.',
            'target_beneficiary_name.required' => 'Nama warga yang disanggah wajib diisi.',
            'description.required' => 'Penjelasan alasan sanggahan wajib diisi.',
            'description.min' => 'Uraian alasan sanggah minimal 20 karakter.',
        ];
    }
}
