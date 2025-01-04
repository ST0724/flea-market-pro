@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}" />
@endsection

@section('content')
<div class="content">
        <h2 class="content__title">商品の出品</h2>

        <form class="form" action="/sell" method="post">
        @csrf
            <div class="form__group">
                <span class="form__label">商品画像</span>
                <div class="form__image">
                    <label class="form__icon--label" for="form__icon">画像を選択する</label>
                    <input type="file" class="form__icon--input" id="form__icon" name="image">
                </div>
                <div class="form__error">
                    @error('image')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <h3 class="title">商品の詳細</h3>

            <div class="form__group">
                <span class="form__label">カテゴリー</span>
                <div class="form__category">
                    @foreach ($categories as $category)
                        <input type="checkbox" class="form__category--input" name="categories[]" id="{{ $category['id'] }}" value="{{ $category['id'] }}">
                        <label for="{{ $category['id'] }}" class="form__category--label">{{ $category['name'] }}</label>
                    @endforeach
                </div>
            </div>

            <div class="form__group">
                <span class="form__label">商品の状態</span>
                <div class="form__group--select">
                    <select name="condition_id" value="{{ old('condition') }}">
                        <option value="">選択してください</option>
                        @foreach ($conditions as $condition)
                            <option value="{{ $condition['id'] }}">{{ $condition['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form__error">
                    @error('condition')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <h3 class="title">商品名と説明</h3>

            <div class="form__group">
                <span class="form__label">商品名</span>
                <div class="form__group--input">
                    <input type="text" name="name">
                </div>
                <div class="form__error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="form__group">
                <span class="form__label">商品の説明</span>
                <div class="form__group--input">
                    <textarea name="description"></textarea>
                </div>
                <div class="form__error">
                        @error('description')
                        {{ $message }}
                        @enderror
                </div>
            </div>

            <div class="form__group">
                <span class="form__label">販売価格</span>
                <div class="form__group--input input__price">
                    <input type="text" name="price">
                </div>
                <div class="form__error">
                    @error('price')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            
            <div class="form__button">
                <button class="form__button--submit" type="submit">出品する</button>
            </div>
        </form>
    </div>
@endsection