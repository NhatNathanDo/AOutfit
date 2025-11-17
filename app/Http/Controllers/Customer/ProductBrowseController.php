<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Products\Service\ProductService;
use App\Modules\Category\Models\Category;
use App\Modules\Brand\Models\Brand;
use App\Modules\Products\Models\Product;

class ProductBrowseController extends Controller
{
    public function __construct(private ProductService $products)
    {
    }

    public function index(Request $request)
    {
        // Accept and normalize filters from query
        $perPage = max(1, (int) $request->integer('per_page', 20));
        $sortKey = $request->string('sort')->toString();
        $filters = [
            'search'      => trim((string) $request->query('q', '')) ?: null,
            'category_id' => $this->toArrayOrNull($request->query('category_id')),
            'brand_id'    => $this->toArrayOrNull($request->query('brand_id')),
            'gender'      => $request->query('gender'),
            'color'       => $this->toArrayOrNull($request->query('color')),
            'min_price'   => $request->query('min_price'),
            'max_price'   => $request->query('max_price'),
            'in_stock'    => $request->boolean('in_stock', false),
        ];

        // Map sort keys from UI to repository format
        $sortMap = [
            'price_asc'  => 'price:asc',
            'price_desc' => 'price:desc',
            'newest'     => 'created_at:desc',
            'name_asc'   => 'name:asc',
            'name_desc'  => 'name:desc',
            'best'       => 'best_seller',
        ];
        if (!empty($sortKey) && isset($sortMap[$sortKey])) {
            $filters['sort'] = $sortMap[$sortKey];
        } elseif ($sortKey) {
            $filters['sort'] = $sortKey; // passthrough if already in repo format
        }

        // Fetch products
        $products = $this->products->list($filters, $perPage);

        // Filter data sources
        $brands = Brand::query()->orderBy('name')->get(['id','name']);
        $topCategories = Category::query()->whereNull('parent_id')->orderBy('name')->get(['id','name','slug','parent_id']);
        $allCategories = Category::query()->orderBy('name')->get(['id','name','slug','parent_id']);
        $colors = Product::query()
            ->whereNotNull('color')
            ->where('color', '<>', '')
            ->distinct()->orderBy('color')
            ->pluck('color');

        // Breadcrumbs from selected category (if single selection)
        $selectedCategory = null;
        $breadcrumbs = [];
        $categoryParam = $request->query('category_id');
        if (!empty($categoryParam) && !is_array($categoryParam)) {
            $selectedCategory = Category::find($categoryParam);
            if ($selectedCategory) {
                $cursor = $selectedCategory;
                $chain = [];
                while ($cursor) {
                    $chain[] = $cursor;
                    $cursor = $cursor->category; // parent
                }
                $breadcrumbs = array_reverse($chain);
            }
        }

        return view('customer.products.index', [
            'products'         => $products,
            'brands'           => $brands,
            'topCategories'    => $topCategories,
            'allCategories'    => $allCategories,
            'colors'           => $colors,
            'selectedCategory' => $selectedCategory,
            'breadcrumbs'      => $breadcrumbs,
            'activeFilters'    => $request->query(),
            'perPage'          => $perPage,
            'sortKey'          => $sortKey ?: 'newest',
            'q'                => (string) ($filters['search'] ?? ''),
        ]);
    }

    public function suggest(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        if ($q === '') {
            return response()->json(['products' => [], 'categories' => []]);
        }

        $products = Product::query()
            ->with('primaryImage')
            ->where('name', 'like', "%{$q}%")
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id','name','slug','price']);

        $categories = Category::query()
            ->where('name', 'like', "%{$q}%")
            ->orderBy('name')
            ->limit(5)
            ->get(['id','name','slug']);

        return response()->json([
            'products' => $products->map(function (Product $p) {
                return [
                    'id'    => $p->id,
                    'name'  => $p->name,
                    'slug'  => $p->slug,
                    'price' => $p->price,
                    'image' => optional($p->primaryImage)->url ?? optional($p->images->first())->url ?? null,
                    'url'   => route('shop.show', $p->slug),
                ];
            }),
            'categories' => $categories->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'slug' => $c->slug,
                'url' => route('shop.index', ['category_id' => $c->id]),
            ]),
        ]);
    }

    public function show(string $slug)
    {
        $product = Product::with(['brand','category','images','primaryImage'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Build breadcrumb chain from category
        $breadcrumbs = [];
        $cursor = $product->category;
        while ($cursor) {
            $breadcrumbs[] = $cursor;
            $cursor = $cursor->category;
        }
        $breadcrumbs = array_reverse($breadcrumbs);

        // Prepare gallery tiles: main + up to 2 side thumbs
        $images = collect([$product->primaryImage])->filter()->merge($product->images)->unique('id')->values();
        $main = $images->get(0);
        $thumb1 = $images->get(1);
        $thumb2 = $images->get(2);

        return view('customer.products.show', [
            'product' => $product,
            'breadcrumbs' => $breadcrumbs,
            'main' => $main,
            'thumb1' => $thumb1,
            'thumb2' => $thumb2,
        ]);
    }

    private function toArrayOrNull($value): ?array
    {
        if (is_null($value) || $value === '') return null;
        return is_array($value) ? array_values(array_filter($value)) : [$value];
    }
}
