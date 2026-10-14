import React from 'react';
import { PageHeader } from '../components/PageHeader';
import { AnimatedSection } from '../components/AnimatedSection';
import { fruitsData, okayamaClimatePoints } from '../data/fruitsData';
import {
  Sun,
  Droplets,
  Wind,
  Award,
  Calendar,
  Sparkles,
  MapPin,
  CheckCircle2,
  Heart
} from 'lucide-react';
import { Link } from 'react-router-dom';

export const FruitsPage: React.FC = () => {
  // アイコンマッピング
  const getIcon = (iconName: string) => {
    switch (iconName) {
      case 'Sun':
        return <Sun className="w-6 h-6 text-[#e26d5c]" />;
      case 'Droplets':
        return <Droplets className="w-6 h-6 text-[#6cae54]" />;
      case 'Wind':
        return <Wind className="w-6 h-6 text-[#574636]" />;
      case 'Award':
        return <Award className="w-6 h-6 text-[#a48c6f]" />;
      default:
        return <Sparkles className="w-6 h-6 text-[#e26d5c]" />;
    }
  };

  return (
    <div className="space-y-16 sm:space-y-24 pb-20">
      <PageHeader
        title="岡山の果物へのこだわり"
        subtitleEn="OKAYAMA FRUITS STORY"
        description="全国に名高い「果物王国・岡山」。なぜ岡山の果物はこれほどまでに甘く芳醇なのか。気候風土の恵みと、代々受け継がれる農家さんの熱い想いをお伝えします。"
        bgGradient="from-[#fde2d9]/60 via-[#faf7f2] to-[#e2f0d9]/60"
      />

      {/* 岡山の果物が美味しい4つの理由 */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center space-y-3 mb-12">
          <span className="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
            WHY OKAYAMA?
          </span>
          <h2 className="font-serif text-2xl sm:text-4xl font-bold text-[#392d23]">
            岡山の果物が極上に育つ4つの理由
          </h2>
          <p className="text-sm text-[#6b5a4d] max-w-xl mx-auto">
            温暖な気候と清流、そして農家さんの繊細な職人技が奇跡の美味しさを生み出します。
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          {okayamaClimatePoints.map((point, idx) => (
            <div
              key={idx}
              className="bg-white rounded-3xl p-6 border border-[#e7dac5] shadow-sm hover:shadow-md transition-shadow space-y-4"
            >
              <div className="w-12 h-12 rounded-2xl bg-[#faf7f2] flex items-center justify-center border border-[#f4eee3]">
                {getIcon(point.icon)}
              </div>
              <h3 className="font-serif text-base font-bold text-[#392d23] leading-snug">
                {point.title}
              </h3>
              <p className="text-xs text-[#6b5a4d] leading-relaxed">
                {point.description}
              </p>
            </div>
          ))}
        </div>
      </AnimatedSection>

      {/* 旬の果物図鑑 */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center space-y-3 mb-14">
          <span className="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
            FRUITS ENCYCLOPEDIA
          </span>
          <h2 className="font-serif text-2xl sm:text-4xl font-bold text-[#392d23]">
            CAFE HAREKA で出会える旬果図鑑
          </h2>
          <p className="text-sm text-[#6b5a4d]">
            それぞれの品種が持つ個性や香りの違いをじっくりとお楽しみください。
          </p>
        </div>

        <div className="space-y-12">
          {fruitsData.map((fruit, idx) => (
            <div
              key={fruit.id}
              className={`bg-white rounded-3xl overflow-hidden border border-[#e7dac5] shadow-sm grid grid-cols-1 lg:grid-cols-12 items-center ${
                idx % 2 === 1 ? 'lg:flex-row-reverse' : ''
              }`}
            >
              <div className={`lg:col-span-6 h-72 sm:h-96 relative bg-[#f4eee3] ${idx % 2 === 1 ? 'lg:order-2' : ''}`}>
                <img
                  src={fruit.image}
                  alt={fruit.name}
                  className="w-full h-full object-cover"
                />
                <div className="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3.5 py-1.5 rounded-full shadow text-xs font-bold text-[#b54737] flex items-center gap-1.5">
                  <Calendar className="w-3.5 h-3.5" />
                  <span>旬：{fruit.season}</span>
                </div>
                <div className="absolute bottom-4 right-4 bg-[#392d23]/80 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-bold">
                  {fruit.sugarBrix}
                </div>
              </div>

              <div className={`lg:col-span-6 p-6 sm:p-10 space-y-5 ${idx % 2 === 1 ? 'lg:order-1' : ''}`}>
                <div className="space-y-1">
                  <div className="text-xs text-[#a48c6f] font-medium tracking-widest uppercase">
                    {fruit.reading}
                  </div>
                  <h3 className="font-serif text-2xl sm:text-3xl font-bold text-[#392d23]">
                    {fruit.name}
                  </h3>
                  <div className="text-xs text-[#4a8235] font-semibold flex items-center gap-1 pt-1">
                    <MapPin className="w-3.5 h-3.5" /> 提携：{fruit.farm}
                  </div>
                </div>

                <p className="text-xs sm:text-sm text-[#6b5a4d] leading-relaxed">
                  {fruit.description}
                </p>

                <div className="space-y-2 pt-2 border-t border-[#f4eee3]">
                  <span className="text-xs font-bold text-[#392d23] block">美味しさの特徴</span>
                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    {fruit.features.map((feature, fIdx) => (
                      <div key={fIdx} className="flex items-center gap-2 text-xs text-[#574636]">
                        <CheckCircle2 className="w-3.5 h-3.5 text-[#e26d5c] shrink-0" />
                        <span>{feature}</span>
                      </div>
                    ))}
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </AnimatedSection>

      {/* 契約農家さんインタビュー・コラム */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="bg-[#f4eee3] rounded-3xl p-8 sm:p-12 border border-[#e7dac5]">
          <div className="max-w-3xl mx-auto space-y-6">
            <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white text-[#b54737] text-xs font-bold shadow-sm">
              <Heart className="w-3.5 h-3.5 fill-current" />
              <span>契約果樹園インタビュー</span>
            </div>
            <h3 className="font-serif text-2xl sm:text-3xl font-bold text-[#392d23] leading-snug">
              「手塩にかけた桃を、いちばん幸せな瞬間に食べてもらいたい。」
            </h3>
            <div className="text-xs sm:text-sm text-[#6b5a4d] leading-relaxed space-y-3">
              <p>
                「岡山の白桃は、陽の光を直接当てないように1玉ずつ袋を被せて育てます。真夏の炎天下での作業は骨が折れますが、透き通るような白い肌と、口に入れた時の果汁の甘さを味わってもらった時の笑顔が何よりの励みです。」
              </p>
              <p>
                「HAREKAさんでは、私たちが朝収穫した桃をその日のうちにパフェやスイーツにしてお客様へ届けてくれます。農家冥利に尽きる取り組みです。」
              </p>
            </div>
            <div className="pt-2 text-xs font-semibold text-[#574636]">
              赤磐市 吉井果樹園 代表 / 吉井 誠一さん
            </div>
          </div>
        </div>
      </AnimatedSection>

      {/* メニューへ誘導 */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div className="p-8 sm:p-12 rounded-3xl bg-white border border-[#e7dac5] space-y-4">
          <h3 className="font-serif text-xl sm:text-2xl font-bold text-[#392d23]">
            これらの果実をふんだんに使ったスイーツはいかがですか？
          </h3>
          <p className="text-xs sm:text-sm text-[#6b5a4d]">
            パフェ、タルト、パンケーキ、クラフトスカッシュなど、多彩なメニューをご用意しています。
          </p>
          <div className="pt-2">
            <Link
              to="/menu"
              className="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-gradient-to-r from-[#e26d5c] to-[#b54737] text-white font-medium text-sm shadow hover:shadow-lg transition"
            >
              <span>旬果メニュー一覧を見る</span>
            </Link>
          </div>
        </div>
      </AnimatedSection>
    </div>
  );
};
