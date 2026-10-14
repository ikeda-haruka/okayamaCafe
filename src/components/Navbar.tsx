import React, { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { motion, AnimatePresence } from 'framer-motion';
import { Menu, X, Phone, Calendar, MapPin, Sparkles } from 'lucide-react';
import { PortfolioBanner } from './PortfolioBanner';

export const Navbar: React.FC = () => {
  const [isOpen, setIsOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const location = useLocation();

  useEffect(() => {
    const handleScroll = () => {
      if (window.scrollY > 20) {
        setScrolled(true);
      } else {
        setScrolled(false);
      }
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  // ページ遷移時にモバイルメニューを閉じる
  useEffect(() => {
    setIsOpen(false);
  }, [location.pathname]);

  const navLinks = [
    { name: 'ホーム', path: '/', en: 'HOME' },
    { name: 'お店について', path: '/about', en: 'ABOUT' },
    { name: 'メニュー', path: '/menu', en: 'MENU' },
    { name: '岡山の果物', path: '/fruits', en: 'OKAYAMA FRUITS' },
    { name: 'アクセス', path: '/access', en: 'ACCESS' },
    { name: 'お問い合わせ', path: '/contact', en: 'CONTACT' },
  ];

  return (
    <>
      {/* 画面冒頭に常時固定されるコンテナ（ポートフォリオ案内バナー ＋ メインヘッダー） */}
      <div className="sticky top-0 z-50 shadow-sm">
        {/* ポートフォリオ実績用 架空サイト固定告知バナー */}
        <PortfolioBanner />

        {/* メインヘッダー */}
        <header
          className={`transition-all duration-300 ${
            scrolled
              ? 'bg-[#faf7f2]/95 backdrop-blur-md py-3 border-b border-[#e7dac5]/60'
              : 'bg-[#faf7f2] py-4 border-b border-[#e7dac5]/30'
          }`}
        >
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
          {/* ブランドロゴ */}
          <Link to="/" className="group flex items-center gap-3">
            <div className="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-gradient-to-tr from-[#fbc6b6] via-[#fde2d9] to-[#a9d997] flex items-center justify-center shadow-inner group-hover:scale-105 transition-transform duration-300">
              <span className="text-xl">🍑</span>
            </div>
            <div className="flex flex-col">
              <span className="text-xs tracking-[0.25em] text-[#a48c6f] font-medium uppercase">
                Okayama Local Fruits & Cafe
              </span>
              <span className="font-serif text-xl sm:text-2xl font-bold tracking-wider text-[#392d23] group-hover:text-[#b54737] transition-colors">
                CAFE HAREKA <span className="text-sm font-normal text-[#a48c6f]">晴果</span>
              </span>
            </div>
          </Link>

          {/* デスクトップナビゲーション */}
          <nav className="hidden lg:flex items-center gap-1 xl:gap-2">
            {navLinks.map((link) => {
              const isActive = location.pathname === link.path;
              return (
                <Link
                  key={link.path}
                  to={link.path}
                  className={`px-3 xl:px-4 py-2 rounded-full text-sm font-medium transition-all relative flex flex-col items-center ${
                    isActive
                      ? 'text-[#b54737] font-semibold'
                      : 'text-[#574636] hover:text-[#b54737] hover:bg-[#f4eee3]/60'
                  }`}
                >
                  <span>{link.name}</span>
                  <span className="text-[9px] tracking-wider text-[#a48c6f] -mt-0.5">
                    {link.en}
                  </span>
                  {isActive && (
                    <motion.div
                      layoutId="activeIndicator"
                      className="absolute bottom-0 w-6 h-0.5 bg-[#b54737] rounded-full"
                      transition={{ type: 'spring', stiffness: 380, damping: 30 }}
                    />
                  )}
                </Link>
              );
            })}
          </nav>

          {/* CTAボタン（予約） */}
          <div className="hidden lg:flex items-center gap-3">
            <Link
              to="/contact"
              className="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-[#e26d5c] to-[#b54737] text-white text-sm font-medium shadow-sm hover:shadow-md hover:brightness-105 transition-all duration-200 active:scale-95"
            >
              <Calendar className="w-4 h-4" />
              <span>お席のご予約</span>
            </Link>
          </div>

          {/* モバイル用ハンバーガーボタン */}
          <button
            onClick={() => setIsOpen(!isOpen)}
            className="lg:hidden p-2 rounded-xl text-[#392d23] hover:bg-[#f4eee3] transition"
            aria-label="メニューを開く"
          >
            {isOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
          </button>
        </div>
      </header>

      {/* 店舗ティッカーインフォ */}
      <div className="bg-[#392d23] text-[#f4eee3] text-[11px] py-1 px-4 hidden sm:block">
        <div className="max-w-7xl mx-auto flex justify-between items-center">
          <div className="flex items-center gap-3">
            <span className="inline-flex items-center gap-1 bg-[#6cae54] text-white px-2 py-0.5 rounded-full text-[10px] font-medium">
              <Sparkles className="w-2.5 h-2.5" /> 営業中 10:00 - 18:00 (L.O. 17:30) / 水曜定休
            </span>
            <span className="text-[#fbc6b6] font-medium">
              🍑 今週は「赤磐産 清水白桃」極上パフェをご提供中！
            </span>
          </div>
          <div className="flex items-center gap-4 text-[#d8c8b2]">
            <span className="flex items-center gap-1">
              <MapPin className="w-3 h-3 text-[#f7a48d]" /> 岡山市北区吉備津780
            </span>
            <a href="tel:086-234-5678" className="hover:text-white transition flex items-center gap-1">
              <Phone className="w-3 h-3" /> 086-234-5678
            </a>
          </div>
        </div>
      </div>
    </div>

      {/* モバイルメニューオーバーレイ */}
      <AnimatePresence>
        {isOpen && (
          <motion.div
            initial={{ opacity: 0, height: 0 }}
            animate={{ opacity: 1, height: 'auto' }}
            exit={{ opacity: 0, height: 0 }}
            transition={{ duration: 0.25, ease: 'easeInOut' }}
            className="lg:hidden bg-[#faf7f2] border-b border-[#e7dac5] shadow-xl overflow-hidden fixed top-[110px] left-0 right-0 z-40"
          >
            <div className="px-6 py-6 space-y-4">
              <div className="grid grid-cols-1 gap-2">
                {navLinks.map((link) => {
                  const isActive = location.pathname === link.path;
                  return (
                    <Link
                      key={link.path}
                      to={link.path}
                      className={`flex items-center justify-between p-3 rounded-xl transition ${
                        isActive
                          ? 'bg-[#fde2d9] text-[#b54737] font-semibold'
                          : 'text-[#433932] hover:bg-[#f4eee3]'
                      }`}
                    >
                      <div>
                        <div className="text-base">{link.name}</div>
                        <div className="text-xs text-[#a48c6f]">{link.en}</div>
                      </div>
                      <span className="text-xs text-[#a48c6f]">→</span>
                    </Link>
                  );
                })}
              </div>

              <div className="pt-4 border-t border-[#e7dac5] space-y-2">
                <Link
                  to="/contact"
                  className="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-gradient-to-r from-[#e26d5c] to-[#b54737] text-white font-medium shadow"
                >
                  <Calendar className="w-4 h-4" />
                  <span>お席の事前予約・お問い合わせ</span>
                </Link>
                <a
                  href="tel:086-234-5678"
                  className="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl border border-[#d8c8b2] text-[#574636] font-medium hover:bg-[#f4eee3] transition"
                >
                  <Phone className="w-4 h-4" />
                  <span>お電話：086-234-5678</span>
                </a>
              </div>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </>
  );
};
