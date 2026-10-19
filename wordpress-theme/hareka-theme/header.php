<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) : ?>
    <link rel="icon" type="image/svg+xml" href="<?php echo esc_url( get_template_directory_uri() . '/assets/images/favicon.svg' ); ?>">
    <link rel="alternate icon" type="image/x-icon" href="<?php echo esc_url( get_template_directory_uri() . '/assets/images/favicon.ico' ); ?>">
    <link rel="apple-touch-icon" href="<?php echo esc_url( get_template_directory_uri() . '/assets/images/favicon.svg' ); ?>">
  <?php endif; ?>
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
        <div class="flex items-center gap-2 sm:gap-3 flex-1 min-w-[280px]">
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
          $header_items = hareka_get_nav_items( 'primary' );
          foreach ( $header_items as $item ) :
              $active_cls = $item['is_active']
                  ? 'text-[#b54737] font-semibold bg-[#fde2d9]/50'
                  : 'text-[#574636] hover:text-[#b54737] hover:bg-[#f4eee3]/60 font-medium';
          ?>
            <a href="<?php echo esc_url( $item['url'] ); ?>" target="<?php echo esc_attr( $item['target'] ); ?>" class="px-3 xl:px-4 py-2 rounded-full text-sm <?php echo esc_attr( $active_cls ); ?> transition flex flex-col items-center">
              <span><?php echo esc_html( $item['title'] ); ?></span>
              <?php if ( ! empty( $item['en'] ) ) : ?>
                <span class="text-[9px] tracking-wider text-[#a48c6f] -mt-0.5"><?php echo esc_html( $item['en'] ); ?></span>
              <?php endif; ?>
            </a>
          <?php endforeach; ?>
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
            ● 営業中 <?php echo esc_html( hareka_get_shop_info( 'hours_header' ) ); ?> / <?php echo esc_html( hareka_get_shop_info( 'closed_day_short' ) ); ?>
          </span>
          <span class="text-[#fbc6b6] font-medium">
            🍑 今週は「赤磐産 清水白桃」極上パフェをご提供中！
          </span>
        </div>
        <div class="flex items-center gap-4 text-[#d8c8b2]">
          <span class="flex items-center gap-1">
            <svg class="w-3 h-3 text-[#f7a48d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            <?php echo esc_html( hareka_get_shop_info( 'address_short' ) ); ?>
          </span>
          <span class="flex items-center gap-1 text-[#fceee9]" title="<?php echo esc_attr( hareka_get_shop_info( 'phone_note' ) ); ?>">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <?php echo esc_html( hareka_get_shop_info( 'phone' ) ); ?>
          </span>
        </div>
      </div>
    </div>
  </div>

  <!-- モバイルメニューオーバーレイ（JS開閉） -->
  <div id="mobile-menu-drawer" class="hidden lg:hidden bg-[#faf7f2] border-b border-[#e7dac5] shadow-xl fixed top-[115px] left-0 right-0 z-40 p-6 space-y-4">
    <div class="grid grid-cols-1 gap-2">
      <?php
      $drawer_items = hareka_get_nav_items( 'primary' );
      foreach ( $drawer_items as $item ) :
          $m_active_cls = $item['is_active']
              ? 'bg-[#fde2d9] text-[#b54737] font-semibold'
              : 'text-[#433932] hover:bg-[#f4eee3] font-medium';
      ?>
        <a href="<?php echo esc_url( $item['url'] ); ?>" target="<?php echo esc_attr( $item['target'] ); ?>" class="flex items-center justify-between p-3 rounded-xl transition <?php echo esc_attr( $m_active_cls ); ?>">
          <div>
            <div class="text-base"><?php echo esc_html( $item['title'] ); ?></div>
            <?php if ( ! empty( $item['en'] ) ) : ?>
              <div class="text-xs text-[#a48c6f]"><?php echo esc_html( $item['en'] ); ?></div>
            <?php endif; ?>
          </div>
          <span class="text-xs text-[#a48c6f]">→</span>
        </a>
      <?php endforeach; ?>
    </div>
    <div class="pt-4 border-t border-[#e7dac5] space-y-2">
      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-gradient-to-r from-[#e26d5c] to-[#b54737] text-white font-medium shadow text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></rect><line x1="16" y1="2" x2="16" y2="6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line><line x1="8" y1="2" x2="8" y2="6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line><line x1="3" y1="10" x2="21" y2="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line></svg>
        <span>お席の事前予約・お問い合わせ</span>
      </a>
      <div class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-[#d8c8b2] text-[#574636] font-medium text-sm bg-white/50" title="<?php echo esc_attr( hareka_get_shop_info( 'phone_note' ) ); ?>">
        <svg class="w-4 h-4 text-[#e26d5c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        <span>お電話：<?php echo esc_html( hareka_get_shop_info( 'phone' ) ); ?></span>
      </div>
    </div>
  </div>

  <!-- メインコンテンツ領域開始 -->
  <main id="primary" class="site-main flex-1">
