<?php

namespace App\Modules\Category\Repository;

use App\Modules\Category\Models\Category;

class CategoryRepository
{
    public function getAll(array $filters = [], ?int $perPage = null)
    {
        $q = Category::query();
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $q->where(function ($w) use ($s) {
                $w->where('name', 'like', "%{$s}%")
                  ->orWhere('slug', 'like', "%{$s}%");
            });
        }
        $q->orderBy('name');
        return $perPage ? $q->paginate($perPage) : $q->get();
    }

    public function findById(string $id): Category
    {
        return Category::findOrFail($id);
    }

    public function create(array $data): Category
    {
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = str($data['name'])->slug('-');
        }
        $cat = new Category($data);
        if (!$cat->getKey() && !$cat->getIncrementing()) {
            $cat->setAttribute($cat->getKeyName(), (string) \Illuminate\Support\Str::uuid());
        }
        $cat->save();
        return $cat;
    }

    public function update(string $id, array $data): Category
    {
        $cat = Category::findOrFail($id);
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = str($data['name'])->slug('-');
        }
        $cat->update($data);
        return $cat;
    }

    public function delete(string $id): bool
    {
        $cat = Category::findOrFail($id);
        return (bool) $cat->delete();
    }
}
