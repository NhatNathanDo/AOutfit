@extends('admin.layouts.app')

@section('content')
<div class="flex items-center justify-between">
	<h2 class="text-xl font-semibold">Thống kê</h2>
	<div class="text-sm opacity-70">Cập nhật: {{ now()->format('d/m/Y H:i') }}</div>
	</div>

	<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 mt-4">
		<div class="card bg-base-100">
			<div class="card-body">
				<div class="text-sm opacity-70">Users</div>
				<div class="text-2xl font-bold">{{ number_format($totalUsers) }}</div>
				<div class="text-xs opacity-60">New 7d: {{ number_format($newUsers7d) }}</div>
			</div>
		</div>
		<div class="card bg-base-100">
			<div class="card-body">
				<div class="text-sm opacity-70">Orders</div>
				<div class="text-2xl font-bold">{{ number_format($totalOrders) }}</div>
			</div>
		</div>
		<div class="card bg-base-100">
			<div class="card-body">
				<div class="text-sm opacity-70">Revenue</div>
				<div class="text-2xl font-bold">₫{{ number_format($totalRevenue, 0) }}</div>
			</div>
		</div>
		<div class="card bg-base-100">
			<div class="card-body">
				<div class="text-sm opacity-70">Products</div>
				<div class="text-2xl font-bold">{{ number_format($totalProducts) }}</div>
			</div>
		</div>
	</div>

	<div class="grid grid-cols-1 gap-4 lg:grid-cols-3 mt-6">
		<!-- Sales chart -->
		<div class="card bg-base-100 lg:col-span-2">
			<div class="card-body">
				<h3 class="card-title">Doanh thu</h3>
				<canvas id="salesChart" height="120"></canvas>
			</div>
		</div>
		<!-- Users chart -->
		<div class="card bg-base-100">
			<div class="card-body">
				<h3 class="card-title">New Users</h3>
				<canvas id="usersChart" height="120"></canvas>
			</div>
		</div>
	</div>

	<div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mt-6">
		<div class="card bg-base-100">
			<div class="card-body">
				<h3 class="card-title">Đơn hàng gần đây</h3>
				<div class="overflow-x-auto">
					<table class="table table-zebra">
						<thead>
							<tr>
								<th>Mã</th>
								<th>Ngày</th>
								<th>Trạng thái</th>
								<th class="text-right">Tổng</th>
							</tr>
						</thead>
						<tbody>
							@forelse($recentOrders as $o)
								<tr>
									<td class="font-mono text-xs">{{ $o->id }}</td>
									<td>{{ optional($o->created_at)->format('d/m/Y H:i') }}</td>
									<td>
										<span class="badge badge-sm">{{ $o->status }}</span>
									</td>
									<td class="text-right">₫{{ number_format($o->total_amount, 0) }}</td>
								</tr>
							@empty
								<tr><td colspan="4" class="text-center opacity-60">Chưa có đơn hàng</td></tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="card bg-base-100">
			<div class="card-body">
				<h3 class="card-title">Sản phẩm bán chạy</h3>
				<ul class="space-y-2">
					@forelse($topProducts as $tp)
						<li class="flex items-center justify-between">
							<span>{{ $tp->product->name ?? $tp->product_id }}</span>
							<span class="badge">x{{ $tp->qty }}</span>
						</li>
					@empty
						<li class="text-center opacity-60">Chưa có dữ liệu</li>
					@endforelse
				</ul>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
	<script>
		const labels = @json($labels);
		const salesData = @json($salesSeries);
		const usersData = @json($usersSeries);

		const salesCtx = document.getElementById('salesChart');
		if (salesCtx) {
			new Chart(salesCtx, {
				type: 'line',
				data: {
					labels,
					datasets: [{
						label: 'Doanh thu',
						data: salesData,
						borderColor: '#3b82f6',
						backgroundColor: 'rgba(59,130,246,.2)',
						tension: .3,
						fill: true,
					}]
				},
				options: {
					plugins: { legend: { display: false } },
					scales: { y: { beginAtZero: true } }
				}
			});
		}

		const usersCtx = document.getElementById('usersChart');
		if (usersCtx) {
			new Chart(usersCtx, {
				type: 'bar',
				data: {
					labels,
					datasets: [{
						label: 'New Users',
						data: usersData,
						backgroundColor: '#22c55e'
					}]
				},
				options: {
					plugins: { legend: { display: false } },
					scales: { y: { beginAtZero: true, precision: 0 } }
				}
			});
		}
	</script>

@endsection