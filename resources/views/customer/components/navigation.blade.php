<nav class="navbar bg-black">
  <div class="relative w-full p-1">
    <span aria-hidden class="pointer-events-none absolute left-60 top-1/2 -translate-y-1/2 h-13 border-l border-dashed border-base-content/30 hidden md:flex
    after:content-[''] after:absolute after:-bottom-1 after:right-10 after:w-13 after:border-t after:border-dashed after:border-base-content/30"></span>
    <span aria-hidden class="pointer-events-none absolute right-60 top-1/2 -translate-y-1/2 h-13 border-l border-dashed border-base-content/30 hidden md:flex
    after:content-[''] after:absolute after:-bottom-1 after:left-10 after:w-13 after:border-t after:border-dashed after:border-base-content/30"></span>

    <div class="mx-auto flex w-full max-w-7xl items-center justify-between border-b border-dashed border-base-content/30">
      <div class="navbar-start mb-3">
        <div class="md:hidden">
          <button type="button" class="collapse-toggle btn btn-outline btn-secondary btn-sm btn-square" data-collapse="#default-navbar-collapse" aria-controls="default-navbar-collapse" aria-label="Toggle navigation" >
            <span class="icon-[tabler--menu-2] collapse-open:hidden size-4"></span>
            <span class="icon-[tabler--x] collapse-open:block hidden size-4"></span>
          </button>
            <div id="default-navbar-collapse" class="md:navbar-end collapse hidden grow basis-full overflow-hidden transition-[height] duration-300 max-md:w-full" >
                <ul class="menu md:menu-horizontal gap-2 p-0 text-base max-md:mt-2">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact us</a></li>
                </ul>
            </div>
        </div>

        <ul class="menu menu-horizontal hidden gap-3 p-0 lg:flex">
          <li>
            <a href="/" class="btn btn-neutral btn-soft btn-lg text-sm rounded-lg px-5">Trang chủ</a>
          </li>
          <li>
            <a href="#" class="btn btn-lg text-sm rounded-lg px-5 btn-outline border-dashed btn-secondary">Sản phẩm</a>
          </li>
        </ul>
      </div>

      <div class="navbar-center hidden md:flex mb-3">
        <a class="text-xl font-bold no-underline text-black">AOutfit</a>
      </div>

      <!-- Desktop actions -->
      <div class="navbar-end gap-2 hidden md:flex mb-3">
        <a class="btn btn-neutral btn-soft btn-square btn-lg" href="#" aria-label="Cart">
          <span class="icon-[tabler--shopping-cart-filled] size-5"></span>
        </a>
        <div class="dropdown dropdown-end relative inline-flex">
          @if(auth()->check())
            <!-- Logged-in: show avatar as toggle -->
            <button id="dropdown-avatar" type="button" class="dropdown-toggle btn btn-soft btn-lg text-sm rounded-lg flex items-center gap-3 px-4 hover:opacity-90 text-neutral-900 shadow-sm" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown" style="background-color:#c7b293;">
              <div class="avatar">
                <div class="w-6 h-6 rounded-full ring-2 ring-white/20 overflow-hidden">
                  <img src="https://cdn.flyonui.com/fy-assets/avatar/avatar-3.png" alt="User Avatar" />
                </div>
              </div>
              <span class="truncate max-w-[140px] md:max-w-[200px]">{{ auth()->user()->name }}</span>
              <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
            </button>
          @else
            <!-- Guest: brand account button -->
            <button id="dropdown-header" type="button" class="dropdown-toggle btn-lg btn-soft text-sm rounded-lg px-5 text-neutral-900" style="background-color:#c7b293;" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
              Tài khoản
              <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 size-4"></span>
            </button>
          @endif
          <ul class="dropdown-menu dropdown-open:opacity-100 hidden right-0 mt-2 z-50 min-w-64 p-3 rounded-xl border border-base-content/20 bg-black/90 backdrop-blur shadow-xl" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-avatar">
            @if(auth()->check())
              <li class="dropdown-header">
                <div class="flex items-center gap-3 p-3 rounded-lg bg-white/5">
                  <div class="avatar">
                    <div class="w-10 rounded-full">
                      <img src="https://cdn.flyonui.com/fy-assets/avatar/avatar-2.png" alt="User Avatar" />
                    </div>
                  </div>
                  <div>
                    <h6 class="text-white text-base font-semibold">{{ auth()->user()->name }}</h6>
                    <small class="text-white/30 text-sm font-normal">{{ auth()->user()->email }}</small>
                  </div>
                </div>
              </li>
              <li class="mt-2"><a class="dropdown-item flex items-center gap-3 text-white/80" href="#"><span class="icon-[tabler--user] size-5"></span>Trang cá nhân</a></li>
              <li><a class="dropdown-item flex items-center gap-3 text-white/80" href="#"><span class="icon-[tabler--settings] size-5"></span>Cài đặt</a></li>
              <li><a class="dropdown-item flex items-center gap-3 text-white/80" href="#"><span class="icon-[tabler--file-invoice] size-5"></span>Hóa đơn</a></li>
              <li><a class="dropdown-item flex items-center gap-3 text-white/80" href="#"><span class="icon-[tabler--help-circle] size-5"></span>FAQs</a></li>
              <li class="my-2"><div class="divider m-0"></div></li>
              <li class="dropdown-footer">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                  @csrf
                  <button type="submit" class="btn btn-error btn-soft btn-block">{{ __('Đăng xuất') }}</button>
                </form>
              </li>
            @else
              <li class="p-2 text-sm text-gray-300">Đăng nhập để trải nghiệm đầy đủ tính năng của AOutfit</li>
              <li class="grid grid-cols-1 gap-2">
                <a class="btn w-full text-neutral-900" style="background-color:#c7b293;" href="{{ route('login') }}">Đăng nhập</a>
                <a class="btn btn-outline btn-secondary w-full" href="{{ route('register') }}">Đăng ký</a>
              </li>
            @endif
          </ul>
        </div>
      </div>

      <!-- Mobile actions -->
  <div class="navbar-end flex md:hidden gap-2 mb-3">
        <a class="btn btn-ghost btn-square" href="#" aria-label="Cart">
          <span class="icon-[tabler--shopping-cart] size-5 text-white"></span>
        </a>
  <div class="dropdown dropdown-end relative inline-flex">
          <button id="dropdown-header-mobile" type="button" class="dropdown-toggle btn btn-ghost btn-square" aria-haspopup="menu" aria-expanded="false" aria-label="Account menu">
            @if(auth()->check())
              <span class="icon-[tabler--user] size-5 text-white"></span>
            @else
              <span class="icon-[tabler--login] size-5 text-white"></span>
            @endif
          </button>
          <ul class="dropdown-menu dropdown-open:opacity-100 hidden right-0 mt-2 z-50 min-w-56 p-3 rounded-xl border border-base-content/20 bg-black/90 backdrop-blur shadow-xl" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-header-mobile">
            @if(auth()->check())
              <li class="dropdown-header">
                <div class="p-3 rounded-lg bg-white/5">
                  <h6 class="text-white text-base font-semibold">{{ auth()->user()->name }}</h6>
                  <small class="text-gray-300/80 text-sm font-normal">{{ auth()->user()->email }}</small>
                </div>
              </li>
              <li class="mt-2"><a class="dropdown-item flex items-center gap-3" href="#"><span class="icon-[tabler--user] size-5"></span>Trang cá nhân</a></li>
              <li><a class="dropdown-item flex items-center gap-3" href="#"><span class="icon-[tabler--settings] size-5"></span>Cài đặt</a></li>
              <li><a class="dropdown-item flex items-center gap-3" href="#"><span class="icon-[tabler--file-invoice] size-5"></span>Hóa đơn</a></li>
              <li class="my-2"><div class="divider m-0"></div></li>
              <li class="dropdown-footer">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                  @csrf
                  <button type="submit" class="btn btn-error btn-soft btn-block">{{ __('Đăng xuất') }}</button>
                </form>
              </li>
            @else
              <li class="grid grid-cols-1 gap-2 w-full">
                <a class="btn w-full text-neutral-900" style="background-color:#c7b293;" href="{{ route('login') }}">Đăng nhập</a>
                <a class="btn btn-outline btn-secondary w-full" href="{{ route('register') }}">Đăng ký</a>
              </li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>