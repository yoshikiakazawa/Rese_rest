<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware('auth')->group(function () {
    Route::get('/', [ShopController::class,'index']);
    Route::get('/search', [ShopController::class,'search']);
    Route::post('/toggle-favorite', [ShopController::class,'toggleFavorite']);
});

// Route::get('/register/thanks', [AuthController::class,'register_thanks']);

Route::get('/register/thanks', function () {
    return view('auth.register_thanks');
})->name('register_thanks');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware(['guest', 'redirect.if.registered'])
    ->name('register');
