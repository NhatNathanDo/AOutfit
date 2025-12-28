<section class="space-y-5">
    <div class="space-y-1">
        <h2 class="text-lg font-semibold tracking-wide text-red-400">{{ __('Xóa tài khoản') }}</h2>
        <p class="text-xs text-gray-400">{{ __('Hành động sẽ xóa vĩnh viễn toàn bộ dữ liệu. Sao lưu trước khi tiếp tục.') }}</p>
    </div>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn btn-error btn-outline h-10 px-6"
    ><span class="icon-[tabler--trash] mr-1"></span>{{ __('Xóa tài khoản') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-5">
            @csrf
            @method('delete')

            <h2 class="text-base font-semibold tracking-wide">{{ __('Xóa tài khoản vĩnh viễn?') }}</h2>
            <p class="text-xs text-gray-400 mt-1">{{ __('Nhập mật khẩu để xác nhận. Thao tác KHÔNG thể hoàn tác.') }}</p>

            <div class="form-control w-full">
                <label for="password" class="label">
                    <span class="label-text text-gray-300">{{ __('Mật khẩu') }}</span>
                </label>
                <input id="password" name="password" type="password" placeholder="********"
                       class="input input-bordered w-full bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
                @if ($errors->userDeletion->has('password'))
                    <p class="mt-2 text-sm text-red-400">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" x-on:click="$dispatch('close')" class="btn btn-ghost h-10 px-5 text-white">{{ __('Hủy') }}</button>
                <button type="submit" class="btn btn-error h-10 px-6"><span class="icon-[tabler--circle-x] mr-1"></span>{{ __('Xóa') }}</button>
            </div>
        </form>
    </x-modal>
</section>
