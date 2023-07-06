<?php
class GSCUSL_custom_login_apply_option {

	function __construct() {
		$this->initialize_hooks();
	}

	public function gs_login_body_class($body_classes) {

		//$body_classes[] = $this->gscusl_cusl_get_option( 'gscusl-theme', 'gscusl_others', '' );
		$body_classes[] = get_option('gs_customize_presets_settings', 'gscusl_theme1');

		$form_animation_in = get_option('gs_form_animate');
		if ( !empty($form_animation_in) ) {
			$body_classes[] = 'gs-form-animated-in';
		}

		$form_position = get_option('gscusl-form-position', 'gscusl_cc');
		$body_classes[] = 'gscusl-formpos__' . $form_position;

		//$body_classes[] = $_GET['class']; // at browser for demo http://localhost/wp/plugin_pro/wp-login.php?class=something

		return $body_classes;
	}

	//-- Getting values from setting panel
	function gscusl_cusl_get_option($option, $section, $default = '') {

		$options = get_option($section);

		if (isset($options[$option])) {
			return $options[$option];
		}

		return $default;
	}

	function initialize_hooks() {

		add_filter('login_headertext', array($this, 'gs_custom_login_logo_url_title'));
		add_filter('login_headerurl', array($this, 'gs_custom_login_logo_url'));

		add_action('login_enqueue_scripts', array($this, 'gscusl_customize_login'));
		add_action('login_head', array($this, 'header_script'));
		// add_action('login_footer', array($this, 'footer_script'));
		//add_action( 'login_head', array($this, 'our_custom_login_page_style') );
		add_filter( 'wp_login_errors', array( $this, 'remove_error_messages_in_wp_customizer' ), 10, 2 );
		add_filter('login_body_class', array($this, 'gs_login_body_class'));
		add_action('customize_preview_init', array($this, 'gs_login_customizer_previewer_js'));
	}

	function gs_login_customizer_previewer_js() {

		wp_enqueue_style('gscustom-customizer-previewer-style', GSCUSL_FILES_URI .  '/inc/css/style-previewer.css', array(), GSCUSL_VERSION);

		wp_enqueue_script('gscustom-customizer-previewer-script', GSCUSL_FILES_URI .  '/inc/js/customizer-previewer.js', array('customize-preview'), GSCUSL_VERSION, true);
	}

	public function gscusl_customize_login() {

		
		// Logo Options
		$logo_url = get_option('gs_logo');
		$logo_width = get_option('gs_logo_width', 84);
		$logo_height = get_option('gs_logo_height', 84);
		$logo_hide	= get_option('gs_logo_hide', 0);
		$logo_hide	= $logo_hide == 1 ? 'none' : 'inherit';
		$logo_padding = get_option('gs_logo_padding');

		// Background Options
		$bg_img = get_option('gs_bg_image');
		$bg_color = get_option('gs_bg_color');
		$bg_repeat = get_option('gs_bg_repeat', 'no-repeat');
		$bg_position = get_option('gs_background_position', 'center');
		$bg_size = get_option('gs_bg_size', 'cover');
		$bg_img_hide = get_option('gs_back_hide');
		$bg_img_hide = ( $bg_img_hide ==1 ? 'none' : $bg_img);

		// Form Background Options
		$form_bg_img = get_option('gs_form_bg_image');
		$form_bg_img_position = get_option('gs_form_bg_position', 'center');
		$form_bg_img_repeat = get_option('gs_form_bg_repeat', 'no-repeat');
		$form_bg_img_size = get_option('gs_form_bg_size', 'cover');
		$form_bg_color = get_option('gs_form_bg_color');

		// Form Style Options
		$form_width = get_option('gs_form_width', 320);
		$form_height = get_option('gs_form_height');
		$form_padding = get_option('gs_form_padding');
		$font_size= get_option('gs_form_font_sizes');
		$form_animation_in = get_option('gs_form_animate');
		$form_border_color = get_option('gs_form_border_color', '#ffffff');
		$form_border_size = get_option('gs_form_border_thick', 0);
		$form_border_style = get_option('gs_form_border_style', 'solid');
		$form_border_radius = get_option('gs_form_border_radius', 0);

		// Form Fields Style Options
		$field_width = get_option('gs_field_width', 100);
		$field_margin = get_option('gs_field_margin', '2px 6px 16px 0px');
		$field_bg = get_option('gs_field_bg', '#FFF');
		$field_color = get_option('gs_field_color', '#333');
		$field_label = get_option('gs_field_label', '#777');
		$field_border_color = get_option('gs_field_border_color', '#fff');
		$field_border_size = get_option('gs_form_field_border_thick', 1);
		$field_border_style = get_option('gs_form_field_border_style', 'solid');

		// Button Style Options
		$button_color = get_option('gs_button_color', '#ffffff');
		$button_bg = get_option('gs_button_bg', '#2EA2CC');
		$button_border = get_option('gs_button_border', '#0074A2');
		$button_hover_color = get_option('gs_button_hover_color', '#ffffff');
		$button_hover_bg = get_option('gs_button_hover_bg', '#1E8CBE');
		$button_hover_border = get_option('gs_button_hover_border', '#0074A2');

		// Form Footer Options
		$other_color = get_option('gs_other_color', '#999');
		$other_color_hover = get_option('gs_other_color_hover', '#2EA2CC');
		$gs_footer_display = get_option('gs_footer_display_text');
	  	$gs_back_display = get_option('gs_back_display_text');

		// Other Options
		$other_css = get_option('gs_other_css');

		?>

		<style type="text/css">

			/* .login #backtoblog a, 
			.login #nav a, 
			.login h1 a {
				color: <?php // echo $nav_font_color; ?>;
			}
			.login #backtoblog a:hover, 
			.login #nav a:hover, 
			.login h1 a:hover {
				color: <?php // echo $nav_font_color_hover; ?>;
			} */

			body.login div#login h1 a {
			    <?php if( !empty($logo_padding)) : ?>
			        margin-bottom: <?php echo $logo_padding; ?>px ;
			    <?php endif; ?>
			}
			.login h1 a{
				padding-bottom:0px;
			}

		
			/*Theme One*/
			<?php if ( empty($bg_img)  ) : ?>
				.login.gscusl_theme1 {
					background-image: url(<?php echo GSCUSL_FILES_URI . '/inc/img/bg1.jpg'; ?>);
				}
			<?php endif; ?>
			.login.gscusl_theme1 div#login h1 a {
				<?php if (empty($logo_url)) : ?>
					background-image: url(<?php echo GSCUSL_FILES_URI . '/inc/img/t1logo.png'; ?>);
				<?php endif; ?>
					width: <?php echo $logo_width; ?>px;
					height: <?php echo $logo_height; ?>px;
					background-size: contain;
					background-position: center center;
			}
			
			.login.gscusl_theme1 #login form {
				background: rgba(255, 255, 255, 0.5);
				border: 1px solid #f1f1f1;
			}

			.login.gscusl_theme1 #login form .forgetmenot label {
				font-size: 13px;
				color: <?php echo $field_label; ?>;
			}

			.login.gscusl_theme1 #backtoblog a,
			.login.gscusl_theme1 #nav a,
			.login.gscusl_theme1 h1 a {
				color: #fff;
			}

			.login.gscusl_theme1 #nav {
				width: 49%;
				padding: 0;
				text-align: left;
			}

			.login.gscusl_theme1 #backtoblog {
				width: 49%;
				text-align: right;
				padding: 0;
			}

			body.login {
				background-size: <?php echo $bg_size; ?>;
				background-position: <?php echo $bg_position; ?>;
				background-repeat: <?php echo $bg_repeat; ?>;
				
				<?php if ( !empty($bg_img) ) : ?> background-image: <?php echo $bg_img_hide =='none'? "none":'url('. $bg_img. ')'?>; <?php endif; ?>
				<?php if ( !empty($bg_color) ) : ?> background-color: <?php echo $bg_color; ?>; <?php endif; ?>
			}
			
			<?php if (!empty($logo_url)) : ?>
				body.login div#login .gs-body-login h1 a {
					background-image: url(<?php echo $logo_url; ?>);
					width: <?php echo $logo_width; ?>px;
					height: <?php echo $logo_height; ?>px;
					background-size: cover;
					background-position: center center;
					overflow: hidden;
				}
			<?php endif; ?>
			
			body.login div#login .gs-body-login h1 a {
				display: <?php echo $logo_hide; ?>;
			}

			body.login #login {
				position: absolute;
				padding: 0;
			}
			#loginform{
				width: <?php echo $form_width; ?>px;
				min-height:<?php echo $form_height; ?>px; 
			}

			.gscusl-formpos__gscusl_tl div#login {
				top: 3%;
				left: 3%;
			}

			.gscusl-formpos__gscusl_tc div#login {
				top: 3%;
				-webkit-transform: translateX(-50%);
					-ms-transform: translateX(-50%);
						transform: translateX(-50%);
				left: 50%;
			}

			.gscusl-formpos__gscusl_tr div#login {
				top: 3%;
				right: 3%;
			}

			.gscusl-formpos__gscusl_cl div#login {
				top: 50%;
				-webkit-transform: translateY(-50%);
					-ms-transform: translateY(-50%);
						transform: translateY(-50%);
				left: 3%;
			}

			.gscusl-formpos__gscusl_cc div#login {
				-webkit-transform: translate(-50%, -50%);
					-ms-transform: translate(-50%, -50%);
						transform: translate(-50%, -50%);
				left: 50%;
				top: 50%;
			}

			.gscusl-formpos__gscusl_cr div#login {
				top: 50%;
				-webkit-transform: translateY(-50%);
					-ms-transform: translateY(-50%);
						transform: translateY(-50%);
				right: 3%;
			}

			.gscusl-formpos__gscusl_bl div#login {
				bottom: 6%;
				left: 3%;
			}

			.gscusl-formpos__gscusl_bc div#login {
				bottom: 6%;
				left: 50%;
				-webkit-transform: translateX(-50%);
					-ms-transform: translateX(-50%);
						transform: translateX(-50%);
			}

			.gscusl-formpos__gscusl_br div#login {
				bottom: 6%;
				right: 3%;
			}

			body.login #login .gs-body-login form#loginform {
				<?php if ( !empty($form_bg_img) ) : ?> background-image: url(<?php echo $form_bg_img; ?>); <?php endif; ?>
				<?php if ( !empty($form_bg_color) ) : ?> background-color: <?php echo $form_bg_color; ?>; <?php endif; ?>
				background-repeat: <?php echo $form_bg_img_repeat; ?>;
				background-position: <?php echo $form_bg_img_position; ?>;
				background-size: <?php echo $form_bg_img_size; ?>;
				<?php if ( !empty($form_padding) ) : ?> padding: <?php echo $form_padding; ?>; <?php endif; ?>
				border: <?php echo $form_border_size . 'px ' . $form_border_style . ' ' . $form_border_color; ?>;
				border-radius: <?php echo $form_border_radius; ?>px;
			}

			body.login .gs-body-login label {
				color: <?php echo $field_label; ?>;
				font-size: <?php echo $font_size;?>px;
			}

			body.login .gs-body-login form .input,
			body.login .gs-body-login form input[type=checkbox],
			body.login .gs-body-login input[type=text] {
				color: <?php echo $field_color; ?>;
			}

			body.login .gs-body-login #wp-submit {
				color: <?php echo $button_color; ?>;
				background: <?php echo $button_bg; ?>;
				border-color: <?php echo $button_border; ?>;
				text-shadow: none;
				outline: none;
				-webkit-transition: all .2s ease-in-out;
				transition: all .2s ease-in-out;
			}

			body.login .gs-body-login #wp-submit:hover {
				color: <?php echo $button_hover_color; ?>;
				background: <?php echo $button_hover_bg; ?>;
				border-color: <?php echo $button_hover_border; ?>;
			}


			body.login .gs-body-login form#loginform .input,
			body.login .gs-body-login form#loginform input[type="text"],
			body.login .gs-body-login form#loginform input[type="password"] {
				width: <?php echo $field_width; ?>%;
				margin: <?php echo $field_margin; ?>;
				background: <?php echo $field_bg; ?>;
				border: <?php echo $field_border_size .'px '. $field_border_style .' '. $field_border_color; ?>;
			}

			body.login #login .gs-body-login #backtoblog a,
			body.login #login .gs-body-login #nav a {
				color: <?php echo $other_color; ?>;
				font-size: <?php echo $font_size;?>px;
			}

			body.login #login .gs-body-login #backtoblog a:hover,
			body.login #login .gs-body-login #nav a:hover,
			body.login .gs-body-login h1 a:hover {
				color: <?php echo $other_color_hover; ?>;
			}

			.login #backtoblog{
				<?php if( !empty($gs_back_display)) : ?>
			      display: <?php echo $gs_back_display; ?> ;
			  	<?php endif; ?>
			}
			.login #nav{
				<?php if( !empty($gs_footer_display)) : ?>
			      display: <?php echo $gs_footer_display; ?> ;
			  	<?php endif; ?>
				
			}
			

			<?php if (!empty($other_css)) : ?>
				<?php echo $other_css; ?>
			<?php endif; ?>
			/*options value output*/

		</style>

		<?php


		// Theme one

		wp_enqueue_style('animate', GSCUSL_FILES_URI . '/inc/css/animate.css');
		wp_enqueue_style('font-awesome', GSCUSL_FILES_URI . '/inc/css/font-awesome.min.css');
		wp_enqueue_script('custom-js', GSCUSL_FILES_URI . '/inc/js/gs_custom_login.js', array('jquery'), false);
		wp_localize_script('custom-js', 'gs_object', array('theme' => $form_animation_in));
	}

	public function gs_custom_login_logo_url_title() {
		$gs_logo_title = get_option('gs_logo_title');
		if (!empty($gs_logo_title)) {
			return $gs_logo_title;
		}
	}

	public function gs_custom_login_logo_url() {
		$gs_logo_url = get_option('gs_logo_url');
		if (!empty($gs_logo_url)) {
			return $gs_logo_url;
		} else {
			return home_url();
		}
	}

	public function header_script() {
		$gscusl_login_icons = get_option( 'gscusl-login-icons');
		?>
		<style>
			#loginform p {
				position: relative;
			}

			.gs-body-login {
				opacity: 0;
			}
			
			.gs-icons {
			    background-color: transparent;
			    bottom: 3px;
				<?php if($gscusl_login_icons == 'block'): ?>
			    	display: inline-block;
				<?php else: ?>
					display: none;
				<?php endif; ?>
			    font-size: 20px;
			    font-weight: normal;
			    height: 15px;
			    left: 6px;
			    line-height: 20px;
			    min-width: 16px;
			    padding: 4px 5px;
			    position: absolute;
			    text-align: center;
			    text-shadow: 0 1px 0 #ffffff;
			    top: 37%;
			    width: 15px;
			    z-index: 3;
			}
			body.login div#login form .input, .login input[type="text"] {
			    padding: 0px 0px 0px 45px;
			}
			.user-pass-wrap .gs-icons { top: 11%; }
		</style>
		<script>
			jQuery(document).ready(function($){
				$( "#user_login" ).before('<div class="gs-icons"><i class="fa fa-user"></i></div>');
				$( "#user_pass" ).before('<div class="gs-icons"><i class="fa fa-unlock-alt"></i></div>');
			})
		</script>
		<?php
	}

	function remove_error_messages_in_wp_customizer( $errors, $redirect_to ) {

		if ( is_customize_preview() && version_compare( $GLOBALS['wp_version'], '5.2', '>=' ) ) {
		  return new WP_Error( '', '' );
		}
		return $errors;
	  }

}