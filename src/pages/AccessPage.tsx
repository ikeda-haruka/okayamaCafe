import React from 'react';
import { PageHeader } from '../components/PageHeader';
import { AnimatedSection } from '../components/AnimatedSection';
import {
  Car,
  Train,
  Compass,
  ExternalLink,
  CheckCircle2
} from 'lucide-react';


export const AccessPage: React.FC = () => {
  return (
    <div className="space-y-16 sm:space-y-24 pb-20">
      <PageHeader
        title="アクセス・店舗情報"
        subtitleEn="LOCATION & ACCESS"
        description="吉備津神社の美しい参道から車で約2分。豊かな田園と緑に囲まれた心地よいロケーション。県外からのドライブや岡山観光の合間にもお気軽にお立ち寄りください。"
      />

      {/* マップ＆基本情報 */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
          {/* インタラクティブ風マップエリア */}
          <div className="lg:col-span-7 bg-white rounded-3xl overflow-hidden border border-[#e7dac5] shadow-sm">
            <div className="relative h-80 sm:h-[450px] bg-[#eef0eb] flex items-center justify-center overflow-hidden">
              {/* マップビジュアル表現 */}
              <iframe
                title="CAFE HAREKA 所在地マップ"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13123.63385750346!2d133.8504008!3d34.6698651!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3554070a2569502f%3A0x6b63391b10a562ef!2z5ZCJ5YKZ5rSl56We56S-!5e0!3m2!1sja!2sjp!4v1710000000000!5m2!1sja!2sjp"
                className="w-full h-full border-0 filter contrast-95 brightness-95"
                loading="lazy"
              />
              <div className="absolute top-4 left-4 bg-white/95 backdrop-blur-md px-4 py-2 rounded-2xl shadow-md border border-[#e7dac5] text-xs space-y-1">
                <span className="font-bold text-[#392d23] block">CAFE HAREKA（晴果）</span>
                <span className="text-[#6b5a4d] block">岡山県岡山市北区吉備津780-1</span>
              </div>
            </div>

            <div className="p-6 bg-white border-t border-[#f4eee3] flex flex-col sm:flex-row items-center justify-between gap-4">
              <div className="text-xs text-[#6b5a4d]">
                ※ナビゲーションには「吉備津神社」または「吉備津780」とご入力ください。
              </div>
              <a
                href="https://maps.google.com/?q=吉備津神社+岡山"
                target="_blank"
                rel="noreferrer"
                className="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#392d23] text-white text-xs font-semibold hover:bg-[#574636] transition shadow-sm shrink-0"
              >
                <Compass className="w-4 h-4 text-[#f7a48d]" />
                <span>Google Mapsでルート案内</span>
                <ExternalLink className="w-3 h-3 text-[#d8c8b2]" />
              </a>
            </div>
          </div>

          {/* 店舗情報サマリー */}
          <div className="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-8 border border-[#e7dac5] shadow-sm space-y-6">
            <h3 className="font-serif text-xl font-bold text-[#392d23] border-b border-[#f4eee3] pb-3">
              店舗概要
            </h3>

            <div className="space-y-4 text-xs sm:text-sm">
              <div className="flex gap-4">
                <span className="w-24 text-[#a48c6f] shrink-0 font-medium">店名</span>
                <span className="font-semibold text-[#392d23]">CAFE HAREKA（カフェ ハレカ / 晴果喫茶）</span>
              </div>

              <div className="flex gap-4">
                <span className="w-24 text-[#a48c6f] shrink-0 font-medium">住所</span>
                <span className="text-[#574636]">
                  〒701-1341<br />
                  岡山県岡山市北区吉備津780-1
                </span>
              </div>

              <div className="flex gap-4">
                <span className="w-24 text-[#a48c6f] shrink-0 font-medium">電話番号</span>
                <a href="tel:086-234-5678" className="text-[#b54737] font-bold hover:underline">
                  086-234-5678
                </a>
              </div>

              <div className="flex gap-4">
                <span className="w-24 text-[#a48c6f] shrink-0 font-medium">営業時間</span>
                <div className="text-[#574636]">
                  10:00 〜 18:00（L.O. 17:30）<br />
                  <span className="text-xs text-[#a48c6f]">・ランチタイム：11:00 〜 14:00<br />・カフェタイム：終日</span>
                </div>
              </div>

              <div className="flex gap-4">
                <span className="w-24 text-[#a48c6f] shrink-0 font-medium">定休日</span>
                <span className="text-[#574636]">毎週水曜日（祝日の場合は翌営業日）</span>
              </div>

              <div className="flex gap-4">
                <span className="w-24 text-[#a48c6f] shrink-0 font-medium">席数</span>
                <span className="text-[#574636]">
                  全42席（店内28席 / テラス14席・ペット同伴可）
                </span>
              </div>

              <div className="flex gap-4">
                <span className="w-24 text-[#a48c6f] shrink-0 font-medium">駐車場</span>
                <span className="text-[#574636]">
                  専用無料駐車場 20台完備<br />
                  <span className="text-xs text-[#4a8235]">（EV普通充電器 2基あり）</span>
                </span>
              </div>

              <div className="flex gap-4">
                <span className="w-24 text-[#a48c6f] shrink-0 font-medium">決済方法</span>
                <div className="text-[#574636]">
                  現金、クレジットカード（VISA, Master, JCB, AMEX）、電子マネー、QRコード決済（PayPay, 楽天ペイ, d払い）
                </div>
              </div>
            </div>
          </div>
        </div>
      </AnimatedSection>

      {/* 交通アクセス手段案内 */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center space-y-3 mb-12">
          <span className="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">
            HOW TO GET HERE
          </span>
          <h2 className="font-serif text-2xl sm:text-4xl font-bold text-[#392d23]">
            交通手段別アクセスガイド
          </h2>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
          {/* お車でのアクセス */}
          <div className="bg-white rounded-3xl p-8 border border-[#e7dac5] shadow-sm space-y-5">
            <div className="flex items-center gap-3">
              <div className="w-12 h-12 rounded-2xl bg-[#fde2d9] text-[#e26d5c] flex items-center justify-center">
                <Car className="w-6 h-6" />
              </div>
              <div>
                <h3 className="font-serif text-xl font-bold text-[#392d23]">お車・レンタカーでお越しの場合</h3>
                <span className="text-xs text-[#a48c6f]">ドライブや観光巡りに便利</span>
              </div>
            </div>

            <ul className="space-y-3 text-xs sm:text-sm text-[#6b5a4d] leading-relaxed">
              <li className="flex items-start gap-2">
                <CheckCircle2 className="w-4 h-4 text-[#e26d5c] shrink-0 mt-0.5" />
                <span>
                  <strong>山陽自動車道「岡山IC」より約15分</strong>（国道53号・県道経由）
                </span>
              </li>
              <li className="flex items-start gap-2">
                <CheckCircle2 className="w-4 h-4 text-[#e26d5c] shrink-0 mt-0.5" />
                <span>
                  <strong>岡山総社ICより約12分</strong>
                </span>
              </li>
              <li className="flex items-start gap-2">
                <CheckCircle2 className="w-4 h-4 text-[#e26d5c] shrink-0 mt-0.5" />
                <span>
                  <strong>倉敷美観地区より約25分</strong>（県道経由でスムーズにお越しいただけます）
                </span>
              </li>
              <li className="flex items-start gap-2">
                <CheckCircle2 className="w-4 h-4 text-[#e26d5c] shrink-0 mt-0.5" />
                <span>
                  店舗敷地内に20台分のゆったりとした無料駐車場をご用意しております。
                </span>
              </li>
            </ul>
          </div>

          {/* 公共交通機関 */}
          <div className="bg-white rounded-3xl p-8 border border-[#e7dac5] shadow-sm space-y-5">
            <div className="flex items-center gap-3">
              <div className="w-12 h-12 rounded-2xl bg-[#e2f0d9] text-[#6cae54] flex items-center justify-center">
                <Train className="w-6 h-6" />
              </div>
              <div>
                <h3 className="font-serif text-xl font-bold text-[#392d23]">電車・バスでお越しの場合</h3>
                <span className="text-xs text-[#a48c6f]">JR岡山駅からのんびりローカル線の旅</span>
              </div>
            </div>

            <ul className="space-y-3 text-xs sm:text-sm text-[#6b5a4d] leading-relaxed">
              <li className="flex items-start gap-2">
                <CheckCircle2 className="w-4 h-4 text-[#6cae54] shrink-0 mt-0.5" />
                <span>
                  <strong>JR桃太郎線（吉備線）「吉備津駅」より徒歩約7分</strong>
                  <br />（JR岡山駅より桃太郎線で約18分）
                </span>
              </li>
              <li className="flex items-start gap-2">
                <CheckCircle2 className="w-4 h-4 text-[#6cae54] shrink-0 mt-0.5" />
                <span>
                  吉備津神社の国宝本殿や名物の廻廊（約360m）を散策しながら徒歩でお越しいただけます。
                </span>
              </li>
              <li className="flex items-start gap-2">
                <CheckCircle2 className="w-4 h-4 text-[#6cae54] shrink-0 mt-0.5" />
                <span>
                  吉備路レンタサイクルの立ち寄りスポットとしても大変人気です。
                </span>
              </li>
            </ul>
          </div>
        </div>
      </AnimatedSection>

      {/* 岡山観光おすすめモデルコース */}
      <AnimatedSection className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="bg-gradient-to-br from-[#fde2d9]/40 via-[#faf7f2] to-[#e2f0d9]/40 rounded-3xl p-8 sm:p-12 border border-[#e7dac5]">
          <div className="max-w-2xl mx-auto text-center space-y-3 mb-10">
            <span className="text-xs font-semibold tracking-widest text-[#b54737] uppercase block">
              TOURIST MODEL COURSES
            </span>
            <h3 className="font-serif text-2xl sm:text-3xl font-bold text-[#392d23]">
              岡山を満喫するカフェ立ち寄りコース
            </h3>
            <p className="text-xs sm:text-sm text-[#6b5a4d]">
              県外からお越しの皆さまへ。周辺の人気観光名所と組み合わせたおすすめルートです。
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="bg-white p-6 rounded-2xl border border-[#e7dac5] space-y-3 shadow-sm">
              <span className="inline-block bg-[#fde2d9] text-[#b54737] text-xs font-bold px-3 py-1 rounded-full">
                コースA：歴史と果実の吉備路めぐり
              </span>
              <h4 className="font-serif text-base font-bold text-[#392d23]">
                国宝・吉備津神社 参拝 ＆ 白桃パフェ
              </h4>
              <p className="text-xs text-[#6b5a4d] leading-relaxed">
                JR岡山駅 → 吉備津神社（美しい廻廊を散策） → <strong>CAFE HAREKA（旬の果実パフェでランチ＆休憩）</strong> → 備中国分寺（五重塔と田園風景）
              </p>
            </div>

            <div className="bg-white p-6 rounded-2xl border border-[#e7dac5] space-y-3 shadow-sm">
              <span className="inline-block bg-[#e2f0d9] text-[#4a8235] text-xs font-bold px-3 py-1 rounded-full">
                コースB：後楽園から倉敷へ抜けるドライブ
              </span>
              <h4 className="font-serif text-base font-bold text-[#392d23]">
                岡山後楽園・岡山城 ＆ テラスカフェ
              </h4>
              <p className="text-xs text-[#6b5a4d] leading-relaxed">
                岡山後楽園・岡山城 → <strong>CAFE HAREKA（ガーデンテラスでマスカットスイーツ＆コーヒー）</strong> → 倉敷美観地区（白壁の町並み散策）
              </p>
            </div>
          </div>
        </div>
      </AnimatedSection>
    </div>
  );
};
