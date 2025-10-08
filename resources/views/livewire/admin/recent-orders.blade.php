<div class="card bg-base-100 shadow relative">
    <div class="card-body p-4 space-y-3">
        <div class="flex flex-wrap items-center gap-2">
            <h2 class="card-title text-base">Đơn hàng gần đây</h2>
            <div class="ms-auto join shadow-sm">
                @foreach(['all' => 'Tất cả', 'pending' => 'Chờ', 'paid' => 'Đã trả', 'shipped' => 'Đã gửi', 'cancelled' => 'Hủy'] as $key => $label)
                    <button wire:click="setStatus('{{$key}}')" class="btn btn-xs join-item {{ $statusFilter===$key ? 'btn-primary' : 'btn-ghost' }}">{{ $label }}</button>
                @endforeach
            </div>
        </div>
        <div class="overflow-x-auto -mx-4">
            <table class="table table-sm">
                <thead class="sticky top-0 bg-base-100 z-10 text-xs">
                    <tr>
                        @php($headers = [ 'code' => 'Mã', 'customer' => 'Khách', 'total' => 'Tổng', 'status' => 'Trạng thái', 'created_at' => 'Thời gian'])
                        @foreach($headers as $field => $label)
                            <th class="whitespace-nowrap">
                                <button type="button" wire:click="sortBy('{{ $field }}')" class="inline-flex items-center gap-1 font-medium hover:underline {{ $sortField === $field ? 'text-primary' : '' }}">
                                    <span>{{ $label }}</span>
                                    @if($sortField === $field)
                                        <span class="icon-[tabler--chevron-{{ $sortDirection==='asc' ? 'up' : 'down' }}] size-4"></span>
                                    @endif
                                </button>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="align-middle">
                @forelse($this->orders as $order)
                    <tr class="hover">
                        <td class="font-mono text-xs">{{ $order['code'] }}</td>
                        <td class="text-sm">{{ $order['customer'] }}</td>
                        <td class="text-sm">{{ number_format($order['total'], 2) }}</td>
                        <td>
                            @php($statusColor = [ 'pending'=>'badge-warning','paid'=>'badge-success','shipped'=>'badge-info','cancelled'=>'badge-error'][$order['status']] ?? 'badge-ghost')
                            <span class="badge badge-sm capitalize {{ $statusColor }}">{{ $order['status'] }}</span>
                        </td>
                        <td class="text-[11px] text-base-content/60">{{ $order['created_at'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-base-content/50">Không có dữ liệu</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between gap-4 pt-1">
            <div class="text-[11px] text-base-content/50">Sắp xếp: {{ $sortField }} ({{ $sortDirection }})</div>
            <div class="ms-auto">{{ $this->orders->links() }}</div>
        </div>
    </div>
    <div wire:loading.delay class="absolute inset-0 backdrop-blur-sm bg-base-100/50 flex items-center justify-center">
        <span class="loading loading-ring loading-lg text-primary"></span>
    </div>
</div>