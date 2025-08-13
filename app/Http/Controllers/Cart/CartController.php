<?php

namespace App\Http\Controllers\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Services\CartService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartItemResource;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Http\Requests\Cart\AddCartItemRequest;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Cart $cart)
    {
        $cart = $this->cartService->getOrCreateUserCart();

        $this->authorize('index', $cart);

        $items = $this->cartService->getCartItems();
        
        return CartItemResource::collection($items);
    }

    public function store(AddCartItemRequest $request)
    {
        $cart = $this->cartService->getOrCreateUserCart();
        
        $this->authorize('addItem', $cart);

        $validated = $request->validated();

        $item = $this->cartService->addItem($validated);

        return new CartItemResource($item);
    }

    public function update(UpdateCartRequest $request, CartItem $cartItem)
    {
        $cart = $this->cartService->getOrCreateUserCart();  

        $this->authorize('update', $cart);

        $validated = $request->validated();

        $item = $this->cartService->updateItem($cartItem, $validated['quantity']);
        
        return new CartItemResource($item);
    }

    public function destroy(CartItem $cartItem)
    {
        $cart = $this->cartService->getOrCreateUserCart();

        $this->authorize('destroy', $cart);

        $this->cartService->removeItem($cartItem);
        
        return response()->json(null, 204);
    }

    public function clear()
    {
        $cart = $this->cartService->getOrCreateUserCart();

        $this->authorize('clear', $cart);

        $this->cartService->clearCart();
        
        return response()->json(null, 204);
    }
}