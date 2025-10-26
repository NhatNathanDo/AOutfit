{{-- Featured Products Section --}}
@php
    // Allow passing $products from controller; otherwise, use sample data for layout/demo.
    $products = $products ?? [
        [
            'id' => 1,
            'category' => 'Womenswear',
            'title' => 'Timeless A-line Evening Dress',
            'fit' => 'Ankle-length',
            'price' => 109.99,
            'image' => 'https://images.unsplash.com/photo-1582582494700-66d6a8f9a89e?q=80&w=1600&auto=format&fit=crop',
        ],
        [
            'id' => 2,
            'category' => 'Womenswear',
            'title' => 'Floral Bloom Maxi Dress',
            'fit' => 'Slim Fit',
            'price' => 54.99,
            'image' => 'https://images.unsplash.com/photo-1549243139-3f10d27b1308?q=80&w=1600&auto=format&fit=crop',
        ],
        [
            'id' => 3,
            'category' => 'Womenswear',
            'title' => 'Elegant Evening Gown',
            'fit' => 'Flowing skirt',
            'price' => 89.99,
            'image' => 'https://images.unsplash.com/photo-1542219550-37153d387c32?q=80&w=1600&auto=format&fit=crop',
        ],
        [
            'id' => 4,
            'category' => 'Accessories',
            'title' => 'Urban Chic Handbag',
            'fit' => 'Spacious',
            'price' => 49.99,
            'image' => 'https://images.unsplash.com/photo-1617038260897-41c1a02aa8a3?q=80&w=1600&auto=format&fit=crop',
        ],
        [
            'id' => 5,
            'category' => 'Accessories',
            'title' => 'Sophisticate Sun Hat',
            'fit' => 'One size fits all',
            'price' => 24.99,
            'image' => 'https://images.unsplash.com/photo-1610276198568-eb6d0ff53e48?q=80&w=1600&auto=format&fit=crop',
        ],
        [
            'id' => 6,
            'category' => 'Womenswear',
            'title' => 'Boho Chic Printed Scarf',
            'fit' => 'Lightweight',
            'price' => 19.99,
            'image' => 'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?q=80&w=1600&auto=format&fit=crop',
        ],
    ];

    $tabs = $tabs ?? ['All', 'Mens', 'Womens', 'Kids'];
    $activeTab = $activeTab ?? 'Womens';
@endphp

<section id="shop" class="relative w-full text-white container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="relative w-full border border-dashed border-white/20 bg-black/90 p-5 md:p-9 lg:p-10 rounded-[20px]">
        {{-- Decorative burst (top-right) --}}
        <div class="pointer-events-none absolute -right-1 -top-1 hidden md:block" aria-hidden="true">
            <div class="w-24 h-24 rotate-12 bg-white/10 rounded-tr-[20px] clip-path-[polygon(100%_0,100%_100%,0_100%)]"></div>
        </div>

        {{-- Heading --}}
        <header>
            <h2 class="text-3xl md:text-4xl lg:text-[34px] leading-tight font-extrabold tracking-tight">
                ELEVATE YOUR STYLE WITH OUR LATEST COLLECTION
            </h2>
            <p class="mt-2 text-base text-white/70">Each piece is crafted to enhance your fashion statement.</p>
        </header>

        {{-- Tabs --}}
        <div class="mt-6 flex flex-wrap items-center gap-2 text-sm">
            @foreach ($tabs as $tab)
                @php $isActive = strtolower($tab) === strtolower($activeTab); @endphp
                <a href="#" class="inline-flex items-center gap-2 rounded-field border border-dashed px-4 py-1.5 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-white/50 {{ $isActive ? 'bg-white text-black border-white' : 'bg-transparent text-white border-white/30 hover:bg-white/10' }}">
                    {{ $tab }}
                </a>
            @endforeach
        </div>

        {{-- Products grid --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($products as $product)
                <article class="group rounded-2xl border border-dashed border-white/20 bg-white/[0.03] p-3">
                    {{-- Card header: tags & CTA --}}
                    <div class="mb-3 flex items-center justify-between gap-2">
                        <span class="inline-flex items-center rounded-full border border-dashed border-white/25 bg-white/5 px-3 py-1 text-xs text-white/80">
                            {{ $product['category'] }}
                        </span>
                        <a href="#" class="inline-flex items-center gap-1 rounded-field border border-dashed border-white/30 bg-transparent px-3 py-1.5 text-xs font-medium text-white/90 transition hover:bg-white hover:text-black">
                            <span>Shop Now</span>
                            <i class="icon-[tabler--arrow-up-right] text-sm"></i>
                        </a>
                    </div>

                    {{-- Image --}}
                    <figure class="overflow-hidden rounded-[16px] border border-dashed border-white/15">
                        <div class="aspect-[4/3] w-full">
                            <img src="{{ $product['image'] }}" alt="{{ $product['title'] }}" loading="lazy" class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.02]" />
                        </div>
                    </figure>

                    {{-- Content --}}
                    <div class="pt-4">
                        <h3 class="text-base md:text-lg font-semibold">{{ $product['title'] }}</h3>
                        <div class="mt-2 text-sm text-white/70">
                            <span class="mr-4">Fit: <span class="italic">{{ $product['fit'] }}</span></span>
                            <span>Price: <span class="font-semibold">${{ number_format($product['price'], 2) }}</span></span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
