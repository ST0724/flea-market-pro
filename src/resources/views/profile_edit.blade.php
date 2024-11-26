@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile_edit.css') }}" />
@endsection

@section('content')
<div class="content">
        <h2 class="content__title">プロフィール設定</h2>

        <form class="form" action="/mypage/profile" method="post">
        @csrf
            <div class="form__group">
                <div class="form__icon">
                    <img src="" alt="画像" class="form__icon--image">

                    <input type="file" class="form__icon--input" name="image">
                    <div class="form__error">
                        @error('image')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group--title">
                    <span class="form__label">ユーザー名</span>
                </div>
                <div class="form__group--input">
                    <input type="text" name="name" value="{{ old('name') }}">
                </div>
                <div class="form__error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="form__group">
                <div class="form__group--title">
                    <span class="form__label">郵便番号</span>
                </div>
                <div class="form__group--input">
                    <input type="text" name="email" value="{{ old('email') }}">
                </div>
                <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="form__group">
                <div class="form__group--title">
                    <span class="form__label">住所</span>
                </div>
                <div class="form__group--input">
                    <input type="password" name="password">
                </div>
                <div class="form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="form__group">
                <div class="form__group--title">
                    <span class="form__label">建物名</span>
                </div>
                <div class="form__group--input">
                    <input type="password" name="password_confirmation">
                </div>
                <div class="form__error">
                    @error('password_confirmation')
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