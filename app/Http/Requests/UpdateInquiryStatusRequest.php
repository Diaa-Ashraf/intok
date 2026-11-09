<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInquiryStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(['Admin', 'Editor']) === true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return ['status' => ['required', Rule::in(['new', 'contacted', 'closed'])]];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return ['required' => 'حالة الاستفسار مطلوبة.', 'in' => 'حالة الاستفسار غير صالحة.'];
    }
}
