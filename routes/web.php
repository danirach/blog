<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/post', [PostController::class,'show'])->name('post');
    Route::post('/post', [PostController::class,'create']);
    Route::get('/post/{id}', [PostController::class,'detailPost'])->name('post-detail');
    Route::post('/comment', [PostController::class,'createComment']);
    Route::post('/reply', [PostController::class,'createReply']);
    Route::post('/postlike', [PostController::class,'toggleLike'])->name('postlike');
});
