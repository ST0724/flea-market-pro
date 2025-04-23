<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}" />
</head>
<body>

    <div id="modal-content">
        <form class="rating__form" action="/chat/{transaction_id}/rating" method="post">
            @csrf
            <div class="modal__title">
                <h3>取引が完了しました。</h3>
            </div>
            <div class="modal__question">
                <p class="modal__question--text">今回の取引相手はどうでしたか？</p>
                <div class="modal__star">
                    <input id="star5" type="radio" name="rating" value="5" />
                    <label for="star5" title="5点"></label>
                    <input id="star4" type="radio" name="rating" value="4" />
                    <label for="star4" title="4点"></label>
                    <input id="star3" type="radio" name="rating" value="3" />
                    <label for="star3" title="3点"></label>
                    <input id="star2" type="radio" name="rating" value="2" />
                    <label for="star2" title="2点"></label>
                    <input id="star1" type="radio" name="rating" value="1" />
                    <label for="star1" title="1点"></label>
                </div>
            </div>
            <div class="evaluation__button">
                <input type="hidden" name="transaction_id" value="{{ $transaction_id }}">
                <button class="evaluation__button--submit" id="modal-close">送信する</button>
            </div>
        </form>
    </div>
    
</body>
</html>