<?php

namespace App\Modules\Products\Repository;

use App\Modules\Products\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProductRepository
{
    public function getAll(array $filters = [], ?int $perPage = null)
    {
        $query = Product::query();

    // Eager load common relations including images
    $query->with(['brand', 'category', 'images', 'primaryImage']);

        // Filters
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        foreach (['category_id', 'brand_id', 'gender'] as $field) {
            if (!empty($filters[$field])) {
                $query->where($field, $filters[$field]);
            }
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        // Sorting
        if (!empty($filters['sort'])) {
            // e.g., "price:asc" or "created_at:desc"
            [$column, $direction] = array_pad(explode(':', $filters['sort'], 2), 2, 'asc');
            $allowed = ['name', 'price', 'created_at', 'updated_at', 'stock'];
            $column = in_array($column, $allowed, true) ? $column : 'created_at';
            $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';
            $query->orderBy($column, $direction);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if ($perPage) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    public function findById(string $id): Product
    {
    return Product::with(['brand', 'category', 'images', 'primaryImage'])->findOrFail($id);
    }

    public function create(array $data): Product
    {
        // Ensure slug default
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = str($data['name'])->slug('-');
        }

        // Handle UUID primary keys if not auto-increment
        /** @var Product $product */
        $product = new Product($data);
        if (!$product->getKey()) {
            // If model uses non-incrementing string key, set UUID when id missing
            if (method_exists($product, 'getKeyName') && !$product->getIncrementing() && empty($data['id'])) {
                $product->setAttribute($product->getKeyName(), (string) \Illuminate\Support\Str::uuid());
            }
        }
    $product->save();
    return $product->fresh(['brand', 'category', 'images', 'primaryImage']);
    }

    public function update(string $id, array $data): Product
    {
        $product = Product::findOrFail($id);
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = str($data['name'])->slug('-');
        }
    $product->update($data);
    return $product->fresh(['brand', 'category', 'images', 'primaryImage']);
    }

    public function delete(string $id): bool
    {
        $product = Product::findOrFail($id);
        return (bool) $product->delete();
    }
}
