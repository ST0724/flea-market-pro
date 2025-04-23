@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
@endsection

@section('content')
    <div class="content">
        <div class="user">
            <div class="user__image">
                <img src="{{ asset('storage/'. $user['image']) }}" alt="画像" class="user__image--icon" accept=".png, .jpeg, .jpg">
                <div class="user__information">
                    <h2 class="user__image--name">{{ $user['name'] }}</h2>
                    @if($rating !==0)
                        <div class="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $rating)
                                    <span class="star filled">&#9733;</span>
                                @else
                                    <span class="star">&#9733;</span>
                                @endif
                            @endfor
                        </div>
                    @endif
                </div>
            </div>
            <div class="user__profile-edit">
                <button class="user__profile-edit--button" onclick="location.href='/mypage/profile'">プロフィールを編集</button>
            </div>
        </div>

        <div class="category">
            <a href="{{ url('/mypage?tab=sell') }}" class="category__title {{ request()->fullUrlIs(url('/mypage?tab=sell')) ? 'active' : '' }}">出品した商品</a>
            <a href="{{ url('/mypage?tab=buy') }}" class="category__title {{ request()->fullUrlIs(url('/mypage?tab=buy')) ? 'active' : '' }}">購入した商品</a>
            <a href="{{ url('/mypage?tab=haggling') }}" class="category__title {{ request()->fullUrlIs(url('/mypage?tab=haggling')) ? 'active' : '' }}">
                取引中の商品
                @if($total_unread_count > 0)
                    <span class="badge category__badge">{{ $total_unread_count }}</span>
                @endif
            </a>
            
        </div>

        <div class="item">
            <div class="item__image">
                @foreach($items as $item)
                    <div class="item__card">
                        @php
                            $transaction = $item->transactions->first();
                        @endphp
                        @if(request('tab') == 'haggling' && $transaction)
                            <a href="/chat/{{ $transaction->id }}" class="item__card--link">
                        @else
                            <a href="/item/{{ $item->id }}" class="item__card--link">
                        @endif
                        @if($item->unread_message_count > 0)
                            <span class="badge item__badge">{{ $item->unread_message_count }}</span>
                        @endif
                        <img src="{{ asset('storage/'.$item['image']) }}" alt="画像" class="item__card--image">
                        <div class="item__card--info">
                            @if(!is_null($item['purchaser_id']))
                                <span class="sold">sold</span>
                            @endif
                            <span class="item__card--name">{{ $item['name'] }}</span>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection