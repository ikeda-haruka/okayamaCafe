<?php
/**
 * Template Name: アクセス・店舗情報 (Access & Info)
 * Description: アクセス・マップ・店舗概要・観光モデルコース
 *
 * @package hareka-theme
 */

get_header();
?>

<div class="space-y-16 sm:space-y-24 pb-20">
    <!-- ページヘッダー -->
    <section class="relative bg-gradient-to-b from-[#fde2d9]/60 via-[#faf7f2] to-[#e2f0d9]/60 py-16 sm:py-24 border-b border-[#e7dac5] page-header-box">
        <div class="max-w-4xl mx-auto px-4 text-center space-y-4 page-header-motion">
            <span class="inline-block text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
                LOCATION & ACCESS
            </span>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold text-[#392d23] leading-tight">
                アクセス・店舗情報
            </h1>
            <div class="w-16 h-1 bg-[#e26d5c] mx-auto rounded-full"></div>
            <p class="text-xs sm:text-sm text-[#6b5a4d] max-w-2xl mx-auto leading-relaxed pt-2">
                吉備津神社の美しい参道から車で約2分。豊かな田園と緑に囲まれた心地よいロケーション。<br class="hidden sm:inline" />
                県外からのドライブや岡山観光の合間にもお気軽にお立ち寄りください。
            </p>
        </div>
    </section>

    <!-- マップ＆基本情報 -->
    <section class="motion-fade-up max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- インタラクティブマップエリア -->
            <div class="lg:col-span-7 bg-white rounded-3xl overflow-hidden border border-[#e7dac5] shadow-sm">
                <div class="relative h-80 sm:h-[450px] bg-[#eef0eb] flex items-center justify-center overflow-hidden">
                    <iframe
                        title="CAFE HAREKA 所在地マップ"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13123.63385750346!2d133.8504008!3d34.6698651!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3554070a2569502f%3A0x6b63391b10a562ef!2z5ZCJ5YKZ5rSl56We56S-!5e0!3m2!1sja!2sjp!4v1710000000000!5m2!1sja!2sjp"
                        class="w-full h-full border-0 filter contrast-95 brightness-95"
                        loading="lazy"
                    ></iframe>
                    <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-md px-4 py-2 rounded-2xl shadow-md border border-[#e7dac5] text-xs space-y-1">
                        <span class="font-bold text-[#392d23] block"><?php echo esc_html( hareka_get_shop_info( 'name' ) ); ?></span>
                        <span class="text-[#6b5a4d] block"><?php echo esc_html( hareka_get_shop_info( 'address' ) ); ?></span>
                    </div>
                </div>

                <div class="p-6 bg-white border-t border-[#f4eee3] flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs text-[#6b5a4d]">
                        ※カーナビゲーションには「吉備津神社」または「吉備津780」とご入力ください。
                    </div>
                    <a
                        href="<?php echo esc_url( hareka_get_shop_info( 'google_map_url' ) ); ?>"
                        target="_blank"
                        rel="noreferrer"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#392d23] text-white text-xs font-semibold hover:bg-[#574636] transition shadow-sm shrink-0"
                    >
                        <svg class="w-4 h-4 text-[#f7a48d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
                        <span>Google Mapsでルート案内</span>
                        <svg class="w-3 h-3 text-[#d8c8b2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    </a>
                </div>
            </div>

            <!-- 店舗情報サマリー -->
            <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-8 border border-[#e7dac5] shadow-sm space-y-6">
                <h3 class="font-serif text-xl font-bold text-[#392d23] border-b border-[#f4eee3] pb-3">
                    店舗概要
                </h3>

                <div class="space-y-4 text-xs sm:text-sm">
                    <div class="flex gap-4">
                        <span class="w-24 text-[#a48c6f] shrink-0 font-medium">店名</span>
                        <span class="font-semibold text-[#392d23]"><?php echo esc_html( hareka_get_shop_info( 'name' ) ); ?></span>
                    </div>

                    <div class="flex gap-4">
                        <span class="w-24 text-[#a48c6f] shrink-0 font-medium">住所</span>
                        <span class="text-[#574636]">
                            <?php echo esc_html( hareka_get_shop_info( 'postal_code' ) ); ?><br />
                            <?php echo esc_html( hareka_get_shop_info( 'address' ) ); ?>
                        </span>
                    </div>

                    <div class="flex gap-4">
                        <span class="w-24 text-[#a48c6f] shrink-0 font-medium">電話番号</span>
                        <span class="text-[#b54737] font-bold flex items-center gap-2" title="<?php echo esc_attr( hareka_get_shop_info( 'phone_note' ) ); ?>">
                            <?php echo esc_html( hareka_get_shop_info( 'phone' ) ); ?>
                        </span>
                    </div>

                    <div class="flex gap-4">
                        <span class="w-24 text-[#a48c6f] shrink-0 font-medium">営業時間</span>
                        <div class="text-[#574636]">
                            <?php echo esc_html( hareka_get_shop_info( 'hours_text' ) ); ?><br />
                            <?php if ( ! empty( hareka_get_shop_info( 'special_notice' ) ) ) : ?>
                                <span class="text-xs text-[#b54737] block mt-0.5"><?php echo esc_html( hareka_get_shop_info( 'special_notice' ) ); ?></span>
                            <?php endif; ?>
                            <span class="text-xs text-[#a48c6f]">・ランチタイム：11:00 〜 14:00<br />・カフェタイム：終日</span>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <span class="w-24 text-[#a48c6f] shrink-0 font-medium">定休日</span>
                        <span class="text-[#574636]"><?php echo esc_html( hareka_get_shop_info( 'closed_day' ) ); ?></span>
                    </div>

                    <div class="flex gap-4">
                        <span class="w-24 text-[#a48c6f] shrink-0 font-medium">席数</span>
                        <span class="text-[#574636]">
                            <?php echo esc_html( hareka_get_shop_info( 'seats' ) ); ?>
                        </span>
                    </div>

                    <div class="flex gap-4">
                        <span class="w-24 text-[#a48c6f] shrink-0 font-medium">駐車場</span>
                        <span class="text-[#574636]">
                            <?php echo esc_html( hareka_get_shop_info( 'parking' ) ); ?>
                        </span>
                    </div>

                    <div class="flex gap-4">
                        <span class="w-24 text-[#a48c6f] shrink-0 font-medium">決済方法</span>
                        <div class="text-[#574636]">
                            現金、クレジットカード（VISA, Master, JCB, AMEX）、電子マネー、QRコード決済（PayPay, 楽天ペイ, d払い）
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 交通アクセス手段案内 -->
    <section class="motion-fade-up max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-3 mb-12">
            <span class="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
                HOW TO GET HERE
            </span>
            <h2 class="font-serif text-2xl sm:text-4xl font-bold text-[#392d23]">
                交通手段別アクセスガイド
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- お車でのアクセス -->
            <div class="bg-white rounded-3xl p-8 border border-[#e7dac5] shadow-sm space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-[#fde2d9] text-[#e26d5c] flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    </div>
                    <div>
                        <h3 class="font-serif text-xl font-bold text-[#392d23]">お車・レンタカーでお越しの場合</h3>
                        <span class="text-xs text-[#a48c6f]">ドライブや観光巡りに便利</span>
                    </div>
                </div>

                <ul class="space-y-3 text-xs sm:text-sm text-[#6b5a4d] leading-relaxed">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-[#e26d5c] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span>
                            <strong>山陽自動車道「岡山IC」より約15分</strong>（国道53号・県道経由）
                        </span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-[#e26d5c] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span>
                            <strong>岡山総社ICより約12分</strong>
                        </span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-[#e26d5c] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span>
                            <strong>倉敷美観地区より約25分</strong>（県道経由でスムーズにお越しいただけます）
                        </span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-[#e26d5c] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span>
                            店舗敷地内に20台分のゆったりとした無料駐車場をご用意しております。
                        </span>
                    </li>
                </ul>
            </div>

            <!-- 公共交通機関 -->
            <div class="bg-white rounded-3xl p-8 border border-[#e7dac5] shadow-sm space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-[#e2f0d9] text-[#6cae54] flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="4" y="3" width="16" height="16" rx="2"></rect><path d="M4 11h16"></path><path d="M12 3v8"></path><path d="m8 19-2 3"></path><path d="m18 22-2-3"></path><circle cx="8" cy="15" r="1"></circle><circle cx="16" cy="15" r="1"></circle></svg>
                    </div>
                    <div>
                        <h3 class="font-serif text-xl font-bold text-[#392d23]">電車でお越しの場合</h3>
                        <span class="text-xs text-[#a48c6f]">JR岡山駅からのんびりローカル線の旅</span>
                    </div>
                </div>

                <ul class="space-y-3 text-xs sm:text-sm text-[#6b5a4d] leading-relaxed">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-[#6cae54] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span>
                            <strong>JR桃太郎線（吉備線）「吉備津駅」より徒歩約7分</strong><br />
                            （JR岡山駅より桃太郎線で約18分）
                        </span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-[#6cae54] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span>
                            吉備津神社の国宝本殿や名物の大廻廊（約360m）を散策しながら徒歩でお越しいただけます。
                        </span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-[#6cae54] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span>
                            吉備路レンタサイクルの立ち寄り休憩スポットとしても大変人気です。
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- 岡山観光おすすめモデルコース -->
    <section class="motion-fade-up max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-[#fde2d9]/40 via-[#faf7f2] to-[#e2f0d9]/40 rounded-3xl p-8 sm:p-12 border border-[#e7dac5]">
            <div class="max-w-2xl mx-auto text-center space-y-3 mb-10">
                <span class="text-xs font-semibold tracking-widest text-[#b54737] uppercase block">
                    TOURIST MODEL COURSES
                </span>
                <h3 class="font-serif text-2xl sm:text-3xl font-bold text-[#392d23]">
                    岡山を満喫するカフェ立ち寄りコース
                </h3>
                <p class="text-xs sm:text-sm text-[#6b5a4d]">
                    県外からお越しの皆さまへ。周辺の人気観光名所と組み合わせたおすすめルートです。
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-[#e7dac5] space-y-3 shadow-sm">
                    <span class="inline-block bg-[#fde2d9] text-[#b54737] text-xs font-bold px-3 py-1 rounded-full">
                        コースA：歴史と果実の吉備路めぐり
                    </span>
                    <h4 class="font-serif text-base font-bold text-[#392d23]">
                        国宝・吉備津神社 参拝 ＆ 白桃パフェ
                    </h4>
                    <p class="text-xs text-[#6b5a4d] leading-relaxed">
                        JR岡山駅 → 吉備津神社（美しい廻廊を散策） → <strong>CAFE HAREKA（旬の果実パフェでランチ＆休憩）</strong> → 備中国分寺（五重塔と田園風景）
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-[#e7dac5] space-y-3 shadow-sm">
                    <span class="inline-block bg-[#e2f0d9] text-[#4a8235] text-xs font-bold px-3 py-1 rounded-full">
                        コースB：後楽園から倉敷へ抜けるドライブ
                    </span>
                    <h4 class="font-serif text-base font-bold text-[#392d23]">
                        岡山後楽園・岡山城 ＆ テラスカフェ
                    </h4>
                    <p class="text-xs text-[#6b5a4d] leading-relaxed">
                        岡山後楽園・岡山城 → <strong>CAFE HAREKA（ガーデンテラスでマスカットスイーツ＆コーヒー）</strong> → 倉敷美観地区（白壁の町並み散策）
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
get_footer();
