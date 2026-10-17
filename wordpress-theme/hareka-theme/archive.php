<?php
/**
 * The template for displaying archive pages
 *
 * @package hareka-theme
 */

get_header();

$categories = get_categories( array(
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
                CATEGORY ARCHIVE
            </span>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold text-[#392d23] leading-tight">
                <?php the_archive_title(); ?>
            </h1>
            <div class="w-16 h-1 bg-[#e26d5c] mx-auto rounded-full"></div>
            <?php if ( get_the_archive_description() ) : ?>
                <div class="text-xs sm:text-sm text-[#6b5a4d] max-w-2xl mx-auto leading-relaxed pt-2">
                    <?php the_archive_description(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- カテゴリフィルター -->
    <?php if ( ! empty( $categories ) ) : ?>
        <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3">
                <a
                    href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/news/' ) ); ?>"
                    class="px-4 py-2 rounded-full text-xs font-semibold bg-white text-[#574636] border border-[#e7dac5] hover:bg-[#faf7f2] transition"
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
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
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-3xl overflow-hidden border border-[#e7dac5] shadow-sm hover:shadow-md transition-all duration-300 flex flex-col group' ); ?>>
                        <a href="<?php the_permalink(); ?>" class="aspect-video bg-[#faf7f2] relative overflow-hidden block">
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
                        </a>

                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div class="space-y-2.5">
                                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="text-[11px] text-[#a48c6f] font-medium flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    <span><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
                                </time>

                                <h2 class="font-serif text-base sm:text-lg font-bold text-[#392d23] group-hover:text-[#b54737] transition-colors line-clamp-2 leading-snug">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <p class="text-xs text-[#6b5a4d] line-clamp-3 leading-relaxed">
                                    <?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?>
                                </p>
                            </div>

                            <div class="pt-4 border-t border-[#f4eee3] flex items-center justify-between">
                                <a href="<?php the_permalink(); ?>" class="text-xs font-semibold text-[#b54737] group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                                    <span>記事を読む</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

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
                <h3 class="font-serif text-lg font-bold text-[#392d23]">該当するお知らせはありません</h3>
                <p class="text-xs text-[#6b5a4d]">別のカテゴリーを選択するか、トップページへお戻りください。</p>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php
get_footer();
