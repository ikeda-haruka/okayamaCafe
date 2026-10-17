<?php
/**
 * The template for displaying the blog/news posts index (Posts Page)
 * Description: 「表示設定 > 投稿ページ」で指定されたページ（例: /news/）用のテンプレート
 *
 * @package hareka-theme
 */

get_header();

// 現在のカテゴリを取得（もしあれば）
$current_cat_id = get_queried_object_id();
$categories     = get_categories( array(
    'orderby'    => 'name',
    'order'      => 'ASC',
    'hide_empty' => true,
) );
?>

<div class="space-y-12 sm:space-y-16 pb-20">
    <!-- ページヘッダー -->
    <section class="relative bg-gradient-to-b from-[#fde2d9]/60 via-[#faf7f2] to-[#e2f0d9]/60 py-16 sm:py-24 border-b border-[#e7dac5]">
        <div class="max-w-4xl mx-auto px-4 text-center space-y-4">
            <span class="inline-block text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
                NEWS & TOPICS
            </span>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold text-[#392d23] leading-tight">
                店舗からのお知らせ
            </h1>
            <div class="w-16 h-1 bg-[#e26d5c] mx-auto rounded-full"></div>
            <p class="text-xs sm:text-sm text-[#6b5a4d] max-w-2xl mx-auto leading-relaxed pt-2">
                CAFE HAREKAからの最新の営業案内、旬の果物の初入荷情報、季節の限定パフェやイベント情報をお届けします。
            </p>
        </div>
    </section>

    <!-- カテゴリフィルター -->
    <?php if ( ! empty( $categories ) ) : ?>
        <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3">
                <a
                    href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/news/' ) ); ?>"
                    class="px-4 py-2 rounded-full text-xs font-semibold transition <?php echo ! is_category() ? 'bg-[#392d23] text-white shadow-sm' : 'bg-white text-[#574636] border border-[#e7dac5] hover:bg-[#faf7f2]'; ?>"
                >
                    すべてのお知らせ
                </a>
                <?php foreach ( $categories as $cat ) : ?>
                    <a
                        href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
                        class="px-4 py-2 rounded-full text-xs font-semibold transition <?php echo ( is_category( $cat->term_id ) ) ? 'bg-[#392d23] text-white shadow-sm' : 'bg-white text-[#574636] border border-[#e7dac5] hover:bg-[#faf7f2]'; ?>"
                    >
                        <?php echo esc_html( $cat->name ); ?> (<?php echo esc_html( $cat->count ); ?>)
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- 記事一覧グリッド -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if ( have_posts() ) : ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php
                    $cats      = get_the_category();
                    $cat_name  = ! empty( $cats ) ? $cats[0]->name : 'お知らせ';
                    $badge_cls = 'bg-[#fde2d9] text-[#b54737]';
                    if ( $cat_name === '旬の入荷' ) {
                        $badge_cls = 'bg-[#e2f0d9] text-[#4a8235]';
                    } elseif ( $cat_name === 'イベント' ) {
                        $badge_cls = 'bg-[#f4eee3] text-[#574636]';
                    }
                    ?>
                    <article
                        id="post-<?php the_ID(); ?>"
                        <?php post_class( 'js-news-card bg-white rounded-3xl overflow-hidden border border-[#e7dac5] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group hover:-translate-y-1 cursor-pointer' ); ?>
                        data-date="<?php echo esc_attr( get_the_date( 'Y.m.d' ) ); ?>"
                        data-category="<?php echo esc_attr( $cat_name ); ?>"
                        data-badge="<?php echo esc_attr( $badge_cls ); ?>"
                        data-title="<?php echo esc_attr( get_the_title() ); ?>"
                        data-img="<?php echo esc_url( has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'hareka-hero' ) : get_template_directory_uri() . '/assets/images/hareka-placeholder.svg' ); ?>"
                    >
                        <!-- サムネイル画像 -->
                        <div class="aspect-video bg-[#faf7f2] relative overflow-hidden block border-b border-[#f4eee3]">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'hareka-card', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500' ) ); ?>
                            <?php else : ?>
                                <img
                                    src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hareka-placeholder.svg' ); ?>"
                                    alt="<?php the_title_attribute(); ?>"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                />
                            <?php endif; ?>
                            <div class="absolute top-3 left-3">
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm backdrop-blur-sm <?php echo esc_attr( $badge_cls ); ?>">
                                    <?php echo esc_html( $cat_name ); ?>
                                </span>
                            </div>
                        </div>

                        <!-- コンテンツ -->
                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div class="space-y-2.5">
                                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="text-[11px] text-[#a48c6f] font-medium flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-[#e26d5c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    <span><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
                                </time>

                                <h2 class="font-serif text-base font-bold text-[#392d23] group-hover:text-[#b54737] transition-colors line-clamp-2 leading-snug">
                                    <span class="hover:text-[#b54737] transition">
                                        <?php the_title(); ?>
                                    </span>
                                </h2>

                                <p class="text-xs text-[#6b5a4d] line-clamp-3 leading-relaxed">
                                    <?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?>
                                </p>

                                <!-- フル本文（モーダル表示用） -->
                                <div class="hidden js-news-body">
                                    <?php the_content(); ?>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-[#f4eee3] flex items-center justify-between">
                                <span class="text-xs font-semibold text-[#b54737] group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                                    <span>詳しく読む</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </span>
                                <span class="text-[10px] text-[#a48c6f]">CAFE HAREKA</span>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- ページネーション -->
            <div class="pt-12 text-center">
                <?php
                the_posts_pagination( array(
                    'mid_size'           => 2,
                    'prev_text'          => '← 前のページ',
                    'next_text'          => '次のページ →',
                    'screen_reader_text' => 'ページ送り',
                ) );
                ?>
            </div>
        <?php else : ?>
            <div class="bg-white rounded-3xl p-12 text-center border border-[#e7dac5] space-y-4 max-w-xl mx-auto shadow-sm">
                <div class="w-12 h-12 rounded-full bg-[#fde2d9] text-[#e26d5c] flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                </div>
                <h3 class="font-serif text-lg font-bold text-[#392d23]">現在、掲載中のお知らせはありません</h3>
                <p class="text-xs text-[#6b5a4d]">WordPress管理画面の「投稿 > 新規追加」から新しいお知らせを公開できます。</p>
                <div class="pt-2">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block px-6 py-2.5 rounded-full bg-[#392d23] text-white text-xs font-semibold hover:bg-[#574636] transition shadow-sm">
                        トップページへ戻る
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <!-- お知らせ詳細ポップアップモーダル（React版完全同一） -->
    <div id="news-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm" role="dialog" aria-modal="true">
        <div id="news-modal-card" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 border border-[#e7dac5] shadow-2xl relative max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 border-b border-[#f4eee3]">
                <div class="flex items-center gap-2 text-xs text-[#a48c6f]">
                    <svg class="w-4 h-4 text-[#e26d5c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    <span id="news-modal-date"></span>
                    <span id="news-modal-badge" class="text-[10px] font-bold px-2 py-0.5 rounded-full ml-2"></span>
                </div>
                <button
                    id="news-modal-close-x"
                    type="button"
                    class="w-8 h-8 rounded-full bg-[#faf7f2] flex items-center justify-center text-[#574636] hover:bg-[#f4eee3] text-sm transition"
                    aria-label="閉じる"
                >
                    ✕
                </button>
            </div>

            <!-- サムネイル画像（未設定時はCAFE HAREKAロゴ入りイラスト） -->
            <div class="rounded-2xl overflow-hidden aspect-video bg-[#faf7f2] border border-[#f4eee3]">
                <img id="news-modal-image" src="" alt="" class="w-full h-full object-cover" />
            </div>

            <!-- タイトル -->
            <h3 id="news-modal-title" class="font-serif text-lg sm:text-xl font-bold text-[#392d23] leading-snug"></h3>

            <!-- 本文エリア -->
            <div id="news-modal-body" class="text-xs sm:text-sm text-[#574636] leading-relaxed whitespace-pre-wrap bg-[#faf7f2] p-4 sm:p-5 rounded-2xl border border-[#f4eee3]"></div>

            <!-- 閉じるボタン -->
            <div class="pt-2 text-center">
                <button
                    id="news-modal-close-btn"
                    type="button"
                    class="px-6 py-2.5 rounded-full bg-[#392d23] text-white text-xs font-semibold hover:bg-[#574636] transition shadow-sm inline-block"
                >
                    閉じる
                </button>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
