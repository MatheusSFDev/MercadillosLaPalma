<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FleaMarketUpdateRequest extends FormRequest
{
    public function authorize()
    {
        // authorization logic can be implemented later; for now allow admins
        return auth()->check();
    }

    public function rules()
    {
        return [
            'address' => 'required|string|max:255',
            'img_url' => 'nullable|string|max:1024',
            'schedules' => 'array',
            'schedules.*.opening_time' => 'nullable',
            'schedules.*.closing_time' => 'nullable',
        ];
    }
}
