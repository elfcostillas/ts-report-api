<?php

use App\Http\Controllers\StubsController;
use App\Http\Controllers\SummaryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('stubs')->group(function(){
   
    Route::get('list',[StubsController::class,'list']);
    Route::get('print/{id}',[StubsController::class,'print']);
   
});


Route::prefix('summary')->group(function(){
   
    Route::get('list',[SummaryController::class,'list']);
    Route::post('save-header',[SummaryController::class,'saveHeader']);
    Route::post('update-header',[SummaryController::class,'updateHeader']);

    Route::get('available-stubs/{id}',[SummaryController::class,'availableStubs']);
    Route::get('selected-stubs/{id}',[SummaryController::class,'selecedStubs']);

    Route::post('save-stubs',[SummaryController::class,'saveStubs']);

});
