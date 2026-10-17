import React from 'react';
import { Link, useLocation } from 'react-router-dom';
import { Utensils, Calendar, MapPin, Phone } from 'lucide-react';
import { useShopInfo } from '../data/shopInfo';

export const BottomBar: React.FC = () => {
  const location = useLocation();
  const shopInfo = useShopInfo();

  return (
    <div className="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-[#faf7f2]/95 backdrop-blur-md border-t border-[#e7dac5] px-3 py-2 shadow-lg">
      <div className="grid grid-cols-4 gap-1">
        <Link
          to="/menu"
          className={`flex flex-col items-center justify-center py-1 rounded-lg text-[11px] font-medium transition ${
            location.pathname === '/menu'
              ? 'text-[#b54737] bg-[#fde2d9]'
              : 'text-[#574636] hover:bg-[#f4eee3]'
          }`}
        >
          <Utensils className="w-4 h-4 mb-0.5" />
          <span>メニュー</span>
        </Link>

        <Link
          to="/access"
          className={`flex flex-col items-center justify-center py-1 rounded-lg text-[11px] font-medium transition ${
            location.pathname === '/access'
              ? 'text-[#b54737] bg-[#fde2d9]'
              : 'text-[#574636] hover:bg-[#f4eee3]'
          }`}
        >
          <MapPin className="w-4 h-4 mb-0.5" />
          <span>アクセス</span>
        </Link>

        <button
          type="button"
          onClick={() => alert(`【${shopInfo.name}】\n${shopInfo.phone_note}`)}
          className="flex flex-col items-center justify-center py-1 rounded-lg text-[11px] font-medium text-[#574636] hover:bg-[#f4eee3] transition cursor-pointer"
          title={shopInfo.phone_note}
        >
          <Phone className="w-4 h-4 mb-0.5 text-[#e26d5c]" />
          <span>お電話</span>
        </button>

        <Link
          to="/contact"
          className="flex flex-col items-center justify-center py-1 rounded-lg text-[11px] font-bold bg-gradient-to-r from-[#e26d5c] to-[#b54737] text-white shadow-sm"
        >
          <Calendar className="w-4 h-4 mb-0.5" />
          <span>席予約</span>
        </Link>
      </div>
    </div>
  );
};
