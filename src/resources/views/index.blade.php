@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
{{-- @if( Auth::check() ) --}}
@component('components.nav')
@endcomponent
<div class="content">
    <div class="content__search">
        <form class="search__form" action="/search" method="get">
            <select class="search__form--select" name="area_id" id="area_id">
                <option value="" {{ request('area_id')=='' ? 'selected' : '' }}>All area</option>
                @foreach ($areas as $area)
                <option value="{{ $area->id }}" {{ request('area_id')==$area->id ? 'selected' : '' }}>{{ $area->name }}
                </option>
                @endforeach
            </select>
            <span>|</span>
            <select class="search__form--select" name="genre_id" id="genre_id">
                <option value="" {{ request('genre_id')=='' ? 'selected' : '' }}>
                    All genre</option>
                @foreach ($genres as $genre)
                <option value="{{ $genre->id }}" {{ request('genre_id')==$genre->id ? 'selected' : '' }}>{{ $genre->name
                    }}</option>
                @endforeach
            </select>
            <span>|</span>
            <button class="search__form--button">
                <i class="bi bi-search" id="search"></i>
            </button>
            <input class="search__form--input" type="text" name="shop_name" value="{{ request('shop_name') }}"
                placeholder="Search ...">
        </form>
    </div>
    <div class="card">
        <div class="card-content">
            @foreach ($shops as $shop)
            <div class="practice__card">
                <div class="card__img">
                    <img src="{{ $shop->image_path }}" alt="{{ $shop->shop_name }}" width="300" height="200">
                </div>
                <div class="card__article">
                    <div class="card__ttl">
                        <h2>{{ $shop->shop_name }}</h2>
                    </div>
                    <div class="tag">
                        <p class="card__tag">#{{ $shop->areas->name }} #{{ $shop->genres->name }}</p>
                    </div>
                    <div class="card__button">
                        <a class="card__button--link" href="/">詳しくみる</a>
                        <div class="heart_false" data-shop-id="{{ $shop->id }}"><i class="bi bi-suit-heart-fill"
                                id="heart"></i></div>
                    </div>
                </div>
            </div>
            @endforeach
            <script src="js/heart.js"></script>
        </div>
    </div>
    {{-- @endif --}}
</div>
<div class="error__message">
    @if(isset($message))
    {{ $message }}
</div>
@endif
@endsection
