<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->hasRole('Admin') === true; }
    public function rules(): array
    {
        return [
            'name' => ['required', 'array'], 'name.ar' => ['required', 'string', 'max:160'], 'name.en' => ['required', 'string', 'max:160'], 'name.it' => ['required', 'string', 'max:160'],
            'quote' => ['required', 'array'], 'quote.ar' => ['required', 'string', 'max:2000'], 'quote.en' => ['required', 'string', 'max:2000'], 'quote.it' => ['required', 'string', 'max:2000'],
            'destination' => ['nullable', 'array'], 'destination.*' => ['nullable', 'string', 'max:120'], 'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'video_url' => ['nullable', 'url', 'max:500'], 'rating' => ['required', 'integer', 'between:1,5'], 'sort_order' => ['sometimes', 'integer', 'min:0'], 'is_published' => ['sometimes', 'boolean'],
        ];
    }
    public function messages(): array { return ['required' => 'حقل :attribute مطلوب.', 'string' => 'يجب أن يكون :attribute نصًا.', 'max' => 'تجاوز :attribute الحد المسموح.', 'image' => 'يجب رفع صورة صحيحة.', 'mimes' => 'نوع الصورة غير مدعوم.', 'url' => 'أدخل رابطًا صحيحًا.', 'integer' => 'أدخل رقمًا صحيحًا.', 'between' => 'التقييم يجب أن يكون بين 1 و5.', 'min' => 'قيمة :attribute أقل من المسموح.']; }
}
