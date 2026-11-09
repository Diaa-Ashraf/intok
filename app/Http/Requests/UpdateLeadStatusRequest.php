<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadStatusRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->hasAnyRole(['Admin', 'Editor']) === true; }
    public function rules(): array { return ['status' => ['required', Rule::in(['new', 'contacted', 'closed'])]]; }
    public function messages(): array { return ['required' => 'حالة الطلب مطلوبة.', 'in' => 'حالة الطلب غير صالحة.']; }
}
