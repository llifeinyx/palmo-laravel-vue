<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Resources\BlogCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tags', [TagController::class, 'index'])->name('index');

Route::group([
    'as' => 'user.',
    'prefix' => 'user',
    'middleware' => ['auth:sanctum']
], function () {
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
});

Route::get('/user_blogs', function () {
    return new BlogCollection((User::find(Auth::id()))->blogs);
})->middleware('auth:sanctum');

Route::group([
    'as' => 'blog.',
    'prefix' => 'blog',
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/all', [BlogController::class, 'index'])->name('index')->withoutMiddleware(['auth:sanctum']);
    Route::get('/{blog}', [BlogController::class, 'show'])->name('show')->withoutMiddleware(['auth:sanctum']);
    Route::post('/', [BlogController::class, 'store'])->name('store');
    Route::delete('/{blog}', [BlogController::class, 'destroy'])->name('delete');
});
//Route::group([])
