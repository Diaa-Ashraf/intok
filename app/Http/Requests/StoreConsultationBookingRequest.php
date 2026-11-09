<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreConsultationBookingRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'], 'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'], 'service_id' => ['nullable', 'integer', Rule::exists('services', 'id')->where('is_active', true)],
            'preferred_at' => ['required', 'date', 'after:now'], 'language' => ['required', Rule::in(['ar', 'en', 'it'])],
            'notes' => ['nullable', 'string', 'max:2000'], 'website' => ['nullable', 'string', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return ['required' => 'حقل :attribute مطلوب.', 'email' => 'أدخل بريدًا إلكترونيًا صحيحًا.', 'max' => 'تجاوز :attribute الحد المسموح.', 'exists' => 'الخدمة المختارة غير متاحة.', 'date' => 'أدخل تاريخًا صحيحًا.', 'after' => 'يجب أن يكون الموعد في المستقبل.', 'in' => 'قيمة :attribute غير صالحة.', 'string' => 'يجب أن يكون :attribute نصًا.'];
    }

    public function attributes(): array
    {
        return ['name' => 'الاسم', 'phone' => 'رقم الهاتف', 'email' => 'البريد الإلكتروني', 'service_id' => 'الخدمة', 'preferred_at' => 'موعد الاستشارة', 'language' => 'لغة التواصل', 'notes' => 'ملاحظات'];
    }
}
