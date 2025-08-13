<?php

namespace App\Http\Controllers\Discount;

use App\Models\Discount\Coupon;
use App\Services\CouponService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Discount\CouponResource;
use App\Http\Requests\Coupon\StoreCouponRequest;
use App\Http\Requests\Coupon\UpdateCouponRequest;

class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function index()
    {
        $this->authorize('viewAny', Coupon::class);
        
        $coupon = $this->couponService->listAll();
        
        return CouponResource::collection($coupon);
    }

    public function show(Coupon $coupon)
    {
        $this->authorize('view', $coupon);
        
        $coupon = $this->couponService->show($coupon);
        
        return new CouponResource($coupon);
    }

    public function store(StoreCouponRequest $request)
    {
        $this->authorize('create', Coupon::class);
        
        $validated = $request->validated();

        $coupon = $this->couponService->create($validated);
        
        return new CouponResource($coupon);
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $this->authorize('update', $coupon);

        $validated = $request->validated();

        $coupon = $this->couponService->update($coupon, $validated);
        
        return new CouponResource($coupon);
    }

    public function destroy(Coupon $coupon)
    {
        $this->authorize('delete', $coupon);

        $this->couponService->delete($coupon);
        
        return response()->json(null, 204);
    }

}
