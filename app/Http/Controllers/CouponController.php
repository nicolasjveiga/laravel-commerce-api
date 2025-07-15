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
        return response()->json(Coupon::all());
    }

    public function store(StoreCouponRequest $request)
    {
        return response()->json($this->couponService->create($request->validated()), 201);
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        return response()->json($this->couponService->update($coupon, $request->validated()));
    }

    public function destroy(Coupon $coupon)
    {
        $this->couponService->delete($coupon);
        return response()->json(null, 204);
    }

}
