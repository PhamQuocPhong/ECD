<?php 

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;


Route::post('/login', [LoginController::class, 'login']);
Route::get('/me', [ProfileController::class, 'me']);

Route::group(['prefix' => 'users', 'as' => 'users.'], function(){
    Route::get('/', [UserController::class, 'fetchAll'])->name('index');
    Route::post('/batch-email-notifications', [UserController::class, 'batchEmailNotifications'])->name('bactch.email.notifications');
    Route::post('/bulk-create-posts', [UserController::class, 'bulkCretePosts'])->name('bulk.create.posts');
});