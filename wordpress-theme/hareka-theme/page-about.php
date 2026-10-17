<?php
/**
 * Template Name: About Page (お店について)
 *
 * @package hareka-theme
 */

get_header();
$theme_uri = get_template_directory_uri();
?>

<div class="space-y-16 sm:space-y-24 pb-20">
  <!-- ページヘッダー -->
  <div class="relative py-12 md:py-20 bg-gradient-to-b from-[#fde2d9]/60 via-[#faf7f2] to-[#e2f0d9]/40 border-b border-[#e7dac5]/60 overflow-hidden text-center page-header-box">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-3 page-header-motion">
      <div class="flex items-center justify-center gap-2 text-xs text-[#a48c6f] mb-4">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#b54737] transition">HOME</a>
        <span>›</span>
        <span class="text-[#574636] font-medium">お店について</span>
      </div>
      <span class="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase block">ABOUT CAFE HAREKA</span>
      <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-[#392d23] tracking-wide">お店について</h1>
      <p class="max-w-2xl mx-auto text-sm sm:text-base text-[#6b5a4d] leading-relaxed pt-2">
        晴れの国・岡山の豊かな自然と、太陽の恵みを浴びて育った果実たち。私たちのカフェが目指す、温かな時間と地産地消の約束をご紹介します。
      </p>
    </div>
  </div>

  <!-- コンセプトストーリー -->
  <section class="motion-fade-up max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
      <div class="lg:col-span-6 relative">
        <div class="rounded-3xl overflow-hidden shadow-xl border-4 border-white bg-white hover-lift">
          <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=1000&q=80" alt="CAFE HAREKA 店内風景" class="w-full h-[400px] sm:h-[480px] object-cover hover:scale-105 transition-transform duration-700">
        </div>
      </div>
      <div class="lg:col-span-6 space-y-6">
        <span class="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">OUR STORY</span>
        <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-[#392d23] leading-snug">
          「晴れの国の果実は、<br>世界でいちばん優しい味がする。」
        </h2>
        <div class="space-y-4 text-sm text-[#6b5a4d] leading-relaxed">
          <p>岡山県で生まれ育った私たちにとって、夏に食べる瑞々しい白桃や、秋に弾けるシャインマスカットは、いつも特別な喜びと思い出の真ん中にありました。</p>
          <p>しかし、全国的には「高級ギフト」として流通することが多く、収穫されたばかりの“本当の樹上完熟のおいしさ”をその場で味わえる場所は、意外にも多くありませんでした。</p>
          <p>「生産者さんが情熱を注いだ果物を、もっと身近に、最高においしい状態で味わってほしい。」<br>「地元の方はもちろん、県外から岡山を訪れた旅人にも、この土地の温もりを感じて帰ってほしい。」</p>
          <p>そんな想いから、地元の契約果樹園さんと手を取り合い、『CAFE HAREKA（晴果）』をオープンしました。</p>
        </div>
      </div>
    </div>
  </section>

  <!-- 3つのこだわり -->
  <section class="motion-fade-up max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center space-y-3 mb-14">
      <span class="text-xs sm:text-sm font-semibold tracking-[0.3em] text-[#e26d5c] uppercase">OUR COMMITMENT</span>
      <h2 class="font-serif text-2xl sm:text-4xl font-bold text-[#392d23]">CAFE HAREKA の3つのこだわり</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-white rounded-3xl p-8 border border-[#e7dac5] shadow-sm space-y-5">
        <div class="w-12 h-12 rounded-2xl bg-[#fde2d9] text-[#e26d5c] flex items-center justify-center font-bold text-lg">01</div>
        <h3 class="font-serif text-xl font-bold text-[#392d23]">生産者の顔が見える<br>産地直送・樹上完熟果実</h3>
        <p class="text-sm text-[#6b5a4d] leading-relaxed">赤磐、倉敷、新見などの契約農家から毎朝直接仕入れ。完熟ギリギリまで太陽を浴びた果実だけを厳選し、ピューレやシロップも保存料不使用の自家製で仕上げています。</p>
      </div>

      <div class="bg-white rounded-3xl p-8 border border-[#e7dac5] shadow-sm space-y-5">
        <div class="w-12 h-12 rounded-2xl bg-[#e2f0d9] text-[#6cae54] flex items-center justify-center font-bold text-lg">02</div>
        <h3 class="font-serif text-xl font-bold text-[#392d23]">自然と調和する<br>居心地のよい木造空間</h3>
        <p class="text-sm text-[#6b5a4d] leading-relaxed">内装には岡山県産材（美作ヒノキ・県産杉）を贅沢に使用。大きな窓から陽光が差し込み、風が抜けるテラス席はペット連れの方にも開放。誰もがほっと息を抜けるオアシスです。</p>
      </div>

      <div class="bg-white rounded-3xl p-8 border border-[#e7dac5] shadow-sm space-y-5">
        <div class="w-12 h-12 rounded-2xl bg-[#f4eee3] text-[#a48c6f] flex items-center justify-center font-bold text-lg">03</div>
        <h3 class="font-serif text-xl font-bold text-[#392d23]">地産地消の循環と<br>フードロスへの取り組み</h3>
        <p class="text-sm text-[#6b5a4d] leading-relaxed">形やサイズが規格外でも味は絶品の果実は、コンフィチュールや焼き菓子、自家製シロップへと大切にアップサイクル。生産者さんへの還元と環境への優しさを両立しています。</p>
      </div>
    </div>
  </section>

  <!-- 設備ガイド -->
  <section class="motion-fade-up max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-[#e7dac5] shadow-sm">
      <div class="max-w-2xl mx-auto text-center space-y-3 mb-10">
        <span class="text-xs font-semibold tracking-widest text-[#a48c6f] uppercase">FACILITIES & COMFORTS</span>
        <h2 class="font-serif text-2xl sm:text-3xl font-bold text-[#392d23]">心地よくお過ごしいただくための設備</h2>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 text-center">
        <div class="p-4 rounded-2xl bg-[#faf7f2] border border-[#f4eee3] space-y-2">
          <div class="text-2xl">🐶</div>
          <h4 class="text-xs font-bold text-[#392d23]">テラス席ペット可</h4>
          <p class="text-[11px] text-[#6b5a4d]">リードフック・水あり</p>
        </div>
        <div class="p-4 rounded-2xl bg-[#faf7f2] border border-[#f4eee3] space-y-2">
          <div class="text-2xl">📶</div>
          <h4 class="text-xs font-bold text-[#392d23]">高速 Free Wi-Fi</h4>
          <p class="text-[11px] text-[#6b5a4d]">快適な通信環境</p>
        </div>
        <div class="p-4 rounded-2xl bg-[#faf7f2] border border-[#f4eee3] space-y-2">
          <div class="text-2xl">🔌</div>
          <h4 class="text-xs font-bold text-[#392d23]">電源コンセント</h4>
          <p class="text-[11px] text-[#6b5a4d]">カウンター各席に完備</p>
        </div>
        <div class="p-4 rounded-2xl bg-[#faf7f2] border border-[#f4eee3] space-y-2">
          <div class="text-2xl">🚗</div>
          <h4 class="text-xs font-bold text-[#392d23]">無料駐車場20台</h4>
          <p class="text-[11px] text-[#6b5a4d]">EV充電スタンド2基あり</p>
        </div>
        <div class="p-4 rounded-2xl bg-[#faf7f2] border border-[#f4eee3] space-y-2">
          <div class="text-2xl">♿</div>
          <h4 class="text-xs font-bold text-[#392d23]">バリアフリー設計</h4>
          <p class="text-[11px] text-[#6b5a4d]">スロープ・多目的トイレ</p>
        </div>
        <div class="p-4 rounded-2xl bg-[#faf7f2] border border-[#f4eee3] space-y-2">
          <div class="text-2xl">👶</div>
          <h4 class="text-xs font-bold text-[#392d23]">お子様連れ歓迎</h4>
          <p class="text-[11px] text-[#6b5a4d]">キッズチェア・おむつ台</p>
        </div>
      </div>
    </div>
  </section>

  <!-- 店主メッセージ -->
  <section class="motion-fade-up max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-[#f4eee3] rounded-3xl p-8 sm:p-12 border border-[#e7dac5] flex flex-col md:flex-row items-center gap-8">
      <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-full overflow-hidden shrink-0 border-4 border-white shadow-md">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/okazaki_chef.jpg' ); ?>" alt="代表・パティシエ 岡崎 健太郎" class="w-full h-full object-cover object-top">
      </div>
      <div class="space-y-3 text-center md:text-left">
        <span class="text-xs font-bold tracking-widest text-[#b54737] uppercase block">OWNER & CHEF MESSAGE</span>
        <h3 class="font-serif text-xl sm:text-2xl font-bold text-[#392d23]">「岡山の美味しい記憶を、皆さまの心に刻みたい。」</h3>
        <p class="text-xs sm:text-sm text-[#6b5a4d] leading-relaxed">
          果物は生き物です。その日の気温や日照で毎日甘みや酸味のバランスが変わります。私たちは毎朝届く果物を一口一口味見し、その日その実が一番輝く仕立てでお出ししています。
        </p>
        <div class="text-xs font-semibold text-[#574636] pt-1">
          <?php echo esc_html( hareka_get_shop_info( 'name' ) ); ?> 代表・パティシエ / <?php echo esc_html( hareka_get_shop_info( 'chef_name' ) ); ?>
        </div>
      </div>
    </div>
  </section>
</div>

<?php get_footer(); ?>
