<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PromotionContent;
use App\Models\PromotionCategory;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $query = PromotionContent::where('status', 'active');

        // Lọc theo category_id nếu có
        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Tìm kiếm theo từ khóa nếu có
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('title', 'LIKE', "%{$keyword}%"); // Tìm kiếm trong title
        }

        return response()->json($query->get(), 200);
    }

    public function show($id)
    {
        $promotion = PromotionContent::find($id);
        if (!$promotion) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $promotion->increment('views');
        return response()->json($promotion, 200);
    }

    public function store(Request $request)
    {
        $promotion = PromotionContent::create($request->all());
        return response()->json($promotion, 201);
    }

    public function update(Request $request, $id)
    {
        $promotion = PromotionContent::find($id);
        if (!$promotion) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $promotion->update($request->all());
        return response()->json($promotion, 200);
    }

    public function destroy($id)
    {
        $promotion = PromotionContent::find($id);
        if (!$promotion) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $promotion->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }

    public function getCategories()
    {
        return response()->json(PromotionCategory::where('status', 'active')->get(), 200);
    }
}