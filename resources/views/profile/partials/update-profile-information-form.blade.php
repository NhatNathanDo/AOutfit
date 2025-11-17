<section class="space-y-5">
    <div class="space-y-1">
        <h2 class="text-lg font-semibold tracking-wide">{{ __('Thông tin hồ sơ') }}</h2>
        <p class="text-xs text-gray-400">{{ __('Cập nhật tên và email để cá nhân hóa trải nghiệm của bạn.') }}</p>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success text-sm">
            <span class="icon-[tabler--check] mr-2"></span>
            {{ __('Thông tin hồ sơ đã được lưu.') }}
        </div>
    @endif

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="form-control w-full">
            <label for="name" class="label">
                <span class="label-text text-gray-300">{{ __('Họ và tên') }}</span>
            </label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name"
                   class="input input-bordered w-full bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
            @error('name')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-control w-full">
            <label for="email" class="label">
                <span class="label-text text-gray-300">{{ __('Email') }}</span>
            </label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                   class="input input-bordered w-full bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
            @error('email')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <div class="alert alert-warning text-sm">
                        <span class="icon-[tabler--alert-circle] mr-2"></span>
                        {{ __('Địa chỉ email của bạn chưa được xác minh.') }}
                        <button form="send-verification" class="ml-2 underline hover:opacity-80">
                            {{ __('Gửi lại email xác minh') }}
                        </button>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success text-sm mt-2">
                            <span class="icon-[tabler--check] mr-2"></span>
                            {{ __('Liên kết xác minh mới đã được gửi tới email của bạn.') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="pt-1 flex items-center gap-4">
            <button type="submit" class="btn h-10 px-6 text-neutral-900" style="background-color:#c7b293;">
                <span class="icon-[tabler--device-floppy] mr-1"></span>{{ __('Lưu thay đổi') }}
            </button>
            @if (session('status') === 'profile-updated')
                <span class="text-xs text-green-400 flex items-center gap-1"><span class="icon-[tabler--check] text-green-400"></span>{{ __('Đã lưu') }}</span>
            @endif
        </div>
    </form>
</section>
