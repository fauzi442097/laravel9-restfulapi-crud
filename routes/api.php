<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => '/lsp/v1'
], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('users/login', 'login')->withoutMiddleware('jwt.verify');
        Route::post('users/register', 'register')->withoutMiddleware('jwt.verify');
        Route::post('users/logout', 'logout');
        Route::post('users/refresh-token', 'refresh');
    });

    Route::apiResource('products', ProductController::class);
});
