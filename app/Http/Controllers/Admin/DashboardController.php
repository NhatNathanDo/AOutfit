<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Models\OrderItem;
use App\Modules\Products\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic stats
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalRevenue = (float) Order::sum('total_amount');
        $totalProducts = Product::count();

        // Last 7 days labels
        $dates = collect(range(0, 6))
            ->map(fn ($i) => Carbon::today()->subDays(6 - $i))
            ->values();

        $labels = $dates->map(fn (Carbon $d) => $d->format('d/m'));

        // Sales per day (sum of order total_amount)
        $salesRaw = Order::selectRaw('DATE(created_at) as d, SUM(total_amount) as total')
            ->where('created_at', '>=', Carbon::today()->subDays(6))
            ->groupBy('d')
            ->pluck('total', 'd');

        $salesSeries = $dates->map(function (Carbon $d) use ($salesRaw) {
            $key = $d->toDateString();
            return (float) ($salesRaw[$key] ?? 0);
        });

        // New users per day
        $usersRaw = User::selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->where('created_at', '>=', Carbon::today()->subDays(6))
            ->groupBy('d')
            ->pluck('c', 'd');

        $usersSeries = $dates->map(function (Carbon $d) use ($usersRaw) {
            $key = $d->toDateString();
            return (int) ($usersRaw[$key] ?? 0);
        });

        $newUsers7d = $usersSeries->sum();

        // Top products by quantity from order items
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as qty'))
            ->groupBy('product_id')
            ->orderByDesc('qty')
            ->with(['product:id,name'])
            ->limit(5)
            ->get();

        // Recent orders (avoid touching possibly mis-namespaced relations)
        $recentOrders = Order::orderByDesc('created_at')
            ->select(['id', 'total_amount', 'status', 'created_at'])
            ->limit(7)
            ->get();

        return view('admin.home', [
            'totalUsers' => $totalUsers,
            'newUsers7d' => $newUsers7d,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'totalProducts' => $totalProducts,
            'labels' => $labels,
            'salesSeries' => $salesSeries,
            'usersSeries' => $usersSeries,
            'topProducts' => $topProducts,
            'recentOrders' => $recentOrders,
        ]);
    }
}
