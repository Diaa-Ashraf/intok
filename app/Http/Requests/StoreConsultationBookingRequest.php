<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreConsultationBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'booking_type' => ['nullable', 'string', Rule::in(['general', 'study_abroad'])],
            'name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'service_id' => ['nullable', 'integer', Rule::exists('services', 'id')->where('is_active', true)],
            'preferred_at' => ['nullable', 'date'],
            'preferred_contact_time' => ['nullable', 'string', 'max:150'],
            'language' => ['nullable', Rule::in(['ar', 'en', 'it'])],
            'notes' => ['nullable', 'string', 'max:2000'],
            'applicant_type' => ['nullable', 'string', Rule::in(['student', 'parent'])],
            'student_name' => [Rule::requiredIf(fn () => $this->input('applicant_type') === 'parent'), 'nullable', 'string', 'max:150'],
            'student_birth_date' => ['nullable', 'date'],
            'current_education_level' => ['nullable', 'string', 'max:100'],
            'target_education_level' => ['nullable', 'string', 'max:100'],
            'qualification_year' => ['nullable', 'string', 'max:20'],
            'destination_country' => ['nullable', 'string', 'max:100'],
            'has_applied_before' => ['nullable', 'string', Rule::in(['yes', 'no'])],
            'website' => ['nullable', 'string', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'حقل :attribute مطلوب.',
            'required_if' => 'حقل :attribute مطلوب عند اختيار ولي الأمر.',
            'email' => 'أدخل بريدًا إلكترونيًا صحيحًا.',
            'max' => 'تجاوز :attribute الحد المسموح به.',
            'exists' => 'الخدمة المختارة غير متاحة.',
            'date' => 'أدخل تاريخًا صحيحًا.',
            'in' => 'قيمة :attribute غير صالحة.',
            'string' => 'يجب أن يكون :attribute نصًا.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'الاسم بالكامل',
            'phone' => 'رقم الهاتف',
            'email' => 'البريد الإلكتروني',
            'service_id' => 'الخدمة المطلوبة',
            'preferred_at' => 'موعد التواصل المفضل',
            'preferred_contact_time' => 'موعد التواصل المفضل',
            'language' => 'لغة التواصل',
            'notes' => 'ملاحظات إضافية',
            'applicant_type' => 'الصفة (الطالب / ولي الأمر)',
            'student_name' => 'اسم الطالب',
            'student_birth_date' => 'تاريخ ميلاد الطالب',
            'current_education_level' => 'المرحلة الدراسية الحالية',
            'target_education_level' => 'المرحلة الدراسية المطلوبة',
            'qualification_year' => 'سنة الحصول على آخر مؤهل',
            'destination_country' => 'وجهة الدراسة المفضلة',
            'has_applied_before' => 'سابقة التقديم بالخارج',
        ];
    }
}
