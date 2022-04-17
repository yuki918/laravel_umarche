## インストール方法

## ダウンロード方法
最終バージョンのダウンロード
git clone https://github.com/yuki918/laravel_umarche.git

特定のブランチのダウンロード
git clone -b ブランチ名 https://github.com/yuki918/laravel_umarche.git

## インストール方法
1. コマンドの入力
- cd laravel_umarche
- composer install
- npm install
- npm run watch

2. .env.sampleファイルをコピーして、.envファイルを作成する

3. .envファイルの下記を利用環境に合わせて、変更する
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_umarche
DB_USERNAME=umarche
DB_PASSWORD=umarche1589

4. 開発環境でDBを起動後にマイグレーションを行う
データベーステーブルとダミーデータが追加される
php artisan migrate:fresh --seed

5. キーの生成
php artisan key:generate

6. php artisan serve

## インストール後の実施事項
画像のダミーデータはpublic/imgフォルダ内に、
sample01.jpg~sample06.jpgとして保存されています。

「php artisan storage:link」でstorageフォルダにリンク後、
storage/app/public/prodauctsフォルダ内に保存すると表示されます。
※productsフォルダがない場合は、作成してください。

ショップの画像も表示する場合は、
storage/app/public/shopsフォルダを作成して、画像を保存してください。

## 決済について
決済のテストしてstripeを利用しています。
必要な場合は、.envファイルにstripeの情報を追記してください。

## メールについて
商品が購入された際に、ユーザーとオーナーに自動返信メールが送信されます。
必要な場合は、.envファイルにmailtrapの情報を追記してください。

メール処理はキューで非同期処理をしています。
必要な場合は、下記のコマンドでワーカーを立ち上げてください
php artisan queuu:work