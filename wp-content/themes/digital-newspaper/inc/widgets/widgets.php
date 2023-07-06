<?php
/**
 * Handle the wigets files and hooks
 * 
 * @package Digital Newspaper
 * @since 1.0.0
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function digital_newspaper_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'digital-newspaper' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'digital-newspaper' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title"><span>',
			'after_title'   => '</span></h2>',
		)
	);

	// left sidebar
	register_sidebar(
		array(
			'name'          => esc_html__( 'Left Sidebar', 'digital-newspaper' ),
			'id'            => 'left-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'digital-newspaper' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title"><span>',
			'after_title'   => '</span></h2>',
		)
	);

	// header toggle sidebar
	register_sidebar(
		array(
			'name'          => esc_html__( 'Header Toggle Sidebar', 'digital-newspaper' ),
			'id'            => 'header-toggle-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'digital-newspaper' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title"><span>',
			'after_title'   => '</span></h2>',
		)
	);
	
	// front right sidebar
	register_sidebar(
		array(
			'name'          => esc_html__( 'Frontpage - Middle Right Sidebar', 'digital-newspaper' ),
			'id'            => 'front-right-sidebar',
			'description'   => esc_html__( 'Add widgets suitable for middle right here.', 'digital-newspaper' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title"><span>',
			'after_title'   => '</span></h2>',
		)
	);

	// front left sidebar
	register_sidebar(
		array(
			'name'          => esc_html__( 'Frontpage - Middle Left Sidebar', 'digital-newspaper' ),
			'id'            => 'front-left-sidebar',
			'description'   => esc_html__( 'Add widgets suitable for middle left here.', 'digital-newspaper' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title"><span>',
			'after_title'   => '</span></h2>',
		)
	);

	// footer sidebar - column 1
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar - Column 1', 'digital-newspaper' ),
			'id'            => 'footer-sidebar--column-1',
			'description'   => esc_html__( 'Add widgets here.', 'digital-newspaper' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title"><span>',
			'after_title'   => '</span></h2>',
		)
	);

	// footer sidebar - column 2
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar - Column 2', 'digital-newspaper' ),
			'id'            => 'footer-sidebar--column-2',
			'description'   => esc_html__( 'Add widgets here.', 'digital-newspaper' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	// footer sidebar - column 3
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar - Column 3', 'digital-newspaper' ),
			'id'            => 'footer-sidebar--column-3',
			'description'   => esc_html__( 'Add widgets here.', 'digital-newspaper' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title"><span>',
			'after_title'   => '</span></h2>',
		)
	);

	// footer sidebar - column 4
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar - Column 4', 'digital-newspaper' ),
			'id'            => 'footer-sidebar--column-4',
			'description'   => esc_html__( 'Add widgets here.', 'digital-newspaper' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title"><span>',
			'after_title'   => '</span></h2>',
		)
	);

	// Register custom widgets
    register_widget( 'Digital_Newspaper_Widget_Title_Widget' ); // custom widget title
	register_widget( 'Digital_Newspaper_Posts_List_Widget' ); // post lists widget
	register_widget( 'Digital_Newspaper_Posts_Grid_Widget' ); // post grid widget
	register_widget( 'Digital_Newspaper_Category_Collection_Widget' ); // category collection widget
	register_widget( 'Digital_Newspaper_Author_Info_Widget' ); // author info widget
	register_widget( 'Digital_Newspaper_Banner_Ads_Widget' ); // banner ad widget
	register_widget( 'Digital_Newspaper_Carousel_Widget' ); // carousel widget
	register_widget( 'Digital_Newspaper_Social_Icons_Widget' ); // social icons widget
	register_widget( 'Digital_Newspaper_Posts_Grid_Two_Column_Widget' ); // post grid two column widget
}
add_action( 'widgets_init', 'digital_newspaper_widgets_init' );

// includes files
require DIGITAL_NEWSPAPER_INCLUDES_PATH .'widgets/widget-fields.php';
require DIGITAL_NEWSPAPER_INCLUDES_PATH .'widgets/category-collection.php';
require DIGITAL_NEWSPAPER_INCLUDES_PATH .'widgets/posts-list.php';
require DIGITAL_NEWSPAPER_INCLUDES_PATH .'widgets/posts-grid.php';
require DIGITAL_NEWSPAPER_INCLUDES_PATH .'widgets/author-info.php';
require DIGITAL_NEWSPAPER_INCLUDES_PATH .'widgets/banner-ads.php';
require DIGITAL_NEWSPAPER_INCLUDES_PATH .'widgets/carousel.php';
require DIGITAL_NEWSPAPER_INCLUDES_PATH .'widgets/social-icons.php';
require DIGITAL_NEWSPAPER_INCLUDES_PATH .'widgets/widget-title.php';
require DIGITAL_NEWSPAPER_INCLUDES_PATH .'widgets/posts-grid-two-column.php';

function digital_newspaper_widget_scripts($hook) {
    if( $hook !== "widgets.php" ) {
        return;
    }
    wp_enqueue_style( 'digital-newspaper-widget', get_template_directory_uri() . '/inc/widgets/assets/widgets.css', array(), DIGITAL_NEWSPAPER_VERSION );
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/lib/fontawesome/css/all.min.css', array(), '5.15.3', 'all' );
	wp_enqueue_media();
	wp_enqueue_script( 'digital-newspaper-widget', get_template_directory_uri() . '/inc/widgets/assets/widgets.js', array( 'jquery' ), DIGITAL_NEWSPAPER_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'digital_newspaper_widget_scripts' );

if( ! function_exists( 'digital_newspaper_get_tabbed_icon_classes' ) ) :
	/**
	 * List of icons classes
	 * 
	 * @package Digital Newspaper
	 */
	function digital_newspaper_get_tabbed_icon_classes() {
		return apply_filters( 'digital_newspaper_tabbed_block_icons', array( "fas fa-ban","fas fa-clock","far fa-clock","fas fa-newspaper","far fa-newspaper","fas fa-poll","fas fa-poll-h","fas fa-ban","fas fa-fire","fas fa-fire-alt","fas fa-comments","fas fa-comment-dots","far fa-comment-dots","far fa-comment","far fa-comments","fas fa-comment-alt","far fa-comment-alt" ) );
	}
endif;