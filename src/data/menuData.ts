import type { MenuItem } from '../types';

export const menuItems: MenuItem[] = [
  // スイーツ (Sweets)
  {
    id: 'sweet-1',
    name: '岡山県産 清水白桃の極上パフェ',
    category: 'sweets',
    price: 1980,
    description: '赤磐の契約農家から毎朝届く朝採れ清水白桃を贅沢に丸ごと1個分使用。蒜山ジャージー牛乳の自家製ソフトクリームと、桃のピューレジュレが重なる至福のハーモニー。',
    image: '/images/peach_parfait.jpg',
    seasonal: true,
    takeout: false,
    farmOrigin: '赤磐市・吉井果樹園 直送',
    tags: ['数量限定', '看板メニュー', '朝採れ果実'],
    sugarContent: '糖度14度以上'
  },
  {
    id: 'sweet-2',
    name: '晴王（シャインマスカット）のエメラルドタルト',
    category: 'sweets',
    price: 1450,
    description: 'パリッと弾ける食感と芳醇なマスカット香。岡山県最高峰ブランド「晴王」を敷き詰め、マスカルポーネクリームと発酵バターサブレで上品に仕上げました。',
    image: '/images/muscat_tart.jpg',
    seasonal: true,
    takeout: true,
    farmOrigin: '倉敷市船穂町・晴山園 直送',
    tags: ['おすすめ', '皮ごと果実', '手土産可'],
    sugarContent: '糖度18度以上'
  },
  {
    id: 'sweet-3',
    name: '完熟ニューピオーネのメルバ風パンケーキ',
    category: 'sweets',
    price: 1380,
    description: '大粒で濃厚な果汁が溢れる岡山県産ニューピオーネの自家製コンポートをトッピング。米粉と地元平飼い卵で焼き上げた、ふわもち食感のスフレパンケーキ。',
    image: 'https://images.unsplash.com/photo-1528207776546-365bb710ee93?auto=format&fit=crop&w=800&q=80',
    seasonal: false,
    takeout: false,
    farmOrigin: '新見市哲西町・高原ぶどう園',
    tags: ['グルテンフリー米粉', '焼き立て'],
    sugarContent: '糖度16度以上'
  },
  {
    id: 'sweet-4',
    name: '足守アールスメロンのショートケーキグラス',
    category: 'sweets',
    price: 1250,
    description: '岡山市足守地区の温室で手塩にかけて育てられた高級メロンの甘みと香りを、軽やかなシャンティクリームとシフォンでグラスに閉じ込めました。',
    image: '/images/melon_glass_cake.jpg',
    seasonal: true,
    takeout: true,
    farmOrigin: '岡山市北区足守・温室農園',
    tags: ['グラスデザート'],
    sugarContent: '糖度15度前後'
  },

  // ランチ・お食事 (Lunch)
  {
    id: 'lunch-1',
    name: '岡山千屋牛のローストビーフ＆旬野菜プレート',
    category: 'lunch',
    price: 1850,
    description: '日本最古の蔓牛とされる希少な「千屋牛（ちやぎゅう）」を低温調理でしっとり仕上げました。瀬戸内レモンの特製和風ドレッシングと、県産無農薬野菜のサラダ付き。',
    image: '/images/chiyagyu_plate.jpg',
    seasonal: false,
    takeout: true,
    farmOrigin: '新見市哲多町・千屋牛肥育組合',
    tags: ['岡山ブランド牛', '限定15食']
  },
  {
    id: 'lunch-2',
    name: '倉敷レンコンと県産森林どりの彩りスパイスカレー',
    category: 'lunch',
    price: 1350,
    description: 'シャキシャキの倉敷連島（つらじま）レンコンとジューシーな岡山県産鶏肉を、桃のチャツネで深みを加えたオリジナルブレンドスパイスで煮込みました。',
    image: 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?auto=format&fit=crop&w=800&q=80',
    seasonal: false,
    takeout: true,
    farmOrigin: '倉敷市連島町・契約レンコン畑',
    tags: ['特製桃チャツネ仕込み', '地元野菜']
  },
  {
    id: 'lunch-3',
    name: '吉田牧場カチョカヴァロと桃太郎トマトのパニーニ',
    category: 'lunch',
    price: 1180,
    description: '全国のシェフが絶賛する吉備中央町「吉田牧場」のチーズを贅沢に香ばしくグリル。甘みたっぷりの完熟桃太郎トマトとバジルソースの相性が抜群です。',
    image: 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?auto=format&fit=crop&w=800&q=80',
    seasonal: false,
    takeout: true,
    farmOrigin: '吉備中央町・吉田牧場直送',
    tags: ['名品チーズ', 'テイクアウト人気']
  },

  // ドリンク (Drinks)
  {
    id: 'drink-1',
    name: '自家製 白桃クラフトシロップスカッシュ',
    category: 'drinks',
    price: 780,
    description: '清水白桃を丁寧に漬け込んだ自家製シロップを、強炭酸と瀬戸内レモンで割った爽快な一杯。桃の果肉がストローから飛び込みます。',
    image: 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?auto=format&fit=crop&w=800&q=80',
    seasonal: true,
    takeout: true,
    tags: ['自家製シロップ', 'ノンアルコール']
  },
  {
    id: 'drink-2',
    name: '蒜山ジャージーミルク・カフェラテ',
    category: 'drinks',
    price: 680,
    description: '岡山県北・蒜山高原の濃厚でコクのあるジャージー牛乳と、岡山市内の焙煎所特注の深煎りエスプレッソ。まろやかで奥深い味わいです。',
    image: 'https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&w=800&q=80',
    seasonal: false,
    takeout: true,
    tags: ['蒜山ジャージー牛乳', 'ラテアート']
  },
  {
    id: 'drink-3',
    name: 'シャインマスカット＆和ハッカのコールドブリューティー',
    category: 'drinks',
    price: 720,
    description: '岡山県産マスカット果汁を水出しアールグレイに合わせ、岡山・津山産の自然栽培ミントを浮かべた透明感溢れるアイスティー。',
    image: 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=800&q=80',
    seasonal: true,
    takeout: true,
    tags: ['オーガニックハーブ', '水出し茶']
  },

  // テイクアウト＆手土産 (Takeout)
  {
    id: 'takeout-1',
    name: 'HAREKA特製 岡山果実のバターサンド（4個入BOX）',
    category: 'takeout',
    price: 1680,
    description: 'ドライ白桃、セミドライピオーネ、瀬戸内レモンピールを練り込んだ特製発酵バタークリームを、サクサクのサブレでサンド。手土産に最適です。',
    image: '/images/butter_sand_box.jpg',
    seasonal: false,
    takeout: true,
    tags: ['お土産人気No.1', 'ギフト箱付き']
  },
  {
    id: 'takeout-2',
    name: '岡山県産 旬果コンフィチュール（白桃・マスカット）',
    category: 'takeout',
    price: 950,
    description: '旬の果実の形を残したプレザーブスタイル。甜菜糖とレモンだけでコトコト煮詰めた無添加ジャムです。パンやヨーグルトに。',
    image: '/images/fruit_confiture.jpg',
    seasonal: false,
    takeout: true,
    tags: ['無添加', '手作りジャム']
  }
];
