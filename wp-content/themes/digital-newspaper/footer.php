<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Digital Newspaper
 */

 /**
  * hook - digital_newspaper_before_footer_section
  * 
  */
  do_action( 'digital_newspaper_before_footer_section' );
?>
	<footer id="colophon" class="site-footer dark_bk">
		<?php
			/**
			 * Function - digital_newspaper_footer_sections_html
			 * 
			 * @since 1.0.0
			 * 
			 */
			digital_newspaper_footer_sections_html();

			/**
			 * Function - digital_newspaper_bottom_footer_sections_html
			 * 
			 * @since 1.0.0
			 * 
			 */
			digital_newspaper_bottom_footer_sections_html();
		?>
	</footer><!-- #colophon -->
	<?php
		/**
		* hook - digital_newspaper_after_footer_hook
		*
		* @hooked - digital_newspaper_scroll_to_top
		*
		*/
		if( has_action( 'digital_newspaper_after_footer_hook' ) ) {
			do_action( 'digital_newspaper_after_footer_hook' );
		}
	?>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>