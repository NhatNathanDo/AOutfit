{{-- Testimonials Section --}}
@php
    $testimonials = $testimonials ?? [
        [
            'name' => 'Sarah Thompson',
            'location' => 'New York, USA',
            'rating' => 5,
            'avatar' => 'https://images.unsplash.com/photo-1544006659-f0b21884ce1d?q=80&w=240&h=240&auto=format&fit=crop',
            'text' => "AOutfit exceeded my expectations. The gown's quality and design made me feel like a queen. Fast shipping, too!",
        ],
        [
            'name' => 'Rajesh Patel',
            'location' => 'Mumbai, India',
            'rating' => 5,
            'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=240&h=240&auto=format&fit=crop',
            'text' => 'Absolutely love the style and warmth of the jacket. A perfect blend of fashion and functionality!',
        ],
        [
            'name' => 'Emily Walker',
            'location' => 'London, UK',
            'rating' => 5,
            'avatar' => 'https://images.unsplash.com/photo-1541214113241-185780a6cbe1?q=80&w=240&h=240&auto=format&fit=crop',
            'text' => 'Adorable and comfortable! My daughter loves her new outfit. Thank you, AOutfit, for dressing our little fashionista.',
        ],
        [
            'name' => 'Alejandro Martinez',
            'location' => 'Barcelona, Spain',
            'rating' => 5,
            'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=240&h=240&auto=format&fit=crop',
            'text' => "Impressed by the quality and style. These shoes turned heads at every event. AOutfit.com, you've gained a loyal customer!",
        ],
        [
            'name' => 'Priya Sharma',
            'location' => 'Delhi, India',
            'rating' => 5,
            'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=240&h=240&auto=format&fit=crop',
            'text' => 'Perfect fit and exceptional quality. These jeans have become my go-to for casual and chic outings.',
        ],
        [
            'name' => 'Maria Rodriguez',
            'location' => 'Mexico City, Mexico',
            'rating' => 5,
            'avatar' => 'https://images.unsplash.com/photo-1547425260-76bcadfb4f2c?q=80&w=240&h=240&auto=format&fit=crop',
            'text' => 'Stylish sneakers that don’t compromise on comfort. AOutfit knows how to balance fashion and functionality.',
        ],
    ];
@endphp

<section class="relative w-full text-white container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="relative w-full border border-dashed border-white/20 bg-black/90 p-5 md:p-9 lg:p-10 rounded-[20px]">
        {{-- Decorative burst (top-right) --}}
        <div class="pointer-events-none absolute -right-1 -top-1 hidden md:block" aria-hidden="true">
            <div class="w-24 h-24 rotate-12 bg-white/10 rounded-tr-[20px] clip-path-[polygon(100%_0,100%_100%,0_100%)]"></div>
        </div>

        {{-- Heading --}}
        <header class="max-w-4xl">
            <h2 class="text-3xl md:text-4xl lg:text-[34px] leading-tight font-extrabold tracking-tight">
                THE AOUTFIT TESTIMONIAL COLLECTION.
            </h2>
            <p class="mt-2 text-base text-white/70">At AOutfit, our customers are the heartbeat of our brand.</p>
        </header>

        {{-- Testimonials grid --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 rounded-xl overflow-hidden border border-dashed border-white/20">
            @foreach ($testimonials as $i => $t)
                <div class="p-6 md:p-8 {{ $i % 3 !== 0 ? 'md:border-l' : '' }} {{ $i >= 3 ? 'border-t' : '' }} border-dashed border-white/20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="{{ $t['avatar'] }}" alt="{{ $t['name'] }}" class="h-10 w-10 rounded-full object-cover border border-white/20" />
                            <div>
                                <div class="font-semibold">{{ $t['name'] }}</div>
                                <div class="text-xs text-white/60">{{ $t['location'] }}</div>
                            </div>
                        </div>
                        <i class="icon-[tabler--brand-twitter] text-white/40"></i>
                    </div>

                    {{-- Stars --}}
                    <div class="mt-4 text-amber-400">
                        @for ($s = 0; $s < $t['rating']; $s++)
                            <i class="icon-[tabler--star-filled]"></i>
                        @endfor
                    </div>

                    <p class="mt-3 text-sm text-white/75">{{ $t['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
