@extends('admin.layouts.app')

@section('title', 'Sửa sản phẩm')

@section('content')
<div class="flex items-center justify-between mb-4">
  <h2 class="text-xl font-semibold">Sửa sản phẩm</h2>
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

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  <div class="grid grid-cols-1 lg:grid-cols-10 gap-6">
    <!-- Left: Images (3/10) -->
    <div class="lg:col-span-3">
      <div class="card bg-base-100 shadow">
        <div class="card-body">
          <h3 class="card-title text-base">Ảnh sản phẩm</h3>
          @if($product->images && $product->images->count())
            <div class="grid grid-cols-2 gap-3 mb-3">
              @foreach($product->images as $img)
                <div class="border rounded p-2 flex flex-col items-center gap-2" data-img-card="{{ $img->id }}">
                  <img src="{{ $img->url }}" alt="product image" class="h-28 w-full object-cover rounded" />
                  <div class="flex items-center justify-between gap-3 w-full">
                    <label class="flex items-center gap-2">
                      <input type="radio" name="primary_image_id" value="{{ $img->id }}" class="radio"
                        @checked(old('primary_image_id', optional($product->primaryImage)->id) === $img->id) />
                      <span class="text-sm">Ảnh chính</span>
                    </label>
                    <button type="button" class="btn btn-ghost btn-xs text-error delete-image-btn"
                      data-delete-url="{{ route('admin.products.images.destroy', [$product->id, $img->id]) }}"
                      data-image-id="{{ $img->id }}">Xóa</button>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <p class="text-sm text-base-content/60">Chưa có ảnh nào.</p>
          @endif

          <div id="drop-area-edit" class="border-2 border-dashed border-base-300 rounded-lg p-4 text-center cursor-pointer hover:bg-base-200/40">
            <input id="images-edit" type="file" name="images[]" class="hidden" accept="image/*" multiple />
            <div class="flex flex-col items-center gap-2">
              <span class="text-sm">Kéo thả ảnh vào đây hoặc</span>
              <button type="button" id="select-btn-edit" class="btn btn-outline btn-sm">Chọn ảnh</button>
              <p class="text-xs text-base-content/60">Sau khi tải lên, chọn ảnh chính ở danh sách trên.</p>
            </div>
          </div>
          <div class="mt-4">
            <div class="text-sm font-medium mb-2">Xem trước ảnh mới</div>
            <div id="preview-edit" class="grid grid-cols-2 gap-3"></div>
            <input type="hidden" name="primary_new_index" id="primary_new_index_edit" />
          </div>
        </div>
      </div>
    </div>

    <!-- Right: Form (7/10) -->
    <div class="lg:col-span-7">
      <div class="card bg-base-100 shadow">
        <div class="card-body">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-control">
              <label class="label"><span class="label-text">Tên sản phẩm</span></label>
              <input type="text" name="name" class="input input-bordered" value="{{ old('name', $product->name) }}" required />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Slug (tùy chọn)</span></label>
              <input type="text" name="slug" class="input input-bordered" value="{{ old('slug', $product->slug) }}" />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Danh mục</span></label>
              <select name="category_id" class="select select-bordered" required>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id)===$cat->id)>{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Nhãn hàng</span></label>
              <select name="brand_id" class="select select-bordered" required>
                @foreach($brands as $brand)
                  <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id)===$brand->id)>{{ $brand->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-control md:col-span-2">
              <label class="label"><span class="label-text">Mô tả</span></label>
              <textarea name="description" rows="4" class="textarea textarea-bordered">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Giá (VND)</span></label>
              <input type="number" step="0.01" name="price" class="input input-bordered" value="{{ old('price', $product->price) }}" required />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Kho</span></label>
              <input type="number" name="stock" class="input input-bordered" value="{{ old('stock', $product->stock) }}" required />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Giới tính</span></label>
              <select name="gender" class="select select-bordered" required>
                <option value="male" @selected(old('gender', $product->gender)==='male')>Nam</option>
                <option value="female" @selected(old('gender', $product->gender)==='female')>Nữ</option>
                <option value="unisex" @selected(old('gender', $product->gender)==='unisex')>Unisex</option>
              </select>
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Màu sắc</span></label>
              <input type="text" name="color" class="input input-bordered" value="{{ old('color', $product->color) }}" />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Chất liệu</span></label>
              <input type="text" name="material" class="input input-bordered" value="{{ old('material', $product->material) }}" />
            </div>
          </div>

          <div class="flex justify-end gap-2 mt-4">
            <a href="{{ route('admin.products.page') }}" class="btn">Hủy</a>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  (function(){
    const input = document.getElementById('images-edit');
    const btn = document.getElementById('select-btn-edit');
    const drop = document.getElementById('drop-area-edit');
    const preview = document.getElementById('preview-edit');

    function render(files){
      preview.innerHTML = '';
      Array.from(files).forEach((file, idx) => {
        if(!file.type.startsWith('image/')) return;
        const url = URL.createObjectURL(file);
        const wrap = document.createElement('div');
        wrap.className = 'relative group';
        const img = document.createElement('img');
        img.src = url;
        img.className = 'w-full h-28 object-cover rounded border';
        const radioWrap = document.createElement('label');
        radioWrap.className = 'absolute top-2 left-2 bg-base-100/80 rounded px-2 py-1 text-xs flex items-center gap-1 cursor-pointer shadow';
        const radio = document.createElement('input');
        radio.type = 'radio';
        radio.name = 'primary_new_index_display';
        radio.value = String(idx);
        radio.className = 'radio radio-xs';
        const span = document.createElement('span');
        span.textContent = 'Chính';
        radioWrap.appendChild(radio);
        radioWrap.appendChild(span);
        wrap.appendChild(img);
        wrap.appendChild(radioWrap);
        preview.appendChild(wrap);

        radio.addEventListener('change', () => {
          document.getElementById('primary_new_index_edit').value = String(idx);
        });
      });
      const firstRadio = preview.querySelector('input[type="radio"][name="primary_new_index_display"]');
      if (firstRadio) { firstRadio.checked = true; document.getElementById('primary_new_index_edit').value = '0'; }
    }

    btn?.addEventListener('click', () => input.click());
    drop?.addEventListener('click', () => input.click());
    input?.addEventListener('change', e => render(e.target.files));

    // Drag & drop handlers
    ['dragenter','dragover'].forEach(evt => drop.addEventListener(evt, e => {
      e.preventDefault();
      e.stopPropagation();
      drop.classList.add('bg-base-200/60');
    }));
    ;['dragleave','dragend','drop'].forEach(evt => drop.addEventListener(evt, e => {
      e.preventDefault();
      e.stopPropagation();
      drop.classList.remove('bg-base-200/60');
    }));
    drop.addEventListener('drop', e => {
      const dt = e.dataTransfer;
      if (!dt || !dt.files || !dt.files.length) return;
      input.files = dt.files;
      render(dt.files);
    });
  })();

  // Image delete (prevent main form submit)
  (function(){
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    document.addEventListener('click', async (e) => {
      const btn = e.target.closest('.delete-image-btn');
      if (!btn) return;
      e.preventDefault();
      if (!confirm('Xóa ảnh này?')) return;
      const url = btn.getAttribute('data-delete-url');
      const card = btn.closest('[data-img-card]');
      try {
        const res = await fetch(url, {
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': token, 'X-HTTP-Method-Override': 'DELETE' },
        });
        if (res.ok) {
          card?.remove();
        } else {
          alert('Xóa ảnh thất bại');
        }
      } catch (_) {
        alert('Có lỗi khi xóa ảnh');
      }
    });
  })();
</script>
@endsection
