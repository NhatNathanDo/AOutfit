<?php

namespace App\Livewire\Admin; // moved from Dashboard

use Livewire\Component;

class TopProducts extends Component
{
    public array $expanded = []; // product ids expanded

    protected function getProducts(): array
    {
        return collect(range(1,8))->map(function($i){
            return [
                'id' => $i,
                'name' => 'Sản phẩm #' . $i,
                'sku' => 'SKU-' . str_pad($i,4,'0',STR_PAD_LEFT),
                'sales' => rand(50,500),
                'revenue' => rand(200000, 5000000),
                'stock' => rand(0, 120),
                'category' => 'Danh mục ' . rand(1,4),
            ];
        })->sortByDesc('sales')->values()->all();
    }

    public function toggle($id): void
    {
        if (in_array($id, $this->expanded)) {
            $this->expanded = array_values(array_diff($this->expanded, [$id]));
        } else {
            $this->expanded[] = $id;
        }
    }

    public function render()
    {
        $products = $this->getProducts();
        return view('livewire.admin.top-products', compact('products'));
    }
}
