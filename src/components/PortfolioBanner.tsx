import React, { useState } from 'react';
import { Info, Code2, ChevronDown } from 'lucide-react';
import { motion, AnimatePresence } from 'framer-motion';

export const PortfolioBanner: React.FC = () => {
  const [showDetails, setShowDetails] = useState(false);

  return (
    <div className="w-full bg-[#221c17] text-[#f4eee3] border-b border-[#574636] shadow-sm relative z-[60]">
      <div className="max-w-7xl mx-auto px-4 py-2 sm:py-2.5 flex flex-wrap items-center justify-between gap-2 text-xs">
        {/* メインの固定通知 */}
        <div className="flex items-center gap-2 sm:gap-3 flex-1 min-w-[280px]">
          <span className="inline-flex items-center gap-1.5 bg-[#b54737] text-white font-bold px-2.5 py-0.5 rounded-full text-[11px] tracking-wide shrink-0 shadow-sm">
            <Info className="w-3.5 h-3.5" />
            ポートフォリオ実績用
          </span>
          <p className="text-xs sm:text-[13px] text-[#f4eee3] leading-tight font-medium">
            ※当Webサイトは制作実績用の<strong>架空のカフェサイト</strong>です。実在の店舗・人物・団体とは一切関係ございません。
          </p>
        </div>

        {/* 技術スタック・詳細トグルボタン */}
        <div className="flex items-center gap-2 ml-auto">
          <span className="hidden md:inline-flex items-center gap-1.5 text-[11px] text-[#d8c8b2] bg-[#392d23] px-2.5 py-0.5 rounded-md border border-[#574636]">
            <Code2 className="w-3 h-3 text-[#f7a48d]" /> React 19 / Vite / TypeScript / Tailwind CSS / Framer Motion
          </span>
          <button
            onClick={() => setShowDetails(!showDetails)}
            className="inline-flex items-center gap-1 text-[11px] text-[#fbc6b6] hover:text-white font-medium bg-[#392d23] hover:bg-[#4a3b32] px-2 py-1 rounded transition border border-[#574636]"
          >
            <span>制作仕様</span>
            <ChevronDown
              className={`w-3 h-3 transition-transform duration-200 ${
                showDetails ? 'rotate-180' : ''
              }`}
            />
          </button>
        </div>
      </div>

      {/* 詳細展開エリア */}
      <AnimatePresence>
        {showDetails && (
          <motion.div
            initial={{ height: 0, opacity: 0 }}
            animate={{ height: 'auto', opacity: 1 }}
            exit={{ height: 0, opacity: 0 }}
            transition={{ duration: 0.2 }}
            className="overflow-hidden bg-[#1a1512] border-t border-[#392d23] px-4 py-3"
          >
            <div className="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-4 text-[11px] text-[#d8c8b2]">
              <div>
                <span className="font-bold text-[#fbc6b6] block mb-1">■ サイト目的 & ペルソナ</span>
                岡山県で新規オープンする地産地消カフェを想定。地元住民のファン獲得および県外・観光客の来店動機を創出するWebデザイン。
              </div>
              <div>
                <span className="font-bold text-[#fbc6b6] block mb-1">■ 掲載素材・画像について</span>
                店舗文章：AI生成 / 写真：商品（白桃パフェ・シャインマスカットタルト・メロン等）と完全合致した専用AI生成写真を採用。
              </div>
              <div>
                <span className="font-bold text-[#fbc6b6] block mb-1">■ UI/UX の工夫</span>
                Framer Motionアニメーション、モバイル最適化下部アクションバー、即時レスポンシブナビゲーションを実装。
              </div>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </div>
  );
};
