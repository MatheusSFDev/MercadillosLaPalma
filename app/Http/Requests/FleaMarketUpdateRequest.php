<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FleaMarketUpdateRequest extends FormRequest
{
    public function authorize()
    {
        
        return auth()->check();
    }

    public function rules()
    {
        return [
            'address' => 'required|string|max:255',
            'img_url' => 'nullable|string|max:1024',
            'schedules' => 'sometimes|array',
            'schedules.*.opening_time' => ['nullable', 'regex:/^([01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/'],
            'schedules.*.closing_time' => ['nullable', 'regex:/^([01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/'],
        ];
    }
}
