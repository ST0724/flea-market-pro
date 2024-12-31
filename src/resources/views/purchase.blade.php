@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
@endsection

@section('content')
<div class="content">
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
            <h4>配送先</h4>
            <div class="left-contents__address">
                <p class="left-contents__post-code"><span>〒</span>郵便番号</p>
                <p class="left-contents__address">住所</p>
                <p class="left-contents__building">建物名</p>
            </div>
        </div>
    </div>

    <div class="right-contents">
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
</div>
@endsection