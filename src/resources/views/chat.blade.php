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
                    $sideTransaction = $other->transactions->first();
                @endphp
                @if($sideTransaction)
                    <div class="side__button">
                        <button class="side__button--submit" onclick="location.href='/chat/{{ $sideTransaction->id }}'">
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
                    <div class="completed__button">
                        <button class="completed__button--submit" id="modal-open" 
                            @if($transaction->status !== 0) disabled @endif>
                            取引を完了する
                        </button>
                    </div>
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
                        @if($isMine)
                            <div class="history__edit">
                                <button class="history__edit-button">編集</button>
                                <form class="delete-form" action="/chat/{transaction_id}/delete" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <input type="hidden" name="message_id" value="{{ $message['id'] }}">
                                    <input type="hidden" name="transaction_id" value="{{ $transaction_id }}">
                                    <button class="history__delete-button">削除</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <form  class="chat" action="/chat/{transaction_id}" method="post" enctype="multipart/form-data" id="chatForm">
                @csrf
                <div class="form__error">
                    @error('text')
                        {{ $message }}
                    @enderror
                </div>
                <div class="form__error">
                    @error('image')
                        {{ $message }}
                    @enderror
                </div>
                <div class="chat__wrap">
                    <input type="hidden" name="transaction_id" value="{{ $transaction_id }}">
                    <div class="chat__textarea">
                        <textarea name="text" id="chatText" rows="1">{{ old('text') }}</textarea>
                    </div>
                    <div class="chat__picture">
                        <label class="chat__picture--label" for="chat__picture">画像を選択する</label>
                        <input type="file" class="chat__picture--input" id="chat__picture" name="image">
                    </div>
                    <div class="chat__button">
                        <button class="chat__button--submit" type="submit" id="sendBtn">
                            <img class="chat__button--image" src="{{ asset('storage/inputbuttun 1.svg') }}" alt="ボタン">
                        </button>
                    </div>
                </div>
            </form>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var saved = localStorage.getItem('chatText');
                    if (saved !== null) {
                        document.getElementById('chatText').value = saved;
                    }
                });

                document.getElementById('chatText').addEventListener('input', function() {
                    localStorage.setItem('chatText', this.value);
                });

                document.getElementById('chatForm').addEventListener('submit', function() {
                    localStorage.removeItem('chatText'); 
                });
            </script>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            // モーダルを開く
            $("#modal-open").click(function() {
                $("#modal-content").fadeIn("fast");
            });
            // モーダルを閉じる
            $("#modal-close").click(function() {
                $("#modal-content").fadeOut("fast");
            });

            @if($transaction->status == 1 && (int)$transaction->seller_id === (int)Auth::id())
                $("#modal-content").fadeIn("fast");
            @endif
        });
    </script>
    @include('modal')
@endsection