<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Requests\ReservationRequest;

class UserDataController extends Controller
{
    public function myPage() {
        $today = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');
        $user = Auth::user();
        $shops = Shop::with(['areas', 'genres'])->get();
        $areas = Area::all();
        $genres = Genre::all();
        $reservations = Reservation::where('user_id', $user->id)
        ->where('date','>',$today)
        ->orWhere('user_id', $user->id)->Where('date','=',$today)->orderBy('date')
        ->orderBy('time')
        ->get();
        $favorites = [];
        if (Auth::check()) {
            $favorites = Favorite::where('user_id', Auth::id())->pluck('shop_id')->toArray();
        }
        $favoriteShops = Shop::whereIn('id', $favorites)->get();
        return view('mypage', compact('user','shops', 'areas', 'genres', 'reservations','favorites', 'favoriteShops'));
    }

    public function myPageHistory (){
        $today = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');
        $user = Auth::user();
        $shops = Shop::with(['areas', 'genres'])->get();
        $reservations = Reservation::where('user_id', $user->id)
        ->where('date','<',$today)
        ->orWhere('user_id', $user->id)->Where('date','=',$today)
        ->where('time','<',$currentTime)->orderBy('date', 'desc')
        ->orderBy('time', 'desc')
        ->get();
        return view ('history', compact('user','shops', 'reservations'));
    }

    public function rank (Request $request) {
        $rank = Reservation::find($request->id);
        if (empty($rank->rank)) {
            $rank->rank = $request->rank;
            $rank->comment = $request->comment;
            $rank->save();
            return redirect()->back()->with('message', '評価しました。');
        }
        $rank->rank = $request->rank;
        $rank->comment = $request->comment;
        $rank->save();
        return redirect()->back()->with('message', '評価を修正しました。');
    }

    public function editReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $formattedTime = Carbon::parse($reservation->time)->format('H:i');
        $shop = Shop::findOrFail($reservation->shop_id);
        $times = [
            '11:00', '11:30', '12:00', '12:30', '13:00', '13:30',
            '14:00', '14:30', '15:00', '15:30', '16:00', '16:30',
            '17:00', '17:30', '18:00', '18:30', '19:00', '19:30',
            '20:00', '20:30', '21:00', '21:30', '22:00'
        ];
        return view('reservation-edit', compact('reservation','shop','times', 'formattedTime'));
    }

    public function updateReservation (ReservationRequest $request) {
        $oldReservation = Reservation::find($request->id);
        $oldReservation->date = $request->date;
        $oldReservation->time = $request->time;
        $oldReservation->number = $request->number;
        $oldReservation->save();
        return redirect('mypage')->with('message_reservation', '修正しました。');
    }

    public function destroyReservation(Request $request)
    {
        Reservation::find($request->id)->delete();
        return redirect('mypage')->with('message_reservation', 'キャンセルしました。');
    }

}
