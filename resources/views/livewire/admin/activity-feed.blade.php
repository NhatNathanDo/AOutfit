<div class="card bg-base-100 shadow h-full">
    <div class="card-body p-4">
        <div class="flex items-center mb-2">
            <h2 class="card-title text-base">Hoạt động</h2>
            <button wire:click="markAllRead" class="btn btn-xs ms-auto">Đánh dấu tất cả</button>
        </div>
        <ul class="space-y-2 overflow-y-auto max-h-80 pr-1">
            @foreach($activities as $a)
                <li wire:key="activity-{{ $a['id'] }}" class="p-2 rounded border border-base-200 flex items-start gap-2 {{ $a['read'] ? 'opacity-60' : '' }}">
                    <button wire:click="toggleRead({{ $a['id'] }})" class="mt-1 btn btn-ghost btn-xs">
                        <span class="icon-[tabler--circle-{{ $a['read'] ? 'check' : 'dot' }}] text-primary"></span>
                    </button>
                    <div class="flex-1">
                        <p class="text-sm">{{ $a['message'] }}</p>
                        <div class="text-[10px] text-base-content/60 mt-0.5">{{ $a['time'] }}</div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>