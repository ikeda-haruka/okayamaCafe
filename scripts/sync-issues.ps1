# GitHub Issues 一括同期スクリプト
# 実行方法: powershell -ExecutionPolicy Bypass -File scripts\sync-issues.ps1

$repo = "ikeda-haruka/okayamaCafe"

Write-Host "=== GitHub Issues 同期開始 ===" -ForegroundColor Cyan

# 認証チェック
$authStatus = gh auth status 2>&1
if ($LASTEXITCODE -ne 0) {
    Write-Host "[ERROR] GitHub CLI (gh) にログインしていません。" -ForegroundColor Red
    Write-Host "以下のコマンドを実行してブラウザからログインしてください：" -ForegroundColor Yellow
    Write-Host "  gh auth login -w -h github.com" -ForegroundColor White
    exit 1
}

Write-Host "[OK] GitHub CLI 認証確認完了" -ForegroundColor Green

# 同期するIssueリスト
$issues = @(
    @{
        title = "[Phase 1] 岡山地産地消カフェ「CAFE HAREKA」Reactフロントエンド基本実装"
        body = @"
## 概要
岡山県で新しくオープンする架空の地産地消カフェ「CAFE HAREKA（晴果）」のWebサイト制作。
果物のおいしさ、自然、温かい雰囲気、行きたくなる魅力を伝えるWebサイトを構築。

## 実装内容
- React 19 + TypeScript + Vite 8 + Tailwind CSS v4
- framer-motion によるアニメーション演出
- レスポンシブデザイン（モバイル完全最適化、下部固定バー）
- 全7ページ（ホーム、お店について、メニュー、岡山の果物、お知らせ、アクセス、お問い合わせ）
- ポートフォリオ実績用の架空サイト案内バナー常時固定

## ステータス
- [x] 設計・コーディング完了
- [x] ビルド検証完了
"@
        label = "enhancement"
        state = "closed"
    },
    @{
        title = "[Phase 2] 実写クオリティAI商品写真の生成と画像アセットの最適化"
        body = @"
## 概要
岡山特産の果物・メニューに正確に合致した実写クオリティのAI画像アセットを用意・最適化。

## 実装内容
- 岡山県産 清水白桃の極上パフェ
- 晴王（シャインマスカット）のエメラルドタルト
- ニューピオーネ（ぶどう房）
- 足守アールスメロン
- おかやま夢白桃
- HAREKA特製 岡山果実のバターサンド（4個入BOX）
- 岡山県産 旬果コンフィチュール（白桃・マスカット）
- 千屋牛ローストビーフの贅沢プレート

## ステータス
- [x] 全画像生成・差し替え完了
- [x] テーマアセットへの配置完了
"@
        label = "documentation"
        state = "closed"
    },
    @{
        title = "[Phase 3] 席予約フォームの空き枠判別・満席誤予約防止・仮予約ワークフロー実装"
        body = @"
## 概要
Webフォームからの予約時に、満席枠の誤予約を防止し、リアルタイムで空き状況を判別・選択できるセレクトUIおよび仮予約制フローを実装。

## 実装内容
- 時間帯別リアルタイム空き状況（◎余裕あり / △残り1組 / ✕満席クリック不可）
- 水曜定休日の自動判定と予約ロック（アラート表示）
- 受付番号発行（`HRK-YYYYMMDD-XXXX`）
- 24時間以内の本確定通知を前提とする「仮予約」ガイダンス表示
- FAQアコーディオン開閉UI

## ステータス
- [x] Reactフロントエンド実装完了
- [x] WordPressテーマ側（main.js）実装完了
"@
        label = "enhancement"
        state = "closed"
    },
    @{
        title = "[Phase 4] WordPressハイブリッドCMS化対応（自作テーマ hareka-theme 制作）"
        body = @"
## 概要
サイトをWordPressでCMS化し、店舗スタッフがメニューや果物情報を管理画面から更新できるように対応。
通常テーマ運用とヘッドレスCMS運用の双方に対応できるハイブリッド構成を実現。

## 実装内容
- テーマフォルダ `wordpress-theme/hareka-theme` 制作
- カスタム投稿タイプ「カフェメニュー (`menu_item`)」「岡山の果物 (`fruit_info`)」登録
- カスタムタクソノミー「メニューカテゴリ (`menu_category`)」
- カスタムメタボックス（価格、産地、糖度、季節限定、テイクアウトフラグ）
- REST API エクスポート（ヘッドレス連携用）
- React側ヘッドレスクライアントモジュール (`src/services/wordpress.ts`, `.env.example`)
- テーマ導入・運用マニュアル (`wordpress-theme/README.md`)

## ステータス
- [x] テーマテンプレート一式制作完了
- [x] REST API連携モジュール実装完了
"@
        label = "enhancement"
        state = "closed"
    },
    @{
        title = "[Phase 5] 投稿ページ用「お知らせ一覧（home.php / page-news.php）」の実装"
        body = @"
## 概要
WordPress管理画面の「表示設定」で「投稿ページ」に指定できるお知らせ用テンプレートおよびReact側のお知らせページを新規作成。

## 実装内容
- WordPress用 `home.php`（投稿ページ用メインテンプレート）
- WordPress用 `page-news.php`（固定ページテンプレート）
- WordPress用 `archive.php`（カテゴリ別アーカイブ）
- カテゴリ別絞り込みタブ、記事一覧カード、ページネーション
- React用 `src/pages/NewsPage.tsx` および詳細モーダルUI
- 各ヘッダー・トップページからのリンク導線整備

## ステータス
- [x] テンプレート作成完了
- [x] ルーティング・ナビゲーション連携完了
"@
        label = "enhancement"
        state = "closed"
    },
    @{
        title = "[Phase 6] ローカルWordPress環境（LocalWP）構築・固定ページ初期設定"
        body = @"
## 概要
LocalWPを使用してローカル環境でWordPressを稼働させ、自作テーマ `hareka-theme` を有効化し、7つの推奨固定ページを作成して表示設定を完了する。

## 実装内容
- LocalWPでのサイト作成（`okayama-cafe`）
- テーマの配置（`wp-content/themes/hareka-theme`）
- 固定ページ7つの作成（ホーム、お知らせ、お店について、メニュー、果物、アクセス、お問い合わせ）
- 「表示設定」でのホームページ（ホーム）＆投稿ページ（お知らせ）割り当て
- パーマリンク設定の更新（投稿名）

## ステータス
- [x] LocalWP環境構築完了
- [x] 固定ページ7種作成完了
- [x] 表示設定保存完了
"@
        label = "documentation"
        state = "closed"
    },
    @{
        title = "[Phase 7] 無料ホスティング（InfinityFree）へのサイト移行・本番公開"
        body = @"
## 概要
ローカル環境で完成したWordPressサイト（デザイン・設定・投稿データ一式）を、無料ホスティング「InfinityFree」へ移行・一般公開する。

## 作業タスク
- [ ] InfinityFreeアカウント作成
- [ ] 無料サブドメインの取得
- [ ] WordPressの専用ディレクトリ（`/wp/`）インストール
- [ ] All-in-One WP Migration 等によるローカルデータのエクスポート＆インポート
- [ ] 独自URL・SSLの動作確認および最終検証
"@
        label = "in-progress"
        state = "open"
    }
)

foreach ($item in $issues) {
    Write-Host "Creating Issue: $($item.title) ..." -ForegroundColor Yellow
    $issueUrl = gh issue create --repo $repo --title $item.title --body $item.body
    Write-Host "Created: $issueUrl" -ForegroundColor Green

    if ($item.state -eq "closed") {
        # Issue番号を抽出してクローズ
        $issueNum = ($issueUrl -split '/')[-1]
        gh issue close $issueNum --repo $repo --comment "タスク完了に伴いクローズしました。"
        Write-Host "Closed Issue #$issueNum" -ForegroundColor DarkGray
    }
}

Write-Host "=== GitHub Issues 同期完了 ===" -ForegroundColor Cyan
