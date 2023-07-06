<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Digital Newspaper
 */
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
					<section class="error-404 not-found">
						<?php
							/**
							 * hook - digital_newspaper_before_inner_content
							 * 
							 */
							do_action( 'digital_newspaper_before_inner_content' );
						?>
						<div class="post-inner-wrapper">
							<header class="page-header">
								<h1 class="page-title digital-newspaper-block-title"><?php echo esc_html__( '404 Not Found', 'digital-newspaper' ); ?></h1>
							</header><!-- .page-header -->

							<div class="page-content">
								<p><?php echo esc_html__( 'It looks like nothing was found at this location. Maybe try another search?', 'digital-newspaper' ); ?></p>
							</div><!-- .page-content -->

							<div class="page-footer">
								<a class="button-404" href="<?php echo esc_url( home_url() ); ?>"><?php echo esc_html__( 'Go back to home', 'digital-newspaper' ); ?></a>
							</div>
						</div><!-- .post-inner-wrapper -->
					</section><!-- .error-404 -->
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
