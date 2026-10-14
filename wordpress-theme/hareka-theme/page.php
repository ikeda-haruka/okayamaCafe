<?php
/**
 * The template for displaying all pages
 *
 * @package hareka-theme
 */

get_header();
?>

<div class="space-y-12 sm:space-y-16 pb-20">
    <?php while ( have_posts() ) : the_post(); ?>
        <!-- ページヘッダー -->
        <section class="relative bg-gradient-to-b from-[#fde2d9]/60 via-[#faf7f2] to-[#e2f0d9]/60 py-16 sm:py-20 border-b border-[#e7dac5]">
            <div class="max-w-4xl mx-auto px-4 text-center space-y-4">
                <span class="inline-block text-xs font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
                    <?php echo esc_html( get_post_field( 'post_name', get_post() ) ); ?>
                </span>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-[#392d23] leading-tight">
                    <?php the_title(); ?>
                </h1>
                <div class="w-16 h-1 bg-[#e26d5c] mx-auto rounded-full"></div>
            </div>
        </section>

        <!-- メインコンテンツ -->
        <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-3xl p-6 sm:p-12 border border-[#e7dac5] shadow-sm prose prose-brown max-w-none' ); ?>>
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="mb-8 rounded-2xl overflow-hidden">
                        <?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-auto object-cover' ) ); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content text-[#574636] leading-relaxed text-sm sm:text-base space-y-4">
                    <?php the_content(); ?>
                </div>
            </article>
        </section>
    <?php endwhile; ?>
</div>

<?php
get_footer();
