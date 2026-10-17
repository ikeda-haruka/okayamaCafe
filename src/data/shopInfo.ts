/**
 * CAFE HAREKA 店舗情報・営業時間 一元管理データ & フック
 *
 * WordPressのREST API (/wp-json/hareka/v1/shop-info) からの動的取得と、
 * オフライン/フォールバック用のデフォルト値を両立した一元管理モジュール。
 */

import { useState, useEffect } from 'react';

export interface ShopInfo {
  name: string;
  name_en: string;
  chef_name: string;
  postal_code: string;
  address: string;
  address_short: string;
  access_note: string;
  parking: string;
  seats: string;
  facility: string;

  // 営業時間・定休日
  hours_open: string;
  hours_close: string;
  hours_lo: string;
  hours_text: string;
  hours_header: string;
  closed_day: string;
  closed_day_short: string;
  closed_day_num: string | number;
  special_notice: string;

  // 連絡先・SNS
  phone: string;
  phone_hours: string;
  phone_note: string;
  email: string;
  instagram_url: string;
  x_url: string;
  facebook_url: string;
  google_map_url: string;
}

export const defaultShopInfo: ShopInfo = {
  name: 'CAFE HAREKA (カフェ 晴果)',
  name_en: 'CAFE HAREKA - Okayama Seasonal Fruit & Cafe',
  chef_name: '岡崎 健太郎',
  postal_code: '〒701-1341',
  address: '岡山県岡山市北区吉備津780-1',
  address_short: '岡山市北区吉備津780',
  access_note: 'JR吉備線「吉備津駅」より徒歩8分 / 山陽自動車道「岡山IC」より車で15分（吉備津神社参道近く）',
  parking: '普通車12台 / 身障者用1台（無料・店舗敷地内）※大型バス要事前相談',
  seats: '32席（店内24席・ウッドデッキテラス8席）',
  facility: '全席完全禁煙 / Wi-Fi完備 / コンセント席あり / キッズチェア完備 / バリアフリースロープ',

  hours_open: '10:00',
  hours_close: '18:00',
  hours_lo: '17:30',
  hours_text: '10:00 〜 18:00（L.O. 17:30）',
  hours_header: '10:00 - 18:00 (L.O. 17:30)',
  closed_day: '毎週水曜日（祝日の場合は翌木曜振替）',
  closed_day_short: '水曜定休',
  closed_day_num: '3',
  special_notice: '',

  phone: '086-XXXX-XXX',
  phone_hours: '10:00 〜 18:00（毎週水曜・定休除く）',
  phone_note: '※当サイトは架空のポートフォリオ用店舗のため通話発信はご利用いただけません。ご予約やお問合せはWebフォームをご利用ください。',
  email: 'info@example.com',
  instagram_url: 'https://instagram.com/',
  x_url: 'https://x.com/',
  facebook_url: 'https://facebook.com/',
  google_map_url: 'https://maps.google.com/?q=吉備津神社',
};

// キャッシュ用変数
let cachedShopInfo: ShopInfo = { ...defaultShopInfo };
const listeners: Array<(info: ShopInfo) => void> = [];

/**
 * 店舗情報を取得するReactカスタムフック
 */
export function useShopInfo(): ShopInfo {
  const [info, setInfo] = useState<ShopInfo>(cachedShopInfo);

  useEffect(() => {
    const listener = (newInfo: ShopInfo) => setInfo(newInfo);
    listeners.push(listener);

    // WordPress REST API から店舗情報をフェッチ
    fetch('http://okayamacafe.local/wp-json/hareka/v1/shop-info')
      .then((res) => {
        if (res.ok) return res.json();
        throw new Error('Network response was not ok');
      })
      .then((data: Partial<ShopInfo>) => {
        cachedShopInfo = { ...defaultShopInfo, ...data };
        listeners.forEach((l) => l(cachedShopInfo));
      })
      .catch(() => {
        // API取得不可時はデフォルト値を維持
      });

    return () => {
      const idx = listeners.indexOf(listener);
      if (idx !== -1) listeners.splice(idx, 1);
    };
  }, []);

  return info;
}
