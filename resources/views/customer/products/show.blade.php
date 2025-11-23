@php($accent = '#c7b293')
@extends('customer.layouts.app')
@section('content')
  <div class="mx-auto max-w-7xl px-4 py-6">
    <!-- Title row -->
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
      <div>
        <h1 class="text-2xl md:text-3xl font-semibold text-white">{{ $product->name }}</h1>
        <div class="mt-1 text-white/70 text-sm">{{ $product->style ? $product->style.', ' : '' }}{{ $product->material ?: '' }}</div>
      </div>
      <div class="flex items-center gap-2">
        <a href="{{ route('shop.index') }}" class="btn btn-sm rounded-full bg-white/10 text-white hover:bg-white/15">Back to shop</a>
        <button class="btn btn-sm rounded-full" style="background-color: {{ $accent }}; color:#111;" data-add-cart="{{ $product->id }}">Add to Cart</button>
        <a href="#buy" class="btn btn-sm rounded-full btn-outline border-white/20 text-white hover:bg-white/10">Buy Now</a>
      </div>
    </div>

    <!-- Breadcrumbs -->
    <nav class="mt-2 text-sm text-white/70">
      <a href="/" class="hover:underline text-white">Home</a>
      @foreach($breadcrumbs as $bc)
        <span class="px-2">/</span><span>{{ $bc->name }}</span>
      @endforeach
      <span class="px-2">/</span><span class="text-white/90">{{ $product->name }}</span>
    </nav>

    <!-- Gallery and brief -->
    <div class="mt-5 grid grid-cols-1 md:grid-cols-12 gap-4">
      <div class="md:col-span-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          <div class="md:col-span-2 rounded-xl overflow-hidden border border-dashed border-white/20 bg-neutral-900 aspect-[4/3] relative">
            @if($main)
              <img src="{{ $main->url }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover" />
            @else
              <div class="absolute inset-0 grid place-items-center text-white/30"><span class="icon-[tabler--photo] size-10"></span></div>
            @endif
          </div>
          <div class="flex flex-col gap-3">
            <div class="rounded-xl overflow-hidden border border-dashed border-white/20 bg-neutral-900 aspect-[4/3] relative">
              @if($thumb1)
                <img src="{{ $thumb1->url }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover" />
              @endif
            </div>
            <div class="rounded-xl overflow-hidden border border-dashed border-white/20 bg-neutral-900 aspect-[4/3] relative">
              @if($thumb2)
                <img src="{{ $thumb2->url }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover" />
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="md:col-span-4">
        <div class="rounded-2xl border border-dashed border-white/20 bg-black p-4">
          <div class="text-sm text-white/60">Price</div>
          <div class="mt-1 text-2xl font-semibold text-white">{{ number_format($product->price, 0, ',', '.') }}₫</div>
          <div class="mt-3 text-sm text-white/70">{{ $product->description }}</div>

          <div class="mt-4">
            <div class="text-sm text-white/60 mb-2">Available Sizes</div>
            <div class="flex items-center gap-2">
              @foreach(['S','M','L','XL'] as $s)
                <button class="btn btn-xs rounded-full bg-white/10 text-white hover:bg-white/15">{{ $s }}</button>
              @endforeach
            </div>
          </div>

          <div class="mt-4 flex items-center gap-2">
            <button class="btn rounded-full flex-1" style="background-color: {{ $accent }}; color:#111;" data-add-cart="{{ $product->id }}">Add to Cart</button>
            <button class="btn btn-outline border-white/20 rounded-full flex-1 text-white hover:bg-white/10">Add to Wishlist</button>
          </div>

          <div class="mt-6">
            <div class="text-sm text-white/60">Rating</div>
            <div class="mt-1 flex items-center gap-2">
              <span class="text-xl font-semibold text-white">4.8</span>
              <div class="flex gap-1 text-yellow-500">
                @for($i=1;$i<=5;$i++)
                  <span class="icon-[tabler--star-filled] size-4"></span>
                @endfor
              </div>
              <span class="text-xs text-white/50">(0 đánh giá)</span>
            </div>
            <div class="mt-3 space-y-2 text-xs text-white/70">
              @foreach([5,4,3,2,1] as $r)
                <div class="flex items-center gap-2">
                  <span class="w-6">{{ $r }}★</span>
                  <div class="flex-1 h-2 rounded bg-white/10"><div class="h-2 rounded" style="width: {{ 20 * (6-$r) }}%; background-color: {{ $accent }}"></div></div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Details sections -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="rounded-2xl border border-dashed border-white/20 bg-black p-4">
        <h3 class="text-white font-semibold">Materials, Care and origin</h3>
        <div class="mt-3 text-sm text-white/80">
          <p>{{ $product->material ? 'Materials: '.$product->material : 'Materials: updating…' }}</p>
          <p class="mt-2">Care: Dry clean only. Do not bleach. Low iron.</p>
          <p class="mt-2">Origin: Made in Vietnam.</p>
        </div>
        <div class="mt-4">
          <div class="text-sm text-white/60 mb-2">Fabric sample</div>
          <div class="aspect-[4/3] rounded-xl border border-dashed border-white/20 bg-neutral-900"></div>
        </div>
      </div>
      <div class="rounded-2xl border border-dashed border-white/20 bg-black p-4">
        <h3 class="text-white font-semibold">Features</h3>
        <ul class="mt-3 text-sm text-white/80 list-disc list-inside space-y-1">
          <li>Tailored silhouette for a elegant look</li>
          <li>Premium fabric with breathable comfort</li>
          <li>Versatile styling for day and night</li>
          <li>Available in multiple colors: {{ $product->color ?: '—' }}</li>
          <li>Designed by {{ optional($product->brand)->name ?: 'our studio' }}</li>
        </ul>
      </div>
    </div>

    <!-- Testimonials placeholder -->
    <div class="mt-8 rounded-2xl border border-dashed border-white/20 bg-black p-5">
      <div class="text-white font-semibold text-lg">The Styleloom Testimonial Collection.</div>
      <div class="mt-1 text-white/60 text-sm">Một vài đánh giá mẫu để tạo cảm hứng cho UI.</div>
      <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach([1,2,3] as $i)
          <div class="rounded-xl border border-white/15 bg-neutral-950 p-4 text-white/80 text-sm">
            <div class="flex items-center gap-3">
              <div class="avatar"><div class="w-8 rounded-full bg-white/10"></div></div>
              <div>
                <div class="font-medium">Khách hàng {{ $i }}</div>
                <div class="text-xs text-white/50">Đã mua {{ $product->name }}</div>
              </div>
            </div>
            <div class="mt-3">Thiết kế đẹp, chất liệu ổn. Mình sẽ quay lại mua tiếp.</div>
            <div class="mt-2 text-yellow-500 flex gap-1">
              @for($s=0;$s<5;$s++)<span class="icon-[tabler--star-filled] size-4"></span>@endfor
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  <script>
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
          if(r.status===401){ toast('Vui lòng đăng nhập'); return; }
          if(!r.ok){ console.error(await r.text()); toast('Lỗi thêm sản phẩm'); return; }
          const cart = await r.json();
          const badge = document.getElementById('cart-count');
          if(badge){ badge.textContent = cart.count || ''; badge.classList.toggle('hidden', !cart.count); }
          toast('Đã thêm vào giỏ');
        }catch(e){ console.error(e); toast('Lỗi mạng'); }
      }
      function toast(msg){
        let box = document.getElementById('toast-box');
        if(!box){ box=document.createElement('div'); box.id='toast-box'; box.className='fixed bottom-4 right-4 space-y-2 z-50'; document.body.appendChild(box); }
        const item=document.createElement('div'); item.className='px-4 py-2 rounded-xl bg-white/90 text-black text-sm shadow'; item.textContent=msg; box.appendChild(item);
        setTimeout(()=>{item.classList.add('opacity-0','scale-95','transition'); setTimeout(()=>item.remove(),400);},1800);
      }
      document.addEventListener('click', e=>{
        const btn = e.target.closest('[data-add-cart]');
        if(btn){ add(btn.getAttribute('data-add-cart')); }
      });
    })();
  </script>
@endsection
