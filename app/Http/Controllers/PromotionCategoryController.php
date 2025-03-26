<?php

namespace App\Http\Controllers;

use App\Models\PromotionCategory;
use Illuminate\Http\Request;

class PromotionCategoryController extends Controller
{
    /**
     * Hiển thị danh sách danh mục khuyến mãi.
     */
    public function index()
    {
        $categories = PromotionCategory::paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Hiển thị form tạo danh mục mới.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Lưu danh mục mới vào database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:promotion_categories,title',
            'status' => 'required|in:active,inactive',
        ]);

        PromotionCategory::create([
            'title' => $request->title,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Danh mục đã được tạo thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa danh mục.
     */
    public function edit($id)
    {
        $category = PromotionCategory::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Cập nhật thông tin danh mục.
     */
    public function update(Request $request, $id)
    {
        $category = PromotionCategory::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255|unique:promotion_categories,title,' . $category->id,
            'status' => 'required|in:active,inactive',
        ]);

        $category->update([
            'title' => $request->title,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Danh mục đã được cập nhật!');
    }

    /**
     * Xóa danh mục khuyến mãi.
     */
    public function destroy(PromotionCategory $promotionCategory)
    {
        $promotionCategory->delete();
        return redirect()->route('admin.category.index')->with('success', 'Danh mục đã được xóa!');
    }
}
