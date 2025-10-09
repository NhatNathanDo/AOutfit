<div class="space-y-4">
    <div class="flex items-center gap-2">
        <div class="join">
            <input type="text" wire:model.debounce.400ms="search" class="input input-sm input-bordered join-item" placeholder="Tìm sản phẩm...">
            <button class="btn btn-sm join-item" wire:click="create"><span class="icon-[tabler--plus]"></span> Thêm</button>
        </div>
        <span wire:loading.class="opacity-50" class="text-xs text-base-content/60">Đang tải...</span>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($products as $p)
                    <tr wire:key="prod-{{ $p->id }}">
                        <td class="font-mono">{{ $p->id }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ is_numeric($p->price) ? number_format($p->price,2) : $p->price }}</td>
                        <td class="text-right space-x-1">
                            <button wire:click="edit({{ $p->id }})" class="btn btn-ghost btn-xs"><span class="icon-[tabler--edit]"></span></button>
                            <button wire:click="delete({{ $p->id }})" class="btn btn-ghost btn-xs text-error"><span class="icon-[tabler--trash]"></span></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-2">{{ $products->links() }}</div>
    </div>

    <div class="modal {{ $showForm ? 'modal-open' : '' }}">
        <div class="modal-box space-y-4">
            <h3 class="font-bold text-lg">{{ $editingId ? 'Cập nhật sản phẩm' : 'Tạo sản phẩm' }}</h3>
            <div class="form-control">
                <label class="label"><span class="label-text">Tên</span></label>
                <input wire:model.defer="form.name" type="text" class="input input-bordered">
                @error('form.name')<span class="text-error text-xs">{{ $message }}</span>@enderror
            </div>
            <div class="form-control">
                <label class="label"><span class="label-text">Giá</span></label>
                <input wire:model.defer="form.price" type="number" step="0.01" class="input input-bordered">
                @error('form.price')<span class="text-error text-xs">{{ $message }}</span>@enderror
            </div>
            <div class="modal-action">
                <button wire:click="$set('showForm', false)" class="btn btn-ghost">Hủy</button>
                <button wire:click="save" class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>