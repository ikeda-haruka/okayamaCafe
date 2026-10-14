<?php
/**
 * Template Name: 岡山の果物について (Fruits Story)
 * Description: 岡山の果物へのこだわり・旬果図鑑ページテンプレート
 *
 * @package hareka-theme
 */

get_header();

// デフォルトの旬果データ（カスタム投稿 fruit_info が未登録時のフォールバック用）
$default_fruits = array(
    array(
        'name'        => '清水白桃（しみずはくとう）',
        'reading'     => 'SHIMIZU HAKUTO PEACH',
        'season'      => '7月下旬 〜 8月上旬',
        'sugarBrix'   => '糖度 13〜15度',
        'farm'        => '赤磐市 吉井果樹園 / 倉敷市玉島',
        'image'       => get_template_directory_uri() . '/assets/images/shimizu_peach.jpg',
        'description' => '「白桃の女王」と称される最高峰の品種。職人が1玉ずつ手作業で袋掛けし、陽の光を浴びずに真っ白な姿に育て上げられます。緻密で繊維の少ない果肉からは、一口かじると芳醇な果汁が溢れ出します。',
        'features'    => array( '果肉が極めて柔らかくジューシー', '上品で気品ある香りと濃厚な甘み', '白く滑らかな美しい果皮' ),
    ),
    array(
        'name'        => 'おかやま夢白桃（ゆめはくとう）',
        'reading'     => 'OKAYAMA YUME HAKUTO',
        'season'      => '8月上旬 〜 8月中旬',
        'sugarBrix'   => '糖度 14〜16度',
        'farm'        => '岡山市一宮 契約果樹園',
        'image'       => get_template_directory_uri() . '/assets/images/yume_hakuto.jpg',
        'description' => '岡山県が誇る大玉の晩生白桃。清水白桃の優美な香りと柔らかさを引き継ぎつつ、さらに大玉で高糖度に育ちます。夏休みの終盤まで岡山の上質な白桃を味わっていただける自慢の逸品です。',
        'features'    => array( '1玉300g超の大玉サイズ', '渋みが一切なく際立つ濃厚な甘さ', '美しい乳白色の滑らかな果肉' ),
    ),
    array(
        'name'        => '晴王（シャインマスカット）',
        'reading'     => 'SHINE MUSCAT HAREOU',
        'season'      => '7月上旬 〜 10月下旬',
        'sugarBrix'   => '糖度 18〜20度以上',
        'farm'        => '倉敷市船穂町 / 井原市 ぶどう部会',
        'image'       => get_template_directory_uri() . '/assets/images/shine_muscat_vine.jpg',
        'description' => '岡山県独自の厳しい品質基準（糖度18度以上・大粒・美しいエメラルドグリーン）をクリアした最高位ブランド「晴王」。種がなく皮ごと食べられ、口いっぱいに広がるマスカット香と弾ける果汁は唯一無二です。',
        'features'    => array( '皮ごとサクッと食べられる種なし', '極めて高い糖度と爽やかな香り', '宝石のように輝く大粒エメラルド' ),
    ),
    array(
        'name'        => 'ニューピオーネ（黒い真珠）',
        'reading'     => 'NEW PIONE GRAPE',
        'season'      => '8月中旬 〜 10月中旬',
        'sugarBrix'   => '糖度 16〜18度',
        'farm'        => '高梁市備中町 / 新見市哲西町',
        'image'       => get_template_directory_uri() . '/assets/images/new_pione_vine.jpg',
        'description' => '岡山県が誇る種なし高級大粒ぶどう。カルスト地形の冷涼な気候と昼夜の寒暖差が、濃い紫黒色の果皮と深いコクを育みます。上品な甘酸っぱさと濃厚なコクが調和した絶妙な味わいです。',
        'features'    => array( '大粒で食べ応え抜群の種なし', '甘みと程よい酸味の絶妙な黄金比', 'ワインのような奥深いコクと芳香' ),
    ),
    array(
        'name'        => '足守アールスメロン（足守温室メロン）',
        'reading'     => 'ASHIMORI EARL\'S MELON',
        'season'      => '通年（特に春・秋・冬）',
        'sugarBrix'   => '糖度 14〜16度',
        'farm'        => '岡山市北区足守 メロン部会',
        'image'       => get_template_directory_uri() . '/assets/images/ashimori_melon.jpg',
        'description' => '大正時代からの歴史を誇る岡山市足守地区の伝統温室マスクメロン。1本の木にたった1玉だけを残す「一木一果（いちぼくいっか）」栽培により、すべての栄養と甘みが凝縮されています。',
        'features'    => array( '1本に1玉だけの贅沢な一木一果栽培', '芸術的な細かい盛り上がりネット', 'とろけるような果肉と気品ある芳香' ),
    ),
);

// 岡山の気候風土 4つの特徴
$climate_points = array(
    array(
        'icon'        => 'sun',
        'title'       => '晴れの国が育む圧倒的日照時間',
        'desc'        => '年間降水量1mm未満の日数が全国第1位。たっぷりと降り注ぐ太陽の光が、果実の光合成を促し極限まで糖度を高めます。',
    ),
    array(
        'icon'        => 'droplets',
        'title'       => '三大河川がもたらす清らかな水源',
        'desc'        => '吉井川・旭川・高梁川。中国山地から湧き出るミネラル豊富な清流が肥沃な大地を潤し、みずみずしい果肉を育てます。',
    ),
    array(
        'icon'        => 'wind',
        'title'       => '瀬戸内海由来の穏やかな温暖気候',
        'desc'        => '温暖で台風などの自然災害が少ない恵まれた気候。昼夜の適度な寒暖差が果実の旨味と甘みをぎゅっと凝縮させます。',
    ),
    array(
        'icon'        => 'award',
        'title'       => '百余年の歴史と職人の袋掛け技術',
        'desc'        => '明治時代から続く品種改良と、1玉ずつ手作業で袋を被せる繊細な職人技。岡山独自の栽培技術が極上の美しさを叶えます。',
    ),
);
?>

<div class="space-y-16 sm:space-y-24 pb-20">
    <!-- ページヘッダー -->
    <section class="relative bg-gradient-to-b from-[#fde2d9]/60 via-[#faf7f2] to-[#e2f0d9]/60 py-16 sm:py-24 border-b border-[#e7dac5]">
        <div class="max-w-4xl mx-auto px-4 text-center space-y-4">
            <span class="inline-block text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
                OKAYAMA FRUITS STORY
            </span>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold text-[#392d23] leading-tight">
                岡山の果物へのこだわり
            </h1>
            <div class="w-16 h-1 bg-[#e26d5c] mx-auto rounded-full"></div>
            <p class="text-xs sm:text-sm text-[#6b5a4d] max-w-2xl mx-auto leading-relaxed pt-2">
                全国に名高い「果物王国・岡山」。なぜ岡山の果物はこれほどまでに甘く芳醇なのか。<br class="hidden sm:inline" />
                気候風土の恵みと、代々受け継がれる農家さんの熱い想いをお伝えします。
            </p>
        </div>
    </section>

    <!-- 岡山の果物が美味しい4つの理由 -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-3 mb-12">
            <span class="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
                WHY OKAYAMA?
            </span>
            <h2 class="font-serif text-2xl sm:text-4xl font-bold text-[#392d23]">
                岡山の果物が極上に育つ4つの理由
            </h2>
            <p class="text-sm text-[#6b5a4d] max-w-xl mx-auto">
                温暖な気候と清流、そして農家さんの繊細な職人技が奇跡の美味しさを生み出します。
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ( $climate_points as $point ) : ?>
                <div class="bg-white rounded-3xl p-6 border border-[#e7dac5] shadow-sm hover:shadow-md transition-shadow space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#faf7f2] flex items-center justify-center border border-[#f4eee3] text-[#e26d5c]">
                        <?php if ( $point['icon'] === 'sun' ) : ?>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"></path></svg>
                        <?php elseif ( $point['icon'] === 'droplets' ) : ?>
                            <svg class="w-6 h-6 text-[#6cae54]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path></svg>
                        <?php elseif ( $point['icon'] === 'wind' ) : ?>
                            <svg class="w-6 h-6 text-[#574636]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.7 7.7a2.5 2.5 0 1 1 1.8 4.3H2m12.7 5a2 2 0 1 1-1.4 3.4H2m13.7-14.8A2 2 0 1 1 17 4.3H2"></path></svg>
                        <?php else : ?>
                            <svg class="w-6 h-6 text-[#a48c6f]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        <?php endif; ?>
                    </div>
                    <h3 class="font-serif text-base font-bold text-[#392d23] leading-snug">
                        <?php echo esc_html( $point['title'] ); ?>
                    </h3>
                    <p class="text-xs text-[#6b5a4d] leading-relaxed">
                        <?php echo esc_html( $point['desc'] ); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 旬の果物図鑑 -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-3 mb-14">
            <span class="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
                FRUITS ENCYCLOPEDIA
            </span>
            <h2 class="font-serif text-2xl sm:text-4xl font-bold text-[#392d23]">
                CAFE HAREKA で出会える旬果図鑑
            </h2>
            <p class="text-sm text-[#6b5a4d]">
                それぞれの品種が持つ個性や香りの違いをじっくりとお楽しみください。
            </p>
        </div>

        <div class="space-y-12">
            <?php
            // カスタム投稿 fruit_info をクエリ
            $fruit_query = new WP_Query( array(
                'post_type'      => 'fruit_info',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order date',
                'order'          => 'ASC',
            ) );

            if ( $fruit_query->have_posts() ) :
                $idx = 0;
                while ( $fruit_query->have_posts() ) :
                    $fruit_query->the_post();
                    $fruit_id    = get_the_ID();
                    $reading     = get_post_meta( $fruit_id, '_hareka_fruit_reading', true );
                    $season      = get_post_meta( $fruit_id, '_hareka_fruit_season', true );
                    $sugar       = get_post_meta( $fruit_id, '_hareka_fruit_sugar', true );
                    $farm        = get_post_meta( $fruit_id, '_hareka_fruit_farm', true );
                    $features    = get_post_meta( $fruit_id, '_hareka_fruit_features', true );
                    $features_arr = ! empty( $features ) ? array_filter( array_map( 'trim', explode( "\n", $features ) ) ) : array();

                    $thumb_url = has_post_thumbnail()
                        ? get_the_post_thumbnail_url( $fruit_id, 'hareka-hero' )
                        : get_template_directory_uri() . '/assets/images/shimizu_peach.jpg';
                    ?>
                    <div class="bg-white rounded-3xl overflow-hidden border border-[#e7dac5] shadow-sm grid grid-cols-1 lg:grid-cols-12 items-center">
                        <div class="lg:col-span-6 h-72 sm:h-96 relative bg-[#f4eee3] <?php echo ( $idx % 2 === 1 ) ? 'lg:order-2' : ''; ?>">
                            <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover" />
                            <?php if ( $season ) : ?>
                                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3.5 py-1.5 rounded-full shadow text-xs font-bold text-[#b54737] flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    <span>旬：<?php echo esc_html( $season ); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ( $sugar ) : ?>
                                <div class="absolute bottom-4 right-4 bg-[#392d23]/80 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-bold">
                                    <?php echo esc_html( $sugar ); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="lg:col-span-6 p-6 sm:p-10 space-y-5 <?php echo ( $idx % 2 === 1 ) ? 'lg:order-1' : ''; ?>">
                            <div class="space-y-1">
                                <?php if ( $reading ) : ?>
                                    <div class="text-xs text-[#a48c6f] font-medium tracking-widest uppercase">
                                        <?php echo esc_html( $reading ); ?>
                                    </div>
                                <?php endif; ?>
                                <h3 class="font-serif text-2xl sm:text-3xl font-bold text-[#392d23]">
                                    <?php the_title(); ?>
                                </h3>
                                <?php if ( $farm ) : ?>
                                    <div class="text-xs text-[#4a8235] font-semibold flex items-center gap-1 pt-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                        提携：<?php echo esc_html( $farm ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="text-xs sm:text-sm text-[#6b5a4d] leading-relaxed">
                                <?php the_content(); ?>
                            </div>

                            <?php if ( ! empty( $features_arr ) ) : ?>
                                <div class="space-y-2 pt-2 border-t border-[#f4eee3]">
                                    <span class="text-xs font-bold text-[#392d23] block">美味しさの特徴</span>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        <?php foreach ( $features_arr as $feature ) : ?>
                                            <div class="flex items-center gap-2 text-xs text-[#574636]">
                                                <svg class="w-3.5 h-3.5 text-[#e26d5c] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                                <span><?php echo esc_html( $feature ); ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                    $idx++;
                endwhile;
                wp_reset_postdata();
            else :
                // カスタム投稿未登録時のフォールバック表示
                foreach ( $default_fruits as $idx => $fruit ) :
                    ?>
                    <div class="bg-white rounded-3xl overflow-hidden border border-[#e7dac5] shadow-sm grid grid-cols-1 lg:grid-cols-12 items-center">
                        <div class="lg:col-span-6 h-72 sm:h-96 relative bg-[#f4eee3] <?php echo ( $idx % 2 === 1 ) ? 'lg:order-2' : ''; ?>">
                            <img src="<?php echo esc_url( $fruit['image'] ); ?>" alt="<?php echo esc_attr( $fruit['name'] ); ?>" class="w-full h-full object-cover" />
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3.5 py-1.5 rounded-full shadow text-xs font-bold text-[#b54737] flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <span>旬：<?php echo esc_html( $fruit['season'] ); ?></span>
                            </div>
                            <div class="absolute bottom-4 right-4 bg-[#392d23]/80 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-bold">
                                <?php echo esc_html( $fruit['sugarBrix'] ); ?>
                            </div>
                        </div>

                        <div class="lg:col-span-6 p-6 sm:p-10 space-y-5 <?php echo ( $idx % 2 === 1 ) ? 'lg:order-1' : ''; ?>">
                            <div class="space-y-1">
                                <div class="text-xs text-[#a48c6f] font-medium tracking-widest uppercase">
                                    <?php echo esc_html( $fruit['reading'] ); ?>
                                </div>
                                <h3 class="font-serif text-2xl sm:text-3xl font-bold text-[#392d23]">
                                    <?php echo esc_html( $fruit['name'] ); ?>
                                </h3>
                                <div class="text-xs text-[#4a8235] font-semibold flex items-center gap-1 pt-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    提携：<?php echo esc_html( $fruit['farm'] ); ?>
                                </div>
                            </div>

                            <p class="text-xs sm:text-sm text-[#6b5a4d] leading-relaxed">
                                <?php echo esc_html( $fruit['description'] ); ?>
                            </p>

                            <div class="space-y-2 pt-2 border-t border-[#f4eee3]">
                                <span class="text-xs font-bold text-[#392d23] block">美味しさの特徴</span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <?php foreach ( $fruit['features'] as $feature ) : ?>
                                        <div class="flex items-center gap-2 text-xs text-[#574636]">
                                            <svg class="w-3.5 h-3.5 text-[#e26d5c] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                            <span><?php echo esc_html( $feature ); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </section>

    <!-- 契約農家さんインタビュー -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#f4eee3] rounded-3xl p-8 sm:p-12 border border-[#e7dac5]">
            <div class="max-w-3xl mx-auto space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white text-[#b54737] text-xs font-bold shadow-sm">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path></svg>
                    <span>契約果樹園インタビュー</span>
                </div>
                <h3 class="font-serif text-2xl sm:text-3xl font-bold text-[#392d23] leading-snug">
                    「手塩にかけた桃を、いちばん幸せな瞬間に食べてもらいたい。」
                </h3>
                <div class="text-xs sm:text-sm text-[#6b5a4d] leading-relaxed space-y-3">
                    <p>
                        「岡山の白桃は、陽の光を直接当てないように1玉ずつ袋を被せて育てます。真夏の炎天下での作業は骨が折れますが、透き通るような白い肌と、口に入れた時の果汁の甘さを味わってもらった時の笑顔が何よりの励みです。」
                    </p>
                    <p>
                        「HAREKAさんでは、私たちが朝収穫した桃をその日のうちにパフェやスイーツにしてお客様へ届けてくれます。農家冥利に尽きる取り組みです。」
                    </p>
                </div>
                <div class="pt-2 text-xs font-semibold text-[#574636]">
                    赤磐市 吉井果樹園 代表 / 吉井 誠一さん
                </div>
            </div>
        </div>
    </section>

    <!-- メニュー誘導CTA -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="p-8 sm:p-12 rounded-3xl bg-white border border-[#e7dac5] space-y-4 shadow-sm">
            <h3 class="font-serif text-xl sm:text-2xl font-bold text-[#392d23]">
                これらの果実をふんだんに使ったスイーツはいかがですか？
            </h3>
            <p class="text-xs sm:text-sm text-[#6b5a4d]">
                パフェ、タルト、パンケーキ、クラフトスカッシュなど、多彩なメニューをご用意しています。
            </p>
            <div class="pt-2">
                <a href="<?php echo esc_url( home_url( '/menu/' ) ); ?>" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-gradient-to-r from-[#e26d5c] to-[#b54737] text-white font-medium text-sm shadow hover:shadow-lg transition">
                    <span>旬果メニュー一覧を見る</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
            </div>
        </div>
    </section>
</div>

<?php
get_footer();
