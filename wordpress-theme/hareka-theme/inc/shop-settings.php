<?php
/**
 * CAFE HAREKA 店舗情報・営業時間 一元管理システム
 *
 * クライアント（店舗オーナー・スタッフ）が管理画面から
 * 店舗情報、営業時間、定休日、SNSリンク等を簡単に編集できるようにするモジュール。
 *
 * @package hareka-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 店舗情報の初期値（デフォルト設定）を取得
 *
 * @return array
 */
function hareka_get_default_shop_info() {
    return array(
        // 基本情報
        'name'             => 'CAFE HAREKA (カフェ 晴果)',
        'name_en'          => 'CAFE HAREKA - Okayama Seasonal Fruit & Cafe',
        'chef_name'        => '岡崎 健太郎',
        'postal_code'      => '〒701-1341',
        'address'          => '岡山県岡山市北区吉備津780-1',
        'address_short'    => '岡山市北区吉備津780',
        'access_note'      => 'JR吉備線「吉備津駅」より徒歩8分 / 山陽自動車道「岡山IC」より車で15分（吉備津神社参道近く）',
        'parking'          => '普通車12台 / 身障者用1台（無料・店舗敷地内）※大型バス要事前相談',
        'seats'            => '32席（店内24席・ウッドデッキテラス8席）',
        'facility'         => '全席完全禁煙 / Wi-Fi完備 / コンセント席あり / キッズチェア完備 / バリアフリースロープ',

        // 営業時間・定休日
        'hours_open'       => '10:00',
        'hours_close'      => '18:00',
        'hours_lo'         => '17:30',
        'hours_text'       => '10:00 〜 18:00（L.O. 17:30）',
        'hours_header'     => '10:00 - 18:00 (L.O. 17:30)',
        'closed_day'       => '毎週水曜日（祝日の場合は翌木曜振替）',
        'closed_day_short' => '水曜定休',
        'closed_day_num'   => '3', // 0:日, 1:月, 2:火, 3:水, 4:木, 5:金, 6:土, -1:なし
        'special_notice'   => '', // 臨時休業や季節の特別案内など

        // 連絡先・SNS
        'phone'            => '086-XXXX-XXX',
        'phone_hours'      => '10:00 〜 18:00（毎週水曜・定休除く）',
        'phone_note'       => '※当サイトは架空のポートフォリオ用店舗のため通話発信はご利用いただけません。ご予約やお問合せはWebフォームをご利用ください。',
        'email'            => 'info@example.com',
        'instagram_url'    => 'https://instagram.com/',
        'x_url'            => 'https://x.com/',
        'facebook_url'     => 'https://facebook.com/',
        'google_map_url'   => 'https://maps.google.com/?q=吉備津神社',
    );
}

/**
 * 保存された店舗情報を取得（未設定項目はデフォルト値でフォールバック）
 *
 * @param string|null $key 特定のキー（省略時は全配列）
 * @return mixed
 */
function hareka_get_shop_info( $key = null ) {
    $defaults = hareka_get_default_shop_info();
    $saved    = get_option( 'hareka_shop_info', array() );

    if ( ! is_array( $saved ) ) {
        $saved = array();
    }

    $info = wp_parse_args( $saved, $defaults );

    if ( null !== $key ) {
        return isset( $info[ $key ] ) ? $info[ $key ] : ( isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
    }

    return $info;
}

/**
 * 管理画面に「店舗情報設定」メニューを追加
 */
function hareka_add_shop_settings_menu() {
    add_menu_page(
        '店舗情報・営業時間設定',          // ページタイトル
        '店舗情報設定',                    // メニュータイトル
        'manage_options',                  // 必要な権限
        'hareka-shop-settings',            // メニュースラッグ
        'hareka_render_shop_settings_page',// レンダリング関数
        'dashicons-store',                 // アイコン（お店アイコン）
        26                                 // メニュー位置（投稿や固定ページの直後）
    );
}
add_action( 'admin_menu', 'hareka_add_shop_settings_menu' );

/**
 * 設定画面の保存処理およびHTMLレンダリング
 */
function hareka_render_shop_settings_page() {
    // 権限チェック
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'このページにアクセスする権限がありません。' );
    }

    $message = '';
    $message_type = 'updated';

    // フォーム送信時の保存処理
    if ( isset( $_POST['hareka_shop_info_nonce'] ) && wp_verify_nonce( $_POST['hareka_shop_info_nonce'], 'hareka_save_shop_info' ) ) {
        $input = isset( $_POST['hareka_shop_info'] ) && is_array( $_POST['hareka_shop_info'] ) ? $_POST['hareka_shop_info'] : array();
        $defaults = hareka_get_default_shop_info();
        $sanitized = array();

        foreach ( $defaults as $field_key => $default_val ) {
            if ( isset( $input[ $field_key ] ) ) {
                if ( strpos( $field_key, '_url' ) !== false ) {
                    $sanitized[ $field_key ] = esc_url_raw( trim( $input[ $field_key ] ) );
                } elseif ( $field_key === 'email' ) {
                    $sanitized[ $field_key ] = sanitize_email( trim( $input[ $field_key ] ) );
                } elseif ( in_array( $field_key, array( 'access_note', 'special_notice', 'phone_note' ), true ) ) {
                    $sanitized[ $field_key ] = sanitize_textarea_field( $input[ $field_key ] );
                } else {
                    $sanitized[ $field_key ] = sanitize_text_field( $input[ $field_key ] );
                }
            } else {
                $sanitized[ $field_key ] = $default_val;
            }
        }

        update_option( 'hareka_shop_info', $sanitized );
        $message = '店舗情報・営業時間の設定を正常に保存しました！サイト全体（ヘッダー・フッター・各ページ・予約フォーム）に反映されています。';
    }

    // 現在の最新設定値を取得
    $info = hareka_get_shop_info();
    ?>
    <div class="wrap" style="max-width: 1080px; margin-top: 20px;">
        <h1 style="font-size: 24px; font-weight: bold; color: #392d23; display: flex; items-center; gap: 10px; margin-bottom: 8px;">
            <span class="dashicons dashicons-store" style="font-size: 28px; width: 28px; height: 28px; color: #b54737;"></span>
            CAFE HAREKA 店舗情報・営業時間設定
        </h1>
        <p style="color: #6b5a4d; font-size: 13px; margin-bottom: 20px;">
            ここで変更した店舗名、営業時間、定休日、電話番号、所在地などは、<strong>サイト全体（ヘッダー、フッター、トップページ、アクセス、お問い合わせ予約フォームなど）に一元的に即時反映</strong>されます。
        </p>

        <?php if ( ! empty( $message ) ) : ?>
            <div class="notice notice-success is-dismissible" style="border-left-color: #4a8235; background: #f0fdf4; padding: 12px 16px; margin-bottom: 20px; border-radius: 6px;">
                <p style="color: #166534; font-size: 14px; font-weight: bold; margin: 0;">
                    ✓ <?php echo esc_html( $message ); ?>
                </p>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field( 'hareka_save_shop_info', 'hareka_shop_info_nonce' ); ?>

            <style>
                .hareka-settings-card {
                    background: #ffffff;
                    border: 1px solid #e2d9cc;
                    border-radius: 12px;
                    padding: 24px 28px;
                    margin-bottom: 24px;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.03);
                }
                .hareka-settings-card h2 {
                    font-size: 17px;
                    font-weight: bold;
                    color: #392d23;
                    border-bottom: 2px solid #f4eee3;
                    padding-bottom: 12px;
                    margin-top: 0;
                    margin-bottom: 20px;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }
                .hareka-settings-card h2 .dashicons {
                    color: #b54737;
                }
                .hareka-form-table {
                    width: 100%;
                    border-collapse: collapse;
                }
                .hareka-form-table th {
                    width: 220px;
                    padding: 14px 12px 14px 0;
                    text-align: left;
                    font-size: 13px;
                    font-weight: 600;
                    color: #433932;
                    vertical-align: top;
                }
                .hareka-form-table td {
                    padding: 12px 0;
                }
                .hareka-form-table input[type="text"],
                .hareka-form-table input[type="email"],
                .hareka-form-table select,
                .hareka-form-table textarea {
                    width: 100%;
                    max-width: 600px;
                    padding: 8px 12px;
                    border: 1px solid #d4c8b8;
                    border-radius: 6px;
                    font-size: 14px;
                    background-color: #faf8f5;
                    transition: border-color 0.2s, background-color 0.2s;
                }
                .hareka-form-table input:focus,
                .hareka-form-table select:focus,
                .hareka-form-table textarea:focus {
                    border-color: #b54737;
                    background-color: #ffffff;
                    outline: none;
                    box-shadow: 0 0 0 1px #b54737;
                }
                .hareka-help-text {
                    font-size: 12px;
                    color: #7d6e60;
                    margin-top: 5px;
                    display: block;
                }
                .hareka-badge {
                    display: inline-block;
                    font-size: 11px;
                    font-weight: bold;
                    background: #fde2d9;
                    color: #b54737;
                    padding: 2px 8px;
                    border-radius: 4px;
                    margin-left: 6px;
                }
            </style>

            <!-- 1. 営業時間・定休日セクション -->
            <div class="hareka-settings-card">
                <h2>
                    <span class="dashicons dashicons-clock"></span>
                    営業時間・定休日の設定
                </h2>
                <table class="hareka-form-table">
                    <tr>
                        <th>
                            <label for="hours_text">営業時間（サイト表示用）</label>
                            <span class="hareka-badge">必須</span>
                        </th>
                        <td>
                            <input type="text" id="hours_text" name="hareka_shop_info[hours_text]" value="<?php echo esc_attr( $info['hours_text'] ); ?>" placeholder="10:00 〜 18:00（L.O. 17:30）">
                            <span class="hareka-help-text">フッターやアクセス情報、お問い合わせページに表示される表記です。</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="hours_header">営業時間（ヘッダー短縮表記）</label>
                        </th>
                        <td>
                            <input type="text" id="hours_header" name="hareka_shop_info[hours_header]" value="<?php echo esc_attr( $info['hours_header'] ); ?>" placeholder="10:00 - 18:00 (L.O. 17:30)">
                            <span class="hareka-help-text">パソコン表示時のヘッダー最上段ステータスバーに表示されます。</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="hours_lo">ラストオーダー（L.O.）</label>
                        </th>
                        <td>
                            <input type="text" id="hours_lo" name="hareka_shop_info[hours_lo]" value="<?php echo esc_attr( $info['hours_lo'] ); ?>" placeholder="17:30" style="max-width: 180px;">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="closed_day">定休日（サイト表示用）</label>
                            <span class="hareka-badge">必須</span>
                        </th>
                        <td>
                            <input type="text" id="closed_day" name="hareka_shop_info[closed_day]" value="<?php echo esc_attr( $info['closed_day'] ); ?>" placeholder="毎週水曜日（祝日の場合は翌木曜振替）">
                            <span class="hareka-help-text">フッターやアクセス情報に表示される詳しい定休日の説明文です。</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="closed_day_short">定休日（短縮表示用）</label>
                        </th>
                        <td>
                            <input type="text" id="closed_day_short" name="hareka_shop_info[closed_day_short]" value="<?php echo esc_attr( $info['closed_day_short'] ); ?>" placeholder="水曜定休" style="max-width: 240px;">
                            <span class="hareka-help-text">ヘッダー最上段などに短く表示されます。</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="closed_day_num">予約フォーム連動・定休曜日</label>
                            <span class="hareka-badge">自動ロック</span>
                        </th>
                        <td>
                            <?php $selected_day = (string) $info['closed_day_num']; ?>
                            <select id="closed_day_num" name="hareka_shop_info[closed_day_num]" style="max-width: 240px;">
                                <option value="3" <?php selected( $selected_day, '3' ); ?>>毎週水曜日（初期設定）</option>
                                <option value="1" <?php selected( $selected_day, '1' ); ?>>毎週月曜日</option>
                                <option value="2" <?php selected( $selected_day, '2' ); ?>>毎週火曜日</option>
                                <option value="4" <?php selected( $selected_day, '4' ); ?>>毎週木曜日</option>
                                <option value="5" <?php selected( $selected_day, '5' ); ?>>毎週金曜日</option>
                                <option value="6" <?php selected( $selected_day, '6' ); ?>>毎週土曜日</option>
                                <option value="0" <?php selected( $selected_day, '0' ); ?>>毎週日曜日</option>
                                <option value="-1" <?php selected( $selected_day, '-1' ); ?>>定休日なし（年中無休）</option>
                            </select>
                            <span class="hareka-help-text">Web予約フォーム（Contact & Reservation）で、お客様がこの曜日を選んだ際に自動で「定休日のため予約不可」アラートを表示し、受付枠を自動ロックします。</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="special_notice">臨時休業・特別なお知らせ</label>
                        </th>
                        <td>
                            <textarea id="special_notice" name="hareka_shop_info[special_notice]" rows="3" placeholder="例：※GW期間中（5/3〜5/6）は水曜日も休まず通常営業いたします。振替として5/8（木）をお休みとさせていただきます。"><?php echo esc_textarea( $info['special_notice'] ); ?></textarea>
                            <span class="hareka-help-text">臨時休業や季節の営業案内がある場合に入力します（空欄の場合は非表示になります）。</span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 2. 基本店舗情報・所在地 -->
            <div class="hareka-settings-card">
                <h2>
                    <span class="dashicons dashicons-location-alt"></span>
                    店舗基本情報・所在地・アクセス
                </h2>
                <table class="hareka-form-table">
                    <tr>
                        <th>
                            <label for="name">店舗名（日本語）</label>
                            <span class="hareka-badge">必須</span>
                        </th>
                        <td>
                            <input type="text" id="name" name="hareka_shop_info[name]" value="<?php echo esc_attr( $info['name'] ); ?>" placeholder="CAFE HAREKA (カフェ 晴果)">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="name_en">店舗名（英語表記・サブタイトル）</label>
                        </th>
                        <td>
                            <input type="text" id="name_en" name="hareka_shop_info[name_en]" value="<?php echo esc_attr( $info['name_en'] ); ?>" placeholder="CAFE HAREKA - Okayama Seasonal Fruit & Cafe">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="chef_name">代表・パティシエ名</label>
                        </th>
                        <td>
                            <input type="text" id="chef_name" name="hareka_shop_info[chef_name]" value="<?php echo esc_attr( $info['chef_name'] ); ?>" placeholder="岡崎 健太郎" style="max-width: 240px;">
                            <span class="hareka-help-text">Aboutページのシェフメッセージ欄に反映されます。</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="postal_code">郵便番号</label>
                        </th>
                        <td>
                            <input type="text" id="postal_code" name="hareka_shop_info[postal_code]" value="<?php echo esc_attr( $info['postal_code'] ); ?>" placeholder="〒701-1341" style="max-width: 180px;">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="address">所在地・住所（全文）</label>
                            <span class="hareka-badge">必須</span>
                        </th>
                        <td>
                            <input type="text" id="address" name="hareka_shop_info[address]" value="<?php echo esc_attr( $info['address'] ); ?>" placeholder="岡山県岡山市北区吉備津780-1">
                            <span class="hareka-help-text">フッターやアクセス詳細テーブルに表示されます。</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="address_short">所在地（ヘッダー短縮用）</label>
                        </th>
                        <td>
                            <input type="text" id="address_short" name="hareka_shop_info[address_short]" value="<?php echo esc_attr( $info['address_short'] ); ?>" placeholder="岡山市北区吉備津780" style="max-width: 280px;">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="access_note">最寄り駅・交通アクセス補足</label>
                        </th>
                        <td>
                            <textarea id="access_note" name="hareka_shop_info[access_note]" rows="2" placeholder="JR吉備線「吉備津駅」より徒歩8分 / 山陽自動車道「岡山IC」より車で15分（吉備津神社参道近く）"><?php echo esc_textarea( $info['access_note'] ); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="parking">駐車場</label>
                        </th>
                        <td>
                            <input type="text" id="parking" name="hareka_shop_info[parking]" value="<?php echo esc_attr( $info['parking'] ); ?>" placeholder="普通車12台 / 身障者用1台（無料・店舗敷地内）※大型バス要事前相談">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="seats">総席数・客席情報</label>
                        </th>
                        <td>
                            <input type="text" id="seats" name="hareka_shop_info[seats]" value="<?php echo esc_attr( $info['seats'] ); ?>" placeholder="32席（店内24席・ウッドデッキテラス8席）">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="facility">設備・禁煙情報・サービス</label>
                        </th>
                        <td>
                            <input type="text" id="facility" name="hareka_shop_info[facility]" value="<?php echo esc_attr( $info['facility'] ); ?>" placeholder="全席完全禁煙 / Wi-Fi完備 / コンセント席あり / キッズチェア完備 / バリアフリースロープ">
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 3. 連絡先・電話・SNS・MAP -->
            <div class="hareka-settings-card">
                <h2>
                    <span class="dashicons dashicons-phone"></span>
                    連絡先・電話番号・SNSリンク
                </h2>
                <table class="hareka-form-table">
                    <tr>
                        <th>
                            <label for="phone">お電話番号</label>
                            <span class="hareka-badge">必須</span>
                        </th>
                        <td>
                            <input type="text" id="phone" name="hareka_shop_info[phone]" value="<?php echo esc_attr( $info['phone'] ); ?>" placeholder="086-XXXX-XXX" style="max-width: 240px;">
                            <span class="hareka-help-text">ヘッダー、フッター、スマホ下部固定バー、お問い合わせカードに反映されます。</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="phone_hours">お電話受付時間</label>
                        </th>
                        <td>
                            <input type="text" id="phone_hours" name="hareka_shop_info[phone_hours]" value="<?php echo esc_attr( $info['phone_hours'] ); ?>" placeholder="10:00 〜 18:00（毎週水曜・定休除く）">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="phone_note">お電話に関する注記・アラート</label>
                        </th>
                        <td>
                            <textarea id="phone_note" name="hareka_shop_info[phone_note]" rows="2" placeholder="※当サイトは架空のポートフォリオ用店舗のため通話発信はご利用いただけません。ご予約やお問合せはWebフォームをご利用ください。"><?php echo esc_textarea( $info['phone_note'] ); ?></textarea>
                            <span class="hareka-help-text">スマホ下部バーの「お電話」ボタンをタップした際のアラート通知文に反映されます。</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="email">代表メールアドレス</label>
                        </th>
                        <td>
                            <input type="email" id="email" name="hareka_shop_info[email]" value="<?php echo esc_attr( $info['email'] ); ?>" placeholder="info@example.com" style="max-width: 360px;">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="instagram_url">Instagram URL</label>
                        </th>
                        <td>
                            <input type="text" id="instagram_url" name="hareka_shop_info[instagram_url]" value="<?php echo esc_attr( $info['instagram_url'] ); ?>" placeholder="https://instagram.com/cafe_hareka">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="x_url">X (旧Twitter) URL</label>
                        </th>
                        <td>
                            <input type="text" id="x_url" name="hareka_shop_info[x_url]" value="<?php echo esc_attr( $info['x_url'] ); ?>" placeholder="https://x.com/cafe_hareka">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="facebook_url">Facebook URL</label>
                        </th>
                        <td>
                            <input type="text" id="facebook_url" name="hareka_shop_info[facebook_url]" value="<?php echo esc_attr( $info['facebook_url'] ); ?>" placeholder="https://facebook.com/cafe_hareka">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="google_map_url">Google マップ リンクURL</label>
                        </th>
                        <td>
                            <input type="text" id="google_map_url" name="hareka_shop_info[google_map_url]" value="<?php echo esc_attr( $info['google_map_url'] ); ?>" placeholder="https://maps.google.com/?q=吉備津神社">
                        </td>
                    </tr>
                </table>
            </div>

            <div style="margin-top: 28px; padding-bottom: 40px; display: flex; align-items: center; gap: 16px;">
                <button type="submit" class="button button-primary button-hero" style="background: #b54737; border-color: #9c3c2e; padding: 10px 36px; height: auto; font-size: 16px; font-weight: bold; border-radius: 8px; box-shadow: 0 4px 10px rgba(181,71,55,0.3); cursor: pointer;">
                    変更を保存する
                </button>
                <span style="font-size: 13px; color: #7d6e60;">
                    保存すると即座にサイト全体の表示が更新されます。
                </span>
            </div>
        </form>
    </div>
    <?php
}

/**
 * REST API に店舗情報エンドポイントを登録
 * GET /wp-json/hareka/v1/shop-info
 */
function hareka_register_shop_info_rest_route() {
    register_rest_route( 'hareka/v1', '/shop-info', array(
        'methods'             => 'GET',
        'callback'            => function() {
            return rest_ensure_response( hareka_get_shop_info() );
        },
        'permission_callback' => '__return_true', // 公開情報のため誰でも閲覧可能
    ) );
}
add_action( 'rest_api_init', 'hareka_register_shop_info_rest_route' );
