<?php
/**
 * Includes all the frontpage sections html functions
 * 
 * @package Digital Newspaper
 * @since 1.0.0
 */
use Digital_Newspaper\CustomizerDefault as DN;

if( ! function_exists( 'digital_newspaper_main_banner_part' ) ) :
    /**
     * Main Banner element
     * 
     * @since 1.0.0
     */
     function digital_newspaper_main_banner_part() {
        $main_banner_option = DN\digital_newspaper_get_customizer_option( 'main_banner_option' );
        if( ! $main_banner_option || is_paged() || digital_newspaper_is_paged_filtered() ) return;
        $main_banner_post_filter = DN\digital_newspaper_get_customizer_option( 'main_banner_post_filter' );
        $main_banner_slider_order_by = DN\digital_newspaper_get_customizer_option( 'main_banner_slider_order_by' );
        $orderArray = explode( '-', $main_banner_slider_order_by );
        $main_banner_slider_categories = json_decode( DN\digital_newspaper_get_customizer_option( 'main_banner_slider_categories' ) );
        $main_banner_args = array(
            'slider_args'  => array(
                'order' => esc_html( $orderArray[1] ),
                'orderby' => esc_html( $orderArray[0] ),
                'ignore_sticky_posts'   => true
            )
        );
        if( $main_banner_post_filter == 'category' ) {
            $main_banner_args['slider_args']['posts_per_page']= absint( DN\digital_newspaper_get_customizer_option( 'main_banner_slider_numbers' ) );
            if( DN\digital_newspaper_get_customizer_option( 'main_banner_date_filter' ) != 'all' ) $main_banner_args['slider_args']['date_query'] = digital_newspaper_get_date_format_array_args(DN\digital_newspaper_get_customizer_option( 'main_banner_date_filter' ));
            if( $main_banner_slider_categories ) $main_banner_args['slider_args']['category_name'] = digital_newspaper_get_categories_for_args($main_banner_slider_categories);
        } else if( $main_banner_post_filter == 'title' ) {
            $main_banner_posts = json_decode(DN\digital_newspaper_get_customizer_option( 'main_banner_posts' ));
            if( $main_banner_posts ) $main_banner_args['slider_args']['post_name__in'] = digital_newspaper_get_post_slugs_for_args($main_banner_posts);
        }
        $banner_section_three_column_order = DN\digital_newspaper_get_customizer_option( 'banner_section_three_column_order' );
        $section_column_sort_class = implode( '--', array( $banner_section_three_column_order[0]['value'], $banner_section_three_column_order[1]['value'], $banner_section_three_column_order[2]['value'] ) );
        
        $main_banner_layout = digial_newspaper_get_section_width_layout_val('main_banner_layout');
        $main_banner_width_layout = digial_newspaper_get_section_width_layout_val('main_banner_width_layout');
        ?>
            <section id="main-banner-section" class="digital-newspaper-section banner-layout--<?php echo esc_attr($main_banner_layout); ?> <?php echo esc_attr( $section_column_sort_class ); ?> <?php echo esc_attr( 'width-' . $main_banner_width_layout ); ?>">
                <div class="digital-newspaper-container">
                    <div class="row">
                        <?php get_template_part( 'template-parts/main-banner/template', esc_html($main_banner_layout), $main_banner_args ); ?>
                    </div>
                </div>
            </section>
        <?php
     }
endif;
add_action( 'digital_newspaper_main_banner_hook', 'digital_newspaper_main_banner_part', 10 );

if( ! function_exists( 'digital_newspaper_full_width_blocks_part' ) ) :
    /**
     * Full Width Blocks element
     * 
     * @since 1.0.0
     */
     function digital_newspaper_full_width_blocks_part() {
        $full_width_blocks = DN\digital_newspaper_get_customizer_option( 'full_width_blocks' );
        if( empty( $full_width_blocks ) || is_paged() || digital_newspaper_is_paged_filtered() ) return;
        $full_width_blocks = json_decode( $full_width_blocks );
        if( ! in_array( true, array_column( $full_width_blocks, 'option' ) ) ) {
            return;
        }
        $full_width_blocks_width_layout = digial_newspaper_get_section_width_layout_val('full_width_blocks_width_layout');
        ?>
            <section id="full-width-section" class="digital-newspaper-section full-width-section <?php echo esc_attr( 'width-' . $full_width_blocks_width_layout ); ?>">
                <div class="digital-newspaper-container">
                    <div class="row">
                        <?php
                            foreach( $full_width_blocks as $block ) :
                                if( $block->option ) :
                                    $type = $block->type;
                                    switch($type) {
                                        case 'shortcode-block' : digital_newspaper_shortcode_block_html( $block, true );
                                                        break;
                                        case 'ad-block' : digital_newspaper_advertisement_block_html( $block, true );
                                                        break;
                                        default: $layout = $block->layout;
                                                $order = $block->query->order;
                                                $postCategories = $block->query->categories;
                                                $customexclude_ids = $block->query->ids;
                                                $orderArray = explode( '-', $order );
                                                $block_args = array(
                                                    'post_args' => array(
                                                        'post_type' => 'post',
                                                        'order' => esc_html( $orderArray[1] ),
                                                        'orderby' => esc_html( $orderArray[0] ),
                                                        'ignore_sticky_posts'   => true
                                                    ),
                                                    'options'    => $block
                                                );
                                                if( $block->query->postFilter == 'category' ) {
                                                    $block_args['post_args']['posts_per_page'] = absint( $block->query->count );
                                                    if( $customexclude_ids ) $block_args['post_args']['post__not_in'] = $customexclude_ids;
                                                    if( $postCategories ) $block_args['post_args']['category_name'] = digital_newspaper_get_categories_for_args($postCategories);
                                                    if( $block->query->dateFilter != 'all' ) $block_args['post_args']['date_query'] = digital_newspaper_get_date_format_array_args($block->query->dateFilter);
                                                } else if( $block->query->postFilter == 'title' ) {
                                                    if( $block->query->posts ) $block_args['post_args']['post_name__in'] = digital_newspaper_get_post_slugs_for_args($block->query->posts);
                                                }
                                                // get template file w.r.t par
                                                get_template_part( 'template-parts/' .esc_html( $type ). '/template', esc_html( $layout ), $block_args );
                                    }
                                endif;
                            endforeach;
                        ?>
                    </div>
                </div>
            </section>
        <?php
     }
     add_action( 'digital_newspaper_full_width_blocks_hook', 'digital_newspaper_full_width_blocks_part' );
endif;

if( ! function_exists( 'digital_newspaper_leftc_rights_blocks_part' ) ) :
    /**
     * Left Content Right Sidebar Blocks element
     * 
     * @since 1.0.0
     */
     function digital_newspaper_leftc_rights_blocks_part() {
        $leftc_rights_blocks = DN\digital_newspaper_get_customizer_option( 'leftc_rights_blocks' );
        if( empty( $leftc_rights_blocks ) || is_paged() || digital_newspaper_is_paged_filtered() ) return;
        $leftc_rights_blocks = json_decode( $leftc_rights_blocks );
        if( ! in_array( true, array_column( $leftc_rights_blocks, 'option' ) ) ) {
            return;
        }
        $leftc_rights_blocks_width_layout = digial_newspaper_get_section_width_layout_val('leftc_rights_blocks_width_layout');
        ?>
            <section id="leftc-rights-section" class="digital-newspaper-section leftc-rights-section <?php echo esc_attr( 'width-' . $leftc_rights_blocks_width_layout ); ?>">
                <div class="digital-newspaper-container">
                    <div class="row">
                        <div class="primary-content">
                            <?php
                                foreach( $leftc_rights_blocks as $block ) :
                                    if( $block->option ) :
                                        $type = $block->type;
                                        switch($type) {
                                            case 'shortcode-block' : digital_newspaper_shortcode_block_html( $block, true );
                                                        break;
                                            case 'ad-block' : digital_newspaper_advertisement_block_html( $block, true );
                                                            break;
                                            default: $layout = $block->layout;
                                                    $order = $block->query->order;
                                                    $postCategories = $block->query->categories;
                                                    $customexclude_ids = $block->query->ids;
                                                    $orderArray = explode( '-', $order );
                                                    $block_args = array(
                                                        'post_args' => array(
                                                            'post_type' => 'post',
                                                            'order' => esc_html( $orderArray[1] ),
                                                            'orderby' => esc_html( $orderArray[0] ),
                                                            'ignore_sticky_posts'   => true
                                                        ),
                                                        'options'    => $block
                                                    );
                                                    if( $block->query->postFilter == 'category' ) {
                                                        $block_args['post_args']['posts_per_page'] = absint( $block->query->count );
                                                        if( $customexclude_ids ) $block_args['post_args']['post__not_in'] = $customexclude_ids;
                                                        if( $postCategories ) $block_args['post_args']['category_name'] = digital_newspaper_get_categories_for_args($postCategories);
                                                        if( $block->query->dateFilter != 'all' ) $block_args['post_args']['date_query'] = digital_newspaper_get_date_format_array_args($block->query->dateFilter);
                                                    } else if( $block->query->postFilter == 'title' ) {
                                                        if( $block->query->posts ) $block_args['post_args']['post_name__in'] = digital_newspaper_get_post_slugs_for_args($block->query->posts);
                                                    }
                                                    // get template file w.r.t par
                                                    get_template_part( 'template-parts/' .esc_html( $type ). '/template', esc_html( $layout ), $block_args );
                                        }
                                    endif;
                                endforeach;
                            ?>
                        </div>
                        <div class="secondary-sidebar">
                            <?php dynamic_sidebar( 'front-right-sidebar' ); ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php
     }
     add_action( 'digital_newspaper_leftc_rights_blocks_hook', 'digital_newspaper_leftc_rights_blocks_part', 10 );
endif;

if( ! function_exists( 'digital_newspaper_lefts_rightc_blocks_part' ) ) :
    /**
     * Left Sidebar Right Content Blocks element
     * 
     * @since 1.0.0
     */
     function digital_newspaper_lefts_rightc_blocks_part() {
        $lefts_rightc_blocks = DN\digital_newspaper_get_customizer_option( 'lefts_rightc_blocks' );
        if( empty( $lefts_rightc_blocks )|| is_paged() || digital_newspaper_is_paged_filtered() ) return;
        $lefts_rightc_blocks = json_decode( $lefts_rightc_blocks );
        if( ! in_array( true, array_column( $lefts_rightc_blocks, 'option' ) ) ) {
            return;
        }
        $lefts_rightc_blocks_width_layout = digial_newspaper_get_section_width_layout_val('lefts_rightc_blocks_width_layout');
        ?>
            <section id="lefts-rightc-section" class="digital-newspaper-section lefts-rightc-section <?php echo esc_attr( 'width-' . $lefts_rightc_blocks_width_layout ); ?>">
                <div class="digital-newspaper-container">
                    <div class="row">
                        <div class="secondary-sidebar">
                            <?php dynamic_sidebar( 'front-left-sidebar' ); ?>
                        </div>
                        <div class="primary-content">
                            <?php
                                foreach( $lefts_rightc_blocks as $block ) :
                                    if( $block->option ) :
                                        $type = $block->type;
                                        switch($type) {
                                            case 'shortcode-block' : digital_newspaper_shortcode_block_html( $block, true );
                                                        break;
                                            case 'ad-block' : digital_newspaper_advertisement_block_html( $block, true );
                                                            break;
                                            default: $layout = $block->layout;
                                                    $order = $block->query->order;
                                                    $postCategories = $block->query->categories;
                                                    $customexclude_ids = $block->query->ids;
                                                    $orderArray = explode( '-', $order );
                                                    $block_args = array(
                                                        'post_args' => array(
                                                            'post_type' => 'post',
                                                            'order' => esc_html( $orderArray[1] ),
                                                            'orderby' => esc_html( $orderArray[0] ),
                                                            'ignore_sticky_posts'   => true
                                                        ),
                                                        'options'    => $block
                                                    );
                                                    if( $block->query->postFilter == 'category' ) {
                                                        $block_args['post_args']['posts_per_page'] = absint( $block->query->count );
                                                        if( $customexclude_ids ) $block_args['post_args']['post__not_in'] = $customexclude_ids;
                                                        if( $postCategories ) $block_args['post_args']['category_name'] = digital_newspaper_get_categories_for_args($postCategories);
                                                        if( $block->query->dateFilter != 'all' ) $block_args['post_args']['date_query'] = digital_newspaper_get_date_format_array_args($block->query->dateFilter);
                                                    } else if( $block->query->postFilter == 'title' ) {
                                                        if( $block->query->posts ) $block_args['post_args']['post_name__in'] = digital_newspaper_get_post_slugs_for_args($block->query->posts);
                                                    }
                                                    // get template file w.r.t par
                                                    get_template_part( 'template-parts/' .esc_html( $type ). '/template', esc_html( $layout ), $block_args );
                                        }
                                    endif;
                                endforeach;
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php
     }
     add_action( 'digital_newspaper_lefts_rightc_blocks_hook', 'digital_newspaper_lefts_rightc_blocks_part', 10 );
endif;

if( ! function_exists( 'digital_newspaper_bottom_full_width_blocks_part' ) ) :
    /**
     * Bottom Full Width Blocks element
     * 
     * @since 1.0.0
     */
     function digital_newspaper_bottom_full_width_blocks_part() {
        $bottom_full_width_blocks = DN\digital_newspaper_get_customizer_option( 'bottom_full_width_blocks' );
        if( empty( $bottom_full_width_blocks )|| is_paged() || digital_newspaper_is_paged_filtered() ) return;
        $bottom_full_width_blocks = json_decode( $bottom_full_width_blocks );
        if( ! in_array( true, array_column( $bottom_full_width_blocks, 'option' ) ) ) {
            return;
        }
        $bottom_full_width_blocks_width_layout = digial_newspaper_get_section_width_layout_val('bottom_full_width_blocks_width_layout');
        ?>
            <section id="bottom-full-width-section" class="digital-newspaper-section bottom-full-width-section <?php echo esc_attr( 'width-' . $bottom_full_width_blocks_width_layout ); ?>">
                <div class="digital-newspaper-container">
                    <div class="row">
                        <?php
                            foreach( $bottom_full_width_blocks as $block ) :
                                if( $block->option ) :
                                    $type = $block->type;
                                    switch($type) {
                                        case 'shortcode-block' : digital_newspaper_shortcode_block_html( $block, true );
                                                        break;
                                        case 'ad-block' : digital_newspaper_advertisement_block_html( $block, true );
                                                        break;
                                        default: $layout = $block->layout;
                                                $order = $block->query->order;
                                                $postCategories = $block->query->categories;
                                                $customexclude_ids = $block->query->ids;
                                                $orderArray = explode( '-', $order );
                                                $block_args = array(
                                                    'post_args' => array(
                                                        'post_type' => 'post',
                                                        'order' => esc_html( $orderArray[1] ),
                                                        'orderby' => esc_html( $orderArray[0] ),
                                                        'ignore_sticky_posts'   => true
                                                    ),
                                                    'options'    => $block
                                                );
                                                if( $block->query->postFilter == 'category' ) {
                                                    $block_args['post_args']['posts_per_page'] = absint( $block->query->count );
                                                    if( $customexclude_ids ) $block_args['post_args']['post__not_in'] = $customexclude_ids;
                                                    if( $postCategories ) $block_args['post_args']['category_name'] = digital_newspaper_get_categories_for_args($postCategories);
                                                    if( $block->query->dateFilter != 'all' ) $block_args['post_args']['date_query'] = digital_newspaper_get_date_format_array_args($block->query->dateFilter);
                                                } else if( $block->query->postFilter == 'title' ) {
                                                    if( $block->query->posts ) $block_args['post_args']['post_name__in'] = digital_newspaper_get_post_slugs_for_args($block->query->posts);
                                                }
                                                // get template file w.r.t par
                                                get_template_part( 'template-parts/' .esc_html( $type ). '/template', esc_html( $layout ), $block_args );
                                    }
                                endif;
                            endforeach;
                        ?>
                    </div>
                </div>
            </section>
        <?php
     }
     add_action( 'digital_newspaper_bottom_full_width_blocks_hook', 'digital_newspaper_bottom_full_width_blocks_part', 10 );
endif;