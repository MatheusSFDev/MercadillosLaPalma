<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StallUpdateRequest extends FormRequest
{
   
    public function rules()
    {
        return [
            'information'   => 'nullable|string|max:255',
            'name'          => 'nullable|string|max:100',
            'img_url'       => 'nullable|string|max:255',
            'home_delivery' => 'boolean',
            'active'        => 'boolean',
        ];
    }
}
