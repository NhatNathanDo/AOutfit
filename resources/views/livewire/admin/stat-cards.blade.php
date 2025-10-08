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
            <div class="card bg-base-100 shadow hover:shadow-lg transition">
                <div class="card-body p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-base-content/70">{{ $stat['label'] }}</p>
                            <p class="text-2xl font-bold mt-1">{{ $stat['value'] }}</p>
                        </div>
                        <span class="{{ $stat['icon'] }} text-primary size-6"></span>
                    </div>
                    <div class="mt-2 text-xs text-success">{{ $stat['delta'] }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>