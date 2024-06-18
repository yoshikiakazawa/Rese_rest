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

Route::get('/', [ShopController::class,'index']);
Route::get('/detail/{shop_id}', [ShopController::class,'detail'])->name('detail');
Route::get('/search', [ShopController::class,'search']);
Route::post('/toggle-favorite', [ShopController::class,'toggleFavorite']);
Route::post('/done', [ShopController::class,'reservation']);

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [ShopController::class,'myPage']);
    Route::patch('/update_reservation', [ShopController::class, 'updateReservation'])->name('update_reservation');
    Route::delete('/delete_reservation',[ShopController::class, 'destroyReservation'])->name('delete_reservation');
    Route::delete('/delete_favorite',[ShopController::class, 'destroyFavorite'])->name('delete_favorite');
    Route::get('/mypage/history', [ShopController::class,'myPageHistory'])->name('history');
});

Route::get('/thanks', function () {
    return view('auth.register_thanks');
})->name('thanks');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware(['guest', 'redirect.if.registered'])
    ->name('register');
