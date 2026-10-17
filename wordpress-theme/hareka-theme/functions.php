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
        'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt' ),
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
 * 管理画面のメニュー一覧テーブルに価格・産地・カテゴリ一覧カラムを追加
 */
function hareka_set_menu_item_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $title ) {
        $new_columns[$key] = $title;
        if ( $key === 'title' ) {
            $new_columns['menu_category'] = '📁 カテゴリ';
            $new_columns['menu_price']    = '💰 税込価格';
            $new_columns['menu_origin']   = '📍 産地・契約農家';
        }
    }
    return $new_columns;
}
add_filter( 'manage_menu_item_posts_columns', 'hareka_set_menu_item_columns' );

function hareka_custom_menu_item_column( $column, $post_id ) {
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
}
add_action( 'manage_menu_item_posts_custom_column', 'hareka_custom_menu_item_column', 10, 2 );

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
            return array(
                'price'     => (int) get_post_meta( $post['id'], '_hareka_price', true ),
                'origin'    => get_post_meta( $post['id'], '_hareka_origin', true ),
                'sugar'     => get_post_meta( $post['id'], '_hareka_sugar', true ),
                'seasonal'  => get_post_meta( $post['id'], '_hareka_seasonal', true ) === '1',
                'takeout'   => get_post_meta( $post['id'], '_hareka_takeout', true ) === '1',
                'featured'  => get_post_meta( $post['id'], '_hareka_featured', true ) === '1',
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
