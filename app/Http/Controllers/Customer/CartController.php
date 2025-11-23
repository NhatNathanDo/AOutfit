<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Modules\Products\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    private function getCart(): Cart
    {
        $user = auth()->user();
        return $this->cartService->getCartFor($user);
    }

    public function index(Request $request)
    {
        $cart = $this->getCart();
        $serialized = $this->cartService->serialize($cart);
        return $request->expectsJson()
            ? response()->json($serialized)
            : view('customer.cart.index', ['cart' => $cart, 'cartData' => $serialized]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|string',
            'quantity' => 'nullable|integer|min:1',
        ]);
        $qty = $data['quantity'] ?? 1;
        $cart = $this->getCart();
        $product = Product::with('primaryImage')->findOrFail($data['product_id']);

        if ($product->stock <= 0) {
            return response()->json(['message' => 'Sản phẩm đã hết hàng'], 422);
        }

        $updated = $this->cartService->addItem($cart, $product, $qty);
        return response()->json($this->cartService->serialize($updated));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $cart = $this->getCart();
        $updated = $this->cartService->updateItem($cart, $id, $data['quantity']);
        return response()->json($this->cartService->serialize($updated));
    }

    public function destroy(string $id)
    {
        $cart = $this->getCart();
        $updated = $this->cartService->removeItem($cart, $id);
        return response()->json($this->cartService->serialize($updated));
    }

    public function clear()
    {
        $cart = $this->getCart();
        $updated = $this->cartService->clear($cart);
        return response()->json($this->cartService->serialize($updated));
    }

    // Serialization delegated to CartService
}
