<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HolidayRequest extends FormRequest
{
    public function rules()
    {
        return [
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ];
    }
}
