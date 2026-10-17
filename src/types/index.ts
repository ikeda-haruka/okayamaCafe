export interface MenuItem {
  id: string;
  name: string;
  category: 'sweets' | 'lunch' | 'drinks' | 'takeout';
  price: number;
  description: string;
  image: string;
  seasonal?: boolean;
  takeout: boolean;
  farmOrigin?: string;
  tags?: string[];
  sugarContent?: string; // 糖度目安
}

export interface FruitInfo {
  id: string;
  name: string;
  reading: string;
  season: string;
  months: number[];
  description: string;
  features: string[];
  image: string;
  farm: string;
  sugarBrix: string;
}

export interface NewsItem {
  id: string;
  date: string;
  category: 'お知らせ' | '旬の入荷' | 'イベント';
  title: string;
  content: string;
  thumbnailUrl?: string;
}

export interface FAQItem {
  question: string;
  answer: string;
  category: string;
}
