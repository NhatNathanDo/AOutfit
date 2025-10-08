<div class="h-screen flex w-full overflow-hidden" x-data="{ mobileNav:false }">
    <!-- Sidebar -->
    <aside class="bg-base-100 border-r border-base-200 flex flex-col w-64 shrink-0 transition-transform duration-200" :class="{'-translate-x-full lg:translate-x-0': !mobileNav}" x-show="mobileNav || $wire.sidebarOpen" x-transition>
        <div class="h-14 flex items-center px-4 border-b border-base-200">
            <span class="font-bold tracking-wide">ADMIN</span>
            <button class="ms-auto btn btn-ghost btn-xs lg:hidden" @click="mobileNav=false"><span class="icon-[tabler--x]"></span></button>
        </div>
        <nav class="flex-1 overflow-y-auto p-3 space-y-1">
            @php($items = [
                ['id'=>'dashboard','label'=>'Dashboard','icon'=>'icon-[tabler--layout-dashboard]'],
                ['id'=>'products','label'=>'Sản phẩm','icon'=>'icon-[tabler--package]'],
                ['id'=>'categories','label'=>'Danh mục','icon'=>'icon-[tabler--folders]'],
                ['id'=>'brands','label'=>'Thương hiệu','icon'=>'icon-[tabler--stack-2]'],
            ])
            @foreach($items as $item)
                <button wire:click="setSection('{{ $item['id'] }}')" class="w-full flex items-center gap-2 px-3 py-2 rounded text-sm text-left hover:bg-base-200 {{ $section===$item['id'] ? 'bg-primary/15 text-primary font-medium' : '' }}">
                    <span class="{{ $item['icon'] }} size-4"></span>
                    <span>{{ $item['label'] }}</span>
                </button>
            @endforeach
        </nav>
        <div class="p-3 border-t border-base-200 text-xs text-base-content/50">
            v1.0 • Livewire SPA Shell
        </div>
    </aside>

    <!-- Main content area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top bar -->
        <header class="h-14 flex items-center gap-3 px-4 border-b border-base-200 bg-base-100">
            <button class="btn btn-ghost btn-sm lg:hidden" @click="mobileNav=true"><span class="icon-[tabler--menu-2]"></span></button>
            <h1 class="text-lg font-semibold capitalize">{{ $section }}</h1>
            <div class="ms-auto flex items-center gap-2">
                <button wire:click="toggleSidebar" class="btn btn-ghost btn-sm hidden lg:inline-flex" title="Thu gọn / Mở sidebar">
                    <span class="icon-[tabler--layout-sidebar-left-collapse]" x-show="$wire.sidebarOpen"></span>
                    <span class="icon-[tabler--layout-sidebar-left-expand]" x-show="!$wire.sidebarOpen"></span>
                </button>
                <button class="btn btn-ghost btn-sm"><span class="icon-[tabler--search]"></span></button>
                <button class="btn btn-ghost btn-sm"><span class="icon-[tabler--bell]"></span></button>
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="avatar placeholder">
                        <div class="bg-primary text-primary-content rounded-full w-8">A</div>
                    </div>
                    <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box mt-3 w-40 p-2 shadow">
                        <li><a>Hồ sơ</a></li>
                        <li><a>Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- Scrollable content -->
        <main class="flex-1 overflow-y-auto bg-base-200 p-6">
            @switch($section)
                @case('dashboard')
                    @include('admin.partials.dashboard')
                    @break
                @case('products')
                    <livewire:admin.manage-products />
                    @break
                @case('categories')
                    <livewire:admin.manage-categories />
                    @break
                @case('brands')
                    <livewire:admin.manage-brands />
                    @break
            @endswitch
        </main>
    </div>
</div>