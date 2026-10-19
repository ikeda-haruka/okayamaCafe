<?php
/**
 * CAFE HAREKA ナビゲーションメニュー管理モジュール
 * - ヘッダーメニュー（PC・モバイル）およびフッターメニューの動的レンダリング
 * - 英語サブテキスト（HOME, ABOUT等）の自動判定・連携
 * - 初回有効化時のデフォルトメニュー自動生成＆位置割り当て
 *
 * @package hareka-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ナビゲーションメニュー項目の英語表記（サブテキスト）を取得
 * 1. メニュー項目の説明（description）に入力があれば優先
 * 2. タイトルのキーワードから自動変換
 * 3. URLスラッグからフォールバック
 *
 * @param WP_Post $item メニュー項目オブジェクト
 * @return string 英語サブテキスト（大文字）
 */
function hareka_get_menu_en_sub( $item ) {
    if ( ! empty( $item->description ) ) {
        return strtoupper( trim( $item->description ) );
    }

    $title = trim( $item->title );
    $map = array(
        'ホーム'           => 'HOME',
        'トップ'           => 'TOP',
        'お店について'     => 'ABOUT',
        'コンセプト'       => 'CONCEPT',
        'メニュー'         => 'MENU',
        'メニュー一覧'     => 'MENU',
        'お品書き'         => 'MENU',
        '岡山の果物'       => 'FRUITS',
        '果物図鑑'         => 'FRUITS',
        '果物'             => 'FRUITS',
        'お知らせ'         => 'NEWS',
        'ニュース'         => 'NEWS',
        '新着情報'         => 'NEWS',
        'ブログ'           => 'BLOG',
        'アクセス'         => 'ACCESS',
        'アクセス・駐車場' => 'ACCESS',
        'お問い合わせ'     => 'CONTACT',
        'ご予約・問合せ'   => 'CONTACT',
        'お席のご予約'     => 'RESERVATION',
        '予約'             => 'RESERVE',
        'ギフト'           => 'GIFT',
        'オンラインショップ' => 'ONLINE SHOP',
    );

    foreach ( $map as $key => $val ) {
        if ( mb_strpos( $title, $key ) !== false ) {
            return $val;
        }
    }

    // URLスラッグから推測
    $slug = trim( wp_make_link_relative( $item->url ), '/' );
    if ( ! empty( $slug ) && ! strpos( $slug, '/' ) ) {
        return strtoupper( $slug );
    }

    return '';
}

/**
 * 現在のURLとメニュー項目のURLが一致しているかを判定（アクティブ状態）
 *
 * @param string $item_url メニュー項目のURL
 * @return bool
 */
function hareka_is_menu_item_active( $item_url ) {
    $current_url = home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) );
    $current_url = rtrim( $current_url, '/' );
    $target_url  = rtrim( (string) $item_url, '/' );

    if ( is_front_page() ) {
        return ( $target_url === rtrim( home_url(), '/' ) );
    }

    return ( ! empty( $target_url ) && $current_url === $target_url );
}

/**
 * 指定したメニュー位置（theme_location）のメニュー項目配列を取得
 * メニューが未設定、または項目がない場合はデフォルトの項目配列を返す
 *
 * @param string $location メニュー位置 ('primary' | 'footer')
 * @return array
 */
function hareka_get_nav_items( $location = 'primary' ) {
    $locations = get_nav_menu_locations();
    if ( isset( $locations[ $location ] ) && $locations[ $location ] > 0 ) {
        $menu_id = $locations[ $location ];
        $items = wp_get_nav_menu_items( $menu_id );
        if ( ! empty( $items ) && ! is_wp_error( $items ) ) {
            $formatted = array();
            foreach ( $items as $item ) {
                // 親項目のみ対象（第1階層）
                if ( ! empty( $item->menu_item_parent ) && $item->menu_item_parent != '0' ) {
                    continue;
                }
                $formatted[] = array(
                    'title'     => $item->title,
                    'url'       => $item->url,
                    'en'        => hareka_get_menu_en_sub( $item ),
                    'target'    => ! empty( $item->target ) ? $item->target : '_self',
                    'is_active' => hareka_is_menu_item_active( $item->url ),
                );
            }
            if ( ! empty( $formatted ) ) {
                return $formatted;
            }
        }
    }

    // デフォルトフォールバック項目
    $news_url = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/news/' );

    if ( $location === 'footer' ) {
        return array(
            array( 'title' => 'ホーム', 'en' => 'HOME', 'url' => home_url( '/' ), 'target' => '_self', 'is_active' => is_front_page() ),
            array( 'title' => 'お店について', 'en' => 'ABOUT', 'url' => home_url( '/about/' ), 'target' => '_self', 'is_active' => is_page( 'about' ) ),
            array( 'title' => 'メニュー一覧', 'en' => 'MENU', 'url' => home_url( '/menu/' ), 'target' => '_self', 'is_active' => is_page( 'menu' ) ),
            array( 'title' => '岡山の果物図鑑', 'en' => 'FRUITS', 'url' => home_url( '/fruits/' ), 'target' => '_self', 'is_active' => is_page( 'fruits' ) ),
            array( 'title' => 'アクセス・駐車場', 'en' => 'ACCESS', 'url' => home_url( '/access/' ), 'target' => '_self', 'is_active' => is_page( 'access' ) ),
            array( 'title' => 'ご予約・問合せ', 'en' => 'CONTACT', 'url' => home_url( '/contact/' ), 'target' => '_self', 'is_active' => is_page( 'contact' ) ),
        );
    }

    return array(
        array( 'title' => 'ホーム', 'en' => 'HOME', 'url' => home_url( '/' ), 'target' => '_self', 'is_active' => is_front_page() ),
        array( 'title' => 'お店について', 'en' => 'ABOUT', 'url' => home_url( '/about/' ), 'target' => '_self', 'is_active' => is_page( 'about' ) ),
        array( 'title' => 'メニュー', 'en' => 'MENU', 'url' => home_url( '/menu/' ), 'target' => '_self', 'is_active' => is_page( 'menu' ) ),
        array( 'title' => '岡山の果物', 'en' => 'FRUITS', 'url' => home_url( '/fruits/' ), 'target' => '_self', 'is_active' => is_page( 'fruits' ) ),
        array( 'title' => 'お知らせ', 'en' => 'NEWS', 'url' => $news_url, 'target' => '_self', 'is_active' => ( is_home() || is_archive() || is_singular( 'post' ) ) ),
        array( 'title' => 'アクセス', 'en' => 'ACCESS', 'url' => home_url( '/access/' ), 'target' => '_self', 'is_active' => is_page( 'access' ) ),
        array( 'title' => 'お問い合わせ', 'en' => 'CONTACT', 'url' => home_url( '/contact/' ), 'target' => '_self', 'is_active' => is_page( 'contact' ) ),
    );
}

/**
 * 初回メニューの自動生成と位置割り当て（メニューが1件も存在しない場合のみ実行）
 */
function hareka_init_default_menus() {
    // 既存メニューの存在確認
    $existing_menus = wp_get_nav_menus();
    $locations = get_nav_menu_locations();
    $updated = false;

    // 1. Primary Header Menu
    if ( empty( $locations['primary'] ) ) {
        $primary_menu = wp_get_nav_menu_object( 'メインメニュー' );
        if ( ! $primary_menu ) {
            $menu_id = wp_create_nav_menu( 'メインメニュー' );
            if ( ! is_wp_error( $menu_id ) ) {
                $news_url = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/news/' );
                $items = array(
                    array( 'title' => 'ホーム', 'url' => home_url( '/' ), 'desc' => 'HOME' ),
                    array( 'title' => 'お店について', 'url' => home_url( '/about/' ), 'desc' => 'ABOUT' ),
                    array( 'title' => 'メニュー', 'url' => home_url( '/menu/' ), 'desc' => 'MENU' ),
                    array( 'title' => '岡山の果物', 'url' => home_url( '/fruits/' ), 'desc' => 'FRUITS' ),
                    array( 'title' => 'お知らせ', 'url' => $news_url, 'desc' => 'NEWS' ),
                    array( 'title' => 'アクセス', 'url' => home_url( '/access/' ), 'desc' => 'ACCESS' ),
                    array( 'title' => 'お問い合わせ', 'url' => home_url( '/contact/' ), 'desc' => 'CONTACT' ),
                );
                foreach ( $items as $it ) {
                    wp_update_nav_menu_item( $menu_id, 0, array(
                        'menu-item-title'       => $it['title'],
                        'menu-item-url'         => $it['url'],
                        'menu-item-description' => $it['desc'],
                        'menu-item-status'      => 'publish',
                    ) );
                }
                $locations['primary'] = $menu_id;
                $updated = true;
            }
        } else {
            $locations['primary'] = $primary_menu->term_id;
            $updated = true;
        }
    }

    // 2. Footer Menu
    if ( empty( $locations['footer'] ) ) {
        $footer_menu = wp_get_nav_menu_object( 'フッターメニュー' );
        if ( ! $footer_menu ) {
            $f_menu_id = wp_create_nav_menu( 'フッターメニュー' );
            if ( ! is_wp_error( $f_menu_id ) ) {
                $f_items = array(
                    array( 'title' => 'ホーム', 'url' => home_url( '/' ) ),
                    array( 'title' => 'お店について', 'url' => home_url( '/about/' ) ),
                    array( 'title' => 'メニュー一覧', 'url' => home_url( '/menu/' ) ),
                    array( 'title' => '岡山の果物図鑑', 'url' => home_url( '/fruits/' ) ),
                    array( 'title' => 'アクセス・駐車場', 'url' => home_url( '/access/' ) ),
                    array( 'title' => 'ご予約・問合せ', 'url' => home_url( '/contact/' ) ),
                );
                foreach ( $f_items as $it ) {
                    wp_update_nav_menu_item( $f_menu_id, 0, array(
                        'menu-item-title'  => $it['title'],
                        'menu-item-url'    => $it['url'],
                        'menu-item-status' => 'publish',
                    ) );
                }
                $locations['footer'] = $f_menu_id;
                $updated = true;
            }
        } else {
            $locations['footer'] = $footer_menu->term_id;
            $updated = true;
        }
    }

    if ( $updated ) {
        set_theme_mod( 'nav_menu_locations', $locations );
    }
}
add_action( 'after_switch_theme', 'hareka_init_default_menus' );
// 管理画面アクセス時に未作成なら1度だけ初期化
add_action( 'admin_init', 'hareka_init_default_menus' );
