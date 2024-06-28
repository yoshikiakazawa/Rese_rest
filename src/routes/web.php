<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\ReservationController;
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


Route::middleware('auth')->group(function () {
    Route::post('/toggle-favorite', [ShopController::class,'toggleFavorite']);
    Route::post('/done', [ReservationController::class,'thanks']);
    Route::get('/mypage', [UserDataController::class,'myPage'])->name('mypage');
    Route::get('/reservation/{shop_id}', [ReservationController::class,'edit'])->name('editReservation');
    Route::patch('/reservation/update', [ReservationController::class, 'update'])->name('updateReservation');
    Route::delete('/reservation/destroy',[ReservationController::class, 'destroy'])->name('destroyReservation');
    Route::get('/mypage/history', [UserDataController::class,'myPageHistory'])->name('history');
    Route::post('/mypage/history/rank', [UserDataController::class,'rank'])->name('rank');
});

Route::get('/thanks', function () {
    return view('auth.register_thanks');
})->name('thanks');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware(['guest', 'redirect.if.registered'])
    ->name('register');
