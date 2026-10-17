import React, { useState, useEffect } from 'react';
import { PageHeader } from '../components/PageHeader';
import { AnimatedSection } from '../components/AnimatedSection';
import { newsList as initialNewsList } from '../data/newsData';
import { fetchWpNews } from '../services/wordpress';
import type { NewsItem } from '../types';
import { Calendar, ChevronRight } from 'lucide-react';

export const NewsPage: React.FC = () => {
  const [news, setNews] = useState<NewsItem[]>(initialNewsList);
  const [selectedCategory, setSelectedCategory] = useState<string>('all');
  const [selectedNews, setSelectedNews] = useState<NewsItem | null>(null);

  useEffect(() => {
    fetchWpNews().then((data) => {
      if (data && data.length > 0) {
        setNews(data);
      }
    });
  }, []);

  const categories = ['all', 'お知らせ', '旬の入荷', 'イベント'];

  const filteredNews = selectedCategory === 'all'
    ? news
    : news.filter((item) => item.category === selectedCategory);

  return (
    <div className="space-y-16 sm:space-y-24 pb-20">
      <PageHeader
        title="店舗からのお知らせ"
        subtitleEn="NEWS & TOPICS"
        description="CAFE HAREKAからの最新の営業案内、旬の果物の初入荷情報、季節限定パフェやイベント情報をお届けします。"
        bgGradient="from-[#fde2d9]/60 via-[#faf7f2] to-[#e2f0d9]/60"
      />

      <AnimatedSection className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* カテゴリフィルタータブ */}
        <div className="flex flex-wrap items-center justify-center gap-2 sm:gap-3 mb-12">
          {categories.map((cat) => (
            <button
              key={cat}
              onClick={() => setSelectedCategory(cat)}
              className={`px-5 py-2.5 rounded-full text-xs font-semibold transition-all shadow-sm ${
                selectedCategory === cat
                  ? 'bg-[#392d23] text-white shadow-md'
                  : 'bg-white text-[#574636] border border-[#e7dac5] hover:bg-[#faf7f2]'
              }`}
            >
              {cat === 'all' ? 'すべて' : cat}
            </button>
          ))}
        </div>

        {/* ニュース一覧グリッド */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {filteredNews.map((item) => (
            <article
              key={item.id}
              onClick={() => setSelectedNews(item)}
              className="bg-white rounded-3xl overflow-hidden border border-[#e7dac5] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between cursor-pointer group hover:-translate-y-1"
            >
              {/* サムネイル画像（未設定時はCAFE HAREKAロゴ入りイラスト） */}
              <div className="aspect-video bg-[#faf7f2] relative overflow-hidden border-b border-[#f4eee3]">
                <img
                  src={item.thumbnailUrl || '/images/hareka-placeholder.svg'}
                  alt={item.title}
                  className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
                <div className="absolute top-3 left-3">
                  <span
                    className={`text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm backdrop-blur-sm ${
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
              </div>

              <div className="p-6 flex-1 flex flex-col justify-between space-y-4">
                <div className="space-y-2.5">
                  <div className="flex items-center gap-2 text-[11px] text-[#a48c6f] font-medium">
                    <Calendar className="w-3.5 h-3.5 text-[#e26d5c]" />
                    <span>{item.date}</span>
                  </div>

                  <h3 className="font-serif text-base font-bold text-[#392d23] group-hover:text-[#b54737] transition-colors line-clamp-2 leading-snug">
                    {item.title}
                  </h3>

                  <p className="text-xs text-[#6b5a4d] line-clamp-3 leading-relaxed">
                    {item.content}
                  </p>
                </div>

                <div className="pt-4 border-t border-[#f4eee3] flex items-center justify-between">
                  <span className="text-xs font-semibold text-[#b54737] group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                    <span>詳しく読む</span>
                    <ChevronRight className="w-3.5 h-3.5" />
                  </span>
                  <span className="text-[10px] text-[#a48c6f]">CAFE HAREKA</span>
                </div>
              </div>
            </article>
          ))}
        </div>

        {filteredNews.length === 0 && (
          <div className="bg-white rounded-3xl p-12 text-center border border-[#e7dac5] space-y-3 max-w-md mx-auto">
            <p className="text-xs sm:text-sm text-[#6b5a4d]">該当するカテゴリーのお知らせは現在ありません。</p>
            <button
              onClick={() => setSelectedCategory('all')}
              className="px-6 py-2 rounded-full bg-[#392d23] text-white text-xs font-semibold hover:bg-[#574636] transition"
            >
              すべてのお知らせを表示
            </button>
          </div>
        )}
      </AnimatedSection>

      {/* 詳細モーダル */}
      {selectedNews && (
        <div
          className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
          onClick={() => setSelectedNews(null)}
        >
          <div
            className="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-5 border border-[#e7dac5] shadow-2xl relative"
            onClick={(e) => e.stopPropagation()}
          >
            <div className="flex items-center justify-between pb-3 border-b border-[#f4eee3]">
              <div className="flex items-center gap-2 text-xs text-[#a48c6f]">
                <Calendar className="w-4 h-4 text-[#e26d5c]" />
                <span>{selectedNews.date}</span>
                <span
                  className={`text-[10px] font-bold px-2 py-0.5 rounded-full ml-2 ${
                    selectedNews.category === '旬の入荷'
                      ? 'bg-[#e2f0d9] text-[#4a8235]'
                      : selectedNews.category === 'お知らせ'
                      ? 'bg-[#fde2d9] text-[#b54737]'
                      : 'bg-[#f4eee3] text-[#574636]'
                  }`}
                >
                  {selectedNews.category}
                </span>
              </div>
              <button
                onClick={() => setSelectedNews(null)}
                className="w-8 h-8 rounded-full bg-[#faf7f2] flex items-center justify-center text-[#574636] hover:bg-[#f4eee3] text-sm"
              >
                ✕
              </button>
            </div>

            {/* サムネイル画像（未設定時はCAFE HAREKAロゴ入りイラスト） */}
            <div className="rounded-2xl overflow-hidden aspect-video bg-[#faf7f2] border border-[#f4eee3]">
              <img
                src={selectedNews.thumbnailUrl || '/images/hareka-placeholder.svg'}
                alt={selectedNews.title}
                className="w-full h-full object-cover"
              />
            </div>

            <h3 className="font-serif text-lg sm:text-xl font-bold text-[#392d23] leading-snug">
              {selectedNews.title}
            </h3>

            <div className="text-xs sm:text-sm text-[#574636] leading-relaxed whitespace-pre-wrap bg-[#faf7f2] p-4 rounded-2xl border border-[#f4eee3]">
              {selectedNews.content}
            </div>

            <div className="pt-2 text-center">
              <button
                onClick={() => setSelectedNews(null)}
                className="px-6 py-2.5 rounded-full bg-[#392d23] text-white text-xs font-semibold hover:bg-[#574636] transition"
              >
                閉じる
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};
