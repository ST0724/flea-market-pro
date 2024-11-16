@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('content')
会員登録画面だよ

<form class="form" action="/register" method="post">
@csrf
    名前<input type="text" name="name" value="{{ old('name') }}">
    メール<input type="email" name="email" value="{{ old('email') }}">
    パスワード<input type="password" name="password">
    パス再確認<input type="password" name="password_confirmation">
    <button>登録</button>
</form>

@endsection