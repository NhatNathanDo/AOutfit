<?php

namespace App\Modules\Brand\Repository;

use App\Modules\Brand\Models\Brand;

class BrandRepository
{
    public function getAll(array $filters = [], ?int $perPage = null)
    {
        $q = Brand::query();

        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $q->where(function ($w) use ($s) {
                $w->where('name', 'like', "%{$s}%")
                  ->orWhere('country', 'like', "%{$s}%");
            });
        }

        $q->orderBy('name');

        return $perPage ? $q->paginate($perPage) : $q->get();
    }

    public function findById(string $id): Brand
    {
        return Brand::findOrFail($id);
    }

    public function create(array $data): Brand
    {
        $brand = new Brand($data);
        if (!$brand->getKey() && !$brand->getIncrementing()) {
            $brand->setAttribute($brand->getKeyName(), (string) \Illuminate\Support\Str::uuid());
        }
        $brand->save();
        return $brand;
    }

    public function update(string $id, array $data): Brand
    {
        $brand = Brand::findOrFail($id);
        $brand->update($data);
        return $brand;
    }

    public function delete(string $id): bool
    {
        $brand = Brand::findOrFail($id);
        return (bool) $brand->delete();
    }
}
