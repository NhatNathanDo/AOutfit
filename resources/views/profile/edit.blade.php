@extends('customer.layouts.app')

@section('title', __('Hồ sơ cá nhân'))

@section('content')
<div class="container mx-auto my-16">
    <div class="max-w-5xl mx-auto space-y-8 text-white">
        <!-- Breadcrumb + Page Heading -->
        <div>
            <nav aria-label="Breadcrumb" class="text-sm text-gray-400">
                <ol class="flex flex-wrap gap-1">
                    <li>
                        <a href="{{ url('/') }}" class="hover:text-white flex items-center gap-1">
                            <span class="icon-[tabler--home] text-xs"></span>{{ __('Trang chủ') }}
                        </a>
                    </li>
                    <li class="opacity-50">/</li>
                    <li>
                        <span class="flex items-center gap-1">
                            <span class="icon-[tabler--user] text-xs"></span>{{ __('Tài khoản') }}
                        </span>
                    </li>
                    <li class="opacity-50">/</li>
                    <li class="text-white font-medium">
                        {{ __('Hồ sơ') }}
                    </li>
                </ol>
            </nav>
            <div class="mt-3 flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-white/10 flex items-center justify-center text-2xl font-bold">
                    {{ \Illuminate\Support\Str::of($user->name)->substr(0, 1)->upper() }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">{{ $user->name }}</h1>
                    <p class="text-gray-300 text-sm">{{ $user->email }}</p>
                </div>
            </div>
            <p class="mt-4 text-gray-300 text-sm">{{ __('Quản lý thông tin tài khoản, bảo mật và quyền riêng tư của bạn.') }}</p>
        </div>

        <!-- Profile Tabs Card -->
        <div x-data="profileTabs()" x-init="init()" class="card border border-base-content/20 bg-white/5">
            <div class="card-body p-0">
                <!-- Tabs -->
                <div class="border-b border-base-content/10 px-4 md:px-6 bg-black/40">
                    <div role="tablist" class="tabs tabs-bordered">
                        <button role="tab" @click="switchTo('info')" :class="{'tab-active': tab==='info'}" class="tab text-gray-300">{{ __('Thông tin') }}</button>
                        <button role="tab" @click="switchTo('password')" :class="{'tab-active': tab==='password'}" class="tab text-gray-300">{{ __('Mật khẩu') }}</button>
                        <button role="tab" @click="switchTo('danger')" :class="{'tab-active': tab==='danger'}" class="tab text-gray-300">{{ __('Bảo mật / Xóa') }}</button>
                    </div>
                </div>

                <!-- Tab Contents -->
                <div class="p-6 md:p-10">
                    <template x-if="tab==='info'">
                        <div x-transition.opacity.duration.250ms>
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </template>
                    <template x-if="tab==='password'">
                        <div x-transition.opacity.duration.250ms>
                            @include('profile.partials.update-password-form')
                        </div>
                    </template>
                    <template x-if="tab==='danger'">
                        <div x-transition.opacity.duration.250ms>
                            <div class="rounded-lg border border-red-500/30 bg-red-500/10 p-4 mb-6">
                                <div class="flex items-center gap-2 text-red-300">
                                    <span class="icon-[tabler--shield-lock]"></span>
                                    <p class="text-sm">{{ __('Khu vực nhạy cảm: Thao tác liên quan bảo mật & xóa vĩnh viễn.') }}</p>
                                </div>
                            </div>
                            @include('profile.partials.delete-user-form')
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function profileTabs(){
    return {
        tab: 'info',
        init(){
            const url = new URL(window.location.href);
            const qp = url.searchParams.get('tab');
            if(['info','password','danger'].includes(qp)) this.tab = qp;
            this.updateUrl();
        },
        switchTo(name){ this.tab = name; this.updateUrl(); },
        updateUrl(){
            const url = new URL(window.location.href);
            url.searchParams.set('tab', this.tab);
            window.history.replaceState({}, '', url);
        }
    }
}
</script>
@endpush
