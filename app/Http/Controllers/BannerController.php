<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('id', 'desc')->paginate(10);
        return view('banner.index', compact('banners'));
    }

    public function create()
    {
        return view('banner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'link' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

        // Tạo tên file duy nhất
        $file = $request->file('image');
        $filename = uniqid('banner_', true) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('banners', $filename, 'public');
        Banner::create([
            'title' => $request->title,
            'image' => '/storage/'.$path,
            'link' => $request->link,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được tạo!');
    }

    public function edit(Banner $banner)
    {
        return view('banner.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'link' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image);
            $path = $request->file('image')->store('banners', 'public');
            $banner->image = '/storage/'.$path;
        }

        $banner->update([
            'title' => $request->title,
            'link' => $request->link,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được cập nhật!');
    }

    public function destroy(Banner $banner)
    {
        Storage::disk('public')->delete($banner->image);
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được xóa!');
    }
}
