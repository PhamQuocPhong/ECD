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

use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {

    return view('welcome');
});

Route::group(['prefix' => 'users', 'as' => 'users.'], function(){
    Route::get('/', [UserController::class, 'fetchAll'])->name('index');
    Route::get('/{id}', [UserController::class, 'fetch'])->name('detail');
});
