@extends('customer.layouts.app')

@section('content')
<div class="min-h-screen bg-black text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold">Thanh toán</h1>
            <p class="text-neutral-400 mt-2">Hoàn tất đơn hàng của bạn</p>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @csrf
            
            <!-- Left Column: Shipping Info -->
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-neutral-900/50 rounded-3xl p-6 border border-white/10">
                    <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <span class="icon-[tabler--truck-delivery] size-6"></span>
                        Thông tin giao hàng
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-400 mb-1">Họ và tên</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                                class="w-full bg-neutral-800 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-[#c7b293] focus:ring-1 focus:ring-[#c7b293] transition"
                                placeholder="Nhập họ tên người nhận" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-neutral-400 mb-1">Số điện thoại</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" 
                                    class="w-full bg-neutral-800 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-[#c7b293] focus:ring-1 focus:ring-[#c7b293] transition"
                                    placeholder="Nhập số điện thoại" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-neutral-400 mb-1">Email</label>
                                <input type="email" value="{{ Auth::user()->email }}" disabled
                                    class="w-full bg-neutral-800/50 border border-white/5 rounded-xl px-4 py-3 text-neutral-500 cursor-not-allowed">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-400 mb-1">Địa chỉ nhận hàng</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4" x-data="addressSelector()">
                                <!-- Province -->
                                <div>
                                    <select name="province" x-model="province" @change="fetchDistricts()" class="w-full bg-neutral-800 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-[#c7b293] focus:ring-1 focus:ring-[#c7b293] transition appearance-none" required>
                                        <option value="">Chọn Tỉnh/Thành</option>
                                        <template x-for="p in provinces" :key="p.code">
                                            <option :value="p.name" x-text="p.name" :data-code="p.code"></option>
                                        </template>
                                    </select>
                                </div>
                                <!-- District -->
                                <div>
                                    <select name="district" x-model="district" @change="fetchWards()" class="w-full bg-neutral-800 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-[#c7b293] focus:ring-1 focus:ring-[#c7b293] transition appearance-none" :disabled="!province" required>
                                        <option value="">Chọn Quận/Huyện</option>
                                        <template x-for="d in districts" :key="d.code">
                                            <option :value="d.name" x-text="d.name" :data-code="d.code"></option>
                                        </template>
                                    </select>
                                </div>
                                <!-- Ward -->
                                <div>
                                    <select name="ward" x-model="ward" class="w-full bg-neutral-800 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-[#c7b293] focus:ring-1 focus:ring-[#c7b293] transition appearance-none" :disabled="!district" required>
                                        <option value="">Chọn Phường/Xã</option>
                                        <template x-for="w in wards" :key="w.code">
                                            <option :value="w.name" x-text="w.name"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                            <input type="text" name="street" value="{{ old('street') }}" 
                                class="w-full bg-neutral-800 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-[#c7b293] focus:ring-1 focus:ring-[#c7b293] transition"
                                placeholder="Số nhà, tên đường" required>
                        </div>
                    </div>
                </div>

                <script>
                    function addressSelector() {
                        return {
                            provinces: [],
                            districts: [],
                            wards: [],
                            province: '',
                            district: '',
                            ward: '',
                            init() {
                                fetch('https://provinces.open-api.vn/api/?depth=1')
                                    .then(res => res.json())
                                    .then(data => this.provinces = data)
                                    .catch(err => console.error(err));
                            },
                            fetchDistricts() {
                                this.districts = [];
                                this.wards = [];
                                this.district = '';
                                this.ward = '';
                                const pCode = this.$el.querySelector(`option[value='${this.province}']`)?.dataset.code;
                                if (pCode) {
                                    fetch(`https://provinces.open-api.vn/api/p/${pCode}?depth=2`)
                                        .then(res => res.json())
                                        .then(data => this.districts = data.districts)
                                        .catch(err => console.error(err));
                                }
                            },
                            fetchWards() {
                                this.wards = [];
                                this.ward = '';
                                const dCode = this.$el.querySelector(`option[value='${this.district}']`)?.dataset.code;
                                if (dCode) {
                                    fetch(`https://provinces.open-api.vn/api/d/${dCode}?depth=2`)
                                        .then(res => res.json())
                                        .then(data => this.wards = data.wards)
                                        .catch(err => console.error(err));
                                }
                            }
                        }
                    }
                </script>

                <div class="bg-neutral-900/50 rounded-3xl p-6 border border-white/10">
                    <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <span class="icon-[tabler--credit-card] size-6"></span>
                        Phương thức thanh toán
                    </h2>

                    <div class="space-y-3">
                        <!-- COD Option -->
                        <label class="relative flex items-start p-4 rounded-xl border cursor-pointer transition-all group hover:bg-neutral-800/50
                            {{ old('payment_method', 'cod') == 'cod' ? 'border-[#c7b293] bg-neutral-800/30' : 'border-white/10 bg-neutral-900/30' }}">
                            <div class="flex items-center h-5">
                                <input type="radio" name="payment_method" value="cod" 
                                    {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}
                                    class="w-4 h-4 text-[#c7b293] border-white/30 focus:ring-[#c7b293] bg-transparent"
                                    onchange="this.form.querySelectorAll('label').forEach(l => l.classList.remove('border-[#c7b293]', 'bg-neutral-800/30')); this.closest('label').classList.add('border-[#c7b293]', 'bg-neutral-800/30')">
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="block text-sm font-medium text-white">Thanh toán khi nhận hàng (COD)</span>
                                    <span class="icon-[tabler--cash] size-6 text-[#c7b293]"></span>
                                </div>
                                <p class="mt-1 text-sm text-neutral-400">Thanh toán bằng tiền mặt khi đơn hàng được giao đến địa chỉ của bạn.</p>
                            </div>
                        </label>

                        <!-- Banking Option (Placeholder) -->
                        <label class="relative flex items-start p-4 rounded-xl border cursor-pointer transition-all group hover:bg-neutral-800/50
                            {{ old('payment_method') == 'banking' ? 'border-[#c7b293] bg-neutral-800/30' : 'border-white/10 bg-neutral-900/30' }}">
                            <div class="flex items-center h-5">
                                <input type="radio" name="payment_method" value="banking" 
                                    {{ old('payment_method') == 'banking' ? 'checked' : '' }}
                                    class="w-4 h-4 text-[#c7b293] border-white/30 focus:ring-[#c7b293] bg-transparent"
                                    onchange="this.form.querySelectorAll('label').forEach(l => l.classList.remove('border-[#c7b293]', 'bg-neutral-800/30')); this.closest('label').classList.add('border-[#c7b293]', 'bg-neutral-800/30')">
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="block text-sm font-medium text-white">Chuyển khoản ngân hàng</span>
                                    <span class="icon-[tabler--building-bank] size-6 text-neutral-400"></span>
                                </div>
                                <p class="mt-1 text-sm text-neutral-400">Chuyển khoản qua QR Code hoặc số tài khoản ngân hàng.</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="lg:col-span-5">
                <div class="sticky top-24 bg-neutral-900/50 rounded-3xl p-6 border border-white/10">
                    <h2 class="text-xl font-semibold mb-4">Đơn hàng của bạn</h2>
                    
                    <div class="space-y-4 mb-6 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cartData['items'] as $item)
                            <div class="flex gap-4 py-2">
                                <div class="relative size-16 rounded-lg overflow-hidden bg-neutral-800 flex-shrink-0 border border-white/5">
                                    @if($item['image'])
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full grid place-items-center text-white/20">
                                            <span class="icon-[tabler--photo] size-6"></span>
                                        </div>
                                    @endif
                                    <span class="absolute bottom-0 right-0 bg-neutral-900/90 text-white text-[10px] px-1.5 py-0.5 rounded-tl-md border-t border-l border-white/10">x{{ $item['quantity'] }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-medium text-white truncate">{{ $item['name'] }}</h3>
                                    <p class="text-xs text-neutral-400 mt-0.5">Đơn giá: {{ number_format($item['price'], 0, ',', '.') }}₫</p>
                                </div>
                                <div class="text-sm font-semibold text-white">
                                    {{ number_format($item['subtotal'], 0, ',', '.') }}₫
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-white/10 pt-4 space-y-2">
                        <div class="flex justify-between text-sm text-neutral-400">
                            <span>Tạm tính</span>
                            <span>{{ number_format($cartData['total'], 0, ',', '.') }}₫</span>
                        </div>
                        <div class="flex justify-between text-sm text-neutral-400">
                            <span>Phí vận chuyển</span>
                            <span class="text-[#c7b293]">Miễn phí</span>
                        </div>
                        <div class="flex justify-between text-base font-bold text-white pt-2 border-t border-white/10 mt-2">
                            <span>Tổng cộng</span>
                            <span class="text-[#c7b293] text-xl">{{ number_format($cartData['total'], 0, ',', '.') }}₫</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-6 btn btn-primary rounded-full h-12 text-base font-bold bg-[#c7b293] hover:bg-[#b39f82] text-black border-none">
                        Đặt hàng ngay
                    </button>
                    
                    <p class="text-xs text-center text-neutral-500 mt-4">
                        Bằng việc đặt hàng, bạn đồng ý với <a href="#" class="underline hover:text-white">Điều khoản dịch vụ</a> của chúng tôi.
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
