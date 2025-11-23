@php($accent = $accent ?? '#c7b293')
<!-- Desktop Sidebar Filters -->
<aside class="w-80 shrink-0 hidden lg:block" x-data="filterSidebar()">
  <div class="sticky top-20">
    <form action="{{ route('shop.index') }}" method="get" id="filters-form" class="rounded-2xl border border-white/15 bg-neutral-950/70 backdrop-blur flex flex-col">
      <!-- Header -->
      <div class="px-4 pt-4 pb-3 flex items-center justify-between border-b border-white/10">
        <div class="flex items-center gap-2">
          <h3 class="text-base font-semibold text-white">Bộ lọc</h3>
          <span class="px-2 py-0.5 rounded-full text-[11px] bg-white/10 text-white/70" x-text="selectedCount"></span>
        </div>
        <div class="flex items-center gap-3">
          <button type="button" @click="expandAll()" class="text-xs text-white/60 hover:text-white">Mở</button>
          <button type="button" @click="collapseAll()" class="text-xs text-white/60 hover:text-white">Thu</button>
          <a href="{{ route('shop.index') }}" class="text-sm text-white/70 hover:text-white underline">Reset</a>
        </div>
      </div>

      <!-- Scrollable body -->
      <div class="px-4 py-4 max-h-[calc(100vh-260px)] overflow-y-auto space-y-6 text-white/90 custom-scroll">
        <input type="hidden" name="q" value="{{ e(request('q','')) }}">

        <!-- Price range -->
        <section class="space-y-3" x-data="{open:true}" :class="open?'':'opacity-70'">
          <div class="flex items-center justify-between cursor-pointer" @click="open=!open">
            <h4 class="font-medium text-white flex items-center gap-2">Khoảng giá <span class="icon-[tabler--chevron-down] transition" :class="open?'rotate-0':'-rotate-90'"></span></h4>
            <span class="text-xs text-white/50" x-text="priceSummary()"></span>
          </div>
          <div x-show="open" x-transition>
            <div class="flex items-center gap-3 mt-2">
              <input type="number" name="min_price" value="{{ e(request('min_price')) }}" class="input input-xs w-24 rounded-lg bg-neutral-900/80 text-white placeholder-white/50 border-white/20 focus:border-white/30" placeholder="Min" min="0">
              <span class="text-white/50">—</span>
              <input type="number" name="max_price" value="{{ e(request('max_price')) }}" class="input input-xs w-24 rounded-lg bg-neutral-900/80 text-white placeholder-white/50 border-white/20 focus:border-white/30" placeholder="Max" min="0">
            </div>
            <div class="mt-3 space-y-2">
              <input type="range" min="0" max="2000000" step="10000" x-ref="minRange" @input="syncRange()" value="{{ (int)request('min_price',0) }}" class="w-full">
              <input type="range" min="0" max="2000000" step="10000" x-ref="maxRange" @input="syncRange()" value="{{ (int)request('max_price',2000000) }}" class="w-full">
            </div>
            <div class="flex flex-wrap gap-2 mt-3">
              @php($__pricePresets = [[0,199000],[200000,499000],[500000,999000],[1000000,2000000]])
              @foreach($__pricePresets as $__pair)
                @php($min = $__pair[0])
                @php($max = $__pair[1])
                @php($active = request('min_price')==$min && request('max_price')==$max)
                <a href="{{ route('shop.index', array_merge(request()->except(['page']), ['min_price'=>$min,'max_price'=>$max])) }}" class="px-3 py-1 rounded-full text-xs border {{ $active ? 'border-transparent' : 'border-white/20' }}" style="{{ $active ? 'background-color: '.$accent.'; color:#111;' : '' }}">
                  {{ number_format($min/1000) }}k–{{ number_format($max/1000) }}k
                </a>
              @endforeach
            </div>
          </div>
        </section>

        <!-- Categories -->
        <section class="space-y-3" x-data="{open:true, search:''}" :class="open?'':'opacity-70'">
          <div class="flex items-center justify-between cursor-pointer" @click="open=!open">
            <h4 class="font-medium text-white flex items-center gap-2">Danh mục <span class="icon-[tabler--chevron-down] transition" :class="open?'rotate-0':'-rotate-90'"></span></h4>
            <span class="text-xs text-white/50" x-text="selectedCat()"></span>
          </div>
          <div x-show="open" x-transition>
            <input type="text" x-model="search" placeholder="Tìm danh mục" class="input input-xs w-full mt-2 bg-neutral-900/70 border-white/20 placeholder-white/40" />
            <div class="max-h-56 overflow-auto pr-1 space-y-2 mt-2" x-ref="catList">
              @foreach($allCategories as $cat)
                <label class="flex items-center gap-3 text-sm" x-show="!search || '{{ Str::lower($cat->name) }}'.includes(search.toLowerCase())">
                  <input type="checkbox" name="category_id[]" value="{{ $cat->id }}" {{ in_array($cat->id, (array)request('category_id', [])) ? 'checked' : '' }} class="checkbox checkbox-sm rounded" />
                  <span class="text-white/90">{{ $cat->name }}</span>
                </label>
              @endforeach
            </div>
          </div>
        </section>

        <!-- Brands -->
        <section class="space-y-3" x-data="{open:true, search:''}" :class="open?'':'opacity-70'">
          <div class="flex items-center justify-between cursor-pointer" @click="open=!open">
            <h4 class="font-medium text-white flex items-center gap-2">Thương hiệu <span class="icon-[tabler--chevron-down] transition" :class="open?'rotate-0':'-rotate-90'"></span></h4>
            <span class="text-xs text-white/50" x-text="selectedBrand()"></span>
          </div>
          <div x-show="open" x-transition>
            <input type="text" x-model="search" placeholder="Tìm thương hiệu" class="input input-xs w-full mt-2 bg-neutral-900/70 border-white/20 placeholder-white/40" />
            <div class="max-h-56 overflow-auto pr-1 space-y-2 mt-2">
              @foreach($brands as $brand)
                <label class="flex items-center gap-3 text-sm" x-show="!search || '{{ Str::lower($brand->name) }}'.includes(search.toLowerCase())">
                  <input type="checkbox" name="brand_id[]" value="{{ $brand->id }}" {{ in_array($brand->id, (array)request('brand_id', [])) ? 'checked' : '' }} class="checkbox checkbox-sm rounded" />
                  <span class="text-white/90">{{ $brand->name }}</span>
                </label>
              @endforeach
            </div>
          </div>
        </section>

        <!-- Colors -->
        <section class="space-y-3" x-data="{open:true}" :class="open?'':'opacity-70'">
          <div class="flex items-center justify-between cursor-pointer" @click="open=!open">
            <h4 class="font-medium text-white flex items-center gap-2">Màu sắc <span class="icon-[tabler--chevron-down] transition" :class="open?'rotate-0':'-rotate-90'"></span></h4>
            <span class="text-xs text-white/50" x-text="selectedColor()"></span>
          </div>
          <div x-show="open" x-transition class="flex flex-wrap gap-2 mt-2">
            @foreach($colors as $c)
              <label class="group relative inline-flex items-center cursor-pointer" title="{{ $c }}">
                <input type="checkbox" name="color[]" value="{{ $c }}" @checked(in_array($c, (array)request('color', []))) class="hidden" />
                <span class="size-8 rounded-xl border border-white/20 flex items-center justify-center ring-0 group-has-[:checked]:ring-2 group-has-[:checked]:ring-[{{ $accent }}]" style="background: {{ $c }}">
                  <span class="icon-[tabler--check] text-xs opacity-0 group-has-[:checked]:opacity-100 text-black mix-blend-luminosity"></span>
                </span>
              </label>
            @endforeach
          </div>
        </section>

        <!-- Size placeholder -->
        <section class="space-y-3">
          <h4 class="font-medium text-white">Kích thước</h4>
          <div class="text-sm text-white/60">Sắp có</div>
        </section>

        <!-- Availability -->
        <section class="space-y-3" x-data="{open:true}" :class="open?'':'opacity-70'">
          <div class="flex items-center justify-between cursor-pointer" @click="open=!open">
            <h4 class="font-medium text-white flex items-center gap-2">Tình trạng <span class="icon-[tabler--chevron-down] transition" :class="open?'rotate-0':'-rotate-90'"></span></h4>
          </div>
          <div x-show="open" x-transition>
            <label class="flex items-center gap-3 text-sm">
              <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} class="checkbox checkbox-sm rounded" />
              <span class="text-white/90">Còn hàng</span>
            </label>
          </div>
        </section>
      </div>

      <!-- Footer (pinned Apply button) -->
      <div class="px-4 pb-4 pt-3 border-t border-white/10 mt-auto space-y-3">
        <button class="btn w-full rounded-xl text-base font-medium" style="background-color: {{ $accent }}; color: #111;">Áp dụng bộ lọc</button>
        <button type="button" @click="clearSelections()" class="btn btn-ghost w-full rounded-xl text-sm">Xóa lựa chọn đã chọn</button>
      </div>
    </form>
  </div>
</aside>
<script>
  function filterSidebar(){
    return {
      selectedCount: '0',
      updateSelected(){
        const checked = document.querySelectorAll('#filters-form input[type=checkbox]:checked').length;
        this.selectedCount = checked+' chọn';
      },
      expandAll(){ document.querySelectorAll('#filters-form section > div.flex').forEach(()=>{}); },
      collapseAll(){ /* handled by individual x-data sections toggling open var */ document.querySelectorAll('#filters-form [x-data]') },
      clearSelections(){
        document.querySelectorAll('#filters-form input[type=checkbox]').forEach(c=>c.checked=false);
        this.updateSelected();
      },
      priceSummary(){
        const min = document.querySelector('#filters-form input[name=min_price]')?.value;
        const max = document.querySelector('#filters-form input[name=max_price]')?.value;
        if(!min && !max) return '—';
        return (min||'0')+' - '+(max||'∞');
      },
    }
  }
  document.addEventListener('change', e=>{
    if(e.target.closest('#filters-form')){
      const cmp = document.querySelector('aside[x-data]');
      cmp?.__x?.updateElements();
      cmp?.__x?.$data.updateSelected();
    }
  });
</script>
