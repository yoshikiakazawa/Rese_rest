<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserDataController;
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
    Route::post('/done', [ShopController::class,'reservation']);
    Route::get('/mypage', [UserDataController::class,'myPage'])->name('mypage');
    Route::get('/mypage/reservation/{shop_id}', [UserDataController::class,'editReservation'])->name('editReservation');
    Route::patch('/mypage/reservation/update', [UserDataController::class, 'updateReservation'])->name('updateReservation');
    Route::delete('/mypage/reservation/delete',[UserDataController::class, 'destroyReservation'])->name('deleteReservation');
    Route::get('/mypage/history', [UserDataController::class,'myPageHistory'])->name('history');
    Route::post('/mypage/history/rank', [UserDataController::class,'rank'])->name('rank');
});

Route::get('/thanks', function () {
    return view('auth.register_thanks');
})->name('thanks');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware(['guest', 'redirect.if.registered'])
    ->name('register');
