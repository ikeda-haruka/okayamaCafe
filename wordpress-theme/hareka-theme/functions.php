<?php
/**
 * CAFE HAREKA Theme functions and definitions
 *
 * @package hareka-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

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
    // Google Fonts (Shippori Mincho & Noto Sans JP)
    wp_enqueue_style( 'hareka-google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;600;700&family=Shippori+Mincho:wght@400;500;600;700&display=swap', array(), null );

    // Tailwind CSS & テーマスタイル
    wp_enqueue_style( 'hareka-theme-css', get_template_directory_uri() . '/assets/css/theme.css', array(), '1.0.0' );
    wp_enqueue_style( 'hareka-main-style', get_stylesheet_uri(), array( 'hareka-theme-css' ), '1.0.0' );

    // テーマ用インタラクティブスクリプト（タブ切り替え、FAQ、空き状況、モバイルメニュー）
    wp_enqueue_script( 'hareka-main-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );

    // JavaScriptへデータを渡す（APIエンドポイントやnonceなど）
    wp_localize_script( 'hareka-main-js', 'harekaThemeData', array(
        'rootUrl'     => get_site_url(),
        'restUrl'     => esc_url_raw( rest_url() ),
        'themeUrl'    => get_template_directory_uri(),
        'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
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
 * カスタムフィールド（メタボックス）の登録
 */
function hareka_add_custom_meta_boxes() {
    // メニュー項目用メタボックス
    add_meta_box(
        'hareka_menu_details',
        'メニュー詳細設定（価格・産地・糖度等）',
        'hareka_render_menu_meta_box',
        'menu_item',
        'normal',
        'high'
    );

    // 果物図鑑用メタボックス
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

// メニュー項目の入力フォーム
function hareka_render_menu_meta_box( $post ) {
    wp_nonce_field( 'hareka_menu_save_meta', 'hareka_menu_meta_nonce' );

    $price = get_post_meta( $post->ID, '_hareka_price', true );
    $origin = get_post_meta( $post->ID, '_hareka_origin', true );
    $sugar = get_post_meta( $post->ID, '_hareka_sugar', true );
    $seasonal = get_post_meta( $post->ID, '_hareka_seasonal', true );
    $takeout = get_post_meta( $post->ID, '_hareka_takeout', true );
    $featured = get_post_meta( $post->ID, '_hareka_featured', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="hareka_price">税込価格 (円)</label></th>
            <td><input type="number" id="hareka_price" name="hareka_price" value="<?php echo esc_attr( $price ); ?>" style="width:200px;" placeholder="1980" /> 円</td>
        </tr>
        <tr>
            <th><label for="hareka_origin">契約農家・産地</label></th>
            <td><input type="text" id="hareka_origin" name="hareka_origin" value="<?php echo esc_attr( $origin ); ?>" style="width:100%;" placeholder="赤磐市・吉井果樹園 直送" /></td>
        </tr>
        <tr>
            <th><label for="hareka_sugar">糖度表示（任意）</label></th>
            <td><input type="text" id="hareka_sugar" name="hareka_sugar" value="<?php echo esc_attr( $sugar ); ?>" style="width:200px;" placeholder="糖度14度以上" /></td>
        </tr>
        <tr>
            <th>フラグ設定</th>
            <td>
                <label style="margin-right:20px;">
                    <input type="checkbox" name="hareka_seasonal" value="1" <?php checked( $seasonal, '1' ); ?> />
                    季節・旬果限定
                </label>
                <label style="margin-right:20px;">
                    <input type="checkbox" name="hareka_takeout" value="1" <?php checked( $takeout, '1' ); ?> />
                    テイクアウト（お持ち帰り）可能
                </label>
                <label>
                    <input type="checkbox" name="hareka_featured" value="1" <?php checked( $featured, '1' ); ?> />
                    TOPページおすすめ枠に表示
                </label>
            </td>
        </tr>
    </table>
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
