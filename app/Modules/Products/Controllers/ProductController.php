<?php

namespace App\Modules\Products\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Products\Service\ProductService;
use App\Modules\Brand\Models\Brand;
use App\Modules\Category\Models\Category;
use App\Modules\Products\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct(private ProductService $service)
    {
    }

    // Render admin page for products
    public function page()
    {
        $products = $this->service->list([], null);
        return view('admin.pages.products.data', compact('products'));
    }

    public function create()
    {
        $brands = Brand::query()->orderBy('name')->get(['id','name']);
        $categories = Category::query()->orderBy('name')->get(['id','name']);
        return view('admin.pages.products.create', compact('brands', 'categories'));
    }

    public function edit(string $id)
    {
        $product = $this->service->get($id);
        $brands = Brand::query()->orderBy('name')->get(['id','name']);
        $categories = Category::query()->orderBy('name')->get(['id','name']);
        return view('admin.pages.products.edit', compact('product','brands','categories'));
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
        // Normalize primary_new_index to null when not provided or no images
        if (!$request->hasFile('images') || !$request->filled('primary_new_index')) {
            $request->merge(['primary_new_index' => null]);
        }
        $rules = [
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
            'stock' => 'required|integer|min:0',
            'images' => 'sometimes|array',
            'images.*' => 'file|image|max:5120', // 5MB per image
            'primary_new_index' => 'nullable|integer|min:0',
        ];

        $messages = [
            'required' => ':attribute là bắt buộc.',
            'string' => ':attribute phải là chuỗi.',
            'max.string' => ':attribute không được vượt quá :max ký tự.',
            'numeric' => ':attribute phải là số.',
            'integer' => ':attribute phải là số nguyên.',
            'min.numeric' => ':attribute phải tối thiểu là :min.',
            'in' => ':attribute không hợp lệ.',
            'array' => ':attribute phải là mảng.',
            'file' => ':attribute phải là tệp hợp lệ.',
            'image' => ':attribute phải là hình ảnh.',
            'url' => ':attribute phải là URL hợp lệ.',
            'images.*.max' => 'Mỗi ảnh tối đa 5MB (5120KB).',
        ];

        $attributes = [
            'name' => 'Tên sản phẩm',
            'slug' => 'Slug',
            'category_id' => 'Danh mục',
            'brand_id' => 'Nhãn hàng',
            'description' => 'Mô tả',
            'price' => 'Giá',
            'gender' => 'Giới tính',
            'style' => 'Phong cách',
            'color' => 'Màu sắc',
            'material' => 'Chất liệu',
            'stock' => 'Kho',
            'images' => 'Ảnh sản phẩm',
            'images.*' => 'Ảnh',
            'primary_image_id' => 'Ảnh chính',
            'primary_new_index' => 'Ảnh chính mới',
        ];

        $validated = $request->validate($rules, $messages, $attributes);

        $product = $this->service->create($validated);

        // Handle image uploads
        $files = [];
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            $addedCount = is_array($files) ? count($files) : 0;
            $product = $this->service->addImages($product, $files);
            // If user picked a primary index among the new files
            if ($addedCount > 0) {
                $pickIndex = $request->filled('primary_new_index') ? $request->integer('primary_new_index') : null;
                if ($pickIndex !== null && $pickIndex >= 0 && $pickIndex < $addedCount) {
                    $all = $product->images()->orderBy('sort_order')->orderBy('created_at')->get();
                    $newImages = $all->slice($all->count() - $addedCount);
                    $chosen = $newImages->values()->get($pickIndex);
                    if ($chosen) {
                        $product = $this->service->setPrimaryImage($product, $chosen->id);
                    }
                } elseif (!$product->primaryImage && $product->images->isNotEmpty()) {
                    // fallback: first becomes primary
                    $this->service->setPrimaryImage($product, $product->images->first()->id);
                }
            }
        }

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json($product, 201);
        }

        return redirect()->route('admin.products.page')->with('success', 'Tạo sản phẩm thành công');
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
        // Normalize primary_new_index to null when not provided or no new images
        if (!$request->hasFile('images') || !$request->filled('primary_new_index')) {
            $request->merge(['primary_new_index' => null]);
        }
        $rules = [
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
            'stock' => 'sometimes|required|integer|min:0',
            'images' => 'sometimes|array',
            'images.*' => 'file|image|max:5120',
            'primary_image_id' => 'sometimes|string',
            'primary_new_index' => 'nullable|integer|min:0',
        ];

        $messages = [
            'required' => ':attribute là bắt buộc.',
            'string' => ':attribute phải là chuỗi.',
            'max.string' => ':attribute không được vượt quá :max ký tự.',
            'numeric' => ':attribute phải là số.',
            'integer' => ':attribute phải là số nguyên.',
            'min.numeric' => ':attribute phải tối thiểu là :min.',
            'in' => ':attribute không hợp lệ.',
            'array' => ':attribute phải là mảng.',
            'file' => ':attribute phải là tệp hợp lệ.',
            'image' => ':attribute phải là hình ảnh.',
            'url' => ':attribute phải là URL hợp lệ.',
            'images.*.max' => 'Mỗi ảnh tối đa 5MB (5120KB).',
        ];

        $attributes = [
            'name' => 'Tên sản phẩm',
            'slug' => 'Slug',
            'category_id' => 'Danh mục',
            'brand_id' => 'Nhãn hàng',
            'description' => 'Mô tả',
            'price' => 'Giá',
            'gender' => 'Giới tính',
            'style' => 'Phong cách',
            'color' => 'Màu sắc',
            'material' => 'Chất liệu',
            'stock' => 'Kho',
            'images' => 'Ảnh sản phẩm',
            'images.*' => 'Ảnh',
            'primary_image_id' => 'Ảnh chính',
            'primary_new_index' => 'Ảnh chính mới',
        ];

        $validated = $request->validate($rules, $messages, $attributes);

        $product = $this->service->update($id, $validated);

        // Add new images if provided
        $addedCount = 0;
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            $addedCount = is_array($files) ? count($files) : 0;
            $product = $this->service->addImages($product, $files);
        }

        // Update primary image if requested
        if ($request->filled('primary_image_id')) {
            $product = $this->service->setPrimaryImage($product, $request->string('primary_image_id'));
        } elseif ($addedCount > 0 && $request->filled('primary_new_index')) {
            $pickIndex = $request->integer('primary_new_index');
            if ($pickIndex >= 0 && $pickIndex < $addedCount) {
                $all = $product->images()->orderBy('sort_order')->orderBy('created_at')->get();
                $newImages = $all->slice($all->count() - $addedCount);
                $chosen = $newImages->values()->get($pickIndex);
                if ($chosen) {
                    $product = $this->service->setPrimaryImage($product, $chosen->id);
                }
            }
        }

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json($product);
        }

        return redirect()->route('admin.products.page')->with('success', 'Cập nhật sản phẩm thành công');
    }

    // Remove the specified product from storage.
    public function destroy(Request $request, string $id)
    {
        $this->service->delete($id);
        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json(null, 204);
        }
        return redirect()->route('admin.products.page')->with('success', 'Đã xóa sản phẩm');
    }

    // Remove a specific image from a product
    public function destroyImage(Request $request, string $productId, string $imageId)
    {
        $image = ProductImage::query()->where('product_id', $productId)->where('id', $imageId)->firstOrFail();
        // delete file
        if ($image->path && Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }
        $wasPrimary = $image->is_primary;
        $image->delete();

        // If it was primary, set another image as primary if available
        if ($wasPrimary) {
            $product = $this->service->get($productId);
            $next = $product->images()->orderBy('sort_order')->orderBy('created_at')->first();
            if ($next) {
                $this->service->setPrimaryImage($product, $next->id);
            }
        }

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json(null, 204);
        }

        return back()->with('success', 'Đã xóa ảnh');
    }
}