@extends('admin.layouts.app')

@section('title', 'Quản lý Danh mục')

@section('content')
<div class="flex items-center justify-between gap-3 mb-4">
  <h2 class="text-xl font-semibold">Danh mục</h2>
  <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-success">+ Thêm</a>
</div>

<div id="datatable-categories" class="bg-base-100 flex flex-col rounded-md shadow-base-300/20 shadow-sm" data-datatable='{"pageLength":10,"pagingOptions":{"pageBtnClasses":"btn btn-text btn-circle btn-sm"},"selecting":true,"ordering":false,"rowSelectingOptions":{"selectAllSelector":"#cats-select-all","individualSelector":".cats-select-row"}}'>
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
                  <input id="cats-select-all" type="checkbox" class="checkbox checkbox-sm" />
                </div>
              </th>
              <th>Tên</th>
              <th>Slug</th>
              <th>Danh mục cha</th>
              <th class="text-right --exclude-from-ordering">Hành động</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $i => $c)
            <tr>
              <td class="w-3.5 pe-0"><input type="checkbox" class="checkbox checkbox-sm cats-select-row" /></td>
              <td>{{ $c->name }}</td>
              <td>{{ $c->slug }}</td>
              <td>{{ optional($c->category)->name }}</td>
              <td class="text-right">
                <a href="{{ route('admin.categories.edit', $c->id) }}" class="btn btn-circle btn-text btn-sm" title="Sửa">
                  <span class="icon-[tabler--pencil] size-5"></span>
                </a>
                <form action="{{ route('admin.categories.destroy', $c->id) }}" method="POST" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-circle btn-text btn-sm" onclick="return confirm('Xóa danh mục này?')" title="Xóa">
                    <span class="icon-[tabler--trash] size-5"></span>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-base-content/60">Không có dữ liệu</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
