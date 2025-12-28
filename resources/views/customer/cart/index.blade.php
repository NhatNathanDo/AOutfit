@extends('customer.layouts.app')
@section('content')
  @php($accent = '#c7b293')
  <div class="mx-auto max-w-6xl px-4 py-8 text-white">
    <h1 class="text-2xl md:text-3xl font-semibold mb-8 flex items-center gap-3">
      <span class="inline-flex items-center justify-center size-10 rounded-xl bg-white/10 text-white/80">
        <span class="icon-[tabler--shopping-cart] size-6"></span>
      </span>
      <span>Giỏ hàng của bạn</span>
    </h1>
    <div id="cart-root" data-cart='@json($cartData)'></div>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8" id="cart-layout">
      <div class="lg:col-span-8 space-y-5" id="cart-list" data-list-col></div>
      <div class="lg:col-span-4" id="cart-summary"></div>
    </div>
  </div>
  <script>
    (function(){
      const root = document.getElementById('cart-root');
      let state = JSON.parse(root.getAttribute('data-cart'));
      const listEl = document.getElementById('cart-list');
      const summaryEl = document.getElementById('cart-summary');
      const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
      const ACCENT = '#c7b293';
      function fmt(n){return new Intl.NumberFormat('vi-VN').format(n)+'₫'}
      function render(){
        if(!state.items.length){
          // Expand list to full width and hide summary
          summaryEl.classList.add('hidden');
          const listCol = document.querySelector('[data-list-col]');
          if(listCol){
            listCol.classList.remove('lg:col-span-8');
            listCol.classList.add('lg:col-span-12');
          }
          listEl.innerHTML = `
            <div class='w-full rounded-3xl border border-dashed border-white/15 bg-black/50 backdrop-blur px-8 py-16 flex flex-col items-center justify-center text-center gap-6'>
              <div class='size-20 rounded-2xl bg-white/5 flex items-center justify-center text-white/25'>
                <span class='icon-[tabler--shopping-cart-off] size-10'></span>
              </div>
              <div class='text-xl font-medium text-white/80'>Giỏ hàng đang trống</div>
              <p class='max-w-md text-sm text-white/50'>Hãy khám phá bộ sưu tập và thêm những sản phẩm bạn yêu thích. Giá và tồn kho được cập nhật theo thời gian thực.</p>
              <div class='flex flex-wrap items-center gap-3'>
                <a href='/' class='btn rounded-full font-medium' style='background-color:${ACCENT};color:#111'>Tiếp tục mua sắm</a>
                <a href='/products' class='btn btn-outline rounded-full'>Xem sản phẩm</a>
              </div>
            </div>`;
          return;
        } else {
          summaryEl.classList.remove('hidden');
          const listCol = document.querySelector('[data-list-col]');
          if(listCol){
            listCol.classList.add('lg:col-span-8');
            listCol.classList.remove('lg:col-span-12');
          }
        }
        listEl.innerHTML = state.items.map(it=>`
          <div class='group relative rounded-2xl border border-white/10 bg-black/60 backdrop-blur p-4 flex gap-4 hover:border-white/20 transition'>
            <button data-remove='${it.id}' title='Xóa' class='absolute top-3 right-3 size-8 inline-flex items-center justify-center rounded-lg bg-red-500/15 hover:bg-red-500/25 text-red-400'>
              <span class='icon-[tabler--trash] size-5'></span>
            </button>
            <div class='w-24 h-28 rounded-xl overflow-hidden bg-neutral-800 ring-1 ring-white/10 flex-shrink-0'>${it.image?`<img src='${it.image}' class='w-full h-full object-cover'/>`:'<span class="icon-[tabler--photo] size-8 text-white/30 flex items-center justify-center h-full"></span>'}</div>
            <div class='flex-1 min-w-0 flex flex-col'>
              <a href='/products/${it.slug}' class='font-medium text-sm md:text-base line-clamp-2 pr-10 hover:text-white'>${it.name}</a>
              <div class='mt-1 text-xs md:text-sm text-white/50 flex items-center gap-4'>
                <span>Giá: <span class='text-white/80'>${fmt(it.price)}</span></span>
                <span>Tồn: <span class='text-white/80'>${it.stock}</span></span>
              </div>
              <div class='mt-3 flex items-center gap-3'>
                <div class='inline-flex items-center gap-1 rounded-full bg-white/10 p-1'>
                  <button data-dec='${it.id}' class='size-8 rounded-full inline-flex items-center justify-center hover:bg-white/15 text-white/80'>
                    <span class='icon-[tabler--minus]'></span>
                  </button>
                  <input data-qty='${it.id}' type='number' min='1' max='${it.stock}' value='${it.quantity}' class='w-14 text-center bg-transparent text-sm focus:outline-none' />
                  <button data-inc='${it.id}' class='size-8 rounded-full inline-flex items-center justify-center hover:bg-white/15 text-white/80'>
                    <span class='icon-[tabler--plus]'></span>
                  </button>
                </div>
                <div class='ml-auto text-right text-sm md:text-base font-semibold tracking-tight text-white'>${fmt(it.subtotal)}</div>
              </div>
            </div>
          </div>`).join('');
        summaryEl.innerHTML = `
          <div class='sticky top-24 space-y-5'>
            <div class='rounded-2xl border border-dashed border-white/15 bg-black/70 backdrop-blur p-5'>
              <h2 class='text-lg font-semibold mb-4 flex items-center gap-2'>Tổng quan <span class='px-2 py-1 rounded-full bg-white/10 text-xs'>${state.count} sp</span></h2>
              <div class='space-y-3 text-sm'>
                <div class='flex items-center justify-between'><span>Tạm tính</span><span class='font-medium'>${fmt(state.total)}</span></div>
                <div class='flex items-center justify-between text-white/50'><span>Giảm giá</span><span>0₫</span></div>
                <div class='flex items-center justify-between text-white/50'><span>Vận chuyển</span><span>—</span></div>
                <div class='border-t border-white/10 pt-3 flex items-center justify-between text-base'><span class='font-semibold'>Tổng</span><span class='font-semibold text-white'>${fmt(state.total)}</span></div>
              </div>
              <div class='mt-5 flex flex-col gap-3'>
                <a href='/checkout' class='btn w-full rounded-full font-medium flex items-center justify-center' style='background-color:${ACCENT};color:#111'>Thanh toán</a>
                <button id='cart-clear' class='btn btn-ghost w-full rounded-full'>Xóa tất cả</button>
                <a href='/' class='btn btn-outline w-full rounded-full'>Tiếp tục mua sắm</a>
              </div>
            </div>
            <div class='text-xs text-white/40'>Giá và tồn kho có thể thay đổi trong quá trình thanh toán.</div>
          </div>`;
      }
      async function sync(url,opts){
        const base = {
          headers:{
            'X-Requested-With':'XMLHttpRequest',
            'Accept':'application/json',
            'X-CSRF-TOKEN': csrf || ''
          },
          credentials:'same-origin'
        };
        const r = await fetch(url, Object.assign(base, opts));
        if(r.status===419){ toast('Phiên CSRF hết hạn, reload trang'); return; }
        if(r.status===401){ toast('Cần đăng nhập'); return; }
        if(!r.ok){ console.error(await r.text()); toast('Lỗi thao tác giỏ hàng'); return; }
        state = await r.json();
        render();
        updateNavBadge();
        toast('Đã cập nhật giỏ');
      }
      function toast(msg){
        let box = document.getElementById('toast-box');
        if(!box){ box=document.createElement('div'); box.id='toast-box'; box.className='fixed bottom-4 right-4 space-y-2 z-50'; document.body.appendChild(box); }
        const item=document.createElement('div'); item.className='px-4 py-2 rounded-xl bg-white/90 text-black text-sm shadow'; item.textContent=msg; box.appendChild(item);
        setTimeout(()=>{item.classList.add('opacity-0','scale-95','transition'); setTimeout(()=>item.remove(),400);},1800);
      }
      function updateNavBadge(){
        const badge = document.getElementById('cart-count');
        if(badge){badge.textContent = state.count || 0; badge.classList.toggle('hidden', !state.count);}
      }
      listEl.addEventListener('click', e=>{
        const inc = e.target.closest('[data-inc]');
        const dec = e.target.closest('[data-dec]');
        const rem = e.target.closest('[data-remove]');
        if(inc){
          const id = inc.getAttribute('data-inc');
          const input = listEl.querySelector(`[data-qty='${id}']`);
          input.value = Math.min(parseInt(input.value)+1, parseInt(input.max));
          sync(`/cart/items/${id}`, {method:'PATCH', body:new URLSearchParams({quantity:input.value})});
        }
        if(dec){
          const id = dec.getAttribute('data-dec');
          const input = listEl.querySelector(`[data-qty='${id}']`);
          input.value = Math.max(parseInt(input.value)-1,1);
          sync(`/cart/items/${id}`, {method:'PATCH', body:new URLSearchParams({quantity:input.value})});
        }
        if(rem){
          const id = rem.getAttribute('data-remove');
          sync(`/cart/items/${id}`, {method:'DELETE'});
        }
      });
      summaryEl.addEventListener('click', e=>{
        if(e.target.id==='cart-clear'){
          sync('/cart/clear', {method:'DELETE'});
        }
      });
      listEl.addEventListener('change', e=>{
        const input = e.target.closest('input[data-qty]');
        if(input){
          const id = input.getAttribute('data-qty');
          const val = Math.max(1, Math.min(parseInt(input.value)||1, parseInt(input.max)));
          input.value = val;
          sync(`/cart/items/${id}`, {method:'PATCH', body:new URLSearchParams({quantity:val})});
        }
      });
      render();
      updateNavBadge();
    })();
  </script>
@endsection