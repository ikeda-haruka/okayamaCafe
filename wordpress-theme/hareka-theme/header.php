<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/svg+xml" href="<?php echo esc_url( get_template_directory_uri() . '/assets/images/favicon.svg' ); ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-[#faf7f2] text-[#433932] antialiased selection:bg-[#fbc6b6] selection:text-[#574636]' ); ?>>
<?php wp_body_open(); ?>

<div id="page" class="min-h-screen flex flex-col">

  <!-- 画面冒頭に常時固定されるコンテナ（ポートフォリオ案内バナー ＋ メインヘッダー） -->
  <div class="sticky top-0 z-50 shadow-sm">
    <!-- ポートフォリオ実績用 架空サイト固定告知バナー -->
    <div class="w-full bg-[#221c17] text-[#f4eee3] border-b border-[#574636] shadow-sm relative z-[60]">
      <div class="max-w-7xl mx-auto px-4 py-2 sm:py-2.5 flex flex-wrap items-center justify-between gap-2 text-xs">
        <div className="flex items-center gap-2 sm:gap-3 flex-1 min-w-[280px]">
          <span class="inline-flex items-center gap-1.5 bg-[#b54737] text-white font-bold px-2.5 py-0.5 rounded-full text-[11px] tracking-wide shrink-0 shadow-sm">
            ポートフォリオ実績用
          </span>
          <p class="text-xs sm:text-[13px] text-[#f4eee3] leading-tight font-medium">
            ※当Webサイトは制作実績用の<strong>架空のカフェサイト（WordPress CMS化対応）</strong>です。実在の店舗・人物・団体とは一切関係ございません。
          </p>
        </div>
        <div class="flex items-center gap-2 ml-auto">
          <span class="hidden md:inline-flex items-center gap-1.5 text-[11px] text-[#d8c8b2] bg-[#392d23] px-2.5 py-0.5 rounded-md border border-[#574636]">
            WordPress 6.x / PHP 8.x / REST API / Tailwind CSS
          </span>
        </div>
      </div>
    </div>

    <!-- メインヘッダー -->
    <header class="bg-[#faf7f2]/95 backdrop-blur-md py-3.5 border-b border-[#e7dac5]/60 transition-all duration-300">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <!-- ブランドロゴ -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="group flex items-center gap-3">
          <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-gradient-to-tr from-[#fbc6b6] via-[#fde2d9] to-[#a9d997] flex items-center justify-center shadow-inner group-hover:scale-105 transition-transform duration-300 text-xl">
            🍑
          </div>
          <div class="flex flex-col">
            <span class="text-xs tracking-[0.25em] text-[#a48c6f] font-medium uppercase">
              Okayama Local Fruits & Cafe
            </span>
            <span class="font-serif text-xl sm:text-2xl font-bold tracking-wider text-[#392d23] group-hover:text-[#b54737] transition-colors">
              CAFE HAREKA <span class="text-sm font-normal text-[#a48c6f]">晴果</span>
            </span>
          </div>
        </a>

        <!-- デスクトップナビゲーション -->
        <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
          <?php
          if ( has_nav_menu( 'primary' ) ) {
              wp_nav_menu( array(
                  'theme_location' => 'primary',
                  'container'      => false,
                  'menu_class'     => 'flex items-center gap-1 xl:gap-2',
                  'items_wrap'     => '%3$s',
                  'fallback_cb'    => false,
              ) );
          } else {
              // デフォルトメニュー
              $news_page_url = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/news/' );
              $nav_items = array(
                  array( 'title' => 'ホーム', 'en' => 'HOME', 'url' => home_url( '/' ) ),
                  array( 'title' => 'お店について', 'en' => 'ABOUT', 'url' => home_url( '/about/' ) ),
                  array( 'title' => 'メニュー', 'en' => 'MENU', 'url' => home_url( '/menu/' ) ),
                  array( 'title' => '岡山の果物', 'en' => 'FRUITS', 'url' => home_url( '/fruits/' ) ),
                  array( 'title' => 'お知らせ', 'en' => 'NEWS', 'url' => $news_page_url ),
                  array( 'title' => 'アクセス', 'en' => 'ACCESS', 'url' => home_url( '/access/' ) ),
                  array( 'title' => 'お問い合わせ', 'en' => 'CONTACT', 'url' => home_url( '/contact/' ) ),
              );
              foreach ( $nav_items as $item ) {
                  echo '<a href="' . esc_url( $item['url'] ) . '" class="px-3 xl:px-4 py-2 rounded-full text-sm font-medium text-[#574636] hover:text-[#b54737] hover:bg-[#f4eee3]/60 transition flex flex-col items-center">';
                  echo '<span>' . esc_html( $item['title'] ) . '</span>';
                  echo '<span class="text-[9px] tracking-wider text-[#a48c6f] -mt-0.5">' . esc_html( $item['en'] ) . '</span>';
                  echo '</a>';
              }
          }
          ?>
        </nav>

        <!-- CTAボタン（予約） -->
        <div class="hidden lg:flex items-center gap-3">
          <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-[#e26d5c] to-[#b54737] text-white text-sm font-medium shadow-sm hover:shadow-md hover:brightness-105 transition active:scale-95">
            <span>お席のご予約</span>
          </a>
        </div>

        <!-- モバイル用ハンバーガーボタン -->
        <button id="mobile-menu-toggle" class="lg:hidden p-2 rounded-xl text-[#392d23] hover:bg-[#f4eee3] transition" aria-label="メニューを開く">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </header>

    <!-- 店舗ティッカーインフォ -->
    <div class="bg-[#392d23] text-[#f4eee3] text-[11px] py-1 px-4 hidden sm:block">
      <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center gap-3">
          <span class="inline-flex items-center gap-1 bg-[#6cae54] text-white px-2 py-0.5 rounded-full text-[10px] font-medium">
            ● 営業中 10:00 - 18:00 (L.O. 17:30) / 水曜定休
          </span>
          <span class="text-[#fbc6b6] font-medium">
            🍑 今週は「赤磐産 清水白桃」極上パフェをご提供中！
          </span>
        </div>
        <div class="flex items-center gap-4 text-[#d8c8b2]">
          <span>岡山市北区吉備津780</span>
          <a href="tel:086-234-5678" class="hover:text-white transition">📞 086-234-5678</a>
        </div>
      </div>
    </div>
  </div>

  <!-- モバイルメニューオーバーレイ（JS開閉） -->
  <div id="mobile-menu-drawer" class="hidden lg:hidden bg-[#faf7f2] border-b border-[#e7dac5] shadow-xl fixed top-[115px] left-0 right-0 z-40 p-6 space-y-4">
    <div class="grid grid-cols-1 gap-2">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="p-3 rounded-xl hover:bg-[#f4eee3] text-sm font-medium">ホーム</a>
      <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="p-3 rounded-xl hover:bg-[#f4eee3] text-sm font-medium">お店について</a>
      <a href="<?php echo esc_url( home_url( '/menu/' ) ); ?>" class="p-3 rounded-xl hover:bg-[#f4eee3] text-sm font-medium">メニュー</a>
      <a href="<?php echo esc_url( home_url( '/fruits/' ) ); ?>" class="p-3 rounded-xl hover:bg-[#f4eee3] text-sm font-medium">岡山の果物</a>
      <a href="<?php echo esc_url( $news_page_url ?? home_url( '/news/' ) ); ?>" class="p-3 rounded-xl hover:bg-[#f4eee3] text-sm font-medium">お知らせ</a>
      <a href="<?php echo esc_url( home_url( '/access/' ) ); ?>" class="p-3 rounded-xl hover:bg-[#f4eee3] text-sm font-medium">アクセス</a>
      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="p-3 rounded-xl hover:bg-[#f4eee3] text-sm font-medium">お問い合わせ</a>
    </div>
    <div class="pt-4 border-t border-[#e7dac5] space-y-2">
      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="w-full flex items-center justify-center py-3 rounded-xl bg-gradient-to-r from-[#e26d5c] to-[#b54737] text-white font-medium shadow text-sm">
        お席の事前予約・お問い合わせ
      </a>
      <a href="tel:086-234-5678" class="w-full flex items-center justify-center py-2.5 rounded-xl border border-[#d8c8b2] text-[#574636] font-medium text-sm">
        📞 お電話：086-234-5678
      </a>
    </div>
  </div>

  <!-- メインコンテンツ領域開始 -->
  <main id="primary" class="site-main flex-1">
