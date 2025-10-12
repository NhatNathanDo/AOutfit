@extends('admin.layouts.app')

@section('title', 'Chi tiết Đơn hàng')

@section('content')
<div class="flex items-center justify-between gap-3 mb-4">
  <h2 class="text-xl font-semibold">Đơn hàng #{{ $order->id }}</h2>
  <div class="flex items-center gap-2">
    <a href="{{ route('admin.orders.page') }}" class="btn btn-sm">← Quay lại</a>
    <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-sm btn-primary" title="Tải hóa đơn PDF">
      <span class="icon-[tabler--download]"></span>
      Tải PDF
    </a>
  </div>
  </div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
  <div class="lg:col-span-2 space-y-4">
    <div class="card bg-base-100">
      <div class="card-body">
        <h3 class="card-title">Sản phẩm</h3>
        <div class="overflow-x-auto">
          <table class="table w-full">
            <thead>
              <tr>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>SL</th>
                <th>Tạm tính</th>
              </tr>
            </thead>
            <tbody>
              @foreach($order->order_items as $it)
                <tr>
                  <td class="flex items-center gap-3">
                    @php $img = optional($it->product?->primaryImage)->path; @endphp
                    @if($img)
                      <img src="{{ asset('storage/'.$img) }}" alt="{{ $it->product?->name }}" class="size-10 rounded object-cover" />
                    @endif
                    <div>
                      <div class="font-medium">{{ $it->product?->name }}</div>
                      <div class="text-xs text-base-content/60">ID: {{ $it->product_id }}</div>
                    </div>
                  </td>
                  <td>@php $p = number_format($it->price ?? 0, 0, ',', '.'); @endphp {{ $p }} ₫</td>
                  <td>{{ $it->quantity }}</td>
                  <td>@php $st = number_format(($it->price ?? 0) * ($it->quantity ?? 0), 0, ',', '.'); @endphp {{ $st }} ₫</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="card bg-base-100">
      <div class="card-body">
        <h3 class="card-title">Thanh toán</h3>
        <ul class="space-y-2">
          @forelse($order->payments as $pm)
            <li class="flex items-center justify-between">
              <div>
                <div class="font-medium">{{ $pm->method ?? $order->payment_method }}</div>
                <div class="text-xs text-base-content/60">{{ optional($pm->created_at)->format('d/m/Y H:i') }}</div>
              </div>
              <div class="font-medium">@php $v = number_format($pm->amount ?? 0, 0, ',', '.'); @endphp {{ $v }} ₫</div>
            </li>
          @empty
            <li class="text-base-content/60">Không có bản ghi thanh toán</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>

  <div class="space-y-4">
    <div class="card bg-base-100">
      <div class="card-body">
        <h3 class="card-title">Thông tin đơn</h3>
        <div class="space-y-2 text-sm">
          <div class="flex justify-between"><span>Khách hàng</span><span>{{ $order->user?->name }}</span></div>
          <div class="flex justify-between"><span>Email</span><span>{{ $order->user?->email }}</span></div>
          <div class="flex justify-between"><span>Thanh toán</span><span>{{ $order->payment_method }}</span></div>
          <div class="flex justify-between"><span>Trạng thái</span><span>{{ $order->status }}</span></div>
          <div class="flex justify-between"><span>Ngày tạo</span><span>{{ optional($order->created_at)->format('d/m/Y H:i') }}</span></div>
        </div>
      </div>
    </div>

    <div class="card bg-base-100">
      <div class="card-body">
        <h3 class="card-title">Cập nhật</h3>
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-3">
          @csrf
          @method('PATCH')
          <label class="form-control w-full">
            <div class="label"><span class="label-text">Trạng thái</span></div>
            <select name="status" class="select select-bordered select-sm">
              @foreach(['pending','processing','shipped','completed','cancelled','failed','refunded'] as $s)
                <option value="{{ $s }}" @selected($order->status === $s)>{{ $s }}</option>
              @endforeach
            </select>
          </label>
          <label class="form-control">
            <div class="label"><span class="label-text">Địa chỉ giao hàng</span></div>
            <textarea name="shipping_address" class="textarea textarea-bordered" rows="3">{{ old('shipping_address', $order->shipping_address) }}</textarea>
          </label>
          <label class="form-control">
            <div class="label"><span class="label-text">Phương thức thanh toán</span></div>
            <input type="text" name="payment_method" class="input input-bordered" value="{{ old('payment_method', $order->payment_method) }}" />
          </label>
          <div class="pt-2">
            <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
          </div>
        </form>
      </div>
    </div>

    <div class="card bg-base-100">
      <div class="card-body">
        <div class="flex justify-between items-center">
          <div class="font-semibold">Tổng tiền</div>
          <div class="text-lg font-bold">@php $t = number_format($order->total_amount ?? 0, 0, ',', '.'); @endphp {{ $t }} ₫</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
