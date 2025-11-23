<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $user = Auth::user();
        $cart = $this->cartService->getCartFor($user);
        
        if ($cart->cart_items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        $cartData = $this->cartService->serialize($cart);

        return view('customer.checkout.index', compact('cartData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province' => 'required|string',
            'district' => 'required|string',
            'ward' => 'required|string',
            'street' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,banking',
        ]);

        $user = Auth::user();
        $cart = $this->cartService->getCartFor($user);

        if ($cart->cart_items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        $cartData = $this->cartService->serialize($cart);
        $totalAmount = $cartData['total'];

        // Construct full address
        $fullAddress = implode(', ', [
            $request->street,
            $request->ward,
            $request->district,
            $request->province
        ]);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'id' => (string) Str::uuid(),
                'user_id' => $user->id,
                'cart_id' => $cart->id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->name . ', ' . $request->phone . ', ' . $fullAddress,
            ]);

            foreach ($cart->cart_items as $item) {
                OrderItem::create([
                    'id' => (string) Str::uuid(),
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }

            // Clear cart
            $this->cartService->clear($cart);

            DB::commit();

            return redirect()->route('shop.index')->with('success', 'Đặt hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage());
        }
    }
}
