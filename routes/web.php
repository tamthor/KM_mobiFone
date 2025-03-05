<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\PromotionController;

// Route::get('/', function () {
//     return view('index');
// });
Route::group(['prefix' => 'admin/', 'as' => 'admin.'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('home');
    Route::resource('promotion', PromotionController::class);
    Route::post('upload-ckeditor', [FilesController::class, 'ckeditorUpload'])->name('upload.ckeditor');

});