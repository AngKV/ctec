<?php
use Digital_Newspaper\CustomizerDefault as DN;
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
add_action( 'customize_preview_init', function() {
    wp_enqueue_script( 
        'digital-newspaper-customizer-preview',
        get_template_directory_uri() . '/inc/customizer/assets/customizer-preview.min.js',
        ['customize-preview'],
        DIGITAL_NEWSPAPER_VERSION,
        true
    );
    // trendyize scripts
	wp_localize_script( 
        'digital-newspaper-customizer-preview',
        'digitalNewspaperPreviewObject', array(
            '_wpnonce'	=> wp_create_nonce( 'digital-newspaper-customizer-nonce' ),
            'ajaxUrl' => esc_url(admin_url('admin-ajax.php'))
        )
    );
});

add_action( 'customize_controls_enqueue_scripts', function() {
    $buildControlsDeps = apply_filters(  'digital_newspaper_customizer_build_controls_dependencies', array(
        'react',
        'wp-blocks',
        'wp-editor',
        'wp-element',
        'wp-i18n',
        'wp-polyfill',
        'jquery',
        'wp-components'
    ));
	wp_enqueue_style( 
        'digital-newspaper-customizer-control',
        get_template_directory_uri() . '/inc/customizer/assets/customizer-controls.min.css', 
        array('wp-components'),
        DIGITAL_NEWSPAPER_VERSION,
        'all'
    );
    wp_enqueue_script( 
        'digital-newspaper-customizer-control',
        get_template_directory_uri() . '/inc/customizer/assets/customizer-extends.min.js',
        $buildControlsDeps,
        DIGITAL_NEWSPAPER_VERSION,
        true
    );
    wp_enqueue_script( 
        'digital-newspaper-customizer-extras',
        get_template_directory_uri() . '/inc/customizer/assets/extras.min.js',
        [],
        DIGITAL_NEWSPAPER_VERSION,
        true
    );
    // trendyize scripts
    wp_localize_script( 
        'digital-newspaper-customizer-control', 
        'customizerControlsObject', array(
            'categories'    => digital_newspaper_get_multicheckbox_categories_simple_array(),
            'posts'    => digital_newspaper_get_multicheckbox_posts_simple_array(),
            '_wpnonce'	=> wp_create_nonce( 'digital-newspaper-customizer-controls-live-nonce' ),
            'ajaxUrl' => esc_url(admin_url('admin-ajax.php'))
        )
    );
    // trendyize scripts
    wp_localize_script( 
        'digital-newspaper-customizer-extras', 
        'customizerExtrasObject', array(
            '_wpnonce'	=> wp_create_nonce( 'digital-newspaper-customizer-controls-nonce' ),
            'ajaxUrl' => esc_url(admin_url('admin-ajax.php'))
        )
    );
});

if( !function_exists( 'digital_newspaper_customizer_about_theme_panel' ) ) :
    /**
     * Register blog archive section settings
     * 
     */
    function digital_newspaper_customizer_about_theme_panel( $wp_customize ) {
        /**
         * About theme section
         * 
         * @since 1.0.0
         */
        $wp_customize->add_section( DIGITAL_NEWSPAPER_PREFIX . 'about_section', array(
            'title' => esc_html__( 'About Theme', 'digital-newspaper' ),
            'priority'  => 1
        ));

        // theme documentation info box
        $wp_customize->add_setting( 'site_documentation_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'site_documentation_info', array(
                'label'	      => esc_html__( 'Theme Documentation', 'digital-newspaper' ),
                'description' => esc_html__( 'We have well prepared documentation which includes overall instructions and recommendations that are required in this theme.', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'about_section',
                'settings'    => 'site_documentation_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Documentation', 'digital-newspaper' ),
                        'url'   => esc_url( '//doc.blazethemes.com/digital-newspaper' )
                    )
                )
            ))
        );

        // theme documentation info box
        $wp_customize->add_setting( 'site_support_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Info_Box_Control( $wp_customize, 'site_support_info', array(
                'label'	      => esc_html__( 'Theme Support', 'digital-newspaper' ),
                'description' => esc_html__( 'We provide 24/7 support regarding any theme issue. Our support team will help you to solve any kind of issue. Feel free to contact us.', 'digital-newspaper' ),
                'section'     => DIGITAL_NEWSPAPER_PREFIX . 'about_section',
                'settings'    => 'site_support_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'Support Form', 'digital-newspaper' ),
                        'url'   => esc_url( '//blazethemes.com/support' )
                    )
                )
            ))
        );
    }
    add_action( 'customize_register', 'digital_newspaper_customizer_about_theme_panel', 10 );
endif;

if( !function_exists( 'digital_newspaper_customizer_global_panel' ) ) :
    /**
     * Register global options settings
     * 
     */
    function digital_newspaper_customizer_global_panel( $wp_customize ) {
        /**
         * Global panel
         * 
         * @package Digital Newspaper
         * @since 1.0.0
         */
        $wp_customize->add_panel( 'digital_newspaper_global_panel', array(
            'title' => esc_html__( 'Global', 'digital-newspaper' ),
            'priority'  => 5
        ));

        // section- seo/misc settings section
        $wp_customize->add_section( 'digital_newspaper_seo_misc_section', array(
            'title' => esc_html__( 'SEO / Misc', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_global_panel'
        ));

        // site schema ready option
        $wp_customize->add_setting( 'site_schema_ready', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'site_schema_ready' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport'    => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Toggle_Control( $wp_customize, 'site_schema_ready', array(
                'label'	      => esc_html__( 'Make website schema ready', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_seo_misc_section',
                'settings'    => 'site_schema_ready'
            ))
        );

        // site date to show
        $wp_customize->add_setting( 'site_date_to_show', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            'default'   => DN\digital_newspaper_get_customizer_default( 'site_date_to_show' )
        ));
        $wp_customize->add_control( 'site_date_to_show', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_seo_misc_section',
            'label'     => esc_html__( 'Date to display', 'digital-newspaper' ),
            'description' => esc_html__( 'Whether to show date published or modified date.', 'digital-newspaper' ),
            'choices'   => array(
                'published'  => __( 'Published date', 'digital-newspaper' ),
                'modified'   => __( 'Modified date', 'digital-newspaper' )
            )
        ));

        // site date format
        $wp_customize->add_setting( 'site_date_format', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            'default'   => DN\digital_newspaper_get_customizer_default( 'site_date_format' )
        ));
        $wp_customize->add_control( 'site_date_format', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_seo_misc_section',
            'label'     => esc_html__( 'Date format', 'digital-newspaper' ),
            'description' => esc_html__( 'Date format applied to single and archive pages.', 'digital-newspaper' ),
            'choices'   => array(
                'theme_format'  => __( 'Default by theme', 'digital-newspaper' ),
                'default'   => __( 'Wordpress default date', 'digital-newspaper' )
            )
        ));

        // preset colors header
        $wp_customize->add_setting( 'preset_colors_heading', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'preset_colors_heading', array(
                'label'	      => esc_html__( 'Theme Presets', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_colors_heading'
            ))
        );

        // primary preset color
        $wp_customize->add_setting( 'preset_color_1', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_color_1' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'digital_newspaper_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_1', array(
                'label'	      => esc_html__( 'Color 1', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_1',
                'variable'   => '--digital-newspaper-global-preset-color-1'
            ))
        );

        // secondary preset color
        $wp_customize->add_setting( 'preset_color_2', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_color_2' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'digital_newspaper_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_2', array(
                'label'	      => esc_html__( 'Color 2', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_2',
                'variable'   => '--digital-newspaper-global-preset-color-2'
            ))
        );

        // tertiary preset color
        $wp_customize->add_setting( 'preset_color_3', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_color_3' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'digital_newspaper_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_3', array(
                'label'	      => esc_html__( 'Color 3', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_3',
                'variable'   => '--digital-newspaper-global-preset-color-3'
            ))
        );

        // primary preset link color
        $wp_customize->add_setting( 'preset_color_4', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_color_4' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'digital_newspaper_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_4', array(
                'label'	      => esc_html__( 'Color 4', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_4',
                'variable'   => '--digital-newspaper-global-preset-color-4'
            ))
        );

        // secondary preset link color
        $wp_customize->add_setting( 'preset_color_5', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_color_5' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'digital_newspaper_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_5', array(
                'label'	      => esc_html__( 'Color 5', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_5',
                'variable'   => '--digital-newspaper-global-preset-color-5'
            ))
        );
        
        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_6', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_color_6' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'digital_newspaper_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_6', array(
                'label'	      => esc_html__( 'Color 6', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_6',
                'variable'   => '--digital-newspaper-global-preset-color-6'
            ))
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_7', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_color_7' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'digital_newspaper_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_7', array(
                'label'       => esc_html__( 'Color 7', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_7',
                'variable'   => '--digital-newspaper-global-preset-color-7'
            ))
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_8', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_color_8' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'digital_newspaper_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_8', array(
                'label'       => esc_html__( 'Color 8', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_8',
                'variable'   => '--digital-newspaper-global-preset-color-8'
            ))
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_9', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_color_9' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'digital_newspaper_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_9', array(
                'label'       => esc_html__( 'Color 9', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_9',
                'variable'   => '--digital-newspaper-global-preset-color-9'
            ))
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_10', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_color_10' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'digital_newspaper_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_10', array(
                'label'       => esc_html__( 'Color 10', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_10',
                'variable'   => '--digital-newspaper-global-preset-color-10'
            ))
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_11', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_color_11' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'digital_newspaper_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_11', array(
                'label'       => esc_html__( 'Color 11', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_11',
                'variable'   => '--digital-newspaper-global-preset-color-11'
            ))
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_12', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_color_12' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'digital_newspaper_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_12', array(
                'label'       => esc_html__( 'Color 12', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_12',
                'variable'   => '--digital-newspaper-global-preset-color-12'
            ))
        );

        // gradient preset colors header
        $wp_customize->add_setting( 'gradient_preset_colors_heading', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'gradient_preset_colors_heading', array(
                'label'	      => esc_html__( 'Gradient Presets', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'gradient_preset_colors_heading'
            ))
        );

        // gradient color 1
        $wp_customize->add_setting( 'preset_gradient_1', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_gradient_1' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_1', array(
                'label'	      => esc_html__( 'Gradient 1', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_1',
                'variable'   => '--digital-newspaper-global-preset-gradient-color-1'
            ))
        );
        
        // gradient color 2
        $wp_customize->add_setting( 'preset_gradient_2', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_gradient_2' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_2', array(
                'label'	      => esc_html__( 'Gradient 2', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_2',
                'variable'   => '--digital-newspaper-global-preset-gradient-color-2'
            ))
        );

        // gradient color 3
        $wp_customize->add_setting( 'preset_gradient_3', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_gradient_3' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_3', array(
                'label'	      => esc_html__( 'Gradient 3', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_3',
                'variable'   => '--digital-newspaper-global-preset-gradient-color-3'
            ))
        );

        // gradient color 4
        $wp_customize->add_setting( 'preset_gradient_4', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_gradient_4' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_4', array(
                'label'	      => esc_html__( 'Gradient 4', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_4',
                'variable'   => '--digital-newspaper-global-preset-gradient-color-4'
            ))
        );

        // gradient color 5
        $wp_customize->add_setting( 'preset_gradient_5', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_gradient_5' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_5', array(
                'label'	      => esc_html__( 'Gradient 5', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_5',
                'variable'   => '--digital-newspaper-global-preset-gradient-color-5'
            ))
        );

        // gradient color 6
        $wp_customize->add_setting( 'preset_gradient_6', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_gradient_6' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_6', array(
                'label'	      => esc_html__( 'Gradient 6', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_6',
                'variable'   => '--digital-newspaper-global-preset-gradient-color-6'
            ))
        );

        // gradient color 7
        $wp_customize->add_setting( 'preset_gradient_7', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_gradient_7' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_7', array(
                'label'       => esc_html__( 'Gradient 7', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_7',
                'variable'   => '--digital-newspaper-global-preset-gradient-color-7'
            ))
        );

        // gradient color 8
        $wp_customize->add_setting( 'preset_gradient_8', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_gradient_8' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_8', array(
                'label'       => esc_html__( 'Gradient 8', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_8',
                'variable'   => '--digital-newspaper-global-preset-gradient-color-8'
            ))
        );

        // gradient color 9
        $wp_customize->add_setting( 'preset_gradient_9', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_gradient_9' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_9', array(
                'label'       => esc_html__( 'Gradient 9', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_9',
                'variable'   => '--digital-newspaper-global-preset-gradient-color-9'
            ))
        );

        // gradient color 10
        $wp_customize->add_setting( 'preset_gradient_10', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_gradient_10' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_10', array(
                'label'       => esc_html__( 'Gradient 10', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_10',
                'variable'   => '--digital-newspaper-global-preset-gradient-color-10'
            ))
        );

        // gradient color 11
        $wp_customize->add_setting( 'preset_gradient_11', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_gradient_11' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_11', array(
                'label'       => esc_html__( 'Gradient 11', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_11',
                'variable'   => '--digital-newspaper-global-preset-gradient-color-11'
            ))
        );

        // gradient color 12
        $wp_customize->add_setting( 'preset_gradient_12', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'preset_gradient_12' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_12', array(
                'label'       => esc_html__( 'Gradient 12', 'digital-newspaper' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_12',
                'variable'   => '--digital-newspaper-global-preset-gradient-color-12'
            ))
        );

        // section- category colors section
        $wp_customize->add_section( 'digital_newspaper_category_colors_section', array(
            'title' => esc_html__( 'Category Colors', 'digital-newspaper' ),
            'priority'  => 40
        ));

        $totalCats = get_categories();
        if( $totalCats ) :
            foreach( $totalCats as $singleCat ) :
                // category colors control
                $wp_customize->add_setting( 'category_' .absint($singleCat->term_id). '_color', array(
                    'default'   => DN\digital_newspaper_get_customizer_default( 'category_' .absint($singleCat->term_id). '_color' ),
                    'sanitize_callback' => 'digital_newspaper_sanitize_color_group_picker_control'
                ));
                $wp_customize->add_control( 
                    new Digital_Newspaper_WP_Color_Group_Picker_Control( $wp_customize, 'category_' .absint($singleCat->term_id). '_color', array(
                        'label'	      => esc_html($singleCat->name),
                        'section'     => 'digital_newspaper_category_colors_section',
                        'settings'    => 'category_' .absint($singleCat->term_id). '_color'
                    ))
                );
            endforeach;
        endif;

        // section- preloader section
        $wp_customize->add_section( 'digital_newspaper_preloader_section', array(
            'title' => esc_html__( 'Preloader', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_global_panel'
        ));
        
        // preloader option
        $wp_customize->add_setting( 'preloader_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default('preloader_option'),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'preloader_option', array(
                'label'	      => esc_html__( 'Enable site preloader', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_preloader_section',
                'settings'    => 'preloader_option'
            ))
        );

        // section- website styles section
        $wp_customize->add_section( 'digital_newspaper_website_styles_section', array(
            'title' => esc_html__( 'Website Styles', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_global_panel'
        ));

        // website block top border style heading
        $wp_customize->add_setting( 'website_block_top_border_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'website_block_top_border_header', array(
                'label'	      => esc_html__( 'Block Top Border Style', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_website_styles_section',
                'settings'    => 'website_block_top_border_header'
            ))
        );

        // website block top border
        $wp_customize->add_setting( 'website_block_border_top_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default('website_block_border_top_option'),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'website_block_border_top_option', array(
                'label'	      => esc_html__( 'Website block top border', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_website_styles_section',
                'settings'    => 'website_block_border_top_option'
            ))
        );
        // border color
        $wp_customize->add_setting( 'website_block_border_top_color', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'website_block_border_top_color' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Color_Group_Control( $wp_customize, 'website_block_border_top_color', array(
                'label'	      => esc_html__( 'Border Color', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_website_styles_section',
                'settings'    => 'website_block_border_top_color'
            ))
        );
        // section- website layout section
        $wp_customize->add_section( 'digital_newspaper_website_layout_section', array(
            'title' => esc_html__( 'Website Layout', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_global_panel'
        ));
        
        // website layout heading
        $wp_customize->add_setting( 'website_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'website_layout_header', array(
                'label'	      => esc_html__( 'Website Layout', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_website_layout_section',
                'settings'    => 'website_layout_header'
            ))
        );

        // website layout
        $wp_customize->add_setting( 'website_layout',
            array(
                'default'           => DN\digital_newspaper_get_customizer_default( 'website_layout' ),
                'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
                'transport' => 'postMessage'
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'website_layout',
            array(
                'section'  => 'digital_newspaper_website_layout_section',
                'choices'  => array(
                    'boxed--layout' => array(
                        'label' => esc_html__( 'Boxed', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/boxed-width.jpg'
                    ),
                    'full-width--layout' => array(
                        'label' => esc_html__( 'Full Width', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/full-width.jpg'
                    )
                )
            )
        ));

        // website content layout heading
        $wp_customize->add_setting( 'website_content_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'website_content_layout_header', array(
                'label'	      => esc_html__( 'Website Content Global Layout', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_website_layout_section',
                'settings'    => 'website_content_layout_header'
            ))
        );

        // website content layout
        $wp_customize->add_setting( 'website_content_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'website_content_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'website_content_layout',
            array(
                'section'  => 'digital_newspaper_website_layout_section',
                'choices'  => array(
                    'boxed--layout' => array(
                        'label' => esc_html__( 'Boxed', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/boxed_content.jpg'
                    ),
                    'full-width--layout' => array(
                        'label' => esc_html__( 'Full Width', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/full_content.jpg'
                    )
                )
            )
        ));

        // website block title layout heading
        $wp_customize->add_setting( 'website_block_title_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'website_block_title_layout_header', array(
                'label'	      => esc_html__( 'Block Title Layout', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_website_layout_section',
                'settings'    => 'website_block_title_layout_header'
            ))
        );

        // website block title layout
        $wp_customize->add_setting( 'website_block_title_layout',
            array(
                'default'           => DN\digital_newspaper_get_customizer_default( 'website_block_title_layout' ),
                'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
                'transport' => 'postMessage'
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'website_block_title_layout',
            array(
                'section'  => 'digital_newspaper_website_layout_section',
                'choices'  => array(
                    'layout-one' => array(
                        'label' => esc_html__( 'Layout One', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/block-title-layout-one.jpg'
                    ),
                    'layout-four' => array(
                        'label' => esc_html__( 'Layout Four', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/block-title-layout-four.jpg'
                    )
                )
            )
        ));

        // section- animation section
        $wp_customize->add_section( 'digital_newspaper_animation_section', array(
            'title' => esc_html__( 'Animation / Hover Effects', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_global_panel'
        ));

        // website hover effects heading
        $wp_customize->add_setting( 'website_hover_effects_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'website_hover_effects_header', array(
                'label'	      => esc_html__( 'Hover Effects Setting', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_animation_section',
                'settings'    => 'website_hover_effects_header'
            ))
        );

        // post title animation effects 
        $wp_customize->add_setting( 'post_title_hover_effects', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            'default'   => DN\digital_newspaper_get_customizer_default( 'post_title_hover_effects' ),
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 'post_title_hover_effects', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_animation_section',
            'label'     => esc_html__( 'Post title hover effects', 'digital-newspaper' ),
            'description' => esc_html__( 'Applied to post titles listed in archive pages.', 'digital-newspaper' ),
            'choices'   => array(
                'none' => __( 'None', 'digital-newspaper' ),
                'one'  => __( 'Effect One', 'digital-newspaper' ),
                'four'   => __( 'Effect Two', 'digital-newspaper' )
            )
        ));

        // site image animation effects 
        $wp_customize->add_setting( 'site_image_hover_effects', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            'default'   => DN\digital_newspaper_get_customizer_default( 'site_image_hover_effects' ),
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 'site_image_hover_effects', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_animation_section',
            'label'     => esc_html__( 'Image hover effects', 'digital-newspaper' ),
            'description' => esc_html__( 'Applied to post thumbanails listed in archive pages.', 'digital-newspaper' ),
            'choices'   => array(
                'none' => __( 'None', 'digital-newspaper' ),
                'six'   => __( 'Effect One', 'digital-newspaper' )
            )
        ));

        // section- social icons section
        $wp_customize->add_section( 'digital_newspaper_social_icons_section', array(
            'title' => esc_html__( 'Social Icons', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_global_panel'
        ));
        
        // social icons setting heading
        $wp_customize->add_setting( 'social_icons_settings_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'social_icons_settings_header', array(
                'label'	      => esc_html__( 'Social Icons Settings', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_social_icons_section',
                'settings'    => 'social_icons_settings_header'
            ))
        );

        // social icons target attribute value
        $wp_customize->add_setting( 'social_icons_target', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            'default'   => DN\digital_newspaper_get_customizer_default( 'social_icons_target' ),
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 'social_icons_target', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_social_icons_section',
            'label'     => esc_html__( 'Social Icon Link Open in', 'digital-newspaper' ),
            'description' => esc_html__( 'Sets the target attribute according to the value.', 'digital-newspaper' ),
            'choices'   => array(
                '_blank' => esc_html__( 'Open link in new tab', 'digital-newspaper' ),
                '_self'  => esc_html__( 'Open link in same tab', 'digital-newspaper' )
            )
        ));

        // social icons items
        $wp_customize->add_setting( 'social_icons', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'social_icons' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_repeater_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control(
            new Digital_Newspaper_WP_Custom_Repeater( $wp_customize, 'social_icons', array(
                'label'         => esc_html__( 'Social Icons', 'digital-newspaper' ),
                'description'   => esc_html__( 'Hold bar icon and drag vertically to re-order the icons', 'digital-newspaper' ),
                'section'       => 'digital_newspaper_social_icons_section',
                'settings'      => 'social_icons',
                'row_label'     => 'inherit-icon_class',
                'add_new_label' => esc_html__( 'Add New Icon', 'digital-newspaper' ),
                'fields'        => array(
                    'icon_class'   => array(
                        'type'          => 'fontawesome-icon-picker',
                        'label'         => esc_html__( 'Social Icon', 'digital-newspaper' ),
                        'description'   => esc_html__( 'Select from dropdown.', 'digital-newspaper' ),
                        'default'       => esc_attr( 'fab fa-instagram' )

                    ),
                    'icon_url'  => array(
                        'type'      => 'url',
                        'label'     => esc_html__( 'URL for icon', 'digital-newspaper' ),
                        'default'   => ''
                    ),
                    'item_option'             => 'show'
                )
            ))
        );

        // section- buttons section
        $wp_customize->add_section( 'digital_newspaper_buttons_section', array(
            'title' => esc_html__( 'Buttons', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_global_panel'
        ));

        // read more button label
        $wp_customize->add_setting( 'global_button_text', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'global_button_text' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_custom_text_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Icon_Text_Control( $wp_customize, 'global_button_text', array(
                'label'     => esc_html__( 'Button label', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_buttons_section',
                'settings'    => 'global_button_text',
                'icons' => array( "fas fa-ban", "fas fa-angle-right", "fas fa-arrow-alt-circle-right", "far fa-arrow-alt-circle-right", "fas fa-angle-double-right", "fas fa-long-arrow-alt-right", "fas fa-arrow-right", "fas fa-arrow-circle-right", "fas fa-chevron-circle-right", "fas fa-caret-right", "fas fa-hand-point-right", "fas fa-caret-square-right", "far fa-caret-square-right" )
            ))
        );
        
        // section- sidebar options section
        $wp_customize->add_section( 'digital_newspaper_sidebar_options_section', array(
            'title' => esc_html__( 'Sidebar Options', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_global_panel'
        ));

        // frontpage sidebar layout heading
        $wp_customize->add_setting( 'frontpage_sidebar_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'frontpage_sidebar_layout_header', array(
                'label'	      => esc_html__( 'Frontpage Sidebar Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_sidebar_options_section',
                'settings'    => 'frontpage_sidebar_layout_header'
            ))
        );

        // frontpage sidebar layout
        $wp_customize->add_setting( 'frontpage_sidebar_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'frontpage_sidebar_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'frontpage_sidebar_layout',
            array(
                'section'  => 'digital_newspaper_sidebar_options_section',
                'choices'  => digital_newspaper_get_customizer_sidebar_array()
            )
        ));

        // frontpage sidebar sticky option
        $wp_customize->add_setting( 'frontpage_sidebar_sticky_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'frontpage_sidebar_sticky_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'frontpage_sidebar_sticky_option', array(
                'label'	      => esc_html__( 'Enable sidebar sticky', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_sidebar_options_section',
                'settings'    => 'frontpage_sidebar_sticky_option'
            ))
        );

        // archive sidebar layouts heading
        $wp_customize->add_setting( 'archive_sidebar_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'archive_sidebar_layout_header', array(
                'label'	      => esc_html__( 'Archive Sidebar Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_sidebar_options_section',
                'settings'    => 'archive_sidebar_layout_header'
            ))
        );

        // archive sidebar layout
        $wp_customize->add_setting( 'archive_sidebar_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'archive_sidebar_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'archive_sidebar_layout',
            array(
                'section'  => 'digital_newspaper_sidebar_options_section',
                'choices'  => digital_newspaper_get_customizer_sidebar_array()
            )
        ));

        // archive sidebar sticky option
        $wp_customize->add_setting( 'archive_sidebar_sticky_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'archive_sidebar_sticky_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'archive_sidebar_sticky_option', array(
                'label'	      => esc_html__( 'Enable sidebar sticky', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_sidebar_options_section',
                'settings'    => 'archive_sidebar_sticky_option'
            ))
        );

        // single sidebar layouts heading
        $wp_customize->add_setting( 'single_sidebar_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'single_sidebar_layout_header', array(
                'label'	      => esc_html__( 'Post Sidebar Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_sidebar_options_section',
                'settings'    => 'single_sidebar_layout_header'
            ))
        );

        // single sidebar layout
        $wp_customize->add_setting( 'single_sidebar_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'single_sidebar_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'single_sidebar_layout',
            array(
                'section'  => 'digital_newspaper_sidebar_options_section',
                'choices'  => digital_newspaper_get_customizer_sidebar_array()
            )
        ));

        // single sidebar sticky option
        $wp_customize->add_setting( 'single_sidebar_sticky_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'single_sidebar_sticky_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'single_sidebar_sticky_option', array(
                'label'	      => esc_html__( 'Enable sidebar sticky', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_sidebar_options_section',
                'settings'    => 'single_sidebar_sticky_option'
            ))
        );

        // page sidebar layouts heading
        $wp_customize->add_setting( 'page_sidebar_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'page_sidebar_layout_header', array(
                'label'	      => esc_html__( 'Page Sidebar Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_sidebar_options_section',
                'settings'    => 'page_sidebar_layout_header'
            ))
        );

        // page sidebar layout
        $wp_customize->add_setting( 'page_sidebar_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'page_sidebar_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'page_sidebar_layout',
            array(
                'section'  => 'digital_newspaper_sidebar_options_section',
                'choices'  => digital_newspaper_get_customizer_sidebar_array()
            )
        ));

        // page sidebar sticky option
        $wp_customize->add_setting( 'page_sidebar_sticky_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'page_sidebar_sticky_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'page_sidebar_sticky_option', array(
                'label'	      => esc_html__( 'Enable sidebar sticky', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_sidebar_options_section',
                'settings'    => 'page_sidebar_sticky_option'
            ))
        );

        // section- breadcrumb options section
        $wp_customize->add_section( 'digital_newspaper_breadcrumb_options_section', array(
            'title' => esc_html__( 'Breadcrumb Options', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_global_panel'
        ));
        
        // breadcrumb option
        $wp_customize->add_setting( 'site_breadcrumb_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'site_breadcrumb_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'site_breadcrumb_option', array(
                'label'	      => esc_html__( 'Show breadcrumb trails', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_breadcrumb_options_section',
                'settings'    => 'site_breadcrumb_option'
            ))
        );

        // breadcrumb type 
        $wp_customize->add_setting( 'site_breadcrumb_type', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            'default'   => DN\digital_newspaper_get_customizer_default( 'site_breadcrumb_type' )
        ));
        $wp_customize->add_control( 'site_breadcrumb_type', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_breadcrumb_options_section',
            'label'     => esc_html__( 'Breadcrumb type', 'digital-newspaper' ),
            'description' => esc_html__( 'If you use other than "default" one you will need to install and activate respective plugins Breadcrumb NavXT, Yoast SEO and Rank Math SEO', 'digital-newspaper' ),
            'choices'   => array(
                'default' => __( 'Default', 'digital-newspaper' ),
                'bcn'  => __( 'NavXT', 'digital-newspaper' ),
                'yoast'  => __( 'Yoast SEO', 'digital-newspaper' ),
                'rankmath'  => __( 'Rank Math', 'digital-newspaper' )
            )
        ));

        // section- scroll to top options
        $wp_customize->add_section( 'digital_newspaper_stt_options_section', array(
            'title' => esc_html__( 'Scroll To Top', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_global_panel'
        ));
        
        // Resposive vivibility option
        $wp_customize->add_setting( 'stt_responsive_option', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'stt_responsive_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_responsive_multiselect_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Responsive_Multiselect_Tab_Control( $wp_customize, 'stt_responsive_option', array(
                'label'	      => esc_html__( 'Scroll To Top Visibility', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_stt_options_section',
                'settings'    => 'stt_responsive_option'
            ))
        );
    }
    add_action( 'customize_register', 'digital_newspaper_customizer_global_panel', 10 );
endif;

if( !function_exists( 'digital_newspaper_customizer_site_identity_panel' ) ) :
    /**
     * Register site identity settings
     * 
     */
    function digital_newspaper_customizer_site_identity_panel( $wp_customize ) {
        /**
         * Register "Site Identity Options" panel
         * 
         */
        $wp_customize->add_panel( 'digital_newspaper_site_identity_panel', array(
            'title' => esc_html__( 'Site Identity', 'digital-newspaper' ),
            'priority' => 5
        ));
        $wp_customize->get_section( 'title_tagline' )->panel = 'digital_newspaper_site_identity_panel'; // assing title tagline section to site identity panel
        $wp_customize->get_section( 'title_tagline' )->title = esc_html__( 'Logo & Site Icon', 'digital-newspaper' ); // modify site logo label

        /**
         * Site Title Section
         * 
         * panel - digital_newspaper_site_identity_panel
         */
        $wp_customize->add_section( 'digital_newspaper_site_title_section', array(
            'title' => esc_html__( 'Site Title & Tagline', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_site_identity_panel',
            'priority'  => 30,
        ));
        $wp_customize->get_control( 'blogname' )->section = 'digital_newspaper_site_title_section';
        $wp_customize->get_control( 'display_header_text' )->section = 'digital_newspaper_site_title_section';
        $wp_customize->get_control( 'display_header_text' )->label = esc_html__( 'Display site title', 'digital-newspaper' );
        $wp_customize->get_control( 'blogdescription' )->section = 'digital_newspaper_site_title_section';
        
        // site logo width
        $wp_customize->add_setting( 'digital_newspaper_site_logo_width', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'digital_newspaper_site_logo_width' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_responsive_range',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control(
            new Digital_Newspaper_WP_Responsive_Range_Control( $wp_customize, 'digital_newspaper_site_logo_width', array(
                    'label'	      => esc_html__( 'Logo Width (px)', 'digital-newspaper' ),
                    'section'     => 'title_tagline',
                    'settings'    => 'digital_newspaper_site_logo_width',
                    'unit'        => 'px',
                    'input_attrs' => array(
                    'max'         => 400,
                    'min'         => 1,
                    'step'        => 1,
                    'reset' => true
                )
            ))
        );

        // site title section tab
        $wp_customize->add_setting( 'site_title_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Tab_Control( $wp_customize, 'site_title_section_tab', array(
                'section'     => 'digital_newspaper_site_title_section',
                'priority'  => 1,
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'digital-newspaper' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'digital-newspaper' )
                    )
                )
            ))
        );

        // blog description option
        $wp_customize->add_setting( 'blogdescription_option', array(
            'default'        => true,
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 'blogdescription_option', array(
            'label'    => esc_html__( 'Display site description', 'digital-newspaper' ),
            'section'  => 'digital_newspaper_site_title_section',
            'type'     => 'checkbox',
            'priority' => 50
        ));

        $wp_customize->get_control( 'header_textcolor' )->section = 'digital_newspaper_site_title_section';
        $wp_customize->get_control( 'header_textcolor' )->priority = 60;
        $wp_customize->get_control( 'header_textcolor' )->label = esc_html__( 'Site Title Color', 'digital-newspaper' );

        // header text hover color
        $wp_customize->add_setting( 'site_title_hover_textcolor', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'site_title_hover_textcolor' ),
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Default_Color_Control( $wp_customize, 'site_title_hover_textcolor', array(
                'label'      => esc_html__( 'Site Title Hover Color', 'digital-newspaper' ),
                'section'    => 'digital_newspaper_site_title_section',
                'settings'   => 'site_title_hover_textcolor',
                'priority'    => 70,
                'tab'   => 'design'
            ))
        );

        // site description color
        $wp_customize->add_setting( 'site_description_color', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'site_description_color' ),
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Default_Color_Control( $wp_customize, 'site_description_color', array(
                'label'      => esc_html__( 'Site Description Color', 'digital-newspaper' ),
                'section'    => 'digital_newspaper_site_title_section',
                'settings'   => 'site_description_color',
                'priority'    => 70,
                'tab'   => 'design'
            ))
        );

        // site title typo
        $wp_customize->add_setting( 'site_title_typo', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'site_title_typo' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_typo_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Typography_Control( $wp_customize, 'site_title_typo', array(
                'label'	      => esc_html__( 'Site Title Typography', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_site_title_section',
                'settings'    => 'site_title_typo',
                'tab'   => 'design',
                'fields'    => array( 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration')
            ))
        );
    }
    add_action( 'customize_register', 'digital_newspaper_customizer_site_identity_panel', 10 );
endif;

if( !function_exists( 'digital_newspaper_customizer_top_header_panel' ) ) :
    /**
     * Register header options settings
     * 
     */
    function digital_newspaper_customizer_top_header_panel( $wp_customize ) {
        /**
         * Top header section
         * 
         */
        $wp_customize->add_section( 'digital_newspaper_top_header_section', array(
            'title' => esc_html__( 'Top Header', 'digital-newspaper' ),
            'priority'  => 68
        ));
        
        // section tab
        $wp_customize->add_setting( 'top_header_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Tab_Control( $wp_customize, 'top_header_section_tab', array(
                'section'     => 'digital_newspaper_top_header_section',
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'digital-newspaper' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'digital-newspaper' )
                    )
                )
            ))
        );
        
        // Top header option
        $wp_customize->add_setting( 'top_header_option', array(
            'default'         => DN\digital_newspaper_get_customizer_default( 'top_header_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
    
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Toggle_Control( $wp_customize, 'top_header_option', array(
                'label'	      => esc_html__( 'Show top header', 'digital-newspaper' ),
                'description' => esc_html__( 'Toggle to enable or disable top header bar', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_top_header_section',
                'settings'    => 'top_header_option'
            ))
        );

        // Top header date time option
        $wp_customize->add_setting( 'top_header_date_time_option', array(
            'default'         => DN\digital_newspaper_get_customizer_default( 'top_header_date_time_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control'
        ));
    
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'top_header_date_time_option', array(
                'label'	      => esc_html__( 'Show date and time', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_top_header_section',
                'settings'    => 'top_header_date_time_option',
            ))
        );

        // top header right content type
        $wp_customize->add_setting( 'top_header_right_content_type', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'top_header_right_content_type' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control'
        ));
        
        $wp_customize->add_control( 'top_header_right_content_type', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_top_header_section',
            'label'     => __( 'Ticker news / Nav menu choices', 'digital-newspaper' ),
            'choices'   => array(
                'ticker-news' => esc_html__( 'Ticker News', 'digital-newspaper' ),
                'nav-menu' => esc_html__( 'Nav Menu', 'digital-newspaper' )
            )
        ));

        // Top header ticker news option
        $wp_customize->add_setting( 'top_header_menu_option', array(
            'default'         => DN\digital_newspaper_get_customizer_default( 'top_header_menu_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control'
        ));
    
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'top_header_menu_option', array(
                'label'	      => esc_html__( 'Show nav menu', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_top_header_section',
                'settings'    => 'top_header_menu_option',
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'top_header_right_content_type' )->value() == 'nav-menu' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Top header ticker news option
        $wp_customize->add_setting( 'top_header_ticker_news_option', array(
            'default'         => DN\digital_newspaper_get_customizer_default( 'top_header_ticker_news_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control'
        ));
    
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'top_header_ticker_news_option', array(
                'label'	      => esc_html__( 'Show ticker news', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_top_header_section',
                'settings'    => 'top_header_ticker_news_option',
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'top_header_right_content_type' )->value() == 'ticker-news' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );
        
        // Ticker News posts filter
        $wp_customize->add_setting( 'top_header_ticker_news_post_filter', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'top_header_ticker_news_post_filter' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Bubble_Control( $wp_customize, 'top_header_ticker_news_post_filter', array(
                'section'     => 'digital_newspaper_top_header_section',
                'settings'    => 'top_header_ticker_news_post_filter',
                'choices' => array(
                    array(
                        'value' => 'category',
                        'label' => esc_html__('By category', 'digital-newspaper' )
                    ),
                    array(
                        'value' => 'title',
                        'label' => esc_html__('By title', 'digital-newspaper' )
                    )
                ),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'top_header_ticker_news_option' )->value() && $setting->manager->get_setting( 'top_header_right_content_type' )->value() == 'ticker-news' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Ticker News categories
        $wp_customize->add_setting( 'top_header_ticker_news_categories', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'top_header_ticker_news_categories' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Multiselect_Control( $wp_customize, 'top_header_ticker_news_categories', array(
                'label'     => esc_html__( 'Posts Categories', 'digital-newspaper' ),
                'section'   => 'digital_newspaper_top_header_section',
                'settings'  => 'top_header_ticker_news_categories',
                'choices'   => digital_newspaper_get_multicheckbox_categories_simple_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'top_header_ticker_news_option' )->value() && $setting->manager->get_setting( 'top_header_ticker_news_post_filter' )->value() == 'category' && $setting->manager->get_setting( 'top_header_right_content_type' )->value() == 'ticker-news' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Ticker News posts
        $wp_customize->add_setting( 'top_header_ticker_news_posts', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'top_header_ticker_news_posts' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Posts_Multiselect_Control( $wp_customize, 'top_header_ticker_news_posts', array(
                'label'     => esc_html__( 'Posts', 'digital-newspaper' ),
                'section'   => 'digital_newspaper_top_header_section',
                'settings'  => 'top_header_ticker_news_posts',
                'choices'   => digital_newspaper_get_multicheckbox_posts_simple_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'top_header_ticker_news_option' )->value() && $setting->manager->get_setting( 'top_header_ticker_news_post_filter' )->value() == 'title' && $setting->manager->get_setting( 'top_header_right_content_type' )->value() == 'ticker-news' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Ticker News date filter
        $wp_customize->add_setting( 'top_header_ticker_news_date_filter', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'top_header_ticker_news_date_filter' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Bubble_Control( $wp_customize, 'top_header_ticker_news_date_filter', array(
                'section'     => 'digital_newspaper_top_header_section',
                'settings'    => 'top_header_ticker_news_date_filter',
                'choices' => digital_newspaper_get_date_filter_choices_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'top_header_ticker_news_option' )->value() && $setting->manager->get_setting( 'top_header_ticker_news_post_filter' )->value() == 'category' && $setting->manager->get_setting( 'top_header_right_content_type' )->value() == 'ticker-news' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // top header social option
        $wp_customize->add_setting( 'top_header_social_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'top_header_social_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
    
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'top_header_social_option', array(
                'label'	      => esc_html__( 'Show social icons', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_top_header_section',
                'settings'    => 'top_header_social_option',
            ))
        );

        // Redirect header social icons link
        $wp_customize->add_setting( 'top_header_social_icons_redirects', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
        ));

        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Redirect_Control( $wp_customize, 'top_header_social_icons_redirects', array(
                'section'     => 'digital_newspaper_top_header_section',
                'settings'    => 'top_header_social_icons_redirects',
                'choices'     => array(
                    'header-social-icons' => array(
                        'type'  => 'section',
                        'id'    => 'digital_newspaper_social_icons_section',
                        'label' => esc_html__( 'Manage social icons', 'digital-newspaper' )
                    )
                )
            ))
        );

        // Top header background colors group control
        $wp_customize->add_setting( 'top_header_background_color_group', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'top_header_background_color_group' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Color_Group_Control( $wp_customize, 'top_header_background_color_group', array(
                'label'	      => esc_html__( 'Background', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_top_header_section',
                'settings'    => 'top_header_background_color_group',
                'tab'   => 'design'
            ))
        );
    }
    add_action( 'customize_register', 'digital_newspaper_customizer_top_header_panel', 10 );
endif;

if( !function_exists( 'digital_newspaper_customizer_header_panel' ) ) :
    /**
     * Register header options settings
     * 
     */
    function digital_newspaper_customizer_header_panel( $wp_customize ) {
        /**
         * Header panel
         * 
         */
        $wp_customize->add_panel( 'digital_newspaper_header_panel', array(
            'title' => esc_html__( 'Theme Header', 'digital-newspaper' ),
            'priority'  => 69
        ));
        
        // Header ads banner section
        $wp_customize->add_section( 'digital_newspaper_header_ads_banner_section', array(
            'title' => esc_html__( 'Ads Banner', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_header_panel',
            'priority'  => 5
        ));

        // Header Ads Banner setting heading
        $wp_customize->add_setting( 'digital_newspaper_header_ads_banner_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));

        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'digital_newspaper_header_ads_banner_header', array(
                'label'	      => esc_html__( 'Ads Banner Setting', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_header_ads_banner_section',
                'settings'    => 'digital_newspaper_header_ads_banner_header'
            ))
        );

        // Resposive vivibility option
        $wp_customize->add_setting( 'header_ads_banner_responsive_option', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'header_ads_banner_responsive_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_responsive_multiselect_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Responsive_Multiselect_Tab_Control( $wp_customize, 'header_ads_banner_responsive_option', array(
                'label'	      => esc_html__( 'Ads Banner Visibility', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_header_ads_banner_section',
                'settings'    => 'header_ads_banner_responsive_option'
            ))
        );

        // ads image field
        $wp_customize->add_setting( 'header_ads_banner_custom_image', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'header_ads_banner_custom_image' ),
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'header_ads_banner_custom_image', array(
            'section' => 'digital_newspaper_header_ads_banner_section',
            'mime_type' => 'image',
            'label' => esc_html__( 'Ads Image', 'digital-newspaper' ),
            'description' => esc_html__( 'Recommended size for ad image is 900 (width) * 350 (height)', 'digital-newspaper' )
        )));

        // ads url field
        $wp_customize->add_setting( 'header_ads_banner_custom_url', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'header_ads_banner_custom_url' ),
            'sanitize_callback' => 'esc_url_raw',
        ));
          
        $wp_customize->add_control( 'header_ads_banner_custom_url', array(
            'type'  => 'url',
            'section'   => 'digital_newspaper_header_ads_banner_section',
            'label'     => esc_html__( 'Ads url', 'digital-newspaper' )
        ));

        // ads link show on
        $wp_customize->add_setting( 'header_ads_banner_custom_target', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'header_ads_banner_custom_target' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control'
        ));
        
        $wp_customize->add_control( 'header_ads_banner_custom_target', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_header_ads_banner_section',
            'label'     => __( 'Open Ads link on', 'digital-newspaper' ),
            'choices'   => array(
                '_self' => esc_html__( 'Open in same tab', 'digital-newspaper' ),
                '_blank' => esc_html__( 'Open in new tab', 'digital-newspaper' )
            )
        ));

        // Header content section
        $wp_customize->add_section( 'digital_newspaper_main_header_section', array(
            'title' => esc_html__( 'Main Header', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_header_panel',
            'priority'  => 10
        ));

        // section tab
        $wp_customize->add_setting( 'main_header_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Tab_Control( $wp_customize, 'main_header_section_tab', array(
                'section'     => 'digital_newspaper_main_header_section',
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'digital-newspaper' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'digital-newspaper' )
                    )
                )
            ))
        );

        // header width layout
        $wp_customize->add_setting( 'header_width_layout', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'header_width_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control'
        ));
        $wp_customize->add_control( 'header_width_layout', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_main_header_section',
            'label'     => __( 'Width Layout', 'digital-newspaper' ),
            'choices'   => array(
                'contain' => esc_html__( 'Container', 'digital-newspaper' ),
                'full-width' => esc_html__( 'Full Width', 'digital-newspaper' )
            )
        ));

        // redirect site logo section
        $wp_customize->add_setting( 'header_site_logo_redirects', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
        ));

        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Redirect_Control( $wp_customize, 'header_site_logo_redirects', array(
                'section'     => 'digital_newspaper_main_header_section',
                'settings'    => 'header_site_logo_redirects',
                'choices'     => array(
                    'header-social-icons' => array(
                        'type'  => 'section',
                        'id'    => 'title_tagline',
                        'label' => esc_html__( 'Manage Site Logo', 'digital-newspaper' )
                    )
                )
            ))
        );

        // redirect site title section
        $wp_customize->add_setting( 'header_site_title_redirects', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
        ));

        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Redirect_Control( $wp_customize, 'header_site_title_redirects', array(
                'section'     => 'digital_newspaper_main_header_section',
                'settings'    => 'header_site_title_redirects',
                'choices'     => array(
                    'header-social-icons' => array(
                        'type'  => 'section',
                        'id'    => 'digital_newspaper_site_title_section',
                        'label' => esc_html__( 'Manage site & Tagline', 'digital-newspaper' )
                    )
                )
            ))
        );

        // header sidebar toggle button option
        $wp_customize->add_setting( 'header_sidebar_toggle_option', array(
            'default'         => DN\digital_newspaper_get_customizer_default( 'header_sidebar_toggle_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
    
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'header_sidebar_toggle_option', array(
                'label'	      => esc_html__( 'Show sidebar toggle button', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_main_header_section',
                'settings'    => 'header_sidebar_toggle_option'
            ))
        );

        // redirect sidebar toggle button link
        $wp_customize->add_setting( 'header_sidebar_toggle_button_redirects', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
        ));

        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Redirect_Control( $wp_customize, 'header_sidebar_toggle_button_redirects', array(
                'section'     => 'digital_newspaper_main_header_section',
                'settings'    => 'header_sidebar_toggle_button_redirects',
                'choices'     => array(
                    'header-social-icons' => array(
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-header-toggle-sidebar',
                        'label' => esc_html__( 'Manage sidebar from here', 'digital-newspaper' )
                    )
                )
            ))
        );

        // header search option
        $wp_customize->add_setting( 'header_search_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'header_search_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
    
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'header_search_option', array(
                'label'	      => esc_html__( 'Show search icon', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_main_header_section',
                'settings'    => 'header_search_option'
            ))
        );

        // live search redirect
        $wp_customize->add_setting( 'website_search_live_search_redirects', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control'
        ));

        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Redirect_Control( $wp_customize, 'website_search_live_search_redirects', array(
                'section'     => 'digital_newspaper_main_header_section',
                'choices'     => array(
                    'header-social-icons' => array(
                        'type'  => 'section',
                        'id'    => 'digital_newspaper_header_live_search_section',
                        'label' => esc_html__( 'Manage live search', 'digital-newspaper' )
                    )
                )
            ))
        );
        
        // header theme mode toggle option
        $wp_customize->add_setting( 'header_theme_mode_toggle_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'header_theme_mode_toggle_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'header_theme_mode_toggle_option', array(
                'label'	      => esc_html__( 'Show dark/light toggle icon', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_main_header_section',
                'settings'    => 'header_theme_mode_toggle_option'
            ))
        );

        // header sticky option
        $wp_customize->add_setting( 'theme_header_sticky', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'theme_header_sticky' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'theme_header_sticky', array(
                'label'	      => esc_html__( 'Enable header section sticky ( on scroll up )', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_main_header_section',
                'settings'    => 'theme_header_sticky'
            ))
        );

        // header top and bottom padding
        $wp_customize->add_setting( 'header_vertical_padding', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'header_vertical_padding' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_responsive_range',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control(
            new Digital_Newspaper_WP_Responsive_Range_Control( $wp_customize, 'header_vertical_padding', array(
                    'label'	      => esc_html__( 'Vertical Padding (px)', 'digital-newspaper' ),
                    'section'     => 'digital_newspaper_main_header_section',
                    'settings'    => 'header_vertical_padding',
                    'unit'        => 'px',
                    'tab'   => 'design',
                    'input_attrs' => array(
                    'max'         => 500,
                    'min'         => 1,
                    'step'        => 1,
                    'reset' => true
                )
            ))
        );

        // Header background colors setting heading
        $wp_customize->add_setting( 'header_background_color_group', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'header_background_color_group' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_color_image_group_control',
            'transport' => 'postMessage'
        ));
        
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Color_Image_Group_Control( $wp_customize, 'header_background_color_group', array(
                'label'	      => esc_html__( 'Background', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_main_header_section',
                'settings'    => 'header_background_color_group',
                'tab'   => 'design'
            ))
        );

        // Header newsletter section
        $wp_customize->add_section( 'digital_newspaper_header_newsletter_section', array(
            'title' => esc_html__( 'Newsletter / Subscribe Button', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_header_panel',
            'priority'  => 15
        ));

        // Header newsletter heading
        $wp_customize->add_setting( 'digital_newspaper_header_newsletter_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'digital_newspaper_header_newsletter_header', array(
                'label'	      => esc_html__( 'Newsletter/Subscribe Setting', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_header_newsletter_section',
                'settings'    => 'digital_newspaper_header_newsletter_header'
            ))
        );

        // header newsletter button option
        $wp_customize->add_setting( 'header_newsletter_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'header_newsletter_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'header_newsletter_option', array(
                'label'	      => esc_html__( 'Show newsletter button', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_header_newsletter_section',
                'settings'    => 'header_newsletter_option'
            ))
        );

        // newsletter redirect url
        $wp_customize->add_setting( 'header_newsletter_redirect_href_link', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'header_newsletter_redirect_href_link' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_url',
        ));
        $wp_customize->add_control( 'header_newsletter_redirect_href_link', array(
            'label' => esc_html__( 'Redirect URL.', 'digital-newspaper' ),
            'description'   => esc_html__( 'Add url for the button to redirect.', 'digital-newspaper' ),
            'section'   => 'digital_newspaper_header_newsletter_section',
            'type'  => 'url'
        ));

        // Header random news section
        $wp_customize->add_section( 'digital_newspaper_header_random_news_section', array(
            'title' => esc_html__( 'Random News', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_header_panel',
            'priority'  => 15
        ));

        // Header random news heading
        $wp_customize->add_setting( 'digital_newspaper_header_random_news_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'digital_newspaper_header_random_news_header', array(
                'label'	      => esc_html__( 'Random News Setting', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_header_random_news_section',
                'settings'    => 'digital_newspaper_header_random_news_header'
            ))
        );

        // header random news button option
        $wp_customize->add_setting( 'header_random_news_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'header_random_news_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'header_random_news_option', array(
                'label'	      => esc_html__( 'Show random news button', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_header_random_news_section',
                'settings'    => 'header_random_news_option'
            ))
        );

        // header random news button option
        $wp_customize->add_setting( 'header_random_news_link_to_single_news_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'header_random_news_link_to_single_news_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'header_random_news_link_to_single_news_option', array(
                'label'	      => esc_html__( 'Redirect button to single random news', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_header_random_news_section',
                'settings'    => 'header_random_news_link_to_single_news_option'
            ))
        );

        // random news filter
        $wp_customize->add_setting( 'header_random_news_filter', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'header_random_news_filter' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Bubble_Control( $wp_customize, 'header_random_news_filter', array(
                'label'	      => esc_html__( 'Type of posts to dislay', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_header_random_news_section',
                'settings'    => 'header_random_news_filter',
                'choices' => digital_newspaper_get_random_news_filter_choices_array(),
                'active_callback'   => function( $setting ) {
                    if ( ! $setting->manager->get_setting( 'header_random_news_link_to_single_news_option' )->value() ) {
                        return true;
                    }
                    return false;
                }
            ))
        );
        
        /**
         * Menu Options Section
         * 
         * panel - digital_newspaper_header_options_panel
         */
        $wp_customize->add_section( 'digital_newspaper_header_menu_option_section', array(
            'title' => esc_html__( 'Menu Options', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_header_panel',
            'priority'  => 30,
        ));

        // menu section tab
        $wp_customize->add_setting( 'header_menu_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'design'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Tab_Control( $wp_customize, 'header_menu_section_tab', array(
                'section'     => 'digital_newspaper_header_menu_option_section',
                'choices'  => array(
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'digital-newspaper' )
                    ),
                    array(
                        'name'  => 'typo',
                        'title'  => esc_html__( 'Typography', 'digital-newspaper' )
                    )
                )
            ))
        );

        // header menu hover effect
        $wp_customize->add_setting( 'header_menu_hover_effect', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'header_menu_hover_effect' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Tab_Control( $wp_customize, 'header_menu_hover_effect', array(
                'label'	      => esc_html__( 'Hover Effect', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_header_menu_option_section',
                'settings'    => 'header_menu_hover_effect',
                'tab'   => 'design',
                'choices' => array(
                    array(
                        'value' => 'none',
                        'label' => esc_html__('None', 'digital-newspaper' )
                    ),
                    array(
                        'value' => 'one',
                        'label' => esc_html__('One', 'digital-newspaper' )
                    )
                )
            ))
        );
        
        // menu typo
        $wp_customize->add_setting( 'header_menu_typo', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'header_menu_typo' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_typo_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Typography_Control( $wp_customize, 'header_menu_typo', array(
                'label'	      => esc_html__( 'Main Menu', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_header_menu_option_section',
                'settings'    => 'header_menu_typo',
                'tab'   => 'typo',
                'fields'    => array( 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration')
            ))
        );

        // sub menu typo
        $wp_customize->add_setting( 'header_sub_menu_typo', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'header_sub_menu_typo' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_typo_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Typography_Control( $wp_customize, 'header_sub_menu_typo', array(
                'label'	      => esc_html__( 'Sub Menu', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_header_menu_option_section',
                'settings'    => 'header_sub_menu_typo',
                'tab'   => 'typo',
                'fields'    => array( 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration')
            ))
        );

        /**
         * Live Search Section
         * 
         * panel - digital_newspaper_header_options_panel
         */
        $wp_customize->add_section( 'digital_newspaper_header_live_search_section', array(
            'title' => esc_html__( 'Live Search', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_header_panel',
            'priority'  => 50
        ));

        // header live search option
        $wp_customize->add_setting( 'theme_header_live_search_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'theme_header_live_search_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Toggle_Control( $wp_customize, 'theme_header_live_search_option', array(
                'label'	      => esc_html__( 'Enable live search', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_header_live_search_section'
            ))
        );
    }
    add_action( 'customize_register', 'digital_newspaper_customizer_header_panel', 10 );
endif;

if( !function_exists( 'digital_newspaper_customizer_ticker_news_panel' ) ) :
    // Register header options settings
    function digital_newspaper_customizer_ticker_news_panel( $wp_customize ) {
        // Header ads banner section
        $wp_customize->add_section( 'digital_newspaper_ticker_news_section', array(
            'title' => esc_html__( 'Ticker News', 'digital-newspaper' ),
            'priority'  => 70
        ));

        // Ticker News Width Layouts setting heading
        $wp_customize->add_setting( 'ticker_news_width_layouts_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'ticker_news_width_layouts_header', array(
                'label'	      => esc_html__( 'Width Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_ticker_news_section',
                'settings'    => 'ticker_news_width_layouts_header'
            ))
        );

        // website content layout
        $wp_customize->add_setting( 'ticker_news_width_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'ticker_news_width_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'ticker_news_width_layout',
            array(
                'section'  => 'digital_newspaper_ticker_news_section',
                'choices'  => array(
                    'global' => array(
                        'label' => esc_html__( 'Global', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/global.jpg'
                    ),
                    'boxed--layout' => array(
                        'label' => esc_html__( 'Boxed', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/boxed_content.jpg'
                    ),
                    'full-width--layout' => array(
                        'label' => esc_html__( 'Full Width', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/full_content.jpg'
                    )
                )
            )
        ));

        // Header menu hover effect
        $wp_customize->add_setting( 'ticker_news_visible', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'ticker_news_visible' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control'
        ));
        
        $wp_customize->add_control( 'ticker_news_visible', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_ticker_news_section',
            'label'     => esc_html__( 'Show ticker on', 'digital-newspaper' ),
            'choices'   => array(
                'front-page' => esc_html__( 'Frontpage', 'digital-newspaper' ),
                'none' => esc_html__( 'Hide', 'digital-newspaper' ),
            ),
        ));

        // Ticker News content setting heading
        $wp_customize->add_setting( 'ticker_news_content_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'ticker_news_content_header', array(
                'label'	      => esc_html__( 'Content Setting', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_ticker_news_section',
                'settings'    => 'ticker_news_content_header',
                'type'        => 'section-heading',
            ))
        );
        
        // Ticker News title
        $wp_customize->add_setting( 'ticker_news_title', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'ticker_news_title' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_custom_text_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Icon_Text_Control( $wp_customize, 'ticker_news_title', array(
                'label'     => esc_html__( 'Ticker title', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_ticker_news_section',
                'settings'    => 'ticker_news_title',
                'icons' => array( "fas fa-ban", "fas fa-bolt", "fas fa-rss", "fas fa-newspaper", "far fa-newspaper", "fas fa-rss-square", "fas fa-fire", "fas fa-wifi", "fab fa-gripfire", "fab fa-free-code-camp", "fas fa-globe-americas", "fas fa-circle", "far fa-circle", "fas fa-circle-notch", "fas fa-dot-circle" )
            ))
        );

        // Ticker News orderby
        $wp_customize->add_setting( 'ticker_news_order_by', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'ticker_news_order_by' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control'
        ));
        
        $wp_customize->add_control( 'ticker_news_order_by', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_ticker_news_section',
            'label'     => esc_html__( 'Orderby', 'digital-newspaper' ),
            'choices'   => array(
                'date-desc' => esc_html__( 'Newest - Oldest', 'digital-newspaper' ),
                'date-asc' => esc_html__( 'Oldest - Newest', 'digital-newspaper' ),
                'title-asc' => esc_html__( 'A - Z', 'digital-newspaper' ),
                'title-desc' => esc_html__( 'Z - A', 'digital-newspaper' ),
                'rand-desc' => esc_html__( 'Random', 'digital-newspaper' )
            ),
        ));

        // Ticker News posts filter
        $wp_customize->add_setting( 'ticker_news_post_filter', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'ticker_news_post_filter' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Bubble_Control( $wp_customize, 'ticker_news_post_filter', array(
                'section'     => 'digital_newspaper_ticker_news_section',
                'settings'    => 'ticker_news_post_filter',
                'choices' => array(
                    array(
                        'value' => 'category',
                        'label' => esc_html__('By category', 'digital-newspaper' )
                    ),
                    array(
                        'value' => 'title',
                        'label' => esc_html__('By title', 'digital-newspaper' )
                    )
                )
            ))
        );

        // Ticker News categories
        $wp_customize->add_setting( 'ticker_news_categories', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'ticker_news_categories' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Multiselect_Control( $wp_customize, 'ticker_news_categories', array(
                'label'     => esc_html__( 'Posts Categories', 'digital-newspaper' ),
                'section'   => 'digital_newspaper_ticker_news_section',
                'settings'  => 'ticker_news_categories',
                'choices'   => digital_newspaper_get_multicheckbox_categories_simple_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'ticker_news_post_filter' )->value() == 'category' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Ticker News posts
        $wp_customize->add_setting( 'ticker_news_posts', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'ticker_news_posts' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Posts_Multiselect_Control( $wp_customize, 'ticker_news_posts', array(
                'label'     => esc_html__( 'Posts', 'digital-newspaper' ),
                'section'   => 'digital_newspaper_ticker_news_section',
                'settings'  => 'ticker_news_posts',
                'choices'   => digital_newspaper_get_multicheckbox_posts_simple_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'ticker_news_post_filter' )->value() == 'title' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Ticker News date filter
        $wp_customize->add_setting( 'ticker_news_date_filter', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'ticker_news_date_filter' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Bubble_Control( $wp_customize, 'ticker_news_date_filter', array(
                'section'     => 'digital_newspaper_ticker_news_section',
                'settings'    => 'ticker_news_date_filter',
                'choices' => digital_newspaper_get_date_filter_choices_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'ticker_news_post_filter' )->value() == 'category' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Ticker News number of posts
        $wp_customize->add_setting( 'ticker_news_numbers', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'ticker_news_numbers' ),
            'sanitize_callback' => 'absint'
        ));
        
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Range_Control( $wp_customize, 'ticker_news_numbers', array(
                'label'	      => esc_html__( 'Number of posts to display', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_ticker_news_section',
                'settings'    => 'ticker_news_numbers',
                'input_attrs' => array(
                    'min'   => 1,
                    'max'   => 5,
                    'step'  => 1,
                    'reset' => false
                ),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'ticker_news_post_filter' )->value() == 'category' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );
    }
    add_action( 'customize_register', 'digital_newspaper_customizer_ticker_news_panel', 10 );
endif;

if( !function_exists( 'digital_newspaper_customizer_main_banner_panel' ) ) :
    /**
     * Register main banner section settings
     * 
     */
    function digital_newspaper_customizer_main_banner_panel( $wp_customize ) {
        /**
         * Main Banner section
         * 
         */
        $wp_customize->add_section( 'digital_newspaper_main_banner_section', array(
            'title' => esc_html__( 'Main Banner', 'digital-newspaper' ),
            'priority'  => 70
        ));

        // main banner section tab
        $wp_customize->add_setting( 'main_banner_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Tab_Control( $wp_customize, 'main_banner_section_tab', array(
                'section'     => 'digital_newspaper_main_banner_section',
                'priority'  => 1,
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'digital-newspaper' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'digital-newspaper' )
                    )
                )
            ))
        );

        // Main Banner option
        $wp_customize->add_setting( 'main_banner_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'main_banner_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control'
        ));
    
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Toggle_Control( $wp_customize, 'main_banner_option', array(
                'label'	      => esc_html__( 'Show main banner', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_main_banner_section',
                'settings'    => 'main_banner_option'
            ))
        );

        // Main Banner Layouts
        $wp_customize->add_setting( 'main_banner_layout', array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'main_banner_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
        ));
        $wp_customize->add_control( new Digital_Newspaper_WP_Radio_Image_Control(
            $wp_customize,
            'main_banner_layout',
            array(
                'section'  => 'digital_newspaper_main_banner_section',
                'priority' => 10,
                'choices'  => array(
                    'five' => array(
                        'label' => esc_html__( 'Layout Five', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/main_banner_five.jpg'
                    ),
                    'six' => array(
                        'label' => esc_html__( 'Layout six', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/main_banner_six.jpg'
                    )
                )
            )
        ));

        // Main banner list posts setting heading
        $wp_customize->add_setting( 'main_banner_list_posts_settings_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'main_banner_list_posts_settings_header', array(
                'label'	      => esc_html__( 'List Posts Setting', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_main_banner_section',
                'settings'    => 'main_banner_list_posts_settings_header',
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_layout' )->value() === 'five' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Main Banner list posts title
        $wp_customize->add_setting( 'main_banner_list_posts_title', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_list_posts_title' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ));
        
        $wp_customize->add_control( 'main_banner_list_posts_title', array(
            'type'      => 'text',
            'section'   => 'digital_newspaper_main_banner_section',
            'label'     => esc_html__( 'Popular posts title', 'digital-newspaper' ),
            'active_callback'   => function( $setting ) {
                if ( $setting->manager->get_setting( 'main_banner_layout' )->value() === 'five' ) {
                    return true;
                }
                return false;
            }
        ));

        // Main Banner list posts categories
        $wp_customize->add_setting( 'main_banner_list_posts_categories', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_list_posts_categories' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Multiselect_Control( $wp_customize, 'main_banner_list_posts_categories', array(
                'label'     => esc_html__( 'Popular posts categories', 'digital-newspaper' ),
                'section'   => 'digital_newspaper_main_banner_section',
                'settings'  => 'main_banner_list_posts_categories',
                'choices'   => digital_newspaper_get_multicheckbox_categories_simple_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_layout' )->value() === 'five' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Main Banner list posts slider orderby
        $wp_customize->add_setting( 'main_banner_list_posts_order_by', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_list_posts_order_by' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control'
        ));
        $wp_customize->add_control( 'main_banner_list_posts_order_by', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_main_banner_section',
            'label'     => esc_html__( 'Orderby', 'digital-newspaper' ),
            'choices'   => array(
                'date-desc' => esc_html__( 'Newest - Oldest', 'digital-newspaper' ),
                'date-asc' => esc_html__( 'Oldest - Newest', 'digital-newspaper' ),
                'title-asc' => esc_html__( 'A - Z', 'digital-newspaper' ),
                'title-desc' => esc_html__( 'Z - A', 'digital-newspaper' ),
                'rand-desc' => esc_html__( 'Random', 'digital-newspaper' )
            ),
            'active_callback'   => function( $setting ) {
                if ( $setting->manager->get_setting( 'main_banner_layout' )->value() === 'five' ) {
                    return true;
                }
                return false;
            }
        ));

        // main banner slider setting heading
        $wp_customize->add_setting( 'main_banner_slider_settings_header', array(
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ));
        
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'main_banner_slider_settings_header', array(
                'label'	      => esc_html__( 'Slider Setting', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_main_banner_section',
                'settings'    => 'main_banner_slider_settings_header',
                'type'        => 'section-heading',
            ))
        );

        // Main Banner slider orderby
        $wp_customize->add_setting( 'main_banner_slider_order_by', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_slider_order_by' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control'
        ));
        $wp_customize->add_control( 'main_banner_slider_order_by', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_main_banner_section',
            'label'     => esc_html__( 'Orderby', 'digital-newspaper' ),
            'choices'   => array(
                'date-desc' => esc_html__( 'Newest - Oldest', 'digital-newspaper' ),
                'date-asc' => esc_html__( 'Oldest - Newest', 'digital-newspaper' ),
                'title-asc' => esc_html__( 'A - Z', 'digital-newspaper' ),
                'title-desc' => esc_html__( 'Z - A', 'digital-newspaper' ),
                'rand-desc' => esc_html__( 'Random', 'digital-newspaper' )
            ),
        ));

        // Main Banner slider number of posts
        $wp_customize->add_setting( 'main_banner_slider_numbers', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_slider_numbers' ),
            'sanitize_callback' => 'absint'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Range_Control( $wp_customize, 'main_banner_slider_numbers', array(
                'label'	      => esc_html__( 'Number of posts to display', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_main_banner_section',
                'settings'    => 'main_banner_slider_numbers',
                'input_attrs' => array(
                    'min'   => 1,
                    'max'   => 4,
                    'step'  => 1,
                    'reset' => false
                ),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_post_filter' )->value() == 'category' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // main banner posts filter
        $wp_customize->add_setting( 'main_banner_post_filter', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_post_filter' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Bubble_Control( $wp_customize, 'main_banner_post_filter', array(
                'section'     => 'digital_newspaper_main_banner_section',
                'settings'    => 'main_banner_post_filter',
                'choices' => array(
                    array(
                        'value' => 'category',
                        'label' => esc_html__('By category', 'digital-newspaper' )
                    ),
                    array(
                        'value' => 'title',
                        'label' => esc_html__('By title', 'digital-newspaper' )
                    )
                )
            ))
        );
        
        // Main Banner slider categories
        $wp_customize->add_setting( 'main_banner_slider_categories', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_slider_categories' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Multiselect_Control( $wp_customize, 'main_banner_slider_categories', array(
                'label'     => esc_html__( 'Posts Categories', 'digital-newspaper' ),
                'section'   => 'digital_newspaper_main_banner_section',
                'settings'  => 'main_banner_slider_categories',
                'choices'   => digital_newspaper_get_multicheckbox_categories_simple_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_post_filter' )->value() == 'category' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // main banner date filter
        $wp_customize->add_setting( 'main_banner_date_filter', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_date_filter' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Bubble_Control( $wp_customize, 'main_banner_date_filter', array(
                'section'     => 'digital_newspaper_main_banner_section',
                'settings'    => 'main_banner_date_filter',
                'choices' => digital_newspaper_get_date_filter_choices_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_post_filter' )->value() == 'category' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // main banner posts
        $wp_customize->add_setting( 'main_banner_posts', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_posts' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Posts_Multiselect_Control( $wp_customize, 'main_banner_posts', array(
                'label'     => esc_html__( 'Posts', 'digital-newspaper' ),
                'section'   => 'digital_newspaper_main_banner_section',
                'settings'  => 'main_banner_posts',
                'choices'   => digital_newspaper_get_multicheckbox_posts_simple_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_post_filter' )->value() == 'title' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // main banner related posts option
        $wp_customize->add_setting( 'main_banner_related_posts_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'main_banner_related_posts_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'main_banner_related_posts_option', array(
                'label'	      => esc_html__( 'Show related posts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_main_banner_section',
                'settings'    => 'main_banner_related_posts_option'
            ))
        );
        
        // Main banner six trailing posts setting heading
        $wp_customize->add_setting( 'main_banner_six_trailing_posts_settings_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'main_banner_six_trailing_posts_settings_header', array(
                'label'	      => esc_html__( 'Trailing Posts Setting', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_main_banner_section',
                'settings'    => 'main_banner_six_trailing_posts_settings_header',
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_layout' )->value() === 'six' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Main banner trailing posts layouts
        $wp_customize->add_setting( 'main_banner_six_trailing_posts_layout', array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'main_banner_six_trailing_posts_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
        ));
        $wp_customize->add_control( new Digital_Newspaper_WP_Radio_Image_Control(
            $wp_customize,
            'main_banner_six_trailing_posts_layout',
            array(
                'section'  => 'digital_newspaper_main_banner_section',
                'priority' => 10,
                'choices'  => array(
                    'row' => array(
                        'label' => esc_html__( 'Row Layout', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/main_banner_six_trailing_posts_layout_row.jpg'
                    ),
                    'column' => array(
                        'label' => esc_html__( 'Column Layout', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/main_banner_six_trailing_posts_layout_column.jpg'
                    )
                ),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_layout' )->value() === 'six' ) {
                        return true;
                    }
                    return false;
                }
            )
        ));
        
        // Main banner six trailing posts slider orderby
        $wp_customize->add_setting( 'main_banner_six_trailing_posts_order_by', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_six_trailing_posts_order_by' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control'
        ));
        $wp_customize->add_control( 'main_banner_six_trailing_posts_order_by', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_main_banner_section',
            'label'     => esc_html__( 'Orderby', 'digital-newspaper' ),
            'choices'   => array(
                'date-desc' => esc_html__( 'Newest - Oldest', 'digital-newspaper' ),
                'date-asc' => esc_html__( 'Oldest - Newest', 'digital-newspaper' ),
                'title-asc' => esc_html__( 'A - Z', 'digital-newspaper' ),
                'title-desc' => esc_html__( 'Z - A', 'digital-newspaper' ),
                'rand-desc' => esc_html__( 'Random', 'digital-newspaper' )
            ),
            'active_callback'   => function( $setting ) {
                if ( $setting->manager->get_setting( 'main_banner_layout' )->value() === 'six' ) {
                    return true;
                }
                return false;
            }
        ));

        // main banner posts filter
        $wp_customize->add_setting( 'main_banner_six_trailing_post_filter', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_six_trailing_post_filter' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Bubble_Control( $wp_customize, 'main_banner_six_trailing_post_filter', array(
                'section'     => 'digital_newspaper_main_banner_section',
                'settings'    => 'main_banner_six_trailing_post_filter',
                'choices' => array(
                    array(
                        'value' => 'category',
                        'label' => esc_html__('By category', 'digital-newspaper' )
                    ),
                    array(
                        'value' => 'title',
                        'label' => esc_html__('By title', 'digital-newspaper' )
                    )
                )
            ))
        );

        // Main banner six trailing posts categories
        $wp_customize->add_setting( 'main_banner_six_trailing_posts_categories', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_six_trailing_posts_categories' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Multiselect_Control( $wp_customize, 'main_banner_six_trailing_posts_categories', array(
                'label'     => esc_html__( 'Trailing posts categories', 'digital-newspaper' ),
                'section'   => 'digital_newspaper_main_banner_section',
                'settings'  => 'main_banner_six_trailing_posts_categories',
                'choices'   => digital_newspaper_get_multicheckbox_categories_simple_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_layout' )->value() === 'six' && $setting->manager->get_setting( 'main_banner_six_trailing_post_filter' )->value() == 'category' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // main banner posts
        $wp_customize->add_setting( 'main_banner_six_trailing_posts', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_six_trailing_posts' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Posts_Multiselect_Control( $wp_customize, 'main_banner_six_trailing_posts', array(
                'label'     => esc_html__( 'Posts', 'digital-newspaper' ),
                'section'   => 'digital_newspaper_main_banner_section',
                'settings'  => 'main_banner_six_trailing_posts',
                'choices'   => digital_newspaper_get_multicheckbox_posts_simple_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_layout' )->value() === 'six' && $setting->manager->get_setting( 'main_banner_six_trailing_post_filter' )->value() == 'title' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Main banner grid posts setting heading
        $wp_customize->add_setting( 'main_banner_grid_posts_settings_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'main_banner_grid_posts_settings_header', array(
                'label'	      => esc_html__( 'Grid Posts Setting', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_main_banner_section',
                'settings'    => 'main_banner_grid_posts_settings_header',
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_layout' )->value() === 'five' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Main Banner grid posts title
        $wp_customize->add_setting( 'main_banner_grid_posts_title', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_grid_posts_title' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ));
        
        $wp_customize->add_control( 'main_banner_grid_posts_title', array(
            'type'      => 'text',
            'section'   => 'digital_newspaper_main_banner_section',
            'label'     => esc_html__( 'Popular posts title', 'digital-newspaper' ),
            'active_callback'   => function( $setting ) {
                if ( $setting->manager->get_setting( 'main_banner_layout' )->value() === 'five' ) {
                    return true;
                }
                return false;
            }
        ));

        // Main Banner grid posts categories
        $wp_customize->add_setting( 'main_banner_grid_posts_categories', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_grid_posts_categories' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Multiselect_Control( $wp_customize, 'main_banner_grid_posts_categories', array(
                'label'     => esc_html__( 'Popular posts categories', 'digital-newspaper' ),
                'section'   => 'digital_newspaper_main_banner_section',
                'settings'  => 'main_banner_grid_posts_categories',
                'choices'   => digital_newspaper_get_multicheckbox_categories_simple_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_layout' )->value() === 'five' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Main Banner grid posts slider orderby
        $wp_customize->add_setting( 'main_banner_grid_posts_order_by', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_grid_posts_order_by' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control'
        ));
        $wp_customize->add_control( 'main_banner_grid_posts_order_by', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_main_banner_section',
            'label'     => esc_html__( 'Orderby', 'digital-newspaper' ),
            'choices'   => array(
                'date-desc' => esc_html__( 'Newest - Oldest', 'digital-newspaper' ),
                'date-asc' => esc_html__( 'Oldest - Newest', 'digital-newspaper' ),
                'title-asc' => esc_html__( 'A - Z', 'digital-newspaper' ),
                'title-desc' => esc_html__( 'Z - A', 'digital-newspaper' ),
                'rand-desc' => esc_html__( 'Random', 'digital-newspaper' )
            ),
            'active_callback'   => function( $setting ) {
                if ( $setting->manager->get_setting( 'main_banner_layout' )->value() === 'five' ) {
                    return true;
                }
                return false;
            }
        ));

        // Main Banner grid posts vertical direction
        $wp_customize->add_setting( 'main_banner_grid_posts_direction', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'main_banner_grid_posts_direction' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control'
        ));
        $wp_customize->add_control( 'main_banner_grid_posts_direction', array(
            'type'      => 'select',
            'section'   => 'digital_newspaper_main_banner_section',
            'label'     => esc_html__( 'Slide direction', 'digital-newspaper' ),
            'choices'   => array(
                'true' => esc_html__( 'Vertical', 'digital-newspaper' ),
                'false' => esc_html__( 'Horizontal', 'digital-newspaper' )
            ),
            'active_callback'   => function( $setting ) {
                if ( $setting->manager->get_setting( 'main_banner_layout' )->value() === 'five' ) {
                    return true;
                }
                return false;
            }
        ));

        // banner Width Layouts setting heading
        $wp_customize->add_setting( 'main_banner_width_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'main_banner_width_layout_header', array(
                'label'	      => esc_html__( 'Width Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_main_banner_section',
                'settings'    => 'main_banner_width_layout_header',
                'tab'   => 'design'
            ))
        );

        // banner layout
        $wp_customize->add_setting( 'main_banner_width_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'main_banner_width_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'main_banner_width_layout',
            array(
                'section'  => 'digital_newspaper_main_banner_section',
                'tab'   => 'design',
                'choices'  => array(
                    'global' => array(
                        'label' => esc_html__( 'Global', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/global.jpg'
                    ),
                    'boxed--layout' => array(
                        'label' => esc_html__( 'Boxed', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/boxed_content.jpg'
                    ),
                    'full-width--layout' => array(
                        'label' => esc_html__( 'Full Width', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/full_content.jpg'
                    )
                )
            )
        ));

        // banner section three column order
        $wp_customize->add_setting( 'banner_section_three_column_order', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'banner_section_three_column_order' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_sortable_control'
        ));
        $wp_customize->add_control(
            new Digital_Newspaper_WP_Item_Sortable_Control( $wp_customize, 'banner_section_three_column_order', array(
                'label'         => esc_html__( 'Layout Five Column Re-order', 'digital-newspaper' ),
                'section'       => 'digital_newspaper_main_banner_section',
                'settings'      => 'banner_section_three_column_order',
                'tab'   => 'design',
                'fields'    => array(
                    'list_posts'  => array(
                        'label' => esc_html__( 'List Posts Column', 'digital-newspaper' )
                    ),
                    'banner_slider'  => array(
                        'label' => esc_html__( 'Banner Slider Column', 'digital-newspaper' )
                    ),
                    'grid_slider'  => array(
                        'label' => esc_html__( 'Grid Posts Slider Column', 'digital-newspaper' )
                    )
                )
            ))
        );
    }
    add_action( 'customize_register', 'digital_newspaper_customizer_main_banner_panel', 10 );
endif;

if( !function_exists( 'digital_newspaper_customizer_footer_panel' ) ) :
    /**
     * Register footer options settings
     * 
     */
    function digital_newspaper_customizer_footer_panel( $wp_customize ) {
        /**
         * Theme Footer Section
         * 
         * panel - digital_newspaper_footer_panel
         */
        $wp_customize->add_section( 'digital_newspaper_footer_section', array(
            'title' => esc_html__( 'Theme Footer', 'digital-newspaper' ),
            'priority'  => 74
        ));

        // Footer Option
        $wp_customize->add_setting( 'footer_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'footer_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport'   => 'postMessage'
        ));
    
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Toggle_Control( $wp_customize, 'footer_option', array(
                'label'	      => esc_html__( 'Enable footer section', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_footer_section',
                'settings'    => 'footer_option',
                'tab'   => 'general'
            ))
        );

        /// Add the footer layout control.
        $wp_customize->add_setting( 'footer_widget_column', array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'footer_widget_column' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            'transport'   => 'postMessage'
            )
        );
        $wp_customize->add_control( new Digital_Newspaper_WP_Radio_Image_Control(
            $wp_customize,
            'footer_widget_column',
            array(
                'section'  => 'digital_newspaper_footer_section',
                'tab'   => 'general',
                'choices'  => array(
                    'column-one' => array(
                        'label' => esc_html__( 'Column One', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/footer_column_one.jpg'
                    ),
                    'column-two' => array(
                        'label' => esc_html__( 'Column Two', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/footer_column_two.jpg'
                    ),
                    'column-three' => array(
                        'label' => esc_html__( 'Column Three', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/footer_column_three.jpg'
                    ),
                    'column-four' => array(
                        'label' => esc_html__( 'Column Four', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/footer_column_four.jpg'
                    )
                )
            )
        ));

        // archive pagination type
        $wp_customize->add_setting( 'footer_section_width', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'footer_section_width' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Tab_Control( $wp_customize, 'footer_section_width', array(
                'label'	      => esc_html__( 'Section Width', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_footer_section',
                'settings'    => 'footer_section_width',
                'choices' => array(
                    array(
                        'value' => 'full-width',
                        'label' => esc_html__('Full Width', 'digital-newspaper' )
                    ),
                    array(
                        'value' => 'boxed-width',
                        'label' => esc_html__('Boxed Width', 'digital-newspaper' )
                    )
                )
            ))
        );
        
        // Redirect widgets link
        $wp_customize->add_setting( 'footer_widgets_redirects', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Redirect_Control( $wp_customize, 'footer_widgets_redirects', array(
                'label'	      => esc_html__( 'Widgets', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_footer_section',
                'settings'    => 'footer_widgets_redirects',
                'tab'   => 'general',
                'choices'     => array(
                    'footer-column-one' => array(
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-footer-sidebar--column-1',
                        'label' => esc_html__( 'Manage footer widget one', 'digital-newspaper' )
                    ),
                    'footer-column-two' => array(
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-footer-sidebar--column-2',
                        'label' => esc_html__( 'Manage footer widget two', 'digital-newspaper' )
                    ),
                    'footer-column-three' => array(
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-footer-sidebar--column-3',
                        'label' => esc_html__( 'Manage footer widget three', 'digital-newspaper' )
                    ),
                    'footer-column-four' => array(
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-footer-sidebar--column-4',
                        'label' => esc_html__( 'Manage footer widget four', 'digital-newspaper' )
                    )
                )
            ))
        );
    }
    add_action( 'customize_register', 'digital_newspaper_customizer_footer_panel', 10 );
endif;

if( !function_exists( 'digital_newspaper_customizer_bottom_footer_panel' ) ) :
    /**
     * Register bottom footer options settings
     * 
     */
    function digital_newspaper_customizer_bottom_footer_panel( $wp_customize ) {
        /**
         * Bottom Footer Section
         * 
         * panel - digital_newspaper_footer_panel
         */
        $wp_customize->add_section( 'digital_newspaper_bottom_footer_section', array(
            'title' => esc_html__( 'Bottom Footer', 'digital-newspaper' ),
            'priority'  => 75
        ));

        // section tab
        $wp_customize->add_setting( 'bottom_footer_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Tab_Control( $wp_customize, 'bottom_footer_section_tab', array(
                'section'     => 'digital_newspaper_bottom_footer_section',
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'digital-newspaper' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'digital-newspaper' )
                    )
                )
            ))
        );

        // Bottom Footer Option
        $wp_customize->add_setting( 'bottom_footer_option', array(
            'default'         => DN\digital_newspaper_get_customizer_default( 'bottom_footer_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
    
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Toggle_Control( $wp_customize, 'bottom_footer_option', array(
                'label'	      => esc_html__( 'Enable bottom footer', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_bottom_footer_section',
                'settings'    => 'bottom_footer_option'
            ))
        );

        // Main Banner slider categories option
        $wp_customize->add_setting( 'bottom_footer_social_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'bottom_footer_social_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'bottom_footer_social_option', array(
                'label'	      => esc_html__( 'Show bottom social icons', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_bottom_footer_section',
                'settings'    => 'bottom_footer_social_option'
            ))
        );

        // Main Banner slider categories option
        $wp_customize->add_setting( 'bottom_footer_menu_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'bottom_footer_menu_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'bottom_footer_menu_option', array(
                'label'	      => esc_html__( 'Show bottom footer menu', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_bottom_footer_section',
                'settings'    => 'bottom_footer_menu_option'
            ))
        );

        // copyright text
        $wp_customize->add_setting( 'bottom_footer_site_info', array(
            'default'    => DN\digital_newspaper_get_customizer_default( 'bottom_footer_site_info' ),
            'sanitize_callback' => 'wp_kses_post'
        ));
        $wp_customize->add_control( 'bottom_footer_site_info', array(
                'label'	      => esc_html__( 'Copyright Text', 'digital-newspaper' ),
                'type'  => 'textarea',
                'description' => esc_html__( 'Add %year% to retrieve current year.', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_bottom_footer_section'
            )
        );

        // bottom footer width layout heading
        $wp_customize->add_setting( 'bottom_footer_width_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'bottom_footer_width_layout_header', array(
                'label'	      => esc_html__( 'Width Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_bottom_footer_section',
                'settings'    => 'bottom_footer_width_layout_header',
                'tab'   => 'design'
            ))
        );

        // bottom footer width layout
        $wp_customize->add_setting( 'bottom_footer_width_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'bottom_footer_width_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'bottom_footer_width_layout',
            array(
                'section'  => 'digital_newspaper_bottom_footer_section',
                'tab'   => 'design',
                'choices'  => array(
                    'global' => array(
                        'label' => esc_html__( 'Global', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/global.jpg'
                    ),
                    'boxed--layout' => array(
                        'label' => esc_html__( 'Boxed', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/boxed_content.jpg'
                    ),
                    'full-width--layout' => array(
                        'label' => esc_html__( 'Full Width', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/full_content.jpg'
                    )
                )
            )
        ));
    }
    add_action( 'customize_register', 'digital_newspaper_customizer_bottom_footer_panel', 10 );
endif;

if( !function_exists( 'digital_newspaper_customizer_typography_panel' ) ) :
    /**
     * Register typography options settings
     * 
     */
    function digital_newspaper_customizer_typography_panel( $wp_customize ) {
        // typography options panel settings
        $wp_customize->add_section( 'digital_newspaper_typography_section', array(
            'title' => esc_html__( 'Typography', 'digital-newspaper' ),
            'priority'  => 55
        ));

        // block title typo
        $wp_customize->add_setting( 'site_section_block_title_typo', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'site_section_block_title_typo' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_typo_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Typography_Control( $wp_customize, 'site_section_block_title_typo', array(
                'label'	      => esc_html__( 'Block Title', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_typography_section',
                'settings'    => 'site_section_block_title_typo',
                'fields'    => array( 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration')
            ))
        );

        // post title typo
        $wp_customize->add_setting( 'site_archive_post_title_typo', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'site_archive_post_title_typo' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_typo_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Typography_Control( $wp_customize, 'site_archive_post_title_typo', array(
                'label'	      => esc_html__( 'Post Title', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_typography_section',
                'settings'    => 'site_archive_post_title_typo',
                'fields'    => array( 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration')
            ))
        );
        
        // post meta typo
        $wp_customize->add_setting( 'site_archive_post_meta_typo', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'site_archive_post_meta_typo' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_typo_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Typography_Control( $wp_customize, 'site_archive_post_meta_typo', array(
                'label'	      => esc_html__( 'Post Meta', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_typography_section',
                'settings'    => 'site_archive_post_meta_typo',
                'fields'    => array( 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration')
            ))
        );

        // post content typo
        $wp_customize->add_setting( 'site_archive_post_content_typo', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'site_archive_post_content_typo' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_typo_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Typography_Control( $wp_customize, 'site_archive_post_content_typo', array(
                'label'	      => esc_html__( 'Post Content', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_typography_section',
                'settings'    => 'site_archive_post_content_typo',
                'fields'    => array( 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration')
            ))
        );
    }
    add_action( 'customize_register', 'digital_newspaper_customizer_typography_panel', 10 );
endif;

if( !function_exists( 'digital_newspaper_customizer_front_sections_panel' ) ) :
    /**
     * Register front sections settings
     * 
     */
    function digital_newspaper_customizer_front_sections_panel( $wp_customize ) {
        // Front sections panel
        $wp_customize->add_panel( 'digital_newspaper_front_sections_panel', array(
            'title' => esc_html__( 'Front sections', 'digital-newspaper' ),
            'priority'  => 71
        ));

        // full width content section
        $wp_customize->add_section( 'digital_newspaper_full_width_section', array(
            'title' => esc_html__( 'Full Width', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_front_sections_panel',
            'priority'  => 10
        ));

        // section tab
        $wp_customize->add_setting( 'full_width_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Tab_Control( $wp_customize, 'full_width_section_tab', array(
                'section'     => 'digital_newspaper_full_width_section',
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'digital-newspaper' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'digital-newspaper' )
                    )
                )
            ))
        );

        // full width repeater control
        $wp_customize->add_setting( 'full_width_blocks', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'full_width_blocks' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_repeater_control'
        ));
        
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Block_Repeater_Control( $wp_customize, 'full_width_blocks', array(
                'label'	      => esc_html__( 'Blocks to show in this section', 'digital-newspaper' ),
                'description' => esc_html__( 'Hold bar icon at right of block item and drag vertically to re-order blocks', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_full_width_section',
                'settings'    => 'full_width_blocks'
            ))
        );

        // Width Layouts setting heading
        $wp_customize->add_setting( 'full_width_blocks_width_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'full_width_blocks_width_layout_header', array(
                'label'	      => esc_html__( 'Width Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_full_width_section',
                'settings'    => 'full_width_blocks_width_layout_header',
                'tab'   => 'design'
            ))
        );

        // width layout
        $wp_customize->add_setting( 'full_width_blocks_width_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'full_width_blocks_width_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'full_width_blocks_width_layout',
            array(
                'section'  => 'digital_newspaper_full_width_section',
                'tab'   => 'design',
                'choices'  => array(
                    'global' => array(
                        'label' => esc_html__( 'Global', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/global.jpg'
                    ),
                    'boxed--layout' => array(
                        'label' => esc_html__( 'Boxed', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/boxed_content.jpg'
                    ),
                    'full-width--layout' => array(
                        'label' => esc_html__( 'Full Width', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/full_content.jpg'
                    )
                )
            )
        ));

        // Left content -right sidebar section
        $wp_customize->add_section( 'digital_newspaper_leftc_rights_section', array(
            'title' => esc_html__( 'Left Content  - Right Sidebar', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_front_sections_panel',
            'priority'  => 10
        ));

        // section tab
        $wp_customize->add_setting( 'leftc_rights_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Tab_Control( $wp_customize, 'leftc_rights_section_tab', array(
                'section'     => 'digital_newspaper_leftc_rights_section',
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'digital-newspaper' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'digital-newspaper' )
                    )
                )
            ))
        );

        // redirect to manage sidebar
        $wp_customize->add_setting( 'leftc_rights_section_sidebar_redirect', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
        ));
    
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Redirect_Control( $wp_customize, 'leftc_rights_section_sidebar_redirect', array(
                'label'	      => esc_html__( 'Widgets', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_leftc_rights_section',
                'settings'    => 'leftc_rights_section_sidebar_redirect',
                'tab'   => 'general',
                'choices'     => array(
                    'footer-column-one' => array(
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-front-right-sidebar',
                        'label' => esc_html__( 'Manage right sidebar', 'digital-newspaper' )
                    )
                )
            ))
        );

        // Block Repeater control
        $wp_customize->add_setting( 'leftc_rights_blocks', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_repeater_control',
            'default'   => DN\digital_newspaper_get_customizer_default( 'leftc_rights_blocks' )
        ));
        
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Block_Repeater_Control( $wp_customize, 'leftc_rights_blocks', array(
                'label'	      => esc_html__( 'Blocks to show in this section', 'digital-newspaper' ),
                'description' => esc_html__( 'Hold bar icon at right of block item and drag vertically to re-order blocks', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_leftc_rights_section',
                'settings'    => 'leftc_rights_blocks'
            ))
        );

        // Width Layouts setting heading
        $wp_customize->add_setting( 'leftc_rights_blocks_width_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'leftc_rights_blocks_width_layout_header', array(
                'label'	      => esc_html__( 'Width Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_leftc_rights_section',
                'settings'    => 'leftc_rights_blocks_width_layout_header',
                'tab'   => 'design'
            ))
        );

        // width layout
        $wp_customize->add_setting( 'leftc_rights_blocks_width_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'leftc_rights_blocks_width_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'leftc_rights_blocks_width_layout',
            array(
                'section'  => 'digital_newspaper_leftc_rights_section',
                'tab'   => 'design',
                'choices'  => array(
                    'global' => array(
                        'label' => esc_html__( 'Global', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/global.jpg'
                    ),
                    'boxed--layout' => array(
                        'label' => esc_html__( 'Boxed', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/boxed_content.jpg'
                    ),
                    'full-width--layout' => array(
                        'label' => esc_html__( 'Full Width', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/full_content.jpg'
                    )
                )
            )
        ));
        
        // Left sidebar - Right content section
        $wp_customize->add_section( 'digital_newspaper_lefts_rightc_section', array(
            'title' => esc_html__( 'Left Sidebar - Right Content', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_front_sections_panel',
            'priority'  => 10
        ));

        // section tab
        $wp_customize->add_setting( 'lefts_rightc_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Tab_Control( $wp_customize, 'lefts_rightc_section_tab', array(
                'section'     => 'digital_newspaper_lefts_rightc_section',
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'digital-newspaper' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'digital-newspaper' )
                    )
                )
            ))
        );

        // redirect to manage sidebar
        $wp_customize->add_setting( 'lefts_rightc_section_sidebar_redirect', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Redirect_Control( $wp_customize, 'lefts_rightc_section_sidebar_redirect', array(
                'label'	      => esc_html__( 'Widgets', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_lefts_rightc_section',
                'settings'    => 'lefts_rightc_section_sidebar_redirect',
                'tab'   => 'general',
                'choices'     => array(
                    'footer-column-one' => array(
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-front-left-sidebar',
                        'label' => esc_html__( 'Manage left sidebar', 'digital-newspaper' )
                    )
                )
            ))
        );

        // Block Repeater control
        $wp_customize->add_setting( 'lefts_rightc_blocks', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_repeater_control',
            'default'   => DN\digital_newspaper_get_customizer_default( 'lefts_rightc_blocks' )
        ));
        
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Block_Repeater_Control( $wp_customize, 'lefts_rightc_blocks', array(
                'label'	      => esc_html__( 'Blocks to show in this section', 'digital-newspaper' ),
                'description' => esc_html__( 'Hold bar icon at right of block item and drag vertically to re-order blocks', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_lefts_rightc_section',
                'settings'    => 'lefts_rightc_blocks'
            ))
        );

        // Width Layouts setting heading
        $wp_customize->add_setting( 'lefts_rightc_blocks_width_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'lefts_rightc_blocks_width_layout_header', array(
                'label'	      => esc_html__( 'Width Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_lefts_rightc_section',
                'settings'    => 'lefts_rightc_blocks_width_layout_header',
                'tab'   => 'design'
            ))
        );

        // width layout
        $wp_customize->add_setting( 'lefts_rightc_blocks_width_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'lefts_rightc_blocks_width_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'lefts_rightc_blocks_width_layout',
            array(
                'section'  => 'digital_newspaper_lefts_rightc_section',
                'tab'   => 'design',
                'choices'  => array(
                    'global' => array(
                        'label' => esc_html__( 'Global', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/global.jpg'
                    ),
                    'boxed--layout' => array(
                        'label' => esc_html__( 'Boxed', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/boxed_content.jpg'
                    ),
                    'full-width--layout' => array(
                        'label' => esc_html__( 'Full Width', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/full_content.jpg'
                    )
                )
            )
        ));
        
        // Bottom Full Width content section
        $wp_customize->add_section( 'digital_newspaper_bottom_full_width_section', array(
            'title' => esc_html__( 'Bottom Full Width', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_front_sections_panel',
            'priority'  => 50
        ));

        // section tab
        $wp_customize->add_setting( 'bottom_full_width_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Tab_Control( $wp_customize, 'bottom_full_width_section_tab', array(
                'section'     => 'digital_newspaper_bottom_full_width_section',
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'digital-newspaper' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'digital-newspaper' )
                    )
                )
            ))
        );

        // bottom full width blocks control
        $wp_customize->add_setting( 'bottom_full_width_blocks', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_repeater_control',
            'default'   => DN\digital_newspaper_get_customizer_default( 'bottom_full_width_blocks' )
        ));
        
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Block_Repeater_Control( $wp_customize, 'bottom_full_width_blocks', array(
                'label'	      => esc_html__( 'Blocks to show in this section', 'digital-newspaper' ),
                'description' => esc_html__( 'Hold bar icon at right of block item and drag vertically to re-order blocks', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_bottom_full_width_section',
                'settings'    => 'bottom_full_width_blocks'
            ))
        );

        // Width Layouts setting heading
        $wp_customize->add_setting( 'bottom_full_width_blocks_width_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'bottom_full_width_blocks_width_layout_header', array(
                'label'	      => esc_html__( 'Width Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_bottom_full_width_section',
                'settings'    => 'bottom_full_width_blocks_width_layout_header',
                'tab'   => 'design'
            ))
        );

        // width layout
        $wp_customize->add_setting( 'bottom_full_width_blocks_width_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'bottom_full_width_blocks_width_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'bottom_full_width_blocks_width_layout',
            array(
                'section'  => 'digital_newspaper_bottom_full_width_section',
                'tab'   => 'design',
                'choices'  => array(
                    'global' => array(
                        'label' => esc_html__( 'Global', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/global.jpg'
                    ),
                    'boxed--layout' => array(
                        'label' => esc_html__( 'Boxed', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/boxed_content.jpg'
                    ),
                    'full-width--layout' => array(
                        'label' => esc_html__( 'Full Width', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/full_content.jpg'
                    )
                )
            )
        ));

        // front sections reorder section
        $wp_customize->add_section( 'digital_newspaper_front_sections_reorder_section', array(
            'title' => esc_html__( 'Reorder sections', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_front_sections_panel',
            'priority'  => 60
        ));

        /**
         * Frontpage sections options
         * 
         * @package Digital Newspaper
         * @since 1.0.0
         */
        $wp_customize->add_setting( 'homepage_content_order', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'homepage_content_order' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_sortable_control'
        ));
        $wp_customize->add_control(
            new Digital_Newspaper_WP_Item_Sortable_Control( $wp_customize, 'homepage_content_order', array(
                'label'         => esc_html__( 'Section Re-order', 'digital-newspaper' ),
                'description'   => esc_html__( 'Hold item and drag vertically to re-order the items', 'digital-newspaper' ),
                'section'       => 'digital_newspaper_front_sections_reorder_section',
                'settings'      => 'homepage_content_order',
                'fields'    => array(
                    'full_width_section'  => array(
                        'label' => esc_html__( 'Full width Section', 'digital-newspaper' )
                    ),
                    'leftc_rights_section'  => array(
                        'label' => esc_html__( 'Left Content - Right Sidebar', 'digital-newspaper' )
                    ),
                    'lefts_rightc_section'  => array(
                        'label' => esc_html__( 'Left Sidebar - Right Content', 'digital-newspaper' )
                    ),
                    'bottom_full_width_section'  => array(
                        'label' => esc_html__( 'Bottom Full width Section', 'digital-newspaper' )
                    ),
                    'latest_posts'  => array(
                        'label' => esc_html__( 'Latest Posts / Page Content', 'digital-newspaper' )
                    )
                )
            ))
        );
    }
    add_action( 'customize_register', 'digital_newspaper_customizer_front_sections_panel', 10 );
endif;

if( !function_exists( 'digital_newspaper_customizer_blog_post_archive_panel' ) ) :
    /**
     * Register global options settings
     * 
     */
    function digital_newspaper_customizer_blog_post_archive_panel( $wp_customize ) {
        // Blog/Archive/Single panel
        $wp_customize->add_panel( 'digital_newspaper_blog_post_archive_panel', array(
            'title' => esc_html__( 'Blog / Archive / Single', 'digital-newspaper' ),
            'priority'  => 72
        ));
        
        // blog / archive section
        $wp_customize->add_section( 'digital_newspaper_blog_archive_section', array(
            'title' => esc_html__( 'Blog / Archive', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_blog_post_archive_panel',
            'priority'  => 10
        ));

        // archive tab section tab
        $wp_customize->add_setting( 'archive_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Tab_Control( $wp_customize, 'archive_section_tab', array(
                'section'     => 'digital_newspaper_blog_archive_section',
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'digital-newspaper' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'digital-newspaper' )
                    )
                )
            ))
        );

        // archive post layouts
        $wp_customize->add_setting( 'archive_page_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'archive_page_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'archive_page_layout',
            array(
                'section'  => 'digital_newspaper_blog_archive_section',
                'priority' => 10,
                'choices'  => array(
                    'one' => array(
                        'label' => esc_html__( 'Layout One', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/archive_one.jpg'
                    ),
                    'two' => array(
                        'label' => esc_html__( 'Layout Two', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/archive_two.jpg'
                    )
                )
            )
        ));

        // archive pagination type
        $wp_customize->add_setting( 'archive_pagination_type', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'archive_pagination_type' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Tab_Control( $wp_customize, 'archive_pagination_type', array(
                'label'	      => esc_html__( 'Pagination Type', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_blog_archive_section',
                'settings'    => 'archive_pagination_type',
                'choices' => array(
                    array(
                        'value' => 'default',
                        'label' => esc_html__('Default', 'digital-newspaper' )
                    ),
                    array(
                        'value' => 'number',
                        'label' => esc_html__('Number', 'digital-newspaper' )
                    )
                )
            ))
        );

        // Redirect continue reading button
        $wp_customize->add_setting( 'archive_button_redirect', array(
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Redirect_Control( $wp_customize, 'archive_button_redirect', array(
                'section'     => 'digital_newspaper_blog_archive_section',
                'settings'    => 'archive_button_redirect',
                'choices'     => array(
                    'header-social-icons' => array(
                        'type'  => 'section',
                        'id'    => 'digital_newspaper_buttons_section',
                        'label' => esc_html__( 'Edit button styles', 'digital-newspaper' )
                    )
                )
            ))
        );

        // Width Layouts setting heading
        $wp_customize->add_setting( 'archive_width_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'archive_width_layout_header', array(
                'label'	      => esc_html__( 'Width Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_blog_archive_section',
                'settings'    => 'archive_width_layout_header',
                'tab'   => 'design'
            ))
        );

        // width layout
        $wp_customize->add_setting( 'archive_width_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'archive_width_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'archive_width_layout',
            array(
                'section'  => 'digital_newspaper_blog_archive_section',
                'tab'   => 'design',
                'choices'  => array(
                    'global' => array(
                        'label' => esc_html__( 'Global', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/global.jpg'
                    ),
                    'boxed--layout' => array(
                        'label' => esc_html__( 'Boxed', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/boxed_content.jpg'
                    ),
                    'full-width--layout' => array(
                        'label' => esc_html__( 'Full Width', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/full_content.jpg'
                    )
                )
            )
        ));

        //  single post section
        $wp_customize->add_section( 'digital_newspaper_single_post_section', array(
            'title' => esc_html__( 'Single Post', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_blog_post_archive_panel',
            'priority'  => 20
        ));

        // single tab section tab
        $wp_customize->add_setting( 'single_post_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Tab_Control( $wp_customize, 'single_post_section_tab', array(
                'section'     => 'digital_newspaper_single_post_section',
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'digital-newspaper' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'digital-newspaper' )
                    )
                )
            ))
        );
        
        // single post related news heading
        $wp_customize->add_setting( 'single_post_related_posts_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'single_post_related_posts_header', array(
                'label'	      => esc_html__( 'Related News', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_single_post_section',
                'settings'    => 'single_post_related_posts_header'
            ))
        );

        // related news option
        $wp_customize->add_setting( 'single_post_related_posts_option', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'single_post_related_posts_option' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Simple_Toggle_Control( $wp_customize, 'single_post_related_posts_option', array(
                'label'	      => esc_html__( 'Show related news', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_single_post_section',
                'settings'    => 'single_post_related_posts_option'
            ))
        );

        // related news title
        $wp_customize->add_setting( 'single_post_related_posts_title', array(
            'default' => DN\digital_newspaper_get_customizer_default( 'single_post_related_posts_title' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 'single_post_related_posts_title', array(
            'type'      => 'text',
            'section'   => 'digital_newspaper_single_post_section',
            'label'     => esc_html__( 'Related news title', 'digital-newspaper' )
        ));
        // Width Layouts setting heading
        $wp_customize->add_setting( 'single_post_width_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'single_post_width_layout_header', array(
                'label'	      => esc_html__( 'Width Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_single_post_section',
                'settings'    => 'single_post_width_layout_header',
                'tab'   => 'design'
            ))
        );

        // width layout
        $wp_customize->add_setting( 'single_post_width_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'single_post_width_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'single_post_width_layout',
            array(
                'section'  => 'digital_newspaper_single_post_section',
                'tab'   => 'design',
                'choices'  => array(
                    'global' => array(
                        'label' => esc_html__( 'Global', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/global.jpg'
                    ),
                    'boxed--layout' => array(
                        'label' => esc_html__( 'Boxed', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/boxed_content.jpg'
                    ),
                    'full-width--layout' => array(
                        'label' => esc_html__( 'Full Width', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/full_content.jpg'
                    )
                )
            )
        ));

        // single post title typo
        $wp_customize->add_setting( 'single_post_title_typo', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'single_post_title_typo' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_typo_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Typography_Control( $wp_customize, 'single_post_title_typo', array(
                'label'	      => esc_html__( 'Post Title', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_single_post_section',
                'settings'    => 'single_post_title_typo',
                'fields'    => array( 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration'),
                'tab'   => 'design'
            ))
        );

        // single post meta typo
        $wp_customize->add_setting( 'single_post_meta_typo', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'single_post_meta_typo' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_typo_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Typography_Control( $wp_customize, 'single_post_meta_typo', array(
                'label'	      => esc_html__( 'Post Meta', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_single_post_section',
                'settings'    => 'single_post_meta_typo',
                'fields'    => array( 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration'),
                'tab'   => 'design'
            ))
        );
        
        // single post content typo
        $wp_customize->add_setting( 'single_post_content_typo', array(
            'default'   => DN\digital_newspaper_get_customizer_default( 'single_post_content_typo' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_typo_control',
            'transport' => 'postMessage',
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Typography_Control( $wp_customize, 'single_post_content_typo', array(
                'label'	      => esc_html__( 'Post Content', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_single_post_section',
                'settings'    => 'single_post_content_typo',
                'fields'    => array( 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration'),
                'tab'   => 'design'
            ))
        );
    }
    add_action( 'customize_register', 'digital_newspaper_customizer_blog_post_archive_panel', 10 );
endif;

if( !function_exists( 'digital_newspaper_customizer_page_panel' ) ) :
    /**
     * Register global options settings
     * 
     */
    function digital_newspaper_customizer_page_panel( $wp_customize ) {
        // page panel
        $wp_customize->add_panel( 'digital_newspaper_page_panel', array(
            'title' => esc_html__( 'Pages', 'digital-newspaper' ),
            'priority'  => 73
        ));

        // 404 section
        $wp_customize->add_section( 'digital_newspaper_page_section', array(
            'title' => esc_html__( 'Page', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_page_panel',
            'priority'  => 10
        ));

        // Width Layouts setting heading
        $wp_customize->add_setting( 'single_page_width_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'single_page_width_layout_header', array(
                'label'	      => esc_html__( 'Width Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_page_section',
                'settings'    => 'single_page_width_layout_header'
            ))
        );

        // width layout
        $wp_customize->add_setting( 'single_page_width_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'single_page_width_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'single_page_width_layout',
            array(
                'section'  => 'digital_newspaper_page_section',
                'choices'  => array(
                    'global' => array(
                        'label' => esc_html__( 'Global', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/global.jpg'
                    ),
                    'boxed--layout' => array(
                        'label' => esc_html__( 'Boxed', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/boxed_content.jpg'
                    ),
                    'full-width--layout' => array(
                        'label' => esc_html__( 'Full Width', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/full_content.jpg'
                    )
                )
            )
        ));

        // 404 section
        $wp_customize->add_section( 'digital_newspaper_404_section', array(
            'title' => esc_html__( '404', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_page_panel',
            'priority'  => 20
        ));

        // Width Layouts setting heading
        $wp_customize->add_setting( 'error_page_width_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'error_page_width_layout_header', array(
                'label'	      => esc_html__( 'Width Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_404_section',
                'settings'    => 'error_page_width_layout_header'
            ))
        );

        // width layout
        $wp_customize->add_setting( 'error_page_width_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'error_page_width_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'error_page_width_layout',
            array(
                'section'  => 'digital_newspaper_404_section',
                'choices'  => array(
                    'global' => array(
                        'label' => esc_html__( 'Global', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/global.jpg'
                    ),
                    'boxed--layout' => array(
                        'label' => esc_html__( 'Boxed', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/boxed_content.jpg'
                    ),
                    'full-width--layout' => array(
                        'label' => esc_html__( 'Full Width', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/full_content.jpg'
                    )
                )
            )
        ));

        // search page section
        $wp_customize->add_section( 'digital_newspaper_search_page_section', array(
            'title' => esc_html__( 'Search Page', 'digital-newspaper' ),
            'panel' => 'digital_newspaper_page_panel',
            'priority'  => 30
        ));

        // Width Layouts setting heading
        $wp_customize->add_setting( 'search_page_width_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Section_Heading_Control( $wp_customize, 'search_page_width_layout_header', array(
                'label'	      => esc_html__( 'Width Layouts', 'digital-newspaper' ),
                'section'     => 'digital_newspaper_search_page_section',
                'settings'    => 'search_page_width_layout_header'
            ))
        );

        // width layout
        $wp_customize->add_setting( 'search_page_width_layout',
            array(
            'default'           => DN\digital_newspaper_get_customizer_default( 'search_page_width_layout' ),
            'sanitize_callback' => 'digital_newspaper_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Digital_Newspaper_WP_Radio_Image_Control( $wp_customize, 'search_page_width_layout',
            array(
                'section'  => 'digital_newspaper_search_page_section',
                'choices'  => array(
                    'global' => array(
                        'label' => esc_html__( 'Global', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/global.jpg'
                    ),
                    'boxed--layout' => array(
                        'label' => esc_html__( 'Boxed', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/boxed_content.jpg'
                    ),
                    'full-width--layout' => array(
                        'label' => esc_html__( 'Full Width', 'digital-newspaper' ),
                        'url'   => '%s/assets/images/customizer/full_content.jpg'
                    )
                )
            )
        ));
    }
    add_action( 'customize_register', 'digital_newspaper_customizer_page_panel', 10 );
endif;

// extract to the customizer js
$digitalNewspaperAddAction = function() {
    $action_prefix = "wp_ajax_" . "digital_newspaper_";
    // retrieve posts with search key
    add_action( $action_prefix . 'get_multicheckbox_posts_simple_array', function() {
        check_ajax_referer( 'digital-newspaper-customizer-controls-live-nonce', 'security' );
        $searchKey = isset($_POST['search']) ? sanitize_text_field(wp_unslash($_POST['search'])): '';
        $posts_list = get_posts(array('numberposts'=>-1, 's'=>esc_html($searchKey)));
        foreach( $posts_list as $postItem ) :
            $posts_array[] = array( 
                'value'	=> esc_html( $postItem->post_name ),
                'label'	=> esc_html(str_replace(array('\'', '"'), '', $postItem->post_title))
            );
        endforeach;
        wp_send_json_success($posts_array);
        wp_die();
    });
    // site border top
    add_action( $action_prefix . 'customizer_site_block_border_top', function() {
        check_ajax_referer( 'digital-newspaper-customizer-nonce', 'security' );
        ob_start();
            digital_newspaper_assign_var( "--theme-block-top-border-color", "website_block_border_top_color" );
        $site_block_border_top = ob_get_clean();
        echo apply_filters( 'site_block_border_top', wp_strip_all_tags($site_block_border_top) );
        wp_die();
    });
    // site logo styles
    add_action( $action_prefix . 'site_logo_styles', function() {
        check_ajax_referer( 'digital-newspaper-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
            digital_newspaper_site_logo_width_fnc("body .site-branding img.custom-logo", 'digital_newspaper_site_logo_width');
		$site_logo_styles = ob_get_clean();
		echo apply_filters( 'digital_newspaper_site_logo_styles', wp_strip_all_tags($site_logo_styles) );
		wp_die();
	});
    // site title typo
    add_action( $action_prefix . 'site_title_typo', function() {
        check_ajax_referer( 'digital-newspaper-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
            digital_newspaper_get_typo_style( "--site-title", 'site_title_typo' );
		$site_title_typo = ob_get_clean();
		echo apply_filters( 'digital_newspaper_site_title_typo', wp_strip_all_tags($site_title_typo) );
		wp_die();
	});
    // top header styles
    add_action( $action_prefix . 'top_header_styles', function() {
        check_ajax_referer( 'digital-newspaper-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
            digital_newspaper_get_background_style('.digital_newspaper_main_body .site-header.layout--default .top-header','top_header_background_color_group');
		$top_header_styles = ob_get_clean();
		echo apply_filters( 'digital_newspaper_top_header_styles', wp_strip_all_tags($top_header_styles) );
		wp_die();
	});
    // header styles
    add_action( $action_prefix . 'header_styles', function() {
        check_ajax_referer( 'digital-newspaper-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
            digital_newspaper_get_background_style('body .site-header.layout--default .site-branding-section', 'header_background_color_group');
			digital_newspaper_header_padding('--header-padding', 'header_vertical_padding');
		$header_styles = ob_get_clean();
		echo apply_filters( 'digital_newspaper_header_styles', wp_strip_all_tags($header_styles) );
		wp_die();
	});
    // header menu typo
    add_action( $action_prefix . 'header_menu_typo', function() {
        check_ajax_referer( 'digital-newspaper-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
            digital_newspaper_get_typo_style("--menu", 'header_menu_typo');
            digital_newspaper_get_typo_style("--submenu", 'header_sub_menu_typo');
        $digital_newspaper_header_menu_typo = ob_get_clean();
		echo apply_filters( 'digital_newspaper_header_menu_typo', wp_strip_all_tags($digital_newspaper_header_menu_typo) );
		wp_die();
	});
    // single typo styles
    add_action( $action_prefix . 'single_typo__styles', function() {
        check_ajax_referer( 'digital-newspaper-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
			digital_newspaper_get_typo_style("--single-title",'single_post_title_typo');
			digital_newspaper_get_typo_style("--single-meta", 'single_post_meta_typo');
			digital_newspaper_get_typo_style("--single-content", 'single_post_content_typo');
        $digital_newspaper_single_typo__styles = ob_get_clean();
		echo apply_filters( 'digital_newspaper_single_typo__styles', wp_strip_all_tags($digital_newspaper_single_typo__styles) );
		wp_die();
	});
    // site archive typo styles
    add_action( $action_prefix . 'site_archive_typo__styles', function() {
        check_ajax_referer( 'digital-newspaper-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
			digital_newspaper_get_typo_style( "--block-title", 'site_section_block_title_typo');
			digital_newspaper_get_typo_style("--post-title",'site_archive_post_title_typo');
			digital_newspaper_get_typo_style("--meta", 'site_archive_post_meta_typo');
			digital_newspaper_get_typo_style("--content", 'site_archive_post_content_typo');
        $digital_newspaper_site_archive_typo__styles = ob_get_clean();
		echo apply_filters( 'digital_newspaper_site_archive_typo__styles', wp_strip_all_tags($digital_newspaper_site_archive_typo__styles) );
		wp_die();
	});
    // typography fonts url
    add_action( $action_prefix . 'typography_fonts_url', function() {
        check_ajax_referer( 'digital-newspaper-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
			echo esc_url(digital_newspaper_typo_fonts_url());
        $digital_newspaper_typography_fonts_url = ob_get_clean();
		echo apply_filters( 'digital_newspaper_typography_fonts_url', esc_url($digital_newspaper_typography_fonts_url) );
		wp_die();
	});
};
$digitalNewspaperAddAction();

// Imports previous customizer settings on exists
add_action( "wp_ajax_digital_newspaper__import_custmomizer_setting", function() {
    check_ajax_referer( 'digital-newspaper-customizer-controls-nonce', 'security' );
    $n_setting = wp_get_theme()->get_stylesheet();
    $old_setting = get_option( 'theme_mods_digitalNewspaper' );
    if( ! $old_setting ) return;
    $current_setting = get_option( 'theme_mods_' . $n_setting );
    if( update_option( 'theme_mods_' .$n_setting. '-old', $current_setting ) ) {
        if( update_option( 'theme_mods_' . $n_setting, $old_setting ) ) {
            return true;
        }
    }
    return;
    wp_die();
});

add_action( 'wp_ajax_digital_newspaper_customizer_reset_to_default', function () {
    check_ajax_referer( 'digital-newspaper-customizer-controls-nonce', 'security' );
    /**
     * Filter the settings that will be removed.
     *
     * @param array $settings Theme modifications.
     * @return array
     * @since 1.1.0
     */
    remove_theme_mods();
    wp_send_json_success();
});