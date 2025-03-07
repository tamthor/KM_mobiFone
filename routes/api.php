<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PromotionContactController;
use App\Http\Controllers\Api\PromotionController; // Cập nhật namespace

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


Route::prefix('promotions')->group(function () {
    Route::get('/', [PromotionController::class, 'index']);
    Route::get('/{id}', [PromotionController::class, 'show']);
    Route::post('/', [PromotionController::class, 'store']);
    Route::put('/{id}', [PromotionController::class, 'update']);
    Route::delete('/{id}', [PromotionController::class, 'destroy']);
});

Route::post('/promotion_contact', [PromotionContactController::class, 'store'])->name('promotion.contact');

// Nếu cần thêm API khác, bạn có thể tiếp tục viết ở đây
