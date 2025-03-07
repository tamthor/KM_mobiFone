<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\PromotionContactController;
use App\Http\Controllers\PromotionContentController;

// Route::get('/', function () {
//     return view('index');
// });
Route::group(['prefix' => 'admin/', 'as' => 'admin.'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('home');
    Route::resource('promotion', PromotionContentController::class);
    Route::post('upload-ckeditor', [FilesController::class, 'ckeditorUpload'])->name('upload.ckeditor');

});

