<?php

namespace App\Http\Controllers;

use App\Models\PromotionContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionContactController extends Controller
{
    //
    // public function index()
    // {
    //     $contacts = PromotionContact::orderBy('created_at', 'desc')->paginate(10);

        
    //     return view('contact.index', compact('contacts'));
    // }
    public function index() {
        $contacts = DB::table('promotion_contacts')
            ->join('promotion_contents', 'promotion_contacts.promotion_content_id', '=', 'promotion_contents.id')
            ->select('promotion_contacts.*', 'promotion_contents.title as promotion_title')
            ->orderBy('promotion_contacts.created_at', 'desc') // Sắp xếp trước khi lấy dữ liệu
            ->paginate(10); // Phải dùng trên Query Builder, không phải Collection
    
        return view('contact.index', compact('contacts'));
    }
    
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

    public function destroy($id)
    {
        $contact = PromotionContact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contact.index')->with('success', 'Thông tin liên hệ đã được xóa thành công!');
    }
}
