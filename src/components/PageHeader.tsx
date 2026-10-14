import React from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { ChevronRight } from 'lucide-react';

interface PageHeaderProps {
  title: string;
  subtitleEn: string;
  description: string;
  bgGradient?: string;
}

export const PageHeader: React.FC<PageHeaderProps> = ({
  title,
  subtitleEn,
  description,
  bgGradient = 'from-[#fde2d9]/60 via-[#faf7f2] to-[#e2f0d9]/40',
}) => {
  return (
    <div className={`relative py-12 md:py-20 bg-gradient-to-b ${bgGradient} border-b border-[#e7dac5]/60 overflow-hidden`}>
      {/* 背景装飾 */}
      <div className="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-[#fbc6b6]/20 blur-3xl pointer-events-none" />
      <div className="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 rounded-full bg-[#a9d997]/20 blur-3xl pointer-events-none" />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        {/* パンくずリスト */}
        <div className="flex items-center justify-center gap-2 text-xs text-[#a48c6f] mb-4">
          <Link to="/" className="hover:text-[#b54737] transition">HOME</Link>
          <ChevronRight className="w-3 h-3 text-[#d8c8b2]" />
          <span className="text-[#574636] font-medium">{title}</span>
        </div>

        <motion.div
          initial={{ opacity: 0, y: 15 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5 }}
          className="space-y-3"
        >
          <span className="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase block">
            {subtitleEn}
          </span>
          <h1 className="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-[#392d23] tracking-wide">
            {title}
          </h1>
          <p className="max-w-2xl mx-auto text-sm sm:text-base text-[#6b5a4d] leading-relaxed pt-2">
            {description}
          </p>
        </motion.div>
      </div>
    </div>
  );
};
