import React, { useState, useMemo } from 'react';
import { PageHeader } from '../components/PageHeader';
import { AnimatedSection } from '../components/AnimatedSection';
import {
  Phone,
  CheckCircle,
  ChevronDown,
  Calendar,
  AlertTriangle,
  Info,
  Globe,
  Check
} from 'lucide-react';
import { motion } from 'framer-motion';
import { useShopInfo } from '../data/shopInfo';

// 時間帯と空き状況の型
interface TimeSlot {
  time: string;
  status: 'available' | 'few' | 'full';
  remaining: number;
}

// 言語型
type Language = 'ja' | 'en';

export const ContactPage: React.FC = () => {
  const shopInfo = useShopInfo();
  const [lang, setLang] = useState<Language>('ja');

  // 明日の日付をデフォルト値に設定（YYYY-MM-DD）
  const getTomorrowDate = () => {
    const d = new Date();
    d.setDate(d.getDate() + 1);
    return d.toISOString().split('T')[0];
  };

  const tomorrowStr = getTomorrowDate();

  // フォーム状態
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    type: '席のご予約',
    date: tomorrowStr,
    time: '11:00',
    guests: '2',
    seatType: '店内テーブル席',
    message: ''
  });

  const [loading, setLoading] = useState(false);
  const [submitted, setSubmitted] = useState(false);
  const [bookingRef, setBookingRef] = useState('');
  const [openFaqIndex, setOpenFaqIndex] = useState<number | null>(null);

  // 選択日が定休日かどうか判定
  const isClosedDay = useMemo(() => {
    if (!formData.date) return false;
    const closedNum = typeof shopInfo.closed_day_num === 'number'
      ? shopInfo.closed_day_num
      : parseInt(shopInfo.closed_day_num as string, 10);
    if (closedNum < 0) return false;
    const day = new Date(formData.date).getDay();
    return day === closedNum;
  }, [formData.date, shopInfo.closed_day_num]);

  // 選択日・人数に応じた時間枠の空き状況（シミュレーション生成）
  const timeSlots = useMemo<TimeSlot[]>(() => {
    if (!formData.date || isClosedDay) return [];

    const baseSlots = ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
    const dateNum = new Date(formData.date).getDate();

    return baseSlots.map((time, idx) => {
      const hash = (dateNum + idx * 7) % 10;
      if (time === '12:00' || (time === '13:00' && hash > 4) || hash === 3) {
        return { time, status: 'full', remaining: 0 };
      } else if (hash === 2 || hash === 6) {
        return { time, status: 'few', remaining: 1 };
      } else {
        return { time, status: 'available', remaining: 3 };
      }
    });
  }, [formData.date, isClosedDay]);

  const handleSelectTime = (slot: TimeSlot) => {
    if (slot.status === 'full') return;
    setFormData({ ...formData, time: slot.time });
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (formData.type === '席のご予約') {
      if (isClosedDay) {
        alert(
          lang === 'ja'
            ? `${shopInfo.closed_day_short}は定休日のためご予約いただけません。別の日程をお選びください。`
            : `We are closed on ${shopInfo.closed_day_short}. Please select another date.`
        );
        return;
      }
      const selectedSlot = timeSlots.find((s) => s.time === formData.time);
      if (selectedSlot && selectedSlot.status === 'full') {
        alert(
          lang === 'ja'
            ? '選択された時間帯は満席です。空きのある時間枠（◎または△）をお選びください。'
            : 'The selected time slot is fully booked. Please choose an available slot.'
        );
        return;
      }
    }

    setLoading(true);

    // 受付番号発行
    const randomNum = Math.floor(1000 + Math.random() * 9000);
    const ref = `HRK-${formData.date ? formData.date.replace(/-/g, '') : '202610'}-${randomNum}`;
    setBookingRef(ref);

    setTimeout(() => {
      setLoading(false);
      setSubmitted(true);
    }, 1000);
  };

  const toggleFaq = (index: number) => {
    setOpenFaqIndex(openFaqIndex === index ? null : index);
  };

  // 多言語テキスト辞書
  const t = {
    ja: {
      pageTitle: 'ご予約・お問い合わせ',
      subtitleEn: 'RESERVATION & CONTACT',
      pageDesc: 'お席の事前予約リクエストや、果物の入荷確認、団体・取材のお問い合わせなど、お気軽にご連絡ください。空き状況のリアルタイム確認が可能です。',
      langSelect: '言語切り替え / Language',
      refBadge: '受付番号',
      submittedTitleRes: 'ご予約リクエスト（仮予約）を受け付けました',
      submittedTitleInq: 'お問い合わせを送信いたしました',
      provisionalHeading: '現時点では【仮予約】の状態です',
      provisionalDesc: '店舗スタッフが配席状況を確認の上、24時間以内に「ご予約確定メール」をお送りいたします。確定メールの受信をもってご予約成立となります。',
      bookingDetails: 'ご予約内容の確認',
      detailDate: 'ご希望日時',
      detailGuests: 'ご予約人数',
      detailSeat: '座席タイプ',
      detailEmail: '送信先アドレス',
      resetBtn: '別の内容で送信する',
      formBadge: 'RESERVATION FORM',
      formTitle: 'WEBお問い合わせ・席予約',
      formDesc: 'ご希望の日時をお選びいただくと、リアルタイムの空き枠状況が表示されます。',
      inquiryTypeLabel: 'お問い合わせ種別',
      types: [
        { key: '席のご予約', label: '席のご予約（仮予約）', en: 'Table Reservation' },
        { key: '果物の入荷確認', label: '果物の入荷確認', en: 'Fruit Stock Inquiry' },
        { key: '取材・撮影', label: '取材・貸切のご相談', en: 'Media / Private Event' },
        { key: 'その他', label: 'その他のお問い合わせ', en: 'General Inquiry' },
      ],
      provisionalNoticeTitle: 'WEB予約の流れ（仮予約制）',
      provisionalNoticeText: '空き枠を選択して送信いただくと【仮予約】となります。店舗より空席確認後、24時間以内に「予約確定メール」をお送りして完了となります。',
      sectionBooking: '席予約詳細・空き状況選択',
      safeBadge: '満席誤予約防止機能 ON',
      dateLabel: 'ご来店希望日',
      dateSub: `※${shopInfo.closed_day}`,
      guestsLabel: 'ご利用人数',
      wednesdayAlert: `${shopInfo.closed_day_short}は定休日のためご予約いただけません。別の日程をお選びください。`,
      timeSlotLabel: 'ご来店時間枠の選択',
      statusAvailable: '◎ 余裕あり',
      statusFew: '△ 残り1組',
      statusFull: '✕ 満席',
      seatTypeLabel: 'ご希望の座席タイプ',
      seatTable: '店内テーブル席（落ち着いた空間）',
      seatTerrace: 'ガーデンテラス席（ペット同伴可・開放感）',
      nameLabel: 'お名前',
      nameSub: 'Full Name',
      namePlaceholder: '例：山田 太郎 / Taro Yamada',
      emailLabel: 'メールアドレス',
      emailSub: 'Email Address',
      emailPlaceholder: 'example@hareka.jp',
      phoneLabel: 'お電話番号',
      phoneSub: 'Phone Number',
      phonePlaceholder: '090-1234-5678 （国番号付き海外番号も可）',
      messageLabel: 'ご要望・メッセージ',
      messageSub: 'Special Requests',
      messagePlaceholder: 'お子様連れ、アレルギー食材、記念日プレートのご希望など、自由にご記入ください。',
      privacyAgree: '当店のプライバシーポリシーに同意の上、送信します。ご入力いただいた情報はご連絡・予約管理のみに使用いたします。',
      submitBtnRes: '空き枠で仮予約リクエストを送信する',
      submitBtnInq: 'お問い合わせを送信する',
      phoneCardTitle: 'お電話でのお問い合わせ',
      phoneCardSub: '当日の空席確認・お急ぎの場合',
      phoneCardHours: `受付時間：${shopInfo.phone_hours}`,
      phoneCardNotice: '※ランチタイム（11:30〜13:30）の混雑時はお電話が繋がりにくい場合がございます。',
      faqTitle: 'よくあるご質問（FAQ）',
      faqSub: 'ご予約・ご来店に関して多くいただくご質問です。',
    },
    en: {
      pageTitle: 'Reservation & Contact',
      subtitleEn: 'WELCOME VISITORS & TRAVELERS',
      pageDesc: 'Reserve your table to enjoy Okayama\'s fresh white peaches and muscat desserts. Real-time availability check is provided.',
      langSelect: 'Language / 言語切り替え',
      refBadge: 'Reference No.',
      submittedTitleRes: 'Reservation Request Received (Provisional)',
      submittedTitleInq: 'Your Inquiry Has Been Sent',
      provisionalHeading: 'Your booking is currently PROVISIONAL',
      provisionalDesc: 'Our staff will check the table status and send you a "Booking Confirmation Email" within 24 hours. Your reservation is finalized once you receive this confirmation.',
      bookingDetails: 'Booking Summary',
      detailDate: 'Date & Time',
      detailGuests: 'Guests',
      detailSeat: 'Seat Type',
      detailEmail: 'Confirmation to',
      resetBtn: 'Submit Another Inquiry',
      formBadge: 'RESERVATION FORM',
      formTitle: 'Online Table Reservation & Inquiry',
      formDesc: 'Select your preferred date to see real-time seat availability.',
      inquiryTypeLabel: 'Type of Inquiry',
      types: [
        { key: '席のご予約', label: 'Table Reservation (Request)', en: 'Table Reservation' },
        { key: '果物の入荷確認', label: 'Fruit Availability', en: 'Fruit Stock' },
        { key: '取材・撮影', label: 'Media / Private Event', en: 'Media / Event' },
        { key: 'その他', label: 'General Questions', en: 'General' },
      ],
      provisionalNoticeTitle: 'Reservation Policy (Provisional Flow)',
      provisionalNoticeText: 'Submitting this form makes a provisional hold. We will confirm your seat availability and send a confirmation email within 24 hours.',
      sectionBooking: 'Seat Reservation & Live Availability',
      safeBadge: 'Overbooking Protection ON',
      dateLabel: 'Preferred Date',
      dateSub: '※ We are CLOSED every Wednesday.',
      guestsLabel: 'Number of Guests',
      wednesdayAlert: 'We are closed on Wednesdays. Please select another date.',
      timeSlotLabel: 'Select Your Time Slot',
      statusAvailable: '◎ Available',
      statusFew: '△ Few Left (1 Table)',
      statusFull: '✕ Fully Booked',
      seatTypeLabel: 'Preferred Seating Area',
      seatTable: 'Indoor Dining Table (Cozy & Quiet)',
      seatTerrace: 'Garden Terrace (Pets Welcome & Open Air)',
      nameLabel: 'Your Full Name',
      nameSub: 'First & Last Name',
      namePlaceholder: 'e.g. John Smith / Taro Yamada',
      emailLabel: 'Email Address',
      emailSub: 'For Booking Confirmation',
      emailPlaceholder: 'yourname@example.com',
      phoneLabel: 'Phone Number',
      phoneSub: 'International numbers accepted',
      phonePlaceholder: '+1-555-123-4567 or 090-1234-5678',
      messageLabel: 'Special Requests / Dietary Restrictions',
      messageSub: 'Allergies, wheelchair, celebration, etc.',
      messagePlaceholder: 'Please let us know if you have fruit/food allergies, need high chairs for children, or are celebrating a special occasion.',
      privacyAgree: 'I agree to the Privacy Policy for reservation management and communications.',
      submitBtnRes: 'Submit Provisional Reservation Request',
      submitBtnInq: 'Submit Inquiry',
      phoneCardTitle: 'Telephone Inquiries',
      phoneCardSub: 'For Same-Day Seating or Urgent Inquiries',
      phoneCardHours: `Hours: ${shopInfo.phone_hours}`,
      phoneCardNotice: '※ During peak lunch hours (11:30 - 13:30), phone lines may be busy.',
      faqTitle: 'Frequently Asked Questions (FAQ)',
      faqSub: 'Common questions from our visitors and international travelers.',
    }
  };

  const currentT = t[lang];

  // 日英FAQリスト
  const faqs = [
    {
      qJa: '予約はいつから受け付けていますか？',
      qEn: 'How far in advance can I make a reservation?',
      aJa: 'ご来店希望日の30日前から、前日の17:00までこちらのWebフォームより受け付けております。当日のご予約や空席確認につきましては、お電話（086-XXXX-XXX ※架空番号）にて直接お問い合わせください。',
      aEn: 'We accept online reservations from 30 days up to 1 day prior (until 17:00). For same-day reservations or immediate seat checks, please call us directly (086-XXXX-XXX *dummy number).'
    },
    {
      qJa: '満席の時間帯は予約できませんか？',
      qEn: 'Can I book a time slot marked as "Fully Booked (✕)"?',
      aJa: 'はい。当店では確実なお席の確保とスムーズなご案内のため、予約枠が上限に達した時間帯（✕表示）はフォームからの受付を自動停止しております。◎または△の空き枠をお選びいただくか、別のお日にちをご検討ください。',
      aEn: 'No. To ensure comfortable seating for all guests, time slots marked with ✕ are locked once full capacity is reached. Please select an available slot (◎ or △) or another date.'
    },
    {
      qJa: '「仮予約」とはどういう状態ですか？',
      qEn: 'What does "Provisional Reservation" mean?',
      aJa: 'Webフォームからの送信時点では「仮受付」となります。店舗スタッフが内容を確認し、24時間以内に「【CAFE HAREKA】ご予約確定メール」をお送りした時点で正式な確定となります。',
      aEn: 'Your submission acts as an advance request. Our cafe team will check table assignments and send you a confirmation email within 24 hours to finalize your reservation.'
    },
    {
      qJa: '席のみの予約で、来店時にメニューを選べますか？',
      qEn: 'Can I reserve seats only and choose desserts upon arrival?',
      aJa: 'はい、可能です。お席のみをご予約いただき、当日店頭にて旬の白桃パフェやランチプレートをご自由にご注文いただけます。ただし、数量限定メニューは完売となる場合がございます。',
      aEn: 'Yes! You can reserve your table and order parfaits, seasonal tarts, and lunch plates at the cafe. Note that some seasonal items are limited in daily quantities.'
    },
    {
      qJa: 'ペット連れで利用できますか？',
      qEn: 'Can I bring my pet / dog?',
      aJa: 'はい、ガーデンテラス席（全14席）はリードを着用の上、ペットご同伴でご利用いただけます。お水用ボウルもご用意しております。雨天時や強風時はテラス席のご利用を制限させていただく場合がございます。',
      aEn: 'Yes, pets on a leash are welcome at our open-air garden terrace (14 seats). We also provide water bowls for dogs. Terrace seating may be restricted during severe weather.'
    },
    {
      qJa: '駐車場やクレジットカード決済は利用できますか？',
      qEn: 'Do you have parking and accept international credit cards?',
      aJa: '店舗敷地内に20台分の無料専用駐車場を完備しています。決済はVISA, Mastercard, JCB, AMEXの各種国際ブランドカード、Apple Pay、電子マネー、QR決済に対応しています。',
      aEn: 'Yes, we have 20 free parking spaces on-site. We accept major credit cards (VISA, MasterCard, JCB, AMEX), Apple Pay, and contactless IC payments.'
    }
  ];

  return (
    <div className="space-y-16 sm:space-y-24 pb-20">
      <PageHeader
        title={currentT.pageTitle}
        subtitleEn={currentT.subtitleEn}
        description={currentT.pageDesc}
        bgGradient="from-[#fde2d9]/60 via-[#faf7f2] to-[#e2f0d9]/60"
      />

      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* 言語切り替えバー */}
        <div className="flex justify-end mb-6">
          <div className="inline-flex items-center gap-1 bg-white p-1 rounded-2xl border border-[#e7dac5] shadow-sm">
            <span className="text-[11px] font-semibold text-[#8c735d] px-2 flex items-center gap-1">
              <Globe className="w-3.5 h-3.5 text-[#e26d5c]" />
              <span className="hidden sm:inline">Language:</span>
            </span>
            <button
              type="button"
              onClick={() => setLang('ja')}
              className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all ${
                lang === 'ja'
                  ? 'bg-[#392d23] text-white shadow-sm'
                  : 'text-[#574636] hover:bg-[#faf7f2]'
              }`}
            >
              🇯🇵 日本語
            </button>
            <button
              type="button"
              onClick={() => setLang('en')}
              className={`px-3 py-1.5 rounded-xl text-xs font-bold transition-all ${
                lang === 'en'
                  ? 'bg-[#392d23] text-white shadow-sm'
                  : 'text-[#574636] hover:bg-[#faf7f2]'
              }`}
            >
              🇬🇧 English
            </button>
          </div>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
          {/* お問い合わせフォームエリア */}
          <div className="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-10 border border-[#e7dac5] shadow-sm">
            {submitted ? (
              <motion.div
                initial={{ opacity: 0, scale: 0.95 }}
                animate={{ opacity: 1, scale: 1 }}
                className="text-center py-10 space-y-5"
              >
                <div className="w-16 h-16 rounded-full bg-[#e2f0d9] text-[#6cae54] flex items-center justify-center mx-auto text-2xl shadow-inner">
                  <CheckCircle className="w-8 h-8" />
                </div>

                <div className="space-y-2">
                  <span className="inline-block px-3 py-1 bg-[#fde2d9] text-[#b54737] rounded-full text-xs font-bold">
                    {currentT.refBadge}: {bookingRef}
                  </span>
                  <h3 className="font-serif text-2xl font-bold text-[#392d23]">
                    {formData.type === '席のご予約'
                      ? currentT.submittedTitleRes
                      : currentT.submittedTitleInq}
                  </h3>
                </div>

                {formData.type === '席のご予約' ? (
                  <div className="bg-[#fef2ee] border border-[#fbc6b6] rounded-2xl p-5 text-left max-w-md mx-auto space-y-3 text-xs text-[#574636]">
                    <div className="flex items-center gap-2 font-bold text-[#b54737] border-b border-[#fbc6b6]/60 pb-2">
                      <Info className="w-4 h-4 shrink-0" />
                      <span>{currentT.provisionalHeading}</span>
                    </div>
                    <p className="leading-relaxed text-[#6b5a4d]">
                      {currentT.provisionalDesc}
                    </p>
                    <div className="pt-2 border-t border-[#fbc6b6]/40 space-y-1 text-[11px] text-[#8c735d]">
                      <div className="font-bold text-[#392d23] mb-1">{currentT.bookingDetails}</div>
                      <div>・{currentT.detailDate}: <strong>{formData.date} {formData.time}</strong></div>
                      <div>・{currentT.detailGuests}: <strong>{formData.guests} Guests ({formData.seatType})</strong></div>
                      <div>・{currentT.detailEmail}: <strong>{formData.email}</strong></div>
                    </div>
                  </div>
                ) : (
                  <p className="text-xs sm:text-sm text-[#6b5a4d] max-w-md mx-auto leading-relaxed">
                    {lang === 'ja'
                      ? `送信が正常に完了いたしました。ご入力いただいたメールアドレス（${formData.email}）へ、担当者より折り返しご連絡いたします。`
                      : `Thank you for your message! Our staff will respond to your email (${formData.email}) shortly.`}
                  </p>
                )}

                <div className="pt-4">
                  <button
                    onClick={() => {
                      setSubmitted(false);
                      setFormData({
                        name: '',
                        email: '',
                        phone: '',
                        type: '席のご予約',
                        date: tomorrowStr,
                        time: '11:00',
                        guests: '2',
                        seatType: '店内テーブル席',
                        message: ''
                      });
                    }}
                    className="px-6 py-2.5 rounded-full border border-[#d8c8b2] text-xs font-semibold text-[#574636] hover:bg-[#faf7f2] transition"
                  >
                    {currentT.resetBtn}
                  </button>
                </div>
              </motion.div>
            ) : (
              <form onSubmit={handleSubmit} className="space-y-6">
                <div>
                  <span className="text-xs font-semibold tracking-widest text-[#a48c6f] uppercase block mb-1">
                    {currentT.formBadge}
                  </span>
                  <h3 className="font-serif text-xl sm:text-2xl font-bold text-[#392d23]">
                    {currentT.formTitle}
                  </h3>
                  <p className="text-xs text-[#6b5a4d] mt-1">
                    {currentT.formDesc}
                  </p>
                </div>

                {/* お問い合わせ種別 */}
                <div className="space-y-1.5">
                  <label className="text-xs font-bold text-[#392d23] block">
                    {currentT.inquiryTypeLabel} <span className="text-[#e26d5c]">*</span>
                  </label>
                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    {currentT.types.map((item) => (
                      <button
                        key={item.key}
                        type="button"
                        onClick={() => setFormData({ ...formData, type: item.key })}
                        className={`py-2.5 px-3 rounded-xl text-xs font-medium border text-left transition cursor-pointer flex items-center justify-between ${
                          formData.type === item.key
                            ? 'bg-[#392d23] text-white border-[#392d23] shadow-sm'
                            : 'bg-[#faf7f2] border-[#e7dac5] text-[#574636] hover:bg-[#f4eee3]'
                        }`}
                      >
                        <span>{item.label}</span>
                        {formData.type === item.key && <Check className="w-3.5 h-3.5 text-[#f7a48d]" />}
                      </button>
                    ))}
                  </div>
                </div>

                {/* 席予約詳細セクション */}
                {formData.type === '席のご予約' && (
                  <div className="space-y-5 bg-[#faf7f2] p-5 sm:p-6 rounded-2xl border border-[#e7dac5]">
                    <div className="flex items-center justify-between border-b border-[#ebdcc9] pb-3">
                      <h4 className="font-serif text-sm font-bold text-[#392d23] flex items-center gap-2">
                        <Calendar className="w-4 h-4 text-[#e26d5c]" />
                        <span>{currentT.sectionBooking}</span>
                      </h4>
                      <span className="text-[11px] text-[#4a8235] font-semibold bg-white px-2.5 py-0.5 rounded-full border border-[#d2e3c7]">
                        {currentT.safeBadge}
                      </span>
                    </div>

                    {/* 日付 & 人数 */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <div>
                        <label className="block text-xs font-bold text-[#392d23] mb-1.5">
                          {currentT.dateLabel} <span className="text-[#e26d5c]">*</span>
                        </label>
                        <input
                          type="date"
                          required
                          min={tomorrowStr}
                          value={formData.date}
                          onChange={(e) => setFormData({ ...formData, date: e.target.value })}
                          className="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                        />
                        <span className="text-[11px] text-[#b54737] mt-1 block">
                          {currentT.dateSub}
                        </span>
                      </div>

                      <div>
                        <label className="block text-xs font-bold text-[#392d23] mb-1.5">
                          {currentT.guestsLabel} <span className="text-[#e26d5c]">*</span>
                        </label>
                        <select
                          value={formData.guests}
                          onChange={(e) => setFormData({ ...formData, guests: e.target.value })}
                          className="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                        >
                          <option value="1">1 {lang === 'ja' ? '名様 (1 Guest)' : 'Guest'}</option>
                          <option value="2">2 {lang === 'ja' ? '名様 (2 Guests)' : 'Guests'}</option>
                          <option value="3">3 {lang === 'ja' ? '名様 (3 Guests)' : 'Guests'}</option>
                          <option value="4">4 {lang === 'ja' ? '名様 (4 Guests)' : 'Guests'}</option>
                          <option value="5">5 {lang === 'ja' ? '名様 (5 Guests)' : 'Guests'}</option>
                          <option value="6">6 {lang === 'ja' ? '名様以上 (6+ Guests)' : 'Guests or more'}</option>
                        </select>
                      </div>
                    </div>

                    {/* 定休日警告 */}
                    {isClosedDay && (
                      <div className="p-3.5 rounded-xl bg-[#fff3cd] border border-[#ffeeba] text-xs text-[#856404] flex items-start gap-2">
                        <AlertTriangle className="w-4 h-4 text-[#856404] shrink-0 mt-0.5" />
                        <span><strong>{currentT.wednesdayAlert}</strong></span>
                      </div>
                    )}

                    {/* 時間帯空き枠グリッド */}
                    {!isClosedDay && (
                      <div className="space-y-2">
                        <div className="flex items-center justify-between">
                          <label className="block text-xs font-bold text-[#392d23]">
                            {currentT.timeSlotLabel} <span className="text-[#e26d5c]">*</span>
                          </label>
                          <div className="flex items-center gap-2.5 text-[10px] text-[#6b5a4d]">
                            <span className="flex items-center gap-1">
                              <span className="w-2 h-2 rounded-full bg-[#4a8235]"></span>
                              {currentT.statusAvailable}
                            </span>
                            <span className="flex items-center gap-1">
                              <span className="w-2 h-2 rounded-full bg-[#d97706]"></span>
                              {currentT.statusFew}
                            </span>
                            <span className="flex items-center gap-1">
                              <span className="w-2 h-2 rounded-full bg-[#9ca3af]"></span>
                              {currentT.statusFull}
                            </span>
                          </div>
                        </div>

                        <div className="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-1">
                          {timeSlots.map((slot) => {
                            const isSelected = formData.time === slot.time && slot.status !== 'full';
                            const isFull = slot.status === 'full';

                            return (
                              <button
                                key={slot.time}
                                type="button"
                                disabled={isFull}
                                onClick={() => handleSelectTime(slot)}
                                className={`p-3 rounded-xl border text-left transition relative flex flex-col justify-between ${
                                  isFull
                                    ? 'opacity-40 bg-[#f8f9fa] border-gray-200 cursor-not-allowed text-gray-400'
                                    : isSelected
                                    ? 'border-[#b54737] bg-[#fef2ee] ring-2 ring-[#b54737]'
                                    : 'border-[#e7dac5] bg-white hover:border-[#b54737]/60'
                                }`}
                              >
                                <div className="flex items-center justify-between">
                                  <span className={`font-serif text-sm font-bold ${isFull ? 'text-gray-400' : 'text-[#392d23]'}`}>
                                    {slot.time}
                                  </span>
                                  {isSelected && <span className="w-2 h-2 rounded-full bg-[#b54737]"></span>}
                                </div>
                                <div
                                  className={`mt-2 text-[10px] font-bold px-1.5 py-0.5 rounded text-center ${
                                    slot.status === 'available'
                                      ? 'text-[#4a8235] bg-[#eaf4e6]'
                                      : slot.status === 'few'
                                      ? 'text-[#d97706] bg-[#fef3c7]'
                                      : 'text-[#9ca3af] bg-[#f3f4f6]'
                                  }`}
                                >
                                  {slot.status === 'available'
                                    ? currentT.statusAvailable
                                    : slot.status === 'few'
                                    ? currentT.statusFew
                                    : currentT.statusFull}
                                </div>
                              </button>
                            );
                          })}
                        </div>
                      </div>
                    )}

                    {/* 座席タイプ選択 */}
                    <div className="space-y-1.5 pt-1">
                      <label className="block text-xs font-bold text-[#392d23]">
                        {currentT.seatTypeLabel}
                      </label>
                      <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label className={`flex items-center gap-2 p-3 rounded-xl border cursor-pointer text-xs transition ${
                          formData.seatType === '店内テーブル席'
                            ? 'border-[#b54737] bg-[#fef2ee] text-[#b54737] font-semibold'
                            : 'border-[#d8c8b2] bg-white text-[#574636]'
                        }`}>
                          <input
                            type="radio"
                            name="seatType"
                            checked={formData.seatType === '店内テーブル席'}
                            onChange={() => setFormData({ ...formData, seatType: '店内テーブル席' })}
                            className="text-[#b54737]"
                          />
                          <span>{currentT.seatTable}</span>
                        </label>

                        <label className={`flex items-center gap-2 p-3 rounded-xl border cursor-pointer text-xs transition ${
                          formData.seatType === 'ガーデンテラス席'
                            ? 'border-[#b54737] bg-[#fef2ee] text-[#b54737] font-semibold'
                            : 'border-[#d8c8b2] bg-white text-[#574636]'
                        }`}>
                          <input
                            type="radio"
                            name="seatType"
                            checked={formData.seatType === 'ガーデンテラス席'}
                            onChange={() => setFormData({ ...formData, seatType: 'ガーデンテラス席' })}
                            className="text-[#b54737]"
                          />
                          <span>{currentT.seatTerrace}</span>
                        </label>
                      </div>
                    </div>
                  </div>
                )}

                {/* お客様情報 */}
                {/* お名前 */}
                <div className="space-y-1.5">
                  <label className="text-xs font-bold text-[#392d23] block">
                    {currentT.nameLabel} <span className="text-[10px] text-[#a48c6f]">/ {currentT.nameSub}</span> <span className="text-[#e26d5c]">*</span>
                  </label>
                  <input
                    type="text"
                    required
                    placeholder={currentT.namePlaceholder}
                    value={formData.name}
                    onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                    className="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                  />
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div className="space-y-1.5">
                    <label className="text-xs font-bold text-[#392d23] block">
                      {currentT.emailLabel} <span className="text-[10px] text-[#a48c6f]">/ {currentT.emailSub}</span> <span className="text-[#e26d5c]">*</span>
                    </label>
                    <input
                      type="email"
                      required
                      placeholder={currentT.emailPlaceholder}
                      value={formData.email}
                      onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                      className="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                    />
                  </div>

                  <div className="space-y-1.5">
                    <label className="text-xs font-bold text-[#392d23] block">
                      {currentT.phoneLabel} <span className="text-[10px] text-[#a48c6f]">/ {currentT.phoneSub}</span> <span className="text-[#e26d5c]">*</span>
                    </label>
                    <input
                      type="tel"
                      required
                      placeholder={currentT.phonePlaceholder}
                      value={formData.phone}
                      onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                      className="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                    />
                  </div>
                </div>

                {/* メッセージ */}
                <div className="space-y-1.5">
                  <label className="text-xs font-bold text-[#392d23] block">
                    {currentT.messageLabel} <span className="text-[10px] text-[#a48c6f]">/ {currentT.messageSub}</span>
                  </label>
                  <textarea
                    rows={4}
                    placeholder={currentT.messagePlaceholder}
                    value={formData.message}
                    onChange={(e) => setFormData({ ...formData, message: e.target.value })}
                    className="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-xs bg-white text-[#392d23] focus:outline-none focus:ring-2 focus:ring-[#e26d5c]"
                  />
                </div>

                {/* プライバシーポリシー同意 */}
                <div className="pt-2">
                  <label className="flex items-start gap-2.5 text-xs text-[#6b5a4d] cursor-pointer">
                    <input type="checkbox" required className="mt-0.5 rounded text-[#b54737] focus:ring-[#b54737]" />
                    <span>{currentT.privacyAgree}</span>
                  </label>
                </div>

                {/* 送信ボタン */}
                <div className="pt-4">
                  <button
                    type="submit"
                    disabled={loading}
                    className="w-full py-4 rounded-full bg-gradient-to-r from-[#e26d5c] to-[#b54737] text-white font-bold text-sm tracking-wider shadow hover:shadow-lg hover:opacity-95 transition flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50"
                  >
                    {loading ? (
                      <span>Loading...</span>
                    ) : (
                      <span>{formData.type === '席のご予約' ? currentT.submitBtnRes : currentT.submitBtnInq}</span>
                    )}
                  </button>
                </div>
              </form>
            )}
          </div>

          {/* 右サイドバー：電話案内 ＆ 日英FAQ */}
          <div className="lg:col-span-5 space-y-8">
            {/* お電話案内カード */}
            <div className="bg-white rounded-3xl p-6 sm:p-8 border border-[#e7dac5] shadow-sm space-y-4">
              <div className="flex items-center gap-3">
                <div className="w-10 h-10 rounded-2xl bg-[#fde2d9] text-[#e26d5c] flex items-center justify-center">
                  <Phone className="w-5 h-5" />
                </div>
                <div>
                  <h3 className="font-serif text-lg font-bold text-[#392d23]">{currentT.phoneCardTitle}</h3>
                  <span className="text-xs text-[#a48c6f]">{currentT.phoneCardSub}</span>
                </div>
              </div>

              <div className="space-y-1">
                <div className="flex items-baseline gap-2">
                  <span
                    className="text-2xl sm:text-3xl font-serif font-bold text-[#b54737] block"
                    title={shopInfo.phone_note}
                  >
                    {shopInfo.phone}
                  </span>
                </div>
                <p className="text-xs text-[#6b5a4d]">
                  {currentT.phoneCardHours}
                </p>
              </div>

              <p className="text-xs text-[#6b5a4d] leading-relaxed pt-2 border-t border-[#f4eee3]">
                {currentT.phoneCardNotice}
              </p>
            </div>

            {/* 日英対応 よくある質問（FAQ）アコーディオン */}
            <div className="bg-white rounded-3xl p-6 sm:p-8 border border-[#e7dac5] shadow-sm space-y-6">
              <div className="space-y-1 border-b border-[#f4eee3] pb-3">
                <h3 className="font-serif text-lg font-bold text-[#392d23]">
                  {currentT.faqTitle}
                </h3>
                <p className="text-xs text-[#a48c6f]">
                  {currentT.faqSub}
                </p>
              </div>

              <div className="space-y-3">
                {faqs.map((faq, idx) => (
                  <div key={idx} className="border border-[#e7dac5] rounded-2xl overflow-hidden transition-all bg-[#faf7f2]/50">
                    <button
                      type="button"
                      onClick={() => toggleFaq(idx)}
                      className="w-full p-4 text-left font-serif text-xs sm:text-sm font-bold text-[#392d23] flex items-center justify-between gap-3 hover:bg-[#faf7f2] transition"
                    >
                      <span className="flex items-center gap-2">
                        <span className="text-[#e26d5c]">Q.</span>
                        <span>{lang === 'ja' ? faq.qJa : faq.qEn}</span>
                      </span>
                      <ChevronDown
                        className={`w-4 h-4 text-[#a48c6f] transform transition-transform duration-200 shrink-0 ${
                          openFaqIndex === idx ? 'rotate-180' : ''
                        }`}
                      />
                    </button>
                    {openFaqIndex === idx && (
                      <div className="p-4 pt-0 text-xs text-[#6b5a4d] leading-relaxed border-t border-[#f4eee3]/60 bg-white">
                        <p className="pt-3">{lang === 'ja' ? faq.aJa : faq.aEn}</p>
                      </div>
                    )}
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </AnimatedSection>
    </div>
  );
};
