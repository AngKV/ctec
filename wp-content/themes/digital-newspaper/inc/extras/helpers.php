<?php
/**
 * Includes the helper functions and hooks the theme. 
 * 
 * @package Digital Newspaper
 * @since 1.0.0
 */
 use Digital_Newspaper\CustomizerDefault as DN;

if( !function_exists( 'digital_newspaper_advertisement_block_html' ) ) :
    /**
     * Calls advertisement block
     * 
     * @since 1.0.0
     */
    function digital_newspaper_advertisement_block_html($options,$echo) {
        $media = $options->media;
        if( ! isset( $media->media_id ) ) return;
        ?>
        <div <?php if( isset( $options->blockId ) && !empty($options->blockId) ) echo 'id="' .esc_attr( $options->blockId ). '"'; ?> class="digital-newspaper-advertisement-block is-large">
        <?php
            if( $echo ) {
                if( isset( $options->title ) && $options->title ) echo '<h2 class="digital-newspaper-block-title">' .esc_html( $options->title ). '</h2>';
                if( $media->media_id != 0 ) {
                ?>
                    <figure class="inner-ad-block">
                        <a href="<?php echo esc_url( $options->url ); ?>" target="<?php echo esc_attr( $options->targetAttr ); ?>" rel="<?php echo esc_attr( $options->relAttr ); ?>"><img src="<?php echo esc_url( wp_get_attachment_url( $media->media_id ) ); ?>"></a>
                    </figure>
                <?php
                }
            }
        ?>
        </div>
    <?php
    }
 endif;

 if( !function_exists( 'digital_newspaper_shortcode_block_html' ) ) :
    /**
     * Calls shortcode block
     * 
     * @since 1.0.0
     */
    function digital_newspaper_shortcode_block_html($options,$echo) {
        $shortcode = $options->shortcode;
        if( ! $shortcode ) return;
        ?>
        <div <?php if( isset( $options->blockId ) && !empty($options->blockId) ) echo 'id="' .esc_attr( $options->blockId ). '"'; ?> class="digital-newspaper-shortcode-block is-large">
            <?php
                if( $echo ) {
                    echo do_shortcode( $shortcode );
                }
            ?>
        </div>
        <?php
    }
 endif;

 if( !function_exists( 'digital_newspaper_top_header_html' ) ) :
    /**
     * Calls top header hooks
     * 
     * @since 1.0.0
     */
    function digital_newspaper_top_header_html() {
        if( ! DN\digital_newspaper_get_customizer_option( 'top_header_option' ) ) return;
        require get_template_directory() . '/inc/hooks/top-header-hooks.php'; // top header hooks.
        echo '<div class="top-header">';
            echo '<div class="digital-newspaper-container">';
                echo '<div class="row">';
                /**
                 * hook - digital_newspaper_top_header_hook
                 * 
                 * @hooked - digital_newspaper_top_header_ticker_news_part - 10
                 * @hooked - digital_newspaper_top_header_social_part - 20
                 */
                if( has_action( 'digital_newspaper_top_header_hook' ) ) do_action( 'digital_newspaper_top_header_hook' );
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
endif;

if( !function_exists( 'digital_newspaper_header_html' ) ) :
    /**
     * Calls header hooks
     * 
     * @since 1.0.0
     */
    function digital_newspaper_header_html() {
        require get_template_directory() . '/inc/hooks/header-hooks.php'; // top header hooks.
        ?>
        <div class="main-header">
            <div class="site-branding-section">
                <div class="digital-newspaper-container">
                    <div class="row">
                        <?php
                            /**
                             * hook - digital_newspaper_header__site_branding_section_hook
                             * 
                             * @hooked - digital_newspaper_header_menu_part - 10
                             * @hooked - digital_newspaper_header_ads_banner_part - 20
                             */
                            if( has_action( 'digital_newspaper_header__site_branding_section_hook' ) ) do_action( 'digital_newspaper_header__site_branding_section_hook' );
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
endif;

if( !function_exists( 'digital_newspaper_after_header_html' ) ) :
    /**
     * Calls after header hooks
     * 
     * @since 1.0.0
     */
    function digital_newspaper_after_header_html() {
        $ticker_news_width_layout = digial_newspaper_get_section_width_layout_val('ticker_news_width_layout');
        $classes[] = esc_attr('ticker-news-section--' . $ticker_news_width_layout);

        ?>
        <div class="after-header header-layout-banner-two ticker-news-section--<?php echo esc_attr($ticker_news_width_layout); ?>">
            <div class="digital-newspaper-container">
                <div class="row">
                    <?php
                        /**
                         * hook - digital_newspaper_after_header_hook
                         * 
                         * @hooked - digital_newspaper_ticker_news_part - 10
                         */
                        if( has_action( 'digital_newspaper_after_header_hook' ) ) do_action( 'digital_newspaper_after_header_hook' );
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
endif;

require get_template_directory() . '/inc/hooks/footer-hooks.php'; // footer hooks.
if( !function_exists( 'digital_newspaper_footer_sections_html' ) ) :
    /**
     * Calls footer hooks
     * 
     * @since 1.0.0
     */
    function digital_newspaper_footer_sections_html() {
        if( ! DN\digital_newspaper_get_customizer_option( 'footer_option' ) ) return;
        $footer_section_width = DN\digital_newspaper_get_customizer_option( 'footer_section_width' );
        ?>
        <div class="main-footer <?php echo esc_attr( $footer_section_width ); ?>">
            <div class="footer-inner <?php if( $footer_section_width == 'boxed-width' ) { echo esc_attr( 'digital-newspaper-container' ); } else { echo esc_attr( 'digital-newspaper-container-fluid' ); } ?>">
                <div class="row">
                    <?php
                        /**
                         * hook - digital_newspaper_footer_hook
                         * 
                         * @hooked - digital_newspaper_footer_widgets_area_part - 10
                         */
                        if( has_action( 'digital_newspaper_footer_hook' ) ) do_action( 'digital_newspaper_footer_hook' );
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
endif;

if( !function_exists( 'digital_newspaper_bottom_footer_sections_html' ) ) :
    /**
     * Calls bottom footer hooks
     * 
     * @since 1.0.0
     */
    function digital_newspaper_bottom_footer_sections_html() {
        if( ! DN\digital_newspaper_get_customizer_option( 'bottom_footer_option' ) ) return;
        require get_template_directory() . '/inc/hooks/bottom-footer-hooks.php'; // footer hooks.
        $bottom_footer_width_layout = digial_newspaper_get_section_width_layout_val('bottom_footer_width_layout');
        ?>
        <div class="bottom-footer <?php echo esc_attr( 'width-' . $bottom_footer_width_layout ); ?>">
            <div class="digital-newspaper-container">
                <div class="row">
                    <?php
                        /**
                         * hook - digital_newspaper_bottom_footer_sections_html
                         * 
                         * @hooked - bottom_footer_social_option - 10
                         * @hooked - digital_newspaper_bottom_footer_menu_part - 20
                         * @hooked - digital_newspaper_bottom_footer_copyright_part - 3020
                         */
                        if( has_action( 'digital_newspaper_botttom_footer_hook' ) ) do_action( 'digital_newspaper_botttom_footer_hook' );
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
endif;
require get_template_directory() . '/inc/hooks/inner-hooks.php'; // inner hooks.
require get_template_directory() . '/inc/hooks/frontpage-sections-hooks.php'; // frontpage sections hooks.

if ( ! function_exists( 'digital_newspaper_breadcrumb_trail' ) ) :
    /**
     * Theme default breadcrumb function.
     *
     * @since 1.0.0
     */
    function digital_newspaper_breadcrumb_trail() {
        if ( ! function_exists( 'breadcrumb_trail' ) ) {
            // load class file
            require_once get_template_directory() . '/inc/breadcrumb-trail/breadcrumb-trail.php';
        }

        // arguments variable
        $breadcrumb_args = array(
            'container' => 'div',
            'show_browse' => false,
        );
        breadcrumb_trail( $breadcrumb_args );
    }
    add_action( 'digital_newspaper_breadcrumb_trail_hook', 'digital_newspaper_breadcrumb_trail' );
endif;

if( ! function_exists( 'digital_newspaper_breadcrumb_html' ) ) :
    /**
     * Theme breadcrumb
     *
     * @package Digital Newspaper
     * @since 1.0.0
     */
    function digital_newspaper_breadcrumb_html() {
        $ticker_news_width_layout = digial_newspaper_get_section_width_layout_val('ticker_news_width_layout');
        $classes[] = esc_attr('ticker-news-section--' . $ticker_news_width_layout);
        
        $site_breadcrumb_option = DN\digital_newspaper_get_customizer_option( 'site_breadcrumb_option' );
        if ( ! $site_breadcrumb_option ) return;
        if ( is_front_page() || is_home() ) return;
        $site_breadcrumb_type = DN\digital_newspaper_get_customizer_option( 'site_breadcrumb_type' );
        ?>
            <div class="digital-newspaper-breadcrumb-wrap">
                <?php
                    switch( $site_breadcrumb_type ) {
                        case 'yoast': if( digital_newspaper_compare_wand([digital_newspaper_function_exists( 'yoast_breadcrumb' )] ) ) yoast_breadcrumb();
                                break;
                        case 'rankmath': if( digital_newspaper_compare_wand([digital_newspaper_function_exists( 'rank_math_the_breadcrumbs' )] ) ) rank_math_the_breadcrumbs();
                                break;
                        case 'bcn': if( digital_newspaper_compare_wand([digital_newspaper_function_exists( 'bcn_display' )] ) ) bcn_display();
                                break;
                        default: do_action( 'digital_newspaper_breadcrumb_trail_hook' );
                                break;
                    }
                ?>
            </div>
        <?php
    }
endif;
add_action( 'digital_newspaper_before_inner_content', 'digital_newspaper_breadcrumb_html' );

if( ! function_exists( 'digital_newspaper_category_archive_featured_posts_html' ) ) :
    /**
     * Html for category archive page featured post
     * 
     * @package Digital Newspaper
     * @since 1.0.0
     */
    function digital_newspaper_category_archive_featured_posts_html() {
        if( ! is_category() ) return;
        $sticky_posts  =  get_option( 'sticky_posts' );
        if( ! $sticky_posts ) return;
        $current_object = get_queried_object();
        $current_object_id = $current_object->term_id;
        foreach( $sticky_posts as $sticky_post_id ) :
            $cat_ids =  wp_get_post_categories( $sticky_post_id, array( 'fields' => 'ids' ) );
            if( in_array( $current_object_id, $cat_ids ) ) {
                $post_to_get = $sticky_post_id;
                break;
            }
        endforeach;
        if( ! isset($post_to_get) ) return;
        ?>
            <div class="<?php echo esc_attr( 'ticker-news-section--' . digial_newspaper_get_section_width_layout_val() ); ?>">
                <div class="digital-newspaper-container">
                    <div class="row">
                        <article class="featured-post is-sticky" data-id="<?php echo esc_attr( $post_to_get ); ?>">
                            <figure class="post-thumb-wrap">
                                <a href="<?php the_permalink($post_to_get); ?>" title="<?php the_title_attribute(array('post'  => $post_to_get)); ?>">
                                    <?php if( has_post_thumbnail($post_to_get) ) {
                                            echo get_the_post_thumbnail($post_to_get, 'full', array(
                                                'title' => the_title_attribute(array(
                                                    'post'  => $post_to_get,
                                                    'echo'  => false
                                                ))
                                            ));
                                        }
                                    ?>
                                </a>
                                
                            </figure>
                            <div class="post-element">
                                <?php digital_newspaper_get_post_categories( $post_to_get, 2 ); ?>
                                <h2 class="post-title"><a href="<?php the_permalink($post_to_get); ?>" title="<?php the_title_attribute(array('post'  => $post_to_get)); ?>"><?php echo wp_kses_post( get_the_title($post_to_get) ); ?></a></h2>
                                <div class="post-meta">
                                    <?php
                                        digital_newspaper_posted_by($post_to_get);
                                        digital_newspaper_posted_on($post_to_get);
                                    ?>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        <?php
    }
    add_action( 'digital_newspaper_before_main_content', 'digital_newspaper_category_archive_featured_posts_html', 20 );
endif;

if( ! function_exists( 'digital_newspaper_category_archive_author_html' ) ) :
    /**
     * Html for category archive page featured post
     * 
     * @package Digital Newspaper
     * @since 1.0.0
     */
    function digital_newspaper_category_archive_author_html() {
        if( ! is_author() ) return;
        $author_id =  get_query_var( 'author' );
        $ticker_news_width_layout = digial_newspaper_get_section_width_layout_val('ticker_news_width_layout');
        $classes[] = esc_attr('ticker-news-section--' . $ticker_news_width_layout);
        ?>
        <div class="ticker-news-section--<?php echo esc_attr($ticker_news_width_layout); ?>">
          <div class="digital-newspaper-container digital-newspaper-author-section">
            <div class="row">
            <?php echo wp_kses_post( get_avatar($author_id, 125) ); ?>
            <div class="author-content">
                <h2 class="author-name"><?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?></h2>
                <p class="author-desc"><?php echo wp_kses_post( get_the_author_meta('description', $author_id) ); ?></p>
            </div>
            </div>
          </div>
        </div>
        <?php
    }
    add_action( 'digital_newspaper_before_main_content', 'digital_newspaper_category_archive_author_html', 20 );
endif;

if( ! function_exists( 'digital_newspaper_button_html' ) ) :
    /**
     * View all html
     * 
     * @package Digital Newspaper
     * @since 1.0.0
     */
    function digital_newspaper_button_html( $args ) {
        if( ! $args['option'] ) return;
        $global_button_text = DN\digital_newspaper_get_customizer_option( 'global_button_text' );
        $classes = isset( $args['classes'] ) ? 'post-link-button' . ' ' .$args['classes'] : 'post-link-button';
        $link = isset( $args['link'] ) ? $args['link'] : get_the_permalink();
        $text = isset( $args['text'] ) ? $args['text'] : $global_button_text['text'];
        $icon = isset( $args['icon'] ) ? $args['icon'] : $global_button_text['icon'];
        echo apply_filters( 'digital_newspaper_button_html', sprintf( '<a class="%1$s" href="%2$s">%3$s<i class="%4$s"></i></a>', esc_attr( $classes ), esc_url( $link ), esc_html( $text ), esc_attr( $icon ) ) );
    }
    add_action( 'digital_newspaper_section_block_view_all_hook', 'digital_newspaper_button_html', 10, 1 );
endif;

if( ! function_exists( 'digital_newspaper_archive_excerpt_more_string' ) ) :
    /**
     * Excerpt more string filter
     * 
     * @package Digital Newspaper
     * @since 1.0.0
     */
    function digital_newspaper_archive_excerpt_more_string( $more ) {
        return '...';
    }
    add_filter('excerpt_more', 'digital_newspaper_archive_excerpt_more_string');
endif;

if( ! function_exists( 'digital_newspaper_pagination_fnc' ) ) :
    /**
     * Renders pagination html
     * 
     * @package Digital Newspaper
     * @since 1.0.0
     */
    function digital_newspaper_pagination_fnc() {
        if( is_null( paginate_links() ) ) {
            return;
        }
        $pagination_type = DN\digital_newspaper_get_customizer_option( 'archive_pagination_type' );
        switch( $pagination_type ) {
            case 'number' : echo '<div class="pagination">' .wp_kses_post( paginate_links( array( 'prev_text' => '<i class="fas fa-chevron-left"></i>', 'next_text' => '<i class="fas fa-chevron-right"></i>', 'type' => 'list' ) ) ). '</div>';
                    break;
            default : echo '<div class="pagination">' .wp_kses_post( get_the_posts_navigation() ). '</div>';
                    break;
        }
    }
    add_action( 'digital_newspaper_pagination_link_hook', 'digital_newspaper_pagination_fnc' );
 endif;

 if( ! function_exists( 'digital_newspaper_scroll_to_top_html' ) ) :
    /**
     * Scroll to top fnc
     * 
     * @package Digital Newspaper
     * @since 1.0.0
     */
    function digital_newspaper_scroll_to_top_html() {
        if( ! DN\digital_newspaper_get_multiselect_tab_option('stt_responsive_option') ) return;
    ?>
        <div id="digital-newspaper-scroll-to-top" class="align--right">
            <span class="icon-holder"><i class="fas fa-caret-up"></i></span>
        </div><!-- #digital-newspaper-scroll-to-top -->
    <?php
    }
    add_action( 'digital_newspaper_after_footer_hook', 'digital_newspaper_scroll_to_top_html' );
 endif;

if( ! function_exists( 'digital_newspaper_loader_html' ) ) :
	/**
     * Preloader html
     * 
     * @package Digital Newspaper
     * @since 1.0.0
     */
	function digital_newspaper_loader_html() {
        if( ! DN\digital_newspaper_get_customizer_option( 'preloader_option' ) ) return;
	?>
		<div class="digital_newspaper_loading_box">
			<div class="box">
				<div class="loader-8"></div>
			</div>
		</div>
	<?php
	}
    add_action( 'digital_newspaper_page_prepend_hook', 'digital_newspaper_loader_html', 1 );
endif;

 if( ! function_exists( 'digital_newspaper_custom_header_html' ) ) :
    /**
     * Site custom header html
     * 
     * @package Digital Newspaper
     * @since 1.0.0
     */
    function digital_newspaper_custom_header_html() {
        /**
         * Get custom header markup
         * 
         * @since 1.0.0 
         */
        the_custom_header_markup();
    }
    add_action( 'digital_newspaper_page_prepend_hook', 'digital_newspaper_custom_header_html', 20 );
 endif;