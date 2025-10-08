<?php

namespace Tests\Feature;

use Livewire\Livewire;
use Tests\TestCase;

class AdminShellTest extends TestCase
{
    /** @test */
    public function shell_renders_dashboard_initially()
    {
        Livewire::test(\App\Livewire\Admin\Shell::class)
            ->assertSet('section', 'dashboard')
            ->assertSee('stat-cards'); // Livewire root element id slug
    }

    /** @test */
    public function can_switch_to_products()
    {
        Livewire::test(\App\Livewire\Admin\Shell::class)
            ->call('setSection', 'products')
            ->assertSet('section', 'products')
            ->assertSee('Tìm sản phẩm');
    }
}
