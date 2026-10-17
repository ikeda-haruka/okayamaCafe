import type { NewsItem, MenuItem } from '../types';
import { newsList as fallbackNews } from '../data/newsData';
import { menuItems as fallbackMenu } from '../data/menuData';

// WordPress REST API のベースURL（.env の VITE_WP_API_URL から取得可能）
const WP_API_URL = import.meta.env.VITE_WP_API_URL || '';

/**
 * WordPress REST API: お知らせ一覧（投稿 / posts）の取得
 * API未接続または取得エラー時はローカルデータに自動フォールバック
 */
export async function fetchWpNews(): Promise<NewsItem[]> {
  if (!WP_API_URL) {
    return fallbackNews;
  }

  try {
    const res = await fetch(`${WP_API_URL}/wp-json/wp/v2/posts?_embed&per_page=10`);
    if (!res.ok) {
      console.warn(`[WordPress API] Failed to fetch posts: ${res.status}. Falling back to local data.`);
      return fallbackNews;
    }

    const posts = await res.json();
    if (!Array.isArray(posts) || posts.length === 0) {
      return fallbackNews;
    }

    return posts.map((post: any): NewsItem => {
      // 日付フォーマット YYYY.MM.DD
      const dateObj = new Date(post.date);
      const year = dateObj.getFullYear();
      const month = String(dateObj.getMonth() + 1).padStart(2, '0');
      const day = String(dateObj.getDate()).padStart(2, '0');
      const formattedDate = `${year}.${month}.${day}`;

      // カテゴリ名抽出（_embedded['wp:term']から）
      let categoryName: 'お知らせ' | '旬の入荷' | 'イベント' = 'お知らせ';
      if (post._embedded && post._embedded['wp:term'] && post._embedded['wp:term'][0]) {
        const cat = post._embedded['wp:term'][0][0];
        if (cat && (cat.name === '旬の入荷' || cat.name === 'イベント')) {
          categoryName = cat.name;
        }
      }

      // アイキャッチ画像の取得
      const featuredMedia = post._embedded?.['wp:featuredmedia']?.[0];
      const thumbnailUrl = featuredMedia?.source_url || featuredMedia?.media_details?.sizes?.large?.source_url;

      // 抜粋または本文のプレーンテキスト化
      const rawExcerpt = post.excerpt?.rendered || post.content?.rendered || '';
      const cleanContent = rawExcerpt.replace(/<[^>]+>/g, '').trim();

      return {
        id: `wp-${post.id}`,
        date: formattedDate,
        category: categoryName,
        title: post.title?.rendered || '無題のおしらせ',
        content: cleanContent,
        thumbnailUrl: thumbnailUrl || undefined
      };
    });
  } catch (err) {
    console.warn('[WordPress API] Network error, fallback to local news data:', err);
    return fallbackNews;
  }
}

/**
 * WordPress REST API: メニュー一覧（カスタム投稿 / menu_items）の取得
 * API未接続または取得エラー時はローカルデータに自動フォールバック
 */
export async function fetchWpMenu(): Promise<MenuItem[]> {
  if (!WP_API_URL) {
    return fallbackMenu;
  }

  try {
    const res = await fetch(`${WP_API_URL}/wp-json/wp/v2/menu_items?_embed&per_page=50`);
    if (!res.ok) {
      console.warn(`[WordPress API] Failed to fetch menu items: ${res.status}. Falling back to local data.`);
      return fallbackMenu;
    }

    const items = await res.json();
    if (!Array.isArray(items) || items.length === 0) {
      return fallbackMenu;
    }

    return items.map((item: any): MenuItem => {
      // アイキャッチ画像
      let imageUrl = '/images/peach_parfait.jpg';
      if (
        item._embedded &&
        item._embedded['wp:featuredmedia'] &&
        item._embedded['wp:featuredmedia'][0]
      ) {
        imageUrl = item._embedded['wp:featuredmedia'][0].source_url || imageUrl;
      }

      // カテゴリ
      let category: 'sweets' | 'lunch' | 'drinks' | 'takeout' = 'sweets';
      if (item._embedded && item._embedded['wp:term'] && item._embedded['wp:term'][0]) {
        const termSlug = item._embedded['wp:term'][0][0]?.slug;
        if (['sweets', 'lunch', 'drinks', 'takeout'].includes(termSlug)) {
          category = termSlug as any;
        }
      }

      // メタフィールド
      const meta = item.meta || {};
      const priceVal = parseInt(String(meta._hareka_menu_price || '').replace(/[^0-9]/g, ''), 10) || 1000;

      return {
        id: `wp-menu-${item.id}`,
        name: item.title?.rendered || '',
        category,
        price: priceVal,
        description: (item.content?.rendered || '').replace(/<[^>]+>/g, '').trim(),
        image: imageUrl,
        seasonal: Boolean(meta._hareka_menu_limited),
        takeout: Boolean(meta._hareka_menu_takeout),
        farmOrigin: meta._hareka_menu_origin || '',
        sugarContent: meta._hareka_menu_sugar || ''
      };
    });
  } catch (err) {
    console.warn('[WordPress API] Network error, fallback to local menu data:', err);
    return fallbackMenu;
  }
}
