<div class="h-screen flex w-full overflow-hidden" x-data="{ mobileNav:false, collapsed:false, search:'', focusSearch(){ requestAnimationFrame(()=> $refs.search?.focus()); } }" x-on:keydown.ctrl.k.prevent="focusSearch()">
    <!-- Sidebar -->
    <aside class="bg-base-100 border-r border-base-200 flex flex-col shrink-0 transition-all duration-300" :class="{'w-64': !collapsed, 'w-16': collapsed, '-translate-x-full lg:translate-x-0': !mobileNav}" x-show="mobileNav || $wire.sidebarOpen" x-transition>
        <div class="h-14 flex items-center px-4 border-b border-base-200 gap-2">
            <span class="font-bold tracking-wide truncate" x-show="!collapsed">ADMIN</span>
            <button class="btn btn-ghost btn-xs" @click="collapsed=!collapsed" :title="collapsed ? 'Mở rộng' : 'Thu gọn'">
                <span class="icon-[tabler--layout-sidebar-right-collapse] inline-block" x-show="!collapsed"></span>
                <span class="icon-[tabler--layout-sidebar-right-expand] inline-block" x-show="collapsed"></span>
            </button>
            <button class="ms-auto btn btn-ghost btn-xs lg:hidden" @click="mobileNav=false"><span class="icon-[tabler--x]"></span></button>
        </div>
        <nav class="flex-1 overflow-y-auto py-3 space-y-1" :class="collapsed ? 'px-2' : 'px-3'">
            @php($items = [
                ['id'=>'dashboard','label'=>'Tổng quan','icon'=>'icon-[tabler--layout-dashboard]'],
                ['id'=>'products','label'=>'Sản phẩm','icon'=>'icon-[tabler--package]'],
                ['id'=>'categories','label'=>'Danh mục','icon'=>'icon-[tabler--folders]'],
                ['id'=>'brands','label'=>'Thương hiệu','icon'=>'icon-[tabler--stack-2]'],
            ])
            @foreach($items as $item)
                <button wire:click="setSection('{{ $item['id'] }}')" class="group relative w-full flex items-center gap-3 px-3 py-2 rounded text-sm text-left hover:bg-base-200 focus:outline-none focus:ring-2 focus:ring-primary/40 {{ $section===$item['id'] ? 'bg-primary/15 text-primary font-medium' : '' }}" :title="collapsed ? '{{ $item['label'] }}' : ''">
                    <span class="{{ $item['icon'] }} size-5 shrink-0 inline-block"></span>
                    <span class="truncate" x-show="!collapsed">{{ $item['label'] }}</span>
                    @if($section===$item['id'])
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary rounded-r"></span>
                    @endif
                </button>
            @endforeach
        </nav>
        <div class="p-3 border-t border-base-200 text-[10px] text-base-content/50 space-y-1" x-show="!collapsed">
            <div>v1.1 • Bảng quản trị</div>
            <div class="opacity-70">Ctrl + K để tìm</div>
        </div>
    </aside>

    <!-- Main content area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top bar -->
    <header class="h-14 flex items-center gap-3 px-4 border-b border-base-200 bg-base-100 backdrop-blur supports-[backdrop-filter]:bg-base-100/90">
            <button class="btn btn-ghost btn-sm lg:hidden" @click="mobileNav=true"><span class="icon-[tabler--menu-2] inline-block"></span></button>
            <nav class="text-xs breadcrumbs hidden md:block">
                <ul>
                    <li><a wire:click="setSection('dashboard')">Tổng quan</a></li>
                    @if($section !== 'dashboard')<li class="capitalize">@lang(match($section){'products'=>'Sản phẩm','categories'=>'Danh mục','brands'=>'Thương hiệu', default=>$section})</li>@endif
                </ul>
            </nav>
            <div class="ms-auto flex items-center gap-2">
                <div class="relative">
                    <span class="icon-[tabler--search] inline-block absolute left-2 top-1/2 -translate-y-1/2 text-base-content/40 size-4"></span>
                    <input x-ref="search" x-model="search" type="text" placeholder="Tìm (Ctrl+K)" class="input input-sm input-bordered ps-7 w-48 md:w-64" />
                </div>
                <button class="btn btn-ghost btn-sm" title="Thông báo"><span class="icon-[tabler--bell] inline-block"></span></button>
                <button @click="toggle" class="btn btn-ghost btn-sm" title="Chuyển giao diện">
                    <span class="icon-[tabler--moon] inline-block" x-show="theme==='light'"></span>
                    <span class="icon-[tabler--sun] inline-block" x-show="theme==='dark'"></span>
                </button>
                {{-- <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="avatar placeholder">
                        <div class="bg-primary text-primary-content rounded-full w-8">A</div>
                    </div>
                    <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box mt-3 w-48 p-2 shadow">
                        <li><a><span class="icon-[tabler--user] size-4 inline-block"></span> Hồ sơ</a></li>
                        <li><a><span class="icon-[tabler--settings] size-4 inline-block"></span> Cài đặt</a></li>
                        <li><a><span class="icon-[tabler--logout] size-4 inline-block"></span> Đăng xuất</a></li>
                    </ul>
                </div> --}}
            </div>
        </header>
        <!-- Scrollable content -->
        <main class="flex-1 overflow-y-auto bg-base-200 p-6 space-y-6">
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