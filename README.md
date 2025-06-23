# 環境お試し目的(tailwind+bun)  
## 環境  
<img alt="Static Badge" src="https://img.shields.io/badge/wsl2-w?style=plastic&logo=linux&logoColor=000000&labelColor=%23FCC624&color=%23FCC624"> <img alt="Static Badge" src="https://img.shields.io/badge/ubuntu-u?style=plastic&logo=ubuntu&logoColor=%23ffffff&labelColor=%23E95420&color=%23E95420"> <img alt="Static Badge" src="https://img.shields.io/badge/debian-l?style=plastic&logo=debian&logoColor=ffffff&labelColor=A81D33&color=A81D33">  
<img alt="Static Badge" src="https://img.shields.io/badge/Docker-d?style=plastic&logo=docker&logoColor=%23ffffff&labelColor=%232496ED&color=%232496ED">
<img alt="Static Badge" src="https://img.shields.io/badge/NGINX-n?style=plastic&logo=nginx&logoColor=%23ffffff">
<img alt="Static Badge" src="https://img.shields.io/badge/MySQL-m?style=plastic&logo=mysql&logoColor=%23ffffff&labelColor=%234479A1&color=%234479A1">
<img alt="Static Badge" src="https://img.shields.io/badge/php-p?style=plastic&logo=php&logoColor=%23ffffff&labelColor=%23777BB4&color=%23777BB4">  
<img alt="Static Badge" src="https://img.shields.io/badge/Laravel12-l?style=plastic&logo=laravel&logoColor=%23ffffff&labelColor=%23FF2D20&color=%23FF2D20">
<img alt="Static Badge" src="https://img.shields.io/badge/bun-b?style=plastic&logo=bun&logoColor=%23ffffff&labelColor=%23000000&color=%23000000">
<img alt="Static Badge" src="https://img.shields.io/badge/bootstrap-b?style=plastic&logo=bootstrap&logoColor=%23ffffff&labelColor=%237952B3&color=%237952B3">
<img alt="Static Badge" src="https://img.shields.io/badge/tailwind-%20?style=plastic&logo=tailwindcss&logoColor=ffffff&color=%2306B6D4">
<img alt="Static Badge" src="https://img.shields.io/badge/vite-v?style=plastic&logo=vite&logoColor=%23ffffff&labelColor=%23646CFF&color=%23646CFF">
<img alt="Static Badge" src="https://img.shields.io/badge/-breeze?style=plastic&logo=breeze&label=breeze&labelColor=c1c1c1&color=c1c1c1">  


## 構築手順  
#### 1. wsl使用の為、仮想マシン プラットフォームを有効化  
####  (wslがインストールされていない場合:Linuxカーネル更新プログラムパッケージを  
####  インストールする)  
#### 2. wsl --set-default-version 2 コマンドでLinuxを標準でWSL2上で動くように設定  
#### 3. wsl --list --verbose　コマンドでLinuxがWSL1とWSL2のどちらで動いているかを確認  
#### 4. ubuntuをインストール  
#### 5. terminalにてアカウント作成  
#### 6. 任意のフォルダ作成  
#### 7. Docker Desktopインストール  
#### 8. dockerでwslを使用する設定に変更  
#### 9. terminalに戻りdockerで使用するイメージのフォルダ構成作成  
#### 10. Dockerfileにて、使用するイメージ作成の設定  
#### 11. composer.ymlにて作成するコンテナの初期状態を  
#### 「ports:」「volumes:」などYAML形式を用いて定義。  
#### 12. その他の使用するイメージの設定ファイル(my.cnf、default.conf)作成  
#### 13. docker compose up -d　コマンドを実行してコンテナの作成・起動  
#### 14. docker exec -it conteinerID bashでコンテナにはいる  
#### 15. 以降はLaravel12の環境構築  
#### ※bunインストールがalpineだとうまくいかなかった為、今回はphp-fpm(debian)を使用
#### 16. composer create-project laravel/laravel example　コマンドでLaravelプロジェクトの作成  
#### 17．cd example  
#### 18. php artisan serve --host 0.0.0.0　コマンドで開発サーバーを起動
#### ※初回のみ実施、以降はdocker compose up -dでDoker起動 
#### ※エラー：failed to open stream: Permission denied  
#### chmod -R 777 storage　コマンドで解消  
#### 19. mysql使用の為、".env"の下記内容を修正
#### DB_CONNECTION=mysql　sqlite→mysql  
#### DB_HOST=127.0.0.1　使用しているdb名に修正  
#### DB_HOST以降からDB_PASSWORDまでのコメントアウト解除及び、自身で設定した内容への修正を行う  
#### 20. php artisan migrate　コマンドでマイグレーション仕直す  
#### ※dbはお好みでどうぞ、sqliteを使用する場合は上記手順は不要  
#### 21. composer require laravel/breeze --dev　コマンドでbreezeパッケージインストール
#### 22. php artisan breeze:install　コマンドでbreezeインストール  
#### 23. bun install　コマンドでbunインストール  
#### ※インストールが上手くいかないときは、下記コマンド実行してからインストール  
#### ※bun upgrade  
#### 24. bun run build　コマンド実行  
#### 25. composer require --dev "squizlabs/php_codesniffer=*"　コマンドでPHP_CodeSniffierのインストール  
#### 26.composer require --dev barryvdh/laravel-debugbar　コマンドでLaravel Debugbarのインストール  
#### 27. php artisan lang:publish　コマンドでlangフォルダ作成  
#### 28. composer require laravel-lang/lang:~8.0　コマンドで翻訳ファイル取得  
#### 29. cp ./vendor/laravel-lang/lang/json/ja.json ./lang/　コマンドで作成された ja.json アプリケーションのディレクトリにコピー  
#### 30. cp -r ./vendor/laravel-lang/lang/src/ja ./lang/　コマンドで と ja ディレクトリをアプリケーションのディレクトリにコピー  
#### 31. php artisan install:api　コマンドでAPIルーティングを有効にする  
#### 32. tailwind.config.jsにてtailwindを使用する設定を行う。  
#### 33. bun install chart.js　コマンドでグラフ用packageインストール  
#### ※laravel12再度表示確認  
#### ※個人お試し用以外での用途は非推奨  
## git cloneg後  
#### 1. docker exec -it conteinerID bashでコンテナにはいる  
#### 2．cd example　コマンド実行  
#### 3. composer update　コマンド実行でautoload.php作成  
#### 4. cp .env.example .env　コマンドで.env作成  
#### 5. php artisan key:generate　コマンド実行  
#### 6. php artisan migrate　コマンド実行でdb再度作成  
#### 7. bun install　コマンドでbunインストール  
#### 8. bun run build　コマンド実行  
## 参考  
[参考サイト](https://www.kamome-susume.com/laratto-overview/)  
※laravel9使用の内容が記載されている。  
※本repositoryは、laravel12及びbunを使用し、blade　compornent使用に変更した内容で構築。  
※参考サイトに記載がないが、必要そうな処理を独自に主観的な内容で追加している。  
## 比較  
#### bunを使用したが特に不自由は感じなかった。  
## 所感  
#### バージョンが古いので読替えて構築するので大変だったが、ある程度基本的な内容の復習の役にたった。  
#### フロントからの構築内容だったので難しく思えた。  
#### modelでデータ加工を行う構築の仕方の役にたった。  
#### 内容をすべて理解するのに、コーディングを試行している数が足りないのが分かった。  
#### seederについて学習することができた。