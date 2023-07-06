<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
					<?php
						/**
						 * hook - digital_newspaper_before_inner_content
						 * 
						 */
						do_action( 'digital_newspaper_before_inner_content' );
						
						if ( have_posts() ) : ?>
						<header class="page-header">
							<?php
								if( ! is_author() ) :
									the_archive_title( '<h1 class="page-title digital-newspaper-block-title">', '</h1>' );
									the_archive_description( '<div class="archive-description">', '</div>' );
								endif;
							?>
						</header><!-- .page-header -->
						<div class="post-inner-wrapper news-list-wrap">
							<?php
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
				</div>
				<div class="secondary-sidebar">
					<?php
						get_sidebar();
					?>
				</div>
			</div>
		</div>

	</main><!-- #main -->
</div><!-- #theme-content -->
<?php
get_footer();
