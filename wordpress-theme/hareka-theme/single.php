<?php
/**
 * The template for displaying all single posts
 *
 * @package hareka-theme
 */

get_header();

$post_type = get_post_type();
?>

<div class="space-y-12 sm:space-y-16 pb-20">
    <?php while ( have_posts() ) : the_post(); ?>
        <!-- ヘッダー -->
        <section class="relative bg-gradient-to-b from-[#fde2d9]/60 via-[#faf7f2] to-[#e2f0d9]/60 py-16 sm:py-20 border-b border-[#e7dac5]">
            <div class="max-w-4xl mx-auto px-4 text-center space-y-4">
                <div class="inline-flex items-center gap-2 text-xs font-semibold tracking-wider text-[#b54737] uppercase">
                    <?php if ( $post_type === 'menu_item' ) : ?>
                        <span>CAFE MENU ITEM</span>
                    <?php elseif ( $post_type === 'fruit_info' ) : ?>
                        <span>OKAYAMA FRUIT</span>
                    <?php else : ?>
                        <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                            <?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
                        </time>
                        <?php
                        $categories = get_the_category();
                        if ( ! empty( $categories ) ) :
                            ?>
                            <span class="text-[#a48c6f]">/</span>
                            <span><?php echo esc_html( $categories[0]->name ); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <h1 class="font-serif text-2xl sm:text-4xl font-bold text-[#392d23] leading-tight">
                    <?php the_title(); ?>
                </h1>
                <div class="w-16 h-1 bg-[#e26d5c] mx-auto rounded-full"></div>
            </div>
        </section>

        <!-- 本文エリア -->
        <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-3xl p-6 sm:p-12 border border-[#e7dac5] shadow-sm space-y-8' ); ?>>
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="rounded-2xl overflow-hidden shadow-sm aspect-video bg-[#faf7f2]">
                        <?php the_post_thumbnail( 'hareka-hero', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( $post_type === 'menu_item' ) :
                    $price     = get_post_meta( get_the_ID(), '_hareka_menu_price', true );
                    $origin    = get_post_meta( get_the_ID(), '_hareka_menu_origin', true );
                    $sugar     = get_post_meta( get_the_ID(), '_hareka_menu_sugar', true );
                    $limited   = get_post_meta( get_the_ID(), '_hareka_menu_limited', true );
                    $takeout   = get_post_meta( get_the_ID(), '_hareka_menu_takeout', true );
                    ?>
                    <div class="p-6 rounded-2xl bg-[#faf7f2] border border-[#e7dac5] flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <?php if ( $limited ) : ?>
                                    <span class="bg-[#b54737] text-white text-[10px] font-bold px-2 py-0.5 rounded-full">季節限定</span>
                                <?php endif; ?>
                                <?php if ( $takeout ) : ?>
                                    <span class="bg-[#4a8235] text-white text-[10px] font-bold px-2 py-0.5 rounded-full">テイクアウト可</span>
                                <?php endif; ?>
                            </div>
                            <?php if ( $origin ) : ?>
                                <span class="text-xs text-[#6b5a4d]">産地：<?php echo esc_html( $origin ); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if ( $price ) : ?>
                            <div class="text-right">
                                <span class="text-xs text-[#a48c6f] block">税込価格</span>
                                <span class="font-serif text-2xl font-bold text-[#b54737]"><?php echo esc_html( $price ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content text-[#574636] leading-relaxed text-sm sm:text-base space-y-4">
                    <?php the_content(); ?>
                </div>

                <!-- 記事末尾ナビゲーション -->
                <div class="pt-8 border-t border-[#f4eee3] flex items-center justify-between">
                    <div>
                        <?php previous_post_link( '%link', '← 前の記事へ' ); ?>
                    </div>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="px-5 py-2 rounded-full border border-[#d8c8b2] text-xs font-semibold text-[#574636] hover:bg-[#faf7f2] transition">
                        トップページへ戻る
                    </a>
                    <div>
                        <?php next_post_link( '%link', '次の記事へ →' ); ?>
                    </div>
                </div>
            </article>
        </section>
    <?php endwhile; ?>
</div>

<?php
get_footer();
