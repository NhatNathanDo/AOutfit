<?php

namespace App\Livewire\Admin; // moved from Dashboard

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class RecentOrders extends Component
{
    use WithPagination;

    public string $statusFilter = 'all';
    // Livewire v3 no longer exposes an implicit $page property via the trait, define it explicitly
    public int $page = 1;

    protected $queryString = [
        'statusFilter' => ['except' => 'all']
    ];

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    protected function sampleOrders(): array
    {
        // Mock dataset (would come from Order model in real app)
        $statuses = ['pending','paid','shipped','cancelled'];
        return collect(range(1,50))->map(function($i) use ($statuses) {
            return [
                'id' => $i,
                'code' => 'ORD-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'customer' => 'Khách ' . $i,
                'total' => rand(200, 5000) / 10,
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now()->subHours($i)->format('d/m H:i')
            ];
        })->all();
    }

    public function getOrdersProperty(): LengthAwarePaginator
    {
        $data = $this->sampleOrders();
        if ($this->statusFilter !== 'all') {
            $data = array_values(array_filter($data, fn($o) => $o['status'] === $this->statusFilter));
        }
        $perPage = 8;
        $page = $this->page;
        $slice = array_slice($data, ($page-1)*$perPage, $perPage);
        return new LengthAwarePaginator($slice, count($data), $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);
    }

    public function setStatus(string $status): void
    {
        $this->statusFilter = $status;
    }

    public function render()
    {
        return view('livewire.admin.recent-orders');
    }
}
