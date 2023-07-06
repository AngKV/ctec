<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Digital Newspaper
 */
use Digital_Newspaper\CustomizerDefault as DN;
get_header();
?>
<div id="theme-content">
	<?php
		/**
		 * hook - digital_newspaper_before_main_content
		 * 
		 */
		do_action( 'digital_newspaper_before_main_content' );
	?>
	<main id="primary" class="site-main <?php echo esc_attr( 'width-' . digial_newspaper_get_section_width_layout_val() ); ?>">
		<div class="digital-newspaper-container">
           	<div class="row">
			    <div class="secondary-left-sidebar">
					<?php
						get_sidebar('left');
					?>
				</div>
				<div class="primary-content">
					<div class="news-list layout--two">
					<?php
						/**
						 * hook - digital_newspaper_before_inner_content
						 * 
						 */
						do_action( 'digital_newspaper_before_inner_content' );
						
						if ( have_posts() ) : ?>
							<header class="page-header">
								<h1 class="page-title digital-newspaper-block-title">
									<?php
										/* translators: %s: search query. */
										printf( esc_html( __( 'Search Results for', 'digital-newspaper' ). ': %s' ), '<span>' . get_search_query() . '</span>' );
									?>
								</h1>
							</header><!-- .page-header -->
							<div class="post-inner-wrapper">
								<div class="news-list-post-wrap column--one">
									<?php
										/* Start the Loop */
										while ( have_posts() ) :
											the_post();
											/**
											 * Run the loop for the search to output the results.
											 * If you want to overload this in a child theme then include a file
											 * called content-search.php and that will be used instead.
											 */
											get_template_part( 'template-parts/content', 'search' );

										endwhile;
										/**
										 * hook - digital_newspaper_pagination_link_hook
										 * 
										 * @package Digital Newspaper
										 * @since 1.0.0
										 */
										do_action( 'digital_newspaper_pagination_link_hook' );
									?>
								</div>
							</div>
							<?php
							else :
								get_template_part( 'template-parts/content', 'none' );
							endif;
							?>
					</div>
				</div>
				<div class="secondary-sidebar">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</main><!-- #main -->
	<?php get_sidebar(); ?>
</div><!-- #theme-content -->
<?php
get_footer();
