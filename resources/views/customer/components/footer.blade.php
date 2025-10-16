{{-- Footer Section --}}
@php
    $categories = $categories ?? [
        'Tank Top', 'T‑Shirt', 'Long‑Sleeve T‑Shirt', 'Raglan Sleeve Shirt', 'Crop Top', 'V‑Neck Shirt', 'Muscle Shirt'
    ];
@endphp

<footer class="relative w-full text-white container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="relative w-full border border-dashed border-white/20 bg-black/90 rounded-[20px] overflow-hidden">
        {{-- Top ticker --}}
        <div class="border-b border-dashed border-white/10">
            <div class="flex items-center gap-6 overflow-x-auto whitespace-nowrap px-4 py-3 text-xs tracking-wider text-white/60">
                @foreach ($categories as $i => $c)
                    @if ($i !== 0)
                        <span class="inline-flex items-center justify-center text-[10px] text-amber-300/80">•</span>
                    @endif
                    <span class="uppercase">{{ strtoupper($c) }}</span>
                @endforeach
            </div>
        </div>

        {{-- Brand row --}}
        <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-6 px-6 md:px-9 lg:px-10 py-10">
            <div>
                <div class="text-[44px] md:text-6xl font-extrabold tracking-tight">
                    <span>{{ config('app.name', 'AOutfit') }}</span>
                </div>
            </div>
            <div class="md:justify-self-end">
                <div class="flex items-center gap-3">
                    @php $socials = [
                        ['icon' => 'icon-[tabler--brand-instagram]','label' => 'Instagram'],
                        ['icon' => 'icon-[tabler--brand-dribbble]','label' => 'Dribbble'],
                        ['icon' => 'icon-[tabler--brand-twitter]','label' => 'Twitter'],
                        ['icon' => 'icon-[tabler--brand-behance]','label' => 'Behance'],
                    ]; @endphp
                    @foreach ($socials as $s)
                        <a href="#" class="inline-flex h-10 w-10 items-center justify-center rounded-md border border-dashed border-white/20 bg-white/10 hover:bg-white/20" aria-label="{{ $s['label'] }}">
                            <i class="{{ $s['icon'] }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Links + newsletter --}}
        <div class="border-t border-dashed border-white/10 px-6 md:px-9 lg:px-10 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="text-sm font-semibold mb-3">Home</div>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li><a href="#" class="hover:text-white">Why Us</a></li>
                        <li><a href="#" class="hover:text-white">About Us</a></li>
                        <li><a href="#" class="hover:text-white">Testimonials</a></li>
                        <li><a href="#" class="hover:text-white">FAQ’s</a></li>
                    </ul>
                </div>
                <div>
                    <div class="text-sm font-semibold mb-3">Products</div>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li><a href="#" class="hover:text-white">Menswear</a></li>
                        <li><a href="#" class="hover:text-white">Womenswear</a></li>
                        <li><a href="#" class="hover:text-white">Kidswear</a></li>
                    </ul>
                </div>
                <div>
                    <div class="text-sm font-semibold mb-3">Subscribe to Newsletter</div>
                    <form action="#" method="post" onsubmit="return false" class="max-w-md">
                        <div class="flex items-stretch rounded-field border border-dashed border-white/20 overflow-hidden">
                            <input type="email" placeholder="Your Email" class="w-full bg-transparent px-3 py-2 text-sm placeholder:text-white/50 focus:outline-none" />
                            <button type="button" class="px-3 bg-white/10 hover:bg-white/20 text-white">
                                <i class="icon-[tabler--arrow-right]"></i>
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-white/50">Get style tips, drops, and promotions. No spam.</p>
                    </form>
                </div>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-dashed border-white/10 px-6 md:px-9 lg:px-10 py-6 text-xs text-white/60 flex flex-col md:flex-row items-center justify-between gap-3">
            <div>© {{ now()->year }} {{ config('app.name', 'AOutfit') }}. All rights reserved.</div>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-white">Terms & Conditions</a>
                <span class="opacity-40">|</span>
                <a href="#" class="hover:text-white">Privacy Policy</a>
            </div>
        </div>
    </div>
</footer>
