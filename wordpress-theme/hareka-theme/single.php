<?php
/**
 * The template for displaying all single posts
 *
 * @package hareka-theme
 */

get_header();

$post_type = get_post_type();
?>

<?php if ( $post_type === 'post' ) : ?>
    <!-- お知らせ投稿（NEWS）専用詳細レイアウト（React版デザイン準拠） -->
    <div class="space-y-12 sm:space-y-16 pb-20">
        <!-- ページヘッダー -->
        <section class="relative bg-gradient-to-b from-[#fde2d9]/60 via-[#faf7f2] to-[#e2f0d9]/60 py-12 sm:py-16 border-b border-[#e7dac5] page-header-box">
            <div class="max-w-4xl mx-auto px-4 text-center space-y-3 page-header-motion">
                <span class="inline-block text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
                    NEWS & TOPICS
                </span>
                <h1 class="font-serif text-2xl sm:text-4xl font-bold text-[#392d23] leading-tight">
                    店舗からのお知らせ
                </h1>
                <div class="w-16 h-1 bg-[#e26d5c] mx-auto rounded-full"></div>
            </div>
        </section>

        <!-- お知らせ詳細カード（Reactモーダル完全一致レイアウト） -->
        <section class="motion-fade-up max-w-xl mx-auto px-4 sm:px-6">
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
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-3xl p-6 sm:p-8 space-y-5 border border-[#e7dac5] shadow-xl relative' ); ?>>
                    <!-- ヘッダーメタ情報 -->
                    <div class="flex items-center justify-between pb-3 border-b border-[#f4eee3]">
                        <div class="flex items-center gap-2 text-xs text-[#a48c6f]">
                            <svg class="w-4 h-4 text-[#e26d5c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            <span><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full ml-2 <?php echo esc_attr( $badge_cls ); ?>">
                                <?php echo esc_html( $cat_name ); ?>
                            </span>
                        </div>
                        <a
                            href="<?php echo esc_url( home_url( '/news/' ) ); ?>"
                            class="w-8 h-8 rounded-full bg-[#faf7f2] flex items-center justify-center text-[#574636] hover:bg-[#f4eee3] text-sm transition"
                            title="一覧へ戻る"
                        >
                            ✕
                        </a>
                    </div>

                    <!-- サムネイル画像（未設定時はCAFE HAREKAロゴ入りイラスト） -->
                    <div class="rounded-2xl overflow-hidden aspect-video bg-[#faf7f2] border border-[#f4eee3]">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'hareka-hero', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                        <?php else : ?>
                            <img
                                src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hareka-placeholder.svg' ); ?>"
                                alt="<?php the_title_attribute(); ?>"
                                class="w-full h-full object-cover"
                            />
                        <?php endif; ?>
                    </div>

                    <!-- タイトル -->
                    <h2 class="font-serif text-lg sm:text-xl font-bold text-[#392d23] leading-snug">
                        <?php the_title(); ?>
                    </h2>

                    <!-- 本文エリア（React版と同じ薄ベージュ枠） -->
                    <div class="text-xs sm:text-sm text-[#574636] leading-relaxed whitespace-pre-wrap bg-[#faf7f2] p-4 sm:p-5 rounded-2xl border border-[#f4eee3] entry-content">
                        <?php the_content(); ?>
                    </div>

                    <!-- 閉じるボタン -->
                    <div class="pt-2 text-center">
                        <a
                            href="<?php echo esc_url( home_url( '/news/' ) ); ?>"
                            class="px-6 py-2.5 rounded-full bg-[#392d23] text-white text-xs font-semibold hover:bg-[#574636] transition shadow-sm inline-block"
                        >
                            閉じる
                        </a>
                    </div>

                    <!-- 前後の記事ナビゲーション -->
                    <div class="pt-4 border-t border-[#f4eee3] flex items-center justify-between text-xs text-[#a48c6f]">
                        <div>
                            <?php previous_post_link( '%link', '← 前のお知らせ' ); ?>
                        </div>
                        <div>
                            <?php next_post_link( '%link', '次のお知らせ →' ); ?>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </section>
    </div>

<?php else : ?>
    <!-- メニュー・果物図鑑などのカスタム投稿タイプ用レイアウト -->
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
<?php endif; ?>

<?php
get_footer();
