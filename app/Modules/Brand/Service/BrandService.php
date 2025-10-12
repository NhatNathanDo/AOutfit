<?php

namespace App\Modules\Brand\Service;

use App\Modules\Brand\Models\Brand;
use App\Modules\Brand\Repository\BrandRepository;
use Illuminate\Support\Arr;

class BrandService
{
    public function __construct(private BrandRepository $repo)
    {
    }

    public function list(array $filters = [], ?int $perPage = null)
    {
        return $this->repo->getAll($filters, $perPage);
    }

    public function get(string $id): Brand
    {
        return $this->repo->findById($id);
    }

    public function create(array $data): Brand
    {
        $data = Arr::only($data, ['name','country']);
        return $this->repo->create($data);
    }

    public function update(string $id, array $data): Brand
    {
        $data = Arr::only($data, ['name','country']);
        return $this->repo->update($id, $data);
    }

    public function delete(string $id): bool
    {
        return $this->repo->delete($id);
    }
}
