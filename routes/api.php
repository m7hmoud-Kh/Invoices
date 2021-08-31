<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\ProductController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['prefix' => 'section'],function(){
    Route::get('all/{id?}',[SectionController::class,'index']);
    Route::post('store',[SectionController::class,'store']);
    Route::put('update/{id}',[SectionController::class,'update'])->whereNumber('id');
    Route::delete('delete/{id}',[SectionController::class,'delete'])->whereNumber('id');
    Route::get('sereach/{any}',[SectionController::class,'sereach']);


});


Route::group(['prefix' => 'product'],function(){
    Route::get('all/{id?}',[ProductController::class,'index']);
    Route::post('store',[ProductController::class,'store']);
    Route::put('update/{id}',[ProductController::class,'update'])->whereNumber('id');
    Route::delete('delete/{id}',[ProductController::class,'delete'])->whereNumber('id');
    Route::get('sereach/{any}',[ProductController::class,'sereach']);

});




