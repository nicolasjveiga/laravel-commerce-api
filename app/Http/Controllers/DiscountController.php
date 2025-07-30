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
        $this->authorize('viewAny', Discount::class);

        $discounts = $this->discountService->listAll();
        
        return response()->json($discounts, 200);
    }

    public function show(Discount $discount)
    {
        $this->authorize('view', $discount);
        
        $discount = $this->discountService->show($discount);
        
        return response()->json($discount, 200);
    }

    public function store(StoreDiscountRequest $request)
    {
        $this->authorize('create', Discount::class);
        
        $validated = $request->validated();

        $discount = $this->discountService->create($validated);
        
        return response()->json($discount, 201);
    }

    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        $this->authorize('update', $discount);
        
        $validated = $request->validated();

        $discount = $this->discountService->update($discount, $validated);
        
        return response()->json($discount, 200);
    }

    public function destroy(Discount $discount)
    {
        $this->authorize('delete', $discount);
        
        $this->discountService->delete($discount);
        
        return response()->json(null, 204);
    }

}
