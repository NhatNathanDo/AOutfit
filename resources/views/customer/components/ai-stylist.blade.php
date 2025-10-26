{{-- AI Stylist (UI only) --}}
@php
    $samples = $samples ?? [
        [
            'title' => 'Minimalist Monochrome',
            'category' => 'Womenswear',
            'fit' => 'Slim fit blazer',
            'price' => 129.99,
            'image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1600&auto=format&fit=crop',
        ],
        [
            'title' => 'Weekend Casual',
            'category' => 'Menswear',
            'fit' => 'Denim jacket + tee',
            'price' => 89.99,
            'image' => 'https://images.unsplash.com/photo-1503342452485-86ff0a4b0674?q=80&w=1600&auto=format&fit=crop',
        ],
        [
            'title' => 'Summer Breeze',
            'category' => 'Womenswear',
            'fit' => 'Linen dress',
            'price' => 74.50,
            'image' => 'https://images.unsplash.com/photo-1520975682031-137a6c5a7831?q=80&w=1600&auto=format&fit=crop',
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
        <header class="flex items-start justify-between gap-4 flex-wrap">
            <div class="max-w-3xl">
                <h2 class="text-3xl md:text-4xl lg:text-[34px] leading-tight font-extrabold tracking-tight">
                    AI‑POWERED OUTFIT STYLIST
                </h2>
                <p class="mt-2 text-base text-white/70">Upload a face photo to get personalized outfit recommendations tailored to your vibe. UI preview only — feature coming soon.</p>
            </div>
            <span class="inline-flex items-center gap-2 rounded-full border border-dashed border-white/25 bg-white/10 px-3 py-1 text-xs text-white/80">Coming soon</span>
        </header>

        {{-- Layout --}}
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Left: upload box (UI only) --}}
            <div class="lg:col-span-5">
                <div class="group relative rounded-2xl border border-dashed border-white/25 bg-white/[0.03] p-5">
                    <div class="aspect-[4/3] w-full rounded-xl border border-dashed border-white/15 flex items-center justify-center text-center px-6">
                        <div>
                            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-white/10">
                                <i class="icon-[tabler--cloud-upload] text-xl"></i>
                            </div>
                            <p class="text-sm">Drag & drop your face photo here</p>
                            <p class="text-xs text-white/60">JPG, PNG, or WEBP — up to 4MB</p>
                            <div class="mt-4">
                                <label class="inline-flex cursor-pointer items-center gap-2 rounded-field border border-dashed border-white/30 bg-transparent px-4 py-2 text-sm transition hover:bg-white hover:text-black">
                                    <input type="file" accept="image/*" class="hidden" />
                                    <i class="icon-[tabler--photo]"></i>
                                    <span>Choose a photo</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <div class="text-xs text-white/60">Your photo stays on your device in this preview.</div>
                        <button type="button" disabled class="inline-flex items-center gap-2 rounded-field border border-dashed border-white/30 bg-white/5 px-4 py-2 text-sm text-white/80">
                            <i class="icon-[tabler--sparkles]"></i>
                            <span>Get recommendations</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Right: sample recommendations --}}
            <div class="lg:col-span-7">
                <div class="rounded-xl overflow-hidden border border-dashed border-white/20">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-6">
                        @foreach ($samples as $item)
                            <article class="group rounded-2xl border border-dashed border-white/20 bg-white/[0.03] p-3">
                                <div class="mb-3 flex items-center justify-between gap-2">
                                    <span class="inline-flex items-center rounded-full border border-dashed border-white/25 bg-white/5 px-3 py-1 text-xs text-white/80">{{ $item['category'] }}</span>
                                    <span class="inline-flex items-center gap-1 rounded-field border border-dashed border-white/30 bg-transparent px-3 py-1.5 text-xs text-white/80">
                                        <i class="icon-[tabler--sparkles]"></i> AI pick
                                    </span>
                                </div>
                                <figure class="overflow-hidden rounded-[16px] border border-dashed border-white/15">
                                    <div class="aspect-[4/3] w-full">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-full w-full object-cover" loading="lazy" />
                                    </div>
                                </figure>
                                <div class="pt-4">
                                    <h3 class="text-base md:text-lg font-semibold">{{ $item['title'] }}</h3>
                                    <div class="mt-2 text-sm text-white/70">
                                        <span class="mr-4">Fit: <span class="italic">{{ $item['fit'] }}</span></span>
                                        <span>Price: <span class="font-semibold">${{ number_format($item['price'], 2) }}</span></span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
