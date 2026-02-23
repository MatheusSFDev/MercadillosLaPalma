<?php

namespace App\Http\Requests;

use App\Enums\Units;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users_id',
            "name" => 'required|string|max:255',
            "unit" => ['required', new Enum(Units::class)],
            "category_id" => 'required|exists:users,id',
            "img" => 'nullable|string|max:255',
            "stall_id" => ['sometimes', 'required', 'exists:stall_id'],
            "quantity" => ['sometimes', 'required', 'number', 'min:1'],
            "price" => ['sometimes', 'required', 'number', 'min:0.01', 'regex:/^\d+(\.\d{1,2})?$/']
        ];
    }
}
