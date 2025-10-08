<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardComponentsTest extends TestCase
{
    /** @test */
    public function stat_cards_renders()
    {
    Livewire::test(\App\Livewire\Admin\StatCards::class)
            ->assertSee('Thống kê')
            ->assertSee('New Users');
    }

    /** @test */
    public function recent_orders_renders()
    {
    Livewire::test(\App\Livewire\Admin\RecentOrders::class)
            ->assertSee('Đơn hàng gần đây');
    }

    /** @test */
    public function top_products_renders()
    {
    Livewire::test(\App\Livewire\Admin\TopProducts::class)
            ->assertSee('Sản phẩm bán chạy');
    }

    /** @test */
    public function activity_feed_renders()
    {
    Livewire::test(\App\Livewire\Admin\ActivityFeed::class)
            ->assertSee('Hoạt động');
    }

    /** @test */
    public function sales_chart_renders()
    {
    Livewire::test(\App\Livewire\Admin\SalesChart::class)
            ->assertSee('Doanh thu');
    }
}
