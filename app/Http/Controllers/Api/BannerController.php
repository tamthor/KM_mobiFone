<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index(): JsonResponse
    {
        $banners = Banner::where('status', 'active')->orderBy('id', 'desc')->get();
        return response()->json($banners);
    }
}
