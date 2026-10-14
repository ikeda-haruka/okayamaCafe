<?php
/**
 * Template Name: ご予約・お問い合わせ (Contact & Reservation)
 * Description: 空き枠判別・満席誤予約防止・仮予約制フロー対応のお問い合わせテンプレート
 *
 * @package hareka-theme
 */

get_header();

// FAQ データ
$faq_items = array(
    array(
        'q' => '予約はいつから受け付けていますか？',
        'a' => 'ご来店希望日の30日前から、前日の17:00までこちらのWebフォームより受け付けております。当日のご予約や空席確認につきましては、お電話（086-234-5678）にて直接お問い合わせください。',
    ),
    array(
        'q' => '満席の時間帯は予約できませんか？',
        'a' => 'はい。当店では確実なお席の確保とスムーズなご案内のため、予約枠が上限に達した時間帯（✕表示）はフォームからの受付を自動停止しております。◎または△の空き枠をお選びいただくか、別のお日にちをご検討ください。',
    ),
    array(
        'q' => '「仮予約」とはどういう状態ですか？',
        'a' => 'Webフォームからの送信時点では「仮受付」となります。店舗スタッフが内容を確認し、24時間以内に「【CAFE HAREKA】ご予約確定メール」をお送りした時点で正式な確定となります。',
    ),
    array(
        'q' => '席のみの予約で、来店時にメニューを選べますか？',
        'a' => 'はい、可能です。お席のみをご予約いただき、当日店頭にて旬のパフェやランチプレートをご自由にご注文いただけます。ただし、数量限定メニュー（パフェ等）は完売となる場合がございます。',
    ),
    array(
        'q' => 'ペット連れで利用できますか？',
        'a' => 'はい、ガーデンテラス席（全14席）はリードを着用の上、ペットご同伴でご利用いただけます。雨天時や強風時はテラス席のご利用を制限させていただく場合がございます。',
    ),
    array(
        'q' => '駐車場はありますか？ 大型車やバスは可能ですか？',
        'a' => '店舗敷地内に無料駐車場20台（普通車・軽自動車）を完備しております。また、マイクロバス等でのご来店をご希望の場合は、事前にご相談ください。',
    ),
);
?>

<div class="space-y-16 sm:space-y-24 pb-20">
    <!-- ページヘッダー -->
    <section class="relative bg-gradient-to-b from-[#fde2d9]/60 via-[#faf7f2] to-[#e2f0d9]/60 py-16 sm:py-24 border-b border-[#e7dac5]">
        <div class="max-w-4xl mx-auto px-4 text-center space-y-4">
            <span class="inline-block text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
                RESERVATION & CONTACT
            </span>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold text-[#392d23] leading-tight">
                ご予約・お問い合わせ
            </h1>
            <div class="w-16 h-1 bg-[#e26d5c] mx-auto rounded-full"></div>
            <p class="text-xs sm:text-sm text-[#6b5a4d] max-w-2xl mx-auto leading-relaxed pt-2">
                お席の事前予約リクエストや、果物の入荷確認、団体・取材のお問い合わせなど、お気軽にご連絡ください。<br class="hidden sm:inline" />
                空き状況のリアルタイム確認が可能です。
            </p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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

                    <div id="booking-provisional-notice" class="bg-[#fef2ee] border border-[#fbc6b6] rounded-2xl p-4 text-left max-w-md mx-auto space-y-3 text-xs text-[#574636]">
                        <div class="flex items-center gap-2 font-bold text-[#b54737] border-b border-[#fbc6b6]/60 pb-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                            <span>現時点では【仮予約】の状態です</span>
                        </div>
                        <ul class="space-y-1.5 list-disc list-inside text-[#6b5a4d]">
                            <li>店舗スタッフが空席台帳を確認後、<strong>24時間以内に「確定メール」</strong>をお送りします。</li>
                            <li>確定メールの受信をもって、本予約の成立となります。</li>
                            <li>万が一満席等でお席のご用意が難しい場合は、お電話またはメールにて代替時間帯をご提案いたします。</li>
                        </ul>
                    </div>

                    <p class="text-xs text-[#6b5a4d] max-w-md mx-auto leading-relaxed">
                        ご入力いただいたメールアドレス宛に自動返信メールを送信いたしました。メールが届かない場合は、迷惑メールフォルダをご確認いただくか、店舗（086-234-5678）までお電話ください。
                    </p>

                    <div class="pt-4">
                        <button
                            type="button"
                            id="reset-form-btn"
                            class="px-6 py-2.5 rounded-full border border-[#d8c8b2] text-xs font-semibold text-[#574636] hover:bg-[#faf7f2] transition"
                        >
                            別の内容で送信する
                        </button>
                    </div>
                </div>

                <!-- 送信フォーム本体 -->
                <form id="contact-booking-form" class="space-y-6">
                    <div class="space-y-1 border-b border-[#f4eee3] pb-4">
                        <h2 class="font-serif text-xl sm:text-2xl font-bold text-[#392d23]">
                            お問い合わせ・席予約フォーム
                        </h2>
                        <p class="text-xs text-[#a48c6f]">
                            必須項目をご入力の上、送信してください。
                        </p>
                    </div>

                    <!-- お問い合わせ種別 -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-[#392d23]">
                            お問い合わせ種別 <span class="text-[#e26d5c]">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <label class="flex items-center gap-2 p-3 rounded-2xl border border-[#e7dac5] hover:border-[#b54737] cursor-pointer text-xs font-medium has-[:checked]:bg-[#fef2ee] has-[:checked]:border-[#b54737] has-[:checked]:text-[#b54737]">
                                <input type="radio" name="inquiry_type" value="席のご予約" checked class="text-[#b54737] focus:ring-[#b54737]" />
                                <span>席のご予約（仮予約）</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 rounded-2xl border border-[#e7dac5] hover:border-[#b54737] cursor-pointer text-xs font-medium has-[:checked]:bg-[#fef2ee] has-[:checked]:border-[#b54737] has-[:checked]:text-[#b54737]">
                                <input type="radio" name="inquiry_type" value="取材・貸切のご相談" class="text-[#b54737] focus:ring-[#b54737]" />
                                <span>取材・貸切のご相談</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 rounded-2xl border border-[#e7dac5] hover:border-[#b54737] cursor-pointer text-xs font-medium has-[:checked]:bg-[#fef2ee] has-[:checked]:border-[#b54737] has-[:checked]:text-[#b54737]">
                                <input type="radio" name="inquiry_type" value="果物・ギフトに関するお問い合わせ" class="text-[#b54737] focus:ring-[#b54737]" />
                                <span>商品・その他</span>
                            </label>
                        </div>
                    </div>

                    <!-- 席予約専用フィールドグループ -->
                    <div id="reservation-fields" class="space-y-5 bg-[#faf7f2] p-5 sm:p-6 rounded-2xl border border-[#e7dac5]">
                        <div class="flex items-center justify-between border-b border-[#ebdcc9] pb-3">
                            <h3 class="font-serif text-sm font-bold text-[#392d23] flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#e26d5c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <span>席予約詳細・空き状況選択</span>
                            </h3>
                            <span class="text-[11px] text-[#4a8235] font-semibold bg-white px-2.5 py-0.5 rounded-full border border-[#d2e3c7]">
                                満席誤予約防止機能 ON
                            </span>
                        </div>

                        <!-- 予約希望日 & 人数 -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="reserve-date" class="block text-xs font-bold text-[#392d23] mb-1.5">
                                    ご来店希望日 <span class="text-[#e26d5c]">*</span>
                                </label>
                                <input
                                    type="date"
                                    id="reserve-date"
                                    name="reserve_date"
                                    required
                                    class="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                                />
                                <span class="text-[11px] text-[#a48c6f] mt-1 block">※毎週水曜日は定休日です</span>
                            </div>

                            <div>
                                <label for="reserve-guests" class="block text-xs font-bold text-[#392d23] mb-1.5">
                                    ご利用人数 <span class="text-[#e26d5c]">*</span>
                                </label>
                                <select
                                    id="reserve-guests"
                                    name="reserve_guests"
                                    class="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                                >
                                    <option value="1">1名様（カウンターまたはテーブル）</option>
                                    <option value="2" selected>2名様</option>
                                    <option value="3">3名様</option>
                                    <option value="4">4名様</option>
                                    <option value="5">5名様</option>
                                    <option value="6">6名様以上（要相談）</option>
                                </select>
                            </div>
                        </div>

                        <!-- 水曜定休日警告アラート -->
                        <div id="wednesday-alert" class="hidden p-3.5 rounded-xl bg-[#fff3cd] border border-[#ffeeba] text-xs text-[#856404] flex items-start gap-2">
                            <svg class="w-4 h-4 text-[#856404] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                            <span><strong>水曜日は定休日です。</strong> 水曜日以外の日程をご選択ください。（祝日の場合は営業・翌木曜休）</span>
                        </div>

                        <!-- 時間帯別空き枠セレクター -->
                        <div id="timeslot-container" class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-bold text-[#392d23]">
                                    ご来店時間枠の選択 <span class="text-[#e26d5c]">*</span>
                                </label>
                                <div class="flex items-center gap-3 text-[11px] text-[#6b5a4d]">
                                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-[#4a8235]"></span>◎ 余裕あり</span>
                                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-[#d97706]"></span>△ 残りわずか</span>
                                    <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-[#9ca3af]"></span>✕ 満席不可</span>
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
                                ご希望の座席タイプ
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <label class="flex items-center gap-2 p-3 rounded-xl border border-[#d8c8b2] bg-white cursor-pointer text-xs has-[:checked]:border-[#b54737] has-[:checked]:bg-[#fef2ee]">
                                    <input type="radio" name="seat_type" value="店内テーブル席" checked class="text-[#b54737]" />
                                    <span>店内テーブル席（落ち着いた空間）</span>
                                </label>
                                <label class="flex items-center gap-2 p-3 rounded-xl border border-[#d8c8b2] bg-white cursor-pointer text-xs has-[:checked]:border-[#b54737] has-[:checked]:bg-[#fef2ee]">
                                    <input type="radio" name="seat_type" value="ガーデンテラス席" class="text-[#b54737]" />
                                    <span>ガーデンテラス席（ペット可・開放感）</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- お客様基本情報 -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="user-name" class="block text-xs font-bold text-[#392d23] mb-1.5">
                                お名前 <span class="text-[#e26d5c]">*</span>
                            </label>
                            <input
                                type="text"
                                id="user-name"
                                name="user_name"
                                required
                                placeholder="例：晴果 太郎"
                                class="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                            />
                        </div>

                        <div>
                            <label for="user-kana" class="block text-xs font-bold text-[#392d23] mb-1.5">
                                フリガナ <span class="text-[#e26d5c]">*</span>
                            </label>
                            <input
                                type="text"
                                id="user-kana"
                                name="user_kana"
                                required
                                placeholder="例：ハレカ タロウ"
                                class="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="user-email" class="block text-xs font-bold text-[#392d23] mb-1.5">
                                メールアドレス <span class="text-[#e26d5c]">*</span>
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
                                お電話番号 <span class="text-[#e26d5c]">*</span>
                            </label>
                            <input
                                type="tel"
                                id="user-phone"
                                name="user_phone"
                                required
                                placeholder="090-1234-5678"
                                class="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                            />
                        </div>
                    </div>

                    <!-- メモ・ご要望 -->
                    <div>
                        <label for="user-message" class="block text-xs font-bold text-[#392d23] mb-1.5">
                            ご要望・メッセージ（アレルギー、車椅子、記念日利用など）
                        </label>
                        <textarea
                            id="user-message"
                            name="user_message"
                            rows="4"
                            placeholder="お子様連れ、アレルギー食材、バースデープレートのご相談などご自由にご記入ください。"
                            class="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                        ></textarea>
                    </div>

                    <!-- 個人情報保護同意 -->
                    <div class="pt-2">
                        <label class="flex items-start gap-2.5 text-xs text-[#6b5a4d] cursor-pointer">
                            <input type="checkbox" required class="mt-0.5 rounded text-[#b54737] focus:ring-[#b54737]" />
                            <span>当店のプライバシーポリシーに同意の上、送信します。ご入力いただいた情報はご連絡・予約管理のみに使用いたします。</span>
                        </label>
                    </div>

                    <!-- 送信ボタン -->
                    <div class="pt-4">
                        <button
                            type="submit"
                            id="submit-booking-btn"
                            class="w-full py-4 rounded-full bg-gradient-to-r from-[#e26d5c] to-[#b54737] text-white font-bold text-sm tracking-wider shadow hover:shadow-lg hover:opacity-95 transition flex items-center justify-center gap-2"
                        >
                            <span id="submit-btn-spinner" class="hidden animate-spin">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                            </span>
                            <span id="submit-btn-text">空き枠で仮予約リクエストを送信する</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- サイド情報：お電話案内 ＆ よくある質問 -->
            <div class="lg:col-span-5 space-y-8">
                <!-- お電話案内カード -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e7dac5] shadow-sm space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#fde2d9] text-[#e26d5c] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-serif text-lg font-bold text-[#392d23]">お電話でのお問い合わせ</h3>
                            <span class="text-xs text-[#a48c6f]">当日の空席確認・お急ぎの場合</span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <a href="tel:086-234-5678" class="text-2xl sm:text-3xl font-serif font-bold text-[#b54737] hover:underline block">
                            086-234-5678
                        </a>
                        <p class="text-xs text-[#6b5a4d]">
                            受付時間：10:00 〜 18:00（毎週水曜・定休除く）
                        </p>
                    </div>

                    <p class="text-xs text-[#6b5a4d] leading-relaxed pt-2 border-t border-[#f4eee3]">
                        ※ランチタイム（11:30〜13:30）の混雑時はお電話が繋がりにくい場合がございます。あらかじめご了承ください。
                    </p>
                </div>

                <!-- よくある質問（FAQ）アコーディオン -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e7dac5] shadow-sm space-y-6">
                    <div class="space-y-1 border-b border-[#f4eee3] pb-3">
                        <h3 class="font-serif text-lg font-bold text-[#392d23]">
                            よくあるご質問（FAQ）
                        </h3>
                        <p class="text-xs text-[#a48c6f]">
                            ご予約・ご来店に関して多くいただくご質問です。
                        </p>
                    </div>

                    <div class="space-y-3" id="faq-accordion-group">
                        <?php foreach ( $faq_items as $f_idx => $faq ) : ?>
                            <div class="border border-[#e7dac5] rounded-2xl overflow-hidden transition-all bg-[#faf7f2]/50">
                                <button
                                    type="button"
                                    class="w-full p-4 text-left font-serif text-xs sm:text-sm font-bold text-[#392d23] flex items-center justify-between gap-3 hover:bg-[#faf7f2] transition faq-trigger"
                                    data-target="faq-ans-<?php echo esc_attr( $f_idx ); ?>"
                                >
                                    <span class="flex items-center gap-2">
                                        <span class="text-[#e26d5c]">Q.</span>
                                        <span><?php echo esc_html( $faq['q'] ); ?></span>
                                    </span>
                                    <svg class="w-4 h-4 text-[#a48c6f] transform transition-transform duration-200 faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </button>
                                <div id="faq-ans-<?php echo esc_attr( $f_idx ); ?>" class="hidden p-4 pt-0 text-xs text-[#6b5a4d] leading-relaxed border-t border-[#f4eee3]/60 bg-white">
                                    <p class="pt-3"><?php echo esc_html( $faq['a'] ); ?></p>
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
