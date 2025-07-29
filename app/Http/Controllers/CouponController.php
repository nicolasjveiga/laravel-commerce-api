<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use App\Services\CouponService;

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
        $coupon = $this->couponService->create($request->validated());
        return response()->json($coupon, 201);
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $this->authorize('update', $coupon);
        $coupon = $this->couponService->update($coupon, $request->validated());
        return response()->json($coupon, 200);
    }

    public function destroy(Coupon $coupon)
    {
        $this->authorize('delete', $coupon);
        $this->couponService->delete($coupon);
        return response()->json(null, 204);
    }

}
