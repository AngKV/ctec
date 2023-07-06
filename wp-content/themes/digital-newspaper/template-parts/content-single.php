<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Digital Newspaper
 */
use Digital_Newspaper\CustomizerDefault as DN;
?>
<article <?php digital_newspaper_schema_article_attributes(); ?> id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-inner">
		<header class="entry-header">
			<?php
				the_category();
				the_title( '<h1 class="entry-title"' .digital_newspaper_schema_article_name_attributes(). '>', '</h1>' );
				if ( 'post' === get_post_type() ) :
					?>
					<div class="entry-meta">
						<?php
							digital_newspaper_posted_by();
							digital_newspaper_posted_on();
							digital_newspaper_comments_number();
							echo '<span class="read-time">' .digital_newspaper_post_read_time( get_the_content() ). ' ' .esc_html__( 'mins', 'digital-newspaper' ). '</span>';
						?>
					</div><!-- .entry-meta -->
				<?php endif;
				digital_newspaper_post_thumbnail();
			?>
		</header><!-- .entry-header -->

		<div <?php digital_newspaper_schema_article_body_attributes(); ?> class="entry-content">
			<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'digital-newspaper' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					)
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'digital-newspaper' ),
						'after'  => '</div>',
					)
				);
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php digital_newspaper_tags_list(); ?>
			<?php digital_newspaper_entry_footer(); ?>
		</footer><!-- .entry-footer -->
		<?php
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle"><i class="fas fa-angle-double-left"></i>' . esc_html__( 'Previous:', 'digital-newspaper' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'digital-newspaper' ) . '<i class="fas fa-angle-double-right"></i></span> <span class="nav-title">%title</span>',
				)
			);
		?>
	</div>
	<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
	?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php
	/**
	 * hook - digital_newspaper_single_post_append_hook
	 * 
	 */
	do_action( 'digital_newspaper_single_post_append_hook' );
?>