<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StallStoreRequest extends FormRequest
{

    public function rules()
    {
        return [
            'user_id'       => 'required|exists:users,id',
            'information'   => 'nullable|string|max:255',
            'name'          => 'nullable|string|max:100',
            'img_url'       => 'nullable|string|max:255',
            'home_delivery' => 'boolean',
            'active'        => 'boolean',
        ];
    }
}
