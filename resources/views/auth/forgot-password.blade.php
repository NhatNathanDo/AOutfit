@extends('customer.layouts.app')

@section('title', __('Forgot Password'))

@section('content')
<div class="container mx-auto my-16">
    <div class="max-w-md mx-auto">
        <div class="card border border-base-content/20 bg-white/5 text-white">
            <div class="card-body">
                <h1 class="card-title text-3xl">{{ __('Forgot your password?') }}</h1>
                <p class="text-sm text-gray-300">{{ __('No problem. Enter your email and we\'ll send you a reset link.') }}</p>

                @if (session('status'))
                    <div class="alert alert-success mt-4 text-sm">
                        <span class="icon-[tabler--check] mr-2"></span>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="mt-4">
                    @csrf
                    <div class="form-control w-full">
                        <label for="email" class="label"><span class="label-text text-gray-300">{{ __('Email') }}</span></label>
                        <div class="relative">
                            <span class="icon-[tabler--mail] absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                         class="input input-bordered w-full pl-10 bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
                        </div>
                        @error('email')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="btn w-full text-neutral-900" style="background-color:#c7b293;">{{ __('Email Password Reset Link') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
