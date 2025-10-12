<?php

namespace App\Modules\Products\Service;

use App\Modules\Products\Models\Product;
use App\Modules\Products\Repository\ProductRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Modules\Products\Models\ProductImage;

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
            'name','slug','category_id','brand_id','description','price','gender','style','color','material','stock'
        ];
        $data = Arr::only($data, $allowed);

        // Simple business rule example: stock cannot be negative
        if (array_key_exists('stock', $data) && (int)$data['stock'] < 0) {
            throw ValidationException::withMessages(['stock' => 'Stock cannot be negative']);
        }

        return $data;
    }

    /**
     * Store uploaded images and attach to product.
     * @param Product $product
     * @param UploadedFile[] $files
     * @param string|null $primaryId Temporary client id to mark primary (optional, not used here)
     * @return Product
     */
    public function addImages(Product $product, array $files, ?int $startSort = null): Product
    {
        if (empty($files)) return $product->load(['images', 'primaryImage']);

        DB::transaction(function () use ($product, $files, $startSort) {
            $sort = $startSort ?? ((int) ($product->images()->max('sort_order') ?? 0));
            foreach ($files as $file) {
                if (!$file instanceof UploadedFile) continue;
                $path = $file->store('products/'.$product->id, 'public');
                $product->images()->create([
                    'path' => $path,
                    'is_primary' => false,
                    'sort_order' => ++$sort,
                ]);
            }
        });

        return $product->fresh(['images', 'primaryImage']);
    }

    public function setPrimaryImage(Product $product, string $imageId): Product
    {
        DB::transaction(function () use ($product, $imageId) {
            $product->images()->update(['is_primary' => false]);
            $product->images()->where('id', $imageId)->update(['is_primary' => true]);
        });
        return $product->fresh(['images', 'primaryImage']);
    }
}
