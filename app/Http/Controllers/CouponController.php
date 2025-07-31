<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Services\CouponService;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;

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
        
        return response()->json($coupon, 200);
    }

    public function show(Coupon $coupon)
    {
        $this->authorize('view', $coupon);
        
        $coupon = $this->couponService->show($coupon);
        
        return response()->json($coupon, 200);
    }

    public function store(StoreCouponRequest $request)
    {
        $this->authorize('create', Coupon::class);
        
        $validated = $request->validated();

        $coupon = $this->couponService->create($validated);
        
        return response()->json($coupon, 201);
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $this->authorize('update', $coupon);

        $validated = $request->validated();

        $coupon = $this->couponService->update($coupon, $validated);
        
        return response()->json($coupon, 200);
    }

    public function destroy(Coupon $coupon)
    {
        $this->authorize('delete', $coupon);

        $this->couponService->delete($coupon);
        
        return response()->json(null, 204);
    }

}
