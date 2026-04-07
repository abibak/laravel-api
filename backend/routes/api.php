<?php

use App\Http\Controllers\API\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/index', function () {
    return response()->json([
        'message' => "index"
    ], 200);
});

Route::post('{entity}/create', [MainController::class, 'create']);
Route::get('{entity}/get/{id?}', [MainController::class, 'get']);;
Route::put('{entity}/update/{id}', [MainController::class, 'update']);
Route::delete('{entity}/delete/{id}', [MainController::class, 'delete']);
