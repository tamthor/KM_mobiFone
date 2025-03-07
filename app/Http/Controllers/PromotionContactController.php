<?php

namespace App\Http\Controllers;

use App\Models\PromotionContact;
use Illuminate\Http\Request;

class PromotionContactController extends Controller
{
    //
    public function store(Request $request){
        $request->validate([
            'promotion_content_id'=> 'required|exists:promotion_contents,id',
            'full_name'=> 'required|string',
            'email'=> 'nullable|email',
            'phone_number'=>'required|string',
            'city'=> 'required|string',
            'note'=> 'nullable|string',
        ]);

        PromotionContact::create($request->all());
        return response()->json(['message'=> 'Thông tin của bạn đã được gửi.']);
    }
}
