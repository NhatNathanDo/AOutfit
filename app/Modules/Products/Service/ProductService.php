<?php

namespace App\Modules\Products\Service;

use App\Modules\Products\Models\Product;
use App\Modules\Products\Repository\ProductRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;

class ProductService
{
    public function __construct(private ProductRepository $repository)
    {
    }

    public function list(array $filters = [], ?int $perPage = null)
    {
        return $this->repository->getAll($filters, $perPage);
    }

    public function get(string $id): Product
    {
        return $this->repository->findById($id);
    }

    public function create(array $data): Product
    {
        $data = $this->sanitize($data);
        return $this->repository->create($data);
    }

    public function update(string $id, array $data): Product
    {
        $data = $this->sanitize($data, false);
        return $this->repository->update($id, $data);
    }

    public function delete(string $id): bool
    {
        return $this->repository->delete($id);
    }

    private function sanitize(array $data, bool $creating = true): array
    {
        // Whitelist fields to prevent mass-assignment of unexpected attributes
        $allowed = [
            'name','slug','category_id','brand_id','description','price','gender','style','color','material','image_url','stock'
        ];
        $data = Arr::only($data, $allowed);

        // Simple business rule example: stock cannot be negative
        if (array_key_exists('stock', $data) && (int)$data['stock'] < 0) {
            throw ValidationException::withMessages(['stock' => 'Stock cannot be negative']);
        }

        return $data;
    }
}
