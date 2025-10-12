<?php

namespace App\Modules\Products\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Ai\DescriptionGeneratorService;

class ProductAiController extends Controller
{
    public function __construct(private DescriptionGeneratorService $generator)
    {
    }

    public function describe(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'gender' => 'nullable|string|max:20',
            'style' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:100',
            'material' => 'nullable|string|max:100',
            'images' => 'sometimes|array',
            'images.*' => 'url',
        ], [
            'required' => ':attribute là bắt buộc.',
            'string' => ':attribute phải là chuỗi.',
            'max' => ':attribute quá dài.',
            'url' => ':attribute phải là URL hợp lệ.',
        ], [
            'name' => 'Tên sản phẩm',
            'price' => 'Giá',
            'category' => 'Danh mục',
            'brand' => 'Nhãn hàng',
            'gender' => 'Giới tính',
            'style' => 'Phong cách',
            'color' => 'Màu sắc',
            'material' => 'Chất liệu',
            'images' => 'Danh sách ảnh',
        ]);

        $desc = $this->generator->generate($data, $data['images'] ?? []);
        return response()->json(['description' => $desc]);
    }
}
