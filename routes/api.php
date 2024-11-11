<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::get('/test',function(){

//     return response()->json('hi from amir ali');
// });

Route::get('v1/posts',[PostController::class,'index']);
Route::post('v1/post',[PostController::class,'store']);
Route::get('v1/posts/{id}',[PostController::class,'show']);
Route::put('v1/post/{post}',[PostController::class,'update']);
Route::delete('v1/post/{post}',[PostController::class,'destroy']);

// img ife related
Route::get('fbimg',[PostController::class,'getAllImg']);
Route::post('fbimg/uplode',[PostController::class,'uplodeimg']);
Route::delete('fbimg/{img}',[PostController::class,'deleteImg']);
Route::get('fbimgs/{id}',[PostController::class,'showImg']);