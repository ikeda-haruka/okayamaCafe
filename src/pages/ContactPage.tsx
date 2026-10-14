import React, { useState, useMemo } from 'react';
import { PageHeader } from '../components/PageHeader';
import { AnimatedSection } from '../components/AnimatedSection';
import { faqList } from '../data/faqData';
import {
  Phone,
  CheckCircle,
  HelpCircle,
  ChevronDown,
  Send,
  Loader2,
  Calendar,
  Clock,
  AlertTriangle,
  Info,
  Check
} from 'lucide-react';
import { motion, AnimatePresence } from 'framer-motion';

// 時間帯と空き状況の型
interface TimeSlot {
  time: string;
  status: 'available' | 'few' | 'full';
  remaining: number;
}

export const ContactPage: React.FC = () => {
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
    kana: '',
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

  // 選択日が定休日（水曜日）かどうか判定
  const isWednesday = useMemo(() => {
    if (!formData.date) return false;
    const day = new Date(formData.date).getDay();
    return day === 3; // 3 = Wednesday
  }, [formData.date]);

  // 選択日・人数に応じた時間枠の空き状況（シミュレーション生成）
  const timeSlots = useMemo<TimeSlot[]>(() => {
    if (!formData.date || isWednesday) return [];

    // 日付と人数に基づく決定的なスロット生成
    const baseSlots = ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
    const dateNum = new Date(formData.date).getDate();

    return baseSlots.map((time, idx) => {
      // ランダム感を出しつつ決定的に満席枠を作る（ランチピークや一部時間帯）
      const hash = (dateNum + idx * 7) % 10;
      if (time === '12:00' || (time === '13:00' && hash > 4) || hash === 3) {
        return { time, status: 'full', remaining: 0 };
      } else if (hash === 2 || hash === 6) {
        return { time, status: 'few', remaining: 1 };
      } else {
        return { time, status: 'available', remaining: 3 };
      }
    });
  }, [formData.date, isWednesday]);

  // 時間選択ハンドラ（満席なら選択不可）
  const handleSelectTime = (slot: TimeSlot) => {
    if (slot.status === 'full') return;
    setFormData({ ...formData, time: slot.time });
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (formData.type === '席のご予約') {
      if (isWednesday) {
        alert('水曜日は定休日のためご予約いただけません。別の日程をお選びください。');
        return;
      }
      const selectedSlot = timeSlots.find((s) => s.time === formData.time);
      if (selectedSlot && selectedSlot.status === 'full') {
        alert('選択された時間帯は満席です。空きのある時間枠（◎または△）をお選びください。');
        return;
      }
    }

    setLoading(true);

    // 受付番号発行
    const randomNum = Math.floor(1000 + Math.random() * 9000);
    const ref = `HRK-${formData.date ? formData.date.replace(/-/g, '') : '202610'}-${randomNum}`;
    setBookingRef(ref);

    // 送信シミュレーション（1.2秒後）
    setTimeout(() => {
      setLoading(false);
      setSubmitted(true);
    }, 1200);
  };

  const toggleFaq = (index: number) => {
    setOpenFaqIndex(openFaqIndex === index ? null : index);
  };

  return (
    <div className="space-y-16 sm:space-y-24 pb-20">
      <PageHeader
        title="ご予約・お問い合わせ"
        subtitleEn="RESERVATION & CONTACT"
        description="お席の事前予約リクエストや、果物の入荷確認、団体・取材のお問い合わせなど、お気軽にご連絡ください。空き状況のリアルタイム確認が可能です。"
      />

      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
          {/* お問い合わせフォーム */}
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
                    受付番号: {bookingRef}
                  </span>
                  <h3 className="font-serif text-2xl font-bold text-[#392d23]">
                    {formData.type === '席のご予約'
                      ? 'ご予約リクエスト（仮予約）を受け付けました'
                      : 'お問い合わせを送信いたしました'}
                  </h3>
                </div>

                {formData.type === '席のご予約' ? (
                  <div className="bg-[#fef2ee] border border-[#fbc6b6] rounded-2xl p-4 text-left max-w-md mx-auto space-y-3 text-xs text-[#574636]">
                    <div className="flex items-center gap-2 font-bold text-[#b54737] border-b border-[#fbc6b6]/60 pb-2">
                      <Info className="w-4 h-4 shrink-0" />
                      <span>現時点では【仮予約】の状態です</span>
                    </div>
                    <p className="leading-relaxed text-[#6b5a4d]">
                      店舗スタッフが最新の配席状況を確認の上、<strong>24時間以内に「ご予約確定メール」</strong>をお送りいたします。確定メールの受信をもってご予約成立となります。
                    </p>
                    <div className="pt-1 space-y-1 text-[11px] text-[#8c735d]">
                      <div>・ご希望日時：{formData.date} {formData.time}〜</div>
                      <div>・ご予約人数：{formData.guests}名様（{formData.seatType}）</div>
                      <div>・送信先アドレス：{formData.email}</div>
                    </div>
                  </div>
                ) : (
                  <p className="text-xs sm:text-sm text-[#6b5a4d] max-w-md mx-auto leading-relaxed">
                    送信が正常に完了いたしました。ご入力いただいたメールアドレス（{formData.email}）へ、担当者より折り返しご連絡いたします。
                  </p>
                )}

                <div className="pt-4">
                  <button
                    onClick={() => {
                      setSubmitted(false);
                      setFormData({
                        name: '',
                        kana: '',
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
                    フォームトップへ戻る
                  </button>
                </div>
              </motion.div>
            ) : (
              <form onSubmit={handleSubmit} className="space-y-6">
                <div>
                  <span className="text-xs font-semibold tracking-widest text-[#a48c6f] uppercase block mb-1">
                    FORM
                  </span>
                  <h3 className="font-serif text-xl sm:text-2xl font-bold text-[#392d23]">
                    WEBお問い合わせ・席予約
                  </h3>
                  <p className="text-xs text-[#6b5a4d] mt-1">
                    ご希望の日時をお選びいただくと、リアルタイムの空き枠状況が表示されます。
                  </p>
                </div>

                {/* お問い合わせ種別 */}
                <div className="space-y-1.5">
                  <label className="text-xs font-bold text-[#392d23] block">
                    お問い合わせ種別 <span className="text-[#e26d5c]">*</span>
                  </label>
                  <div className="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    {['席のご予約', '果物の入荷確認', '取材・撮影', 'その他'].map((type) => (
                      <button
                        key={type}
                        type="button"
                        onClick={() => setFormData({ ...formData, type })}
                        className={`py-2 px-3 rounded-xl text-xs font-medium border text-center transition cursor-pointer ${
                          formData.type === type
                            ? 'bg-[#392d23] text-white border-[#392d23] shadow-sm'
                            : 'bg-[#faf7f2] border-[#e7dac5] text-[#574636] hover:bg-[#f4eee3]'
                        }`}
                      >
                        {type}
                      </button>
                    ))}
                  </div>
                </div>

                {/* 席予約の場合の「安心フロー案内」 */}
                {formData.type === '席のご予約' && (
                  <div className="p-3.5 rounded-2xl bg-[#faf7f2] border border-[#e7dac5] text-xs space-y-1 text-[#6b5a4d]">
                    <div className="flex items-center gap-1.5 font-bold text-[#b54737]">
                      <Info className="w-3.5 h-3.5" />
                      <span>WEB予約の流れ（仮予約制）</span>
                    </div>
                    <p className="text-[11px] leading-relaxed">
                      空き枠を選択して送信いただくと<strong>【仮予約】</strong>となります。店舗より空席確認後、24時間以内に「予約確定メール」をお送りして完了となります。
                    </p>
                  </div>
                )}

                {/* お名前 & フリガナ */}
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div className="space-y-1.5">
                    <label className="text-xs font-bold text-[#392d23] block">
                      お名前 <span className="text-[#e26d5c]">*</span>
                    </label>
                    <input
                      type="text"
                      required
                      placeholder="山田 太郎"
                      value={formData.name}
                      onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                      className="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-sm focus:outline-none focus:ring-2 focus:ring-[#f7a48d] bg-[#faf7f2]"
                    />
                  </div>
                  <div className="space-y-1.5">
                    <label className="text-xs font-bold text-[#392d23] block">
                      フリガナ <span className="text-[#e26d5c]">*</span>
                    </label>
                    <input
                      type="text"
                      required
                      placeholder="ヤマダ タロウ"
                      value={formData.kana}
                      onChange={(e) => setFormData({ ...formData, kana: e.target.value })}
                      className="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-sm focus:outline-none focus:ring-2 focus:ring-[#f7a48d] bg-[#faf7f2]"
                    />
                  </div>
                </div>

                {/* メールアドレス & 電話番号 */}
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div className="space-y-1.5">
                    <label className="text-xs font-bold text-[#392d23] block">
                      メールアドレス <span className="text-[#e26d5c]">*</span>
                    </label>
                    <input
                      type="email"
                      required
                      placeholder="example@gmail.com"
                      value={formData.email}
                      onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                      className="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-sm focus:outline-none focus:ring-2 focus:ring-[#f7a48d] bg-[#faf7f2]"
                    />
                  </div>
                  <div className="space-y-1.5">
                    <label className="text-xs font-bold text-[#392d23] block">
                      お電話番号 <span className="text-[#e26d5c]">*</span>
                    </label>
                    <input
                      type="tel"
                      required
                      placeholder="090-1234-5678"
                      value={formData.phone}
                      onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                      className="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-sm focus:outline-none focus:ring-2 focus:ring-[#f7a48d] bg-[#faf7f2]"
                    />
                  </div>
                </div>

                {/* 席予約の場合の日時・空き枠リアルタイムセレクター */}
                {formData.type === '席のご予約' && (
                  <div className="p-5 rounded-2xl bg-[#fef2ee] border border-[#fbc6b6]/80 space-y-5">
                    <div className="flex items-center justify-between border-b border-[#fbc6b6]/60 pb-3">
                      <div className="flex items-center gap-2">
                        <Calendar className="w-4 h-4 text-[#b54737]" />
                        <span className="text-xs font-bold text-[#b54737]">
                          希望日・人数・空き枠の選択
                        </span>
                      </div>
                      <span className="text-[10px] text-[#8c735d] bg-white px-2 py-0.5 rounded-full border border-[#fbc6b6]">
                        定休日：毎週水曜
                      </span>
                    </div>

                    {/* 日付・人数・席タイプ入力 */}
                    <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                      <div>
                        <label className="text-[11px] font-bold text-[#574636] block mb-1">
                          ご希望日 <span className="text-[#e26d5c]">*</span>
                        </label>
                        <input
                          type="date"
                          required
                          min={new Date().toISOString().split('T')[0]}
                          value={formData.date}
                          onChange={(e) => setFormData({ ...formData, date: e.target.value })}
                          className="w-full px-3 py-2 rounded-lg border border-[#d8c8b2] text-xs bg-white focus:outline-none focus:ring-1 focus:ring-[#f7a48d]"
                        />
                      </div>

                      <div>
                        <label className="text-[11px] font-bold text-[#574636] block mb-1">
                          人数 <span className="text-[#e26d5c]">*</span>
                        </label>
                        <select
                          value={formData.guests}
                          onChange={(e) => setFormData({ ...formData, guests: e.target.value })}
                          className="w-full px-3 py-2 rounded-lg border border-[#d8c8b2] text-xs bg-white focus:outline-none"
                        >
                          <option value="1">1名様</option>
                          <option value="2">2名様</option>
                          <option value="3">3名様</option>
                          <option value="4">4名様</option>
                          <option value="5">5名様以上（要お電話）</option>
                        </select>
                      </div>

                      <div>
                        <label className="text-[11px] font-bold text-[#574636] block mb-1">
                          座席タイプ
                        </label>
                        <select
                          value={formData.seatType}
                          onChange={(e) => setFormData({ ...formData, seatType: e.target.value })}
                          className="w-full px-3 py-2 rounded-lg border border-[#d8c8b2] text-xs bg-white focus:outline-none"
                        >
                          <option value="店内テーブル席">店内テーブル席</option>
                          <option value="ガーデンテラス席（ペット可）">ガーデンテラス席（ペット可）</option>
                          <option value="窓際カウンター席">窓際カウンター席</option>
                        </select>
                      </div>
                    </div>

                    {/* 定休日アラート */}
                    {isWednesday ? (
                      <div className="p-3 rounded-xl bg-[#fff0f0] border border-[#e26d5c] text-xs text-[#b54737] flex items-center gap-2">
                        <AlertTriangle className="w-4 h-4 shrink-0" />
                        <span>選択された日は定休日（水曜日）です。木曜日〜火曜日の営業日をお選びください。</span>
                      </div>
                    ) : (
                      /* リアルタイム時間枠グリッドセレクター */
                      <div className="space-y-2 pt-1">
                        <div className="flex items-center justify-between text-[11px]">
                          <span className="font-bold text-[#392d23] flex items-center gap-1">
                            <Clock className="w-3.5 h-3.5 text-[#b54737]" />
                            希望時間を選択（現在の空席状況）:
                          </span>
                          <div className="flex items-center gap-3 text-[10px]">
                            <span className="flex items-center gap-1 text-[#4a8235]">
                              <span className="w-2 h-2 rounded-full bg-[#6cae54]" /> ◎ 空きあり
                            </span>
                            <span className="flex items-center gap-1 text-[#c07d2c]">
                              <span className="w-2 h-2 rounded-full bg-[#e6a23c]" /> △ 残りわずか
                            </span>
                            <span className="flex items-center gap-1 text-[#a0392b]">
                              <span className="w-2 h-2 rounded-full bg-[#e26d5c]" /> ✕ 満席
                            </span>
                          </div>
                        </div>

                        <div className="grid grid-cols-2 sm:grid-cols-4 gap-2">
                          {timeSlots.map((slot) => {
                            const isSelected = formData.time === slot.time;
                            const isFull = slot.status === 'full';

                            return (
                              <button
                                key={slot.time}
                                type="button"
                                disabled={isFull}
                                onClick={() => handleSelectTime(slot)}
                                className={`p-2.5 rounded-xl border text-center transition flex flex-col items-center justify-center gap-0.5 ${
                                  isFull
                                    ? 'bg-[#f0ece9] border-[#d8c8b2] text-[#a48c6f] cursor-not-allowed opacity-60'
                                    : isSelected
                                    ? 'bg-[#392d23] text-white border-[#392d23] shadow-md scale-[1.02]'
                                    : 'bg-white border-[#d8c8b2] text-[#392d23] hover:border-[#b54737] hover:bg-[#faf7f2] cursor-pointer'
                                }`}
                              >
                                <span className="font-bold text-xs">{slot.time}</span>
                                <div className="text-[10px] flex items-center gap-1 font-medium">
                                  {slot.status === 'available' && (
                                    <span className={isSelected ? 'text-[#a9d997]' : 'text-[#4a8235]'}>
                                      ◎ 空席あり
                                    </span>
                                  )}
                                  {slot.status === 'few' && (
                                    <span className={isSelected ? 'text-[#fde2d9]' : 'text-[#c07d2c]'}>
                                      △ 残り1組
                                    </span>
                                  )}
                                  {slot.status === 'full' && (
                                    <span className="text-[#b54737] font-bold">
                                      ✕ 満席
                                    </span>
                                  )}
                                </div>
                              </button>
                            );
                          })}
                        </div>

                        {formData.time && (
                          <div className="text-[11px] text-[#4a8235] bg-[#e2f0d9]/60 px-3 py-1.5 rounded-lg flex items-center justify-between">
                            <span className="flex items-center gap-1">
                              <Check className="w-3.5 h-3.5" /> 選択中：<strong>{formData.date} {formData.time}〜</strong>（{formData.guests}名様）
                            </span>
                            <span className="text-[10px] text-[#574636]">予約可能枠</span>
                          </div>
                        )}
                      </div>
                    )}
                  </div>
                )}

                {/* メッセージ本文 */}
                <div className="space-y-1.5">
                  <label className="text-xs font-bold text-[#392d23] block">
                    メッセージ / ご要望
                  </label>
                  <textarea
                    rows={3}
                    placeholder="アレルギー、お子様用椅子の要否、清水白桃パフェのお取り置き希望など自由にご記入ください。"
                    value={formData.message}
                    onChange={(e) => setFormData({ ...formData, message: e.target.value })}
                    className="w-full px-4 py-2.5 rounded-xl border border-[#d8c8b2] text-sm focus:outline-none focus:ring-2 focus:ring-[#f7a48d] bg-[#faf7f2]"
                  />
                </div>

                {/* 送信ボタン */}
                <button
                  type="submit"
                  disabled={loading || (formData.type === '席のご予約' && isWednesday)}
                  className="w-full py-4 rounded-full bg-gradient-to-r from-[#e26d5c] to-[#b54737] text-white font-bold text-sm shadow-md hover:shadow-lg hover:brightness-105 transition flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50"
                >
                  {loading ? (
                    <>
                      <Loader2 className="w-5 h-5 animate-spin" />
                      <span>空席照会中...</span>
                    </>
                  ) : (
                    <>
                      <Send className="w-4 h-4" />
                      <span>
                        {formData.type === '席のご予約'
                          ? '予約リクエスト（仮予約）を送信する'
                          : 'お問い合わせを送信する'}
                      </span>
                    </>
                  )}
                </button>
              </form>
            )}
          </div>

          {/* 右側：お電話案内 & FAQ */}
          <div className="lg:col-span-5 space-y-8">
            {/* お急ぎの方はお電話 */}
            <div className="bg-[#392d23] text-white rounded-3xl p-6 sm:p-8 space-y-4">
              <span className="text-[11px] font-semibold text-[#f7a48d] tracking-widest uppercase block">
                FOR IMMEDIATE ASSISTANCE
              </span>
              <h3 className="font-serif text-xl font-bold">
                当日のご予約・果物のお取り置き
              </h3>
              <p className="text-xs text-[#d8c8b2] leading-relaxed">
                本日ご利用のお席の空き状況や、数量限定の清水白桃パフェのお取り置きについては、お電話でのお問い合わせが最も確実で即時確定となります。
              </p>
              <div className="pt-2">
                <a
                  href="tel:086-234-5678"
                  className="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#e26d5c] hover:bg-[#b54737] text-white font-bold text-sm transition shadow"
                >
                  <Phone className="w-4 h-4" />
                  <span>086-234-5678</span>
                </a>
              </div>
              <span className="text-[10px] text-[#a48c6f] block">
                受付時間：10:00 〜 18:00（水曜定休日を除く）
              </span>
            </div>

            {/* よくあるご質問 (FAQ アコーディオン) */}
            <div className="bg-white rounded-3xl p-6 sm:p-8 border border-[#e7dac5] shadow-sm space-y-5">
              <div className="flex items-center gap-2 text-[#392d23]">
                <HelpCircle className="w-5 h-5 text-[#e26d5c]" />
                <h3 className="font-serif text-lg font-bold">
                  よくあるご質問（FAQ）
                </h3>
              </div>

              <div className="space-y-3">
                {faqList.slice(0, 4).map((faq, idx) => {
                  const isOpen = openFaqIndex === idx;
                  return (
                    <div
                      key={idx}
                      className="border border-[#f4eee3] rounded-2xl overflow-hidden bg-[#faf7f2]"
                    >
                      <button
                        type="button"
                        onClick={() => toggleFaq(idx)}
                        className="w-full p-3.5 text-left flex items-center justify-between gap-3 text-xs font-bold text-[#392d23] hover:bg-[#f4eee3] transition"
                      >
                        <span className="flex items-center gap-2">
                          <span className="text-[#e26d5c]">Q.</span> {faq.question}
                        </span>
                        <ChevronDown
                          className={`w-4 h-4 text-[#a48c6f] transition-transform duration-200 shrink-0 ${
                            isOpen ? 'rotate-180' : ''
                          }`}
                        />
                      </button>
                      <AnimatePresence>
                        {isOpen && (
                          <motion.div
                            initial={{ height: 0, opacity: 0 }}
                            animate={{ height: 'auto', opacity: 1 }}
                            exit={{ height: 0, opacity: 0 }}
                            transition={{ duration: 0.2 }}
                            className="px-4 pb-3 pt-1 text-xs text-[#6b5a4d] leading-relaxed border-t border-[#f4eee3] bg-white"
                          >
                            <span className="font-bold text-[#6cae54] mr-1">A.</span>
                            {faq.answer}
                          </motion.div>
                        )}
                      </AnimatePresence>
                    </div>
                  );
                })}
              </div>
            </div>
          </div>
        </div>
      </AnimatedSection>
    </div>
  );
};
