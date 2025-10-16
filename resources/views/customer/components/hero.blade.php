{{-- Hero Section --}}
<section class="relative w-full text-white container mx-auto px-4 sm:px-6 lg:px-8">
	{{-- Top banner image --}}
	<figure class="relative h-[290px] md:h-[430px] lg:h-[450px] w-full">
		<img src="https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?q=80&w=2068&auto=format&fit=crop"
			alt="Woman in dotted dress styling in sunlight" class="absolute inset-0 h-full w-full object-cover"
			loading="eager" />

		{{-- Floating CTA --}}
		<div class="absolute -bottom-6 left-1/2 -translate-x-1/2 z-20">
			<a href="{{ url('/') }}#shop"
				class="inline-flex items-center gap-2 rounded-field border border-dashed border-white/30 bg-black/80 backdrop-blur-md px-6 py-3 text-sm font-semibold shadow-lg transition hover:bg-white hover:text-black focus:outline-none focus-visible:ring-2 focus-visible:ring-white/50">
				<span>Shop Now</span>
				<span class="icon-[tabler--arrow-up-right] text-lg"></span>
			</a>
		</div>

	</figure>
	<div class="relative px-4 pb-10 sm:px-6 lg:px-8 w-full border border-dashed border-white/20 bg-black/90 p-5 md:p-9 lg:p-10">
		{{-- Category pills --}}
		<div class="mb-6 flex flex-wrap items-center gap-2 text-sm text-white/80">
			@php $tabs = ['All', 'Mens', 'Womens', 'Kids']; @endphp
			@foreach($tabs as $i => $tab)
				<a href="#"
					class="btn btn-outline btn-lg text-sm border-dashed px-4 py-1.5 transition hover:bg-white/13 text-white">{{ $tab }}</a>
			@endforeach
		</div>

		<div class="grid grid-cols-1 gap-y-8 lg:grid-cols-12 lg:gap-0">
			{{-- Left: headline & blurb --}}
			<div class="lg:col-span-5 pr-0 lg:pr-10">
				<h1 class="text-3xl md:text-4xl lg:text-[34px] leading-tight font-extrabold tracking-tight">
					ELEVATE YOUR STYLE WITH
					<span class="block mt-1 text-4xl md:text-5xl lg:text-6xl font-black tracking-tighter">AOUTFIT</span>
				</h1>
				<p class="mt-4 max-w-xl text-base text-white/70">
					Explore a world of fashion at AOutfit, where trends meet affordability. Immerse yourself in the
					latest styles and seize exclusive promotions.
				</p>
			</div>

			{{-- Right: stats grid --}}
			<div class="lg:col-span-7 lg:pl-10 lg:border-l lg:border-dashed lg:border-white/20">
				<div class="grid grid-cols-2 rounded-xl overflow-hidden border border-dashed border-white/20">
					{{-- Card 1 --}}
					<div class="p-6 md:p-8">
						<div class="text-4xl md:text-5xl font-extrabold">1,500<span class="align-super text-xl">+</span>
						</div>
						<div class="mt-2 text-xs uppercase tracking-wide text-white/60">Fashion Products</div>
					</div>
					{{-- Card 2 --}}
					<div class="p-6 md:p-8 border-l border-dashed border-white/20">
						<div class="text-4xl md:text-5xl font-extrabold">50<span class="align-super text-xl">+</span>
						</div>
						<div class="mt-2 text-xs uppercase tracking-wide text-white/60">New arrivals every month.</div>
					</div>
					{{-- Card 3 --}}
					<div class="p-6 md:p-8 border-t border-dashed border-white/20">
						<div class="text-4xl md:text-5xl font-extrabold">30<span class="align-super text-xl">%</span>
						</div>
						<div class="mt-2 text-xs uppercase tracking-wide text-white/60">OFF on select items.</div>
					</div>
					{{-- Card 4 --}}
					<div class="p-6 md:p-8 border-t border-l border-dashed border-white/20">
						<div class="text-4xl md:text-5xl font-extrabold">95<span class="align-super text-xl">%</span>
						</div>
						<div class="mt-2 text-xs uppercase tracking-wide text-white/60">Customer Satisfaction Rate</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>