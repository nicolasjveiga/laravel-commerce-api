<?php

namespace App\Services\Cart;

use App\Models\Cart\CartItem;
use App\Models\Catalog\Product;
use App\Models\Cart\Cart;
use App\Repositories\Cart\CartRepository;

class CartService
{
    protected CartRepository $cartRepo;

    public function __construct(CartRepository $cartRepo)
    {
        $this->cartRepo = $cartRepo;
    }

    public function getOrCreateUserCart(): Cart
    {
        return $this->cartRepo->getOrCreateUserCart();
    }

    public function getCartItems()
    {
        return $this->cartRepo->getCartItems();
    }

    public function addItem(array $data): CartItem
    {
        $cart = $this->cartRepo->getOrCreateUserCart();
        
        $item = $this->cartRepo->findCartItem($cart, $data['product_id']);

        if ($item) {
            $item->quantity += $data['quantity'];
            $item->save();
        } else {
            $product = Product::findOrFail($data['product_id']);
            $item = $this->cartRepo->createCartItem($cart, [
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'unitPrice' => $product->price,
            ]);
        }
        return $item;
    }

    public function updateItem(CartItem $item, int $quantity): CartItem
    {
        $this->cartRepo->updateCartItem($item, $quantity);
        return $item->fresh();
    }

    public function removeItem(CartItem $item): void
    {
        $this->cartRepo->deleteCartItem($item);
    }

    public function clearCart(): void
    {
        $cart = $this->cartRepo->getOrCreateUserCart();
        $this->cartRepo->clearCart($cart);
    }

}