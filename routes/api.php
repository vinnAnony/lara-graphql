<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'api/v1'], function () {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('documents', [DocumentController::class, 'index']);
    Route::get('documents/{id}', [DocumentController::class, 'show']);
    Route::get('documents/user/{id}', [DocumentController::class, 'showByUserId']);
    Route::post('documents', [DocumentController::class, 'store']);
    Route::put('documents/{id}', [DocumentController::class, 'update']);
    Route::delete('documents/{id}', [DocumentController::class, 'delete']);
});
