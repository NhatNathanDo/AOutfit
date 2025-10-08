<?php

namespace App\Livewire\Admin; // moved from Dashboard

use Livewire\Component;

class SalesChart extends Component
{
    public string $range = '7d'; // 7d, 30d, 90d

    protected $queryString = [
        'range' => ['except' => '7d']
    ];

    public function setRange(string $range): void
    {
        if (! in_array($range, ['7d','30d','90d'])) return; 
        $this->range = $range;
    }

    public function getChartDataProperty(): array
    {
        $points = match($this->range) {
            '7d' => 7,
            '30d' => 30,
            '90d' => 30, // compress for display
            default => 7,
        };
        $data = [];
        for ($i=$points; $i>=1; $i--) {
            $data[] = [
                'label' => $i.'d',
                'value' => rand(50,200)
            ];
        }
        return $data;
    }

    public function render()
    {
        return view('livewire.admin.sales-chart');
    }
}
