@extends('customer.layouts.app')

@section('title', __('Log in'))

@section('content')
<div class="container mx-auto my-16">
    <div class="mx-auto w-full max-w-5xl">
        <div class="card border border-base-content/20 bg-white/5 text-white">
            <div class="card-body p-0">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <!-- Left: Promo/Brand -->
                    <div class="p-8 md:p-10 border-b md:border-b-0 md:border-r border-base-content/10 flex flex-col justify-center gap-4 bg-gradient-to-b from-black to-black/50">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold">{{ __('Chào mừng bạn trở lại') }}</h1>
                            <p class="mt-2 text-gray-300">{{ __('Đăng nhập để tiếp tục hành trình mua sắm của bạn với AOutfit.') }}</p>
                        </div>
                        <ul class="space-y-3 text-gray-300">
                            <li class="flex items-start gap-3"><span class="icon-[tabler--sparkles] text-[#c7b293]"></span><span>{{ __('Outfit được chọn lọc chỉ dành cho bạn') }}</span></li>
                            <li class="flex items-start gap-3"><span class="icon-[tabler--truck] text-[#c7b293]"></span><span>{{ __('Giao hàng nhanh chóng và dễ dàng trả hàng') }}</span></li>
                            <li class="flex items-start gap-3"><span class="icon-[tabler--lock] text-[#c7b293]"></span><span>{{ __('Thanh toán an toàn và lưu trữ tùy chọn') }}</span></li>
                        </ul>
                    </div>

                    <!-- Right: Form -->
                    <div class="p-8 md:p-10">
                        @if (session('status'))
                            <div class="alert alert-success text-sm">
                                <span class="icon-[tabler--check] mr-2"></span>
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="mt-4" x-data>
                            @csrf

                            <div class="form-control w-full">
                                <label for="email" class="label">
                                    <span class="label-text text-gray-300">{{ __('Email') }}</span>
                                </label>
                                <div class="relative">
                                    <span class="icon-[tabler--mail] absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></span>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus
                                                 class="input input-bordered w-full pl-10 bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-control w-full mt-4">
                                <label for="password" class="label">
                                    <span class="label-text text-gray-300">{{ __('Mật khẩu') }}</span>
                                </label>
                                <div class="relative">
                                    <span class="icon-[tabler--lock] absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></span>
                                    <input id="password" type="password" name="password" required autocomplete="current-password"
                                                 class="input input-bordered w-full pl-10 pr-12 bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
                                    <button type="button" class="btn btn-ghost btn-square absolute right-1 top-1/2 -translate-y-1/2" data-toggle-password="#password" aria-label="Toggle password visibility">
                                        <span class="icon-[tabler--eye] toggle-icon-show"></span>
                                        <span class="icon-[tabler--eye-off] hidden toggle-icon-hide"></span>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-3 flex items-center justify-between">
                                <label for="remember_me" class="flex items-center gap-2">
                                    <input id="remember_me" name="remember" type="checkbox" class="checkbox checkbox-sm border-neutral-700" />
                                    <span class="text-sm text-gray-300">{{ __('Nhớ tôi') }}</span>
                                </label>
                                @if (Route::has('password.request'))
                                    <a class="text-sm text-gray-300 hover:text-white" href="{{ route('password.request') }}">{{ __('Quên mật khẩu?') }}</a>
                                @endif
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="btn w-full h-11 text-neutral-900" style="background-color:#c7b293;">
                                    {{ __('Log in') }}
                                </button>
                            </div>

                            <div class="divider my-6 text-gray-400">{{ __('hoặc tiếp tục với') }}</div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <a href="#" class="btn btn-outline btn-secondary w-full">
                                    <span class="icon-[tabler--brand-google] mr-2"></span> Google
                                </a>
                                <a href="#" class="btn btn-outline btn-secondary w-full">
                                    <span class="icon-[tabler--brand-facebook] mr-2"></span> Facebook
                                </a>
                            </div>

                            <p class="mt-6 text-center text-sm text-gray-300">
                                {{ __('Bạn chưa có tài khoản?') }}
                                <a href="{{ route('register') }}" class="font-medium text-white underline hover:opacity-80">{{ __('Đăng ký') }}</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Password toggle (no external dependency)
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-toggle-password]')?.forEach(function(btn){
            btn.addEventListener('click', function(){
                const input = document.querySelector(this.getAttribute('data-toggle-password'));
                if (!input) return;
                const isPwd = input.type === 'password';
                input.type = isPwd ? 'text' : 'password';
                const showIcon = this.querySelector('.toggle-icon-show');
                const hideIcon = this.querySelector('.toggle-icon-hide');
                if (showIcon && hideIcon){
                    if (isPwd){ showIcon.classList.add('hidden'); hideIcon.classList.remove('hidden'); }
                    else { showIcon.classList.remove('hidden'); hideIcon.classList.add('hidden'); }
                }
            })
        });
    });
</script>
@endsection
