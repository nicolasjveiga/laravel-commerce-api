<?php

namespace App\Repositories\Cart;

use App\Models\Cart\Cart;
use App\Models\Cart\CartItem;
use App\Models\Catalog\Product;
use Illuminate\Support\Facades\Auth;

class CartRepository
{
    public function getOrCreateUserCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }

    public function getCartItems()
    {
        return $this->getOrCreateUserCart()->items()->with('product')->get();
    }

    public function findCartItem(Cart $cart, int $productId)
    {
        return $cart->items()->where('product_id', $productId)->with('product')->first();
    }

    public function createCartItem(Cart $cart, array $data): CartItem
    {
        return $cart->items()->create($data);
    }

    public function updateCartItem(CartItem $item, int $quantity): CartItem
    {
        $item->update(['quantity' => $quantity]);
        return $item;
    } 

    public function deleteCartItem(CartItem $item): void
    {
        $item->delete();
    }

    public function clearCart(Cart $cart): void
    {
        $cart->items()->delete();
    }
}