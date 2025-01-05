@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
    <div class="content">
        <div class="category">
                <a href="{{ url('/') }}" class="category__title {{ request()->fullUrlIs(url('/')) ? 'active' : '' }}">おすすめ</a>
                <a href="{{ url('/?tab=mylist') }}" class="category__title {{ request()->fullUrlIs(url('/?tab=mylist')) ? 'active' : '' }}">マイリスト</a>
            </div>

            <div class="item">
                <div class="item__image">
                    @foreach($items as $item)
                        <div class="item__card">
                            <a href="/item/{{ $item['id'] }}" class="item__card--link">
                                <img src="{{ asset('storage/'.$item['image']) }}" alt="画像" class="item__card--image">
                                <div class="item__card--info">
                                    @if(!is_null($item['purchaser_id']))
                                        <span class="sold">sold</span>
                                    @endif
                                    <span>{{ $item['name'] }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        
        
    </div>
@endsection