<?php

namespace App\Modules\Category\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Category\Service\CategoryService;
use App\Modules\Category\Models\Category;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $service)
    {
    }

    public function page()
    {
        $categories = $this->service->list([], null);
        return view('admin.pages.categories.data', compact('categories'));
    }

    public function create()
    {
        $parents = Category::orderBy('name')->get(['id','name']);
        return view('admin.pages.categories.create', compact('parents'));
    }

    public function edit(string $id)
    {
        $category = $this->service->get($id);
        $parents = Category::orderBy('name')->get(['id','name']);
        return view('admin.pages.categories.edit', compact('category','parents'));
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search']);
        $perPage = $request->integer('per_page') ?: null;
        return response()->json($this->service->list($filters, $perPage));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'parent_id' => 'nullable|string',
        ]);
        $cat = $this->service->create($data);
        if ($request->expectsJson()) return response()->json($cat, 201);
        return redirect()->route('admin.categories.page')->with('success', 'Tạo danh mục thành công');
    }

    public function show(string $id)
    {
        return response()->json($this->service->get($id));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255',
            'parent_id' => 'sometimes|nullable|string',
        ]);
        $cat = $this->service->update($id, $data);
        if ($request->expectsJson()) return response()->json($cat);
        return redirect()->route('admin.categories.page')->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy(Request $request, string $id)
    {
        $this->service->delete($id);
        if ($request->expectsJson()) return response()->json(null, 204);
        return redirect()->route('admin.categories.page')->with('success', 'Đã xóa danh mục');
    }
}
