<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DiscountService;
use App\Models\Discount;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;

class DiscountController extends Controller
{
    protected $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    public function index()
    {
        $discounts = $this->discountService->listAll();
        return response()->json($discounts);
    }

    public function store(StoreDiscountRequest $request)
    {
         return response()->json($this->discountService->create($request->validated()), 201);
    }

    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        return response()->json($this->discountService->update($discount, $request->validated()));
    }

    public function destroy(Discount $discount)
    {
        $this->discountService->delete($discount);
        return response()->json(null, 204);
    }

}
