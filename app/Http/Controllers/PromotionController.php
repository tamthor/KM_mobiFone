<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\PromotionContent;
use App\Models\Tags;
use Illuminate\Http\Request;

class PromotionController extends Controller
{

    public function index()
    {
        // $func = "promotion"
        $func = "admin_view";
        $data['breadcrumb'] = '
        <li class="breadcrumb-item"><a href="#">/</a></li>
        <li class="breadcrumb-item active" aria-current="page"> Bảng điều khiển</li>';
        $data['active_menu'] = 'dashboard';
        return view('promotion.index');
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

        dd($request->all());
        // $user  = auth()->user();
        // if (!$user) {
        //     return redirect()->route('front.login');
        // }

        // Xác thực dữ liệu
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'string|required',
            'start_at' => 'nullable|date|after_or_equal:today',
            'end_at' => 'nullable|date|after:start_at',
            'tag_ids' => 'nullable|array',
            'status' => 'required|in:active,inactive',
        ]); 
        $tag_ids = null;
    
        if($request->has('tag_ids')){
            $tag_ids = (new TagsController())->store($request['tag_ids']);
        }
        Promotion::create([
            'title' => $request->title,
            'content' => $request->content,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'tag_ids' => $tag_ids,
            'status' => $request->status,
        ]);
        return redirect()->route('promotion.create')->with('success', 'Khuyến mãi đã được thêm thành công!');
    }
}
