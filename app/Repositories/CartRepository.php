<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
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

    public function findCartItem(Cart $cart, int $id)
    {
        return $cart->items()->where('id', $id)->with('product')->first();
    }

    public function createCartItem(Cart $cart, array $data): CartItem
    {
        $product = Product::findOrFail($data['product_id']);

        return $cart->items()->create([
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'unitPrice' => $product->price,
        ]);
    }

    public function updateCartItemQuantity(CartItem $item, int $quantity): CartItem
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