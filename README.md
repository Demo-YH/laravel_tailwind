# 投稿・予約投稿管理アプリ(Laravel 12 + Vite + Tailwind)  

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

## プロジェクト概要  
参考サイトの手順をもとに学習目的で作成した小規模ブログ／投稿管理アプリです。  
学習用に作ったプロジェクトですが、設計や技術スタックは実務で使えるレベルを意識しています。

## 学習・検証目的
- MVC / Eloquent を用いたモデル設計・データ操作
- サービス層による責務分離・テスト容易性の確保
- バリデーション / フォームリクエストによる入力管理
- Vite + Tailwind によるフロントエンドビルドとモダンな開発フロー
- Docker Compose による複数コンテナ環境構築
- 予約投稿の概念を理解したスケジューリング設計

## 使用技術
| カテゴリ | 使用技術 |
| :--- | :--- |
| **Backend** | Laravel 12, breeze, PHP_CodeSniffer, Debugbar |
| **Frontend** | blade, Vite, Tailwind CSS, bun |
| **Infrastructure** | Docker Compose (App / Node / MySQL / Nginx) |
| **OS Environment** | WSL2 (Ubuntu / Alpine Linux) |
| **Database** | MySQL 8.x |

## セットアップ手順

### 1. インフラのビルドと起動
```bash
docker compose build
docker compose up -d
```

### 2. バックエンドの初期化
```
docker compose exec app bash
composer require laravel/breeze --dev
composer install
php artisan breeze:install
php artisan migrate
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```
### 3. フロントエンド依存関係
```
bun install
bun run build
``` 

## 設計・実装の特徴
- Post と ReservationPost を分離して、公開タイミングや状態管理を整理
- ビジネスロジックは app/Services に置き、コントローラの責務を薄く
- バリデーションは app/Http/Requests に集約
- サンプルデータは database/seeders で簡単に再現可能
- Vite を使ったモダンな開発ワークフロー（ホットリロード、ES モジュール対応）

## ディレクトリ構成
以下はこのリポジトリ内の主要なフォルダと役割の説明です（初心者向けの短い解説付き）。
- app/Models - Eloquent モデル
- app/Http/Controllers - ルーティング処理
- app/Http/Requests - フォームリクエスト
- app/Services - サービス層
- database/migrations / seeders / factories
- resources/views, resources/js, resources/css
- routes/ - web/api/auth
- tests/ - PHPUnit
- config/ - 設定ファイル

## 今後の展望
- サービス層・フォームリクエストの活用経験をさらに深める
- SPA 風の UI / UX を強化
- Vite + Tailwind によるフロントエンドビルド、モダンな SPA 開発フローの経験
- Docker マルチコンテナ運用経験のブラッシュアップ
- 予約投稿やスケジューリングの実務レベル実装経験