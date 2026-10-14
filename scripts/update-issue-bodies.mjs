import { execSync } from 'child_process';
import fs from 'fs';
import path from 'path';

const repo = 'ikeda-haruka/okayamaCafe';

const issues = [
  {
    num: 1,
    title: '[Phase 1] 岡山地産地消カフェ「CAFE HAREKA」Reactフロントエンド基本実装',
    body: `## 🎯 概要
岡山県で新しくオープンする架空の地産地消カフェ「CAFE HAREKA（晴果）」のWebサイト制作。
果物のおいしさ、自然、温かい雰囲気、行きたくなる魅力を伝えるWebサイトを構築。

## 📋 実装内容
- **フレームワーク**: React 19 + TypeScript + Vite 8
- **スタイリング**: Tailwind CSS v4（岡山ピーチ＆マスカット＆ウッドのカラーパレット）
- **アニメーション**: framer-motion（スクロールイン、フェードイン演出）
- **レスポンシブデザイン**: スマートフォン・タブレット完全対応（下部固定クイックアクションバー付き）
- **ページ構成（全7ページ）**:
  1. ホーム (\`/\`)
  2. お店について (\`/about\`)
  3. メニュー (\`/menu\`)
  4. 岡山の果物 (\`/fruits\`)
  5. お知らせ (\`/news\`)
  6. アクセス (\`/access\`)
  7. お問い合わせ (\`/contact\`)
- **ポートフォリオ実績用注意喚起**: 画面最上部に常時固定（Sticky）される架空サイト案内バナー

## 🔍 検証結果
- [x] 設計・コーディング完了
- [x] \`npm run build\` エラーなし（Exit code 0）
`
  },
  {
    num: 2,
    title: '[Phase 2] 実写クオリティAI商品写真の生成と画像アセットの最適化',
    body: `## 🎯 概要
岡山特産の果物・メニューに正確に合致した実写クオリティの画像アセットを用意・最適化。

## 📋 実装・差し替え内容
- **清水白桃**: 岡山県産 清水白桃の極上パフェ (\`peach_parfait.jpg\`)
- **シャインマスカット**: 晴王のエメラルドタルト (\`muscat_tart.jpg\`)
- **ピオーネ**: 岡山県産 ニューピオーネぶどう房 (\`new_pione_vine.jpg\`)
- **足守メロン**: 伝統温室 足守アールスメロン (\`ashimori_melon.jpg\`)
- **白桃品種**: おかやま夢白桃 (\`yume_hakuto.jpg\`)
- **ギフト商品**: HAREKA特製 岡山果実のバターサンド 4個入BOX (\`butter_sand_box.jpg\`)
- **ギフト商品**: 岡山県産 旬果コンフィチュール瓶 (\`fruit_confiture.jpg\`)
- **ランチ料理**: 千屋牛ローストビーフの贅沢プレート (\`chiyagyu_plate.jpg\`)

## 🔍 検証結果
- [x] 全画像生成・差し替え完了
- [x] ReactおよびWordPressテーマアセット（\`assets/images/\`）への配置完了
`
  },
  {
    num: 3,
    title: '[Phase 3] 席予約フォームの空き枠判別・満席誤予約防止・仮予約ワークフロー実装',
    body: `## 🎯 概要
Webフォームからの予約時に、既に埋まっている時間帯への誤予約を防止し、リアルタイムで空き状況を判別・選択できるセレクトUIおよび仮予約制フローを実装。

## 📋 実装内容
- **リアルタイム時間帯空き状況セレクター**:
  - ◎ 余裕あり（選択可能）
  - △ 残り1組（選択可能）
  - ✕ 満席（クリック不可・disabled・誤予約防止ロック）
- **定休日自動判定**:
  - 毎週水曜日（定休日）を選択した際のアラート表示＆時間枠自動ロック
- **仮予約受付フロー**:
  - 受付番号発行（\`HRK-YYYYMMDD-XXXX\`）
  - 24時間以内の店舗スタッフ確認・本確定メール送信用案内ボックス表示
- **よくあるご質問（FAQ）アコーディオン**:
  - 予約ルール、定休日、席種、駐車場に関するQ&Aの開閉UI

## 🔍 検証結果
- [x] Reactフロントエンド実装完了
- [x] WordPressテーマ側（\`assets/js/main.js\`）実装完了
`
  },
  {
    num: 4,
    title: '[Phase 4] WordPressハイブリッドCMS化対応（自作テーマ hareka-theme 制作）',
    body: `## 🎯 概要
WebサイトをWordPressでCMS化し、店舗スタッフがメニューや果物情報、お知らせを管理画面から更新できるように対応。
「通常のWordPressテーマ運用」と「ヘッドレスREST API連携」の双方に対応できるハイブリッド構成を実現。

## 📋 実装内容
- **自作テーマ一式**: \`wordpress-theme/hareka-theme/\`
  - \`functions.php\`: カスタム投稿タイプ（\`menu_item\`, \`fruit_info\`）、カスタムタクソノミー（\`menu_category\`）、カスタムメタボックス（価格、産地、糖度、限定・テイクアウトフラグ）、REST API露出
  - \`header.php\` / \`footer.php\`: 固定バナー、レスポンシブナビ、スマホ下部アクションバー
  - \`front-page.php\`, \`page-about.php\`, \`page-menu.php\`, \`page-fruits.php\`, \`page-access.php\`, \`page-contact.php\`
- **React側ヘッドレスモジュール**:
  - \`src/services/wordpress.ts\`（REST API自動取得＋安心のローカル自動フォールバック）
  - \`.env.example\`
- **導入マニュアル**: \`wordpress-theme/README.md\`

## 🔍 検証結果
- [x] 全PHPテンプレート・CSS・JS制作完了
- [x] \`npm run build\` 検証完了
`
  },
  {
    num: 5,
    title: '[Phase 5] 投稿ページ用「お知らせ一覧（home.php / page-news.php）」の実装',
    body: `## 🎯 概要
WordPress管理画面の「表示設定」で「投稿ページ」に指定できるお知らせ用テンプレートおよびReact側のお知らせページを新規作成。

## 📋 実装内容
- **WordPressテーマ側**:
  - \`home.php\`: 「表示設定 > 投稿ページ」で指定されたページ（例: \`/news/\`）用の標準テンプレート
  - \`page-news.php\`: 固定ページ用テンプレート「お知らせ一覧 (News)」
  - \`archive.php\`: カテゴリー別アーカイブ用テンプレート
  - カテゴリ別絞り込みタブ、記事カードグリッド、ページネーション
  - 各ヘッダー・トップページからのリンク導線整備
- **React側**:
  - \`src/pages/NewsPage.tsx\`: カテゴリフィルター、記事一覧、詳細モーダルポップアップ
  - \`src/App.tsx\`: \`/news\` ルートの追加

## 🔍 検証結果
- [x] テンプレート作成完了
- [x] ナビゲーション・ルーティング連携完了
`
  },
  {
    num: 6,
    title: '[Phase 6] ローカルWordPress環境（LocalWP）構築・固定ページ初期設定',
    body: `## 🎯 概要
LocalWPを使用してローカル環境でWordPressを稼働させ、自作テーマ \`hareka-theme\` を有効化し、7つの推奨固定ページを作成して表示設定を完了する。

## 📋 実装内容
- **LocalWPサイト構築**: \`okayamaCafe\`
- **テーマ配置**: \`wp-content/themes/hareka-theme\`
- **固定ページ7つの作成**:
  1. ホーム (\`home\`)
  2. お知らせ (\`news\`)
  3. お店について (\`about\`)
  4. カフェメニュー (\`menu\`)
  5. 岡山の果物について (\`fruits\`)
  6. アクセス・店舗情報 (\`access\`)
  7. ご予約・お問い合わせ (\`contact\`)
- **表示設定の保存**:
  - ホームページ: **「ホーム」** 指定（\`front-page.php\` が自動適用）
  - 投稿ページ: **「お知らせ」** 指定（\`home.php\` が自動適用）
- **ドキュメント更新**:
  - \`wordpress-theme/README.md\` および \`README.md\` の固定ページ表と設定手順を更新

## 🔍 検証結果
- [x] 全7固定ページの作成・公開完了
- [x] 表示設定（ホーム / お知らせ）の保存確認完了
`
  },
  {
    num: 7,
    title: '[Phase 7] 無料ホスティング（InfinityFree）へのサイト移行・本番公開',
    body: `## 🎯 目的・ゴール
ローカル環境（LocalWP）で完成した「CAFE HAREKA」WordPressサイト（全7ページ、デザイン、メニュー、画像、予約機能一式）を、無料ホスティング「InfinityFree」へ完全移行し、世界中からアクセス可能な状態で本番公開する。

---

## 📋 作業ステップ・チェックリスト

### ステップ 1: InfinityFreeアカウント作成 & 無料ドメイン取得
- [ ] [InfinityFree 公式サイト](https://www.infinityfree.com/) にアクセスし、無料アカウントを登録
- [ ] クライアントエリアで **「Create Account」** をクリック
- [ ] 無料のサブドメインを選択して取得
  - 例: \`okayama-cafe.infinityfreeapp.com\` または \`hareka-cafe.great-site.net\` 等
- [ ] アカウント作成完了後、コントロールパネル（Control Panel / VistaPanel）へのアクセスを確認

---

### ステップ 2: InfinityFreeにWordPressをインストール
- [ ] コントロールパネル内の **「Softaculous Apps Installer」** を開く
- [ ] **WordPress** を選択し、**「Install Now」** をクリック
- [ ] インストール設定の入力:
  - **Choose Installation URL**: 取得したドメインを選択
  - **In Directory**: 空欄（ドメイン直下に公開する場合）または \`wp\`（専用サブディレクトリに置く場合）
  - **Admin Username / Password**: 管理者ログイン情報を設定
  - **Language**: Japanese（日本語）を選択
- [ ] **「Install」** をクリックし、インストール完了画面のURL（サイトURL / 管理画面URL）を確認

---

### ステップ 3: ローカル環境からサイトデータをエクスポート
- [ ] LocalWPを起動し、ローカルWordPressの管理画面（WP Admin）にログイン
- [ ] **「プラグイン」 > 「新規追加」** を開く
- [ ] **「All-in-One WP Migration」** を検索し、インストール＆有効化
- [ ] 左メニューの **「All-in-One WP Migration」 > 「エクスポート」** を開く
- [ ] **「エクスポート先」 > 「ファイル」** をクリック
- [ ] サイト全体のバックアップファイル（\`○○.wpress\`）が生成されるのでPCにダウンロード保存

---

### ステップ 4: InfinityFreeへサイトデータをインポート（移行実行）
- [ ] InfinityFree側のWordPress管理画面（\`https://あなたのドメイン/wp-admin/\`）にログイン
- [ ] 同様に **「プラグイン」 > 「新規追加」** より **「All-in-One WP Migration」** をインストール＆有効化
- [ ] **「All-in-One WP Migration」 > 「インポート」** を開く
- [ ] ステップ3でダウンロードした \`.wpress\` ファイルをドラッグ＆ドロップ
- [ ] 警告画面が出たら **「Proceed（続行）」** をクリック
  - ※データベース、投稿、固定ページ、テーマ、画像、URL置換（ローカルURL → InfinityFreeの公開URL）がすべて自動で行われます
- [ ] 「Your site has been imported successfully!」と表示されたらインポート完了

> 💡 **容量制限（ファイルサイズ）の注意点**:
> 無料プランのアップロード上限（通常10MB〜40MB程度）を超えてしまう場合は、FTPクライアント（FileZilla）を使ってテーマフォルダ（\`hareka-theme\`）を直接 \`htdocs/wp-content/themes/\` にアップロードする分割手順をご案内します。

---

### ステップ 5: 仕上げ・パーマリンク更新 & 動作確認
- [ ] インポート後、新しいログイン情報（ローカル時の管理者アカウント）で再度ログイン
- [ ] 管理画面の **「設定」 > 「パーマリンク」** を開き、何も変更せずに **「変更を保存」を2回クリック**（URLルーティングを正常化）
- [ ] ブラウザで公開URLにアクセスし、以下の動作を最終確認:
  - [ ] トップページ（\`/\`）が正常に表示されるか
  - [ ] 全7ページ（ホーム、お店について、メニュー、果物、お知らせ、アクセス、予約）のリンクが繋がっているか
  - [ ] 清水白桃パフェや晴王タルト等の商品写真が正しく表示されているか
  - [ ] 予約フォームの空き枠選択（◎/△/✕）が動作するか
  - [ ] スマートフォン表示（下部固定バー・モバイルメニュー）が崩れていないか

---

## 🔍 完了条件
- [ ] InfinityFreeの公開URLにて、世界中からCAFE HAREKAのWebサイトが正常に閲覧・操作できること
`
  }
];

const tmpDir = path.resolve('scripts/.tmp_issues');
if (!fs.existsSync(tmpDir)) {
  fs.mkdirSync(tmpDir, { recursive: true });
}

console.log('=== GitHub Issues 詳細アップデート開始 ===');

for (const item of issues) {
  try {
    const tmpFile = path.join(tmpDir, `issue_${item.num}.md`);
    fs.writeFileSync(tmpFile, item.body, 'utf-8');

    console.log(`Updating Issue #${item.num}: ${item.title} ...`);
    execSync(
      `gh issue edit ${item.num} --repo ${repo} --title "${item.title.replace(/"/g, '\\"')}" --body-file "${tmpFile}"`,
      { encoding: 'utf-8' }
    );
    console.log(`✓ Issue #${item.num} updated successfully!`);
  } catch (err) {
    console.error(`Error updating Issue #${item.num}:`, err.message);
  }
}

// 一時ディレクトリのクリーンアップ
fs.rmSync(tmpDir, { recursive: true, force: true });

console.log('=== すべての GitHub Issues 詳細アップデート完了 ===');
