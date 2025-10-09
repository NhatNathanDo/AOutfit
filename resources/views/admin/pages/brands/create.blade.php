@extends('admin.layouts.app')

@section('title', 'Thêm nhãn hàng')

@section('content')
<div class="flex items-center justify-between mb-4">
  <h2 class="text-xl font-semibold">Thêm nhãn hàng</h2>
  <a href="{{ route('admin.brands.page') }}" class="btn btn-sm">← Danh sách</a>
</div>

@if ($errors->any())
  <div class="alert alert-error mb-4">
    <div>
      <span class="font-semibold">Có lỗi xảy ra:</span>
      <ul class="list-disc ms-5">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif

<form action="{{ route('admin.brands.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
  @csrf
  <div class="form-control md:col-span-1">
    <label class="label"><span class="label-text">Tên nhãn hàng</span></label>
    <input type="text" name="name" class="input input-bordered" value="{{ old('name') }}" required />
  </div>
  <div class="form-control md:col-span-1">
    <label class="label"><span class="label-text">Quốc gia</span></label>
    <input type="text" name="country" class="input input-bordered" value="{{ old('country') }}" />
  </div>
  <div class="md:col-span-2 flex justify-end gap-2 mt-2">
    <a href="{{ route('admin.brands.page') }}" class="btn">Hủy</a>
    <button type="submit" class="btn btn-primary">Lưu</button>
  </div>
</form>
@endsection
