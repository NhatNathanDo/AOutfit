<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Modules\Products\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;

class CartService
{
    public function getCartFor(User $user): Cart
    {
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
            'status' => 'active',
        ]);
        return $cart->load(['cart_items.product.primaryImage']);
    }

    public function addItem(Cart $cart, Product $product, int $quantity = 1): Cart
    {
        if ($product->stock <= 0) {
            return $cart->load(['cart_items.product.primaryImage']);
        }
        $existing = $cart->cart_items()->where('product_id', $product->id)->first();
        if ($existing) {
            $newQty = $existing->quantity + $quantity;
            if ($newQty > $product->stock) {
                $newQty = $product->stock;
            }
            $existing->update([
                'quantity' => $newQty,
                'price' => $product->price,
            ]);
        } else {
            $cart->cart_items()->create([
                'id' => (string) Str::uuid(),
                'product_id' => $product->id,
                'quantity' => min($quantity, $product->stock),
                'price' => $product->price,
            ]);
        }
        return $cart->refresh()->load(['cart_items.product.primaryImage']);
    }

    public function updateItem(Cart $cart, string $itemId, int $quantity): Cart
    {
        $item = $cart->cart_items()->where('id', $itemId)->firstOrFail();
        $product = Product::findOrFail($item->product_id);
        $newQty = min($quantity, $product->stock);
        $item->update([
            'quantity' => $newQty,
            'price' => $product->price,
        ]);
        return $cart->refresh()->load(['cart_items.product.primaryImage']);
    }

    public function removeItem(Cart $cart, string $itemId): Cart
    {
        $item = $cart->cart_items()->where('id', $itemId)->first();
        if ($item) {
            $item->delete();
        }
        return $cart->refresh()->load(['cart_items.product.primaryImage']);
    }

    public function clear(Cart $cart): Cart
    {
        $cart->cart_items()->delete();
        return $cart->refresh();
    }

    public function serialize(Cart $cart): array
    {
        $items = $cart->cart_items->map(function ($i) {
            $product = $i->product;
            if (!$product) {
                return null;
            }
            return [
                'id' => $i->id,
                'product_id' => $i->product_id,
                'name' => $product->name,
                'slug' => $product->slug,
                'image' => optional($product->primaryImage)->url ?? optional($product->images->first())->url,
                'quantity' => $i->quantity,
                'price' => $i->price,
                'subtotal' => $i->price * $i->quantity,
                'stock' => $product->stock,
            ];
        })->filter();

        return [
            'id' => $cart->id,
            'items' => $items->values(),
            'total' => $items->sum('subtotal'),
            'count' => $items->sum('quantity'),
            'currency' => 'VND',
        ];
    }
}
