@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
@endsection

@section('content')
<div class="content">
    <form class="form" action="/purchase/{{ $item['id'] }}" method="post">
        @csrf
        <div class="left-contents">
            <div class="left-contents__first">
                <div class="left-contents__image">
                    <img src="{{ asset('storage/'.$item['image']) }}" alt="画像">
                </div>
                <div class="left-contents__information">
                    <h3 class="left-contents__name">{{ $item['name'] }}</h3>
                    <p class="left-contents__price"><span>￥</span>{{ number_format($item['price']) }}</p>
                </div>
            </div>
            <div class="left-contents__second">
                <h4>支払い方法</h4>
                <div class="left-contents__select">
                        <select name="payment" value="">
                            <option value="" style="display:none;">選択してください</option>
                            <option value="1">コンビニ払い</option>
                            <option value="2">カード支払い</option>
                        </select>
                    </div>
                    <div class="form__error">
                        @error('payment')
                        {{ $message }}
                        @enderror
                    </div>
            </div>
            <div class="left-contents__third">
                <div class="left-contents__third--sub">
                    <h4>配送先</h4>
                    <a href="/purchase/address/{{ $item['id'] }}">変更する</a>
                </div>
                <div class="left-contents__address">
                    <p class="left-contents__post-code"><span>〒</span>{{ $destination['post_code'] }}</p>
                    <p class="left-contents__address">{{ $destination['address'] }}</p>
                    <p class="left-contents__building">{{ $destination['building'] }}</p>
                </div>
            </div>
        </div>

        <div class="right-contents">
            <div class="right-contents__wrap">
                <div class="right-contents__information">
                    <p class="right-contents__information--title">商品代金</p>
                    <p class="right-contents__information--price"><span>￥</span>{{ number_format($item['price']) }}</p>
                </div>
                <div class="right-contents__information">
                    <p class="right-contents__information--title">支払い方法</p>
                    <!-- JavaScript実装まで仮文字のみ -->
                    <p class="right-contents__information--payment">コンビニ払い</p>
                </div>
            </div>
            <div class="right-contents__purchase">
                <button class="purchase__button--submit">購入する</button>
            </div>
        </div>
    </form>
</div>
@endsection