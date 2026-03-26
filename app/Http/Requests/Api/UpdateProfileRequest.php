<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()->id ?? null;

        return [
            'name'       => ['sometimes','string','max:255'],
            'email'      => ['sometimes','email','max:255', Rule::unique('users','email')->ignore($userId)],
            'age'        => ['sometimes','integer','min:0','max:120'],
            'gender'     => ['sometimes','string','in:male,female'],
            'blood_type' => ['sometimes','string','in:A,B,AB,O'],
            'height'     => ['sometimes','numeric','min:0','max:200'],
        ];
    }
}
