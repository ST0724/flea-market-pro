@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}" />
@endsection

@section('content')
 商品詳細画面だよ
 商品IDは<span>{{ $item['id'] }}</span>だよ
 商品名は<span>{{ $item['name'] }}</span>だよ
@endsection