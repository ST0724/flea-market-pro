@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}" />
@endsection

@section('content')
    <div class="content">
        <div class="side">
            <h3 class="side__title">その他の取引</h3>
            @foreach($others as $other)
                @php
                    // 取引中のTransaction（最初の1件）を取得
                    $transaction = $other->transactions->first();
                @endphp
                @if($transaction)
                    <div class="side__button">
                        <button class="side__button--submit" onclick="location.href='/chat/{{ $transaction->id }}'">
                            {{ $other->name }}
                        </button>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="main">
            <div class="title">
                <div class="title__user">
                    <img src="{{ asset('storage/'. $target['image']) }}" alt="画像" class="title__image" accept=".png, .jpeg, .jpg">
                    <h3 class="title__name">「{{$target['name']}}」さんとの取引画面</h3>
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

            <div class="history">
                @foreach($messages as $message)
                    @php
                        $isMine = $message->user_id === $user->id;
                    @endphp
                    <div class="history__message {{ $isMine ? 'history__message--right' : 'history__message--left' }}">
                        <div class="history__user {{ $isMine ? 'history__user--right' : 'history__user--left' }}">
                            <img class="history__user--image" src="{{ asset('storage/'. $message['user']['image']) }}" alt="画像">
                            <h4 class="history__user--name">{{ $message['user']['name'] }}</h4>
                        </div>
                        @if($message->image)
                            <div class="history__picture {{ $isMine ? 'history__picture--right' : 'history__picture--left' }}">
                                <img class="history__picture--image" src="{{ asset('storage/'. $message['image']) }}" alt="画像">
                            </div>
                        @endif
                        <div class="history__text">
                            <p>{{ $message['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <form  class="chat" action="/chat/{transaction_id}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="transaction_id" value="{{ $transaction_id }}">
                <div class="chat__textarea">
                    <textarea name="text" rows="1"></textarea>
                </div>
                <div class="chat__picture">
                    <label class="chat__picture--label" for="chat__picture">画像を選択する</label>
                        <input type="file" class="chat__picture--input" id="chat__picture" name="image">
                    <div class="form__error">
                        @error('image')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="chat__button">
                    <button class="chat__button--submit" type="submit">
                        <img class="chat__button--image" src="{{ asset('storage/inputbuttun 1.svg') }}" alt="ボタン">
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection