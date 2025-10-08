<div class="card bg-base-100 shadow">
    <div class="card-body p-4">
        <h2 class="card-title text-base mb-2">Sản phẩm bán chạy</h2>
        <ul class="divide-y divide-base-200">
            @foreach($products as $p)
                <li class="py-2">
                    <div class="flex items-center gap-3">
                        <button wire:click="toggle({{ $p['id'] }})" class="btn btn-xs btn-ghost">
                            <span class="icon-[tabler--chevron-{{ in_array($p['id'],$expanded) ? 'down' : 'right' }}]"></span>
                        </button>
                        <div class="flex-1">
                            <p class="font-medium">{{ $p['name'] }}</p>
                            <div class="text-xs text-base-content/60">SKU: {{ $p['sku'] }}</div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold">{{ $p['sales'] }} bán</p>
                            <p class="text-xs text-base-content/60">₫{{ number_format($p['revenue']) }}</p>
                        </div>
                    </div>
                    @if(in_array($p['id'],$expanded))
                        <div class="mt-2 grid grid-cols-3 gap-2 text-xs">
                            <div class="p-2 rounded bg-base-200">
                                <div class="text-base-content/60">Tồn kho</div>
                                <div class="font-semibold">{{ $p['stock'] }}</div>
                            </div>
                            <div class="p-2 rounded bg-base-200">
                                <div class="text-base-content/60">Danh mục</div>
                                <div class="font-semibold">{{ $p['category'] }}</div>
                            </div>
                            <div class="p-2 rounded bg-base-200">
                                <div class="text-base-content/60">Tỷ lệ</div>
                                <div class="font-semibold">{{ rand(10,90) }}%</div>
                            </div>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>