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

class ShopController extends Controller
{
    public function index() {
        $shops = Shop::with(['areas', 'genres'])->get();
        $areas = Area::all();
        $genres = Genre::all();
        $favorites = [];
        if (Auth::check()) {
            $favorites = Favorite::where('user_id', Auth::id())->pluck('shop_id')->toArray();
        }
        return view('index', compact('shops', 'areas', 'genres', 'favorites'));
    }

    public function search(Request $request) {
        $area = $request->area_id;
        $genre = $request->genre_id;
        $shop = $request->shop_name;

        $query = Shop::query();

        if (!empty($shop)) {
            $query->where(function ($q) use ($shop)
            {
                $q->where('shop_name', 'like', "%$shop%");
            });
        }

        if (!empty($area))
        {
            $query->where('area_id', $area);
        }

        if (!empty($genre))
        {
            $query->where('genre_id', $genre);
        }
        $shops = $query->get();
        $areas = Area::all();
        $genres = Genre::all();
        $favorites = [];
        if (Auth::check()) {
            $favorites = Favorite::where('user_id', Auth::id())->pluck('shop_id')->toArray();
        }

        if ($shops->isEmpty()) {
            return view('index', compact('shops', 'areas', 'genres', 'favorites'))->with('message', '検索結果がありません。');
        }

        return view('index', compact('shops', 'areas', 'genres', 'favorites'));

    }
    public function toggleFavorite(Request $request)
    {
        $userId = Auth::id();
        $shopId = $request->input('shop_id');
        $favorite = Favorite::where('user_id', $userId)
            ->where('shop_id', $shopId)
            ->first();
            if ($favorite) {
                $favorite->delete();
                $isFavorite = false;
            } else {
            Favorite::create([
                'user_id' => $userId,
                'shop_id' => $shopId
            ]);
            $isFavorite = true;
        }
        return response()->json(['success' => true, 'is_favorite' => $isFavorite]);
    }

    public function detail($id)
    {
        $shop = Shop::findOrFail($id);

        return view('detail', compact('shop'));
    }

    public function reservation(Request $request) {
        Reservation::create([
            'shop_id' => $request->shop_id,
            'user_id' => Auth::id(),
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
        ]);
        return view('reservation_thanks');
    }
}
