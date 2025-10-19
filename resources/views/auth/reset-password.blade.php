@extends('customer.layouts.app')

@section('title', __('Reset Password'))

@section('content')
<div class="container mx-auto my-16">
    <div class="max-w-md mx-auto">
        <div class="card border border-base-content/20 bg-white/5 text-white">
            <div class="card-body">
                <h1 class="card-title text-3xl">{{ __('Reset Password') }}</h1>

                <form method="POST" action="{{ route('password.store') }}" class="mt-4">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="form-control w-full">
                        <label for="email" class="label"><span class="label-text text-gray-300">{{ __('Email') }}</span></label>
                        <div class="relative">
                            <span class="icon-[tabler--mail] absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></span>
                            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" autocomplete="username" required autofocus
                                         class="input input-bordered w-full pl-10 bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
                        </div>
                        @error('email')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-control w-full mt-4">
                        <label for="password" class="label"><span class="label-text text-gray-300">{{ __('Password') }}</span></label>
                        <div class="relative">
                            <span class="icon-[tabler--lock] absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></span>
                            <input id="password" type="password" name="password" autocomplete="new-password" required
                                         class="input input-bordered w-full pl-10 bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
                        </div>
                        @error('password')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-control w-full mt-4">
                        <label for="password_confirmation" class="label"><span class="label-text text-gray-300">{{ __('Confirm Password') }}</span></label>
                        <div class="relative">
                            <span class="icon-[tabler--shield-lock] absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></span>
                            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required
                                         class="input input-bordered w-full pl-10 bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
                        </div>
                        @error('password_confirmation')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="btn w-full text-neutral-900" style="background-color:#c7b293;">{{ __('Reset Password') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
