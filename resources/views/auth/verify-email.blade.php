@extends('customer.layouts.app')

@section('title', __('Verify Email'))

@section('content')
<div class="container mx-auto my-16">
    <div class="max-w-lg mx-auto">
        <div class="card border border-base-content/20 bg-white/5 text-white">
            <div class="card-body">
                <h1 class="card-title text-3xl">{{ __('Verify Email') }}</h1>
                <div class="alert alert-info text-sm mt-2">
                    <span class="icon-[tabler--info-circle] mr-2"></span>
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success text-sm mt-4">
                        <span class="icon-[tabler--check] mr-2"></span>
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <div class="mt-6 flex items-center justify-between">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn text-neutral-900" style="background-color:#c7b293;">{{ __('Resend Verification Email') }}</button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-ghost text-white">{{ __('Log Out') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
