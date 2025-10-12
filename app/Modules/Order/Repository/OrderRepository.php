<?php

namespace App\Modules\Order\Repository;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class OrderRepository
{
    public function getAll(array $filters = [], ?int $perPage = null)
    {
        $q = Order::query();

        // Eager load relations
        $q->with([
            'user:id,name,email',
            'order_items.product:id,name,price,brand_id,category_id',
            'order_items.product.primaryImage:id,product_id,path,is_primary',
            'payments',
        ]);

        // Filters
        if (!empty($filters['search'])) {
            $s = trim($filters['search']);
            $q->where(function (Builder $w) use ($s) {
                $w->where('id', 'like', "%{$s}%")
                  ->orWhere('shipping_address', 'like', "%{$s}%")
                  ->orWhereHas('user', function (Builder $u) use ($s) {
                      $u->where('name', 'like', "%{$s}%")
                        ->orWhere('email', 'like', "%{$s}%");
                  });
            });
        }

        foreach (['status','payment_method'] as $field) {
            if (!empty($filters[$field])) {
                $q->where($field, $filters[$field]);
            }
        }

        if (!empty($filters['min_total'])) {
            $q->where('total_amount', '>=', (float) $filters['min_total']);
        }
        if (!empty($filters['max_total'])) {
            $q->where('total_amount', '<=', (float) $filters['max_total']);
        }

        if (!empty($filters['from'])) {
            $q->whereDate('created_at', '>=', $filters['from']);
        }
        if (!empty($filters['to'])) {
            $q->whereDate('created_at', '<=', $filters['to']);
        }

        // Sorting
        if (!empty($filters['sort'])) {
            [$column, $direction] = array_pad(explode(':', $filters['sort'], 2), 2, 'desc');
            $allowed = ['created_at','updated_at','total_amount','status'];
            $column = in_array($column, $allowed, true) ? $column : 'created_at';
            $direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';
            $q->orderBy($column, $direction);
        } else {
            $q->orderBy('created_at', 'desc');
        }

        return $perPage ? $q->paginate($perPage) : $q->get();
    }

    public function findById(string $id): Order
    {
        return Order::with([
            'user:id,name,email',
            'order_items.product',
            'order_items.product.primaryImage',
            'payments',
        ])->findOrFail($id);
    }

    public function update(string $id, array $data): Order
    {
        $order = Order::findOrFail($id);
        $order->update($data);
        return $order->fresh([
            'user:id,name,email',
            'order_items.product',
            'order_items.product.primaryImage',
            'payments',
        ]);
    }
}
