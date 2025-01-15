<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;

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
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\TokenController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    User::addAllToIndex();
    dd("Add all index users");
});

Route::post('/login', [LoginController::class, 'login']);

Route::group(['middleware' => 'jwtAuth'], function(){
    Route::post('/logout', [LogoutController::class, 'logout']);
    Route::post('/refresh-token', [TokenController::class, 'refreshToken']);

    Route::group(['prefix' => 'users', 'as' => 'users.'], function(){
        Route::get('/', [UserController::class, 'fetchAll'])->name('index');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}', [UserController::class, 'fetch'])->name('detail');
    });
    
    Route::group(['prefix' => 'posts', 'as' => 'posts.'], function(){
        Route::get('/', [PostController::class, 'fetchAll'])->name('index');
        Route::post('/', [PostController::class, 'store'])->name('store');
    });
});






