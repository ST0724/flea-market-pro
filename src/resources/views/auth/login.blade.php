@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('content')
ログインだよ
<form class="form" action="/login" method="post">
@csrf
    メール<input type="email" name="email" value="{{ old('email') }}">
    パスワード<input type="password" name="password">
    <button>ログイン</button>
</form>

@endsection