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
       1. Mobile Menu Drawer
       ========================================================================== */
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
    const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');

    function openMobileMenu() {
        if (!mobileMenuDrawer || !mobileMenuBackdrop) return;
        mobileMenuBackdrop.classList.remove('hidden');
        mobileMenuDrawer.classList.remove('translate-x-full');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileMenu() {
        if (!mobileMenuDrawer || !mobileMenuBackdrop) return;
        mobileMenuDrawer.classList.add('translate-x-full');
        setTimeout(() => {
            mobileMenuBackdrop.classList.add('hidden');
            document.body.style.overflow = '';
        }, 250);
    }

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', openMobileMenu);
    }
    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', closeMobileMenu);
    }
    if (mobileMenuBackdrop) {
        mobileMenuBackdrop.addEventListener('click', closeMobileMenu);
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
                    const cardCat = card.getAttribute('data-category');
                    if (targetCategory === 'all' || cardCat === targetCategory) {
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

        // 2) スロット生成関数（空き状況シミュレーション）
        function renderTimeSlots(dateVal) {
            slotsGrid.innerHTML = '';
            if (!dateVal) return;

            const selectedDate = new Date(dateVal);
            const dayOfWeek = selectedDate.getDay(); // 3 = 水曜

            if (dayOfWeek === 3) {
                // 水曜日は定休日
                if (wednesdayAlert) wednesdayAlert.classList.remove('hidden');
                slotsGrid.innerHTML = '<div class="col-span-full py-4 text-center text-xs text-[#a48c6f] bg-white rounded-xl border border-[#e7dac5]">定休日のため時間枠は選択できません</div>';
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
                let badgeText = '◎ 余裕あり';
                let badgeColor = 'text-[#4a8235] bg-[#eaf4e6]';

                // ピーク時や決定論的パターンで満席/残少を算出
                if (time === '12:00' || (time === '13:00' && hash > 4) || hash === 3) {
                    status = 'full';
                    badgeText = '✕ 満席';
                    badgeColor = 'text-[#9ca3af] bg-[#f3f4f6]';
                } else if (hash === 2 || hash === 6) {
                    status = 'few';
                    badgeText = '△ 残り1組';
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
                    if (submitText) submitText.textContent = '空き枠で仮予約リクエストを送信する';
                } else {
                    reservationFields.classList.add('hidden');
                    if (submitText) submitText.textContent = 'お問い合わせを送信する';
                }
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
                if (selectedDate.getDay() === 3) {
                    alert('水曜日は定休日のためご予約いただけません。別の日程をお選びください。');
                    return;
                }
            }

            // 送信ローディング表示
            if (submitSpinner) submitSpinner.classList.remove('hidden');
            if (submitBtn) submitBtn.disabled = true;

            const datePart = (dateInput && dateInput.value) ? dateInput.value.replace(/-/g, '') : '202610';
            const randomNum = Math.floor(1000 + Math.random() * 9000);
            const bookingRef = `HRK-${datePart}-${randomNum}`;

            // 送信シミュレーション（WordPress REST APIまたはAJAXとも接続可能）
            setTimeout(() => {
                if (submitSpinner) submitSpinner.classList.add('hidden');
                if (submitBtn) submitBtn.disabled = false;

                contactForm.classList.add('hidden');
                completeBox.classList.remove('hidden');

                if (refBadge) refBadge.textContent = `受付番号: ${bookingRef}`;

                if (inquiryType === '席のご予約') {
                    if (completeTitle) completeTitle.textContent = 'ご予約リクエスト（仮予約）を受け付けました';
                    if (provisionalNotice) provisionalNotice.classList.remove('hidden');
                } else {
                    if (completeTitle) completeTitle.textContent = 'お問い合わせを送信いたしました';
                    if (provisionalNotice) provisionalNotice.classList.add('hidden');
                }

                // スムーズスクロール
                completeBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 1000);
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
});
