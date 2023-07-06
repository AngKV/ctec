<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Digital Newspaper
 */
use Digital_Newspaper\CustomizerDefault as DN;
get_header();
/**
 * hook - digital_newspaper_main_banner_hook
 * 
 * hooked - digital_newspaper_main_banner_part - 10
 */
if( is_home() && is_front_page() ) do_action( 'digital_newspaper_main_banner_hook' );

$homepage_content_order = DN\digital_newspaper_get_customizer_option( 'homepage_content_order' );
foreach( $homepage_content_order as $content_order_key => $content_order ) :
	if( $content_order['value'] == 'latest_posts' && is_home() && ! is_front_page()  ) $content_order['option'] = true;
	if( $content_order['option'] ) :
		switch( $content_order['value'] ) {
			case "full_width_section": 
								/**
								 * hook - digital_newspaper_full_width_blocks_hook
								 * 
								 * hooked- digital_newspaper_full_width_blocks_part
								 * @since 1.0.0
								 * 
								 */
								if( is_home() && is_front_page() ) do_action( 'digital_newspaper_full_width_blocks_hook' );
							break;
			case "leftc_rights_section": 
								/**
								 * hook - digital_newspaper_leftc_rights_blocks_hook
								 * 
								 * hooked- digital_newspaper_leftc_rights_blocks_part
								 * @since 1.0.0
								 * 
								 */
								if( is_home() && is_front_page() ) do_action( 'digital_newspaper_leftc_rights_blocks_hook' );
							break;
			case "lefts_rightc_section": 
								/**
								 * hook - digital_newspaper_lefts_rightc_blocks_hook
								 * 
								 * hooked- digital_newspaper_lefts_rightc_blocks_part
								 * @since 1.0.0
								 * 
								 */
								if( is_home() && is_front_page() ) do_action( 'digital_newspaper_lefts_rightc_blocks_hook' );
							break;
			case "bottom_full_width_section": 
								/**
								 * hook - digital_newspaper_bottom_full_width_blocks_hook
								 * 
								 * hooked- digital_newspaper_bottom_full_width_blocks_part
								 * @since 1.0.0
								 * 
								 */
								if( is_home() && is_front_page() ) do_action( 'digital_newspaper_bottom_full_width_blocks_hook' );
							break;
			default: ?>
					<div id="theme-content">
						<main id="primary" class="site-main <?php echo esc_attr( 'width-' . digial_newspaper_get_section_width_layout_val() ); ?>">
							<div class="digital-newspaper-container">
                    			<div class="row">
									<div class="secondary-left-sidebar">
										<?php get_sidebar('left'); ?>
									</div>
                    				<div class="primary-content">
										<?php
											if ( have_posts() ) :
												if ( is_home() && ! is_front_page() ) :
													?>
													<header>
														<h1 class="page-title digital-newspaper-block-title screen-reader-text"><?php single_post_title(); ?></h1>
													</header>
													<?php
												endif;
												echo '<div class="news-list-wrap">';
													/* Start the Loop */
													while ( have_posts() ) :
														the_post();
														/*
														* Include the Post-Type-specific template for the content.
														* If you want to override this in a child theme, then include a file
														* called content-___.php (where ___ is the Post Type name) and that will be used instead.
														*/
														get_template_part( 'template-parts/content', get_post_type() );
													endwhile;
												echo '</div>';

													/**
													 * hook - digital_newspaper_pagination_link_hook
													 * 
													 * @package Digital Newspaper
													 * @since 1.0.0
													 */
													do_action( 'digital_newspaper_pagination_link_hook' );
											else :
												get_template_part( 'template-parts/content', 'none' );
											endif;
										?>
									</div>
									<div class="secondary-sidebar">
										<?php
											get_sidebar();
										?>
									</div>
								</div>
							</div> <!-- digital-newspaper-container end -->
						</main><!-- #main -->
					</div><!-- #theme-content -->
			<?php
		}
	endif;
endforeach;
get_footer();