<?php

namespace App\Modules\Order\Service;

use App\Models\Order;
use App\Modules\Order\Repository\OrderRepository;
use Illuminate\Support\Arr;

class OrderService
{
    public function __construct(private OrderRepository $repo)
    {
    }

    public function list(array $filters = [], ?int $perPage = null)
    {
        $filters = Arr::only($filters, [
            'search','status','payment_method','min_total','max_total','from','to','sort'
        ]);
        return $this->repo->getAll($filters, $perPage);
    }

    public function get(string $id): Order
    {
        return $this->repo->findById($id);
    }

    public function update(string $id, array $data): Order
    {
        // Only allow status, shipping_address, payment_method to be updated from admin
        $data = Arr::only($data, ['status','shipping_address','payment_method']);
        return $this->repo->update($id, $data);
    }
}
