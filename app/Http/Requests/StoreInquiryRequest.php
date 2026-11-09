<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:255', 'required_without:phone'],
            'phone' => ['nullable', 'string', 'max:30', 'required_without:email'],
            'subject' => ['nullable', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:5000'],
            'website' => ['nullable', 'string', 'max:0'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'required' => 'حقل :attribute مطلوب.', 'required_without' => 'أدخل :attribute أو وسيلة تواصل أخرى.',
            'email' => 'يرجى إدخال بريد إلكتروني صحيح.', 'string' => 'يجب أن يكون :attribute نصًا.',
            'max' => 'يجب ألا يتجاوز :attribute الحد المسموح.', 'max.numeric' => 'تعذر إرسال الطلب.',
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return ['name' => 'الاسم', 'email' => 'البريد الإلكتروني', 'phone' => 'رقم الهاتف', 'subject' => 'الموضوع', 'message' => 'الرسالة'];
    }
}
