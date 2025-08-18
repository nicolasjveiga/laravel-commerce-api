<?php

namespace App\Http\Controllers\Discount;

use App\Models\Discount\Discount;
use App\Services\Discount\DiscountService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Discount\DiscountResource;
use App\Http\Requests\Discount\StoreDiscountRequest;
use App\Http\Requests\Discount\UpdateDiscountRequest;

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
        
        return DiscountResource::collection($discounts);
    }

    public function show(Discount $discount)
    {
        $this->authorize('view', $discount);
        
        $discount = $this->discountService->show($discount);
        
        return new DiscountResource($discount);
    }

    public function store(StoreDiscountRequest $request)
    {
        $this->authorize('create', Discount::class);
        
        $validated = $request->validated();

        $discount = $this->discountService->create($validated);
        
        return new DiscountResource($discount);
    }

    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        $this->authorize('update', $discount);
        
        $validated = $request->validated();

        $discount = $this->discountService->update($discount, $validated);
        
        return new DiscountResource($discount);
    }

    public function destroy(Discount $discount)
    {
        $this->authorize('delete', $discount);
        
        $this->discountService->delete($discount);
        
        return response()->json(null, 204);
    }

}
