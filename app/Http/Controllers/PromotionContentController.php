<?php

namespace App\Http\Controllers;

use App\Models\promotionCategory;
use App\Models\PromotionContent;
use App\Models\Tags;
use Illuminate\Http\Request;

class PromotionContentController extends Controller
{

    public function index()
    {
        $promotions = PromotionContent::orderBy('created_at', 'desc')->paginate(10);
        $categories = PromotionCategory::where('status', 'active')->get();
        return view('promotion.index', compact('promotions', 'categories'));
    }

    public function create()
    {
        // $user  = auth()->user();
        // if (!$user) {
        //     return redirect()->route('front.login');
        // }
        $tags = Tags::all();
        $categories = PromotionCategory::where('status', 'active')->get();
        return view('promotion.create', compact('tags', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'string|required',
            'image' => 'nullable|string',
            'start_at' => 'nullable|date|after_or_equal:today',
            'end_at' => 'nullable|date|after:start_at',
            'tag_titles' => 'nullable|array',
            'category_id' => 'nullable|exists:promotion_categories,id',
            'status' => 'required|in:active,inactive',
        ]);

        $tag_id = null;
        if ($request->has('tag_titles')) {
            $tag_id = app(TagsController::class)->store($request['tag_titles']);
        }

        // Xử lý ảnh thumbnail từ CKEditor
        $image = null;
        if ($request->has('image')) {
            // Lấy URL ảnh từ nội dung HTML của CKEditor
            preg_match('/<img[^>]+src="([^">]+)"/', $request->image, $matches);
            if (isset($matches[1])) {
                $image = $matches[1];
            }
        }

        PromotionContent::create([
            'title' => $request->title,
            'image' => $image,
            'content' => $request->content,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'tag_ids' => $tag_id,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.promotion.index')->with('success', 'Khuyến mãi đã được thêm thành công!');
    }

    public function edit($id)
    {
        $promotion = PromotionContent::findOrFail($id);
        $categories = PromotionCategory::where('status', 'active')->get();
        $tags = Tags::all();

        return view('promotion.edit', compact('promotion', 'tags', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'string|required',
            'image' => 'nullable|string',
            'start_at' => 'nullable|date|after_or_equal:today',
            'end_at' => 'nullable|date|after:start_at',
            'tag_titles' => 'nullable|array',
            'category_id' => 'nullable|exists:promotion_categories,id',
            'status' => 'required|in:active,inactive',
        ]);

        $promotion = PromotionContent::findOrFail($id);

        $tag_id = null;
        if ($request->has('tag_titles')) {
            $tag_id = app(TagsController::class)->store($request['tag_titles']);
        }

        // Xử lý ảnh thumbnail từ CKEditor
        $image = $promotion->image; // Giữ ảnh cũ mặc định
        if (!empty($request->image)) {
            // Lấy URL ảnh từ nội dung HTML của CKEditor
            preg_match('/<img[^>]+src="([^">]+)"/', $request->image, $matches);
            if (isset($matches[1])) {
                $image = $matches[1];
            }
        }

        $promotion->update([
            'title' => $request->title,
            'image' => $image,
            'content' => $request->content,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'tag_ids' => $tag_id,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.promotion.index')->with('success', 'Khuyến mãi đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $promotion = PromotionContent::findOrFail($id);
        $promotion->delete();

        return redirect()->route('admin.promotion.index')->with('success', 'Khuyến mãi đã được xóa thành công!');
    }
}
