import React from 'react';
import { Link } from 'react-router-dom';
import { MapPin, Phone, Mail, Clock, Heart, Sparkles, Compass } from 'lucide-react';
import { useShopInfo } from '../data/shopInfo';

export const Footer: React.FC = () => {
  const shopInfo = useShopInfo();
  return (
    <footer className="bg-[#392d23] text-[#f4eee3] pt-16 pb-24 md:pb-16 border-t-4 border-[#e26d5c]">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8 pb-12 border-b border-[#574636]">
          {/* ブランド情報 */}
          <div className="space-y-4">
            <div className="flex items-center gap-3">
              <div className="w-10 h-10 rounded-full bg-gradient-to-tr from-[#fbc6b6] via-[#fde2d9] to-[#a9d997] flex items-center justify-center text-xl shadow">
                🍑
              </div>
              <div>
                <div className="text-[10px] tracking-widest text-[#d8c8b2] uppercase">Okayama Fruits Cafe</div>
                <div className="font-serif text-xl font-bold tracking-wider text-white">
                  CAFE HAREKA <span className="text-sm font-normal text-[#d8c8b2]">晴果</span>
                </div>
              </div>
            </div>
            <p className="text-xs text-[#d8c8b2] leading-relaxed">
              「晴れの国」岡山の豊かな太陽と清流が育んだ、新鮮な白桃やシャインマスカットを味わう地産地消カフェ。木の温もりあふれる居心地の良い空間で、心ほどける特別なひとときをお届けします。
            </p>
            <div className="inline-flex items-center gap-2 bg-[#574636] px-3 py-1.5 rounded-full text-xs text-[#fde2d9]">
              <Sparkles className="w-3.5 h-3.5 text-[#f7a48d]" />
              岡山県地産地消推進協力店舗
            </div>
          </div>

          {/* 営業時間・アクセス */}
          <div className="space-y-3">
            <h4 className="font-serif text-base font-semibold text-white flex items-center gap-2">
              <Clock className="w-4 h-4 text-[#f7a48d]" /> 店舗インフォメーション
            </h4>
            <ul className="text-xs text-[#d8c8b2] space-y-2.5">
              <li>
                <span className="text-white block font-medium">営業時間</span>
                {shopInfo.hours_text}
                {shopInfo.special_notice && (
                  <span className="block text-[11px] text-[#fbc6b6] mt-0.5">{shopInfo.special_notice}</span>
                )}
              </li>
              <li>
                <span className="text-white block font-medium">定休日</span>
                {shopInfo.closed_day}
              </li>
              <li>
                <span className="text-white block font-medium">席数 / 設備</span>
                {shopInfo.seats}
                <br />{shopInfo.facility}
              </li>
            </ul>
          </div>

          {/* ナビゲーションリンク */}
          <div className="space-y-3">
            <h4 className="font-serif text-base font-semibold text-white flex items-center gap-2">
              <Compass className="w-4 h-4 text-[#a9d997]" /> サイトメニュー
            </h4>
            <div className="grid grid-cols-2 gap-2 text-xs text-[#d8c8b2]">
              <Link to="/" className="hover:text-white transition py-1">ホーム</Link>
              <Link to="/about" className="hover:text-white transition py-1">お店について</Link>
              <Link to="/menu" className="hover:text-white transition py-1">メニュー一覧</Link>
              <Link to="/fruits" className="hover:text-white transition py-1">岡山の果物図鑑</Link>
              <Link to="/access" className="hover:text-white transition py-1">アクセス・駐車場</Link>
              <Link to="/contact" className="hover:text-white transition py-1">ご予約・問合せ</Link>
            </div>
            <div className="pt-2">
              <div className="text-xs text-[#d8c8b2] mb-2">公式SNSで旬の入荷情報を配信中</div>
              <div className="flex gap-3">
                <a
                  href={shopInfo.instagram_url}
                  target="_blank"
                  rel="noreferrer"
                  className="w-8 h-8 rounded-full bg-[#574636] hover:bg-[#e26d5c] transition flex items-center justify-center text-white"
                  aria-label="Instagram"
                >
                  <svg className="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                  </svg>
                </a>
                <a
                  href={shopInfo.x_url}
                  target="_blank"
                  rel="noreferrer"
                  className="w-8 h-8 rounded-full bg-[#574636] hover:bg-[#433932] transition flex items-center justify-center text-white text-xs font-bold"
                  aria-label="X"
                >
                  𝕏
                </a>
              </div>
            </div>
          </div>

          {/* 所在地・お問い合わせ */}
          <div className="space-y-3">
            <h4 className="font-serif text-base font-semibold text-white flex items-center gap-2">
              <MapPin className="w-4 h-4 text-[#f7a48d]" /> 所在地・ご連絡
            </h4>
            <div className="text-xs text-[#d8c8b2] space-y-2">
              <p>
                {shopInfo.postal_code}<br />
                {shopInfo.address}<br />
                （{shopInfo.access_note}）
              </p>
              <div className="pt-1">
                <span
                  className="inline-flex items-center gap-2 text-white font-semibold"
                  title={shopInfo.phone_note}
                >
                  <Phone className="w-3.5 h-3.5 text-[#f7a48d]" /> {shopInfo.phone}
                </span>
              </div>
              <div>
                <a
                  href={`mailto:${shopInfo.email}`}
                  className="inline-flex items-center gap-2 text-[#d8c8b2] hover:text-white transition text-[11px]"
                >
                  <Mail className="w-3.5 h-3.5" /> {shopInfo.email}
                </a>
              </div>
            </div>
          </div>
        </div>

        {/* コピーライト */}
        <div className="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-[#a48c6f] gap-3">
          <p>© {new Date().getFullYear()} {shopInfo.name} All Rights Reserved. (架空ポートフォリオWebサイト制作実績)</p>
          <p className="flex items-center gap-1">
            Made with <Heart className="w-3.5 h-3.5 text-[#e26d5c] fill-current" /> in Okayama, Japan
          </p>
        </div>
      </div>
    </footer>
  );
};
