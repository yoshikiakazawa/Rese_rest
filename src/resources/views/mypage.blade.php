@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('main')
@if(Auth::check())
@component('components.nav')
@endcomponent
@endif
<div class="mypage__grid-parent">
    <div class="mypage__login-name">{{$user->name}}さん</div>
    <div class="reservation-status">
        <div class="reservation-status__ttl">
            <span>予約状況</span>
            <span class="reservation-status__ttl--link">来店履歴は<a href="{{ route('history') }}">コチラ</a></span>
        </div>
        @if ($reservations->isEmpty())
        <div class="reservation-status__ttl--empty-message">
            <p>予約済みの店舗はありません。</p>
        </div>
        @else
        <div class="flash_message">
            @if (session('message_reservation'))
            {{ session('message_reservation') }}
            @endif
        </div>
        @foreach ($reservations as $index => $reservation)
        <div class="reservation-status__detail">
            <div class="reservation-status__detail--header">
                <label for="modal-toggle-{{$reservation->id}}" class="reservation-status__modal--label"><i
                        class="bi bi-pencil-square"></i></label>
                <input type="checkbox" id="modal-toggle-{{$reservation->id}}" class="modal-toggle">
                <div class="modal">
                    <form action="{{route('update_reservation')}}" method="post">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" name="id" value="{{$reservation->id}}">
                        <table class="reservation-status__modal--table">
                            <tr class="reservation-status__modal--table-inner">
                                <th class="reservation-status__modal--table-header">Shop</th>
                                <td class="reservation-status__modal--table-text">
                                    <p class="reservation-status__modal--table-text-shop">{{
                                        $reservation->shops->shop_name }}</p>
                                </td>
                            </tr>
                            <tr class="reservation-status__modal--table-inner">
                                <th class="reservation-status__modal--table-header">Date</th>
                                <td class="reservation-status__modal--table-text">
                                    <input class="reservation-status__modal--table-text-date" name="date" type="date"
                                        value="{{ $reservation->date }}">
                                </td>
                            </tr>
                            <tr class="reservation-status__modal--table-inner">
                                <th class="reservation-status__modal--table-header">Time</th>
                                <td class="reservation-status__modal--table-text">
                                    <input class="reservation-status__modal--table-text-time" name="time" type="time"
                                        value="{{ $reservation->time }}">
                                </td>
                            </tr>
                            <tr class="reservation-status__modal--table-inner">
                                <th class="reservation-status__modal--table-header">Number</th>
                                <td class="reservation-status__modal--table-text">
                                    <input class="reservation-status__modal--table-text-number" name="number"
                                        type="text" value="{{ $reservation->number }}">
                                </td>
                            </tr>
                        </table>
                        <div class="reservation-status__modal--button">
                            <label class="reservation-status__modal--button-close"
                                for="modal-toggle-{{$reservation->id}}"><i class="bi bi-reply-fill"></i></label>
                            <button class="reservation-status__update--button-submit" type="submit">修正</button>
                        </div>
                    </form>
                </div>
                <p class="reservation-status__detail--header-ttl">予約 {{ $index + 1 }}</p>
                <form onsubmit="return confirm('本当に削除しますか？')" action="{{route('delete_reservation')}}" method="post">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="id" value="{{$reservation->id}}">
                    <button class="reservation-status__detail--header-delete-button-submit" type="submit"><i
                            class="bi bi-eraser-fill"></i></button>
                </form>
            </div>
            <table class="reservation-status__table">
                <tr class="reservation-status__table--inner">
                    <th class="reservation-status__table--header">Shop</th>
                    <td class="reservation-status__table--text">
                        <p class="reservation-status__table--text-shop">{{ $reservation->shops->shop_name }}</p>
                    </td>
                </tr>
                <tr class="reservation-status__table--inner">
                    <th class="reservation-status__table--header">Date</th>
                    <td class="reservation-status__table--text">
                        <p class="reservation-status__table--text-date">{{ $reservation->date }}</p>
                    </td>
                </tr>
                <tr class="reservation-status__table--inner">
                    <th class="reservation-status__table--header">Time</th>
                    <td class="reservation-status__table--text">
                        <p class="reservation-status__table--text-time">{{ $reservation->time }}</p>
                    </td>
                </tr>
                <tr class="reservation-status__table--inner">
                    <th class="reservation-status__table--header">Number</th>
                    <td class="reservation-status__table--text">
                        <p class="reservation-status__table--text-number">{{ $reservation->number }}</p>
                    </td>
                </tr>
            </table>
            <div class="reservation-status__qr">
                <label for="qr-modal__toggle-{{$reservation->id}}" class="qr-modal__button--open">チェックイン</label>
                <input type="checkbox" id="qr-modal__toggle-{{$reservation->id}}" class="qr-modal__toggle">
                <div class="qr-modal">
                    <label for="qr-modal__toggle-{{$reservation->id}}" class="qr-modal__button--close"><i
                            class="bi bi-x-circle"></i></label>
                    <span class="qr-modal__span">
                        {!! QrCode::size(100)->generate( $user->id/$reservation->id ); !!}
                    </span>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <div class="favorite-shop__detail">
        <div class="favorite-shop__ttl">お気に入り店舗</div>
        @if ($favoriteShops->isEmpty())
        <div class="favorite-shop__ttl--empty-message">
            <p>お気に入りに登録された店舗はありません。</p>
        </div>
        @else
        <div class="flash_message">
            @if (session('message_favorite'))
            {{ session('message_favorite') }}
            @endif
        </div>
        <div class="favorite-shop__list">
            <div class="favorite-shop__list--grid-parent">
                @foreach ($favoriteShops as $favoriteShop)
                <div class="favorite-shop__card">
                    <div class="favorite-shop__card--img">
                        <img src="{{ $favoriteShop->image_path }}" alt="{{ $favoriteShop->shop_name }}">
                    </div>
                    <div class="favorite-shop__card--article">
                        <div class="favorite-shop__card--ttl">
                            <h2 class="favorite-shop__card--ttl-h2">{{ $favoriteShop->shop_name }}</h2>
                        </div>
                        <div class="tag">
                            <p class="favorite-shop__card--tag">#{{ $favoriteShop->areas->name }}
                                #{{$favoriteShop->genres->name }}</p>
                        </div>
                        <div class="favorite-shop__card--button">
                            <a class="favorite-shop__card--button--link"
                                href="{{ route('detail', $favoriteShop->id) }}">詳しくみる</a>
                            <div class="heart">
                                <form action="{{route('delete_favorite')}}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <input type="hidden" name="id" value="{{$favoriteShop->id}}">
                                    <button class="heart__delete-button--submit" type="submit">
                                        <i class="bi bi-suit-heart-fill" id="heart"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
