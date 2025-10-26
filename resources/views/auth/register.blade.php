@extends('customer.layouts.app')

@section('title', __('Register'))

@section('content')
<div class="container mx-auto my-16">
    <div class="mx-auto w-full max-w-5xl">
        <div class="card border border-base-content/20 bg-white/5 text-white">
            <div class="card-body p-0">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <!-- Left: Selling points -->
                    <div class="p-8 md:p-10 border-b md:border-b-0 md:border-r border-base-content/10 flex flex-col justify-center gap-4 bg-gradient-to-b from-black to-black/50">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold">{{ __('Create your account') }}</h1>
                            <p class="mt-2 text-gray-300">{{ __('Join AOutfit for personalized recommendations and exclusive perks.') }}</p>
                        </div>
                        <ul class="space-y-3 text-gray-300">
                            <li class="flex items-start gap-3"><span class="icon-[tabler--stars] text-[#c7b293]"></span><span>{{ __('Exclusive member discounts') }}</span></li>
                            <li class="flex items-start gap-3"><span class="icon-[tabler--heart] text-[#c7b293]"></span><span>{{ __('Save your favorite outfits') }}</span></li>
                            <li class="flex items-start gap-3"><span class="icon-[tabler--bolt] text-[#c7b293]"></span><span>{{ __('AI-powered styling tips') }}</span></li>
                        </ul>
                    </div>

                    <!-- Right: Form -->
                    <div class="p-8 md:p-10">
                        <form method="POST" action="{{ route('register') }}" class="mt-2" x-data>
                            @csrf

                            <div class="form-control w-full">
                                <label for="name" class="label"><span class="label-text text-gray-300">{{ __('Name') }}</span></label>
                                <div class="relative">
                                    <span class="icon-[tabler--user] absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></span>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" required autofocus
                                                 class="input input-bordered w-full pl-10 bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
                                </div>
                                @error('name')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
                            </div>

                            <div class="form-control w-full mt-4">
                                <label for="email" class="label"><span class="label-text text-gray-300">{{ __('Email') }}</span></label>
                                <div class="relative">
                                    <span class="icon-[tabler--mail] absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></span>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required
                                                 class="input input-bordered w-full pl-10 bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
                                </div>
                                @error('email')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
                            </div>

                            <div class="form-control w-full mt-4">
                                <label for="password" class="label"><span class="label-text text-gray-300">{{ __('Password') }}</span></label>
                                <div class="relative">
                                    <span class="icon-[tabler--lock] absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></span>
                                    <input id="password" type="password" name="password" autocomplete="new-password" required
                                                 class="input input-bordered w-full pl-10 pr-12 bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
                                    <button type="button" class="btn btn-ghost btn-square absolute right-1 top-1/2 -translate-y-1/2" data-toggle-password="#password" aria-label="Toggle password visibility">
                                        <span class="icon-[tabler--eye] toggle-icon-show"></span>
                                        <span class="icon-[tabler--eye-off] hidden toggle-icon-hide"></span>
                                    </button>
                                </div>
                                <div class="mt-2">
                                    <div class="w-full bg-neutral-800 h-1 rounded">
                                        <div id="pwd-strength" class="h-1 rounded bg-red-500 w-1/6 transition-all"></div>
                                    </div>
                                    <p id="pwd-hint" class="mt-2 text-xs text-gray-400">{{ __('Use 8+ chars with a mix of letters, numbers, and symbols.') }}</p>
                                </div>
                                @error('password')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
                            </div>

                            <div class="form-control w-full mt-4">
                                <label for="password_confirmation" class="label"><span class="label-text text-gray-300">{{ __('Confirm Password') }}</span></label>
                                <div class="relative">
                                    <span class="icon-[tabler--shield-lock] absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></span>
                                    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required
                                                 class="input input-bordered w-full pl-10 pr-12 bg-black/50 border-neutral-700 text-white placeholder:text-gray-400 focus:border-neutral-400" />
                                    <button type="button" class="btn btn-ghost btn-square absolute right-1 top-1/2 -translate-y-1/2" data-toggle-password="#password_confirmation" aria-label="Toggle password visibility">
                                        <span class="icon-[tabler--eye] toggle-icon-show"></span>
                                        <span class="icon-[tabler--eye-off] hidden toggle-icon-hide"></span>
                                    </button>
                                </div>
                                @error('password_confirmation')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="btn w-full h-11 text-neutral-900" style="background-color:#c7b293;">{{ __('Register') }}</button>
                            </div>

                            <div class="divider my-6 text-gray-400">{{ __('or continue with') }}</div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <a href="#" class="btn btn-outline btn-secondary w-full">
                                    <span class="icon-[tabler--brand-google] mr-2"></span> Google
                                </a>
                                <a href="#" class="btn btn-outline btn-secondary w-full">
                                    <span class="icon-[tabler--brand-facebook] mr-2"></span> Facebook
                                </a>
                            </div>

                            <p class="mt-6 text-center text-sm text-gray-300">
                                {{ __('Already registered?') }}
                                <a href="{{ route('login') }}" class="font-medium text-white underline hover:opacity-80">{{ __('Log in') }}</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Password toggle (no external dependency) + strength meter
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

        const pwd = document.getElementById('password');
        const bar = document.getElementById('pwd-strength');
        const hint = document.getElementById('pwd-hint');
        const calcScore = (val) => {
            let score = 0;
            if (!val) return 0;
            if (val.length >= 8) score += 1;
            if (/[A-Z]/.test(val)) score += 1;
            if (/[a-z]/.test(val)) score += 1;
            if (/\d/.test(val)) score += 1;
            if (/[^A-Za-z0-9]/.test(val)) score += 1;
            return score; // 0..5
        };
        const updateBar = (score) => {
            const widths = ['0%', '20%', '40%', '60%', '80%', '100%'];
            const colors = ['bg-red-500','bg-red-500','bg-orange-500','bg-yellow-500','bg-lime-500','bg-green-500'];
            bar.className = `h-1 rounded ${colors[score]} transition-all`;
            bar.style.width = widths[score];
            if (hint){
                const labels = ['','Very weak','Weak','Okay','Good','Strong'];
                hint.textContent = labels[score] ? `${labels[score]} — Use 8+ chars with a mix of letters, numbers, and symbols.` : hint.textContent;
            }
        };
        if (pwd && bar){
            updateBar(calcScore(pwd.value));
            pwd.addEventListener('input', (e)=> updateBar(calcScore(e.target.value)) );
        }
    });
</script>
@endsection
