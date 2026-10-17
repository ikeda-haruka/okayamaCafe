<?php
/**
 * Template Name: Front Page
 *
 * @package hareka-theme
 */

get_header();
$theme_uri = get_template_directory_uri();
?>

<div class="space-y-20 sm:space-y-28 overflow-hidden pb-16">
  <!-- ヒーローセクション -->
  <section id="hero" class="relative min-h-[85vh] sm:min-h-[90vh] flex items-center justify-center bg-gradient-to-br from-[#fde2d9]/50 via-[#faf7f2] to-[#e2f0d9]/50 px-4 sm:px-6 lg:px-8 py-16">
    <div class="absolute top-1/4 left-10 w-72 h-72 rounded-full bg-[#fbc6b6]/30 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 rounded-full bg-[#a9d997]/25 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10">
      <!-- テキストコンテンツ -->
      <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
        <div class="motion-fade-up inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/90 border border-[#fbc6b6] shadow-sm text-xs text-[#b54737] font-medium">
          <span>✨ 2026年秋・岡山県北区吉備津にグランドオープン</span>
        </div>

        <div class="space-y-3 motion-fade-up motion-delay-100">
          <p class="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#a48c6f] uppercase">
            Okayama Local Fruits & Slow Time
          </p>
          <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-bold text-[#392d23] leading-[1.25] tracking-wide">
            晴れの国の太陽と、<br>
            <span class="text-[#b54737] relative inline-block">
              樹上のめぐみ
              <span class="absolute bottom-1 left-0 w-full h-2.5 bg-[#fde2d9] -z-10 rounded"></span>
            </span>
            をそのままに。
          </h1>
        </div>

        <p class="motion-fade-up motion-delay-200 text-sm sm:text-base text-[#6b5a4d] leading-relaxed max-w-xl mx-auto lg:mx-0">
          岡山の大地と農家さんが手塩にかけて育てた白桃やシャインマスカット。<br>
          木漏れ日あふれる温かな空間で、ここ岡山でしか出逢えない瑞々しい旬のスイーツと穏やかなカフェ時間をお届けします。
        </p>

        <div class="motion-fade-up motion-delay-300 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3.5 pt-2">
          <a href="<?php echo esc_url( home_url( '/menu/' ) ); ?>" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-full bg-gradient-to-r from-[#e26d5c] to-[#b54737] text-white font-medium text-sm shadow-md hover:shadow-lg transition">
            <span>旬のメニューを見る</span>
          </a>
          <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-full bg-white border border-[#d8c8b2] text-[#574636] font-medium text-sm hover:bg-[#f4eee3] transition">
            <span>HAREKAのこだわり</span>
          </a>
        </div>

        <!-- 本日の入荷速報ミニカード -->
        <div class="pt-4 motion-fade-up motion-delay-400">
          <div class="inline-flex items-center gap-3 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-2xl border border-[#e7dac5] text-xs text-[#574636]">
            <span class="w-2 h-2 rounded-full bg-[#6cae54] animate-pulse"></span>
            <span class="font-semibold text-[#b54737]">本日の産直入荷</span>
            <span class="text-[#6b5a4d]">赤磐市吉井果樹園より「清水白桃」朝採れ到着（糖度14.8度）</span>
          </div>
        </div>
      </div>

      <!-- ヒーロービジュアル -->
      <div class="lg:col-span-5 relative motion-scale-up">
        <div class="relative mx-auto max-w-md lg:max-w-none">
          <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-white">
            <img src="<?php echo esc_url( $theme_uri . '/assets/images/peach_parfait.jpg' ); ?>" alt="岡山県産 清水白桃パフェ" class="w-full h-[400px] sm:h-[480px] object-cover hover:scale-105 transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex flex-col justify-end p-6 text-white">
              <span class="text-[11px] font-semibold tracking-wider bg-[#b54737] text-white px-2.5 py-0.5 rounded-full w-fit mb-1">
                看板スイーツ
              </span>
              <h3 class="font-serif text-xl sm:text-2xl font-bold">
                岡山県産 清水白桃の極上パフェ
              </h3>
              <p class="text-xs text-[#fde2d9] mt-1">
                朝採れの芳醇な果汁と蒜山ジャージーソフトの口どけ
              </p>
            </div>
          </div>

          <!-- フローティングバッジ -->
          <div class="animate-float-slow-1 absolute -top-4 -left-4 sm:-left-8 bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-xl border border-[#e7dac5] flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#e2f0d9] overflow-hidden flex items-center justify-center shrink-0 border border-[#a9d997]/50">
              <img src="<?php echo esc_url( $theme_uri . '/assets/images/shine_muscat_vine.jpg' ); ?>" alt="晴王 シャインマスカット" class="w-full h-full object-cover">
            </div>
            <div>
              <div class="text-[10px] text-[#a48c6f] font-semibold uppercase">Okayama Muscat</div>
              <div class="text-xs font-bold text-[#392d23]">晴王（シャインマスカット）</div>
              <div class="text-[10px] text-[#6cae54] font-medium">糖度18度以上の最高峰</div>
            </div>
          </div>

          <div class="animate-float-slow-2 absolute -bottom-6 -right-4 sm:-right-6 bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-xl border border-[#e7dac5] flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#fde2d9] flex items-center justify-center text-xl">
              🌿
            </div>
            <div>
              <div class="text-xs font-bold text-[#392d23]">ガーデンテラス完備</div>
              <div class="text-[10px] text-[#a48c6f]">ペット同伴可 / 駐車場20台無料</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 3つの約束セクション -->
  <section class="motion-fade-up max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center space-y-3 mb-14">
      <span class="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">CONCEPT</span>
      <h2 class="font-serif text-2xl sm:text-4xl font-bold text-[#392d23]">CAFE HAREKA が大切にすること</h2>
      <p class="text-sm text-[#6b5a4d] max-w-xl mx-auto">岡山という土地が持つ豊かな恵みと、訪れるすべての人の心がほどける時間をお約束します。</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-white rounded-3xl p-8 border border-[#e7dac5]/80 shadow-sm space-y-4">
        <div class="w-14 h-14 rounded-2xl bg-[#fde2d9] flex items-center justify-center text-2xl text-[#e26d5c]">☀️</div>
        <span class="text-xs font-bold text-[#a48c6f] tracking-widest block">01 / LOCAL FRUITS</span>
        <h3 class="font-serif text-xl font-bold text-[#392d23]">契約果樹園から届く<br>樹上完熟の果物</h3>
        <p class="text-sm text-[#6b5a4d] leading-relaxed">赤磐や倉敷の契約農家さんと直接繋がり、最も香りと糖度が高まった「一番おいしい瞬間」の果物を仕入れています。</p>
      </div>

      <div class="bg-white rounded-3xl p-8 border border-[#e7dac5]/80 shadow-sm space-y-4">
        <div class="w-14 h-14 rounded-2xl bg-[#e2f0d9] flex items-center justify-center text-2xl text-[#6cae54]">🌿</div>
        <span class="text-xs font-bold text-[#a48c6f] tracking-widest block">02 / SLOW SPACE</span>
        <h3 class="font-serif text-xl font-bold text-[#392d23]">木漏れ日と自然を感じる<br>居心地のよい空間</h3>
        <p class="text-sm text-[#6b5a4d] leading-relaxed">岡山県産木材をふんだんに使用した温もりある店内と、緑の風が通り抜けるガーデンテラス。愛犬同伴も歓迎です。</p>
      </div>

      <div class="bg-white rounded-3xl p-8 border border-[#e7dac5]/80 shadow-sm space-y-4">
        <div class="w-14 h-14 rounded-2xl bg-[#f4eee3] flex items-center justify-center text-2xl text-[#a48c6f]">🍽</div>
        <span class="text-xs font-bold text-[#a48c6f] tracking-widest block">03 / ALL OKAYAMA</span>
        <h3 class="font-serif text-xl font-bold text-[#392d23]">スイーツだけでなく<br>岡山自慢のランチプレート</h3>
        <p class="text-sm text-[#6b5a4d] leading-relaxed">日本最古の蔓牛「千屋牛」や、全国的に名高い「吉田牧場」チーズ、県産無農薬野菜を使った本格ランチをご用意。</p>
      </div>
    </div>
  </section>

  <!-- 今月のおすすめメニュー（WordPressカスタム投稿 menu_item よりループ表示） -->
  <section class="motion-fade-up max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
      <div class="space-y-2">
        <span class="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">RECOMMENDED MENU</span>
        <h2 class="font-serif text-2xl sm:text-4xl font-bold text-[#392d23]">今月のおすすめメニュー</h2>
        <p class="text-sm text-[#6b5a4d]">WordPress管理画面から投稿・更新された旬のメニューを動的表示します。</p>
      </div>
      <a href="<?php echo esc_url( home_url( '/menu/' ) ); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-[#b54737] hover:underline">
        <span>すべてのメニューを見る →</span>
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <?php
      $menu_query = new WP_Query( array(
          'post_type'      => 'menu_item',
          'posts_per_page' => 3,
          'meta_key'       => '_hareka_featured',
          'meta_value'     => '1',
      ) );

      if ( ! $menu_query->have_posts() ) {
          // おすすめフラグが無い場合は通常の最新3件
          $menu_query = new WP_Query( array(
              'post_type'      => 'menu_item',
              'posts_per_page' => 3,
          ) );
      }

      if ( $menu_query->have_posts() ) :
          while ( $menu_query->have_posts() ) : $menu_query->the_post();
              $price   = get_post_meta( get_the_ID(), '_hareka_price', true );
              $origin  = get_post_meta( get_the_ID(), '_hareka_origin', true );
              $sugar   = get_post_meta( get_the_ID(), '_hareka_sugar', true );
              $seasonal = get_post_meta( get_the_ID(), '_hareka_seasonal', true );
              $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'hareka-card' ) ?: ( $theme_uri . '/assets/images/peach_parfait.jpg' );
      ?>
        <div class="bg-white rounded-3xl overflow-hidden border border-[#e7dac5] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
          <div class="relative h-60 overflow-hidden bg-[#f4eee3]">
            <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <?php if ( $seasonal ) : ?>
              <span class="absolute top-4 left-4 bg-[#e26d5c] text-white text-[11px] font-bold px-3 py-1 rounded-full shadow">旬果限定</span>
            <?php endif; ?>
            <?php if ( $sugar ) : ?>
              <span class="absolute top-4 right-4 bg-white/95 text-[#4a8235] text-[11px] font-semibold px-2.5 py-1 rounded-full shadow"><?php echo esc_html( $sugar ); ?></span>
            <?php endif; ?>
          </div>
          <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
            <div class="space-y-2">
              <?php if ( $origin ) : ?>
                <div class="text-[11px] text-[#a48c6f] font-medium">📍 <?php echo esc_html( $origin ); ?></div>
              <?php endif; ?>
              <h3 class="font-serif text-lg font-bold text-[#392d23] group-hover:text-[#b54737] transition-colors"><?php the_title(); ?></h3>
              <p class="text-xs text-[#6b5a4d] leading-relaxed line-clamp-3"><?php echo wp_trim_words( get_the_excerpt(), 40, '...' ); ?></p>
            </div>
            <div class="pt-4 border-t border-[#f4eee3] flex items-center justify-between">
              <span class="text-xs text-[#a48c6f]">税込</span>
              <?php if ( $price !== '' && is_numeric( $price ) && (int)$price > 0 ) : ?>
                <span class="font-serif text-xl font-bold text-[#392d23]">¥<?php echo number_format( (int)$price ); ?></span>
              <?php else : ?>
                <span class="text-[11px] font-bold text-[#b54737] bg-[#fef2ee] border border-[#fbc6b6] px-2 py-0.5 rounded">
                  価格未設定
                </span>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php
          endwhile;
          wp_reset_postdata();
      else :
          // メニュー未投稿時のデフォルトフォールバック表示
      ?>
        <div class="bg-white rounded-3xl overflow-hidden border border-[#e7dac5] shadow-sm p-6 text-center text-xs text-[#a48c6f]">
          WordPress管理画面の「カフェメニュー」よりおすすめメニューを投稿してください。
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- 岡山の果物 特集バナー -->
  <section class="motion-fade-up max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="relative rounded-3xl overflow-hidden bg-[#392d23] text-white p-8 sm:p-12 lg:p-16">
      <div class="absolute inset-0 bg-cover bg-center opacity-30 mix-blend-overlay" style="background-image: url('<?php echo esc_url( $theme_uri . '/assets/images/shine_muscat_vine.jpg' ); ?>');"></div>
      <div class="relative z-10 max-w-2xl space-y-6">
        <span class="text-xs font-semibold tracking-[0.3em] text-[#f7a48d] uppercase">OKAYAMA FRUITS STORY</span>
        <h2 class="font-serif text-2xl sm:text-4xl font-bold leading-snug">なぜ、岡山の果物は<br>世界中を虜にするのか。</h2>
        <p class="text-xs sm:text-sm text-[#d8c8b2] leading-relaxed">
          晴れの国の豊かな陽光、三大河川の清らかな水、そして明治から受け継がれる「一果一袋」の職人技。<br>
          甘み、香り、みずみずしさ——すべてが極限まで磨かれた岡山フルーツの物語を紐解きます。
        </p>
        <div class="pt-2">
          <a href="<?php echo esc_url( home_url( '/fruits/' ) ); ?>" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-white text-[#392d23] font-semibold text-sm hover:bg-[#fde2d9] transition shadow">
            <span>岡山の果物・契約農家のこだわりへ →</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- お知らせ・News（WordPressの通常投稿 post よりループ表示） -->
  <section class="motion-fade-up max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-[#e7dac5] shadow-sm">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-[#f4eee3] mb-6 gap-3">
        <div>
          <span class="text-xs font-semibold tracking-widest text-[#a48c6f] uppercase block">NEWS & TOPICS</span>
          <h3 class="font-serif text-xl sm:text-2xl font-bold text-[#392d23]">店舗からのお知らせ</h3>
        </div>
        <div class="flex items-center gap-4">
          <span class="text-xs text-[#a48c6f] hidden md:inline">最新の入荷・営業案内</span>
          <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/news/' ) ); ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#b54737] hover:underline">
            <span>すべてのお知らせを見る</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </a>
        </div>
      </div>

      <div class="divide-y divide-[#f4eee3]">
        <?php
        $news_query = new WP_Query( array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
        ) );

        if ( $news_query->have_posts() ) :
            while ( $news_query->have_posts() ) : $news_query->the_post();
                $cats = get_the_category();
                $cat_name = ! empty( $cats ) ? $cats[0]->name : 'お知らせ';
                $badge_cls = 'bg-[#fde2d9] text-[#b54737]';
                if ( $cat_name === '旬の入荷' ) {
                    $badge_cls = 'bg-[#e2f0d9] text-[#4a8235]';
                } elseif ( $cat_name === 'イベント' ) {
                    $badge_cls = 'bg-[#f4eee3] text-[#574636]';
                }
        ?>
          <div class="py-4 flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-6">
            <div class="flex items-center gap-3 shrink-0">
              <span class="text-xs font-medium text-[#a48c6f]"><?php echo get_the_date( 'Y.m.d' ); ?></span>
              <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full <?php echo esc_attr( $badge_cls ); ?>"><?php echo esc_html( $cat_name ); ?></span>
            </div>
            <a href="<?php the_permalink(); ?>" class="text-sm font-medium text-[#392d23] hover:text-[#b54737] transition">
              <?php the_title(); ?>
            </a>
          </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
        ?>
          <div class="py-4 text-xs text-[#a48c6f]">お知らせはまだありません。管理画面より投稿を追加してください。</div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- アクセス＆予約CTA -->
  <section class="motion-fade-up max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-gradient-to-r from-[#fde2d9] to-[#e2f0d9] rounded-3xl p-8 sm:p-12 border border-[#e7dac5] flex flex-col lg:flex-row items-center justify-between gap-8">
      <div class="space-y-3 text-center lg:text-left">
        <span class="inline-block bg-white/90 text-[#b54737] text-xs font-bold px-3 py-1 rounded-full shadow-sm">観光・ドライブの立ち寄りに最適</span>
        <h2 class="font-serif text-2xl sm:text-3xl font-bold text-[#392d23]">岡山へのご旅行や週末のカフェ巡りに。</h2>
        <p class="text-sm text-[#6b5a4d] max-w-xl">
          吉備津神社から車で2分、岡山ICから15分。無料駐車場20台を完備しております。<br>
          県内外問わず、皆さまのご来店を心よりお待ちしております。
        </p>
      </div>
      <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
        <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-[#b54737] hover:bg-[#a0392b] text-white font-medium text-sm shadow-md transition">
          <span>お席のご予約はこちら</span>
        </a>
        <a href="<?php echo esc_url( home_url( '/access/' ) ); ?>" class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-full bg-white hover:bg-[#faf7f2] text-[#392d23] font-medium text-sm shadow-sm transition border border-[#d8c8b2]">
          <span>アクセス・地図</span>
        </a>
      </div>
    </div>
  </section>
</div>

<?php get_footer(); ?>
