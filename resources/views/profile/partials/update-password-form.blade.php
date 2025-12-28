<section class="space-y-5">
    <div class="space-y-1">
        <h2 class="text-lg font-semibold tracking-wide">{{ __('Đổi mật khẩu') }}</h2>
        <p class="text-xs text-gray-400">{{ __('Hãy sử dụng mật khẩu mạnh và duy nhất cho tài khoản của bạn.') }}</p>
    </div>

    @if (session('status') === 'password-updated')
        <div class="alert alert-success text-sm">
            <span class="icon-[tabler--check] mr-2"></span>
            {{ __('Mật khẩu đã được cập nhật.') }}
        </div>
    @endif

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="form-control w-full">
            <label for="update_password_current_password" class="label">
                <span class="label-text text-gray-300">{{ __('Mật khẩu hiện tại') }}</span>
            </label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                   class="input input-bordered w-full bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
            @if ($errors->updatePassword->has('current_password'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div class="form-control w-full">
            <label for="update_password_password" class="label">
                <span class="label-text text-gray-300">{{ __('Mật khẩu mới') }}</span>
            </label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                   class="input input-bordered w-full bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
            @if ($errors->updatePassword->has('password'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div class="form-control w-full">
            <label for="update_password_password_confirmation" class="label">
                <span class="label-text text-gray-300">{{ __('Xác nhận mật khẩu') }}</span>
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                   class="input input-bordered w-full bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
            @if ($errors->updatePassword->has('password_confirmation'))
                <p class="mt-2 text-sm text-red-400">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="pt-1">
            <button type="submit" class="btn h-10 px-6 text-neutral-900" style="background-color:#c7b293;">
                <span class="icon-[tabler--device-floppy] mr-1"></span>{{ __('Lưu thay đổi') }}
            </button>
        </div>
    </form>
</section>
