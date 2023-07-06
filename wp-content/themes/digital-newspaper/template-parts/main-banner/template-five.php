<?php
/**
 * Main Banner template five
 * 
 * @package Digital Newspaper
 * @since 1.0.0
 */
use Digital_Newspaper\CustomizerDefault as DN;
?>
<div class="main-banner-list-posts">
    <h2 class="section-title"><?php echo esc_html( DN\digital_newspaper_get_customizer_option( 'main_banner_list_posts_title' ) ); ?></h2>
    <div class="list-posts-wrap">
        <?php
            $main_banner_list_posts_order_by = DN\digital_newspaper_get_customizer_option( 'main_banner_list_posts_order_by' );
            $listPostsOrderArray = explode( '-', $main_banner_list_posts_order_by );
            $main_banner_list_posts_categories = json_decode( DN\digital_newspaper_get_customizer_option( 'main_banner_list_posts_categories' ) );
            $list_posts_args = array(
                'numberposts' => 4,
                'order' => esc_html( $listPostsOrderArray[1] ),
                'orderby' => esc_html( $listPostsOrderArray[0] ),
                'category_name' => digital_newspaper_get_categories_for_args($main_banner_list_posts_categories)
            );
            // main_banner_list_posts_order_by
            $list_posts = get_posts( $list_posts_args );
            if( $list_posts ) :
                $total_posts = sizeof($list_posts);
                foreach( $list_posts as $list_post_key => $list_post ) :
                    $list_post_id  = $list_post->ID;
                ?>
                        <article class="post-item <?php if(!has_post_thumbnail($list_post_id)){ echo esc_attr(' no-feat-img');} ?>">
                        <?php if( $list_post_key == 0 ) { ?>
                                <figure class="post-thumb">
                                    <?php if( has_post_thumbnail($list_post_id) ): ?> 
                                        <a href="<?php echo esc_url(get_the_permalink($list_post_id)); ?>">
                                            <img src="<?php echo esc_url( get_the_post_thumbnail_url($list_post_id, 'digital-newspaper-list') ); ?>"/>
                                        </a>
                                    <?php endif; ?>
                                </figure>
                            <?php } ?>
                            <div class="post-element">
                                <?php digital_newspaper_get_post_categories( $list_post_id, 2 ); ?>
                                <h2 class="post-title"><a href="<?php the_permalink($list_post_id); ?>"><?php echo wp_kses_post( get_the_title($list_post_id) ); ?></a></h2>
                            </div>
                            <div class="post-meta">
                                <?php digital_newspaper_posted_by(); ?>
                                <?php digital_newspaper_posted_on(); ?>
                            </div>
                        </article>
                <?php
                endforeach;
            endif;
        ?>
    </div>
</div>

<?php
$slider_args = $args['slider_args'];
?>
<div class="main-banner-wrap">
    <div class="main-banner-slider">
        <?php
            $slider_query = new WP_Query( $slider_args );
            if( $slider_query -> have_posts() ) :
                while( $slider_query -> have_posts() ) : $slider_query -> the_post();
                ?>
                    <article class="slide-item <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?>">
                        <figure class="post-thumb">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php 
                                    if( has_post_thumbnail()) { 
                                        the_post_thumbnail('digital-newspaper-featured', array(
                                            'title' => the_title_attribute(array(
                                                'echo'  => false
                                            ))
                                        ));
                                    }
                                ?>
                            </a>
                        </figure>
                        <div class="post-element">
                            <div class="post-meta">
                                <?php digital_newspaper_get_post_categories( get_the_ID(), 2 ); ?>
                                <?php digital_newspaper_posted_on(); ?>
                            </div>
                            <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                            <div class="post-excerpt"><?php the_excerpt(); ?></div>
                            <?php
                                /**
                                 * hook - digital_newspaper_main_banner_post_append_hook
                                 * 
                                 */
                                do_action('digital_newspaper_main_banner_post_append_hook', get_the_ID());
                            ?>
                        </div>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
            endif;
        ?>
    </div>
</div>
<?php
    // Slider direction
    $digital_newspaper_slider_direction = DN\digital_newspaper_get_customizer_option('main_banner_grid_posts_direction');
    $digital_newspaper_slider = 'digital_newspaper_vertical_slider';
    if( $digital_newspaper_slider_direction == 'false' ) {
        $digital_newspaper_slider = 'digital_newspaper_horizontal_slider';
    }
?>
<div class="main-banner-grid-posts <?php echo esc_attr($digital_newspaper_slider); ?>">
    <h2 class="section-title"><?php echo esc_html( DN\digital_newspaper_get_customizer_option( 'main_banner_grid_posts_title' ) ); ?></h2>
    <div class="grid-posts-wrap" data-vertical="<?php echo esc_attr( $digital_newspaper_slider_direction ); ?>">
        <?php
            $main_banner_grid_posts_order_by = DN\digital_newspaper_get_customizer_option( 'main_banner_grid_posts_order_by' );
            $gridPostsOrderArray = explode( '-', $main_banner_grid_posts_order_by );
            $main_banner_grid_posts_categories = json_decode( DN\digital_newspaper_get_customizer_option( 'main_banner_grid_posts_categories' ) );
            $grid_posts_args = array(
                'numberposts' => -1,
                'order' => esc_html( $gridPostsOrderArray[1] ),
                'orderby' => esc_html( $gridPostsOrderArray[0] ),
                'category_name' => digital_newspaper_get_categories_for_args($main_banner_grid_posts_categories)
            );
            if( ! $main_banner_grid_posts_categories ) $grid_posts_args['numberposts'] = 8;
            $grid_posts = get_posts( $grid_posts_args );
            if( $grid_posts ) :
                $total_posts = sizeof($grid_posts);
                foreach( $grid_posts as $grid_post_key => $grid_post ) :
                    $grid_post_id  = $grid_post->ID;
                    if( $digital_newspaper_slider_direction == 'false' ) {
                        if( ( $grid_post_key % 3 ) == 0 ) echo '<div class="digital-newspaper-slick-slide-wrap">';
                    }
                ?>
                        <article class="post-item digital-newspaper-category-no-bk <?php if(!has_post_thumbnail($grid_post_id)){ echo esc_attr(' no-feat-img');} ?>">
                            <figure class="post-thumb">
                                <?php if( has_post_thumbnail($grid_post_id) ): ?> 
                                    <a href="<?php echo esc_url(get_the_permalink($grid_post_id)); ?>">
                                        <img src="<?php echo esc_url( get_the_post_thumbnail_url($grid_post_id, 'digital-newspaper-list') ); ?>"/>
                                    </a>
                                <?php endif; ?>
                            </figure>
                            <div class="post-element">
                                <h2 class="post-title"><a href="<?php the_permalink($grid_post_id); ?>"><?php echo wp_kses_post( get_the_title($grid_post_id) ); ?></a></h2>
                            </div>
                        </article>
                <?php
                    if( $digital_newspaper_slider_direction == 'false' ) {
                        if( ( $grid_post_key % 3 ) == 2 || ( $grid_post_key + 1 ) == $total_posts ) echo '</div><!-- .digital-newspaper-slick-slide-wrap -->';
                    }
                endforeach;
            endif;
        ?>
    </div>
</div>