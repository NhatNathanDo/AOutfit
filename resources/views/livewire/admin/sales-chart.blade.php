<div class="card bg-base-100 shadow h-full">
    <div class="card-body p-4">
        <div class="flex items-center mb-2">
            <h2 class="card-title text-base">Doanh thu</h2>
            <div class="ms-auto join">
                <button wire:click="setRange('7d')" class="btn btn-xs join-item {{ $range==='7d' ? 'btn-primary' : 'btn-ghost' }}">7N</button>
                <button wire:click="setRange('30d')" class="btn btn-xs join-item {{ $range==='30d' ? 'btn-primary' : 'btn-ghost' }}">30N</button>
                <button wire:click="setRange('90d')" class="btn btn-xs join-item {{ $range==='90d' ? 'btn-primary' : 'btn-ghost' }}">90N</button>
            </div>
        </div>
        <div 
            x-data="{ points: @js(collect($this->chartData)->pluck('value')), max: Math.max(...@js(collect($this->chartData)->pluck('value'))) }" 
            class="mt-4"
        >
            <div class="flex items-end gap-1 h-40">
                <template x-for="(p,i) in points" :key="i">
                    <div class="flex-1 bg-primary/30 rounded" :style="`height: ${(p/max)*100}%`" title="" ></div>
                </template>
            </div>
            <div class="mt-2 text-xs text-base-content/60">Biểu đồ cột đơn giản (placeholder)</div>
        </div>
    </div>
</div>