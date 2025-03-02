<?php

use App\Http\Controllers\MessagesController;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'user'], function () {
    Route::post('', [UserController::class, 'user']);
});
Route::group(['prefix' => 'messages', 'middleware' => 'check.username'], function () {
    Route::get('', [MessagesController::class, 'index']);
    Route::post('', [MessagesController::class, 'store']);
});
