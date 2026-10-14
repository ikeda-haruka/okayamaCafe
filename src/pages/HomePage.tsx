import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import {
  Sparkles,
  ChevronRight,
  Calendar,
  Utensils,
  MapPin,
  ArrowRight,
  HeartHandshake,
  SunMedium,
  Trees
} from 'lucide-react';
import { menuItems } from '../data/menuData';
import { newsList as initialNewsList } from '../data/newsData';
import { fetchWpNews } from '../services/wordpress';
import { AnimatedSection } from '../components/AnimatedSection';

export const HomePage: React.FC = () => {
  const [news, setNews] = useState(initialNewsList);

  useEffect(() => {
    fetchWpNews().then((data) => {
      if (data && data.length > 0) {
        setNews(data);
      }
    });
  }, []);

  // ピックアップメニュー
  const featuredMenu = menuItems.filter((m) =>
    ['sweet-1', 'sweet-2', 'lunch-1'].includes(m.id)
  );

  return (
    <div className="space-y-20 sm:space-y-28 overflow-hidden pb-16">
      {/* ヒーローセクション */}
      <section className="relative min-h-[85vh] sm:min-h-[90vh] flex items-center justify-center bg-gradient-to-br from-[#fde2d9]/50 via-[#faf7f2] to-[#e2f0d9]/50 px-4 sm:px-6 lg:px-8 py-16">
        {/* 背景装飾ブラー円 */}
        <div className="absolute top-1/4 left-10 w-72 h-72 rounded-full bg-[#fbc6b6]/30 blur-3xl pointer-events-none" />
        <div className="absolute bottom-10 right-10 w-96 h-96 rounded-full bg-[#a9d997]/25 blur-3xl pointer-events-none" />

        <div className="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10">
          {/* テキストコンテンツ */}
          <div className="lg:col-span-7 space-y-6 text-center lg:text-left">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
              className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/90 border border-[#fbc6b6] shadow-sm text-xs text-[#b54737] font-medium"
            >
              <Sparkles className="w-3.5 h-3.5 text-[#e26d5c]" />
              <span>2026年秋・岡山県北区吉備津にグランドオープン</span>
            </motion.div>

            <motion.div
              initial={{ opacity: 0, y: 25 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.7, delay: 0.1 }}
              className="space-y-3"
            >
              <p className="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#a48c6f] uppercase">
                Okayama Local Fruits & Slow Time
              </p>
              <h1 className="font-serif text-3xl sm:text-5xl lg:text-6xl font-bold text-[#392d23] leading-[1.25] tracking-wide">
                晴れの国の太陽と、<br />
                <span className="text-[#b54737] relative inline-block">
                  樹上のめぐみ
                  <span className="absolute bottom-1 left-0 w-full h-2.5 bg-[#fde2d9] -z-10 rounded"></span>
                </span>
                をそのままに。
              </h1>
            </motion.div>

            <motion.p
              initial={{ opacity: 0, y: 25 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.7, delay: 0.2 }}
              className="text-sm sm:text-base text-[#6b5a4d] leading-relaxed max-w-xl mx-auto lg:mx-0"
            >
              岡山の大地と農家さんが手塩にかけて育てた白桃やシャインマスカット。
              木漏れ日あふれる温かな空間で、ここ岡山でしか出逢えない
              瑞々しい旬のスイーツと穏やかなカフェ時間をお届けします。
            </motion.p>

            <motion.div
              initial={{ opacity: 0, y: 25 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.7, delay: 0.3 }}
              className="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3.5 pt-2"
            >
              <Link
                to="/menu"
                className="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-full bg-gradient-to-r from-[#e26d5c] to-[#b54737] text-white font-medium text-sm shadow-md hover:shadow-lg hover:brightness-105 transition active:scale-95"
              >
                <Utensils className="w-4 h-4" />
                <span>旬のメニューを見る</span>
              </Link>
              <Link
                to="/about"
                className="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-full bg-white border border-[#d8c8b2] text-[#574636] font-medium text-sm hover:bg-[#f4eee3] transition"
              >
                <span>HAREKAのこだわり</span>
                <ChevronRight className="w-4 h-4 text-[#a48c6f]" />
              </Link>
            </motion.div>

            {/* 本日の入荷速報ミニカード */}
            <motion.div
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              transition={{ duration: 0.8, delay: 0.4 }}
              className="pt-4"
            >
              <div className="inline-flex items-center gap-3 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-2xl border border-[#e7dac5] text-xs text-[#574636]">
                <span className="w-2 h-2 rounded-full bg-[#6cae54] animate-pulse"></span>
                <span className="font-semibold text-[#b54737]">本日の産直入荷</span>
                <span className="text-[#6b5a4d]">赤磐市吉井果樹園より「清水白桃」朝採れ到着（糖度14.8度）</span>
              </div>
            </motion.div>
          </div>

          {/* ヒーロービジュアル（複合カード演出） */}
          <div className="lg:col-span-5 relative">
            <motion.div
              initial={{ opacity: 0, scale: 0.95 }}
              animate={{ opacity: 1, scale: 1 }}
              transition={{ duration: 0.8 }}
              className="relative mx-auto max-w-md lg:max-w-none"
            >
              {/* メイン画像カード */}
              <div className="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-white">
                <img
                  src="/images/peach_parfait.jpg"
                  alt="岡山県産 清水白桃パフェ"
                  className="w-full h-[400px] sm:h-[480px] object-cover hover:scale-105 transition-transform duration-700"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex flex-col justify-end p-6 text-white">
                  <span className="text-[11px] font-semibold tracking-wider bg-[#b54737] text-white px-2.5 py-0.5 rounded-full w-fit mb-1">
                    看板スイーツ
                  </span>
                  <h3 className="font-serif text-xl sm:text-2xl font-bold">
                    岡山県産 清水白桃の極上パフェ
                  </h3>
                  <p className="text-xs text-[#fde2d9] mt-1">
                    朝採れの芳醇な果汁と蒜山ジャージーソフトの口どけ
                  </p>
                </div>
              </div>

              {/* フローティングバッジ 1（シャインマスカット） */}
              <motion.div
                animate={{ y: [0, -8, 0] }}
                transition={{ duration: 4, repeat: Infinity, ease: 'easeInOut' }}
                className="absolute -top-4 -left-4 sm:-left-8 bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-xl border border-[#e7dac5] flex items-center gap-3"
              >
                <div className="w-10 h-10 rounded-xl bg-[#e2f0d9] overflow-hidden flex items-center justify-center shrink-0 border border-[#a9d997]/50">
                  <img
                    src="/images/shine_muscat_vine.jpg"
                    alt="晴王 シャインマスカット"
                    className="w-full h-full object-cover"
                  />
                </div>
                <div>
                  <div className="text-[10px] text-[#a48c6f] font-semibold uppercase">Okayama Muscat</div>
                  <div className="text-xs font-bold text-[#392d23]">晴王（シャインマスカット）</div>
                  <div className="text-[10px] text-[#6cae54] font-medium">糖度18度以上の最高峰</div>
                </div>
              </motion.div>

              {/* フローティングバッジ 2（店舗情報） */}
              <motion.div
                animate={{ y: [0, 8, 0] }}
                transition={{ duration: 5, repeat: Infinity, ease: 'easeInOut' }}
                className="absolute -bottom-6 -right-4 sm:-right-6 bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-xl border border-[#e7dac5] flex items-center gap-3"
              >
                <div className="w-10 h-10 rounded-xl bg-[#fde2d9] flex items-center justify-center text-xl">
                  🌿
                </div>
                <div>
                  <div className="text-xs font-bold text-[#392d23]">ガーデンテラス完備</div>
                  <div className="text-[10px] text-[#a48c6f]">ペット同伴可 / 駐車場20台無料</div>
                </div>
              </motion.div>
            </motion.div>
          </div>
        </div>
      </section>

      {/* 3つのコンセプトセクション */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center space-y-3 mb-14">
          <span className="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
            CONCEPT
          </span>
          <h2 className="font-serif text-2xl sm:text-4xl font-bold text-[#392d23]">
            CAFE HAREKA が大切にすること
          </h2>
          <p className="text-sm text-[#6b5a4d] max-w-xl mx-auto">
            岡山という土地が持つ豊かな恵みと、訪れるすべての人の心がほどける時間をお約束します。
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {/* 特徴1 */}
          <div className="bg-white rounded-3xl p-8 border border-[#e7dac5]/80 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
            <div className="space-y-4">
              <div className="w-14 h-14 rounded-2xl bg-[#fde2d9] flex items-center justify-center text-[#e26d5c] group-hover:scale-110 transition-transform">
                <SunMedium className="w-7 h-7" />
              </div>
              <span className="text-xs font-bold text-[#a48c6f] tracking-widest block">01 / LOCAL FRUITS</span>
              <h3 className="font-serif text-xl font-bold text-[#392d23]">
                契約果樹園から届く<br />樹上完熟の果物
              </h3>
              <p className="text-sm text-[#6b5a4d] leading-relaxed">
                赤磐や倉敷の契約農家さんと直接繋がり、最も香りと糖度が高まった「一番おいしい瞬間」の果物を仕入れています。市場に出回る前の、採れたての瑞々しさをご堪能ください。
              </p>
            </div>
            <div className="pt-6 border-t border-[#f4eee3] mt-6">
              <span className="text-xs text-[#b54737] font-semibold flex items-center gap-1">
                白桃・晴王・ピオーネ・足守メロン
              </span>
            </div>
          </div>

          {/* 特徴2 */}
          <div className="bg-white rounded-3xl p-8 border border-[#e7dac5]/80 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
            <div className="space-y-4">
              <div className="w-14 h-14 rounded-2xl bg-[#e2f0d9] flex items-center justify-center text-[#6cae54] group-hover:scale-110 transition-transform">
                <Trees className="w-7 h-7" />
              </div>
              <span className="text-xs font-bold text-[#a48c6f] tracking-widest block">02 / SLOW SPACE</span>
              <h3 className="font-serif text-xl font-bold text-[#392d23]">
                木漏れ日と自然を感じる<br />居心地のよい空間
              </h3>
              <p className="text-sm text-[#6b5a4d] leading-relaxed">
                岡山県産木材をふんだんに使用した温もりある店内と、緑の風が通り抜ける開放的なガーデンテラス。ひとり時間も、大切な人との語らいも、気兼ねなくのんびり過ごせます。
              </p>
            </div>
            <div className="pt-6 border-t border-[#f4eee3] mt-6">
              <span className="text-xs text-[#4a8235] font-semibold flex items-center gap-1">
                テラス席ペット同伴可 / Free Wi-Fi完備
              </span>
            </div>
          </div>

          {/* 特徴3 */}
          <div className="bg-white rounded-3xl p-8 border border-[#e7dac5]/80 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
            <div className="space-y-4">
              <div className="w-14 h-14 rounded-2xl bg-[#f4eee3] flex items-center justify-center text-[#a48c6f] group-hover:scale-110 transition-transform">
                <HeartHandshake className="w-7 h-7" />
              </div>
              <span className="text-xs font-bold text-[#a48c6f] tracking-widest block">03 / ALL OKAYAMA</span>
              <h3 className="font-serif text-xl font-bold text-[#392d23]">
                スイーツだけでなく<br />岡山自慢のランチプレート
              </h3>
              <p className="text-sm text-[#6b5a4d] leading-relaxed">
                日本最古の蔓牛「千屋牛」や、全国的に名高い「吉田牧場」のチーズ、県産無農薬野菜など、岡山が誇る上質な素材を使った手作りランチも豊富にご用意しています。
              </p>
            </div>
            <div className="pt-6 border-t border-[#f4eee3] mt-6">
              <span className="text-xs text-[#a48c6f] font-semibold flex items-center gap-1">
                千屋牛・吉田牧場チーズ・蒜山ジャージー
              </span>
            </div>
          </div>
        </div>
      </AnimatedSection>

      {/* 旬のピックアップメニュー */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
          <div className="space-y-2">
            <span className="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
              RECOMMENDED MENU
            </span>
            <h2 className="font-serif text-2xl sm:text-4xl font-bold text-[#392d23]">
              今月のおすすめメニュー
            </h2>
            <p className="text-sm text-[#6b5a4d]">
              岡山県内から届く旬の果実と食材を使った限定メニューをご紹介します。
            </p>
          </div>
          <Link
            to="/menu"
            className="inline-flex items-center gap-2 text-sm font-semibold text-[#b54737] hover:gap-3 transition-all"
          >
            <span>すべてのメニューを見る（全12種）</span>
            <ArrowRight className="w-4 h-4" />
          </Link>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {featuredMenu.map((item) => (
            <div
              key={item.id}
              className="bg-white rounded-3xl overflow-hidden border border-[#e7dac5] shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col"
            >
              <div className="relative h-60 overflow-hidden bg-[#f4eee3]">
                <img
                  src={item.image}
                  alt={item.name}
                  className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
                {item.seasonal && (
                  <span className="absolute top-4 left-4 bg-[#e26d5c] text-white text-[11px] font-bold px-3 py-1 rounded-full shadow">
                    旬果限定
                  </span>
                )}
                {item.sugarContent && (
                  <span className="absolute top-4 right-4 bg-white/95 text-[#4a8235] text-[11px] font-semibold px-2.5 py-1 rounded-full shadow">
                    {item.sugarContent}
                  </span>
                )}
              </div>
              <div className="p-6 flex-1 flex flex-col justify-between space-y-4">
                <div className="space-y-2">
                  <div className="text-[11px] text-[#a48c6f] font-medium flex items-center gap-1">
                    <MapPin className="w-3 h-3 text-[#e26d5c]" />
                    {item.farmOrigin}
                  </div>
                  <h3 className="font-serif text-lg font-bold text-[#392d23] group-hover:text-[#b54737] transition-colors">
                    {item.name}
                  </h3>
                  <p className="text-xs text-[#6b5a4d] leading-relaxed line-clamp-3">
                    {item.description}
                  </p>
                </div>
                <div className="pt-4 border-t border-[#f4eee3] flex items-center justify-between">
                  <span className="text-xs text-[#a48c6f]">税込</span>
                  <span className="font-serif text-xl font-bold text-[#392d23]">
                    ¥{item.price.toLocaleString()}
                  </span>
                </div>
              </div>
            </div>
          ))}
        </div>
      </AnimatedSection>

      {/* 岡山の果物 特集バナーエリア */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="relative rounded-3xl overflow-hidden bg-[#392d23] text-white p-8 sm:p-12 lg:p-16">
          {/* 背景画像薄めオーバーレイ */}
          <div
            className="absolute inset-0 bg-cover bg-center opacity-30 mix-blend-overlay"
            style={{
              backgroundImage: `url('/images/shine_muscat_vine.jpg')`,
            }}
          />
          <div className="relative z-10 max-w-2xl space-y-6">
            <span className="text-xs font-semibold tracking-[0.3em] text-[#f7a48d] uppercase">
              OKAYAMA FRUITS STORY
            </span>
            <h2 className="font-serif text-2xl sm:text-4xl font-bold leading-snug">
              なぜ、岡山の果物は<br />世界中を虜にするのか。
            </h2>
            <p className="text-xs sm:text-sm text-[#d8c8b2] leading-relaxed">
              晴れの国の豊かな陽光、三大河川の清らかな水、そして明治から受け継がれる「一果一袋」の職人技。<br />
              甘み、香り、みずみずしさ——すべてが極限まで磨かれた岡山フルーツの物語を紐解きます。
            </p>
            <div className="pt-2">
              <Link
                to="/fruits"
                className="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-white text-[#392d23] font-semibold text-sm hover:bg-[#fde2d9] transition shadow"
              >
                <span>岡山の果物・契約農家のこだわりへ</span>
                <ChevronRight className="w-4 h-4" />
              </Link>
            </div>
          </div>
        </div>
      </AnimatedSection>

      {/* カフェ空間フォトギャラリー */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center space-y-3 mb-10">
          <span className="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
            ATMOSPHERE
          </span>
          <h2 className="font-serif text-2xl sm:text-4xl font-bold text-[#392d23]">
            木の香りと光に満ちた、心地よい場所
          </h2>
          <p className="text-sm text-[#6b5a4d] max-w-xl mx-auto">
            日常を離れて、ほっとひと息。お一人でも、ご家族でもゆったり寛げる空間です。
          </p>
        </div>

        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div className="rounded-2xl overflow-hidden shadow-sm h-48 sm:h-64">
            <img
              src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=600&q=80"
              alt="温もりある木目の店内カフェ席"
              className="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
            />
          </div>
          <div className="rounded-2xl overflow-hidden shadow-sm h-48 sm:h-64">
            <img
              src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=600&q=80"
              alt="緑が広がるテラス席"
              className="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
            />
          </div>
          <div className="rounded-2xl overflow-hidden shadow-sm h-48 sm:h-64">
            <img
              src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=600&q=80"
              alt="バリスタが淹れるスペシャルティコーヒー"
              className="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
            />
          </div>
          <div className="rounded-2xl overflow-hidden shadow-sm h-48 sm:h-64">
            <img
              src="https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?auto=format&fit=crop&w=600&q=80"
              alt="自家製フルーツシロップドリンク"
              className="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
            />
          </div>
        </div>
      </AnimatedSection>

      {/* お知らせ・News */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="bg-white rounded-3xl p-6 sm:p-10 border border-[#e7dac5] shadow-sm">
          <div className="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-[#f4eee3] mb-6 gap-3">
            <div>
              <span className="text-xs font-semibold tracking-widest text-[#a48c6f] uppercase block">
                NEWS & TOPICS
              </span>
              <h3 className="font-serif text-xl sm:text-2xl font-bold text-[#392d23]">
                店舗からのお知らせ
              </h3>
            </div>
            <div className="flex items-center gap-4">
              <span className="text-xs text-[#a48c6f] hidden sm:inline">最新の入荷・営業カレンダー</span>
              <Link
                to="/news"
                className="inline-flex items-center gap-1 text-xs font-semibold text-[#b54737] hover:underline"
              >
                <span>すべてのお知らせを見る</span>
                <ChevronRight className="w-3.5 h-3.5" />
              </Link>
            </div>
          </div>

          <div className="divide-y divide-[#f4eee3]">
            {news.map((item) => (
              <div key={item.id} className="py-4 flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-6">
                <div className="flex items-center gap-3 shrink-0">
                  <span className="text-xs font-medium text-[#a48c6f]">{item.date}</span>
                  <span
                    className={`text-[11px] font-semibold px-2.5 py-0.5 rounded-full ${
                      item.category === '旬の入荷'
                        ? 'bg-[#e2f0d9] text-[#4a8235]'
                        : item.category === 'お知らせ'
                        ? 'bg-[#fde2d9] text-[#b54737]'
                        : 'bg-[#f4eee3] text-[#574636]'
                    }`}
                  >
                    {item.category}
                  </span>
                </div>
                <div className="text-sm font-medium text-[#392d23] hover:text-[#b54737] transition cursor-pointer">
                  {item.title}
                </div>
              </div>
            ))}
          </div>
        </div>
      </AnimatedSection>

      {/* アクセス＆予約のCTAセクション */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="bg-gradient-to-r from-[#fde2d9] to-[#e2f0d9] rounded-3xl p-8 sm:p-12 border border-[#e7dac5] flex flex-col lg:flex-row items-center justify-between gap-8">
          <div className="space-y-3 text-center lg:text-left">
            <span className="inline-block bg-white/90 text-[#b54737] text-xs font-bold px-3 py-1 rounded-full shadow-sm">
              観光・ドライブの立ち寄りに最適
            </span>
            <h2 className="font-serif text-2xl sm:text-3xl font-bold text-[#392d23]">
              岡山へのご旅行や週末のカフェ巡りに。
            </h2>
            <p className="text-sm text-[#6b5a4d] max-w-xl">
              吉備津神社から車で2分、岡山ICから15分。無料駐車場20台を完備しております。<br />
              県内外問わず、皆さまのご来店を心よりお待ちしております。
            </p>
          </div>
          <div className="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
            <Link
              to="/contact"
              className="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-[#b54737] hover:bg-[#a0392b] text-white font-medium text-sm shadow-md transition"
            >
              <Calendar className="w-4 h-4" />
              <span>お席のご予約はこちら</span>
            </Link>
            <Link
              to="/access"
              className="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-full bg-white hover:bg-[#faf7f2] text-[#392d23] font-medium text-sm shadow-sm transition border border-[#d8c8b2]"
            >
              <MapPin className="w-4 h-4" />
              <span>アクセス・地図</span>
            </Link>
          </div>
        </div>
      </AnimatedSection>
    </div>
  );
};
