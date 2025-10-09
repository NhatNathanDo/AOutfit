@extends('admin.layouts.app')

@section('title', 'Quản lý Nhãn hàng')

@section('content')
<div class="flex items-center justify-between gap-3 mb-4">
  <h2 class="text-xl font-semibold">Nhãn hàng</h2>
  <a href="{{ route('admin.brands.create') }}" class="btn btn-sm btn-success">+ Thêm</a>
</div>

<div id="datatable-brands" class="bg-base-100 flex flex-col rounded-md shadow-base-300/20 shadow-sm" data-datatable='{"pageLength":10,"pagingOptions":{"pageBtnClasses":"btn btn-text btn-circle btn-sm"},"selecting":true,"ordering":false,"rowSelectingOptions":{"selectAllSelector":"#brands-select-all","individualSelector":".brands-select-row"}}'>
  <div class="border-base-content/25 flex items-center border-b px-5 py-3 gap-3">
    <div class="input input-sm max-w-60">
      <span class="icon-[tabler--search] text-base-content/80 my-auto me-3 size-4 shrink-0"></span>
      <input type="search" class="grow" placeholder="Tìm kiếm..." data-datatable-search />
    </div>
  </div>
  <div class="overflow-x-auto">
    <div class="inline-block min-w-full align-middle">
      <div class="overflow-hidden">
        <table class="table min-w-full">
          <thead>
            <tr>
              <th class="w-3.5 pe-0 --exclude-from-ordering">
                <div class="flex h-5 items-center">
                  <input id="brands-select-all" type="checkbox" class="checkbox checkbox-sm" />
                </div>
              </th>
              <th>Tên</th>
              <th>Quốc gia</th>
              <th class="text-right --exclude-from-ordering">Hành động</th>
            </tr>
          </thead>
          <tbody>
            @forelse($brands as $i => $b)
            <tr>
              <td class="w-3.5 pe-0"><input type="checkbox" class="checkbox checkbox-sm brands-select-row" /></td>
              <td>{{ $b->name }}</td>
              <td>{{ $b->country }}</td>
              <td class="text-right">
                <a href="{{ route('admin.brands.edit', $b->id) }}" class="btn btn-circle btn-text btn-sm" title="Sửa">
                  <span class="icon-[tabler--pencil] size-5"></span>
                </a>
                <form action="{{ route('admin.brands.destroy', $b->id) }}" method="POST" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-circle btn-text btn-sm" onclick="return confirm('Xóa nhãn hàng này?')" title="Xóa">
                    <span class="icon-[tabler--trash] size-5"></span>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-base-content/60">Không có dữ liệu</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
