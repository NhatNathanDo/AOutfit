{{-- FAQ Section --}}
@php
    $tabs = $tabs ?? ['All', 'Ordering', 'Shipping', 'Returns', 'Support'];
    $activeTab = $activeTab ?? 'Shipping';
    $faqs = $faqs ?? [
        [
            'q' => 'How can I place an order on AOutfit?',
            'a' => 'Ordering is easy! Browse products, add to cart, and proceed to checkout. Follow the prompts to enter your details and complete the purchase.'
        ],
        [
            'q' => 'Can I modify or cancel my order after placing it?',
            'a' => 'Once an order is confirmed, changes or cancellations may not be possible. Please review your order carefully before completing checkout.'
        ],
        [
            'q' => 'What payment methods do you accept?',
            'a' => 'We accept major credit/debit cards and select digital wallets. Choose the payment option that suits you best during checkout.'
        ],
        [
            'q' => 'How do I initiate a return?',
            'a' => 'Visit our Returns page and follow the instructions. Ensure your item meets our return criteria; our team will guide you through the process.'
        ],
        [
            'q' => 'How can I track my order?',
            'a' => 'After dispatch, you’ll receive a tracking number via email. Use it to track your package in real time on our website.'
        ],
        [
            'q' => 'Do you offer exchanges for products?',
            'a' => 'At this time, we do not offer direct product exchanges. If you’d like a different item, please initiate a return and place a new order.'
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
                HAVE QUESTIONS? WE HAVE ANSWERS.
            </h2>
            <p class="mt-2 text-base text-white/70">Ease into the world of AOutfit with clarity. Our FAQs cover a spectrum of topics.</p>
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

        {{-- FAQ grid --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 rounded-xl overflow-hidden border border-dashed border-white/20">
            @foreach ($faqs as $i => $item)
                <div class="p-6 md:p-8 {{ $i % 2 !== 0 ? 'md:border-l' : '' }} {{ $i >= 2 ? 'border-t' : '' }} border-dashed border-white/20">
                    <h3 class="text-base md:text-lg font-semibold">{{ $item['q'] }}</h3>
                    <p class="mt-2 text-sm text-white/70">{{ $item['a'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
