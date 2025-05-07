<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    // Lấy danh sách bình luận của một khuyến mãi
    public function index($promotionId)
    {
        $comments = Comment::where('promotion_id', $promotionId)
            // ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $comments,
        ], 200);
    }

    // Thêm bình luận mới
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'promotion_id' => 'required|exists:promotion_contents,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'content' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $comment = Comment::create([
            'promotion_id' => $request->promotion_id,
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Bình luận đã được gửi và đang chờ duyệt.',
            'data' => $comment,
        ], 201);
    }
}