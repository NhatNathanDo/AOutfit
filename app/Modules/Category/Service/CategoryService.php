<?php

namespace App\Modules\Category\Service;

use App\Modules\Category\Models\Category;
use App\Modules\Category\Repository\CategoryRepository;
use Illuminate\Support\Arr;

class CategoryService
{
    public function __construct(private CategoryRepository $repo)
    {
    }

    public function list(array $filters = [], ?int $perPage = null)
    {
        return $this->repo->getAll($filters, $perPage);
    }

    public function get(string $id): Category
    {
        return $this->repo->findById($id);
    }

    public function create(array $data): Category
    {
        $data = Arr::only($data, ['name','parent_id','slug']);
        return $this->repo->create($data);
    }

    public function update(string $id, array $data): Category
    {
        $data = Arr::only($data, ['name','parent_id','slug']);
        return $this->repo->update($id, $data);
    }

    public function delete(string $id): bool
    {
        return $this->repo->delete($id);
    }
}
