<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|unique:coupons,code',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'discountPercentage' => 'required|numeric|min:0|max:100'
        ];
    }
}
