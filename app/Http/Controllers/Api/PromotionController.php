<?php
namespace App\Http\Controllers\Api; // Cập nhật namespace

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Import Controller gốc
use App\Models\PromotionContent;

class PromotionController extends Controller
{
    public function index()
    {
        return response()->json(PromotionContent::all(), 200);
    }

    public function show($id)
    {
        $promotion = PromotionContent::find($id);
        if (!$promotion) {
            return response()->json(['message' => 'Not found'], 404);
        }
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
}
