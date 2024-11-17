<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;


Route::get('/register', [RegisterController::class,'show'])->name('show.register');
Route::post('/register', [RegisterController::class,'create'])->name('create.register');

Route::get('/login', [AuthenticationController::class,'show'])->name('login');
Route::post('/login', [AuthenticationController::class,'store'])->name('post.login');




Route::middleware('auth')->prefix('todo')->group(function(){

    Route::get('/', [TodoController::class,'show'])->name('home');
    Route::post('/', [TodoController::class,'create'])->name('create.todo');

    Route::patch('/{todo}', [TodoController::class,'update'])->name('create.todo');

});
