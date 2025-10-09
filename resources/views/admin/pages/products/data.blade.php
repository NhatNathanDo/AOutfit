@extends('admin.layouts.app')

@section('title', 'Quản lý Sản phẩm')

@section('content')
<div class="flex items-center justify-between gap-3 mb-4">
  <h2 class="text-xl font-semibold">Sản phẩm</h2>
  <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-success">+ Thêm</a>
</div>

<div
  id="datatable-products"
  class="bg-base-100 flex flex-col rounded-md shadow-base-300/20 shadow-sm"
  data-datatable='{
    "pageLength": 10,
    "pagingOptions": { "pageBtnClasses": "btn btn-text btn-circle btn-sm" },
    "selecting": true,
    "ordering": false,
    "rowSelectingOptions": { "selectAllSelector": "#products-select-all", "individualSelector": ".products-select-row" },
    "language": { "zeroRecords": "<div class=\"py-10 px-5 flex flex-col justify-center items-center text-center\"><span class=\"icon-[tabler--search] shrink-0 size-6 text-base-content\"></span><div class=\"max-w-sm mx-auto\"><p class=\"mt-2 text-sm text-base-content/80\">Không có kết quả</p></div></div>" }
  }'
>
  <div class="border-base-content/25 flex items-center border-b px-5 py-3 gap-3">
    <div class="input input-sm max-w-60">
      <span class="icon-[tabler--search] text-base-content/80 my-auto me-3 size-4 shrink-0"></span>
      <label class="sr-only" for="products-search"></label>
      <input type="search" class="grow" placeholder="Tìm kiếm..." id="products-search" data-datatable-search="" />
    </div>
    <div class="flex flex-1 items-center justify-end gap-3">
      <select
        data-select='{
          "placeholder": "Hiển thị...",
          "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
          "toggleClasses": "advance-select-toggle advance-select-sm",
          "dropdownClasses": "advance-select-menu w-24 max-sm:w-16",
          "optionClasses": "advance-select-option selected:select-active",
          "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"icon-[tabler--check] shrink-0 size-3 text-primary hidden selected:block \"></span></div>",
          "extraMarkup": "<span class=\"icon-[tabler--caret-up-down] shrink-0 size-4 text-base-content absolute top-1/2 end-2 -translate-y-1/2 \"></span>"
        }'
        class="hidden"
        data-datatable-page-entities=""
      >
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
                  <input id="products-select-all" type="checkbox" class="checkbox checkbox-sm" />
                  <label for="products-select-all" class="sr-only">Chọn tất cả</label>
                </div>
              </th>
              <th>Tên</th>
              <th>Giá</th>
              <th>Kho</th>
              <th>Danh mục</th>
              <th>Nhãn hàng</th>
              <th>Giới tính</th>
              <th>Ngày tạo</th>
              <th class="--exclude-from-ordering text-right">Hành động</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products as $i => $p)
              <tr>
                <td class="w-3.5 pe-0">
                  <div class="flex h-5 items-center">
                    <input id="product-row-{{ $i+1 }}" type="checkbox" class="checkbox checkbox-sm products-select-row" data-datatable-row-selecting-individual="" />
                    <label for="product-row-{{ $i+1 }}" class="sr-only">Chọn</label>
                  </div>
                </td>
                <td>{{ $p->name }}</td>
                <td>
                  @php $v = number_format($p->price, 0, ',', '.'); @endphp
                  {{ $v }} ₫
                </td>
                <td>
                  @if(($p->stock ?? 0) > 10)
                    <span class="badge badge-soft badge-success badge-sm">Còn hàng ({{ $p->stock }})</span>
                  @elseif(($p->stock ?? 0) > 0)
                    <span class="badge badge-soft badge-warning badge-sm">Sắp hết ({{ $p->stock }})</span>
                  @else
                    <span class="badge badge-soft badge-error badge-sm">Hết hàng</span>
                  @endif
                </td>
                <td>{{ optional($p->category)->name }}</td>
                <td>{{ optional($p->brand)->name }}</td>
                <td>
                  @switch($p->gender)
                    @case('male') Nam @break
                    @case('female') Nữ @break
                    @default Unisex
                  @endswitch
                </td>
                <td>{{ optional($p->created_at)->format('d/m/Y H:i') }}</td>
                <td class="text-right">
                  <div class="join">
                    <button class="btn btn-circle btn-text btn-sm" title="Sửa">
                      <span class="icon-[tabler--pencil] size-5"></span>
                    </button>
                    <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-circle btn-text btn-sm" onclick="return confirm('Xóa sản phẩm này?')" title="Xóa">
                        <span class="icon-[tabler--trash] size-5"></span>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center text-base-content/60">Không có dữ liệu</td>
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
      sản phẩm
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
