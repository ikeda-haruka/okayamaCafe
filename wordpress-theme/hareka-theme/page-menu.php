<?php
/**
 * Template Name: Menu Page (メニュー一覧)
 *
 * @package hareka-theme
 */

get_header();
$theme_uri = get_template_directory_uri();
?>

<div class="space-y-16 sm:space-y-20 pb-20">
  <!-- ページヘッダー -->
  <div class="relative py-12 md:py-20 bg-gradient-to-b from-[#fde2d9]/60 via-[#faf7f2] to-[#e2f0d9]/40 border-b border-[#e7dac5]/60 overflow-hidden text-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-3">
      <div class="flex items-center justify-center gap-2 text-xs text-[#a48c6f] mb-4">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#b54737] transition">HOME</a>
        <span>›</span>
        <span class="text-[#574636] font-medium">メニュー</span>
      </div>
      <span class="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase block">OUR MENU</span>
      <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-[#392d23] tracking-wide">カフェメニュー</h1>
      <p class="max-w-2xl mx-auto text-sm sm:text-base text-[#6b5a4d] leading-relaxed pt-2">
        岡山の大自然が育んだ果実や、千屋牛・吉田牧場チーズなど選りすぐりの県産食材を贅沢に使用。朝採れの瑞々しさをそのまま味わえる手作りメニューです。
      </p>
    </div>
  </div>

  <!-- 季節の果物リレーカレンダー -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e7dac5] shadow-sm">
      <div class="flex items-center gap-2 text-[#b54737] font-semibold text-xs mb-3">
        <span>📅 季節の果物 リレーカレンダー（現在の旬をチェック）</span>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
        <div class="p-3 rounded-2xl bg-[#fef2ee] border border-[#fbc6b6]/50">
          <span class="font-bold text-[#b54737] block">🍑 7月〜8月</span>
          <span class="font-medium text-[#392d23] block text-sm">清水白桃 / 白鳳</span>
          <span class="text-[10px] text-[#6b5a4d]">上品な甘みと溢れる果汁</span>
        </div>
        <div class="p-3 rounded-2xl bg-[#f4f8f0] border border-[#a9d997]/50">
          <span class="font-bold text-[#4a8235] block">🍇 7月〜10月</span>
          <span class="font-medium text-[#392d23] block text-sm">シャインマスカット晴王</span>
          <span class="text-[10px] text-[#6b5a4d]">皮ごとパリッと高糖度18度</span>
        </div>
        <div class="p-3 rounded-2xl bg-[#faf7f2] border border-[#d8c8b2]">
          <span class="font-bold text-[#574636] block">🍇 8月〜10月</span>
          <span class="font-medium text-[#392d23] block text-sm">ニューピオーネ</span>
          <span class="text-[10px] text-[#6b5a4d]">大粒でジューシーな黒真珠</span>
        </div>
        <div class="p-3 rounded-2xl bg-[#fef2ee] border border-[#fbc6b6]/50">
          <span class="font-bold text-[#e26d5c] block">🍓 12月〜5月</span>
          <span class="font-medium text-[#392d23] block text-sm">晴苺（はれいちご）</span>
          <span class="text-[10px] text-[#6b5a4d]">色鮮やかで濃厚な甘酸っぱさ</span>
        </div>
      </div>
    </div>
  </section>

  <!-- カテゴリ切り替えタブ（JSフィルター対応） -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-wrap justify-center gap-2 sm:gap-3 mb-10" id="menu-filter-tabs">
      <button data-category="all" class="menu-tab-btn active px-5 py-2.5 rounded-full text-xs sm:text-sm font-medium transition-all bg-[#392d23] text-white shadow-md">
        すべて <span class="text-[10px] opacity-70 ml-1 font-normal">ALL</span>
      </button>
      <button data-category="sweets" class="menu-tab-btn px-5 py-2.5 rounded-full text-xs sm:text-sm font-medium transition-all bg-white text-[#574636] border border-[#e7dac5] hover:bg-[#f4eee3]">
        旬果スイーツ <span class="text-[10px] opacity-70 ml-1 font-normal">SWEETS</span>
      </button>
      <button data-category="lunch" class="menu-tab-btn px-5 py-2.5 rounded-full text-xs sm:text-sm font-medium transition-all bg-white text-[#574636] border border-[#e7dac5] hover:bg-[#f4eee3]">
        ランチ・軽食 <span class="text-[10px] opacity-70 ml-1 font-normal">LUNCH</span>
      </button>
      <button data-category="drinks" class="menu-tab-btn px-5 py-2.5 rounded-full text-xs sm:text-sm font-medium transition-all bg-white text-[#574636] border border-[#e7dac5] hover:bg-[#f4eee3]">
        ドリンク <span class="text-[10px] opacity-70 ml-1 font-normal">DRINKS</span>
      </button>
      <button data-category="takeout" class="menu-tab-btn px-5 py-2.5 rounded-full text-xs sm:text-sm font-medium transition-all bg-white text-[#574636] border border-[#e7dac5] hover:bg-[#f4eee3]">
        テイクアウト・ギフト <span class="text-[10px] opacity-70 ml-1 font-normal">TAKEOUT</span>
      </button>
    </div>

    <!-- メニューカード一覧（カスタム投稿 menu_item ループ） -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="menu-items-grid">
      <?php
      $all_menu = new WP_Query( array(
          'post_type'      => 'menu_item',
          'posts_per_page' => -1,
          'orderby'        => 'menu_order date',
          'order'          => 'DESC',
      ) );

      if ( $all_menu->have_posts() ) :
          while ( $all_menu->have_posts() ) : $all_menu->the_post();
              $price    = get_post_meta( get_the_ID(), '_hareka_price', true );
              $origin   = get_post_meta( get_the_ID(), '_hareka_origin', true );
              $sugar    = get_post_meta( get_the_ID(), '_hareka_sugar', true );
              $seasonal = get_post_meta( get_the_ID(), '_hareka_seasonal', true );
              $takeout  = get_post_meta( get_the_ID(), '_hareka_takeout', true );
              $thumb    = get_the_post_thumbnail_url( get_the_ID(), 'hareka-card' ) ?: ( $theme_uri . '/assets/images/peach_parfait.jpg' );

              // タクソノミー（カテゴリ）取得
              $terms = get_the_terms( get_the_ID(), 'menu_category' );
              $cat_slugs = array();
              if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                  foreach ( $terms as $term ) {
                      $cat_slugs[] = $term->slug;
                  }
              }
              $cat_class = implode( ' ', $cat_slugs );
      ?>
        <div class="menu-card bg-white rounded-3xl overflow-hidden border border-[#e7dac5] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group" data-categories="<?php echo esc_attr( $cat_class ); ?>">
          <div class="relative h-64 overflow-hidden bg-[#f4eee3]">
            <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
              <?php if ( $seasonal ) : ?>
                <span class="bg-[#e26d5c] text-white text-[11px] font-bold px-2.5 py-0.5 rounded-full shadow-sm">季節限定</span>
              <?php endif; ?>
              <?php if ( $takeout ) : ?>
                <span class="bg-[#392d23]/80 backdrop-blur-sm text-white text-[11px] font-medium px-2 py-0.5 rounded-full">お持帰り可</span>
              <?php endif; ?>
            </div>
            <?php if ( $sugar ) : ?>
              <span class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm text-[#4a8235] text-[11px] font-bold px-2.5 py-0.5 rounded-full shadow-sm"><?php echo esc_html( $sugar ); ?></span>
            <?php endif; ?>
          </div>

          <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
            <div class="space-y-3">
              <?php if ( $origin ) : ?>
                <div class="text-[11px] font-medium text-[#a48c6f] flex items-center gap-1">
                  <span>📍 <?php echo esc_html( $origin ); ?></span>
                </div>
              <?php endif; ?>
              <h3 class="font-serif text-lg font-bold text-[#392d23] group-hover:text-[#b54737] transition-colors leading-snug"><?php the_title(); ?></h3>
              <div class="text-xs text-[#6b5a4d] leading-relaxed"><?php the_content(); ?></div>
            </div>

            <div class="pt-4 border-t border-[#f4eee3] flex items-center justify-between">
              <span class="text-xs text-[#a48c6f]">税込価格</span>
              <span class="font-serif text-2xl font-bold text-[#392d23]">¥<?php echo number_format( (int)$price ); ?></span>
            </div>
          </div>
        </div>
      <?php
          endwhile;
          wp_reset_postdata();
      else :
          // 管理画面で未投稿時のサンプル静的表示
      ?>
        <!-- サンプル表示（管理画面で投稿すると自動で置き換わります） -->
        <div class="col-span-full bg-white p-8 rounded-3xl text-center text-xs text-[#a48c6f]">
          WordPress管理画面の「カフェメニュー」よりメニューアイテムを追加してください。<br>
          カテゴリ（sweets, lunch, drinks, takeout）を設定すると自動的にタブ分類されます。
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- 注意事項 -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-[#f4eee3] rounded-3xl p-6 sm:p-8 border border-[#e7dac5] text-xs text-[#6b5a4d] space-y-1.5">
      <h4 class="font-bold text-[#392d23]">メニューに関するご案内</h4>
      <p>・天候や収穫状況により、果物の品種や提供期間が予告なく変更となる場合がございます。</p>
      <p>・アレルギーをお持ちのお客様は、ご注文の際にお気軽にスタッフまでご相談ください。</p>
    </div>
  </section>
</div>

<?php get_footer(); ?>
