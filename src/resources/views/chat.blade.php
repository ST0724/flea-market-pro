@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}" />
@endsection

@section('content')
    <div class="content">
        <div class="side">さいどばー</div>

        <div class="main">
            <div class="title">
                <div class="title__user">
                    <img src="{{ asset('storage/'. $partner['image']) }}" alt="画像" class="title__image" accept=".png, .jpeg, .jpg">
                    <h3 class="title__name">「{{$partner['name']}}」さんとの取引画面</h3>
                </div>
                 @if($item['seller_id'] !== Auth::id())
                    <form class="transaction-form" action="/chat/completed{{ $transaction_id }}" method="POST">
                        @csrf
                        <div class="completed__button">
                            <button class="completed__button--submit">取引を完了する</button>
                        </div>
                    </form>
                @endif
            </div>
            <div class="item">
                <div class="item__image">
                    <img src="{{ asset('storage/'.$item['image']) }}" alt="画像">
                </div>
                <div class="item__detail">
                    <h3 class="item__detail--name"> {{ $item['name'] }}</h3>
                    <p class="item__detail--price"><span>￥</span>{{ number_format($item['price']) }}<span>(税込み)</span></p>
                </div>
            </div>
            <div class="chat">
                <div class="chat__user">
                    <img class="chat__user--image" src="{{ asset('storage/'. $user['image']) }}" alt="画像">
                    <h4 class="chat__user--name">{{ $user['name'] }}</h4>
                </div>

            </div>
        </div>
    </div>

@endsection