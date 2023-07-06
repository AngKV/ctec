<?php
/**
 * Includes theme defaults and starter functions
 * 
 * @package Digital Newspaper
 * @since 1.0.0
 */
 namespace Digital_Newspaper\CustomizerDefault;

 if( !function_exists( 'digital_newspaper_get_customizer_option' ) ) :
    /**
     * Gets customizer "theme_mods" value
     * 
     * @package Digital Newspaper
     * @since 1.0.0
     * 
     */
    function digital_newspaper_get_customizer_option( $key ) {
        return get_theme_mod( $key, digital_newspaper_get_customizer_default( $key ) );
    }
 endif;

 if( !function_exists( 'digital_newspaper_get_multiselect_tab_option' ) ) :
    /**
     * Gets customizer "multiselect combine tab" value
     * 
     * @package Digital Newspaper
     * @since 1.0.0
     */
    function digital_newspaper_get_multiselect_tab_option( $key ) {
        $value = digital_newspaper_get_customizer_option( $key );
        if( !$value["desktop"] && !$value["tablet"] && !$value["mobile"] ) return apply_filters( "digital_newspaper_get_multiselect_tab_option", false );
        return apply_filters( "digital_newspaper_get_multiselect_tab_option", true );
    }
 endif;

 if( !function_exists( 'digital_newspaper_get_customizer_default' ) ) :
    /**
     * Gets customizer "theme_mods" value
     * 
     * @package Digital Newspaper
     * @since 1.0.0
     */
    function digital_newspaper_get_customizer_default($key) {
        $array_defaults = apply_filters( 'digital_newspaper_get_customizer_defaults', array(
            'theme_color'   => '#FD4F18',
            'site_background_color'  => json_encode(array(
                'type'  => 'solid',
                'solid' => '#F0F1F2',
                'gradient'  => null
            )),
            'global_button_text'    => array( "icon"  => "fas fa-caret-right", "text"   => esc_html__( 'Read More', 'digital-newspaper' ) ),
            'preloader_option'  => false,
            'website_layout'    => 'boxed--layout',
            'website_content_layout'    => 'boxed--layout',
            'website_block_title_layout'    => 'layout-one',
            'website_block_border_top_option' => false,
            'website_block_border_top_color' => json_encode(array(
                'type'  => 'gradient',
                'solid' => null,
                'gradient'  => 'linear-gradient( 135deg, #485563 10%, #29323c 100%)'
            )),
            'frontpage_sidebar_layout'  => 'right-sidebar',
            'frontpage_sidebar_sticky_option'    => false,
            'archive_sidebar_layout'    => 'right-sidebar',
            'archive_sidebar_sticky_option'    => false,
            'single_sidebar_layout' => 'right-sidebar',
            'single_sidebar_sticky_option'    => false,
            'page_sidebar_layout'   => 'right-sidebar',
            'page_sidebar_sticky_option'    => false,
            'preset_color_1'    => '#FD4F18',
            'preset_color_2'    => '#27272a',
            'preset_color_3'    => '#ef4444',
            'preset_color_4'    => '#eab308',
            'preset_color_5'    => '#84cc16',
            'preset_color_6'    => '#22c55e',
            'preset_color_7'    => '#06b6d4',
            'preset_color_8'    => '#0284c7',
            'preset_color_9'    => '#6366f1',
            'preset_color_10'    => '#84cc16',
            'preset_color_11'    => '#a855f7',
            'preset_color_12'    => '#f43f5e',
            'preset_gradient_1'   => 'linear-gradient( 135deg, #485563 10%, #29323c 100%)',
            'preset_gradient_2' => 'linear-gradient( 135deg, #FF512F 10%, #F09819 100%)',
            'preset_gradient_3'  => 'linear-gradient( 135deg, #00416A 10%, #E4E5E6 100%)',
            'preset_gradient_4'   => 'linear-gradient( 135deg, #CE9FFC 10%, #7367F0 100%)',
            'preset_gradient_5' => 'linear-gradient( 135deg, #90F7EC 10%, #32CCBC 100%)',
            'preset_gradient_6'  => 'linear-gradient( 135deg, #81FBB8 10%, #28C76F 100%)',
            'preset_gradient_7'   => 'linear-gradient( 135deg, #EB3349 10%, #F45C43 100%)',
            'preset_gradient_8' => 'linear-gradient( 135deg, #FFF720 10%, #3CD500 100%)',
            'preset_gradient_9'  => 'linear-gradient( 135deg, #FF96F9 10%, #C32BAC 100%)',
            'preset_gradient_10'   => 'linear-gradient( 135deg, #69FF97 10%, #00E4FF 100%)',
            'preset_gradient_11' => 'linear-gradient( 135deg, #3C8CE7 10%, #00EAFF 100%)',
            'preset_gradient_12'  => 'linear-gradient( 135deg, #FF7AF5 10%, #513162 100%)',
            'post_title_hover_effects'  => 'one',
            'site_image_hover_effects'  => 'none',
            'site_breadcrumb_option'    => true,
            'site_breadcrumb_type'  => 'default',
            'site_schema_ready' => true,
            'site_date_format'  => 'theme_format',
            'site_date_to_show' => 'published',
            'site_title_hover_textcolor'=> '#FD4F18',
            'site_description_color'    => '#8f8f8f',
            'homepage_content_order'    => array( 
                array( 'value'  => 'full_width_section', 'option'   => false ),
                array( 'value'  => 'leftc_rights_section', 'option'    => false ),
                array( 'value'   => 'lefts_rightc_section', 'option' => false ),
                array( 'value'   => 'latest_posts', 'option'    => true ),
                array( 'value' => 'bottom_full_width_section', 'option'  => true )
            ),
            'digital_newspaper_site_logo_width'    => array(
                'desktop'   => 230,
                'tablet'    => 200,
                'smartphone'    => 200
            ),
            'site_title_typo'    => array(
                'font_family'   => array( 'value' => 'Jost', 'label' => 'Jost' ),
                'font_weight'   => array( 'value' => '700', 'label' => 'Bold 700' ),
                'font_size'   => array(
                    'desktop' => 45,
                    'tablet' => 43,
                    'smartphone' => 40
                ),
                'line_height'   => array(
                    'desktop' => 45,
                    'tablet' => 42,
                    'smartphone' => 40,
                ),
                'letter_spacing'   => array(
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ),
                'text_transform'    => 'unset',
                'text_decoration'    => 'none',
            ),
            'top_header_option' => true,
            'top_header_responsive_option' => true,
            'top_header_date_time_option'   => true,
            'top_header_right_content_type' => 'ticker-news',
            'top_header_menu_option' => true,
            'top_header_ticker_news_option' => false,
            'top_header_ticker_news_post_filter' => 'category',
            'top_header_ticker_news_categories' => '[]',
            'top_header_ticker_news_posts' => '[]',
            'top_header_ticker_news_date_filter' => 'all',
            'top_header_social_option'  => true,
            'top_header_background_color_group' => json_encode(array(
                'type'  => 'gradient',
                'solid' => null,
                'gradient'  => 'linear-gradient(135deg,rgb(253,79,24) 10%,rgb(247,157,22) 100%)'
            )),
            'header_newsletter_option'   => true,
            'header_newsletter_label' => array( "icon"  => "far fa-envelope", "text"   => esc_html__( 'Newsletter', 'digital-newspaper' ) ),
            'header_newsletter_redirect_href_link'  => '',
            'header_random_news_option'   => true,
            'header_random_news_label' => array( "icon"  => "fas fa-random", "text"   => esc_html__( 'Random News', 'digital-newspaper' ) ),
            'header_random_news_link_to_single_news_option' => true,
            'header_random_news_filter'    => 'random',
            'header_ads_banner_responsive_option'  => array(
                'desktop'   => true,
                'tablet'   => true,
                'mobile'   => true
            ),
            'header_ads_banner_type'    => 'custom',
            'header_ads_banner_shortcode'   => '',
            'header_ads_banner_custom_image'  => '',
            'header_ads_banner_custom_url'  => '',
            'header_ads_banner_custom_target'  => '_self',
            'header_sidebar_toggle_option'  => true,
            'header_search_option'  => true,
            'header_theme_mode_toggle_option'  => true,
            'theme_header_sticky'  => false,
            'header_width_layout'   => 'full-width',
            'header_vertical_padding'   => array(
                'desktop' => 15,
                'tablet' => 10,
                'smartphone' => 10
            ),
            'header_background_color_group' => json_encode(array(
                'type'  => 'solid',
                'solid' => null,
                'gradient'  => null,
                'image'     => array( 'media_id' => 0, 'media_url' => '' )
            )),
            'header_menu_hover_effect'  => 'none',
            'header_menu_typo'    => array(
                'font_family'   => array( 'value' => 'Jost', 'label' => 'Jost' ),
                'font_weight'   => array( 'value' => '600', 'label' => 'Bold 600' ),
                'font_size'   => array(
                    'desktop' => 15,
                    'tablet' => 16,
                    'smartphone' => 16
                ),
                'line_height'   => array(
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24,
                ),
                'letter_spacing'   => array(
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ),
                'text_transform'    => 'unset',
                'text_decoration'    => 'none',
            ),
            'header_sub_menu_typo'    => array(
                'font_family'   => array( 'value' => 'Jost', 'label' => 'Jost' ),
                'font_weight'   => array( 'value' => '700', 'label' => 'Bold 700' ),
                'font_size'   => array(
                    'desktop' => 15,
                    'tablet' => 15,
                    'smartphone' => 15
                ),
                'line_height'   => array(
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24,
                ),
                'letter_spacing'   => array(
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ),
                'text_transform'    => 'unset',
                'text_decoration'    => 'none',
            ),
            'theme_header_live_search_option'   => true,
            'social_icons_target' => '_blank',
            'social_icons' => json_encode(array(
                array(
                    'icon_class'    => 'fab fa-facebook-f',
                    'icon_url'      => '',
                    'item_option'   => 'show'
                ),
                array(
                    'icon_class'    => 'fab fa-instagram',
                    'icon_url'      => '',
                    'item_option'   => 'show'
                ),
                array(
                    'icon_class'    => 'fab fa-twitter',
                    'icon_url'      => '',
                    'item_option'   => 'show'
                ),
                array(
                    'icon_class'    => 'fab fa-google-wallet',
                    'icon_url'      => '',
                    'item_option'   => 'show'
                ),
                array(
                    'icon_class'    => 'fab fa-youtube',
                    'icon_url'      => '',
                    'item_option'   => 'show'
                )
            )),
            'ticker_news_width_layout'  => 'global',
            'ticker_news_visible'   => 'front-page',
            'ticker_news_order_by'  => 'date-desc',
            'ticker_news_numbers'   => 6,
            'ticker_news_post_filter' => 'category',
            'ticker_news_categories' => '[]',
            'ticker_news_posts' => '[]',
            'ticker_news_date_filter' => 'all',
            'ticker_news_title' => array( "icon"  => "fas fa-dot-circle", "text"   => esc_html__( 'Headlines', 'digital-newspaper' ) ),
            'main_banner_option'    => true,
            'main_banner_layout'    => 'six',
            'main_banner_list_posts_title'  => esc_html__( 'Popular News', 'digital-newspaper' ),
            'main_banner_list_posts_categories'   => '[]',
            'main_banner_list_posts_order_by'  => 'rand-desc',
            'main_banner_slider_order_by'   => 'date-desc',
            'main_banner_post_filter' => 'category',
            'main_banner_slider_categories' => '[]',
            'main_banner_posts' => '[]',
            'main_banner_date_filter' => 'all',
            'main_banner_slider_numbers'    => 4,
            'main_banner_related_posts_option'  => true,
            'main_banner_grid_posts_title'  => esc_html__( 'Latest News', 'digital-newspaper' ),
            'main_banner_grid_posts_categories'   => '[]',
            'main_banner_grid_posts_order_by'  => 'rand-desc',
            'main_banner_grid_posts_direction'  => 'true',
            'main_banner_six_trailing_posts_order_by'  => 'rand-desc',
            'main_banner_six_trailing_post_filter'  => 'category',
            'main_banner_six_trailing_posts_categories'   => '[]',
            'main_banner_six_trailing_posts'   => '[]',
            'main_banner_six_trailing_posts_layout'   => 'row',
            'main_banner_width_layout'  => 'global',
            'banner_section_three_column_order'  => array( 
                array( 'value'  => 'grid_slider', 'option'    => true ),
                array( 'value'  => 'banner_slider', 'option'   => true ),
                array( 'value'  => 'list_posts', 'option'    => true )
            ),
            'full_width_blocks'   => json_encode(array(
                array(
                    'type'  => 'news-grid',
                    'blockId'    => '',
                    'option'    => true,
                    'column'    => 'four',
                    'layout'    => 'four',
                    'title'     => esc_html__( 'Featured posts', 'digital-newspaper' ),
                    'thumbOption'    => true,
                    'categoryOption'    => true,
                    'authorOption'  => true,
                    'dateOption'    => true,
                    'commentOption' => true,
                    'excerptOption' => true,
                    'excerptLength' => 10,
                    'query' => array(
                        'order' => 'date-desc',
                        'count' => 8,
                        'postFilter' => 'category',
                        'dateFilter' => 'all',
                        'posts' => [],
                        'categories' => [],
                        'ids' => []
                    ),
                    'buttonOption' => false,
                    'viewallOption'=> false,
                    'viewallUrl'   => ''
                ),
                array(
                    'type'  => 'ad-block',
                    'option'    => false,
                    'title'     => esc_html__( 'Advertisement Banner', 'digital-newspaper' ),
                    'media' => ['media_url' => '','media_id'=> 0],
                    'url'   =>  '',
                    'targetAttr'    => '_blank',
                    'relAttr'   => 'nofollow'
                )
            )),
            'full_width_blocks_width_layout'  => 'global',
            'leftc_rights_blocks'   => json_encode(array(
                array(
                    'type'  => 'news-filter',
                    'blockId'    => '',
                    'option'    => true,
                    'layout'    => 'one',
                    'title'     => esc_html__( 'Latest posts', 'digital-newspaper' ),
                    'categoryOption'    => true,
                    'authorOption'  => true,
                    'dateOption'    => true,
                    'commentOption' => true,
                    'excerptOption' => false,
                    'excerptLength' => 10,
                    'query' => array(
                        'order' => 'date-desc',
                        'count' => 7,
                        'postFilter' => 'category',
                        'dateFilter' => 'all',
                        'posts' => [],
                        'categories' => [],
                        'ids' => []
                    ),
                    'buttonOption'    => false,
                    'viewallOption'    => false,
                    'viewallUrl'   => ''
                )
            )),
            'leftc_rights_blocks_width_layout'  => 'global',
            'lefts_rightc_blocks'   => json_encode(array(
                array(
                    'type'  => 'news-list',
                    'blockId'    => '',
                    'option'    => true,
                    'layout'    => 'four',
                    'column'    => 'two',
                    'title'     => esc_html__( 'Latest posts', 'digital-newspaper' ),
                    'thumbOption'    => true,
                    'categoryOption'    => true,
                    'authorOption'  => true,
                    'dateOption'    => true,
                    'commentOption' => true,
                    'excerptOption' => true,
                    'excerptLength' => 10,
                    'query' => array(
                        'order' => 'date-desc',
                        'count' => 6,
                        'postFilter' => 'category',
                        'dateFilter' => 'all',
                        'posts' => [],
                        'categories' => [],
                        'ids' => []
                    ),
                    'buttonOption'    => false,
                    'viewallOption'    => false,
                    'viewallUrl'   => ''
                )
            )),
            'lefts_rightc_blocks_width_layout'  => 'global',
            'bottom_full_width_blocks'   => json_encode(array(
                array(
                    'type'  => 'news-carousel',
                    'blockId'    => '',
                    'option'    => true,
                    'layout'    => 'two',
                    'title'     => esc_html__( 'You May Have Missed', 'digital-newspaper' ),
                    'categoryOption'    => true,
                    'authorOption'  => true,
                    'dateOption'    => true,
                    'commentOption' => false,
                    'excerptOption' => false,
                    'excerptLength' => 10,
                    'columns' => 4,
                    'query' => array(
                        'order' => 'rand-desc',
                        'count' => 8,
                        'postFilter' => 'category',
                        'dateFilter' => 'all',
                        'posts' => [],
                        'categories' => [],
                        'ids' => []
                    ),
                    'buttonOption'    => false,
                    'viewallOption'    => false,
                    'viewallUrl'   => '',
                    'dots' => true,
                    'loop' => false,
                    'arrows' => true,
                    'auto' => false
                )
            )),
            'bottom_full_width_blocks_width_layout'  => 'global',
            'footer_option' => false,
            'footer_section_width'  => 'boxed-width',
            'footer_widget_column'  => 'column-three',
            'bottom_footer_option'  => true,
            'bottom_footer_social_option'   => true,
            'bottom_footer_menu_option'     => false,
            'bottom_footer_site_info'   => esc_html__( 'Digital Newspaper - Multipurpose News WordPress Theme %year%.', 'digital-newspaper' ),
            'bottom_footer_width_layout'    => 'global',
            'single_post_related_posts_option'  => true,
            'single_post_related_posts_title'   => esc_html__( 'Related News', 'digital-newspaper' ),
            'single_post_width_layout'=> 'global',
            'single_post_title_typo'=> array(
                'font_family'   => array( 'value' => 'Jost', 'label' => 'Jost' ),
                'font_weight'   => array( 'value' => '700', 'label' => 'Bold 700' ),
                'font_size'   => array(
                    'desktop' => 34,
                    'tablet' => 32,
                    'smartphone' => 30
                ),
                'line_height'   => array(
                    'desktop' => 40,
                    'tablet' => 40,
                    'smartphone' => 35
                ),
                'letter_spacing'   => array(
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ),
                'text_transform'    => 'unset',
                'text_decoration'    => 'none',
            ),
            'single_post_meta_typo'=> array(
                'font_family'   => array( 'value' => 'Jost', 'label' => 'Jost' ),
                'font_weight'   => array( 'value' => '500', 'label' => 'Medium 500' ),
                'font_size'   => array(
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 13
                ),
                'line_height'   => array(
                    'desktop' => 22,
                    'tablet' => 22,
                    'smartphone' => 22
                ),
                'letter_spacing'   => array(
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ),
                'text_transform'    => 'unset',
                'text_decoration'    => 'none',
            ),
            'single_post_content_typo'=> array(
                'font_family'   => array( 'value' => 'Jost', 'label' => 'Jost' ),
                'font_weight'   => array( 'value' => '400', 'label' => 'Regular 400' ),
                'font_size'   => array(
                    'desktop' => 17,
                    'tablet' => 16,
                    'smartphone' => 16
                ),
                'line_height'   => array(
                    'desktop' => 27,
                    'tablet' => 22,
                    'smartphone' => 22
                ),
                'letter_spacing'   => array(
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ),
                'text_transform'    => 'unset',
                'text_decoration'    => 'none',
            ),
            'archive_page_layout'   => 'one',
            'archive_pagination_type'   => 'number',
            'archive_width_layout'=> 'global',
            'single_page_width_layout' => 'global',
            'error_page_width_layout' => 'global',
            'search_page_width_layout' => 'global',
            'site_section_block_title_typo'    => array(
                'font_family'   => array( 'value' => 'Jost', 'label' => 'Jost' ),
                'font_weight'   => array( 'value' => '500', 'label' => 'Bold 500' ),
                'font_size'   => array(
                    'desktop' => 26,
                    'tablet' => 26,
                    'smartphone' => 25
                ),
                'line_height'   => array(
                    'desktop' => 30,
                    'tablet' => 30,
                    'smartphone' => 30
                ),
                'letter_spacing'   => array(
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ),
                'text_transform'    => 'unset',
                'text_decoration'    => 'none',
            ),
            'site_archive_post_title_typo'    => array(
                'font_family'   => array( 'value' => 'Jost', 'label' => 'Jost, Sans-serif' ),
                'font_weight'   => array( 'value' => '500', 'label' => 'Medium 500' ),
                'font_size'   => array(
                    'desktop' => 22,
                    'tablet' => 20,
                    'smartphone' => 19
                ),
                'line_height'   => array(
                    'desktop' => 27,
                    'tablet' => 27,
                    'smartphone' => 27
                ),
                'letter_spacing'   => array(
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ),
                'text_transform'    => 'unset',
                'text_decoration'    => 'none',
            ),
            'site_archive_post_meta_typo'    => array(
                'font_family'   => array( 'value' => 'Jost', 'label' => 'Jost' ),
                'font_weight'   => array( 'value' => '500', 'label' => 'Medium 500' ),
                'font_size'   => array(
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ),
                'line_height'   => array(
                    'desktop' => 20,
                    'tablet' => 20,
                    'smartphone' => 20
                ),
                'letter_spacing'   => array(
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ),
                'text_transform'    => 'unset',
                'text_decoration'    => 'none',
            ),
            'site_archive_post_content_typo'    => array(
                'font_family'   => array( 'value' => 'Jost', 'label' => 'Jost' ),
                'font_weight'   => array( 'value' => '400', 'label' => 'Regular 400' ),
                'font_size'   => array(
                    'desktop' => 15,
                    'tablet' => 15,
                    'smartphone' => 15
                ),
                'line_height'   => array(
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24
                ),
                'letter_spacing'   => array(
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ),
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ),
            'stt_responsive_option'    => array(
                'desktop'   => true,
                'tablet'   => true,
                'mobile'   => false
            )
        ));
        $totalCats = get_categories();
        if( $totalCats ) :
            foreach( $totalCats as $singleCat ) :
                $array_defaults['category_' .absint($singleCat->term_id). '_color'] = digital_newspaper_get_rcolor_code();
            endforeach;
        endif;
        return $array_defaults[$key];
    }
 endif;
 