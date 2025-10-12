<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hóa đơn #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .muted { color: #666; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 6px 8px; border-bottom: 1px solid #e5e5e5; }
        th { text-align: left; background: #f6f6f6; }
        .right { text-align: right; }
        .total { font-weight: bold; font-size: 13px; }
        .mb-1 { margin-bottom: 8px; }
        .mb-2 { margin-bottom: 12px; }
        .small { font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h2 style="margin:0">AOutfit</h2>
            <div class="small">Hóa đơn bán hàng</div>
        </div>
        <div style="text-align:right">
            <div class="small">Mã đơn:</div>
            <div style="font-weight:bold">#{{ $order->id }}</div>
            <div class="small">Ngày: {{ optional($order->created_at)->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    <div class="mb-2">
        <div class="mb-1"><strong>Khách hàng:</strong> {{ $order->user?->name }}</div>
        <div class="small muted">{{ $order->user?->email }}</div>
        <div class="small">Địa chỉ: {{ $order->shipping_address }}</div>
        <div class="small">Thanh toán: {{ $order->payment_method }}</div>
        <div class="small">Trạng thái: {{ $order->status }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th class="right">Giá</th>
                <th class="right">SL</th>
                <th class="right">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @php $sum = 0; @endphp
            @foreach($order->order_items as $it)
                @php $line = ($it->price ?? 0) * ($it->quantity ?? 0); $sum += $line; @endphp
                <tr>
                    <td>
                        {{ $it->product?->name ?? ('SP '.$it->product_id) }}
                        <div class="small muted">ID: {{ $it->product_id }}</div>
                    </td>
                    <td class="right">{{ number_format($it->price ?? 0, 0, ',', '.') }} ₫</td>
                    <td class="right">{{ $it->quantity }}</td>
                    <td class="right">{{ number_format($line, 0, ',', '.') }} ₫</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="right total">Tổng cộng</td>
                <td class="right total">{{ number_format($order->total_amount ?? $sum, 0, ',', '.') }} ₫</td>
            </tr>
        </tfoot>
    </table>

    <div class="mb-1" style="margin-top: 16px; text-align:center;">
        {{-- Barcode Code128 for Order ID --}}
        <?php $barcode = new \Milon\Barcode\DNS1D(); echo $barcode->getBarcodeHTML($order->id, 'C128', 1.4, 40); ?>
        <div class="small">Quét barcode để tra cứu đơn hàng</div>
    </div>

    <div class="small muted" style="margin-top: 8px; text-align:center;">Cảm ơn quý khách đã mua hàng!</div>
</body>
</html>
