<?php

namespace App\Modules\Brand\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Brand\Service\BrandService;

class BrandController extends Controller
{
    public function __construct(private BrandService $service)
    {
    }

    public function page()
    {
        $brands = $this->service->list([], null);
        return view('admin.pages.brands.data', compact('brands'));
    }

    public function create()
    {
        return view('admin.pages.brands.create');
    }

    public function edit(string $id)
    {
        $brand = $this->service->get($id);
        return view('admin.pages.brands.edit', compact('brand'));
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
            'country' => 'nullable|string|max:255',
        ]);

        $brand = $this->service->create($data);
        if ($request->expectsJson()) return response()->json($brand, 201);
        return redirect()->route('admin.brands.page')->with('success', 'Tạo nhãn hàng thành công');
    }

    public function show(string $id)
    {
        return response()->json($this->service->get($id));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'country' => 'sometimes|nullable|string|max:255',
        ]);
        $brand = $this->service->update($id, $data);
        if ($request->expectsJson()) return response()->json($brand);
        return redirect()->route('admin.brands.page')->with('success', 'Cập nhật nhãn hàng thành công');
    }

    public function destroy(Request $request, string $id)
    {
        $this->service->delete($id);
        if ($request->expectsJson()) return response()->json(null, 204);
        return redirect()->route('admin.brands.page')->with('success', 'Đã xóa nhãn hàng');
    }
}
