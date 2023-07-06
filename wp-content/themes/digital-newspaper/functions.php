<?php
/**
 * Digital Newspaper functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Digital Newspaper
 */
use Digital_Newspaper\CustomizerDefault as DN;
if ( ! defined( 'DIGITAL_NEWSPAPER_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	$theme_info = wp_get_theme();
	define( 'DIGITAL_NEWSPAPER_VERSION', $theme_info->get( 'Version' ) );
}

if ( ! defined( 'DIGITAL_NEWSPAPER_PREFIX' ) ) {
	// Replace the prefix of theme if changed.
	define( 'DIGITAL_NEWSPAPER_PREFIX', 'digital_newspaper_' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function digital_newspaper_setup() {
	$nprefix = 'digital-newspaper-';
	/*
	* Make theme available for translation.
	* Translations can be filed in the /languages/ directory.
	* If you're building a theme based on Digital Newspaper, use a find and replace
	* to change 'digital-newspaper' to the name of your theme in all the template files.
	*/
	load_theme_textdomain( 'digital-newspaper', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	* Let WordPress manage the document title.
	* By adding theme support, we declare that this theme does not use a
	* hard-coded <title> tag in the document head, and expect WordPress to
	* provide it for us.
	*/
	add_theme_support( 'title-tag' );

	/*
	* Enable support for Post Thumbnails on posts and pages.
	*
	* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	*/
	add_theme_support( 'post-thumbnails' );

	// add_image_size( 'digital-newspaper-large', 1400, 800, true );
	add_image_size( $nprefix . 'featured', 1020, 700, true );
	add_image_size( $nprefix . 'list', 600, 400, true );
	add_image_size( $nprefix . 'thumb', 300, 200, true );
	add_image_size( $nprefix . 'small', 150, 95, true );
	add_image_size( $nprefix . 'grid', 400, 250, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Top Header', 'digital-newspaper' ),
			'menu-2' => esc_html__( 'Main Header', 'digital-newspaper' ),
			'menu-3' => esc_html__( 'Bottom Footer', 'digital-newspaper' )
		)
	);

	/*
	* Switch default core markup for search form, comment form, and comments
	* to output valid HTML5.
	*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			DIGITAL_NEWSPAPER_VERSION . 'custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 100,
			'width'       => 100,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'digital_newspaper_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function digital_newspaper_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'digital_newspaper_content_width', 640 );
}
add_action( 'after_setup_theme', 'digital_newspaper_content_width', 0 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/admin/class-theme-info.php';

add_action( 'pre_get_posts', 'digital_newspaper_custom_get_posts' );
function digital_newspaper_custom_get_posts( $query ) {
	if( ! digital_newspaper_is_paged_filtered() ) return;
	if( isset( $_GET['posts'] ) ) {
		switch($_GET['posts']) {
			case 'random'	: $query->set( 'orderby', 'rand' );
							break;
			case 'today': $todayDate = getdate();
							$query->set( 'date_query', array(
								'year'  => $todayDate['year'],
								'month' => $todayDate['mon'],
								'day'   => $todayDate['mday'],
							));
						break;
			case 'this-week': $query->set( 'date_query', array(
									'year'  => date( 'Y' ),
									'week'  => date( 'W' )
								));
						break;
			case 'last-seven-days': $query->set( 'date_query', array(
										'after'  => '1 week ago'
									));
					break;
			case 'this-month': $todayDate = getdate();
								$query->set( 'date_query', array(
									'month' => $todayDate['mon']
								));
						break;
			case 'last-month': 
						$thisdate = getdate();
						if ($thisdate['mon'] != 1) :
							$lastmonth = $thisdate['mon'] - 1;
						else : 
							$lastmonth = 12;
						endif; 
						$thisyear = date('Y');
						if ($lastmonth != 12) :
							$thisyear = date('Y');
						else: 
							$thisyear = date('Y') - 1;
						endif;
							$query->set( 'date_query', array(
								'year'  => $thisyear,
								'month'  => $lastmonth
							));
						break;
			case 'last-week':
						$thisweek = date('W');
						if ($thisweek != 1) :
							$lastweek = $thisweek - 1;
						else : 
							$lastweek = 52;
						endif; 
						$thisyear = date('Y');
						if ($lastweek != 52) :
							$thisyear = date('Y');
						else: 
							$thisyear = date('Y') -1; 
						endif;
						$query->set( 'date_query', array(
							'year'  => $thisyear,
							'week'  => $lastweek
						));
				break;
			case 'this-year':
					$thisweek = date('W');
					if ($thisweek != 1) :
						$lastweek = $thisweek - 1;
					else : 
						$lastweek = 52;
					endif; 
					$thisyear = date('Y');
					if ($lastweek != 52) :
						$thisyear = date('Y');
					else: 
						$thisyear = date('Y') -1; 
					endif;
					$query->set( 'date_query', array(
						'year'  => $thisyear
					));
				break;
			default: return;
		}
	}
}
