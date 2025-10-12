@extends('admin.layouts.app')

@section('title', 'Quản lý Đơn hàng')

@section('content')
<div class="flex items-center justify-between gap-3 mb-4">
  <h2 class="text-xl font-semibold">Đơn hàng</h2>
</div>

<div id="datatable-orders" class="bg-base-100 flex flex-col rounded-md shadow-base-300/20 shadow-sm"
  data-datatable='{
    "pageLength": 10,
    "pagingOptions": { "pageBtnClasses": "btn btn-text btn-circle btn-sm" },
    "selecting": true,
    "ordering": false,
    "rowSelectingOptions": { "selectAllSelector": "#orders-select-all", "individualSelector": ".orders-select-row" },
    "language": { "zeroRecords": "<div class=\"py-10 px-5 flex flex-col justify-center items-center text-center\"><span class=\"icon-[tabler--search] shrink-0 size-6 text-base-content\"></span><div class=\"max-w-sm mx-auto\"><p class=\"mt-2 text-sm text-base-content/80\">Không có kết quả</p></div></div>" }
  }'>
  <div class="border-base-content/25 flex items-center border-b px-5 py-3 gap-3">
    <div class="input input-sm max-w-60">
      <span class="icon-[tabler--search] text-base-content/80 my-auto me-3 size-4 shrink-0"></span>
      <label class="sr-only" for="orders-search"></label>
      <input type="search" class="grow" placeholder="Tìm kiếm..." id="orders-search" data-datatable-search="" />
    </div>
    <div class="flex flex-1 items-center justify-end gap-3">
      <select data-select='{
          "placeholder": "Hiển thị...",
          "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
          "toggleClasses": "advance-select-toggle advance-select-sm",
          "dropdownClasses": "advance-select-menu w-24 max-sm:w-16",
          "optionClasses": "advance-select-option selected:select-active",
          "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"icon-[tabler--check] shrink-0 size-3 text-primary hidden selected:block \"></span></div>",
          "extraMarkup": "<span class=\"icon-[tabler--caret-up-down] shrink-0 size-4 text-base-content absolute top-1/2 end-2 -translate-y-1/2 \"></span>"
        }' class="hidden" data-datatable-page-entities="">
        <option value="5">5</option>
        <option value="10" selected>10</option>
        <option value="20">20</option>
        <option value="30">30</option>
        <option value="50">50</option>
      </select>
    </div>
  </div>

  <div class="overflow-x-auto">
    <div class="inline-block min-w-full align-middle">
      <div class="overflow-hidden">
        <table class="table min-w-full">
          <thead>
            <tr>
              <th class="--exclude-from-ordering w-3.5 pe-0">
                <div class="flex h-5 items-center">
                  <input id="orders-select-all" type="checkbox" class="checkbox checkbox-sm" />
                  <label for="orders-select-all" class="sr-only">Chọn tất cả</label>
                </div>
              </th>
              <th>Mã đơn</th>
              <th>Khách hàng</th>
              <th>Tổng tiền</th>
              <th>Trạng thái</th>
              <th>Thanh toán</th>
              <th>Ngày tạo</th>
              <th class="--exclude-from-ordering text-right">Hành động</th>
            </tr>
          </thead>
          <tbody>
            @forelse($orders as $i => $o)
              <tr>
                <td class="w-3.5 pe-0">
                  <div class="flex h-5 items-center">
                    <input id="order-row-{{ $i+1 }}" type="checkbox" class="checkbox checkbox-sm orders-select-row" data-datatable-row-selecting-individual="" />
                    <label for="order-row-{{ $i+1 }}" class="sr-only">Chọn</label>
                  </div>
                </td>
                <td class="font-mono">{{ $o->id }}</td>
                <td>{{ optional($o->user)->name }}<div class="text-xs text-base-content/60">{{ optional($o->user)->email }}</div></td>
                <td>
                  @php $v = number_format($o->total_amount ?? 0, 0, ',', '.'); @endphp
                  {{ $v }} ₫
                </td>
                <td>
                  @php $st = $o->status; @endphp
                  @switch($st)
                    @case('pending') <span class="badge badge-soft badge-warning badge-sm">Chờ</span> @break
                    @case('processing') <span class="badge badge-soft badge-info badge-sm">Xử lý</span> @break
                    @case('shipped') <span class="badge badge-soft badge-accent badge-sm">Đã gửi</span> @break
                    @case('completed') <span class="badge badge-soft badge-success badge-sm">Hoàn tất</span> @break
                    @case('cancelled') <span class="badge badge-soft badge-error badge-sm">Hủy</span> @break
                    @case('refunded') <span class="badge badge-soft badge-neutral badge-sm">Hoàn tiền</span> @break
                    @default <span class="badge badge-soft badge-ghost badge-sm">Khác</span>
                  @endswitch
                </td>
                <td>{{ $o->payment_method }}</td>
                <td>{{ optional($o->created_at)->format('d/m/Y H:i') }}</td>
                <td class="text-right">
                  <a href="{{ route('admin.orders.edit', $o->id) }}" class="btn btn-circle btn-text btn-sm" title="Chi tiết/Sửa">
                    <span class="icon-[tabler--pencil] size-5"></span>
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center text-base-content/60">Không có dữ liệu</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="border-base-content/25 flex items-center justify-between gap-3 border-t p-3 max-md:flex-wrap max-md:justify-center">
    <div class="text-base-content/80 text-sm" data-datatable-info="">
      Hiển thị
      <span data-datatable-info-from="1"></span>
      đến
      <span data-datatable-info-to="30"></span>
      trên tổng
      <span data-datatable-info-length="50"></span>
      đơn hàng
    </div>
    <div class="flex hidden items-center space-x-1" data-datatable-paging="">
      <button type="button" class="btn btn-text btn-circle btn-sm" data-datatable-paging-prev="">
        <span class="icon-[tabler--chevrons-left] size-4.5 rtl:rotate-180"></span>
        <span class="sr-only">Trước</span>
      </button>
      <div class="[&>.active]:text-bg-soft-primary flex items-center space-x-1" data-datatable-paging-pages=""></div>
      <button type="button" class="btn btn-text btn-circle btn-sm" data-datatable-paging-next="">
        <span class="sr-only">Sau</span>
        <span class="icon-[tabler--chevrons-right] size-4.5 rtl:rotate-180"></span>
      </button>
    </div>
  </div>
</div>
@endsection
