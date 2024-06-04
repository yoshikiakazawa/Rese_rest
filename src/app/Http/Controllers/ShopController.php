<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index() {
        $shops = Shop::with(['areas', 'genres'])->get();
        $areas = Area::all();
        $genres = Genre::all();
        return view('index', compact('shops', 'areas', 'genres'));
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

        if ($shops->isEmpty()) {
            return view('index', compact('shops', 'areas', 'genres'))->with('message', '検索結果がありません。');
        }

        return view('index', compact('shops', 'areas', 'genres'));

    }
    public function toggleFavorite(Request $request)
    {
        $shopId = $request->input('shop_id');
        $isFavorite = $request->input('is_favorite');

        // ユーザーのIDを取得
        $userId = Auth::id();

        // お気に入り状態をデータベースに保存
        if ($isFavorite) {
            // お気に入りに追加
            DB::table('favorites')->insert([
                'user_id' => $userId,
                'shop_id' => $shopId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
            // お気に入りから削除
            DB::table('favorites')
                ->where('user_id', $userId)
                ->where('shop_id', $shopId)
                ->delete();
        }
        return response()->json(['success' => true]);
    }
}
