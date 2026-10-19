/**
 * CAFE HAREKA - WordPress Theme Main JavaScript
 * 
 * Features:
 * 1. Mobile Menu Drawer
 * 2. Menu Category Tabs Filter
 * 3. FAQ Accordion Toggle
 * 4. Contact/Reservation Form with Live Time Slot Availability & Provisional Flow
 */

document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    /* ==========================================================================
       1. Mobile Menu Drawer & Header Scroll Motion (Navbar.tsx 互換)
       ========================================================================== */
    const mobileMenuBtn = document.getElementById('mobile-menu-toggle') || document.getElementById('mobile-menu-btn');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
    const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');
    const siteHeader = document.querySelector('header');

    // スクロール時のヘッダー縮小＆ブラー演出
    function handleHeaderScroll() {
        if (!siteHeader) return;
        if (window.scrollY > 20) {
            siteHeader.classList.add('bg-[#faf7f2]/95', 'backdrop-blur-md', 'py-3', 'shadow-sm');
            siteHeader.classList.remove('py-3.5', 'py-4');
        } else {
            siteHeader.classList.remove('py-3', 'shadow-sm');
            siteHeader.classList.add('py-3.5');
        }
    }
    window.addEventListener('scroll', handleHeaderScroll, { passive: true });
    handleHeaderScroll();

    function toggleMobileMenu() {
        if (!mobileMenuDrawer) return;
        const isHidden = mobileMenuDrawer.classList.contains('hidden');
        if (isHidden) {
            mobileMenuDrawer.classList.remove('hidden');
            mobileMenuDrawer.style.opacity = '0';
            mobileMenuDrawer.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                mobileMenuDrawer.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                mobileMenuDrawer.style.opacity = '1';
                mobileMenuDrawer.style.transform = 'translateY(0)';
            }, 10);
            if (mobileMenuBackdrop) mobileMenuBackdrop.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            mobileMenuDrawer.style.opacity = '0';
            mobileMenuDrawer.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                mobileMenuDrawer.classList.add('hidden');
                document.body.style.overflow = '';
            }, 250);
            if (mobileMenuBackdrop) mobileMenuBackdrop.classList.add('hidden');
        }
    }

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', toggleMobileMenu);
    }
    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', toggleMobileMenu);
    }
    if (mobileMenuBackdrop) {
        mobileMenuBackdrop.addEventListener('click', toggleMobileMenu);
    }

    /* ==========================================================================
       2. Menu Category Tabs Filter (page-menu.php)
       ========================================================================== */
    const tabButtons = document.querySelectorAll('.menu-tab-btn');
    const menuCards = document.querySelectorAll('.menu-card');

    if (tabButtons.length > 0 && menuCards.length > 0) {
        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetCategory = this.getAttribute('data-category');

                // タブボタンスタイルの更新
                tabButtons.forEach(btn => {
                    btn.classList.remove('active', 'bg-[#392d23]', 'text-white', 'shadow-md');
                    btn.classList.add('bg-white', 'text-[#574636]', 'border', 'border-[#e7dac5]');
                });
                this.classList.add('active', 'bg-[#392d23]', 'text-white', 'shadow-md');
                this.classList.remove('bg-white', 'text-[#574636]', 'border', 'border-[#e7dac5]');

                // カードのフィルタリング表示
                menuCards.forEach(card => {
                    const rawCats = (card.getAttribute('data-categories') || card.getAttribute('data-category') || '');
                    const cardCats = rawCats.split(/\s+/).filter(Boolean);

                    let isMatch = false;
                    if (targetCategory === 'all') {
                        isMatch = true;
                    } else if (cardCats.includes(targetCategory)) {
                        isMatch = true;
                    } else if (targetCategory === 'sweets' && (cardCats.includes('旬果スイーツ') || cardCats.includes('sweet'))) {
                        isMatch = true;
                    } else if (targetCategory === 'lunch' && (cardCats.includes('ランチ・軽食') || cardCats.includes('ランチ'))) {
                        isMatch = true;
                    } else if (targetCategory === 'drinks' && (cardCats.includes('drink') || cardCats.includes('ドリンク'))) {
                        isMatch = true;
                    } else if (targetCategory === 'takeout' && (cardCats.includes('テイクアウト') || cardCats.includes('テイクアウト・ギフト') || cardCats.includes('ギフト'))) {
                        isMatch = true;
                    }

                    if (isMatch) {
                        card.style.display = '';
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(8px)';
                        setTimeout(() => {
                            card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 20);
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }

    /* ==========================================================================
       3. FAQ Accordion (page-contact.php)
       ========================================================================== */
    const faqTriggers = document.querySelectorAll('.faq-trigger');

    if (faqTriggers.length > 0) {
        faqTriggers.forEach(trigger => {
            trigger.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const answerEl = document.getElementById(targetId);
                const icon = this.querySelector('.faq-icon');

                if (!answerEl) return;

                const isHidden = answerEl.classList.contains('hidden');

                // 他のアコーディオンを閉じる（1つだけ開く上品な仕様）
                document.querySelectorAll('[id^="faq-ans-"]').forEach(el => el.classList.add('hidden'));
                document.querySelectorAll('.faq-icon').forEach(ic => ic.classList.remove('rotate-180'));

                if (isHidden) {
                    answerEl.classList.remove('hidden');
                    if (icon) icon.classList.add('rotate-180');
                }
            });
        });
    }

    /* ==========================================================================
       4. Contact & Reservation Form Logic (page-contact.php)
       ========================================================================== */
    const dateInput = document.getElementById('reserve-date');
    const slotsGrid = document.getElementById('slots-grid');
    const selectedTimeInput = document.getElementById('selected-time-input');
    const wednesdayAlert = document.getElementById('wednesday-alert');
    const contactForm = document.getElementById('contact-booking-form');
    const completeBox = document.getElementById('booking-complete-box');
    const refBadge = document.getElementById('booking-ref-badge');
    const completeTitle = document.getElementById('booking-complete-title');
    const provisionalNotice = document.getElementById('booking-provisional-notice');
    const resetBtn = document.getElementById('reset-form-btn');
    const submitBtn = document.getElementById('submit-booking-btn');
    const submitSpinner = document.getElementById('submit-btn-spinner');
    const submitText = document.getElementById('submit-btn-text');
    const inquiryTypeRadios = document.querySelectorAll('input[name="inquiry_type"]');
    const reservationFields = document.getElementById('reservation-fields');

    // 多言語切り替え関連のDOM要素
    const langBtnJa = document.getElementById('lang-btn-ja');
    const langBtnEn = document.getElementById('lang-btn-en');
    let currentLang = 'ja';

    const pageMainTitle = document.getElementById('page-main-title');
    const pageMainDesc = document.getElementById('page-main-desc');
    const formHeadingTitle = document.getElementById('form-heading-title');
    const formHeadingDesc = document.getElementById('form-heading-desc');
    const safeBadgeText = document.getElementById('safe-badge-text');
    const privacyAgreeText = document.getElementById('privacy-agree-text');
    const faqMainTitle = document.getElementById('faq-main-title');
    const faqMainSub = document.getElementById('faq-main-sub');
    const cardPhoneTitle = document.getElementById('card-phone-title');
    const cardPhoneSub = document.getElementById('card-phone-sub');
    const cardPhoneHours = document.getElementById('card-phone-hours');
    const cardPhoneNotice = document.getElementById('card-phone-notice');
    const bookingProvisionalHeading = document.getElementById('booking-provisional-heading');
    const bookingProvisionalText = document.getElementById('booking-provisional-text');
    const bookingCompleteDesc = document.getElementById('booking-complete-desc');

    function updateLanguageUI(lang) {
        currentLang = lang;

        // ボタンのアクティブ状態切り替え
        if (lang === 'ja') {
            if (langBtnJa) {
                langBtnJa.className = 'lang-toggle-btn active px-3.5 py-1.5 rounded-xl text-xs font-bold bg-[#392d23] text-white transition-all shadow-sm cursor-pointer';
            }
            if (langBtnEn) {
                langBtnEn.className = 'lang-toggle-btn px-3.5 py-1.5 rounded-xl text-xs font-bold text-[#574636] hover:bg-[#faf7f2] transition-all cursor-pointer';
            }
        } else {
            if (langBtnEn) {
                langBtnEn.className = 'lang-toggle-btn active px-3.5 py-1.5 rounded-xl text-xs font-bold bg-[#392d23] text-white transition-all shadow-sm cursor-pointer';
            }
            if (langBtnJa) {
                langBtnJa.className = 'lang-toggle-btn px-3.5 py-1.5 rounded-xl text-xs font-bold text-[#574636] hover:bg-[#faf7f2] transition-all cursor-pointer';
            }
        }

        // ページヘッダー文言
        if (pageMainTitle) {
            pageMainTitle.textContent = lang === 'ja' ? 'ご予約・お問い合わせ' : 'Reservation & Inquiry';
        }
        if (pageMainDesc) {
            pageMainDesc.innerHTML = lang === 'ja'
                ? 'お席の事前予約リクエストや、果物の入荷確認、団体・取材のお問い合わせなど、お気軽にご連絡ください。<br class="hidden sm:inline" />空き状況のリアルタイム確認が可能です。'
                : 'Feel free to request advance table reservations, check fruit arrivals, or make private party and media inquiries.<br class="hidden sm:inline" />Real-time seat availability is available below.';
        }

        // フォーム見出し
        if (formHeadingTitle) {
            formHeadingTitle.textContent = lang === 'ja' ? 'お問い合わせ・席予約フォーム' : 'Reservation & Contact Form';
        }
        if (formHeadingDesc) {
            formHeadingDesc.textContent = lang === 'ja' ? '必須項目をご入力の上、送信してください。' : 'Please fill in the required fields and submit your request.';
        }

        // 誤予約防止バッジ
        if (safeBadgeText) {
            safeBadgeText.textContent = lang === 'ja' ? '満席誤予約防止機能 ON' : 'Live Availability Active';
        }

        // プライバシー同意文
        if (privacyAgreeText) {
            privacyAgreeText.textContent = lang === 'ja'
                ? '当店のプライバシーポリシーに同意の上、送信します。'
                : 'I agree to the Privacy Policy for reservation handling.';
        }

        // 送信ボタン文言
        updateSubmitButtonText();

        // 凡例（Legend）
        const legendAvail = document.querySelector('.legend-avail');
        const legendFew = document.querySelector('.legend-few');
        const legendFull = document.querySelector('.legend-full');
        if (legendAvail) legendAvail.textContent = lang === 'ja' ? '◎ 余裕あり' : '◎ Available';
        if (legendFew) legendFew.textContent = lang === 'ja' ? '△ 残少' : '△ Few Left';
        if (legendFull) legendFull.textContent = lang === 'ja' ? '✕ 満席' : '✕ Full';

        // お電話案内カード
        if (cardPhoneTitle) cardPhoneTitle.textContent = lang === 'ja' ? 'お電話でのお問い合わせ' : 'Phone Inquiry';
        const currentPhoneHours = (window.harekaThemeData && window.harekaThemeData.shopInfo && window.harekaThemeData.shopInfo.phone_hours)
            ? window.harekaThemeData.shopInfo.phone_hours
            : '10:00 〜 18:00（毎週水曜・定休除く）';
        if (cardPhoneHours) cardPhoneHours.textContent = lang === 'ja' ? `受付時間：${currentPhoneHours}` : `Hours: ${currentPhoneHours}`;
        if (cardPhoneNotice) cardPhoneNotice.textContent = lang === 'ja'
            ? '※ランチタイム（11:30〜13:30）の混雑時はお電話が繋がりにくい場合がございます。'
            : '* Phone lines may be busy during peak lunch hours (11:30 - 13:30).';

        // よくある質問（FAQ）
        if (faqMainTitle) faqMainTitle.textContent = lang === 'ja' ? 'よくあるご質問（FAQ）' : 'Frequently Asked Questions (FAQ)';
        if (faqMainSub) faqMainSub.textContent = lang === 'ja' ? 'ご予約・ご来店に関して多くいただくご質問です。' : 'Helpful information regarding reservations, parking, and dining.';

        document.querySelectorAll('.faq-question-text').forEach(el => {
            el.textContent = lang === 'ja' ? el.getAttribute('data-q-ja') : el.getAttribute('data-q-en');
        });
        document.querySelectorAll('.faq-answer-text').forEach(el => {
            el.textContent = lang === 'ja' ? el.getAttribute('data-a-ja') : el.getAttribute('data-a-en');
        });

        // 完了画面テキストの更新
        if (bookingProvisionalHeading) {
            bookingProvisionalHeading.textContent = lang === 'ja' ? '現時点では【仮予約】の状態です' : 'Your booking is currently PROVISIONAL';
        }
        if (bookingProvisionalText) {
            bookingProvisionalText.textContent = lang === 'ja'
                ? '店舗スタッフが配席状況を確認の上、24時間以内に「ご予約確定メール」をお送りいたします。確定メールの受信をもってご予約成立となります。'
                : 'Our cafe team will check table assignments and send you a confirmation email within 24 hours to finalize your reservation.';
        }
        if (bookingCompleteDesc) {
            bookingCompleteDesc.textContent = lang === 'ja'
                ? 'ご入力いただいたメールアドレス宛に自動返信メールを送信いたしました。メールが届かない場合は、迷惑メールフォルダをご確認いただくか、店舗（086-XXXX-XXX ※架空番号）までお問い合わせください。'
                : 'An automated confirmation email has been sent to your inbox. If you do not receive it, please check your spam folder or contact us at 086-XXXX-XXX (*dummy number).';
        }

        // スロット再描画
        if (dateInput && slotsGrid && typeof renderTimeSlots === 'function') {
            renderTimeSlots(dateInput.value);
        }
    }

    function updateSubmitButtonText() {
        if (!submitText) return;
        const inquiryType = document.querySelector('input[name="inquiry_type"]:checked')?.value || '席のご予約';
        if (inquiryType === '席のご予約') {
            submitText.textContent = currentLang === 'ja'
                ? '空き枠で仮予約リクエストを送信する'
                : 'Submit Provisional Reservation Request';
        } else {
            submitText.textContent = currentLang === 'ja'
                ? 'お問い合わせを送信する'
                : 'Submit Inquiry';
        }
    }

    if (langBtnJa) {
        langBtnJa.addEventListener('click', () => updateLanguageUI('ja'));
    }
    if (langBtnEn) {
        langBtnEn.addEventListener('click', () => updateLanguageUI('en'));
    }

    if (dateInput && slotsGrid) {
        // 1) 明日の日付をデフォルト設定し、min属性に今日を設定
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);

        const formatDate = d => {
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };

        const todayStr = formatDate(today);
        const tomorrowStr = formatDate(tomorrow);

        dateInput.min = tomorrowStr;
        if (!dateInput.value) {
            dateInput.value = tomorrowStr;
        }

        // 2) スロット生成関数（空き状況シミュレーション・多言語対応）
        function renderTimeSlots(dateVal) {
            slotsGrid.innerHTML = '';
            if (!dateVal) return;

            const selectedDate = new Date(dateVal);
            const dayOfWeek = selectedDate.getDay();
            const shopClosedNum = (window.harekaThemeData && window.harekaThemeData.shopInfo && window.harekaThemeData.shopInfo.closed_day_num !== undefined)
                ? parseInt(window.harekaThemeData.shopInfo.closed_day_num, 10)
                : 3;
            const closedDayShort = (window.harekaThemeData && window.harekaThemeData.shopInfo && window.harekaThemeData.shopInfo.closed_day_short)
                ? window.harekaThemeData.shopInfo.closed_day_short
                : '定休日';

            if (shopClosedNum >= 0 && dayOfWeek === shopClosedNum) {
                // 定休日のためスロット自動ロック
                if (wednesdayAlert) wednesdayAlert.classList.remove('hidden');
                const closedMsg = currentLang === 'ja'
                    ? `${closedDayShort}のため時間枠は選択できません`
                    : 'Closed today. Slots unavailable.';
                slotsGrid.innerHTML = `<div class="col-span-full py-4 text-center text-xs text-[#a48c6f] bg-white rounded-xl border border-[#e7dac5]">${closedMsg}</div>`;
                return;
            } else {
                if (wednesdayAlert) wednesdayAlert.classList.add('hidden');
            }

            const baseTimes = ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
            const dateNum = selectedDate.getDate();
            let currentSelected = selectedTimeInput ? selectedTimeInput.value : '11:00';
            let validSelectedFound = false;

            baseTimes.forEach((time, idx) => {
                const hash = (dateNum + idx * 7) % 10;
                let status = 'available'; // 'available' | 'few' | 'full'
                let badgeText = currentLang === 'ja' ? '◎ 余裕あり' : '◎ Available';
                let badgeColor = 'text-[#4a8235] bg-[#eaf4e6]';

                // ピーク時や決定論的パターンで満席/残少を算出
                if (time === '12:00' || (time === '13:00' && hash > 4) || hash === 3) {
                    status = 'full';
                    badgeText = currentLang === 'ja' ? '✕ 満席' : '✕ Fully Booked';
                    badgeColor = 'text-[#9ca3af] bg-[#f3f4f6]';
                } else if (hash === 2 || hash === 6) {
                    status = 'few';
                    badgeText = currentLang === 'ja' ? '△ 残少' : '△ Few Left';
                    badgeColor = 'text-[#d97706] bg-[#fef3c7]';
                }

                const isFull = status === 'full';
                const isSelected = (!isFull && time === currentSelected);
                if (isSelected) validSelectedFound = true;

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = `p-3 rounded-xl border text-left transition relative flex flex-col justify-between ${
                    isFull
                        ? 'opacity-40 bg-[#f8f9fa] border-gray-200 cursor-not-allowed text-gray-400'
                        : isSelected
                        ? 'border-[#b54737] bg-[#fef2ee] ring-2 ring-[#b54737]'
                        : 'border-[#e7dac5] bg-white hover:border-[#b54737]/60'
                }`;

                if (isFull) {
                    btn.disabled = true;
                } else {
                    btn.addEventListener('click', function () {
                        if (selectedTimeInput) selectedTimeInput.value = time;
                        renderTimeSlots(dateInput.value);
                    });
                }

                btn.innerHTML = `
                    <div class="flex items-center justify-between">
                        <span class="font-serif text-sm font-bold ${isFull ? 'text-gray-400' : 'text-[#392d23]'}">${time}</span>
                        ${isSelected ? '<span class="w-2 h-2 rounded-full bg-[#b54737]"></span>' : ''}
                    </div>
                    <div class="mt-2 text-[10px] font-bold px-1.5 py-0.5 rounded text-center ${badgeColor}">
                        ${badgeText}
                    </div>
                `;

                slotsGrid.appendChild(btn);
            });

            // 以前選択されていた時間が満席になった場合、最初の選択可能枠を選択
            if (!validSelectedFound) {
                const firstAvailable = baseTimes.find((time, idx) => {
                    const hash = (dateNum + idx * 7) % 10;
                    return !(time === '12:00' || (time === '13:00' && hash > 4) || hash === 3);
                });
                if (firstAvailable && selectedTimeInput) {
                    selectedTimeInput.value = firstAvailable;
                }
            }
        }

        // 日付変更イベント
        dateInput.addEventListener('change', function () {
            renderTimeSlots(this.value);
        });

        // 初回レンダリング
        renderTimeSlots(dateInput.value);
    }

    // 3) お問い合わせ種別切り替えによる予約詳細フィールドの表示・非表示
    if (inquiryTypeRadios.length > 0 && reservationFields) {
        inquiryTypeRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.value === '席のご予約') {
                    reservationFields.classList.remove('hidden');
                } else {
                    reservationFields.classList.add('hidden');
                }
                updateSubmitButtonText();
            });
        });
    }

    // 4) フォーム送信ハンドラ
    if (contactForm && completeBox) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const inquiryType = document.querySelector('input[name="inquiry_type"]:checked')?.value || '席のご予約';

            if (inquiryType === '席のご予約' && dateInput) {
                const selectedDate = new Date(dateInput.value);
                const shopClosedNum = (window.harekaThemeData && window.harekaThemeData.shopInfo && window.harekaThemeData.shopInfo.closed_day_num !== undefined)
                    ? parseInt(window.harekaThemeData.shopInfo.closed_day_num, 10)
                    : 3;
                const closedDayShort = (window.harekaThemeData && window.harekaThemeData.shopInfo && window.harekaThemeData.shopInfo.closed_day_short)
                    ? window.harekaThemeData.shopInfo.closed_day_short
                    : '定休日';

                if (shopClosedNum >= 0 && selectedDate.getDay() === shopClosedNum) {
                    alert(currentLang === 'ja'
                        ? `${closedDayShort}は定休日のためご予約いただけません。別の日程をお選びください。`
                        : `We are closed on ${closedDayShort}. Please choose another date.`);
                    return;
                }
            }

            // エラー表示をクリア
            const errorAlert = document.getElementById('booking-error-alert');
            const errorMsg = document.getElementById('booking-error-msg');
            if (errorAlert) errorAlert.classList.add('hidden');

            // 送信ローディング表示
            if (submitSpinner) submitSpinner.classList.remove('hidden');
            if (submitBtn) submitBtn.disabled = true;

            const ajaxUrl = (window.harekaThemeData && window.harekaThemeData.ajaxUrl)
                ? window.harekaThemeData.ajaxUrl
                : '/wp-admin/admin-ajax.php';

            const formData = new FormData(contactForm);
            formData.append('action', 'hareka_submit_booking');
            if (window.harekaThemeData && window.harekaThemeData.contactNonce && !formData.get('hareka_contact_nonce')) {
                formData.append('nonce', window.harekaThemeData.contactNonce);
            }

            fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (submitSpinner) submitSpinner.classList.add('hidden');
                if (submitBtn) submitBtn.disabled = false;

                if (data && data.success) {
                    const bookingRef = data.data && data.data.booking_ref ? data.data.booking_ref : 'HRK-SUCCESS';

                    contactForm.classList.add('hidden');
                    completeBox.classList.remove('hidden');

                    if (refBadge) {
                        refBadge.textContent = currentLang === 'ja' ? `受付番号: ${bookingRef}` : `Booking Ref: ${bookingRef}`;
                    }

                    if (inquiryType === '席のご予約') {
                        if (completeTitle) {
                            completeTitle.textContent = currentLang === 'ja'
                                ? 'ご予約リクエスト（仮予約）を受け付けました'
                                : 'Reservation Request Received (Provisional)';
                        }
                        if (provisionalNotice) provisionalNotice.classList.remove('hidden');
                    } else {
                        if (completeTitle) {
                            completeTitle.textContent = currentLang === 'ja'
                                ? 'お問い合わせを送信いたしました'
                                : 'Inquiry Submitted Successfully';
                        }
                        if (provisionalNotice) provisionalNotice.classList.add('hidden');
                    }

                    // スムーズスクロール
                    completeBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    const msg = (data && data.data && data.data.message)
                        ? data.data.message
                        : (currentLang === 'ja' ? '送信に失敗しました。時間をおいて再度お試しいただくか、お電話にてお問い合わせください。' : 'Failed to submit. Please try again later or contact us by phone.');
                    if (errorAlert && errorMsg) {
                        errorMsg.textContent = msg;
                        errorAlert.classList.remove('hidden');
                        errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        alert(msg);
                    }
                }
            })
            .catch(err => {
                console.error('Submit error:', err);
                if (submitSpinner) submitSpinner.classList.add('hidden');
                if (submitBtn) submitBtn.disabled = false;

                const msg = currentLang === 'ja'
                    ? '通信エラーが発生しました。インターネット接続をご確認の上、再度お試しください。'
                    : 'A network error occurred. Please check your connection and try again.';
                if (errorAlert && errorMsg) {
                    errorMsg.textContent = msg;
                    errorAlert.classList.remove('hidden');
                    errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    alert(msg);
                }
            });
        });
    }

    // リセットボタン
    if (resetBtn && contactForm && completeBox) {
        resetBtn.addEventListener('click', function () {
            contactForm.reset();
            contactForm.classList.remove('hidden');
            completeBox.classList.add('hidden');
            if (dateInput) {
                const today = new Date();
                today.setDate(today.getDate() + 1);
                dateInput.value = today.toISOString().split('T')[0];
                if (typeof renderTimeSlots === 'function') {
                    renderTimeSlots(dateInput.value);
                }
            }
        });
    }

    /* ==========================================================================
       5. News Modal Popup (page-news.php, home.php)
       ========================================================================== */
    const newsModal = document.getElementById('news-modal');
    const newsModalDate = document.getElementById('news-modal-date');
    const newsModalBadge = document.getElementById('news-modal-badge');
    const newsModalImage = document.getElementById('news-modal-image');
    const newsModalTitle = document.getElementById('news-modal-title');
    const newsModalBody = document.getElementById('news-modal-body');
    const newsModalCloseX = document.getElementById('news-modal-close-x');
    const newsModalCloseBtn = document.getElementById('news-modal-close-btn');
    const newsCards = document.querySelectorAll('.js-news-card');

    function openNewsModal(card) {
        if (!newsModal) return;
        const date = card.getAttribute('data-date') || '';
        const category = card.getAttribute('data-category') || '';
        const badgeCls = card.getAttribute('data-badge') || 'bg-[#fde2d9] text-[#b54737]';
        const title = card.getAttribute('data-title') || '';
        const img = card.getAttribute('data-img') || '';
        const bodyEl = card.querySelector('.js-news-body');
        const bodyHtml = bodyEl ? bodyEl.innerHTML : '';

        if (newsModalDate) newsModalDate.textContent = date;
        if (newsModalBadge) {
            newsModalBadge.textContent = category;
            newsModalBadge.className = 'text-[10px] font-bold px-2 py-0.5 rounded-full ml-2 ' + badgeCls;
        }
        if (newsModalImage) {
            newsModalImage.src = img;
            newsModalImage.alt = title;
        }
        if (newsModalTitle) newsModalTitle.textContent = title;
        if (newsModalBody) newsModalBody.innerHTML = bodyHtml;

        newsModal.classList.remove('hidden');
        newsModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeNewsModal() {
        if (!newsModal) return;
        newsModal.classList.add('hidden');
        newsModal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    if (newsCards.length > 0 && newsModal) {
        newsCards.forEach(card => {
            card.addEventListener('click', function (e) {
                // 通常のページ遷移をキャンセルしてモーダルを開く
                e.preventDefault();
                openNewsModal(this);
            });
        });

        if (newsModalCloseX) newsModalCloseX.addEventListener('click', closeNewsModal);
        if (newsModalCloseBtn) newsModalCloseBtn.addEventListener('click', closeNewsModal);

        newsModal.addEventListener('click', function (e) {
            if (e.target === newsModal) {
                closeNewsModal();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !newsModal.classList.contains('hidden')) {
                closeNewsModal();
            }
        });
    }

    /* ==========================================================================
       6. Scroll & Entrance Motion System (framer-motion 互換)
       ========================================================================== */

    // 1) ページヘッダー（固定ページ冒頭の見出しエリア）の自動エントランス演出
    // React版 PageHeader.tsx (initial={{ opacity: 0, y: 15 }} animate={{ opacity: 1, y: 0 }}) 互換
    const headerBoxes = document.querySelectorAll(
        '.page-header-box, ' +
        'div[class*="bg-gradient-to-b"] > .max-w-7xl, ' +
        'section[class*="bg-gradient-to-b"] > .max-w-4xl, ' +
        'section[class*="bg-gradient-to-b"] > .max-w-7xl'
    );
    headerBoxes.forEach(box => {
        const titleGroup = box.querySelector('.space-y-3, .space-y-4') || box;
        if (titleGroup && !titleGroup.classList.contains('page-header-motion')) {
            titleGroup.classList.add('page-header-motion');
        }
    });

    // 2) 各ページのセクションを自動検出してスクロールモーション対象に登録
    // React版 AnimatedSection.tsx (initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }}) 互換
    const contentSections = document.querySelectorAll(
        '#page section, ' +
        '#page > div > section, ' +
        'main section, ' +
        '.site-main section, ' +
        '.animated-section'
    );

    contentSections.forEach(sec => {
        // ヒーロー（トップ冒頭）およびヘッダーセクション自体は別制御
        if (sec.id === 'hero' || sec.classList.contains('site-header') || sec.closest('header') || sec.closest('footer')) {
            return;
        }

        if (!sec.classList.contains('motion-fade-up') && !sec.classList.contains('motion-scale-up')) {
            sec.classList.add('motion-fade-up');
        }

        // セクション内のグリッドカード群（3列・4列など）にスタッガーアニメーションを自動適用
        const grid = sec.querySelector('.grid');
        if (grid && !grid.closest('#hero') && !grid.classList.contains('no-stagger')) {
            const cards = Array.from(grid.children);
            if (cards.length > 1 && cards.length <= 16) {
                cards.forEach((card, cIdx) => {
                    if (!card.classList.contains('stagger-item')) {
                        card.classList.add('stagger-item');
                        const delay = ((cIdx % 6) * 0.08 + 0.04).toFixed(2);
                        card.style.transitionDelay = `${delay}s`;
                    }
                });
            }
        }
    });

    // 3) IntersectionObserver によるスクロールフェードイン実行
    const motionElements = document.querySelectorAll('.motion-fade-up, .motion-scale-up, .motion-fade-in');

    if (motionElements.length > 0) {
        if ('IntersectionObserver' in window) {
            const motionObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-in-view');
                        // 子要素のスタッガーアイテムも同時に表示状態へ
                        entry.target.querySelectorAll('.stagger-item').forEach(item => {
                            item.classList.add('is-in-view');
                        });
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                root: null,
                rootMargin: '0px 0px -50px 0px', // framer-motion margin: '-50px' と完全一致
                threshold: 0.04
            });

            motionElements.forEach(el => {
                // ファーストビュー（画面内にすでに入っている要素）の即時フェードイン
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    setTimeout(() => {
                        el.classList.add('is-in-view');
                        el.querySelectorAll('.stagger-item').forEach(item => {
                            item.classList.add('is-in-view');
                        });
                    }, 60);
                } else {
                    motionObserver.observe(el);
                }
            });
        } else {
            motionElements.forEach(el => el.classList.add('is-in-view'));
        }
    }

    // 4) ヒーローセクション（トップページ冒頭）の段階的スタッガー表示
    const heroElements = document.querySelectorAll('#hero .motion-fade-up, #hero .motion-scale-up, #hero .motion-fade-in, .hero-motion');
    if (heroElements.length > 0) {
        setTimeout(() => {
            heroElements.forEach(el => el.classList.add('is-in-view'));
        }, 80);
    }
});
