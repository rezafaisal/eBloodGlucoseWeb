<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBloodGlucoseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'blood_glucose' => ['required','numeric','between:50,300'],
            'context' => ['nullable', Rule::in(['before_breakfast','after_breakfast','random'])],
            'reading_time' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'reading_time.required' => 'Waktu pencatatan wajib diisi.',
        ];
    }
}
