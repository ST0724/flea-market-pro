@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
    <div class="content">
        <div class="category">
                <h3 class="category__recommend">おすすめ</h3>
                <h3 class="category__mylist">マイリスト</h3>
            </div>

            <div class="item">
                <div class="item__image">
                    @foreach($items as $item)
                        <div class="item__card">
                            <a href="/item/{{ $item['id'] }}" class="item__card--link">
                                <img src="{{ asset($item['image']) }}" alt="画像" class="item__card--image">
                                <div class="item__card--info">
                                    <span>{{ $item['name'] }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        
        
    </div>
@endsection