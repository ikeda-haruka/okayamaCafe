<?php
/**
 * Template Name: ご予約・お問い合わせ (Contact & Reservation)
 * Description: 空き枠判別・満席誤予約防止・仮予約制フロー・日英バイリンガル対応のお問い合わせテンプレート
 *
 * @package hareka-theme
 */

get_header();

// FAQ データ（日英バイリンガル）
$faq_items = array(
    array(
        'q_ja' => '予約はいつから受け付けていますか？',
        'q_en' => 'How far in advance can I make a reservation?',
        'a_ja' => 'ご来店希望日の30日前から、前日の17:00までこちらのWebフォームより受け付けております。当日のご予約や空席確認につきましては、お電話（' . hareka_get_shop_info( 'phone' ) . '）にて直接お問い合わせください。',
        'a_en' => 'We accept online reservations from 30 days up to 1 day prior (until 17:00). For same-day reservations or immediate seat checks, please call us directly (' . hareka_get_shop_info( 'phone' ) . ').',
    ),
    array(
        'q_ja' => '満席の時間帯は予約できませんか？',
        'q_en' => 'Can I book a time slot marked as "Fully Booked (✕)"?',
        'a_ja' => 'はい。当店では確実なお席の確保とスムーズなご案内のため、予約枠が上限に達した時間帯（✕表示）はフォームからの受付を自動停止しております。◎または△の空き枠をお選びいただくか、別のお日にちをご検討ください。',
        'a_en' => 'No. To ensure comfortable seating for all guests, time slots marked with ✕ are locked once full capacity is reached. Please select an available slot (◎ or △) or another date.',
    ),
    array(
        'q_ja' => '「仮予約」とはどういう状態ですか？',
        'q_en' => 'What does "Provisional Reservation" mean?',
        'a_ja' => 'Webフォームからの送信時点では「仮受付」となります。店舗スタッフが内容を確認し、24時間以内に「【CAFE HAREKA】ご予約確定メール」をお送りした時点で正式な確定となります。',
        'a_en' => 'Your submission acts as an advance request. Our cafe team will check table assignments and send you a confirmation email within 24 hours to finalize your reservation.',
    ),
    array(
        'q_ja' => '席のみの予約で、来店時にメニューを選べますか？',
        'q_en' => 'Can I reserve seats only and choose desserts upon arrival?',
        'a_ja' => 'はい、可能です。お席のみをご予約いただき、当日店頭にて旬のパフェやランチプレートをご自由にご注文いただけます。ただし、数量限定メニュー（パフェ等）は完売となる場合がございます。',
        'a_en' => 'Yes! You can reserve your table and order parfaits, seasonal tarts, and lunch plates at the cafe. Note that some seasonal items are limited in daily quantities.',
    ),
    array(
        'q_ja' => 'ペット連れで利用できますか？',
        'q_en' => 'Can I bring my pet / dog?',
        'a_ja' => 'はい、ガーデンテラス席（全14席）はリードを着用の上、ペットご同伴でご利用いただけます。雨天時や強風時はテラス席のご利用を制限させていただく場合がございます。',
        'a_en' => 'Yes, pets on a leash are welcome at our open-air garden terrace (14 seats). We also provide water bowls for dogs. Terrace seating may be restricted during severe weather.',
    ),
    array(
        'q_ja' => '駐車場や決済方法について教えてください',
        'q_en' => 'Do you have parking and accept international cards?',
        'a_ja' => '店舗敷地内に無料駐車場20台（普通車・軽自動車）を完備しております。決済は現金、各種国際クレジットカード（VISA, MasterCard, JCB, AMEX）、電子マネー、QR決済に対応しております。',
        'a_en' => 'We have 20 free parking spaces on-site. We accept major credit cards (VISA, MasterCard, JCB, AMEX), Apple Pay, and contactless IC payments.',
    ),
);
?>

<div class="space-y-16 sm:space-y-24 pb-20">
    <!-- ページヘッダー -->
    <section class="relative bg-gradient-to-b from-[#fde2d9]/60 via-[#faf7f2] to-[#e2f0d9]/60 py-16 sm:py-24 border-b border-[#e7dac5] page-header-box">
        <div class="max-w-4xl mx-auto px-4 text-center space-y-4 page-header-motion">
            <span class="inline-block text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase" id="page-subtitle-en">
                RESERVATION & CONTACT
            </span>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold text-[#392d23] leading-tight" id="page-main-title">
                ご予約・お問い合わせ
            </h1>
            <div class="w-16 h-1 bg-[#e26d5c] mx-auto rounded-full"></div>
            <p class="text-xs sm:text-sm text-[#6b5a4d] max-w-2xl mx-auto leading-relaxed pt-2" id="page-main-desc">
                お席の事前予約リクエストや、果物の入荷確認、団体・取材のお問い合わせなど、お気軽にご連絡ください。<br class="hidden sm:inline" />
                空き状況のリアルタイム確認が可能です。
            </p>
        </div>
    </section>

    <section class="motion-fade-up max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- 言語切り替えバー -->
        <div class="flex justify-end mb-6">
            <div class="inline-flex items-center gap-1 bg-white p-1 rounded-2xl border border-[#e7dac5] shadow-sm">
                <span class="text-[11px] font-semibold text-[#8c735d] px-2 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-[#e26d5c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    <span class="hidden sm:inline">Language:</span>
                </span>
                <button
                    type="button"
                    id="lang-btn-ja"
                    class="lang-toggle-btn active px-3.5 py-1.5 rounded-xl text-xs font-bold bg-[#392d23] text-white transition-all shadow-sm cursor-pointer"
                    data-lang="ja"
                >
                    🇯🇵 日本語
                </button>
                <button
                    type="button"
                    id="lang-btn-en"
                    class="lang-toggle-btn px-3.5 py-1.5 rounded-xl text-xs font-bold text-[#574636] hover:bg-[#faf7f2] transition-all cursor-pointer"
                    data-lang="en"
                >
                    🇬🇧 English
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            <!-- お問い合わせフォームエリア -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-10 border border-[#e7dac5] shadow-sm">
                <!-- 完了画面（初期非表示） -->
                <div id="booking-complete-box" class="hidden text-center py-10 space-y-5">
                    <div class="w-16 h-16 rounded-full bg-[#e2f0d9] text-[#6cae54] flex items-center justify-center mx-auto text-2xl shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>

                    <div class="space-y-2">
                        <span id="booking-ref-badge" class="inline-block px-3 py-1 bg-[#fde2d9] text-[#b54737] rounded-full text-xs font-bold">
                            受付番号: HRK-XXXX
                        </span>
                        <h3 id="booking-complete-title" class="font-serif text-2xl font-bold text-[#392d23]">
                            ご予約リクエスト（仮予約）を受け付けました
                        </h3>
                    </div>

                    <div id="booking-provisional-notice" class="bg-[#fef2ee] border border-[#fbc6b6] rounded-2xl p-5 text-left max-w-md mx-auto space-y-3 text-xs text-[#574636]">
                        <div class="flex items-center gap-2 font-bold text-[#b54737] border-b border-[#fbc6b6]/60 pb-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                            <span id="booking-provisional-heading">現時点では【仮予約】の状態です</span>
                        </div>
                        <p id="booking-provisional-text" class="leading-relaxed text-[#6b5a4d]">
                            店舗スタッフが配席状況を確認の上、24時間以内に「ご予約確定メール」をお送りいたします。確定メールの受信をもってご予約成立となります。
                        </p>
                    </div>

                    <p id="booking-complete-desc" class="text-xs text-[#6b5a4d] max-w-md mx-auto leading-relaxed">
                        ご入力いただいたメールアドレス宛に自動返信メールを送信いたしました。メールが届かない場合は、迷惑メールフォルダをご確認いただくか、店舗（<?php echo esc_html( hareka_get_shop_info( 'phone' ) ); ?>）までお問い合わせください。
                    </p>

                    <div class="pt-4">
                        <button
                            type="button"
                            id="reset-form-btn"
                            class="px-6 py-2.5 rounded-full border border-[#d8c8b2] text-xs font-semibold text-[#574636] hover:bg-[#faf7f2] transition cursor-pointer"
                        >
                            別の内容で送信する / Submit Another
                        </button>
                    </div>
                </div>

                <!-- 送信フォーム本体 -->
                <form id="contact-booking-form" class="space-y-6">
                    <?php wp_nonce_field( 'hareka_contact_nonce', 'hareka_contact_nonce' ); ?>
                    <!-- 送信エラー時アラート（初期非表示） -->
                    <div id="booking-error-alert" class="hidden p-4 rounded-2xl bg-[#fef2ee] border border-[#fbc6b6] text-xs text-[#b54737] flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <span id="booking-error-msg"></span>
                    </div>

                    <div class="space-y-1 border-b border-[#f4eee3] pb-4">
                        <span class="text-xs font-semibold tracking-widest text-[#a48c6f] uppercase block mb-1">
                            RESERVATION FORM
                        </span>
                        <h2 class="font-serif text-xl sm:text-2xl font-bold text-[#392d23]" id="form-heading-title">
                            お問い合わせ・席予約フォーム
                        </h2>
                        <p class="text-xs text-[#a48c6f]" id="form-heading-desc">
                            必須項目をご入力の上、送信してください。/ Please fill in the required fields.
                        </p>
                    </div>

                    <!-- お問い合わせ種別 -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-[#392d23]">
                            <span id="label-inquiry-type">お問い合わせ種別</span>
                            <span class="text-[10px] text-[#a48c6f]">/ Inquiry Type</span>
                            <span class="text-[#e26d5c]">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <label class="flex items-center gap-2 p-3 rounded-2xl border border-[#e7dac5] hover:border-[#b54737] cursor-pointer text-xs font-medium has-[:checked]:bg-[#fef2ee] has-[:checked]:border-[#b54737] has-[:checked]:text-[#b54737]">
                                <input type="radio" name="inquiry_type" value="席のご予約" checked class="text-[#b54737] focus:ring-[#b54737]" />
                                <div>
                                    <span class="type-text-main block">席のご予約（仮予約）</span>
                                    <span class="text-[10px] text-[#a48c6f] block">Table Reservation</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-2 p-3 rounded-2xl border border-[#e7dac5] hover:border-[#b54737] cursor-pointer text-xs font-medium has-[:checked]:bg-[#fef2ee] has-[:checked]:border-[#b54737] has-[:checked]:text-[#b54737]">
                                <input type="radio" name="inquiry_type" value="取材・貸切のご相談" class="text-[#b54737] focus:ring-[#b54737]" />
                                <div>
                                    <span class="type-text-main block">取材・貸切のご相談</span>
                                    <span class="text-[10px] text-[#a48c6f] block">Media / Private Event</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-2 p-3 rounded-2xl border border-[#e7dac5] hover:border-[#b54737] cursor-pointer text-xs font-medium has-[:checked]:bg-[#fef2ee] has-[:checked]:border-[#b54737] has-[:checked]:text-[#b54737]">
                                <input type="radio" name="inquiry_type" value="果物・ギフトに関するお問い合わせ" class="text-[#b54737] focus:ring-[#b54737]" />
                                <div>
                                    <span class="type-text-main block">商品・その他</span>
                                    <span class="text-[10px] text-[#a48c6f] block">General Inquiry</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- 席予約専用フィールドグループ -->
                    <div id="reservation-fields" class="space-y-5 bg-[#faf7f2] p-5 sm:p-6 rounded-2xl border border-[#e7dac5]">
                        <div class="flex items-center justify-between border-b border-[#ebdcc9] pb-3">
                            <h3 class="font-serif text-sm font-bold text-[#392d23] flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#e26d5c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <span id="section-res-title">席予約詳細・空き状況選択</span>
                            </h3>
                            <span class="text-[11px] text-[#4a8235] font-semibold bg-white px-2.5 py-0.5 rounded-full border border-[#d2e3c7]" id="safe-badge-text">
                                満席誤予約防止機能 ON
                            </span>
                        </div>

                        <!-- 予約希望日 & 人数 -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="reserve-date" class="block text-xs font-bold text-[#392d23] mb-1.5">
                                    <span id="label-date-text">ご来店希望日</span>
                                    <span class="text-[10px] text-[#a48c6f]">/ Preferred Date</span>
                                    <span class="text-[#e26d5c]">*</span>
                                </label>
                                <input
                                    type="date"
                                    id="reserve-date"
                                    name="reserve_date"
                                    required
                                    class="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                                />
                                <span class="text-[11px] text-[#b54737] mt-1 block" id="text-wednesday-notice">
                                    ※<?php echo esc_html( hareka_get_shop_info( 'closed_day' ) ); ?>
                                </span>
                            </div>

                            <div>
                                <label for="reserve-guests" class="block text-xs font-bold text-[#392d23] mb-1.5">
                                    <span id="label-guests-text">ご利用人数</span>
                                    <span class="text-[10px] text-[#a48c6f]">/ Guests</span>
                                    <span class="text-[#e26d5c]">*</span>
                                </label>
                                <select
                                    id="reserve-guests"
                                    name="reserve_guests"
                                    class="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                                >
                                    <option value="1">1名様 (1 Guest)</option>
                                    <option value="2" selected>2名様 (2 Guests)</option>
                                    <option value="3">3名様 (3 Guests)</option>
                                    <option value="4">4名様 (4 Guests)</option>
                                    <option value="5">5名様 (5 Guests)</option>
                                    <option value="6">6名様以上 (6+ Guests)</option>
                                </select>
                            </div>
                        </div>

                        <!-- 水曜定休日警告アラート -->
                        <div id="wednesday-alert" class="hidden p-3.5 rounded-xl bg-[#fff3cd] border border-[#ffeeba] text-xs text-[#856404] flex items-start gap-2">
                            <svg class="w-4 h-4 text-[#856404] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                            <span id="wednesday-alert-text"><strong><?php echo esc_html( hareka_get_shop_info( 'closed_day_short' ) ); ?>は定休日です。</strong> 定休日以外の日程をご選択ください。 / We are closed on <?php echo esc_html( hareka_get_shop_info( 'closed_day_short' ) ); ?>. Please select another date.</span>
                        </div>

                        <!-- 時間帯別空き枠セレクター -->
                        <div id="timeslot-container" class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-bold text-[#392d23]">
                                    <span id="label-time-text">ご来店時間枠の選択</span>
                                    <span class="text-[10px] text-[#a48c6f]">/ Time Slot</span>
                                    <span class="text-[#e26d5c]">*</span>
                                </label>
                                <div class="flex items-center gap-3 text-[10px] text-[#6b5a4d]" id="legend-slots">
                                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-[#4a8235]"></span><span class="legend-avail">◎ 余裕あり</span></span>
                                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-[#d97706]"></span><span class="legend-few">△ 残少</span></span>
                                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-[#9ca3af]"></span><span class="legend-full">✕ 満席</span></span>
                                </div>
                            </div>

                            <input type="hidden" name="reserve_time" id="selected-time-input" value="11:00" />
                            
                            <!-- グリッド表示エリア（JSで生成） -->
                            <div id="slots-grid" class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-1">
                                <!-- JSがここにボタンスロットをレンダリング -->
                            </div>
                        </div>

                        <!-- お席のご希望 -->
                        <div class="space-y-1.5 pt-2">
                            <label class="block text-xs font-bold text-[#392d23]">
                                <span id="label-seat-text">ご希望の座席タイプ</span>
                                <span class="text-[10px] text-[#a48c6f]">/ Seating Area</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <label class="flex items-center gap-2 p-3 rounded-xl border border-[#d8c8b2] bg-white cursor-pointer text-xs has-[:checked]:border-[#b54737] has-[:checked]:bg-[#fef2ee]">
                                    <input type="radio" name="seat_type" value="店内テーブル席" checked class="text-[#b54737]" />
                                    <div>
                                        <span class="block font-medium seat-table-main">店内テーブル席</span>
                                        <span class="text-[10px] text-[#a48c6f] block">Indoor Table (Cozy)</span>
                                    </div>
                                </label>
                                <label class="flex items-center gap-2 p-3 rounded-xl border border-[#d8c8b2] bg-white cursor-pointer text-xs has-[:checked]:border-[#b54737] has-[:checked]:bg-[#fef2ee]">
                                    <input type="radio" name="seat_type" value="ガーデンテラス席" class="text-[#b54737]" />
                                    <div>
                                        <span class="block font-medium seat-terrace-main">ガーデンテラス席（ペット可）</span>
                                        <span class="text-[10px] text-[#a48c6f] block">Garden Terrace (Pets Welcome)</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- お客様基本情報 -->
                    <div>
                        <label for="user-name" class="block text-xs font-bold text-[#392d23] mb-1.5">
                            <span id="label-name-text">お名前</span>
                            <span class="text-[10px] text-[#a48c6f]">/ Full Name</span>
                            <span class="text-[#e26d5c]">*</span>
                        </label>
                        <input
                            type="text"
                            id="user-name"
                            name="user_name"
                            required
                            placeholder="山田 太郎 / John Smith"
                            class="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                        />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="user-email" class="block text-xs font-bold text-[#392d23] mb-1.5">
                                <span id="label-email-text">メールアドレス</span>
                                <span class="text-[10px] text-[#a48c6f]">/ Email Address</span>
                                <span class="text-[#e26d5c]">*</span>
                            </label>
                            <input
                                type="email"
                                id="user-email"
                                name="user_email"
                                required
                                placeholder="example@hareka.jp"
                                class="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                            />
                        </div>

                        <div>
                            <label for="user-phone" class="block text-xs font-bold text-[#392d23] mb-1.5">
                                <span id="label-phone-text">お電話番号（ハイフンなし）</span>
                                <span class="text-[10px] text-[#a48c6f]">/ Phone (No hyphens)</span>
                                <span class="text-[#e26d5c]">*</span>
                            </label>
                            <input
                                type="tel"
                                id="user-phone"
                                name="user_phone"
                                required
                                pattern="[0-9]{10,11}"
                                inputmode="numeric"
                                maxlength="11"
                                placeholder="09012345678"
                                title="半角数字10〜11桁（ハイフンなし）で入力してください"
                                class="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                            />
                            <p class="text-[11px] text-[#8c735d] mt-1" id="phone-format-hint">
                                ※半角数字のみ・ハイフンなし（例：09012345678 / 0861234567）
                            </p>
                        </div>
                    </div>

                    <!-- メモ・ご要望 -->
                    <div>
                        <label for="user-message" class="block text-xs font-bold text-[#392d23] mb-1.5">
                            <span id="label-msg-text">ご要望・メッセージ（アレルギー、記念日など）</span>
                            <span class="text-[10px] text-[#a48c6f]">/ Special Requests</span>
                        </label>
                        <textarea
                            id="user-message"
                            name="user_message"
                            rows="4"
                            placeholder="お子様連れ、フルーツアレルギー、お祝いプレートのご相談などご自由にご記入ください。 / Please let us know if you have any allergies or special requests."
                            class="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                        ></textarea>
                    </div>

                    <!-- 個人情報保護同意 -->
                    <div class="pt-2">
                        <label class="flex items-start gap-2.5 text-xs text-[#6b5a4d] cursor-pointer">
                            <input type="checkbox" required class="mt-0.5 rounded text-[#b54737] focus:ring-[#b54737]" />
                            <span id="privacy-agree-text">
                                当店のプライバシーポリシーに同意の上、送信します。 / I agree to the Privacy Policy for reservation management.
                            </span>
                        </label>
                    </div>

                    <!-- 送信ボタン -->
                    <div class="pt-4">
                        <button
                            type="submit"
                            id="submit-booking-btn"
                            class="w-full py-4 rounded-full bg-gradient-to-r from-[#e26d5c] to-[#b54737] text-white font-bold text-sm tracking-wider shadow hover:shadow-lg hover:opacity-95 transition flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <span id="submit-btn-spinner" class="hidden animate-spin">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                            </span>
                            <span id="submit-btn-text">空き枠で仮予約リクエストを送信する / Submit Request</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- サイド情報：お電話案内 ＆ よくある質問（FAQ） -->
            <div class="lg:col-span-5 space-y-8">
                <!-- お電話案内カード -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e7dac5] shadow-sm space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#fde2d9] text-[#e26d5c] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-serif text-lg font-bold text-[#392d23]" id="card-phone-title">お電話でのお問い合わせ</h3>
                            <span class="text-xs text-[#a48c6f]" id="card-phone-sub">当日の空席確認・お急ぎの場合 / Same-day Seating</span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-baseline gap-2">
                            <span class="text-2xl sm:text-3xl font-serif font-bold text-[#b54737] block" title="<?php echo esc_attr( hareka_get_shop_info( 'phone_note' ) ); ?>">
                                <?php echo esc_html( hareka_get_shop_info( 'phone' ) ); ?>
                            </span>
                        </div>
                        <p class="text-xs text-[#6b5a4d]" id="card-phone-hours">
                            受付時間：<?php echo esc_html( hareka_get_shop_info( 'phone_hours' ) ); ?>
                        </p>
                    </div>

                    <p class="text-xs text-[#6b5a4d] leading-relaxed pt-2 border-t border-[#f4eee3]" id="card-phone-notice">
                        ※ランチタイム（11:30〜13:30）の混雑時はお電話が繋がりにくい場合がございます。
                    </p>
                </div>

                <!-- よくある質問（FAQ）アコーディオン -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e7dac5] shadow-sm space-y-6">
                    <div class="space-y-1 border-b border-[#f4eee3] pb-3">
                        <h3 class="font-serif text-lg font-bold text-[#392d23]" id="faq-main-title">
                            よくあるご質問（FAQ）
                        </h3>
                        <p class="text-xs text-[#a48c6f]" id="faq-main-sub">
                            ご予約・ご来店に関して多くいただくご質問です。
                        </p>
                    </div>

                    <div class="space-y-3" id="faq-accordion-group">
                        <?php foreach ( $faq_items as $f_idx => $faq ) : ?>
                            <div class="border border-[#e7dac5] rounded-2xl overflow-hidden transition-all bg-[#faf7f2]/50">
                                <button
                                    type="button"
                                    class="w-full p-4 text-left font-serif text-xs sm:text-sm font-bold text-[#392d23] flex items-center justify-between gap-3 hover:bg-[#faf7f2] transition faq-trigger cursor-pointer"
                                    data-target="faq-ans-<?php echo esc_attr( $f_idx ); ?>"
                                >
                                    <span class="flex items-center gap-2">
                                        <span class="text-[#e26d5c]">Q.</span>
                                        <span class="faq-question-text" data-q-ja="<?php echo esc_attr( $faq['q_ja'] ); ?>" data-q-en="<?php echo esc_attr( $faq['q_en'] ); ?>">
                                            <?php echo esc_html( $faq['q_ja'] ); ?>
                                        </span>
                                    </span>
                                    <svg class="w-4 h-4 text-[#a48c6f] transform transition-transform duration-200 faq-icon shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </button>
                                <div id="faq-ans-<?php echo esc_attr( $f_idx ); ?>" class="hidden p-4 pt-0 text-xs text-[#6b5a4d] leading-relaxed border-t border-[#f4eee3]/60 bg-white">
                                    <p class="pt-3 faq-answer-text" data-a-ja="<?php echo esc_attr( $faq['a_ja'] ); ?>" data-a-en="<?php echo esc_attr( $faq['a_en'] ); ?>">
                                        <?php echo esc_html( $faq['a_ja'] ); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
get_footer();
