<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCartItemRequest;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $items = $this->cartService->getCartItems();
        return response()->json($items);
    }

    public function store(AddCartItemRequest $request)
    {
        $item = $this->cartService->addItem($request->validated());
        return response()->json($item, 201);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $item = $this->cartService->updateItem($cartItem, $validated['quantity']);
        return response()->json($item);
    }

    public function destroy(CartItem $cartItem)
    {
        $this->cartService->removeItem($cartItem);
        return response()->json(null, 204);
    }

    public function clear()
    {
        $this->cartService->clearCart();
        return response()->json(null, 204);
    }
}