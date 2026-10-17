import React from 'react';
import { PageHeader } from '../components/PageHeader';
import { AnimatedSection } from '../components/AnimatedSection';
import { Sparkles, CheckCircle } from 'lucide-react';


export const AboutPage: React.FC = () => {
  return (
    <div className="space-y-16 sm:space-y-24 pb-20">
      <PageHeader
        title="お店について"
        subtitleEn="ABOUT CAFE HAREKA"
        description="晴れの国・岡山の豊かな自然と、太陽の恵みを浴びて育った果実たち。私たちのカフェが目指す、温かな時間と地産地消の約束をご紹介します。"
      />

      {/* コンセプトストーリー */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
          <div className="lg:col-span-6 relative">
            <div className="rounded-3xl overflow-hidden shadow-xl border-4 border-white bg-white">
              <img
                src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=1000&q=80"
                alt="CAFE HAREKA 店内風景"
                className="w-full h-[400px] sm:h-[480px] object-cover"
              />
            </div>
            <div className="absolute -bottom-6 -right-6 bg-white p-5 rounded-2xl shadow-xl border border-[#e7dac5] max-w-xs hidden sm:block">
              <div className="flex items-center gap-2 text-[#e26d5c] mb-1">
                <Sparkles className="w-4 h-4" />
                <span className="text-xs font-bold">2026年秋 NEW OPEN</span>
              </div>
              <p className="text-xs text-[#574636] leading-relaxed">
                岡山県産ヒノキの香るカウンターと、緑あふれる開放的なテラス席。
              </p>
            </div>
          </div>

          <div className="lg:col-span-6 space-y-6">
            <span className="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
              OUR STORY
            </span>
            <h2 className="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-[#392d23] leading-snug">
              「晴れの国の果実は、<br />
              世界でいちばん優しい味がする。」
            </h2>
            <div className="space-y-4 text-sm text-[#6b5a4d] leading-relaxed">
              <p>
                岡山県で生まれ育った私たちにとって、夏に食べる瑞々しい白桃や、秋に弾けるシャインマスカットは、いつも特別な喜びと思い出の真ん中にありました。
              </p>
              <p>
                しかし、全国的には「高級ギフト」として流通することが多く、収穫されたばかりの“本当の樹上完熟のおいしさ”をその場で味わえる場所は、意外にも多くありませんでした。
              </p>
              <p>
                「生産者さんが情熱を注いだ果物を、もっと身近に、最高においしい状態で味わってほしい。」
                「地元の方はもちろん、県外から岡山を訪れた旅人にも、この土地の温もりを感じて帰ってほしい。」
              </p>
              <p>
                そんな想いから、地元の契約果樹園さんと手を取り合い、『CAFE HAREKA（晴果）』をオープンしました。
              </p>
            </div>
          </div>
        </div>
      </AnimatedSection>

      {/* 3つのこだわり */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center space-y-3 mb-14">
          <span className="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
            OUR COMMITMENT
          </span>
          <h2 className="font-serif text-2xl sm:text-4xl font-bold text-[#392d23]">
            CAFE HAREKA の3つのこだわり
          </h2>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {/* こだわり1 */}
          <div className="bg-white rounded-3xl p-8 border border-[#e7dac5] shadow-sm space-y-5">
            <div className="w-12 h-12 rounded-2xl bg-[#fde2d9] text-[#e26d5c] flex items-center justify-center font-bold text-lg">
              01
            </div>
            <h3 className="font-serif text-xl font-bold text-[#392d23]">
              生産者の顔が見える<br />産地直送・樹上完熟果実
            </h3>
            <p className="text-sm text-[#6b5a4d] leading-relaxed">
              赤磐、倉敷、新見などの契約農家から毎朝直接仕入れ。完熟ギリギリまで太陽を浴びた果実だけを厳選し、ピューレやシロップも保存料不使用の自家製で仕上げています。
            </p>
            <div className="flex items-center gap-2 text-xs font-semibold text-[#b54737] pt-2">
              <CheckCircle className="w-4 h-4" /> 毎朝の糖度測定・品質確認
            </div>
          </div>

          {/* こだわり2 */}
          <div className="bg-white rounded-3xl p-8 border border-[#e7dac5] shadow-sm space-y-5">
            <div className="w-12 h-12 rounded-2xl bg-[#e2f0d9] text-[#6cae54] flex items-center justify-center font-bold text-lg">
              02
            </div>
            <h3 className="font-serif text-xl font-bold text-[#392d23]">
              自然と調和する<br />居心地のよい木造空間
            </h3>
            <p className="text-sm text-[#6b5a4d] leading-relaxed">
              内装には岡山県産材（美作ヒノキ・県産杉）を贅沢に使用。大きな窓から陽光が差し込み、風が抜けるテラス席はペット連れの方にも開放。誰もがほっと息を抜けるオアシスです。
            </p>
            <div className="flex items-center gap-2 text-xs font-semibold text-[#4a8235] pt-2">
              <CheckCircle className="w-4 h-4" /> 全42席・バリアフリー対応
            </div>
          </div>

          {/* こだわり3 */}
          <div className="bg-white rounded-3xl p-8 border border-[#e7dac5] shadow-sm space-y-5">
            <div className="w-12 h-12 rounded-2xl bg-[#f4eee3] text-[#a48c6f] flex items-center justify-center font-bold text-lg">
              03
            </div>
            <h3 className="font-serif text-xl font-bold text-[#392d23]">
              地産地消の循環と<br />フードロスへの取り組み
            </h3>
            <p className="text-sm text-[#6b5a4d] leading-relaxed">
              形やサイズが規格外でも味は絶品の果実は、コンフィチュールや焼き菓子、自家製シロップへと大切にアップサイクル。生産者さんへの還元と環境への優しさを両立しています。
            </p>
            <div className="flex items-center gap-2 text-xs font-semibold text-[#574636] pt-2">
              <CheckCircle className="w-4 h-4" /> 果実ロスゼロのレシピ開発
            </div>
          </div>
        </div>
      </AnimatedSection>

      {/* 店内空間・設備ガイド */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="bg-white rounded-3xl p-8 sm:p-12 border border-[#e7dac5] shadow-sm">
          <div className="max-w-2xl mx-auto text-center space-y-3 mb-10">
            <span className="text-xs font-semibold tracking-widest text-[#a48c6f] uppercase">
              FACILITIES & COMFORTS
            </span>
            <h2 className="font-serif text-2xl sm:text-3xl font-bold text-[#392d23]">
              心地よくお過ごしいただくための設備
            </h2>
            <p className="text-sm text-[#6b5a4d]">
              赤ちゃん連れのご家族から、お一人でのんびり読書したい方、愛犬とお散歩途中の立ち寄りまで大歓迎です。
            </p>
          </div>

          <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 text-center">
            <div className="p-4 rounded-2xl bg-[#faf7f2] border border-[#f4eee3] space-y-2">
              <div className="w-10 h-10 mx-auto rounded-full bg-[#fde2d9] text-[#e26d5c] flex items-center justify-center">
                🐶
              </div>
              <h4 className="text-xs font-bold text-[#392d23]">テラス席ペット可</h4>
              <p className="text-[11px] text-[#6b5a4d]">リードフック・お水ボウルあり</p>
            </div>

            <div className="p-4 rounded-2xl bg-[#faf7f2] border border-[#f4eee3] space-y-2">
              <div className="w-10 h-10 mx-auto rounded-full bg-[#e2f0d9] text-[#6cae54] flex items-center justify-center">
                📶
              </div>
              <h4 className="text-xs font-bold text-[#392d23]">高速 Free Wi-Fi</h4>
              <p className="text-[11px] text-[#6b5a4d]">ノマドワーク・観光調べに</p>
            </div>

            <div className="p-4 rounded-2xl bg-[#faf7f2] border border-[#f4eee3] space-y-2">
              <div className="w-10 h-10 mx-auto rounded-full bg-[#fde2d9] text-[#e26d5c] flex items-center justify-center">
                🔌
              </div>
              <h4 className="text-xs font-bold text-[#392d23]">電源コンセント</h4>
              <p className="text-[11px] text-[#6b5a4d]">カウンター各席に完備</p>
            </div>

            <div className="p-4 rounded-2xl bg-[#faf7f2] border border-[#f4eee3] space-y-2">
              <div className="w-10 h-10 mx-auto rounded-full bg-[#e2f0d9] text-[#6cae54] flex items-center justify-center">
                🚗
              </div>
              <h4 className="text-xs font-bold text-[#392d23]">無料駐車場20台</h4>
              <p className="text-[11px] text-[#6b5a4d]">EV充電スタンド2基あり</p>
            </div>

            <div className="p-4 rounded-2xl bg-[#faf7f2] border border-[#f4eee3] space-y-2">
              <div className="w-10 h-10 mx-auto rounded-full bg-[#fde2d9] text-[#e26d5c] flex items-center justify-center">
                ♿
              </div>
              <h4 className="text-xs font-bold text-[#392d23]">バリアフリー設計</h4>
              <p className="text-[11px] text-[#6b5a4d]">スロープ・多目的トイレ</p>
            </div>

            <div className="p-4 rounded-2xl bg-[#faf7f2] border border-[#f4eee3] space-y-2">
              <div className="w-10 h-10 mx-auto rounded-full bg-[#e2f0d9] text-[#6cae54] flex items-center justify-center">
                👶
              </div>
              <h4 className="text-xs font-bold text-[#392d23]">お子様連れ歓迎</h4>
              <p className="text-[11px] text-[#6b5a4d]">キッズチェア・おむつ台</p>
            </div>
          </div>
        </div>
      </AnimatedSection>

      {/* 店主・スタッフメッセージ */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="bg-[#f4eee3] rounded-3xl p-8 sm:p-12 border border-[#e7dac5] flex flex-col md:flex-row items-center gap-8">
          <div className="w-32 h-32 sm:w-40 sm:h-40 rounded-full overflow-hidden shrink-0 border-4 border-white shadow-md">
            <img
              src="/images/okazaki_chef.jpg"
              alt="代表・パティシエ 岡崎 健太郎"
              className="w-full h-full object-cover object-top"
            />
          </div>
          <div className="space-y-3 text-center md:text-left">
            <span className="text-xs font-bold tracking-widest text-[#b54737] uppercase block">
              OWNER & CHEF MESSAGE
            </span>
            <h3 className="font-serif text-xl sm:text-2xl font-bold text-[#392d23]">
              「岡山の美味しい記憶を、皆さまの心に刻みたい。」
            </h3>
            <p className="text-xs sm:text-sm text-[#6b5a4d] leading-relaxed">
              果物は生き物です。その日の気温や日照、雨の降り方で毎日糖度や酸味のバランスが変わります。私たちは毎朝届く果物を一口一口味見し、その日その実が一番輝く仕立てでお出ししています。<br />
              岡山に観光でお越しの方も、お近くにお住まいの方も、ふらっと立ち寄って笑顔になれる場所であり続けます。
            </p>
            <div className="text-xs font-semibold text-[#574636] pt-1">
              CAFE HAREKA 代表・パティシエ / 岡崎 健太郎
            </div>
          </div>
        </div>
      </AnimatedSection>
    </div>
  );
};
