<?php

namespace App\Livewire\Admin; // moved from Dashboard

use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;

class StatCards extends Component
{
    public string $period = 'day'; // day|week|month

    protected $queryString = [
        'period' => ['except' => 'day']
    ];

    public function setPeriod(string $period): void
    {
        if (! in_array($period, ['day','week','month'])) {
            return;
        }
        $this->period = $period;
    }

    #[Computed]
    public function stats(): array
    {
        // Placeholder logic – in real app query DB using $this->period
        $base = match($this->period) {
            'day' => 1,
            'week' => 7,
            'month' => 30,
            default => 1,
        };

        return [
            [
                'label' => 'New Users',
                'icon' => 'icon-[tabler--users]',
                'value' => 12 * $base,
                'delta' => '+8%'
            ],
            [
                'label' => 'Orders',
                'icon' => 'icon-[tabler--shopping-bag]',
                'value' => 34 * $base,
                'delta' => '+3%'
            ],
            [
                'label' => 'Revenue',
                'icon' => 'icon-[tabler--currency-dollar]',
                'value' => '$' . number_format(1400 * $base),
                'delta' => '+12%'
            ],
            [
                'label' => 'Refunds',
                'icon' => 'icon-[tabler--rotate-clockwise-2]',
                'value' => 2 * $base,
                'delta' => '-2%'
            ],
        ];
    }

    public function render()
    {
        return view('livewire.admin.stat-cards');
    }
}
