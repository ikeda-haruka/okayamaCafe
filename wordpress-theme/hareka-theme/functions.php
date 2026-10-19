<?php
/**
 * CAFE HAREKA Theme functions and definitions
 *
 * @package hareka-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// 店舗情報・営業時間 一元管理モジュール
require_once get_template_directory() . '/inc/shop-settings.php';

/**
 * テーマのセットアップ
 */
function hareka_theme_setup() {
    // アイキャッチ画像のサポート
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'hareka-card', 800, 600, true );
    add_image_size( 'hareka-hero', 1200, 800, true );

    // タイトルタグ自動生成
    add_theme_support( 'title-tag' );

    // HTML5マークアップ対応
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    // カスタムナビゲーションメニュー登録
    register_nav_menus( array(
        'primary' => __( 'Primary Header Menu', 'hareka-theme' ),
        'footer'  => __( 'Footer Menu', 'hareka-theme' ),
    ) );
}
add_action( 'after_setup_theme', 'hareka_theme_setup' );

/**
 * CSS・JavaScriptのエンキュー
 */
function hareka_theme_scripts() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    // Google Fonts (Shippori Mincho & Noto Sans JP)
    wp_enqueue_style( 'hareka-google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;600;700&family=Shippori+Mincho:wght@400;500;600;700&display=swap', array(), null );

    // Tailwind CSS & テーマスタイル
    $css_ver = file_exists( $theme_dir . '/assets/css/theme.css' ) ? filemtime( $theme_dir . '/assets/css/theme.css' ) : '1.0.0';
    wp_enqueue_style( 'hareka-theme-css', $theme_uri . '/assets/css/theme.css', array(), $css_ver );

    $style_ver = file_exists( $theme_dir . '/style.css' ) ? filemtime( $theme_dir . '/style.css' ) : '1.0.0';
    wp_enqueue_style( 'hareka-main-style', get_stylesheet_uri(), array( 'hareka-theme-css' ), $style_ver );

    // テーマ用インタラクティブスクリプト（タブ切り替え、FAQ、空き状況、スクロールモーション等）
    $js_ver = file_exists( $theme_dir . '/assets/js/main.js' ) ? filemtime( $theme_dir . '/assets/js/main.js' ) : '1.0.0';
    wp_enqueue_script( 'hareka-main-js', $theme_uri . '/assets/js/main.js', array(), $js_ver, true );

    // JavaScriptへデータを渡す（APIエンドポイントやnonce、店舗情報など）
    wp_localize_script( 'hareka-main-js', 'harekaThemeData', array(
        'rootUrl'     => get_site_url(),
        'restUrl'     => esc_url_raw( rest_url() ),
        'themeUrl'    => $theme_uri,
        'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
        'contactNonce'=> wp_create_nonce( 'hareka_contact_nonce' ),
        'shopInfo'    => hareka_get_shop_info(),
    ) );
}
add_action( 'wp_enqueue_scripts', 'hareka_theme_scripts' );

/**
 * カスタム投稿タイプ＆タクソノミー登録
 */
function hareka_register_custom_post_types() {
    // 1. カフェメニュー (menu_item)
    $menu_labels = array(
        'name'               => 'メニュー',
        'singular_name'      => 'メニュー項目',
        'menu_name'          => 'カフェメニュー',
        'add_new'            => '新規メニュー追加',
        'add_new_item'       => '新規メニューを追加',
        'edit_item'          => 'メニューを編集',
        'all_items'          => 'すべてのメニュー',
    );
    $menu_args = array(
        'labels'             => $menu_labels,
        'public'             => true,
        'has_archive'        => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true, // REST API (Gutenberg & Headless) 有効
        'rest_base'          => 'menu_items',
        'menu_icon'          => 'dashicons-food',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt', 'page-attributes' ),
        'rewrite'            => array( 'slug' => 'menu-item' ),
    );
    register_post_type( 'menu_item', $menu_args );

    // メニューカテゴリ (menu_category)
    $cat_labels = array(
        'name'              => 'メニューカテゴリ',
        'singular_name'     => 'メニューカテゴリ',
        'search_items'      => 'カテゴリを検索',
        'all_items'         => 'すべてのカテゴリ',
        'edit_item'         => 'カテゴリを編集',
        'update_item'       => 'カテゴリを更新',
        'add_new_item'      => '新規カテゴリを追加',
        'new_item_name'     => '新しいカテゴリ名',
        'menu_name'         => 'メニューカテゴリ',
    );
    $cat_args = array(
        'hierarchical'      => true,
        'labels'            => $cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'menu-category' ),
    );
    register_taxonomy( 'menu_category', array( 'menu_item' ), $cat_args );

    // メニュータグ (menu_tag) - #数量限定、#看板メニュー等
    $tag_labels = array(
        'name'              => 'メニュータグ',
        'singular_name'     => 'メニュータグ',
        'search_items'      => 'タグを検索',
        'all_items'         => 'すべてのタグ',
        'edit_item'         => 'タグを編集',
        'update_item'       => 'タグを更新',
        'add_new_item'      => '新規タグを追加',
        'new_item_name'     => '新しいタグ名',
        'menu_name'         => 'メニュータグ',
    );
    $tag_args = array(
        'hierarchical'      => false,
        'labels'            => $tag_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'menu-tag' ),
    );
    register_taxonomy( 'menu_tag', array( 'menu_item' ), $tag_args );

    // 2. 岡山の果物図鑑 (fruit_info)
    $fruit_labels = array(
        'name'               => '岡山の果物図鑑',
        'singular_name'      => '果物情報',
        'menu_name'          => '果物図鑑',
        'add_new'            => '新規果物追加',
        'add_new_item'       => '新しい果物情報を追加',
        'edit_item'          => '果物情報を編集',
        'all_items'          => 'すべての果物',
    );
    $fruit_args = array(
        'labels'             => $fruit_labels,
        'public'             => true,
        'has_archive'        => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'rest_base'          => 'fruit_info',
        'menu_icon'          => 'dashicons-palmtree',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt' ),
        'rewrite'            => array( 'slug' => 'fruit' ),
    );
    register_post_type( 'fruit_info', $fruit_args );
}
add_action( 'init', 'hareka_register_custom_post_types' );

/**
 * メニューカテゴリの初期ターム自動登録
 */
function hareka_ensure_default_menu_categories() {
    $defaults = array(
        'sweets'  => '旬果スイーツ',
        'lunch'   => 'ランチ・軽食',
        'drinks'  => 'ドリンク',
        'takeout' => 'テイクアウト・ギフト',
    );
    foreach ( $defaults as $slug => $name ) {
        if ( ! term_exists( $slug, 'menu_category' ) && ! term_exists( $name, 'menu_category' ) ) {
            wp_insert_term( $name, 'menu_category', array( 'slug' => $slug ) );
        }
    }
}
add_action( 'init', 'hareka_ensure_default_menu_categories', 20 );

/**
 * カスタムフィールド（メタボックス）の登録
 */
function hareka_add_custom_meta_boxes() {
    // 1. 通常投稿（お知らせ）用：直感的な3択種別ラジオボタン（右サイドバー配置）
    add_meta_box(
        'hareka_post_category_box',
        '📢 お知らせ種別（必須選択）',
        'hareka_render_post_category_box',
        'post',
        'side',
        'high'
    );

    // 2. メニュー項目用メタボックス（右サイドバーに配置して見落としを防止）
    add_meta_box(
        'hareka_menu_details',
        '🍽️ メニュー詳細設定（価格・産地等）',
        'hareka_render_menu_meta_box',
        'menu_item',
        'side',
        'high'
    );

    // 3. 果物図鑑用メタボックス
    add_meta_box(
        'hareka_fruit_details',
        '果物詳細設定（読み方・旬・糖度・契約農家）',
        'hareka_render_fruit_meta_box',
        'fruit_info',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'hareka_add_custom_meta_boxes' );

// 通常投稿（お知らせ）用の3択ラジオボタン入力フォーム
function hareka_render_post_category_box( $post ) {
    wp_nonce_field( 'hareka_post_cat_save', 'hareka_post_cat_nonce' );

    $categories = get_the_category( $post->ID );
    $current_cat_name = ! empty( $categories ) ? $categories[0]->name : 'お知らせ';

    $options = array(
        'お知らせ' => array(
            'icon'  => '📢',
            'desc'  => '営業時間・休業日・店舗案内・新メニューなど',
            'bg'    => '#fef2ee',
            'color' => '#b54737',
        ),
        '旬の入荷' => array(
            'icon'  => '🍇',
            'desc'  => '白桃・シャインマスカット・ピオーネ等の産直入荷',
            'bg'    => '#f4f8f0',
            'color' => '#4a8235',
        ),
        'イベント' => array(
            'icon'  => '🎪',
            'desc'  => '週末限定体験・試食ワークショップ・テラス企画など',
            'bg'    => '#faf7f2',
            'color' => '#574636',
        ),
    );
    ?>
    <div style="display:flex;flex-direction:column;gap:8px;padding:4px 0;">
        <p style="font-size:11px;color:#6b5a4d;margin:0 0 4px;line-height:1.4;">
            記事の内容に合わせて3つの中から選んでください（Webサイト上でカラーバッジが自動表示されます）。
        </p>
        <?php foreach ( $options as $name => $opt ) : ?>
            <label style="display:flex;align-items:flex-start;gap:8px;padding:8px 10px;border-radius:8px;border:1px solid #d8c8b2;background:<?php echo $opt['bg']; ?>;cursor:pointer;">
                <input
                    type="radio"
                    name="hareka_news_category"
                    value="<?php echo esc_attr( $name ); ?>"
                    <?php checked( $current_cat_name, $name ); ?>
                    style="margin-top:2px;"
                />
                <div style="flex:1;">
                    <div style="display:flex;align-items:center;gap:4px;">
                        <span><?php echo $opt['icon']; ?></span>
                        <strong style="font-size:12px;color:<?php echo $opt['color']; ?>;"><?php echo esc_html( $name ); ?></strong>
                    </div>
                    <div style="font-size:10px;color:#6b5a4d;margin-top:2px;line-height:1.3;">
                        <?php echo esc_html( $opt['desc'] ); ?>
                    </div>
                </div>
            </label>
        <?php endforeach; ?>
    </div>
    <?php
}

// メニュー項目の入力フォーム（右サイドバー・ブロックエディタ最適化UI）
function hareka_render_menu_meta_box( $post ) {
    wp_nonce_field( 'hareka_menu_save_meta', 'hareka_menu_meta_nonce' );

    $price = get_post_meta( $post->ID, '_hareka_price', true );
    $origin = get_post_meta( $post->ID, '_hareka_origin', true );
    $sugar = get_post_meta( $post->ID, '_hareka_sugar', true );
    $seasonal = get_post_meta( $post->ID, '_hareka_seasonal', true );
    $takeout = get_post_meta( $post->ID, '_hareka_takeout', true );
    $featured = get_post_meta( $post->ID, '_hareka_featured', true );

    // 特徴タグ取得（メタフィールドまたはmenu_tagタクソノミー）
    $tags_meta = get_post_meta( $post->ID, '_hareka_tags', true );
    if ( empty( $tags_meta ) ) {
        $terms = get_the_terms( $post->ID, 'menu_tag' );
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            $tags_meta = implode( ', ', wp_list_pluck( $terms, 'name' ) );
        }
    }
    if ( empty( $tags_meta ) ) {
        $title = $post->post_title;
        if ( mb_strpos( $title, '清水白桃' ) !== false ) {
            $tags_meta = '数量限定, 看板メニュー, 朝採れ果実';
        } elseif ( mb_strpos( $title, '晴王' ) !== false || mb_strpos( $title, 'シャインマスカット' ) !== false ) {
            $tags_meta = 'おすすめ, 皮ごと果実, 手土産可';
        }
    }
    $tags_str = is_array( $tags_meta ) ? implode( ', ', $tags_meta ) : (string) $tags_meta;

    // カテゴリ取得（menu_categoryタクソノミーまたはメタ）
    $current_cat = get_post_meta( $post->ID, '_hareka_category', true );
    if ( ! $current_cat ) {
        $terms = get_the_terms( $post->ID, 'menu_category' );
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            $current_cat = $terms[0]->slug;
        }
    }
    if ( ! $current_cat ) {
        $title = $post->post_title;
        if ( preg_match( '/カレー|サンド|パスタ|ランチ|ピザ|プレート/u', $title ) ) {
            $current_cat = 'lunch';
        } elseif ( preg_match( '/コーヒー|珈琲|ティー|お茶|ラテ|ジュース|ソーダ|スムージー|ドリンク/u', $title ) ) {
            $current_cat = 'drinks';
        } else {
            $current_cat = 'sweets';
        }
    }

    $cat_options = array(
        'sweets' => array(
            'icon'  => '🍑',
            'name'  => '旬果スイーツ',
            'en'    => 'SWEETS',
            'desc'  => 'パフェ・タルト・ケーキ・旬の果実デザート',
            'bg'    => '#fef2ee',
            'color' => '#b54737',
        ),
        'lunch' => array(
            'icon'  => '🥗',
            'name'  => 'ランチ・軽食',
            'en'    => 'LUNCH',
            'desc'  => '千屋牛カレー・地場野菜サンド・パスタ等',
            'bg'    => '#f4f8f0',
            'color' => '#4a8235',
        ),
        'drinks' => array(
            'icon'  => '☕',
            'name'  => 'ドリンク',
            'en'    => 'DRINKS',
            'desc'  => '果実スムージー・珈琲・クラフトソーダ等',
            'bg'    => '#faf7f2',
            'color' => '#574636',
        ),
        'takeout' => array(
            'icon'  => '🎁',
            'name'  => 'テイクアウト・ギフト',
            'en'    => 'TAKEOUT',
            'desc'  => '手土産ギフト・焼き菓子BOX・ジャム等',
            'bg'    => '#fbf5e6',
            'color' => '#b45309',
        ),
    );
    ?>
    <div style="display:flex;flex-direction:column;gap:14px;padding:4px 0;">
        <!-- メニューカテゴリ（必須選択） -->
        <div style="background:#faf7f2;border:1px solid #d8c8b2;padding:10px;border-radius:8px;">
            <label style="display:block;font-weight:700;margin-bottom:6px;color:#392d23;font-size:12px;">
                🍽️ メニューカテゴリ <span style="color:#d9534f;font-weight:normal;">*タブ表示に連動</span>
            </label>
            <div style="display:flex;flex-direction:column;gap:6px;">
                <?php foreach ( $cat_options as $slug => $opt ) : ?>
                    <label style="display:flex;align-items:flex-start;gap:8px;padding:6px 8px;border-radius:6px;border:1px solid #e7dac5;background:<?php echo $opt['bg']; ?>;cursor:pointer;">
                        <input
                            type="radio"
                            name="hareka_menu_category"
                            value="<?php echo esc_attr( $slug ); ?>"
                            <?php checked( $current_cat, $slug ); ?>
                            style="margin-top:2px;"
                        />
                        <div style="flex:1;">
                            <div style="display:flex;align-items:center;gap:4px;">
                                <span><?php echo $opt['icon']; ?></span>
                                <strong style="font-size:12px;color:<?php echo $opt['color']; ?>;"><?php echo esc_html( $opt['name'] ); ?></strong>
                                <span style="font-size:9px;color:#8c735d;font-weight:normal;">(<?php echo esc_html( $opt['en'] ); ?>)</span>
                            </div>
                            <div style="font-size:10px;color:#6b5a4d;margin-top:1px;line-height:1.2;">
                                <?php echo esc_html( $opt['desc'] ); ?>
                            </div>
                        </div>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div style="background:#fef2ee;border:1px solid #fbc6b6;padding:10px;border-radius:8px;">
            <label for="hareka_price" style="display:block;font-weight:700;margin-bottom:4px;color:#b54737;font-size:13px;">
                💰 税込価格 (円) <span style="color:#d9534f;font-weight:normal;">*重要</span>
            </label>
            <div style="display:flex;align-items:center;gap:6px;">
                <span style="font-weight:bold;color:#555;font-size:15px;">¥</span>
                <input
                    type="number"
                    id="hareka_price"
                    name="hareka_price"
                    value="<?php echo esc_attr( $price ); ?>"
                    style="width:100%;font-size:15px;font-weight:bold;padding:6px 8px;border:1px solid #d8c8b2;border-radius:4px;"
                    placeholder="例: 1480"
                    min="0"
                />
            </div>
            <p style="font-size:11px;color:#8c735d;margin:4px 0 0;line-height:1.4;">
                ※数字のみ入力してください。未入力のままだとWebサイト上で「価格設定中」と表示されます。
            </p>
        </div>

        <div>
            <label for="hareka_origin" style="display:block;font-weight:600;margin-bottom:4px;color:#333;font-size:12px;">
                📍 契約農家・産地表示
            </label>
            <input
                type="text"
                id="hareka_origin"
                name="hareka_origin"
                value="<?php echo esc_attr( $origin ); ?>"
                style="width:100%;padding:6px 8px;font-size:12px;border:1px solid #ccc;border-radius:4px;"
                placeholder="例: 赤磐市・吉井果樹園 直送"
            />
        </div>

        <div>
            <label for="hareka_sugar" style="display:block;font-weight:600;margin-bottom:4px;color:#333;font-size:12px;">
                🍇 糖度表示（任意）
            </label>
            <input
                type="text"
                id="hareka_sugar"
                name="hareka_sugar"
                value="<?php echo esc_attr( $sugar ); ?>"
                style="width:100%;padding:6px 8px;font-size:12px;border:1px solid #ccc;border-radius:4px;"
                placeholder="例: 糖度18度以上"
            />
        </div>

        <!-- 特徴タグ（ハッシュタグ） -->
        <div style="background:#faf7f2;border:1px solid #d8c8b2;padding:10px;border-radius:8px;">
            <label for="hareka_tags" style="display:block;font-weight:700;margin-bottom:4px;color:#392d23;font-size:12px;">
                🏷️ 特徴タグ（#ハッシュタグ）
            </label>
            <input
                type="text"
                id="hareka_tags"
                name="hareka_tags"
                value="<?php echo esc_attr( $tags_str ); ?>"
                style="width:100%;padding:6px 8px;font-size:12px;border:1px solid #ccc;border-radius:4px;background:#fff;"
                placeholder="例: 数量限定, 看板メニュー, 朝採れ果実"
            />
            <div style="margin-top:6px;">
                <span style="font-size:10px;color:#8c735d;display:block;margin-bottom:4px;">クリックで追加:</span>
                <div style="display:flex;flex-wrap:wrap;gap:4px;" id="hareka-tag-presets">
                    <button type="button" class="button button-small hareka-tag-btn" data-tag="数量限定">#数量限定</button>
                    <button type="button" class="button button-small hareka-tag-btn" data-tag="看板メニュー">#看板メニュー</button>
                    <button type="button" class="button button-small hareka-tag-btn" data-tag="朝採れ果実">#朝採れ果実</button>
                    <button type="button" class="button button-small hareka-tag-btn" data-tag="おすすめ">#おすすめ</button>
                    <button type="button" class="button button-small hareka-tag-btn" data-tag="皮ごと果実">#皮ごと果実</button>
                    <button type="button" class="button button-small hareka-tag-btn" data-tag="手土産可">#手土産可</button>
                    <button type="button" class="button button-small hareka-tag-btn" data-tag="グルテンフリー米粉">#グルテンフリー米粉</button>
                    <button type="button" class="button button-small hareka-tag-btn" data-tag="焼き立て">#焼き立て</button>
                    <button type="button" class="button button-small hareka-tag-btn" data-tag="自家製">#自家製</button>
                </div>
            </div>
            <p style="font-size:10px;color:#8c735d;margin:4px 0 0;line-height:1.3;">
                ※カンマ（,）区切りで複数入力可能。「#」は自動付与されます。
            </p>
            <script>
            (function(){
                document.querySelectorAll('.hareka-tag-btn').forEach(function(btn){
                    btn.addEventListener('click', function(e){
                        e.preventDefault();
                        var tag = this.getAttribute('data-tag');
                        var input = document.getElementById('hareka_tags');
                        if (!input) return;
                        var cur = input.value ? input.value.split(/[,、\s]+/).filter(Boolean) : [];
                        if (cur.indexOf(tag) === -1) {
                            cur.push(tag);
                            input.value = cur.join(', ');
                        }
                    });
                });
            })();
            </script>
        </div>

        <div style="border-top:1px solid #eee;padding-top:10px;">
            <span style="display:block;font-weight:600;margin-bottom:8px;color:#333;font-size:12px;">
                🏷️ バッジ・表示設定
            </span>
            <div style="display:flex;flex-direction:column;gap:8px;font-size:12px;color:#444;">
                <label style="cursor:pointer;display:flex;align-items:center;gap:6px;">
                    <input type="checkbox" name="hareka_seasonal" value="1" <?php checked( $seasonal, '1' ); ?> />
                    <span>🌸 季節・旬果限定バッジ</span>
                </label>
                <label style="cursor:pointer;display:flex;align-items:center;gap:6px;">
                    <input type="checkbox" name="hareka_takeout" value="1" <?php checked( $takeout, '1' ); ?> />
                    <span>🥡 テイクアウト可</span>
                </label>
                <label style="cursor:pointer;display:flex;align-items:center;gap:6px;">
                    <input type="checkbox" name="hareka_featured" value="1" <?php checked( $featured, '1' ); ?> />
                    <span>⭐ TOPページおすすめ枠</span>
                </label>
            </div>
        </div>

        <!-- 表示順序（並び替え） -->
        <div style="border-top:1px solid #eee;padding-top:10px;">
            <label for="menu_order" style="display:block;font-weight:600;margin-bottom:4px;color:#333;font-size:12px;">
                ↕️ 表示順序（並び順）
            </label>
            <input
                type="number"
                id="menu_order"
                name="menu_order"
                value="<?php echo esc_attr( $post->menu_order ); ?>"
                style="width:90px;padding:4px 8px;font-size:12px;border:1px solid #ccc;border-radius:4px;"
                min="0"
                step="1"
            />
            <p style="font-size:10px;color:#666;margin:4px 0 0;line-height:1.4;">
                ※数字が小さいほど先頭に表示されます。<br>※メニュー一覧画面でドラッグ＆ドロップでも直感的に並び替えが可能です。
            </p>
        </div>
    </div>
    <?php
}

// 果物情報の入力フォーム
function hareka_render_fruit_meta_box( $post ) {
    wp_nonce_field( 'hareka_fruit_save_meta', 'hareka_fruit_meta_nonce' );

    $reading = get_post_meta( $post->ID, '_hareka_reading', true );
    $season = get_post_meta( $post->ID, '_hareka_season', true );
    $sugar = get_post_meta( $post->ID, '_hareka_fruit_sugar', true );
    $farm = get_post_meta( $post->ID, '_hareka_fruit_farm', true );
    $features = get_post_meta( $post->ID, '_hareka_features', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="hareka_reading">読みがな (ひらがな)</label></th>
            <td><input type="text" id="hareka_reading" name="hareka_reading" value="<?php echo esc_attr( $reading ); ?>" style="width:200px;" placeholder="しみずはくとう" /></td>
        </tr>
        <tr>
            <th><label for="hareka_season">旬の時期</label></th>
            <td><input type="text" id="hareka_season" name="hareka_season" value="<?php echo esc_attr( $season ); ?>" style="width:100%;" placeholder="7月下旬 〜 8月上旬" /></td>
        </tr>
        <tr>
            <th><label for="hareka_fruit_sugar">糖度目安</label></th>
            <td><input type="text" id="hareka_fruit_sugar" name="hareka_fruit_sugar" value="<?php echo esc_attr( $sugar ); ?>" style="width:200px;" placeholder="糖度 13〜15度" /></td>
        </tr>
        <tr>
            <th><label for="hareka_fruit_farm">提携・契約農園</label></th>
            <td><input type="text" id="hareka_fruit_farm" name="hareka_fruit_farm" value="<?php echo esc_attr( $farm ); ?>" style="width:100%;" placeholder="岡山県赤磐市・吉井ファーム" /></td>
        </tr>
        <tr>
            <th><label for="hareka_features">美味しさの特徴（改行区切りで4点）</label></th>
            <td><textarea id="hareka_features" name="hareka_features" rows="4" style="width:100%;" placeholder="袋掛け栽培による上品な乳白色の果肌&#10;手で剥けるほど柔らかく緻密な果肉"><?php echo esc_textarea( $features ); ?></textarea></td>
        </tr>
    </table>
    <?php
}

// メタボックスの保存処理
function hareka_save_custom_meta( $post_id ) {
    // メニュー保存
    if ( isset( $_POST['hareka_menu_meta_nonce'] ) && wp_verify_nonce( $_POST['hareka_menu_meta_nonce'], 'hareka_menu_save_meta' ) ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if ( ! current_user_can( 'edit_post', $post_id ) ) return;

        update_post_meta( $post_id, '_hareka_price', sanitize_text_field( $_POST['hareka_price'] ?? '' ) );
        update_post_meta( $post_id, '_hareka_origin', sanitize_text_field( $_POST['hareka_origin'] ?? '' ) );
        update_post_meta( $post_id, '_hareka_sugar', sanitize_text_field( $_POST['hareka_sugar'] ?? '' ) );
        update_post_meta( $post_id, '_hareka_seasonal', isset( $_POST['hareka_seasonal'] ) ? '1' : '0' );
        update_post_meta( $post_id, '_hareka_takeout', isset( $_POST['hareka_takeout'] ) ? '1' : '0' );
        update_post_meta( $post_id, '_hareka_featured', isset( $_POST['hareka_featured'] ) ? '1' : '0' );

        // 特徴タグ（_hareka_tags & menu_tagタクソノミー）の保存
        if ( isset( $_POST['hareka_tags'] ) ) {
            $tags_raw = sanitize_text_field( $_POST['hareka_tags'] );
            $tags_arr = array_filter( array_map( function( $t ) {
                return ltrim( trim( $t ), '#' );
            }, preg_split( '/[,、\s]+/u', $tags_raw ) ) );
            $tags_str = implode( ', ', $tags_arr );
            update_post_meta( $post_id, '_hareka_tags', $tags_str );

            // menu_tag タクソノミーにも同期
            wp_set_post_terms( $post_id, $tags_arr, 'menu_tag' );
        }

        // カテゴリ（menu_category）の保存
        if ( isset( $_POST['hareka_menu_category'] ) ) {
            $cat_slug = sanitize_text_field( $_POST['hareka_menu_category'] );
            update_post_meta( $post_id, '_hareka_category', $cat_slug );

            $term = get_term_by( 'slug', $cat_slug, 'menu_category' );
            if ( $term ) {
                wp_set_object_terms( $post_id, (int) $term->term_id, 'menu_category' );
            } else {
                wp_set_object_terms( $post_id, $cat_slug, 'menu_category' );
            }
        }

        // 表示順序（menu_order）の保存
        if ( isset( $_POST['menu_order'] ) ) {
            $menu_order = (int) $_POST['menu_order'];
            global $wpdb;
            $wpdb->update(
                $wpdb->posts,
                array( 'menu_order' => $menu_order ),
                array( 'ID' => $post_id ),
                array( '%d' ),
                array( '%d' )
            );
            clean_post_cache( $post_id );
        }
    }

    // 果物情報保存
    if ( isset( $_POST['hareka_fruit_meta_nonce'] ) && wp_verify_nonce( $_POST['hareka_fruit_meta_nonce'], 'hareka_fruit_save_meta' ) ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if ( ! current_user_can( 'edit_post', $post_id ) ) return;

        update_post_meta( $post_id, '_hareka_reading', sanitize_text_field( $_POST['hareka_reading'] ?? '' ) );
        update_post_meta( $post_id, '_hareka_season', sanitize_text_field( $_POST['hareka_season'] ?? '' ) );
        update_post_meta( $post_id, '_hareka_fruit_sugar', sanitize_text_field( $_POST['hareka_fruit_sugar'] ?? '' ) );
        update_post_meta( $post_id, '_hareka_fruit_farm', sanitize_text_field( $_POST['hareka_fruit_farm'] ?? '' ) );
        update_post_meta( $post_id, '_hareka_features', sanitize_textarea_field( $_POST['hareka_features'] ?? '' ) );
    }
}
add_action( 'save_post', 'hareka_save_custom_meta' );

/**
 * 管理画面のメニュー一覧テーブルに並び順・価格・産地・カテゴリ一覧カラムを追加
 */
function hareka_set_menu_item_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $title ) {
        if ( $key === 'title' ) {
            $new_columns['menu_order_col'] = '↕ 並び順';
        }
        $new_columns[$key] = $title;
        if ( $key === 'title' ) {
            $new_columns['menu_category'] = '📁 カテゴリ';
            $new_columns['menu_price']    = '💰 税込価格';
            $new_columns['menu_origin']   = '📍 産地・契約農家';
            $new_columns['menu_tags']     = '🏷️ 特徴タグ';
        }
    }
    return $new_columns;
}
add_filter( 'manage_menu_item_posts_columns', 'hareka_set_menu_item_columns' );

// ソート可能カラムとして登録
add_filter( 'manage_edit-menu_item_sortable_columns', function( $columns ) {
    $columns['menu_order_col'] = 'menu_order';
    return $columns;
} );

function hareka_custom_menu_item_column( $column, $post_id ) {
    if ( $column === 'menu_order_col' ) {
        $p = get_post( $post_id );
        $num = $p ? (int) $p->menu_order : 0;
        echo '<span class="hareka-drag-handle" title="ドラッグして上下に並び替えできます">';
        echo '<span class="dashicons dashicons-move"></span>';
        echo '<span class="hareka-order-number">' . esc_html( $num ) . '</span>';
        echo '</span>';
    }
    if ( $column === 'menu_category' ) {
        $terms = get_the_terms( $post_id, 'menu_category' );
        $cat_badges = array(
            'sweets'  => array( 'name' => '🍑 旬果スイーツ', 'bg' => '#fef2ee', 'color' => '#b54737', 'border' => '#fbc6b6' ),
            'lunch'   => array( 'name' => '🥗 ランチ・軽食', 'bg' => '#f4f8f0', 'color' => '#4a8235', 'border' => '#a9d997' ),
            'drinks'  => array( 'name' => '☕ ドリンク', 'bg' => '#faf7f2', 'color' => '#574636', 'border' => '#d8c8b2' ),
            'takeout' => array( 'name' => '🎁 テイクアウト', 'bg' => '#fbf5e6', 'color' => '#b45309', 'border' => '#fcd34d' ),
        );
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                $style = $cat_badges[$term->slug] ?? array( 'name' => $term->name, 'bg' => '#faf7f2', 'color' => '#574636', 'border' => '#d8c8b2' );
                echo '<span style="display:inline-block;margin:2px;font-weight:600;color:' . esc_attr( $style['color'] ) . ';background:' . esc_attr( $style['bg'] ) . ';border:1px solid ' . esc_attr( $style['border'] ) . ';padding:2px 8px;border-radius:12px;font-size:11px;">' . esc_html( $style['name'] ) . '</span>';
            }
        } else {
            echo '<span style="color:#d9534f;font-weight:bold;background:#fef2ee;border:1px solid #fbc6b6;padding:2px 6px;border-radius:4px;font-size:11px;">⚠️ 未設定</span>';
        }
    }
    if ( $column === 'menu_price' ) {
        $price = get_post_meta( $post_id, '_hareka_price', true );
        if ( $price !== '' && is_numeric( $price ) && (int)$price > 0 ) {
            echo '<span style="font-weight:bold;color:#2b6cb0;font-size:13px;">¥' . number_format( (int)$price ) . '</span>';
        } else {
            echo '<span style="color:#d9534f;font-weight:bold;background:#fef2ee;padding:2px 6px;border-radius:4px;font-size:11px;">⚠️ 未設定 (¥0)</span>';
        }
    }
    if ( $column === 'menu_origin' ) {
        $origin = get_post_meta( $post_id, '_hareka_origin', true );
        echo $origin ? esc_html( $origin ) : '<span style="color:#999;">—</span>';
    }
    if ( $column === 'menu_tags' ) {
        $tags_meta = get_post_meta( $post_id, '_hareka_tags', true );
        $tags = array();
        if ( ! empty( $tags_meta ) ) {
            $tags = is_array( $tags_meta ) ? $tags_meta : array_filter( array_map( 'trim', preg_split( '/[,、\s]+/u', $tags_meta ) ) );
        } else {
            $terms = get_the_terms( $post_id, 'menu_tag' );
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                $tags = wp_list_pluck( $terms, 'name' );
            }
        }
        if ( empty( $tags ) ) {
            $p_title = get_the_title( $post_id );
            if ( mb_strpos( $p_title, '清水白桃' ) !== false ) {
                $tags = array( '数量限定', '看板メニュー', '朝採れ果実' );
            } elseif ( mb_strpos( $p_title, '晴王' ) !== false || mb_strpos( $p_title, 'シャインマスカット' ) !== false ) {
                $tags = array( 'おすすめ', '皮ごと果実', '手土産可' );
            }
        }
        if ( ! empty( $tags ) ) {
            foreach ( $tags as $t ) {
                echo '<span style="display:inline-block;margin:1px 2px;background:#faf7f2;color:#8c735d;border:1px solid #e7dac5;padding:1px 6px;border-radius:4px;font-size:10px;">#' . esc_html( ltrim( trim( $t ), '#' ) ) . '</span>';
            }
        } else {
            echo '<span style="color:#bbb;font-size:11px;">—</span>';
        }
    }
}
add_action( 'manage_menu_item_posts_custom_column', 'hareka_custom_menu_item_column', 10, 2 );

/**
 * 管理画面メニュー一覧のデフォルト並び順を menu_order 昇順（並び替え順）に設定
 */
function hareka_admin_menu_item_order( $query ) {
    if ( is_admin() && $query->is_main_query() && $query->get( 'post_type' ) === 'menu_item' ) {
        if ( ! isset( $_GET['orderby'] ) ) {
            $query->set( 'orderby', 'menu_order' );
            $query->set( 'order', 'ASC' );
        }
    }
}
add_action( 'pre_get_posts', 'hareka_admin_menu_item_order' );

/**
 * メニュー一覧でのドラッグ＆ドロップ並び替えスクリプト & CSS
 */
function hareka_admin_menu_sortable_scripts( $hook ) {
    global $post_type;
    if ( $hook === 'edit.php' && $post_type === 'menu_item' ) {
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_localize_script( 'jquery-ui-sortable', 'harekaOrderData', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'hareka_menu_order_nonce' ),
        ) );

        $custom_js = "
        jQuery(function($) {
            var \$tbody = $('#the-list');
            if (!\$tbody.length) return;

            // ドラッグ並び替えの初期化
            \$tbody.sortable({
                items: 'tr',
                cursor: 'grabbing',
                axis: 'y',
                handle: '.hareka-drag-handle, .column-menu_order_col',
                placeholder: 'ui-sortable-placeholder',
                helper: function(e, tr) {
                    var \$originals = tr.children();
                    var \$helper = tr.clone();
                    \$helper.children().each(function(index) {
                        \$(this).width(\$originals.eq(index).width());
                    });
                    return \$helper;
                },
                start: function(e, ui) {
                    ui.placeholder.height(ui.item.height());
                },
                update: function(event, ui) {
                    var orderData = [];
                    \$tbody.find('tr').each(function(index) {
                        var idAttr = \$(this).attr('id');
                        if (idAttr && idAttr.indexOf('post-') === 0) {
                            var postId = idAttr.replace('post-', '');
                            orderData.push(postId);
                            \$(this).find('.hareka-order-number').text(index + 1);
                        }
                    });

                    showToast('並び順を更新中...', 'info');

                    $.ajax({
                        url: harekaOrderData.ajaxurl,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            action: 'hareka_save_menu_order',
                            order: orderData,
                            nonce: harekaOrderData.nonce
                        },
                        success: function(res) {
                            if (res && res.success) {
                                showToast('✅ メニューの並び順を保存しました', 'success');
                            } else {
                                showToast('⚠️ 並び順の保存に失敗しました', 'error');
                            }
                        },
                        error: function() {
                            showToast('⚠️ 通信エラーが発生しました', 'error');
                        }
                    });
                }
            });

            function showToast(msg, type) {
                var \$toast = $('#hareka-order-toast');
                if (!\$toast.length) {
                    \$toast = $('<div id=\"hareka-order-toast\" style=\"position:fixed;bottom:24px;right:24px;z-index:999999;padding:12px 20px;border-radius:8px;font-size:13px;font-weight:600;box-shadow:0 6px 16px rgba(0,0,0,0.18);transition:all 0.3s ease;transform:translateY(20px);opacity:0;\"></div>').appendTo('body');
                }
                var bg = type === 'success' ? '#2e7d32' : (type === 'error' ? '#c62828' : '#1565c0');
                \$toast.css({ background: bg, color: '#fff', transform: 'translateY(0)', opacity: '1' }).text(msg);
                if (type !== 'info') {
                    setTimeout(function() {
                        \$toast.css({ transform: 'translateY(20px)', opacity: '0' });
                    }, 2500);
                }
            }
        });
        ";
        wp_add_inline_script( 'jquery-ui-sortable', $custom_js );

        $custom_css = "
        .wp-list-table.posts tr.ui-sortable-helper {
            background-color: #fef9f5 !important;
            box-shadow: 0 4px 16px rgba(0,0,0,0.2) !important;
            display: table !important;
        }
        .wp-list-table.posts tr.ui-sortable-placeholder {
            visibility: visible !important;
            background-color: #fdf5f0 !important;
            border: 2px dashed #b54737 !important;
            height: 48px !important;
        }
        .hareka-drag-handle {
            cursor: grab;
            color: #8c735d;
            display: inline-flex;
            align-items: center;
            gap: 2px;
            padding: 3px 6px;
            border-radius: 4px;
            background: #faf7f2;
            border: 1px solid #e7dac5;
            font-weight: 600;
            font-size: 11px;
            user-select: none;
        }
        .hareka-drag-handle:hover {
            background: #f5ede2;
            border-color: #b54737;
            color: #b54737;
        }
        .hareka-drag-handle:active {
            cursor: grabbing;
            background: #b54737;
            color: #fff;
        }
        .column-menu_order_col {
            width: 80px;
            text-align: center;
        }
        ";
        wp_add_inline_style( 'wp-admin', $custom_css );
    }
}
add_action( 'admin_enqueue_scripts', 'hareka_admin_menu_sortable_scripts' );

/**
 * AJAX: ドラッグ＆ドロップによるメニュー並び順（menu_order）の一括保存
 */
function hareka_save_menu_order_callback() {
    check_ajax_referer( 'hareka_menu_order_nonce', 'nonce' );
    if ( ! current_user_can( 'edit_posts' ) ) {
        wp_send_json_error( array( 'message' => '権限がありません' ) );
    }
    $order_ids = $_POST['order'] ?? array();
    if ( ! is_array( $order_ids ) || empty( $order_ids ) ) {
        wp_send_json_error( array( 'message' => '無効なデータです' ) );
    }

    global $wpdb;
    foreach ( $order_ids as $index => $post_id ) {
        $post_id = (int) $post_id;
        $menu_order = (int) $index + 1;
        $wpdb->update(
            $wpdb->posts,
            array( 'menu_order' => $menu_order ),
            array( 'ID' => $post_id ),
            array( '%d' ),
            array( '%d' )
        );
        clean_post_cache( $post_id );
    }
    wp_send_json_success( array( 'message' => '並び順を更新しました' ) );
}
add_action( 'wp_ajax_hareka_save_menu_order', 'hareka_save_menu_order_callback' );

/**
 * --------------------------------------------------------------------------
 * 通常投稿（お知らせ）の専用UI最適化（3択ラジオボタン・タグ非表示・一覧バッジ）
 * --------------------------------------------------------------------------
 */

// 1. お知らせ種別の保存処理（標準カテゴリーへ自動マッピング）
function hareka_save_post_category( $post_id ) {
    if ( ! isset( $_POST['hareka_post_cat_nonce'] ) || ! wp_verify_nonce( $_POST['hareka_post_cat_nonce'], 'hareka_post_cat_save' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['hareka_news_category'] ) ) {
        $cat_name = sanitize_text_field( $_POST['hareka_news_category'] );
        $term = get_term_by( 'name', $cat_name, 'category' );
        if ( ! $term ) {
            $slug_map = array( 'お知らせ' => 'news', '旬の入荷' => 'seasonal', 'イベント' => 'event' );
            $new_term = wp_insert_term( $cat_name, 'category', array( 'slug' => $slug_map[$cat_name] ?? '' ) );
            if ( ! is_wp_error( $new_term ) ) {
                $term_id = $new_term['term_id'];
            }
        } else {
            $term_id = $term->term_id;
        }

        if ( isset( $term_id ) ) {
            // 選択されたカテゴリー1つだけに設定（重複や未分類を解除）
            wp_set_post_categories( $post_id, array( $term_id ) );
        }
    }
}
add_action( 'save_post', 'hareka_save_post_category' );

// 2. お知らせ用初期カテゴリーの登録と不要な「タグ」の解除
function hareka_setup_news_taxonomies() {
    // お知らせ・旬の入荷・イベント カテゴリーの自動初期化
    $default_cats = array(
        'お知らせ'   => 'news',
        '旬の入荷' => 'seasonal',
        'イベント'   => 'event',
    );
    foreach ( $default_cats as $name => $slug ) {
        if ( ! term_exists( $name, 'category' ) ) {
            wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
        }
    }

    // 投稿者にとって使いづらく不要な「タグ」機能を投稿から解除
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}
add_action( 'init', 'hareka_setup_news_taxonomies' );

// 3. 投稿一覧テーブル（edit.php）のカラムカスタマイズ
function hareka_set_post_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $title ) {
        if ( $key === 'categories' ) {
            $new_columns['hareka_post_type'] = '📢 お知らせ種別';
        } elseif ( $key === 'tags' ) {
            continue; // タグ列は削除
        } else {
            $new_columns[$key] = $title;
        }
    }
    return $new_columns;
}
add_filter( 'manage_post_posts_columns', 'hareka_set_post_columns' );

function hareka_custom_post_column( $column, $post_id ) {
    if ( $column === 'hareka_post_type' ) {
        $cats = get_the_category( $post_id );
        $cat_name = ! empty( $cats ) ? $cats[0]->name : 'お知らせ';

        if ( $cat_name === '旬の入荷' ) {
            echo '<span style="background:#e2f0d9;color:#4a8235;border:1px solid #c4e4b5;padding:3px 10px;border-radius:12px;font-size:11px;font-weight:bold;display:inline-block;">🍇 旬の入荷</span>';
        } elseif ( $cat_name === 'イベント' ) {
            echo '<span style="background:#f4eee3;color:#574636;border:1px solid #e7dac5;padding:3px 10px;border-radius:12px;font-size:11px;font-weight:bold;display:inline-block;">🎪 イベント</span>';
        } else {
            echo '<span style="background:#fde2d9;color:#b54737;border:1px solid #fbc6b6;padding:3px 10px;border-radius:12px;font-size:11px;font-weight:bold;display:inline-block;">📢 お知らせ</span>';
        }
    }
}
add_action( 'manage_post_posts_custom_column', 'hareka_custom_post_column', 10, 2 );

// 4. ブロックエディタの標準カテゴリーパネル（未分類や手動入力欄）を非表示にして専用の3択種別ボックスに一本化
function hareka_admin_news_ui_styles() {
    echo '<style>
        /* ブロックエディタの標準カテゴリーパネルを非表示 */
        .components-panel__body:has(.editor-post-taxonomies__hierarchical-terms-list) {
            display: none !important;
        }
        /* クラシックエディタの場合の標準カテゴリーボックス非表示 */
        #categorydiv {
            display: none !important;
        }
    </style>';
}
add_action( 'admin_head', 'hareka_admin_news_ui_styles' );

/**
 * REST API にカスタムメタフィールドを登録（ヘッドレスWordPress連携用）
 */
function hareka_register_rest_fields() {
    register_rest_field( 'menu_item', 'menu_meta', array(
        'get_callback' => function( $post ) {
            $tags_raw = get_post_meta( $post['id'], '_hareka_tags', true );
            $tags = array();
            if ( ! empty( $tags_raw ) ) {
                $tags = is_array( $tags_raw ) ? $tags_raw : array_filter( array_map( 'trim', preg_split( '/[,、\s]+/u', $tags_raw ) ) );
            } else {
                $terms = get_the_terms( $post['id'], 'menu_tag' );
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                    $tags = wp_list_pluck( $terms, 'name' );
                }
            }
            if ( empty( $tags ) ) {
                $p_title = get_the_title( $post['id'] );
                if ( mb_strpos( $p_title, '清水白桃' ) !== false ) {
                    $tags = array( '数量限定', '看板メニュー', '朝採れ果実' );
                } elseif ( mb_strpos( $p_title, '晴王' ) !== false || mb_strpos( $p_title, 'シャインマスカット' ) !== false ) {
                    $tags = array( 'おすすめ', '皮ごと果実', '手土産可' );
                }
            }
            return array(
                'price'     => (int) get_post_meta( $post['id'], '_hareka_price', true ),
                'origin'    => get_post_meta( $post['id'], '_hareka_origin', true ),
                'sugar'     => get_post_meta( $post['id'], '_hareka_sugar', true ),
                'seasonal'  => get_post_meta( $post['id'], '_hareka_seasonal', true ) === '1',
                'takeout'   => get_post_meta( $post['id'], '_hareka_takeout', true ) === '1',
                'featured'  => get_post_meta( $post['id'], '_hareka_featured', true ) === '1',
                'tags'      => array_values( $tags ),
                'order'     => (int) ( get_post( $post['id'] )->menu_order ?? 0 ),
                'thumbnail' => get_the_post_thumbnail_url( $post['id'], 'hareka-card' ),
            );
        },
        'schema' => null,
    ) );

    register_rest_field( 'fruit_info', 'fruit_meta', array(
        'get_callback' => function( $post ) {
            $features_raw = get_post_meta( $post['id'], '_hareka_features', true );
            $features_arr = array_filter( array_map( 'trim', explode( "\n", $features_raw ) ) );
            return array(
                'reading'   => get_post_meta( $post['id'], '_hareka_reading', true ),
                'season'    => get_post_meta( $post['id'], '_hareka_season', true ),
                'sugar'     => get_post_meta( $post['id'], '_hareka_fruit_sugar', true ),
                'farm'      => get_post_meta( $post['id'], '_hareka_fruit_farm', true ),
                'features'  => array_values( $features_arr ),
                'thumbnail' => get_the_post_thumbnail_url( $post['id'], 'hareka-card' ),
            );
        },
        'schema' => null,
    ) );
}
add_action( 'rest_api_init', 'hareka_register_rest_fields' );

/**
 * --------------------------------------------------------------------------
 * お問い合わせ・席予約フォーム（AJAX送信 & メール通知処理）
 * --------------------------------------------------------------------------
 */
add_action( 'wp_ajax_hareka_submit_booking', 'hareka_submit_booking_callback' );
add_action( 'wp_ajax_nopriv_hareka_submit_booking', 'hareka_submit_booking_callback' );

function hareka_submit_booking_callback() {
    // 1. Nonceチェック（CSRF対策）
    $nonce = $_POST['nonce'] ?? $_POST['hareka_contact_nonce'] ?? '';
    if ( ! wp_verify_nonce( $nonce, 'hareka_contact_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'セッションの有効期限が切れました。ページを再読み込みしてお試しください。' ) );
    }

    // 2. 入力値のサニタイズ
    $inquiry_type   = sanitize_text_field( $_POST['inquiry_type'] ?? '席のご予約' );
    $user_name      = sanitize_text_field( $_POST['user_name'] ?? '' );
    $user_email     = sanitize_email( $_POST['user_email'] ?? '' );
    $user_phone     = sanitize_text_field( $_POST['user_phone'] ?? '' );
    $user_message   = sanitize_textarea_field( $_POST['user_message'] ?? '' );
    $reserve_date   = sanitize_text_field( $_POST['reserve_date'] ?? '' );
    $reserve_time   = sanitize_text_field( $_POST['reserve_time'] ?? '' );
    $reserve_guests = sanitize_text_field( $_POST['reserve_guests'] ?? '2' );
    $seat_type      = sanitize_text_field( $_POST['seat_type'] ?? '店内テーブル席' );

    // 3. バリデーション
    if ( empty( $user_name ) ) {
        wp_send_json_error( array( 'message' => 'お名前を入力してください。' ) );
    }
    if ( empty( $user_email ) || ! is_email( $user_email ) ) {
        wp_send_json_error( array( 'message' => '正しいメールアドレスを入力してください。' ) );
    }
    if ( empty( $user_phone ) ) {
        wp_send_json_error( array( 'message' => 'お電話番号を入力してください。' ) );
    }

    $is_reservation = ( $inquiry_type === '席のご予約' );
    if ( $is_reservation ) {
        if ( empty( $reserve_date ) ) {
            wp_send_json_error( array( 'message' => 'ご来店希望日を選択してください。' ) );
        }
        if ( empty( $reserve_time ) ) {
            wp_send_json_error( array( 'message' => 'ご来店時間枠を選択してください。' ) );
        }
    }

    // 受付番号の生成（HRK-YYYYMMDD-XXXX）
    $date_part = ! empty( $reserve_date ) ? str_replace( '-', '', $reserve_date ) : current_time( 'Ymd' );
    $rand_part = rand( 1000, 9999 );
    $booking_ref = 'HRK-' . $date_part . '-' . $rand_part;

    // 店舗情報取得
    $shop = function_exists( 'hareka_get_shop_info' ) ? hareka_get_shop_info() : array();
    $shop_name  = 'CAFE HAREKA（カフェ ハレカ）';
    $shop_phone = $shop['phone'] ?? '086-XXXX-XXX';
    $shop_hours = $shop['phone_hours'] ?? '10:00 〜 18:00';
    $shop_closed = $shop['closed_day'] ?? '毎週水曜日';
    $shop_address = '〒701-1341 岡山県岡山市北区吉備津780';
    $site_url   = home_url();

    $admin_email = get_option( 'admin_email' );
    if ( ! is_email( $admin_email ) ) {
        $admin_email = 'info@okayamacafe.local';
    }

    // メール送信元ヘッダー
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $shop_name . ' <' . $admin_email . '>',
        'Reply-To: ' . $admin_email,
    );

    // ==========================================
    // A. お客様宛 自動返信メール（控えメール）
    // ==========================================
    if ( $is_reservation ) {
        $cust_subject = "【CAFE HAREKA】ご予約リクエスト（仮予約）を受け付けました [受付番号: {$booking_ref}]";
        $cust_body = "{$user_name} 様\n\n"
            . "この度は、CAFE HAREKA（カフェ ハレカ）へご予約リクエストをいただき、誠にありがとうございます。\n\n"
            . "以下の内容で【仮予約】を受け付けいたしました。\n\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "■ ご予約リクエスト内容\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "【受付番号】 {$booking_ref}\n"
            . "【お申込み種別】 {$inquiry_type}\n"
            . "【ご来店希望日】 {$reserve_date}\n"
            . "【ご来店時間帯】 {$reserve_time}\n"
            . "【ご利用人数】 {$reserve_guests} 名様\n"
            . "【ご希望のお席】 {$seat_type}\n\n"
            . "【お客様氏名】 {$user_name} 様\n"
            . "【お電話番号】 {$user_phone}\n"
            . "【メールアドレス】 {$user_email}\n"
            . "【ご要望・メッセージ】\n" . ( $user_message ? $user_message : '（特になし）' ) . "\n\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "■ 今後の流れについて（※重要）\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "現時点では【仮予約】の状態となっております。\n"
            . "店舗スタッフが配席状況を確認の上、24時間以内に「ご予約確定メール」またはお電話にてご連絡を差し上げます。\n"
            . "確定メールの受信、もしくはお電話での確認完了をもって正式なご予約成立となりますので、今しばらくお待ちくださいますようお願い申し上げます。\n\n"
            . "※当日の仕入れや混雑状況により、ご希望のお席に添えない場合や、お時間の調整をご相談させていただく場合がございます。\n"
            . "※万が一、24時間を経過しても当店からの連絡が届かない場合は、大変お手数ですがお電話（{$shop_phone}）までお問い合わせください。\n\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "■ 店舗情報・お問い合わせ先\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "旬果と寛ぎの古民家カフェ\n"
            . "{$shop_name}\n"
            . "住所: {$shop_address}\n"
            . "電話: {$shop_phone}（受付時間: {$shop_hours}）\n"
            . "定休日: {$shop_closed}\n"
            . "公式サイト: {$site_url}\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "※本メールはWebサイトより自動送信されています。心当たりのない場合は破棄をお願いいたします。\n";
    } else {
        $cust_subject = "【CAFE HAREKA】お問い合わせを受け付けました [受付番号: {$booking_ref}]";
        $cust_body = "{$user_name} 様\n\n"
            . "この度は、CAFE HAREKA（カフェ ハレカ）へお問い合わせいただき、誠にありがとうございます。\n\n"
            . "以下の内容でお問い合わせを受け付けいたしました。\n\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "■ お問い合わせ内容\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "【受付番号】 {$booking_ref}\n"
            . "【お問い合わせ種別】 {$inquiry_type}\n"
            . "【お客様氏名】 {$user_name} 様\n"
            . "【お電話番号】 {$user_phone}\n"
            . "【メールアドレス】 {$user_email}\n"
            . "【お問い合わせ・ご要望内容】\n" . ( $user_message ? $user_message : '（特になし）' ) . "\n\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "店舗スタッフが内容を確認の上、担当者より2〜3営業日以内にご連絡差し上げます。\n"
            . "お急ぎの場合は、恐れ入りますがお電話（{$shop_phone}）までお問い合わせください。\n\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "■ 店舗情報・お問い合わせ先\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "旬果と寛ぎの古民家カフェ\n"
            . "{$shop_name}\n"
            . "住所: {$shop_address}\n"
            . "電話: {$shop_phone}（受付時間: {$shop_hours}）\n"
            . "定休日: {$shop_closed}\n"
            . "公式サイト: {$site_url}\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    }

    $mail_cust_sent = wp_mail( $user_email, $cust_subject, $cust_body, $headers );

    // ==========================================
    // B. 店舗管理者宛 通知メール
    // ==========================================
    $admin_subject = $is_reservation
        ? "【予約リクエスト受付】{$user_name}様より仮予約が入りました（{$reserve_date} {$reserve_time}）"
        : "【お問い合わせ受付】{$user_name}様よりお問い合わせが届きました";

    $admin_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $shop_name . ' 予約システム <' . $admin_email . '>',
        'Reply-To: ' . $user_name . ' <' . $user_email . '>',
    );

    $now_str = current_time( 'Y-m-d H:i:s' );
    $remote_ip = $_SERVER['REMOTE_ADDR'] ?? '不明';

    $admin_body = "CAFE HAREKA 店舗スタッフ様\n\n"
        . "Webサイトより新しい" . ( $is_reservation ? "ご予約リクエスト（仮予約）" : "お問い合わせ" ) . "が届きました。\n"
        . "配席状況をご確認の上、24時間以内にお客様へご予約確定または日程調整のご連絡をお願いいたします。\n\n"
        . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
        . "■ 受付明細\n"
        . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
        . "【受付番号】 {$booking_ref}\n"
        . "【お問い合わせ種別】 {$inquiry_type}\n";

    if ( $is_reservation ) {
        $admin_body .= "【ご来店希望日】 {$reserve_date}\n"
            . "【ご来店時間帯】 {$reserve_time}\n"
            . "【ご利用人数】 {$reserve_guests} 名様\n"
            . "【ご希望のお席】 {$seat_type}\n";
    }

    $admin_body .= "【お客様氏名】 {$user_name} 様\n"
        . "【お電話番号】 {$user_phone}\n"
        . "【メールアドレス】 {$user_email}\n"
        . "【ご要望・メッセージ】\n" . ( $user_message ? $user_message : '（特になし）' ) . "\n\n"
        . "【受付日時】 {$now_str}\n"
        . "【送信元IP】 {$remote_ip}\n"
        . "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

    $mail_admin_sent = wp_mail( $admin_email, $admin_subject, $admin_body, $admin_headers );

    wp_send_json_success( array(
        'message'     => '送信が完了しました。',
        'booking_ref' => $booking_ref,
        'cust_sent'   => (bool) $mail_cust_sent,
        'admin_sent'  => (bool) $mail_admin_sent,
    ) );
}
