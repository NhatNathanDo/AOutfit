<div class="space-y-4">
    <div class="flex items-center gap-2">
        <h2 class="text-xl font-semibold">Thống kê</h2>
        <div class="ms-auto join">
            <button wire:click="setPeriod('day')" class="btn btn-xs join-item {{ $period==='day' ? 'btn-primary' : 'btn-ghost' }}">Ngày</button>
            <button wire:click="setPeriod('week')" class="btn btn-xs join-item {{ $period==='week' ? 'btn-primary' : 'btn-ghost' }}">Tuần</button>
            <button wire:click="setPeriod('month')" class="btn btn-xs join-item {{ $period==='month' ? 'btn-primary' : 'btn-ghost' }}">Tháng</button>
        </div>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($this->stats as $stat)
            <div class="group relative card bg-base-100 shadow hover:shadow-xl transition ring-1 ring-base-200/60 hover:ring-primary/40">
                <div class="card-body p-4 gap-3">
                    <div class="flex items-start justify-between">
                        <div class="space-y-1">
                            <p class="text-[11px] uppercase tracking-wide text-base-content/50 font-medium">{{ $stat['label'] }}</p>
                            <p class="text-2xl font-semibold leading-none">{{ $stat['value'] }}</p>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <span class="{{ $stat['icon'] }} size-6 text-primary inline-block"></span>
                            <span class="badge badge-success badge-xs font-normal">{{ $stat['delta'] }}</span>
                        </div>
                    </div>
                    <div class="h-10 -mb-2" x-data="{points: Array.from({length:16},()=>Math.random()*100)}">
                        <svg viewBox="0 0 100 30" class="w-full h-full overflow-visible">
                            <polyline :points="points.map((p,i)=> `${(i/(points.length-1))*100},${30-(p/100)*30}`).join(' ')" fill="none" stroke="currentColor" stroke-width="2" class="text-primary/60 group-hover:text-primary"></polyline>
                            <polyline :points="points.map((p,i)=> `${(i/(points.length-1))*100},${30-(p/100)*30}`).join(' ')" fill="none" stroke="currentColor" stroke-width="6" stroke-linecap="round" class="text-primary/10"></polyline>
                        </svg>
                    </div>
                </div>
                <div class="absolute inset-0 rounded-xl pointer-events-none opacity-0 group-hover:opacity-100 bg-gradient-to-br from-primary/5 via-transparent"></div>
            </div>
        @endforeach
    </div>
</div>