import React, { useState } from 'react';
import { PageHeader } from '../components/PageHeader';
import { AnimatedSection } from '../components/AnimatedSection';
import { menuItems } from '../data/menuData';
import {
  ShoppingBag,
  MapPin,
  Info,
  Calendar
} from 'lucide-react';


export const MenuPage: React.FC = () => {
  const [activeTab, setActiveTab] = useState<'all' | 'sweets' | 'lunch' | 'drinks' | 'takeout'>('all');

  const filteredItems = activeTab === 'all'
    ? menuItems
    : menuItems.filter((item) => item.category === activeTab);

  const categories = [
    { key: 'all', label: 'すべて', en: 'ALL' },
    { key: 'sweets', label: '旬果スイーツ', en: 'SWEETS' },
    { key: 'lunch', label: 'ランチ・軽食', en: 'LUNCH' },
    { key: 'drinks', label: 'ドリンク', en: 'DRINKS' },
    { key: 'takeout', label: 'テイクアウト・ギフト', en: 'TAKEOUT' },
  ];

  return (
    <div className="space-y-16 sm:space-y-20 pb-20">
      <PageHeader
        title="カフェメニュー"
        subtitleEn="OUR MENU"
        description="岡山の大自然が育んだ果実や、千屋牛・吉田牧場チーズなど選りすぐりの県産食材を贅沢に使用。朝採れの瑞々しさをそのまま味わえる手作りメニューです。"
      />

      {/* フルーツ提供カレンダーインフォ */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="bg-white rounded-3xl p-6 sm:p-8 border border-[#e7dac5] shadow-sm">
          <div className="flex items-center gap-2 text-[#b54737] font-semibold text-xs mb-3">
            <Calendar className="w-4 h-4" />
            <span>季節の果物 リレーカレンダー（現在の旬をチェック）</span>
          </div>
          <div className="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
            <div className="p-3 rounded-2xl bg-[#fef2ee] border border-[#fbc6b6]/50">
              <span className="font-bold text-[#b54737] block">🍑 7月〜8月</span>
              <span className="font-medium text-[#392d23] block text-sm">清水白桃 / 白鳳</span>
              <span className="text-[10px] text-[#6b5a4d]">上品な甘みと溢れる果汁</span>
            </div>
            <div className="p-3 rounded-2xl bg-[#f4f8f0] border border-[#a9d997]/50">
              <span className="font-bold text-[#4a8235] block">🍇 7月〜10月</span>
              <span className="font-medium text-[#392d23] block text-sm">シャインマスカット晴王</span>
              <span className="text-[10px] text-[#6b5a4d]">皮ごとパリッと高糖度18度</span>
            </div>
            <div className="p-3 rounded-2xl bg-[#faf7f2] border border-[#d8c8b2]">
              <span className="font-bold text-[#574636] block">🍇 8月〜10月</span>
              <span className="font-medium text-[#392d23] block text-sm">ニューピオーネ</span>
              <span className="text-[10px] text-[#6b5a4d]">大粒でジューシーな黒真珠</span>
            </div>
            <div className="p-3 rounded-2xl bg-[#fef2ee] border border-[#fbc6b6]/50">
              <span className="font-bold text-[#e26d5c] block">🍓 12月〜5月</span>
              <span className="font-medium text-[#392d23] block text-sm">晴苺（はれいちご）</span>
              <span className="text-[10px] text-[#6b5a4d]">色鮮やかで濃厚な甘酸っぱさ</span>
            </div>
          </div>
        </div>
      </AnimatedSection>

      {/* カテゴリ切り替えタブ */}
      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex flex-wrap justify-center gap-2 sm:gap-3 mb-10">
          {categories.map((cat) => (
            <button
              key={cat.key}
              onClick={() => setActiveTab(cat.key as any)}
              className={`px-5 py-2.5 rounded-full text-xs sm:text-sm font-medium transition-all duration-200 cursor-pointer ${
                activeTab === cat.key
                  ? 'bg-[#392d23] text-white shadow-md scale-105'
                  : 'bg-white text-[#574636] border border-[#e7dac5] hover:bg-[#f4eee3]'
              }`}
            >
              <span>{cat.label}</span>
              <span className="text-[10px] opacity-70 ml-1.5 font-normal tracking-wider">
                {cat.en}
              </span>
            </button>
          ))}
        </div>

        {/* メニューカード一覧 */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {filteredItems.map((item) => (
            <div
              key={item.id}
              className="bg-white rounded-3xl overflow-hidden border border-[#e7dac5] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group"
            >
              <div className="relative h-64 overflow-hidden bg-[#f4eee3]">
                <img
                  src={item.image}
                  alt={item.name}
                  className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                />

                {/* バッジ群 */}
                <div className="absolute top-3 left-3 flex flex-wrap gap-1.5">
                  {item.seasonal && (
                    <span className="bg-[#e26d5c] text-white text-[11px] font-bold px-2.5 py-0.5 rounded-full shadow-sm">
                      季節限定
                    </span>
                  )}
                  {item.takeout && (
                    <span className="bg-[#392d23]/80 backdrop-blur-sm text-white text-[11px] font-medium px-2 py-0.5 rounded-full flex items-center gap-1">
                      <ShoppingBag className="w-3 h-3" /> お持帰り可
                    </span>
                  )}
                </div>

                {item.sugarContent && (
                  <span className="absolute top-3 right-3 bg-white/95 backdrop-blur-sm text-[#4a8235] text-[11px] font-bold px-2.5 py-0.5 rounded-full shadow-sm">
                    {item.sugarContent}
                  </span>
                )}
              </div>

              <div className="p-6 flex-1 flex flex-col justify-between space-y-4">
                <div className="space-y-3">
                  {item.farmOrigin && (
                    <div className="text-[11px] font-medium text-[#a48c6f] flex items-center gap-1">
                      <MapPin className="w-3 h-3 text-[#e26d5c]" />
                      <span>{item.farmOrigin}</span>
                    </div>
                  )}

                  <h3 className="font-serif text-lg font-bold text-[#392d23] group-hover:text-[#b54737] transition-colors leading-snug">
                    {item.name}
                  </h3>

                  <p className="text-xs text-[#6b5a4d] leading-relaxed">
                    {item.description}
                  </p>

                  {item.tags && (
                    <div className="flex flex-wrap gap-1.5 pt-1">
                      {item.tags.map((tag, idx) => (
                        <span
                          key={idx}
                          className="bg-[#faf7f2] text-[#8c735d] text-[10px] font-medium px-2 py-0.5 rounded border border-[#e7dac5]"
                        >
                          #{tag}
                        </span>
                      ))}
                    </div>
                  )}
                </div>

                <div className="pt-4 border-t border-[#f4eee3] flex items-center justify-between">
                  <span className="text-xs text-[#a48c6f]">税込価格</span>
                  <span className="font-serif text-2xl font-bold text-[#392d23]">
                    ¥{item.price.toLocaleString()}
                  </span>
                </div>
              </div>
            </div>
          ))}
        </div>
      </section>

      {/* アレルギーおよび素材表記に関するご案内 */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="bg-[#f4eee3] rounded-3xl p-6 sm:p-8 border border-[#e7dac5] flex items-start gap-4">
          <Info className="w-5 h-5 text-[#a48c6f] shrink-0 mt-0.5" />
          <div className="text-xs text-[#6b5a4d] space-y-1.5 leading-relaxed">
            <h4 className="font-bold text-[#392d23]">メニューに関するご案内とお願い</h4>
            <p>
              ・天候や収穫状況により、果物の品種や提供期間が予告なく変更となる場合がございます。
            </p>
            <p>
              ・アレルギーをお持ちのお客様は、ご注文の際にお気軽にスタッフまでご相談ください。特定原材料7品目に対応した一覧をご用意しております。
            </p>
            <p>
              ・パフェや生果実は鮮度を第一としているため、一部テイクアウトに対応していない商品がございます。
            </p>
          </div>
        </div>
      </AnimatedSection>
    </div>
  );
};
