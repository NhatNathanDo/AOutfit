@php($accent = $accent ?? '#c7b293')
<!-- Desktop Sidebar Filters -->
<aside class="w-80 shrink-0 hidden lg:block">
  <div class="sticky top-20">
    <form action="{{ route('shop.index') }}" method="get" id="filters-form" class="rounded-2xl border border-white/15 bg-neutral-950/70 backdrop-blur">
      <!-- Header -->
      <div class="px-4 pt-4 pb-3 flex items-center justify-between">
        <h3 class="text-base font-semibold text-white">Bộ lọc</h3>
        <a href="{{ route('shop.index') }}" class="text-sm text-white/70 hover:text-white underline">Xóa lọc</a>
      </div>

      <!-- Scrollable body -->
      <div class="px-4 pb-2 max-h-[calc(100vh-240px)] overflow-y-auto space-y-6 text-white/90">
        <input type="hidden" name="q" value="{{ e(request('q','')) }}">

        <!-- Price range -->
        <section class="space-y-3">
          <h4 class="font-medium text-white">Khoảng giá</h4>
          <div class="flex items-center gap-3">
            <input type="number" name="min_price" value="{{ e(request('min_price')) }}" class="input input-sm w-28 rounded-lg bg-neutral-900/80 text-white placeholder-white/50 border-white/20 focus:border-white/30" placeholder="Tối thiểu" min="0">
            <span class="text-white/50">—</span>
            <input type="number" name="max_price" value="{{ e(request('max_price')) }}" class="input input-sm w-28 rounded-lg bg-neutral-900/80 text-white placeholder-white/50 border-white/20 focus:border-white/30" placeholder="Tối đa" min="0">
          </div>
          <div class="flex flex-wrap gap-2">
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
        </section>

        <!-- Categories -->
        <section class="space-y-3">
          <h4 class="font-medium text-white">Danh mục</h4>
          <div class="max-h-56 overflow-auto pr-1 space-y-2">
            @foreach($allCategories as $cat)
              <label class="flex items-center gap-3 text-sm">
                <input type="checkbox" name="category_id[]" value="{{ $cat->id }}" {{ in_array($cat->id, (array)request('category_id', [])) ? 'checked' : '' }} class="checkbox checkbox-sm rounded" />
                <span class="text-white/90">{{ $cat->name }}</span>
              </label>
            @endforeach
          </div>
        </section>

        <!-- Brands -->
        <section class="space-y-3">
          <h4 class="font-medium text-white">Thương hiệu</h4>
          <div class="max-h-56 overflow-auto pr-1 space-y-2">
            @foreach($brands as $brand)
              <label class="flex items-center gap-3 text-sm">
                <input type="checkbox" name="brand_id[]" value="{{ $brand->id }}" {{ in_array($brand->id, (array)request('brand_id', [])) ? 'checked' : '' }} class="checkbox checkbox-sm rounded" />
                <span class="text-white/90">{{ $brand->name }}</span>
              </label>
            @endforeach
          </div>
        </section>

        <!-- Colors -->
        <section class="space-y-3">
          <h4 class="font-medium text-white">Màu sắc</h4>
          <div class="flex flex-wrap gap-2">
            @foreach($colors as $c)
              <label class="inline-flex items-center gap-2 cursor-pointer text-sm">
                <input type="checkbox" name="color[]" value="{{ $c }}" @checked(in_array($c, (array)request('color', []))) class="checkbox checkbox-sm rounded" />
                <span class="inline-flex items-center gap-2">
                  <span class="size-4 rounded-full border border-white/20" style="background-color: {{ $c }}"></span>
                  <span class="text-white/90">{{ $c }}</span>
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
        <section class="space-y-3">
          <h4 class="font-medium text-white">Tình trạng</h4>
          <label class="flex items-center gap-3 text-sm">
            <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} class="checkbox checkbox-sm rounded" />
            <span class="text-white/90">Còn hàng</span>
          </label>
        </section>
      </div>

      <!-- Footer (pinned Apply button) -->
      <div class="px-4 pb-4 pt-3 border-t border-white/10">
        <button class="btn w-full rounded-xl text-base font-medium" style="background-color: {{ $accent }}; color: #111;">Áp dụng bộ lọc</button>
      </div>
    </form>
  </div>
</aside>
