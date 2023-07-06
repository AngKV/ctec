<?php
/**
 * Header hooks and functions
 * 
 * @package Digital Newspaper
 * @since 1.0.0
 */
use Digital_Newspaper\CustomizerDefault as DN;

 if( ! function_exists( 'digital_newspaper_header_site_branding_part' ) ) :
    /**
     * Header site branding element
     * 
     * @since 1.0.0
     */
     function digital_newspaper_header_site_branding_part() {
         ?>
            <div class="site-branding">
                <?php
                    the_custom_logo();
                    if ( is_front_page() && is_home() ) :
                ?>
                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php
                    else :
                ?>
                        <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                <?php
                    endif;
                    $digital_newspaper_description = get_bloginfo( 'description', 'display' );
                    if ( $digital_newspaper_description || is_customize_preview() ) :
                ?>
                    <p class="site-description"><?php echo get_bloginfo( 'description', 'display' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                <?php endif; ?>
            </div><!-- .site-branding -->
         <?php
     }
    add_action( 'digital_newspaper_header__site_branding_section_hook', 'digital_newspaper_header_site_branding_part', 10 );
 endif;

 if( ! function_exists( 'digital_newspaper_header_ads_banner_part' ) ) :
    /**
     * Header ads banner element
     * 
     * @since 1.0.0
     */
     function digital_newspaper_header_ads_banner_part() {
        if( ! DN\digital_newspaper_get_multiselect_tab_option( 'header_ads_banner_responsive_option' ) ) return;
        $header_ads_banner_custom_image = DN\digital_newspaper_get_customizer_option( 'header_ads_banner_custom_image' );
        $header_ads_banner_custom_url = DN\digital_newspaper_get_customizer_option( 'header_ads_banner_custom_url' );
        $header_ads_banner_custom_target = DN\digital_newspaper_get_customizer_option( 'header_ads_banner_custom_target' );
        if( ! empty( $header_ads_banner_custom_image ) ) :
        ?>
            <div class="ads-banner">
                <a href="<?php echo esc_url( $header_ads_banner_custom_url ); ?>" target="<?php echo esc_html( $header_ads_banner_custom_target ); ?>"><img src="<?php echo esc_url(wp_get_attachment_url( $header_ads_banner_custom_image )); ?>"></a>
            </div><!-- .ads-banner -->
        <?php
        endif;
     }
    add_action( 'digital_newspaper_after_header_hook', 'digital_newspaper_header_ads_banner_part', 10 );
 endif;

 if( ! function_exists( 'digital_newspaper_header_sidebar_toggle_part' ) ) :
    /**
     * Header sidebar toggle element
     * 
     * @since 1.0.0
     */
     function digital_newspaper_header_sidebar_toggle_part() {
         if( ! DN\digital_newspaper_get_customizer_option( 'header_sidebar_toggle_option' ) ) return;
         ?>
            <div class="sidebar-toggle-wrap">
                <a class="sidebar-toggle-trigger" href="javascript:void(0);">
                    <div class="digital_newspaper_sidetoggle_menu_burger">
                      <span></span>
                      <span></span>
                      <span></span>
                  </div>
                </a>
                <div class="sidebar-toggle hide">
                <span class="sidebar-toggle-close"><i class="fas fa-times"></i></span>
                  <div class="digital-newspaper-container">
                    <div class="row">
                      <?php dynamic_sidebar( 'header-toggle-sidebar' ); ?>
                    </div>
                  </div>
                </div>
            </div>
         <?php
     }
    add_action( 'digital_newspaper_header__site_branding_section_hook', 'digital_newspaper_header_sidebar_toggle_part', 100 );
 endif;

 if( ! function_exists( 'digital_newspaper_header_menu_part' ) ) :
    /**
     * Header menu element
     * 
     * @since 1.0.0
     */
    function digital_newspaper_header_menu_part() {
      ?>
        <nav id="site-navigation" class="main-navigation <?php echo esc_attr( 'hover-effect--' . DN\digital_newspaper_get_customizer_option( 'header_menu_hover_effect' ) ); ?>">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <div id="digital_newspaper_menu_burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <span class="menu_txt"><?php esc_html_e( 'Menu', 'digital-newspaper' ); ?></span></button>
            <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'menu-2',
                        'menu_id'        => 'header-menu',
                    )
                );
            ?>
        </nav><!-- #site-navigation -->
      <?php
    }
    add_action( 'digital_newspaper_header__site_branding_section_hook', 'digital_newspaper_header_menu_part', 50 );
 endif;

 if( ! function_exists( 'digital_newspaper_header_search_part' ) ) :
   /**
    * Header search element
    * 
    * @since 1.0.0
    */
    function digital_newspaper_header_search_part() {
        if( ! DN\digital_newspaper_get_customizer_option( 'header_search_option' ) ) return;
        ?>
            <div class="search-wrap">
                <button class="search-trigger">
                    <i class="fas fa-search"></i>
                </button>
                <div class="search-form-wrap hide">
                    <?php echo get_search_form(); ?>
                </div>
                <div class="search_close_btn hide"><i class="fas fa-times"></i></div>
            </div>
        <?php
    }
    add_action( 'digital_newspaper_header__site_branding_section_hook', 'digital_newspaper_header_search_part', 60 );
endif;

if( ! function_exists( 'digital_newspaper_header_theme_mode_icon_part' ) ) :
    /**
     * Header theme mode element
     * 
     * @since 1.0.0
     */
     function digital_newspaper_header_theme_mode_icon_part() {
        if( ! DN\digital_newspaper_get_customizer_option( 'header_theme_mode_toggle_option' ) ) return;
        ?>
            <div class="blaze-switcher-button">
                <div class="blaze-switcher-button-inner-left"></div>
                <div class="blaze-switcher-button-inner"></div>
            </div>
        <?php
     }
    add_action( 'digital_newspaper_header__site_branding_section_hook', 'digital_newspaper_header_theme_mode_icon_part', 110 );
 endif;

add_action( 'digital_newspaper_header__site_branding_section_hook', function() {
    echo '<div class="header-smh-button-wrap menu-section">';
}, 45 ); // search wrapper open
add_action( 'digital_newspaper_header__site_branding_section_hook', function() {
    echo '</div><!-- .header-smh-button-wrap -->';
}, 120 ); // search wrapper end

 if( ! function_exists( 'digital_newspaper_ticker_news_part' ) ) :
    /**
     * Ticker news element
     * 
     * @since 1.0.0
     */
     function digital_newspaper_ticker_news_part() {
        $ticker_news_visible = DN\digital_newspaper_get_customizer_option( 'ticker_news_visible' );
        if( $ticker_news_visible === 'none' ) return;
        if( $ticker_news_visible === 'front-page' && ! is_front_page() ) {
            return;
        } else if( $ticker_news_visible === 'innerpages' && is_front_page()  ) {
            return;
        }
        $ticker_news_order_by = DN\digital_newspaper_get_customizer_option( 'ticker_news_order_by' );
        $ticker_news_post_filter = DN\digital_newspaper_get_customizer_option( 'ticker_news_post_filter' );
        $orderArray = explode( '-', $ticker_news_order_by );
        $ticker_args = array(
            'order' => esc_html( $orderArray[1] ),
            'orderby' => esc_html( $orderArray[0] )
        );
        if( $ticker_news_post_filter == 'category' ) {
            $ticker_news_numbers = DN\digital_newspaper_get_customizer_option( 'ticker_news_numbers' );
            $ticker_args['posts_per_page'] = absint( $ticker_news_numbers );
            $ticker_news_categories = json_decode( DN\digital_newspaper_get_customizer_option( 'ticker_news_categories' ) );
            if( DN\digital_newspaper_get_customizer_option( 'ticker_news_date_filter' ) != 'all' ) $ticker_args['date_query'] = digital_newspaper_get_date_format_array_args(DN\digital_newspaper_get_customizer_option( 'ticker_news_date_filter' ));
            if( $ticker_news_categories ) $ticker_args['category_name'] = digital_newspaper_get_categories_for_args($ticker_news_categories);
        } else if( $ticker_news_post_filter == 'title' ) {
            $ticker_news_posts = json_decode(DN\digital_newspaper_get_customizer_option( 'ticker_news_posts' ));
            if( $ticker_news_posts ) $ticker_args['post_name__in'] = digital_newspaper_get_post_slugs_for_args($ticker_news_posts);
        }
         ?>
            <div class="ticker-news-wrap digital-newspaper-ticker layout--three">
                <?php
                    $ticker_news_title = DN\digital_newspaper_get_customizer_option( 'ticker_news_title' );

                    if( $ticker_news_title['icon'] != 'fas fa-ban' ||  !empty($ticker_news_title['text']) ) {
                        ?>
                        <div class="ticker_label_title ticker-title digital-newspaper-ticker-label">
                            <?php if( $ticker_news_title['icon'] != "fas fa-ban" ) : ?>
                                <span class="icon">
                                    <i class="<?php echo esc_attr($ticker_news_title['icon']); ?>"></i>
                                </span>
                            <?php endif;
                                if( $ticker_news_title['text'] ) :
                             ?>
                                    <span class="ticker_label_title_string"><?php echo esc_html( $ticker_news_title['text'] ); ?></span>
                                <?php endif; ?>
                        </div>
                        <?php
                    }
                ?>
                <div class="digital-newspaper-ticker-box">
                  <?php
                    $digital_newspaper_direction = 'left';
                    $digital_newspaper_dir = 'ltr';
                    if( is_rtl() ){
                      $digital_newspaper_direction = 'right';
                      $digital_newspaper_dir = 'ltr';
                    }
                  ?>

                    <ul class="ticker-item-wrap" direction="<?php echo esc_attr($digital_newspaper_direction); ?>" dir="<?php echo esc_attr($digital_newspaper_dir); ?>">
                        <?php get_template_part( 'template-parts/ticker-news/template', 'three', $ticker_args ); ?>
                    </ul>
                </div>
                <div class="digital-newspaper-ticker-controls">
                    <button class="digital-newspaper-ticker-pause"><i class="fas fa-pause"></i></button>
                </div>
            </div>
         <?php
     }
    add_action( 'digital_newspaper_after_header_hook', 'digital_newspaper_ticker_news_part', 10 );
 endif;