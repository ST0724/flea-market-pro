@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}" />
@endsection

@section('content')
 <div class="content">
    <div class="left-contents">
        <div class="image">
            <img src="{{ asset('storage/'.$item['image']) }}" alt="画像">
        </div>
    </div>

    <div class="right-contents">
        <h3 class="name">{{ $item['name'] }}</h3>
        <p class="price"><span>￥</span>{{ number_format($item['price']) }}<span>(税込み)</span></p>
        <div class="icon">
            <form class="like-form" action="/like/{{ $item['id'] }}" method="POST">
                @csrf
                <div class="icon__like">
                    @if($isLiked)
                        <input class="icon__like--image" type="image" src="{{ asset('storage/星アイコン6.png') }}" alt="いいね解除" title="いいね解除">
                    @else
                        <input class="icon__like--image" type="image" src="{{ asset('storage/星アイコン8.png') }}" alt="いいね" title="いいね">
                    @endif
                    <p class="icon__like--count">{{ $count_likes }}</p>
                </div>
            </form>
            <div class="icon__comment">
                <img src="{{ asset('storage/ふきだしのアイコン.svg') }}" alt="画像">
                <p class="icon__comment--count">{{ $count_comments }}</p>
            </div>
        </div>
        <div class="purchase__button">
            <button class="purchase__button--submit" onclick="location.href='/purchase/{{ $item['id'] }}'">購入手続きへ</button>
        </div>

        <div class="description">
            <h3 class="title">商品説明</h3>
            <p>{{ $item['description'] }}</p>
        </div>
        <div class="information">
            <h3 class="title">商品情報</h3>
            <div class="category">
                <h4 class="sub-title">カテゴリー</h4>
                <div class="category__item">
                    @foreach ($categories as $category)
                        <label class="category__item--label">{{ $category['name'] }}</label>
                    @endforeach
                </div>
            </div>
            <div class="condition">
                <h4 class="sub-title">商品の状態</h4>
                <p>{{ $item['condition']['name'] }}</p>
            </div>
        </div>

        <div class="comment">
            <h3 class="title">コメント({{ $count_comments }})</h3>
            @foreach($comments as $comment)
                <div class="comment__user">
                    <img class="comment__user--image" src="{{ asset('storage/'. $comment['user']['image']) }}" alt="画像">
                    <h4 class="comment__user--name">{{ $comment['user']['name'] }}</h4>
                </div>
                <div class="comment__text">
                    <p>{{ $comment['text'] }}</p>
                </div>
            @endforeach
        </div>
        <form action="/item/{{ $item['id'] }}" class="comment-form" method="post">
            @csrf
            <h4 class="sub-title__comment">商品へのコメント</h4>
            <div class="comment-form__text">
                <textarea name="text"></textarea>
            </div>
            <div class="form__error">
                @error('text')
                {{ $message }}
                @enderror
            </div>
            <div class="comment__button">
                <button class="comment__button--submit">コメントを送信する</button>
            </div>
        </form>
 </div>
@endsection