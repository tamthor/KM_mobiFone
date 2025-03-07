<?php

namespace App\Http\Controllers;

use App\Models\PromotionContent;
use App\Models\Tags;
use Illuminate\Http\Request;

class PromotionContentController extends Controller
{

    public function index()
    {
        $promotions = PromotionContent::orderBy('created_at', 'desc')->paginate(10);
        return view('promotion.index', compact('promotions'));
    }

    public function create()
    {
        // $user  = auth()->user();
        // if (!$user) {
        //     return redirect()->route('front.login');
        // }
        $tags = Tags::all();
        return view('promotion.create', compact('tags'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'string|required',
            'start_at' => 'nullable|date|after_or_equal:today',
            'end_at' => 'nullable|date|after:start_at',
            'tag_titles' => 'nullable|array',
            'status' => 'required|in:active,inactive',
        ]);

        $tag_id = null;
        if ($request->has('tag_titles')) {
            $tag_id = app(TagsController::class)->store($request['tag_titles']);
        }

        PromotionContent::create([
            'title' => $request->title,
            'content' => $request->content,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'tag_ids' => $tag_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.promotion.index')->with('success', 'Khuyến mãi đã được thêm thành công!');
    }

    public function edit($id)
    {
        $promotion = PromotionContent::findOrFail($id);
        $tags = Tags::all();

        return view('promotion.edit', compact('promotion', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'string|required',
            'start_at' => 'nullable|date|after_or_equal:today',
            'end_at' => 'nullable|date|after:start_at',
            'tag_titles' => 'nullable|array',
            'status' => 'required|in:active,inactive',
        ]);

        $promotion = PromotionContent::findOrFail($id);

        $tag_id = null;
        if ($request->has('tag_titles')) {
            $tag_id = app(TagsController::class)->store($request['tag_titles']);
        }

        $promotion->update([
            'title' => $request->title,
            'content' => $request->content,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'tag_ids' => $tag_id,
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
