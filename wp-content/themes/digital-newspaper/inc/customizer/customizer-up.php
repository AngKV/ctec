<?php
/**
 * Handles the customizer additional functionality.
 */
if( !function_exists( 'digital_newspaper_customizer_up_panel' ) ) :
    /**
     * Register controls for upsell, notifications and addtional info.
     * 
     */
    function digital_newspaper_customizer_up_panel( $wp_customize ) {
        // upgrade info box
        $wp_customize->add_setting( 'social_icons_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'social_icons_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Unlimited social icons items with unlimited choices', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'social_icons_section',
                'priority'  => 200,
                'settings'    => 'social_icons_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'preloader_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'preloader_upgrade_info', array(
                'label'	      => esc_html__( '20 + Preloader', 'digital-newspaper' ),
                'description' => esc_html__( 'Dedicated technical support.', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'preloader_section',
                'settings'    => 'preloader_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'website_style_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'website_style_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Website frame, Post card box shadow, icons choices for date, author, list', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'website_styles_section',
                'settings'    => 'website_style_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'website_layouts_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'website_layouts_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( '6 title layouts and 3 search popup layouts', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'website_layout_section',
                'settings'    => 'website_layouts_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'animation_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'animation_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Post appear animations, more effects choices', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'animation_section',
                'settings'    => 'animation_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'global_buttons_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'global_buttons_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Button font size, border and padding control', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'buttons_section',
                'settings'    => 'global_buttons_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'sidebars_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'sidebars_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Left and right both sidebar layout', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'sidebar_options_section',
                'settings'    => 'sidebars_upgrade_info',
                'priority'    => 1,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'breadcrumb_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'breadcrumb_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Text color, link color and background options', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'breadcrumb_options_section',
                'settings'    => 'breadcrumb_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'stt_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'stt_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Icon choices, text label, font size, position, border, padding, and background options ', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'stt_options_section',
                'settings'    => 'stt_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'typography_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'typography_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( '600+ google fonts, font size, line height, letter spacing, text tranform and text decoration', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'typography_section',
                'settings'    => 'typography_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'header_ads_banner_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'header_ads_banner_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Display ads from shortcode and ads banner sidebar in pro', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'header_ads_banner_section',
                'settings'    => 'header_ads_banner_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'bottom_footer_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'bottom_footer_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Copyright editor, Text color, link color and background color, gradient colors.', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'bottom_footer_section',
                'settings'    => 'bottom_footer_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'single_post_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'single_post_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Show or hide post title, meta, categories, author, elements reorder, typography and content background, ', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'single_post_section',
                'settings'    => 'single_post_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'top_header_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'top_header_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Date time color, menu color social icons color and hover colors.', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'top_header_section',
                'settings'    => 'top_header_upgrade_info',
                'priority'  => 100,
                'tab'   => 'design',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'theme_header_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'theme_header_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( '3 layouts and more color options', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'main_header_section',
                'settings'    => 'theme_header_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'header_newsletter_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'header_newsletter_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Display in popup, newsletter shortcode and label color option', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'header_newsletter_section',
                'settings'    => 'header_newsletter_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'header_menu_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'header_menu_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Active menu color, su menu color, background color, menu toggle color, border top, bottom and typography - font size, line height, letter spacing, text decoration, text tranform', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'header_menu_option_section',
                'settings'    => 'header_menu_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'header_live_search_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'header_live_search_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'show or hide image, post title, post date, number of posts to display, view all button and link target options', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'header_live_search_section',
                'settings'    => 'header_live_search_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'ticker_news_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'ticker_news_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( '3 layouts, show in innerpages, show or hide thumbnail, posts offset, controller hide, marquee settings', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'ticker_news_section',
                'settings'    => 'ticker_news_upgrade_info',
                'priority'  => 1,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'main_banner_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'main_banner_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( '5 layouts, posts offset, elements show or hide, related posts count, slider controls', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'main_banner_section',
                'settings'    => 'main_banner_upgrade_info',
                'priority'  => 1000,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'full_width_section_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'full_width_section_upgrade_info', array(
                'label'	      => esc_html__( 'More sections and news blocks', 'digital-newspaper' ),
                'description' => esc_html__( 'Unlimited sections, background color, gradient and image, three column, two column and video playlist section', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'full_width_section',
                'settings'    => 'full_width_section_upgrade_info',
                'priority'  => 20,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'leftc_rights_section_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'leftc_rights_section_upgrade_info', array(
                'label'	      => esc_html__( 'More sections and news blocks', 'digital-newspaper' ),
                'description' => esc_html__( 'Unlimited sections, background color, gradient and image, three column, two column and video playlist section', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'leftc_rights_section',
                'settings'    => 'leftc_rights_section_upgrade_info',
                'priority'  => 20,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'lefts_rightc_section_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'lefts_rightc_section_upgrade_info', array(
                'label'	      => esc_html__( 'More sections and news blocks', 'digital-newspaper' ),
                'description' => esc_html__( 'Unlimited sections, background color, gradient and image, three column, two column and video playlist section', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'lefts_rightc_section',
                'settings'    => 'lefts_rightc_section_upgrade_info',
                'priority'  => 20,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'bottom_full_width_section_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'bottom_full_width_section_upgrade_info', array(
                'label'	      => esc_html__( 'More sections and news blocks', 'digital-newspaper' ),
                'description' => esc_html__( 'Unlimited sections, background color, gradient and image, three column, two column and video playlist section', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'bottom_full_width_section',
                'settings'    => 'bottom_full_width_section_upgrade_info',
                'priority'  => 20,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'theme_header_design_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'theme_header_design_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Toggle bar color and search icon color.', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'main_header_section',
                'settings'    => 'theme_header_design_upgrade_info',
                'priority'  => 100,
                'tab'  => 'design',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'header_menu_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'header_menu_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Menu color, active menu color, hover color, sub menu color, background color, border color and typography.', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'header_menu_option_section',
                'settings'    => 'header_menu_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'footer_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'footer_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Text color and background color, image, gradient colors.', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'footer_section',
                'settings'    => 'footer_upgrade_info',
                'priority'  => 100,
                'tab'  => 'design',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'bottom_footer_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'bottom_footer_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Copyright editor, Text color, link color and background color, gradient colors.', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'bottom_footer_section',
                'settings'    => 'bottom_footer_upgrade_info',
                'priority'  => 100,
                'tab'  => 'design',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'blog_archive_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'blog_archive_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( '5 layouts, elements show hide, excerpt length, ajax pagination, elements, meta reorder show or hide, padding and content background', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'blog_archive_section',
                'settings'    => 'blog_archive_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( '404_section_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, '404_section_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Custom title, content and image upload field', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . '404_section',
                'settings'    => '404_section_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'search_page_section_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'search_page_section_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'digital-newspaper' ),
                'description' => esc_html__( 'Custom title and content fields', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'search_page_section',
                'settings'    => 'search_page_section_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/theme/digital-newspaper-pro/' )
                    )
                )
            ))
        );
    }
    add_action( 'customize_register', 'digital_newspaper_customizer_up_panel', 20 );
endif;