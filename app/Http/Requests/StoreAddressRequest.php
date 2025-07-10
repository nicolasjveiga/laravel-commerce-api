<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:50',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
        ];
    }
}
