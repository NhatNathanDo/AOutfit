@extends('admin.layouts.app')

@section('title', 'Thêm sản phẩm')

@section('content')
<div class="flex items-center justify-between mb-4">
  <h2 class="text-xl font-semibold">Thêm sản phẩm</h2>
  <a href="{{ route('admin.products.page') }}" class="btn btn-sm">← Danh sách</a>
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

<form action="{{ route('admin.products.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
  @csrf
  <div class="form-control">
    <label class="label">
      <span class="label-text">Tên sản phẩm</span>
    </label>
    <input type="text" name="name" class="input input-bordered" value="{{ old('name') }}" required />
  </div>

  <div class="form-control">
    <label class="label">
      <span class="label-text">Slug (tùy chọn)</span>
    </label>
    <input type="text" name="slug" class="input input-bordered" value="{{ old('slug') }}" />
  </div>

  <div class="form-control">
    <label class="label">
      <span class="label-text">Danh mục</span>
    </label>
    <select name="category_id" class="select select-bordered" required>
      <option value="">-- Chọn danh mục --</option>
      @foreach($categories as $cat)
        <option value="{{ $cat->id }}" @selected(old('category_id')===$cat->id)>{{ $cat->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="form-control">
    <label class="label">
      <span class="label-text">Nhãn hàng</span>
    </label>
    <select name="brand_id" class="select select-bordered" required>
      <option value="">-- Chọn nhãn hàng --</option>
      @foreach($brands as $brand)
        <option value="{{ $brand->id }}" @selected(old('brand_id')===$brand->id)>{{ $brand->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="form-control md:col-span-2">
    <label class="label">
      <span class="label-text">Mô tả</span>
    </label>
    <textarea name="description" rows="4" class="textarea textarea-bordered">{{ old('description') }}</textarea>
  </div>

  <div class="form-control">
    <label class="label">
      <span class="label-text">Giá (VND)</span>
    </label>
    <input type="number" step="0.01" name="price" class="input input-bordered" value="{{ old('price') }}" required />
  </div>

  <div class="form-control">
    <label class="label">
      <span class="label-text">Kho</span>
    </label>
    <input type="number" name="stock" class="input input-bordered" value="{{ old('stock', 0) }}" required />
  </div>

  <div class="form-control">
    <label class="label">
      <span class="label-text">Giới tính</span>
    </label>
    <select name="gender" class="select select-bordered" required>
      <option value="">-- Chọn --</option>
      <option value="male" @selected(old('gender')==='male')>Nam</option>
      <option value="female" @selected(old('gender')==='female')>Nữ</option>
      <option value="unisex" @selected(old('gender')==='unisex')>Unisex</option>
    </select>
  </div>

  <div class="form-control">
    <label class="label">
      <span class="label-text">Màu sắc</span>
    </label>
    <input type="text" name="color" class="input input-bordered" value="{{ old('color') }}" />
  </div>

  <div class="form-control">
    <label class="label">
      <span class="label-text">Chất liệu</span>
    </label>
    <input type="text" name="material" class="input input-bordered" value="{{ old('material') }}" />
  </div>

  <div class="form-control md:col-span-2">
    <label class="label">
      <span class="label-text">Ảnh (URL)</span>
    </label>
    <input type="url" name="image_url" class="input input-bordered" value="{{ old('image_url') }}" />
  </div>

  <div class="md:col-span-2 flex justify-end gap-2 mt-2">
    <a href="{{ route('admin.products.page') }}" class="btn">Hủy</a>
    <button type="submit" class="btn btn-primary">Lưu</button>
  </div>
</form>
@endsection