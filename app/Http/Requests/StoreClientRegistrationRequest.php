<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRegistrationRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'], 'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'], 'country' => ['required', 'string', 'max:120'],
            'education_level' => ['required', 'string', 'max:120'], 'service_id' => ['nullable', 'integer', Rule::exists('services', 'id')->where('is_active', true)],
            'website' => ['nullable', 'string', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return ['required' => 'حقل :attribute مطلوب.', 'email' => 'أدخل بريدًا إلكترونيًا صحيحًا.', 'max' => 'تجاوز :attribute الحد المسموح.', 'exists' => 'الخدمة المختارة غير متاحة.', 'integer' => 'قيمة :attribute غير صالحة.'];
    }

    public function attributes(): array
    {
        return ['name' => 'الاسم', 'phone' => 'رقم الهاتف', 'email' => 'البريد الإلكتروني', 'country' => 'الدولة', 'education_level' => 'المستوى التعليمي', 'service_id' => 'الخدمة'];
    }
}
