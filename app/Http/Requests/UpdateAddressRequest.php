<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'street' => 'sometimes|required|string|max:255',
            'number' => 'sometimes|required|string|max:50',
            'city' => 'sometimes|required|string|max:100',
            'country' => 'sometimes|required|string|max:100',
        ];
    }
}
