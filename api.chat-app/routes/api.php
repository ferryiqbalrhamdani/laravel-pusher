<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{ MeController, UserController, ConversationController };
use App\Http\Controllers\Auth\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('me', MeController::class);

    Route::get('user', [UserController::class, 'index']);
    Route::get('user/{id}', [UserController::class, 'show']);

    Route::get('conversation/{user_two}', [ConversationController::class, 'show'])->name('conversation.show');
    Route::post('conversation/{conversation}/message', [ConversationController::class, 'store'])->name('conversation.store');
});