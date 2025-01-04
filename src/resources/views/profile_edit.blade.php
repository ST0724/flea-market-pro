@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile_edit.css') }}" />
@endsection

@section('content')
    <div class="content">
        <h2 class="content__title">プロフィール設定</h2>

        <form class="form" action="/mypage/profile" method="post">
            @method('PATCH')
            @csrf
            <div class="form__group">
                <div class="form__icon">
                    <img src="{{ asset('storage/'. $user['image']) }}" alt="画像" class="form__icon--image" accept=".png, .jpeg, .jpg">
                    <label class="form__icon--label" for="form__icon">画像を選択する</label>
                        <input type="file" class="form__icon--input" id="form__icon" name="image">
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
                    <input type="text" name="name" value="{{ $user['name'] }}">
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
                    <input type="text" name="post_code" value="{{ $user['post_code'] }}">
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
                    <input type="text" name="address" value="{{ $user['address'] }}">
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
                    <input type="text" name="building" value="{{ $user['building'] }}"">
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