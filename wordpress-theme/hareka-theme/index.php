<?php
/**
 * The main template file
 *
 * @package hareka-theme
 */

get_header();
?>

<div class="space-y-12 sm:space-y-16 pb-20">
    <!-- ヘッダー -->
    <section class="relative bg-gradient-to-b from-[#fde2d9]/60 via-[#faf7f2] to-[#e2f0d9]/60 py-16 sm:py-20 border-b border-[#e7dac5]">
        <div class="max-w-4xl mx-auto px-4 text-center space-y-4">
            <span class="inline-block text-xs font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
                NEWS & JOURNAL
            </span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-[#392d23] leading-tight">
                お知らせ・果実便り
            </h1>
            <div class="w-16 h-1 bg-[#e26d5c] mx-auto rounded-full"></div>
            <p class="text-xs sm:text-sm text-[#6b5a4d]">
                CAFE HAREKAからの最新情報、旬の果物の入荷情報、季節の限定メニューのお知らせです。
            </p>
        </div>
    </section>

    <!-- 記事一覧 -->
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if ( have_posts() ) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-3xl overflow-hidden border border-[#e7dac5] shadow-sm hover:shadow-md transition flex flex-col' ); ?>>
                        <div class="aspect-video bg-[#faf7f2] relative overflow-hidden">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'hareka-card', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300' ) ); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hareka-placeholder.svg' ); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            <?php endif; ?>
                            <div class="absolute top-3 left-3">
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm backdrop-blur-sm <?php echo esc_attr( $badge_cls ); ?>">
                                    <?php echo esc_html( $cat_name ); ?>
                                </span>
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="text-[11px] text-[#a48c6f] font-medium block">
                                    <?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
                                </time>
                                <h2 class="font-serif text-base font-bold text-[#392d23] line-clamp-2 leading-snug">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-[#b54737] transition">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                <p class="text-xs text-[#6b5a4d] line-clamp-3 leading-relaxed">
                                    <?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?>
                                </p>
                            </div>

                            <div class="pt-3 border-t border-[#f4eee3]">
                                <a href="<?php the_permalink(); ?>" class="text-xs font-semibold text-[#b54737] hover:underline inline-flex items-center gap-1">
                                    <span>詳しく読む</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                </a>
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
                    'prev_text'          => '← 前へ',
                    'next_text'          => '次へ →',
                    'screen_reader_text' => '記事一覧ページナビゲーション',
                ) );
                ?>
            </div>
        <?php else : ?>
            <div class="bg-white rounded-3xl p-12 text-center border border-[#e7dac5] space-y-4">
                <p class="text-sm text-[#6b5a4d]">現在表示できる記事はありません。</p>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block px-6 py-2.5 rounded-full bg-[#392d23] text-white text-xs font-semibold hover:bg-[#574636] transition">
                    トップページへ戻る
                </a>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php
get_footer();
