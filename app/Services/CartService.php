<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getOrCreateUserCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }

    public function addItem(array $data): CartItem
    {
        $cart = $this->getOrCreateUserCart();
        
        $item = $cart->items()->where('product_id', $data['product_id'])->first();

        if ($item) {
            $item->quantity += $data['quantity'];
            $item->save();
        } else {
            $product = Product::findOrFail($data['product_id']);
            $item = $cart->items()->create([
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'unitPrice' => $product->price,
            ]);
        }
        return $item;
    }

    public function updateItem(CartItem $item, int $quantity): CartItem
    {
        $item->update(['quantity' => $quantity]);
        return $item;
    }

    public function removeItem(CartItem $item): void
    {
        $item->delete();
    }

    public function clearCart(): void
    {
        $cart = $this->getOrCreateUserCart();
        $cart->items()->delete();
    }

    public function getCartItems()
    {
        return $this->getOrCreateUserCart()->items()->with('product')->get();
    }
}