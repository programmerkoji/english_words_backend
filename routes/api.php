<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WordController;
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

Route::post('/login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::get('/word', [WordController::class, 'index']);
        Route::post('/word', [WordController::class, 'store']);
        Route::put('/word/{word_id}', [WordController::class, 'update']);
        Route::post('/logout', [AuthController::class, 'logout']);
    }
);
