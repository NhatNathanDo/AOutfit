<?php

namespace App\Modules\Products\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Products\Service\ProductService;

class ProductController extends Controller
{
    public function __construct(private ProductService $service)
    {
    }

    // Display a listing of the products.
    public function index(Request $request)
    {
        $filters = $request->only(['search','category_id','brand_id','gender','min_price','max_price','sort']);
        $perPage = $request->integer('per_page') ?: null;
        $products = $this->service->list($filters, $perPage);
        return response()->json($products);
    }

    // Store a newly created product in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category_id' => 'required|string',
            'brand_id' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'gender' => 'required|string|in:male,female,unisex',
            'style' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'image_url' => 'nullable|url',
            'stock' => 'required|integer|min:0',
        ]);

        $product = $this->service->create($validated);

        return response()->json($product, 201);
    }

    // Display the specified product.
    public function show(string $id)
    {
        $product = $this->service->get($id);
        return response()->json($product);
    }

    // Update the specified product in storage.
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255',
            'category_id' => 'sometimes|required|string',
            'brand_id' => 'sometimes|required|string',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'gender' => 'sometimes|required|string|in:male,female,unisex',
            'style' => 'sometimes|nullable|string|max:255',
            'color' => 'sometimes|nullable|string|max:255',
            'material' => 'sometimes|nullable|string|max:255',
            'image_url' => 'sometimes|nullable|url',
            'stock' => 'sometimes|required|integer|min:0',
        ]);

        $product = $this->service->update($id, $validated);

        return response()->json($product);
    }

    // Remove the specified product from storage.
    public function destroy(string $id)
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}