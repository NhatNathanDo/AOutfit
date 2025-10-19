@extends('customer.layouts.app')

@section('title', __('Confirm Password'))

@section('content')
<div class="container mx-auto my-16">
    <div class="max-w-md mx-auto">
        <div class="card border border-base-content/20 bg-white/5 text-white">
            <div class="card-body">
                <h1 class="card-title text-3xl">{{ __('Confirm Password') }}</h1>
                <p class="text-sm text-gray-300">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>

                <form method="POST" action="{{ route('password.confirm') }}" class="mt-4">
                    @csrf
                    <div class="form-control w-full">
                        <label for="password" class="label"><span class="label-text text-gray-300">{{ __('Password') }}</span></label>
                        <div class="relative">
                            <span class="icon-[tabler--lock] absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></span>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                         class="input input-bordered w-full pl-10 bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
                        </div>
                        @error('password')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="btn text-neutral-900" style="background-color:#c7b293;">{{ __('Confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
