<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Đây là nơi bạn có thể đăng ký các route API cho ứng dụng của mình.
| Các route này được tải bởi RouteServiceProvider và sẽ
| thuộc nhóm middleware "api".
|
*/

// Route kiểm tra API hoạt động
Route::get('/ping', function () {
    return response()->json(['message' => 'API is working'], 200);
});

// Nhóm route dành cho user API
Route::prefix('users')->group(function () {
    
});

// Nếu cần thêm API khác, bạn có thể tiếp tục viết ở đây
