<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fasting_start_at' => ['sometimes','date_format:H:i','nullable'],
            'breakfast_at'     => ['sometimes','date_format:H:i','nullable'],
        ];
    }
}
