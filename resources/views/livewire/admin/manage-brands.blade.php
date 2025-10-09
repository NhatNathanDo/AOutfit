<div class="space-y-4">
    <div class="flex items-center gap-2">
        <input type="text" wire:model.defer="name" placeholder="Tên thương hiệu" class="input input-sm input-bordered w-56">
        <button wire:click="save" class="btn btn-sm btn-primary">{{ $editingId ? 'Cập nhật' : 'Thêm' }}</button>
        @if($editingId)
            <button wire:click="$set('editingId', null); $set('name','')" class="btn btn-sm btn-ghost">Hủy</button>
        @endif
    </div>
    <div class="card bg-base-100 shadow">
        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead>
                    <tr><th>ID</th><th>Tên</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach($brands as $b)
                        <tr wire:key="brand-{{ $b->id }}">
                            <td class="font-mono">{{ $b->id }}</td>
                            <td>{{ $b->name }}</td>
                            <td class="text-right space-x-1">
                                <button wire:click="edit({{ $b->id }})" class="btn btn-ghost btn-xs"><span class="icon-[tabler--edit]"></span></button>
                                <button wire:click="delete({{ $b->id }})" class="btn btn-ghost btn-xs text-error"><span class="icon-[tabler--trash]"></span></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-2">{{ $brands->links() }}</div>
    </div>
</div>