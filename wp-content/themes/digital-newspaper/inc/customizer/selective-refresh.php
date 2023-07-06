<?php
/**
 * Includes functions for selective refresh
 * 
 * @package Digital Newspaper
 * @since 1.0.0
 */
use Digital_Newspaper\CustomizerDefault as DN;
if( ! function_exists( 'digital_newspaper_customize_selective_refresh' ) ) :
    /**
     * Adds partial refresh for the customizer preview
     * 
     */
    function digital_newspaper_customize_selective_refresh( $wp_customize ) {
        if ( ! isset( $wp_customize->selective_refresh ) ) return;
        // top header show hide
        $wp_customize->selective_refresh->add_partial(
            'top_header_option',
            array(
                'selector'        => '#masthead .top-header',
                'render_callback' => 'digital_newspaper_top_header_html'
            )
        );
        // top header social icons show hide
        $wp_customize->selective_refresh->add_partial(
            'top_header_social_option',
            array(
                'selector'        => '#masthead .top-header .social-icons-wrap',
                'render_callback' => 'digital_newspaper_top_header_social_part_selective_refresh'
            )
        );
        // header sidebar toggle show hide
        $wp_customize->selective_refresh->add_partial(
            'header_sidebar_toggle_option',
            array(
                'selector'        => '#masthead .sidebar-toggle-wrap',
                'render_callback' => 'digital_newspaper_header_sidebar_toggle_part_selective_refresh'
            )
        );
        // header search icon show hide
        $wp_customize->selective_refresh->add_partial(
            'header_search_option',
            array(
                'selector'        => '#masthead .search-wrap',
                'render_callback' => 'digital_newspaper_header_search_part_selective_refresh'
            )
        );
        // theme mode toggle show hide
        $wp_customize->selective_refresh->add_partial(
            'header_theme_mode_toggle_option',
            array(
                'selector'        => '#masthead .mode_toggle_wrap',
                'render_callback' => 'digital_newspaper_header_theme_mode_icon_part_selective_refresh'
            )
        );
        // site title
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'digital_newspaper_customize_partial_blogname',
            )
        );
        // site description
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'digital_newspaper_customize_partial_blogdescription',
            )
        );
        
        // social icons target attribute
        $wp_customize->selective_refresh->add_partial(
            'social_icons_target',
            array(
                'selector'        => '.top-header .social-icons-wrap',
                'render_callback' => 'digital_newspaper_customizer_social_icons',
            )
        );

        // social icons
        $wp_customize->selective_refresh->add_partial(
            'social_icons',
            array(
                'selector'        => '.top-header .social-icons-wrap',
                'render_callback' => 'digital_newspaper_customizer_social_icons',
            )
        );

        // post read more button label
        $wp_customize->selective_refresh->add_partial(
            'global_button_text',
            array(
                'selector'        => 'article .post-link-button',
                'render_callback' => 'digital_newspaper_customizer_read_more_button',
            )
        );
        
        // ticker news title
        $wp_customize->selective_refresh->add_partial(
            'ticker_news_title',
            array(
                'selector'        => '.ticker-news-wrap .ticker_label_title',
                'render_callback' => 'digital_newspaper_customizer_ticker_label',
            )
        );
        
        // banner list posts title
        $wp_customize->selective_refresh->add_partial(
            'main_banner_list_posts_title',
            array(
                'selector'        => '#main-banner-section .main-banner-list-posts .section-title',
                'render_callback' => 'digital_newspaper_customizer_main_banner_list_posts_title',
            )
        );

        // banner grid posts title
        $wp_customize->selective_refresh->add_partial(
            'main_banner_grid_posts_title',
            array(
                'selector'        => '#main-banner-section .main-banner-grid-posts .section-title',
                'render_callback' => 'digital_newspaper_customizer_main_banner_grid_posts_title',
            )
        );
        
        // single post related posts option
        $wp_customize->selective_refresh->add_partial(
            'single_post_related_posts_option',
            array(
                'selector'        => '.single-related-posts-section-wrap',
                'render_callback' => 'digital_newspaper_single_related_posts',
            )
        );
        
        // footer option
        $wp_customize->selective_refresh->add_partial(
            'footer_option',
            array(
                'selector'        => 'footer .main-footer',
                'render_callback' => 'digital_newspaper_footer_sections_html',
                'container_inclusive'=> true
            )
        );

        // footer column option
        $wp_customize->selective_refresh->add_partial(
            'footer_widget_column',
            array(
                'selector'        => 'footer .main-footer',
                'render_callback' => 'digital_newspaper_footer_sections_html',
            )
        );

        // bottom footer option
        $wp_customize->selective_refresh->add_partial(
            'bottom_footer_option',
            array(
                'selector'        => 'footer .bottom-footer',
                'render_callback' => 'digital_newspaper_bottom_footer_sections_html',
            )
        );

        // bottom footer menu option
        $wp_customize->selective_refresh->add_partial(
            'bottom_footer_menu_option',
            array(
                'selector'        => 'footer .bottom-footer .bottom-menu',
                'render_callback' => 'digital_newspaper_bottom_footer_menu_part_selective_refresh',
            )
        );

        // bottom footer menu option
        $wp_customize->selective_refresh->add_partial(
            'bottom_footer_social_option',
            array(
                'selector'        => 'footer .bottom-footer .social-icons-wrap',
                'render_callback' => 'digital_newspaper_botttom_footer_social_part_selective_refresh',
            )
        );
    }
    add_action( 'customize_register', 'digital_newspaper_customize_selective_refresh' );
endif;

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function digital_newspaper_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function digital_newspaper_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

// global button label
function digital_newspaper_customizer_read_more_button() {
    $global_button_text = DN\digital_newspaper_get_customizer_option( 'global_button_text' );
    return ( esc_html( $global_button_text['text'] ) . '<i class="' .esc_attr( $global_button_text['icon'] ). '"></i>' );
}

// ticker label latest tab
function digital_newspaper_customizer_ticker_label() {
    $ticker_news_title = DN\digital_newspaper_get_customizer_option( 'ticker_news_title' );
    return ( '<span class="icon"><i class="' .esc_attr( $ticker_news_title['icon'] ). '"></i></span><span class="ticker_label_title_string">' .esc_html( $ticker_news_title['text'] ). '</span>' );
}

// banner grid posts title
function digital_newspaper_customizer_main_banner_grid_posts_title() {
    return DN\digital_newspaper_get_customizer_option( 'main_banner_grid_posts_title' );
}

// banner list posts title
function digital_newspaper_customizer_main_banner_list_posts_title() {
    return DN\digital_newspaper_get_customizer_option( 'main_banner_list_posts_title' );
}

// top header social icons part
function digital_newspaper_top_header_social_part_selective_refresh() {
    if( ! DN\digital_newspaper_get_customizer_option( 'top_header_social_option' ) ) return;
    ?>
       <div class="social-icons-wrap">
          <?php digital_newspaper_customizer_social_icons(); ?>
       </div>
    <?php
}

function digital_newspaper_header_sidebar_toggle_part_selective_refresh() {
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
             <div class="digital-newspaper-container">
               <div class="row">
                 <?php dynamic_sidebar( 'header-toggle-sidebar' ); ?>
               </div>
             </div>
           </div>
       </div>
    <?php
}

function digital_newspaper_header_search_part_selective_refresh() {
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

function digital_newspaper_header_theme_mode_icon_part_selective_refresh() {
    if( ! DN\digital_newspaper_get_customizer_option( 'header_theme_mode_toggle_option' ) ) return;
    ?>
        <div class="blaze-switcher-button">
            <div class="blaze-switcher-button-inner-left"></div>
            <div class="blaze-switcher-button-inner"></div>
        </div>
    <?php
 }

// bottom footer menu part
function digital_newspaper_bottom_footer_menu_part_selective_refresh() {
    if( ! DN\digital_newspaper_get_customizer_option( 'bottom_footer_menu_option' ) ) return;
    ?>
       <div class="bottom-menu">
          <?php
          if( has_nav_menu( 'menu-3' ) ) :
             wp_nav_menu(
                array(
                   'theme_location' => 'menu-3',
                   'menu_id'        => 'bottom-footer-menu',
                   'depth' => 1
                )
             );
             else :
                if ( is_user_logged_in() && current_user_can( 'edit_theme_options' ) ) {
                   ?>
                      <a href="<?php echo esc_url( admin_url( '/nav-menus.php?action=locations' ) ); ?>"><?php esc_html_e( 'Setup Bottom Footer Menu', 'digital-newspaper' ); ?></a>
                   <?php
                }
             endif;
          ?>
       </div>
    <?php
 }

// bottom footer social icons part
function digital_newspaper_botttom_footer_social_part_selective_refresh() {
    if( ! DN\digital_newspaper_get_customizer_option( 'bottom_footer_social_option' ) ) return;
    ?>
       <div class="social-icons-wrap">
          <?php digital_newspaper_customizer_social_icons(); ?>
       </div>
    <?php
}