@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/history.css') }}">
@endsection

@section('main')
@if(Auth::check())
@component('components.nav')
@endcomponent
@endif
<div class="history__grid-parent">
    <div class="history__login-name">{{$user->name}}さん</div>
    <div class="history">
        <div class="history__ttl">
            <span>来店履歴</span>
        </div>
        @if ($reservations->isEmpty())
        <div class="history__ttl--empty-message">
            <p>来店済みの店舗はありません。</p>
        </div>
        @else
        <div class="flash_message">
            @if (session('message_reservation'))
            {{ session('message_reservation') }}
            @endif
        </div>
        <div class="history__detail--grid-parent">
            @foreach ($reservations as $index => $reservation)
            <div class="history__detail">
                <div class="history__detail--header">
                    <p class="history__detail--header-ttl">来店 {{ $index + 1 }}</p>
                    <label for="modal-toggle-{{$reservation->id}}" class="history__modal--button-label"><i
                            class="bi bi-chat-left-heart-fill"></i></label>
                    <input type="checkbox" id="modal-toggle-{{$reservation->id}}" class="modal-toggle">
                    <div class="modal">
                        <form class="history__modal--form" action="{{route('update_reservation')}}" method="post">
                            @method('PATCH')
                            @csrf
                            <input type="hidden" name="id" value="{{$reservation->id}}">
                            <table class="history__modal--table">
                                <tr class="history__modal--table-inner">
                                    <th class="history__modal--table-header">Shop</th>
                                    <td class="history__modal--table-text">
                                        <p class="history__modal--table-text-shop">{{
                                            $reservation->shops->shop_name }}</p>
                                    </td>
                                </tr>
                                <tr class="history__modal--table-inner">
                                    <th class="history__modal--table-header"><label for="evaluation">Comment</label>
                                    </th>
                                    <td class="history__modal--table-text">
                                        <select class="history__modal--table-select" name="evaluation" id="evaluation">
                                            <option value="5">★★★★★</option>
                                            <option value="4">★★★★☆</option>
                                            <option value="3">★★★☆☆</option>
                                            <option value="2">★★☆☆☆</option>
                                            <option value="1">★☆☆☆☆</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="history__modal--table-inner">
                                    <td class="history__modal--table-text" colspan="2">
                                        <textarea class="history__modal--table-textarea" name="comment" id="comment"
                                            cols="10" rows="8"></textarea>
                                    </td>
                                </tr>
                            </table>
                            <div class="history__modal--button">
                                <label class="history__modal--button-close" for="modal-toggle-{{$reservation->id}}"><i
                                        class="bi bi-reply-fill"></i></label>
                                <button class="history__modal--button-submit" type="submit">送信</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="history__list">
                    <table class="history__table">
                        <tr class="history__table--inner">
                            <th class="history__table--header">Shop</th>
                            <td class="history__table--text">
                                <p class="history__table--text-shop">{{ $reservation->shops->shop_name }}</p>
                            </td>
                        </tr>
                        <tr class="history__table--inner">
                            <th class="history__table--header">Date</th>
                            <td class="history__table--text">
                                <p class="history__table--text-date">{{ $reservation->date }}</p>
                            </td>
                        </tr>
                        <tr class="history__table--inner">
                            <th class="history__table--header">Time</th>
                            <td class="history__table--text">
                                <p class="history__table--text-time">{{ $reservation->time }}</p>
                            </td>
                        </tr>
                        <tr class="history__table--inner">
                            <th class="history__table--header">Number</th>
                            <td class="history__table--text">
                                <p class="history__table--text-number">{{ $reservation->number }}</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
