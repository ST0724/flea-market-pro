@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}" />
@endsection

@section('content')
<div class="content">
        <h2 class="content__title">住所の変更</h2>

        <form class="form" action="/purchase/address/{{ $item['id'] }}" method="post">
            @csrf
            <div class="form__group">
                <div class="form__group--title">
                    <span class="form__label">郵便番号</span>
                </div>
                <div class="form__group--input">
                    <input type="text" name="post_code" value="{{ old('post_code') }}">
                </div>
                <div class="form__error">
                    @error('post_code')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="form__group">
                <div class="form__group--title">
                    <span class="form__label">住所</span>
                </div>
                <div class="form__group--input">
                    <input type="address" name="address" value="{{ old('address') }}">
                </div>
                <div class="form__error">
                    @error('address')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="form__group">
                <div class="form__group--title">
                    <span class="form__label">建物名</span>
                </div>
                <div class="form__group--input">
                    <input type="text" name="building" value="{{ old('building') }}">
                </div>
                <div class="form__error">
                    @error('building')
                    {{ $message }}
                    @enderror
                </div>
            </div>
            
            <div class="form__button">
                <button class="form__button--submit" type="submit">更新する</button>
            </div>
        </form>
    </div>
@endsection