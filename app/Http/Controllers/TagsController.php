<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index()
    {
        $active_menu="tag_list";
        $breadcrumb = '
        <li class="breadcrumb-item"><a href="#">/</a></li>
        <li class="breadcrumb-item active" aria-current="page"> tags </li>';
        $tags=Tags::orderBy('id','DESC');
        return view('backend.tags.index',compact('tags','breadcrumb','active_menu'));
    }
    
    public function tagStatus(Request $request)
    {
        $func = "tag_edit";
        if($request->mode =='true')
        {
            \DB::table('tags')->where('id',$request->id)->update(['status'=>'active']);
        }
        else
        {
            \DB::table('tags')->where('id',$request->id)->update(['status'=>'inactive']);
        }
        return response()->json(['msg'=>"Cập nhật thành công",'status'=>true]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $func = "tag_add";
        $active_menu="tag_add";
        $breadcrumb = '
        <li class="breadcrumb-item"><a href="#">/</a></li>
        <li class="breadcrumb-item  " aria-current="page"><a href="'.route('tag.index').'">tags</a></li>
        <li class="breadcrumb-item active" aria-current="page"> tạo tags </li>';
        return view('backend.tags.create',compact('breadcrumb','active_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($tag_titles)
    {
        if (!$tag_titles || count($tag_titles) == 0) {
            return null;
        }

        $tags = [];
        foreach ($tag_titles as $tag_title) {
            $tag = Tags::firstOrCreate(['title' => $tag_title], ['hit' => 0]);
            $tag->increment('hit');
            $tags[] = $tag->id;
        }
        
        return implode(';', $tags); // Trả về danh sách ID tags dạng chuỗi
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $func = "tag_edit";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        $tag = Tag::find($id);
        if($tag)
        {
            $active_menu="tag_list";
            $breadcrumb = '
            <li class="breadcrumb-item"><a href="#">/</a></li>
            <li class="breadcrumb-item  " aria-current="page"><a href="'.route('tag.index').'">tags</a></li>
            <li class="breadcrumb-item active" aria-current="page"> điều chỉnh tags </li>';
            return view('backend.tags.edit',compact('breadcrumb','tag','active_menu'));
        }
        else
        {
            return back()->with('error','Không tìm thấy dữ liệu');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $func = "tag_edit";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        //
        $tag = Tag::find($id);
        if($tag)
        {
            $this->validate($request,[
                'title'=>'string|required',
                'status'=>'nullable|in:active,inactive',
            ]);
            $data = $request->all();
            $status = $tag->fill($data)->save();
            if($status){
                return redirect()->route('tag.index')->with('success','Cập nhật thành công');
            }
            else
            {
                return back()->with('error','Something went wrong!');
            }    
        }
        else
        {
            return back()->with('error','Không tìm thấy dữ liệu');
        }
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $func = "tag_delete";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        //
        $tag = Tag::find($id);
        if($tag)
        {
            $status = $tag->delete();
            if($status){
                return redirect()->route('tag.index')->with('success','Xóa tag thành công!');
            }
            else
            {
                return back()->with('error','Có lỗi xãy ra!');
            }    
        }
        else
        {
            return back()->with('error','Không tìm thấy dữ liệu');
        }
    }
}
