<div class="card bg-base-100 shadow">
    <div class="card-body p-4">
        <div class="flex items-center gap-2 mb-2">
            <h2 class="card-title text-base">Đơn hàng gần đây</h2>
            <div class="ms-auto join">
                @foreach(['all' => 'Tất cả', 'pending' => 'Chờ', 'paid' => 'Đã trả', 'shipped' => 'Đã gửi', 'cancelled' => 'Hủy'] as $key => $label)
                    <button wire:click="setStatus('{{$key}}')" class="btn btn-xs join-item {{ $statusFilter===$key ? 'btn-primary' : 'btn-ghost' }}">{{ $label }}</button>
                @endforeach
            </div>
        </div>
        <div class="overflow-x-auto -mx-4">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>Khách</th>
                        <th>Tổng</th>
                        <th>Trạng thái</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($this->orders as $order)
                    <tr class="hover">
                        <td class="font-mono">{{ $order['code'] }}</td>
                        <td>{{ $order['customer'] }}</td>
                        <td>{{ number_format($order['total'], 2) }}</td>
                        <td>
                            <span class="badge badge-sm badge-outline capitalize">{{ $order['status'] }}</span>
                        </td>
                        <td class="text-xs text-base-content/70">{{ $order['created_at'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2">{{ $this->orders->links() }}</div>
    </div>
</div>