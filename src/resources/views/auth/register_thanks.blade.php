@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth_thanks.css') }}">
@endsection

@section('main')
@component('components.nav_auth')
@endcomponent
<div class="auth">
    <div class="auth-parent">
        <div class="auth__content">
            <p>会員登録ありがとうございます</p>
            <a href="/login">ログインする</a>
        </div>
    </div>
</div>
@endsection
