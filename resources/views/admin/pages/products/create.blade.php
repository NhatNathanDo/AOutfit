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

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="grid grid-cols-1 lg:grid-cols-10 gap-6">
    <!-- Left: Images (3/10) -->
    <div class="lg:col-span-3">
      <div class="card bg-base-100 shadow">
        <div class="card-body">
          <h3 class="card-title text-base">Ảnh sản phẩm</h3>
          <div id="drop-area-create" class="border-2 border-dashed border-base-300 rounded-lg p-4 text-center cursor-pointer hover:bg-base-200/40">
            <input id="images-create" type="file" name="images[]" class="hidden" accept="image/*" multiple />
            <div class="flex flex-col items-center gap-2">
              <span class="text-sm">Kéo thả ảnh vào đây hoặc</span>
              <button type="button" id="select-btn-create" class="btn btn-outline btn-sm">Chọn ảnh</button>
              <p class="text-xs text-base-content/60">Ảnh đầu tiên sẽ là ảnh chính sau khi lưu.</p>
            </div>
          </div>
          <div class="mt-4">
            <div class="text-sm font-medium mb-2">Xem trước</div>
            <div id="preview-create" class="grid grid-cols-2 gap-3"></div>
            <input type="hidden" name="primary_new_index" id="primary_new_index_create" />
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
              <input type="text" name="name" class="input input-bordered" value="{{ old('name') }}" required />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Slug (tùy chọn)</span></label>
              <input type="text" name="slug" class="input input-bordered" value="{{ old('slug') }}" />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Danh mục</span></label>
              <select name="category_id" class="select select-bordered" required>
                <option value="">-- Chọn danh mục --</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" @selected(old('category_id')===$cat->id)>{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Nhãn hàng</span></label>
              <select name="brand_id" class="select select-bordered" required>
                <option value="">-- Chọn nhãn hàng --</option>
                @foreach($brands as $brand)
                  <option value="{{ $brand->id }}" @selected(old('brand_id')===$brand->id)>{{ $brand->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-control md:col-span-2">
              <div class="flex items-center justify-between">
                <label class="label"><span class="label-text">Mô tả</span></label>
                <button type="button" id="ai-generate-create" class="btn btn-sm">Viết mô tả bằng AI</button>
              </div>
              <textarea name="description" id="description-create" rows="6" class="textarea textarea-bordered">{{ old('description') }}</textarea>
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Giá (VND)</span></label>
              <input type="number" step="0.01" name="price" class="input input-bordered" value="{{ old('price') }}" required />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Kho</span></label>
              <input type="number" name="stock" class="input input-bordered" value="{{ old('stock', 0) }}" required />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Giới tính</span></label>
              <select name="gender" class="select select-bordered" required>
                <option value="">-- Chọn --</option>
                <option value="male" @selected(old('gender')==='male')>Nam</option>
                <option value="female" @selected(old('gender')==='female')>Nữ</option>
                <option value="unisex" @selected(old('gender')==='unisex')>Unisex</option>
              </select>
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Màu sắc</span></label>
              <input type="text" name="color" class="input input-bordered" value="{{ old('color') }}" />
            </div>
            <div class="form-control">
              <label class="label"><span class="label-text">Chất liệu</span></label>
              <input type="text" name="material" class="input input-bordered" value="{{ old('material') }}" />
            </div>
          </div>

          <div class="flex justify-end gap-2 mt-4">
            <a href="{{ route('admin.products.page') }}" class="btn">Hủy</a>
            <button type="submit" class="btn btn-primary">Lưu</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  (function(){
    const input = document.getElementById('images-create');
    const btn = document.getElementById('select-btn-create');
    const drop = document.getElementById('drop-area-create');
    const preview = document.getElementById('preview-create');
    const aiBtn = document.getElementById('ai-generate-create');
    const descEl = document.getElementById('description-create');

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
          document.getElementById('primary_new_index_create').value = String(idx);
        });
      });
      // Default primary: first image if any
      const firstRadio = preview.querySelector('input[type="radio"][name="primary_new_index_display"]');
      if (firstRadio) { firstRadio.checked = true; document.getElementById('primary_new_index_create').value = '0'; }
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
      input.files = dt.files; // assign files
      render(dt.files);
    });

    // AI generate description
    aiBtn?.addEventListener('click', async () => {
      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
      const name = document.querySelector('input[name="name"]').value;
      if (!name) { alert('Vui lòng nhập Tên sản phẩm'); return; }
      const payload = {
        name,
        price: document.querySelector('input[name="price"]').value || null,
        category: document.querySelector('select[name="category_id"]')?.selectedOptions?.[0]?.text || null,
        brand: document.querySelector('select[name="brand_id"]')?.selectedOptions?.[0]?.text || null,
        gender: document.querySelector('select[name="gender"]').value || null,
        style: document.querySelector('input[name="style"]')?.value || null,
        color: document.querySelector('input[name="color"]').value || null,
        material: document.querySelector('input[name="material"]').value || null,
        images: [], // No URLs yet for local files
      };
      aiBtn.disabled = true; aiBtn.classList.add('btn-disabled'); aiBtn.textContent = 'Đang tạo...';
      try {
        const res = await fetch('{{ route('admin.products.ai.describe') }}', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
          body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (res.ok && data.description) {
          descEl.value = data.description;
        } else {
          alert(data.message || 'Không thể tạo mô tả.');
        }
      } catch(_) {
        alert('Có lỗi khi gọi AI.');
      } finally {
        aiBtn.disabled = false; aiBtn.classList.remove('btn-disabled'); aiBtn.textContent = 'Viết mô tả bằng AI';
      }
    });
  })();
</script>
@endsection