# coachtechフリマ

## 環境構築
Dockerビルド
1. git clone git@github.com:ST0724/flea-market-pro.git
2. docker-compose up -d --build

Laravel環境構築
1. docker-compose exec php bash
2. composer install
3. cp .env.example .env
4. .envファイルの環境変数を適宜変更
5. php artisan key:generate
6. php artisan migrate
7. php artisan db:seed
8. php artisan storage:link

## 使用技術(実行環境)
+ Laravel 8.83.8

## テストアカウント
name:テストユーザー1   
email:test1@example.com  
password:test_user1  

name:テストユーザー2   
email:test2@example.com  
password:test_user2  

name:テストユーザー3   
email:test3@example.com  
password:test_user3  

## メール認証
mailtrapを使用しています。  
以下のリンクから会員登録をしてください。  
https://mailtrap.io/

メールボックスのIntegrations内、Code Samplesから 「PHP」タブ→「laravel 7.x and 8.x」を選択し、  
.envファイルのMAIL_MAILERからMAIL_ENCRYPTIONまでの項目をコピー＆ペーストしてください。  
MAIL_FROM_ADDRESSは任意のメールアドレスを入力してください。　

## ER図
![ER図](ER.png)

## URL
開発環境：[http://localhost/](http://localhost/)

## その他
取引中の商品が最初は存在しないため、購入処理と同時に取引中になる仕様にしています。   
そのため、商品を取引中にするためにはまず購入処理をお願いいたします。  
