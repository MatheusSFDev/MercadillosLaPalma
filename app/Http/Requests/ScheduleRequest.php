<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'day_of_week'   => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'opening_time'  => 'required|date_format:H:i',
            'closing_time'  => 'required|date_format:H:i|after:opening_time',
        ];
    }
}
