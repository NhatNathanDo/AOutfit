<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Order\Service\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function __construct(private OrderService $service)
    {
    }

    // Admin page list
    public function page()
    {
        $orders = $this->service->list([], null);
        return view('admin.pages.orders.data', compact('orders'));
    }

    // JSON list
    public function index(Request $request)
    {
        $filters = $request->only(['search','status','payment_method','min_total','max_total','from','to','sort']);
        $perPage = $request->integer('per_page') ?: null;
        return response()->json($this->service->list($filters, $perPage));
    }

    public function show(string $id)
    {
        return response()->json($this->service->get($id));
    }

    public function edit(string $id)
    {
        $order = $this->service->get($id);
        return view('admin.pages.orders.edit', compact('order'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'status' => 'sometimes|required|string|in:pending,processing,shipped,completed,cancelled,failed,refunded',
            'shipping_address' => 'sometimes|nullable|string|max:1000',
            'payment_method' => 'sometimes|nullable|string|max:255',
        ]);
        $order = $this->service->update($id, $data);
        if ($request->expectsJson()) return response()->json($order);
        return redirect()->route('admin.orders.page')->with('success', 'Cập nhật đơn hàng thành công');
    }

    public function invoice(string $id)
    {
        $order = $this->service->get($id);
        $pdf = Pdf::loadView('admin.pages.orders.invoice', [
            'order' => $order,
        ])->setPaper('a5', 'portrait');
        $filename = 'invoice-'.$order->id.'.pdf';
        return $pdf->download($filename);
    }
}
