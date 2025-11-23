@php
    $accent = '#c7b293';
@endphp

@extends('customer.layouts.app')

@section('content')

  <!-- Sticky header: breadcrumb + search -->
  <div class="sticky top-0 z-30 bg-black/90 backdrop-blur border-b border-white/10">
    <div class="mx-auto max-w-7xl px-4 py-3 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
      <nav class="breadcrumbs text-sm text-white/70">
        <ul class="flex items-center gap-2">
          <li><a href="/" class="hover:underline text-white">Home</a></li>
          @if(!empty($breadcrumbs))
            @foreach($breadcrumbs as $bc)
              <li class="before:content-['/'] before:px-2 text-white/80">{{ $bc->name }}</li>
            @endforeach
          @else
            <li class="before:content-['/'] before:px-2 text-white/80">Danh mục</li>
          @endif
        </ul>
      </nav>

      <div class="relative w-full md:w-[520px]">
        <form action="{{ route('shop.index') }}" method="get" class="w-full">
          <div class="relative flex items-center">
            <span class="icon-[tabler--search] absolute left-4 top-1/2 -translate-y-1/2 size-5 text-white/60"></span>
            <input id="plp-search" type="search" name="q" value="{{ e($q) }}" 
                   class="input input-bordered w-full rounded-full pl-12 pr-14 h-12 bg-neutral-900/80 text-white placeholder-white/50 border-white/25 focus:outline-none focus:ring-2 focus:ring-[{{ $accent }}] focus:border-transparent"
                   placeholder="Tìm kiếm sản phẩm..." autocomplete="off" />
            @if($q)
              <a href="{{ route('shop.index') }}" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/50 hover:text-white/80 text-xs">Xóa</a>
            @endif
          </div>
        </form>
        <div id="search-suggest" class="absolute mt-2 w-full hidden rounded-2xl border border-white/15 bg-neutral-950/95 backdrop-blur shadow-xl overflow-hidden"></div>
      </div>
    </div>
  </div>

  <div class="mx-auto max-w-7xl px-4 py-6">
    <div class="flex items-start gap-6">
      <!-- Sidebar / Filters (extracted) -->
      @include('customer.products.partials.filters')

      <!-- Mobile filter button -->
      <div class="lg:hidden w-full">
        <div x-data="{open:false}" class="mb-4">
          <button @click="open=true" class="btn btn-neutral btn-soft w-full">Bộ lọc & Sắp xếp</button>
          <div x-show="open" x-transition class="fixed inset-0 z-40">
            <div class="absolute inset-0 bg-black/60" @click="open=false"></div>
            <div class="absolute right-0 top-0 h-full w-[86%] max-w-sm bg-base-100 p-5 overflow-y-auto">
              <div class="flex items-center justify-between mb-3">
                <h3 class="text-base font-semibold">Bộ lọc</h3>
                <button class="btn btn-ghost btn-sm" @click="open=false"><span class="icon-[tabler--x]"></span></button>
              </div>
              <form action="{{ route('shop.index') }}" method="get" class="space-y-6">
                <input type="hidden" name="q" value="{{ e(request('q','')) }}">
                <!-- Repeat simplified filters for mobile -->
                <div class="space-y-3">
                  <h4 class="font-medium">Khoảng giá</h4>
                  <div class="flex items-center gap-3">
                    <input type="number" name="min_price" value="{{ e(request('min_price')) }}" class="input input-sm w-1/2" placeholder="Min" min="0">
                    <input type="number" name="max_price" value="{{ e(request('max_price')) }}" class="input input-sm w-1/2" placeholder="Max" min="0">
                  </div>
                </div>
                <div class="space-y-3">
                  <h4 class="font-medium">Danh mục</h4>
                  <div class="max-h-56 overflow-auto pr-1 space-y-2">
                    @foreach($allCategories as $cat)
                      <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="category_id[]" value="{{ $cat->id }}" {{ in_array($cat->id, (array)request('category_id', [])) ? 'checked' : '' }} class="checkbox checkbox-sm" />
                        <span>{{ $cat->name }}</span>
                      </label>
                    @endforeach
                  </div>
                </div>
                <div class="space-y-3">
                  <h4 class="font-medium">Thương hiệu</h4>
                  <div class="max-h-56 overflow-auto pr-1 space-y-2">
                    @foreach($brands as $brand)
                      <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="brand_id[]" value="{{ $brand->id }}" {{ in_array($brand->id, (array)request('brand_id', [])) ? 'checked' : '' }} class="checkbox checkbox-sm" />
                        <span>{{ $brand->name }}</span>
                      </label>
                    @endforeach
                  </div>
                </div>
                <div class="space-y-3">
                  <h4 class="font-medium">Màu sắc</h4>
                  <div class="flex flex-wrap gap-2">
                    @foreach($colors as $color)
                      @php $checked = in_array($color, (array)request('color', [])); @endphp
                      <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="color[]" value="{{ $color }}" {{ $checked ? 'checked' : '' }} class="checkbox checkbox-sm" />
                        <span class="inline-flex items-center gap-2 text-sm">
                          <span class="size-4 rounded-full border" style="background-color: {{ $color }}"></span>
                          <span>{{ $color }}</span>
                        </span>
                      </label>
                    @endforeach
                  </div>
                </div>
                <div class="space-y-3">
                  <h4 class="font-medium">Tình trạng</h4>
                  <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} class="checkbox checkbox-sm" />
                    <span>Còn hàng</span>
                  </label>
                </div>
                <button class="btn w-full" style="background-color: {{ $accent }}; color: #111;">Áp dụng</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <section class="flex-1 min-w-0">
        <!-- Active filter tags + sort + per-page -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
          <div class="flex flex-wrap items-center gap-2">
            @php
              $tags = [];
              if(request('min_price') || request('max_price')) $tags[] = 'Giá: '.(request('min_price') ?: '0').'–'.(request('max_price') ?: '∞');
              foreach((array)request('category_id', []) as $cid){ $c=$allCategories->firstWhere('id',$cid); if($c) $tags[] = 'Danh mục: '.$c->name; }
              foreach((array)request('brand_id', []) as $bid){ $b=$brands->firstWhere('id',$bid); if($b) $tags[] = 'Thương hiệu: '.$b->name; }
              foreach((array)request('color', []) as $cl){ $tags[] = 'Màu: '.$cl; }
              if(request('in_stock')) $tags[] = 'Còn hàng';
            @endphp
            @foreach($tags as $t)
              <span class="badge badge-ghost">{{ $t }}</span>
            @endforeach
            @if(count($tags))
              <a href="{{ route('shop.index') }}" class="text-sm text-white/60 hover:text-white/90">Xóa tất cả</a>
            @endif
          </div>

          <form action="{{ route('shop.index') }}" method="get" class="flex items-center gap-2">
            @foreach(request()->except(['sort','per_page','page']) as $k=>$v)
              @if(is_array($v))
                @foreach($v as $vv)
                  <input type="hidden" name="{{ $k }}[]" value="{{ e($vv) }}">
                @endforeach
              @else
                <input type="hidden" name="{{ $k }}" value="{{ e($v) }}">
              @endif
            @endforeach
            <select name="sort" class="select select-sm rounded-full bg-neutral-900/80 text-white border-white/20">
              <option value="newest" {{ $sortKey==='newest' ? 'selected' : '' }}>Mới nhất</option>
              <option value="price_asc" {{ $sortKey==='price_asc' ? 'selected' : '' }}>Giá tăng</option>
              <option value="price_desc" {{ $sortKey==='price_desc' ? 'selected' : '' }}>Giá giảm</option>
              <option value="best" {{ $sortKey==='best' ? 'selected' : '' }}>Bán chạy nhất</option>
              <option value="rating" disabled>Đánh giá cao nhất</option>
            </select>
            <select name="per_page" class="select select-sm rounded-full bg-neutral-900/80 text-white border-white/20">
              @foreach([20,40,60] as $pp)
                <option value="{{ $pp }}" {{ $perPage==$pp ? 'selected' : '' }}>Hiển thị {{ $pp }}</option>
              @endforeach
            </select>
            <button class="btn btn-sm rounded-full px-5" style="background-color: {{ $accent }}; color: #111;">Áp dụng</button>
          </form>
        </div>

        <!-- Products grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
          @forelse($products as $product)
            @php
              $primary = $product->primaryImage?->url ?? optional($product->images->first())->url;
              $hover   = optional($product->images->skip(1)->first())->url;
              $catName = $product->category->name ?? 'Product';
              $style   = $product->style ?: 'Standard';
            @endphp
            <div class="group flex flex-col gap-4 p-4 rounded-[2.5rem] border border-dashed border-white/10 hover:border-white/30 transition-colors">
              <!-- Image Area -->
              <a href="{{ route('shop.show', $product->slug) }}" class="relative aspect-[4/5] w-full overflow-hidden rounded-[2rem] bg-neutral-800 ring-1 ring-white/5">
                @if($primary)
                  <img src="{{ $primary }}" alt="{{ $product->name }}" class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" />
                @else
                  <div class="absolute inset-0 grid place-items-center text-white/20"><span class="icon-[tabler--photo] size-12"></span></div>
                @endif
                
                @if($hover)
                  <img src="{{ $hover }}" alt="{{ $product->name }}" class="absolute inset-0 h-full w-full object-cover opacity-0 transition-opacity duration-500 group-hover:opacity-100 group-hover:scale-105" loading="lazy" />
                @endif
              </a>

              <!-- Action Row -->
              <div class="flex items-center justify-between px-1">
                <span class="rounded-full bg-neutral-900 px-4 py-1.5 text-xs font-medium text-neutral-400 border border-white/10">{{ $catName }}</span>
                <a href="{{ route('shop.show', $product->slug) }}" class="flex items-center gap-1 rounded-full border border-white/20 px-4 py-1.5 text-xs font-medium text-white transition hover:bg-white hover:text-black hover:border-white">
                  Shop Now <span class="icon-[tabler--arrow-up-right] size-3"></span>
                </a>
              </div>

              <!-- Info Row -->
              <div class="px-1">
                <h3 class="text-lg font-bold text-white tracking-tight">
                  <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                </h3>
                <div class="mt-1.5 flex items-center gap-4 text-sm text-neutral-500 font-mono">
                  <span>Fit <span class="text-neutral-300">· {{ $style }}</span></span>
                  <span>Price <span class="text-neutral-300">· {{ number_format($product->price, 0, ',', '.') }}₫</span></span>
                </div>
              </div>
            </div>
          @empty
            <div class="col-span-full text-center text-white/70 py-16">Không có sản phẩm phù hợp</div>
          @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
          {{ $products->appends(request()->query())->links() }}
        </div>
      </section>
    </div>
  </div>

  <!-- Quick View Modal -->
  <div id="quick-modal" class="modal hidden">
    <div class="modal-box max-w-3xl">
      <div class="flex items-center justify-between mb-3">
        <h3 class="font-semibold">Xem nhanh</h3>
        <button class="btn btn-ghost btn-sm" data-close-quick><span class="icon-[tabler--x]"></span></button>
      </div>
      <div id="quick-content" class="min-h-40">Đang tải…</div>
    </div>
    <div class="modal-backdrop" data-close-quick></div>
  </div>

  <script>
    // Debounced search suggest
    (function(){
      const input = document.getElementById('plp-search');
      const box = document.getElementById('search-suggest');
      let t;
      const render = (data)=>{
        if(!data || (!data.products.length && !data.categories.length)) { box.classList.add('hidden'); box.innerHTML=''; return; }
        let html = '<div class="p-2">';
        if(data.categories.length){
          html += '<div class="px-2 py-1 text-xs font-semibold text-neutral-500">Danh mục</div>';
          data.categories.forEach(c=>{ html += `<a class="flex items-center gap-2 px-3 py-2 hover:bg-neutral/10" href="${c.url}"><span class="icon-[tabler--folder]"></span><span>${c.name}</span></a>`; });
        }
        if(data.products.length){
          html += '<div class="px-2 py-1 text-xs font-semibold text-neutral-500 mt-2">Sản phẩm</div>';
          data.products.forEach(p=>{
            html += `<a class="flex items-center gap-3 px-3 py-2 hover:bg-neutral/10" href="${p.url}">`+
                    (p.image ? `<img src="${p.image}" class="size-8 rounded object-cover"/>` : '<span class="icon-[tabler--photo] size-5"></span>')+
                    `<span class="flex-1">${p.name}</span>`+
                    `<span class="text-sm font-medium">${new Intl.NumberFormat('vi-VN').format(p.price)}₫</span>`+
                    `</a>`;
          });
        }
        html += '</div>';
        box.innerHTML = html; box.classList.remove('hidden');
      };
      const fetchSuggest = (q)=>{
        if(!q || q.trim()===''){ box.classList.add('hidden'); return; }
        fetch(`{{ route('shop.suggest') }}?q=`+encodeURIComponent(q))
          .then(r=>r.json()).then(render).catch(()=>{ box.classList.add('hidden'); });
      };
      input?.addEventListener('input', (e)=>{
        clearTimeout(t);
        t = setTimeout(()=>fetchSuggest(e.target.value), 200);
      });
      document.addEventListener('click', (e)=>{
        if(!box.contains(e.target) && e.target!==input){ box.classList.add('hidden'); }
      });
    })();

    // Quick modal basic toggling (placeholder)
    (function(){
      const modal = document.getElementById('quick-modal');
      document.addEventListener('click', (e)=>{
        const btn = e.target.closest('[data-quick]');
        const close = e.target.closest('[data-close-quick]');
        if(btn){ modal.classList.remove('hidden'); document.getElementById('quick-content').innerHTML = 'Đang phát triển'; }
        if(close){ modal.classList.add('hidden'); }
      });
    })();

    // Add to cart buttons
    (function(){
      const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
      async function add(pid){
        try {
          const r = await fetch('/cart/items', {
            method:'POST',
            headers:{
              'X-Requested-With':'XMLHttpRequest',
              'Accept':'application/json',
              'Content-Type':'application/x-www-form-urlencoded',
              'X-CSRF-TOKEN': csrf || ''
            },
            credentials:'same-origin',
            body:new URLSearchParams({product_id:pid, quantity:1})
          });
          if(r.status === 401){
            console.warn('Cần đăng nhập để thêm vào giỏ');
            toast('Vui lòng đăng nhập');
            return;
          }
          if(!r.ok){
            console.error(await r.text());
            toast('Lỗi thêm sản phẩm');
            return;
          }
          const cart = await r.json();
          const badge = document.getElementById('cart-count');
          if(badge){ badge.textContent = cart.count || ''; badge.classList.toggle('hidden', !cart.count); }
          toast('Đã thêm vào giỏ');
        } catch(e){
          console.error(e);
          toast('Lỗi mạng');
        }
      }
      function toast(msg){
        let box = document.getElementById('toast-box');
        if(!box){
          box = document.createElement('div');
          box.id='toast-box';
          box.className='fixed bottom-4 right-4 space-y-2 z-50';
          document.body.appendChild(box);
        }
        const item = document.createElement('div');
        item.className='px-4 py-2 rounded-xl bg-white/90 text-black text-sm shadow';
        item.textContent = msg;
        box.appendChild(item);
        setTimeout(()=>{item.classList.add('opacity-0','scale-95','transition'); setTimeout(()=>item.remove(),400);},1800);
      }
      document.addEventListener('click', e=>{
        const addBtn = e.target.closest('[data-add-cart]');
        if(addBtn){ add(addBtn.getAttribute('data-add-cart')); }
      });
    })();
  </script>
@endsection
