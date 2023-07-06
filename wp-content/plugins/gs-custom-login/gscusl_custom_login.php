<?php
/**
 *
 * @package   GS_Custom_Login
 * @author    GS Plugins <hello@gsplugins.com>
 * @license   GPL-2.0+
 * @link      https://www.gsplugins.com
 * @copyright 2015 GS Plugins
 *
 * @wordpress-plugin
 * Plugin Name:			GS Custom Login Lite
 * Plugin URI:			https://www.gsplugins.com/wordpress-plugins
 * Description:       	A simple, lightweight Plugin to Customize Your WordPress Login Screen Amazingly. 
 * Version:           	1.3.5
 * Author:       		GS Plugins
 * Author URI:       	https://www.gsplugins.com
 * Text Domain:       	gsCS
 * License:           	GPL-2.0+
 * License URI:       	http://www.gnu.org/licenses/gpl-2.0.txt
 */

if (!defined('GSCUSL_HACK_MSG')) define('GSCUSL_HACK_MSG', __('Sorry cowboy! This is not your place', 'gscusl'));

/**
 * Protect direct access
 */
if (!defined('ABSPATH')) die(GSCUSL_HACK_MSG);

/**
 * Defining constants
 */
if (!defined('GSCUSL_VERSION')) define('GSCUSL_VERSION', '1.3.5');
if (!defined('GSCUSL_MENU_POSITION')) define('GSCUSL_MENU_POSITION', 31);
if (!defined('GSCUSL_PLUGIN_DIR')) define('GSCUSL_PLUGIN_DIR', plugin_dir_path(__FILE__));
if (!defined('GSCUSL_PLUGIN_URI')) define('GSCUSL_PLUGIN_URI', plugins_url('', __FILE__));
if (!defined('GSCUSL_FILES_DIR')) define('GSCUSL_FILES_DIR', GSCUSL_PLUGIN_DIR . 'gscusl_assets');
if (!defined('GSCUSL_FILES_URI')) define('GSCUSL_FILES_URI', GSCUSL_PLUGIN_URI . '/gscusl_assets');

require_once GSCUSL_FILES_DIR . '/gs-plugins/gs-plugins.php';
require_once GSCUSL_FILES_DIR . '/inc/gscusl_functions.php';
require_once GSCUSL_FILES_DIR . '/gs-plugins/gs-plugins-free.php';
new GSCUSL_custom_login_apply_option();

// -- Admin css
function gs_cust_login_enque_admin_style() {
    $media = 'all';
    // wp_register_style( 'gscusl_custom_admin_style', GSCUSL_FILES_URI . '/admin/css/gscusl_custom_style.css', '', GSCUSL_VERSION, $media );
    // wp_enqueue_style( 'gscusl_custom_admin_style' );
    wp_register_style( 'gscusl_custom_login_free', GSCUSL_FILES_URI . '/admin/css/gs_free_plugins.css', '', GSCUSL_VERSION, $media );
    wp_enqueue_style( 'gscusl_custom_login_free' );
}
add_action( 'admin_enqueue_scripts', 'gs_cust_login_enque_admin_style' );


if (!function_exists('gs_cust_login_pro_link')) {
    function gs_cust_login_pro_link($gsCustLogin_links) {
        $gsCustLogin_links[] = '<a class="gs-pro-link" href="https://www.gsplugins.com/product/gs-custom-login" target="_blank">Go Pro!</a>';
        $gsCustLogin_links[] = '<a href="https://www.gsplugins.com/wordpress-plugins" target="_blank">GS Plugins</a>';
        $gsCustLogin_links[] = '<a href="' . admin_url( 'admin.php?page=gsp-customizar' ) . '" >Customize</a>';
        return $gsCustLogin_links;
    }
    add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'gs_cust_login_pro_link');
    
}

/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_gs_custom_login() {

    if ( ! class_exists( 'Appsero\Client' ) ) {
      require_once GSCUSL_FILES_DIR . '/appsero/src/Client.php';
    }

    $client = new Appsero\Client( 'fa821025-7a13-4792-8495-a2e89ab303e3', 'GS Custom Login', __FILE__ );

    // Active insights
    $client->insights()->init();

}

appsero_init_tracker_gs_custom_login();

if ( ! function_exists('gs_row_meta') ) {
    function gs_row_meta( $meta_fields, $file ) {
  
      if ( $file != 'gs-custom-login/gscusl_custom_login.php' ) {
          return $meta_fields;
      }
    
        echo "<style>.gslogin-rate-stars { display: inline-block; color: #ffb900; position: relative; top: 3px; }.gslogin-rate-stars svg{ fill:#ffb900; } .gslogin-rate-stars svg:hover{ fill:#ffb900 } .gslogin-rate-stars svg:hover ~ svg{ fill:none; } </style>";
  
        $plugin_rate   = "https://wordpress.org/support/plugin/gs-custom-login/reviews/?rate=5#new-post";
        $plugin_filter = "https://wordpress.org/support/plugin/gs-custom-login/reviews/?filter=5";
        $svg_xmlns     = "https://www.w3.org/2000/svg";
        $svg_icon      = '';
  
        for ( $i = 0; $i < 5; $i++ ) {
          $svg_icon .= "<svg xmlns='" . esc_url( $svg_xmlns ) . "' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>";
        }
  
        // Set icon for thumbsup.
        $meta_fields[] = '<a href="' . esc_url( $plugin_filter ) . '" target="_blank"><span class="dashicons dashicons-thumbs-up"></span>' . __( 'Vote!', 'gscs' ) . '</a>';
  
        // Set icon for 5-star reviews. v1.1.22
        $meta_fields[] = "<a href='" . esc_url( $plugin_rate ) . "' target='_blank' title='" . esc_html__( 'Rate', 'gscs' ) . "'><i class='gslogin-rate-stars'>" . $svg_icon . "</i></a>";
  
        return $meta_fields;
    }
    add_filter( 'plugin_row_meta','gs_row_meta', 10, 2 );
  }


function gs_customize_register($wp_customize) {

    if (class_exists('WP_Customize_Control')) {

        class gscustom_login_Presets extends WP_Customize_Control {

            public $type = 'checkbox-multiple';

            public function enqueue() {
                // wp_enqueue_script( 'jt-customize-controls', plugins_url(  '/customize-controls.js' , __FILE__  ), array( 'jquery' ) );
                // wp_enqueue_script( 'jquery-ui-button' );
            }
       
            public function render_content() {

                if ( empty($this->choices) ) return;

                $name = 'gscustom_login_preset-' . $this->id; ?>

                <span class="customize-control-title">
                    <?php echo esc_attr($this->label); ?>
                    <?php if (!empty($this->description)) : ?>
                        <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                    <?php endif; ?>
                </span>

                <?php // $multi_values = !is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>

                <div id="input_<?php echo $this->id; ?>" class="image">

                <?php foreach ( $this->choices as $val ) : ?>
                    <?php $_disbaled = isset( $val['pro'] ) ? 'disabled' : ''; ?>
                    <?php $_disbaled_link = isset( $val['link'] ) ? 'disabled' : ''; ?>
                    <?php $disable_for_pro = $_disbaled == 'disabled'  ? $_disbaled : $_disbaled_link; ?>
                    <div class="gscustom_login_thumbnail">
                    <input <?php echo $disable_for_pro; ?> class="image-select" type="radio" value="<?php echo esc_attr( $val['id'] ); ?>" id="<?php echo $this->id . $val['id']; ?>" name="<?php echo esc_attr( $name ); ?>" <?php  checked( $this->value(), $val['id'] ); ?> />
                    <label for="<?php echo $this->id . $val['id']; ?>">
                        <div class="gscustom_login_thumbnail_img">
                        <img src="<?php echo $val['thumbnail']; ?>" alt="<?php echo esc_attr( $val['name'] ); ?>" title="<?php echo esc_attr( $val['name'] ); ?>">
                        </div> <!--  .img -->
                        <h3><?php echo $val['name'] ?></h3>
                    </label>
                    <?php if ( isset( $val['pro'] ) ) : ?>
                        <a href="https://www.gsplugins.com/product/gs-custom-login" target="_blank" class="no-available">
                        <span><?php _e( 'Upgrade to Pro', 'gscustom_login' ); ?></span>
                        </a>
                    <?php elseif ( isset( $val['link'] ) ) : ?>
                        <a href="https://www.gsplugins.com/contact" class="no-available" target="_blank">
                        <span><?php _e( 'Contact for Custom Design', 'gscustom_login' ); ?></span>
                        </a>
                    <?php endif; ?>
                            <!-- </input> -->
                        </div> <!--  .gscustom_login_thumbnail -->

                <?php endforeach; ?>
                </div>

                <input name='presets_hidden' type="hidden" <?php $this->link(); ?> value="<?php echo  $this->value(); ?>" />
                <?php
            }

        }

        class Gs_Customizer_Range_Value_Control extends WP_Customize_Control {

            public $type = 'range-input';

            public function enqueue() {
                wp_enqueue_script('customizer-range-value-control', GSCUSL_FILES_URI . '/inc/js/customizer-range-value-control.js', array('jquery'), rand(), true);
                wp_enqueue_style('customizer-range-value-control', GSCUSL_FILES_URI . '/inc/css/customizer-range-value-control.css', array(), rand());
            }

            public function render_content() {
                ?>
                <label>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                    <div class="range-slider" style="width:100%; display:flex;flex-direction: row;justify-content: flex-start;">
                        <span style="width:100%; flex: 1 0 0; vertical-align: middle;">
                            <input class="range-slider__range" type="range" value="<?php echo esc_attr($this->value()); ?>"<?php $this->input_attrs(); $this->link(); ?> >
                            <span class="range-slider__value">0</span>
                        </span>
                    </div>
                    <?php if (!empty($this->description)) : ?>
                        <span class="description customize-control-description"><?php echo $this->description; ?></span>
                    <?php endif; ?>
                </label>
                <?php
            }

        }
        class GScustom_Login_Promo extends WP_Customize_Control {


            public $type = 'promotion';
          
            public $thumbnail;
          
            public $promo_text;
        
            public $link;
        
            public function enqueue() {
              // wp_enqueue_script( 'jt-customize-controls', plugins_url(  '/customize-controls.js' , __FILE__  ), array( 'jquery' ) );
              // wp_enqueue_script( 'jquery-ui-button' );
            }
          
        
            public function render_content() {
              ?>
          
              <span class="customize-control-title">
                <?php echo esc_attr( $this->label ); ?>
                <?php if ( ! empty( $this->description ) ) : ?>
                  <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <?php endif; ?>
              </span>
              <div id="input_<?php echo $this->id; ?>" class="image">
                <div class="gscustom_login_promo_thumbnail">
                <a href="<?php echo esc_url( $this->link );?>" target="_blank">
                    <div class="customizer-promo-overlay">
                    <span class="customizer-promo-text"><?php echo esc_html( $this->promo_text ); ?></span>
                    </div>
                    <img src="<?php echo esc_url( $this->thumbnail ); ?>" alt="<?php echo esc_attr( $this->id ); ?>" title="<?php echo esc_attr( $this->id ); ?>">
                </a>
                </div> 
          
              </div>
          
            <?php }
        }

    }

    $wp_customize->add_panel( 'gs_panel', array(
        'priority'       => 30,
        'capability'     => 'edit_theme_options',
        'title'          => __('GS Custom Login Lite', 'gscs'),
        'description'    => __('This section allows you to customize the login page of your website.<br/>Login Customizer by <a target="_blank" rel="nofollow" href="https://www.gsplugins.com">GS Plugins</a>', 'gscs'),
    ));

    $wp_customize->add_section( 'gs_customize_presets', array(
        'title'           => __( 'Themes', 'gscustom_login' ),
        'description'     => __( 'Choose Theme', 'gscustom_login' ),
        'priority'        => 5,
        'panel'           => 'gs_panel',
      ) );

      $wp_customize->add_setting( 'gs_customize_presets_settings', array(
        'default'       => 'gscusl_theme1',
        'type'          => 'option',
        'capability'    => 'edit_theme_options',
      ) );

      $gscustom_login_free_templates  = array();
      $gscustom_login_theme_name = array( "", "",
        __( 'Theme - Two',       'gscustom_login' ),
        __( 'Theme - Three',     'gscustom_login' ),
        __( 'Theme - Four',      'gscustom_login' ),
        __( 'Theme - Five',      'gscustom_login' ),
        __( 'Theme - Six',       'gscustom_login' ),
        __( 'Theme - Seven',     'gscustom_login' ),
       );

      // 1st template that is default
      $gscustom_login_free_templates["gscusl_theme1" ] = array(
        'img'       =>GSCUSL_FILES_URI . '/inc/img/bg1.jpg',
        'thumbnail' =>GSCUSL_FILES_URI . '/inc/img/thumb1.jpg',
        'id'        => 'gscusl_theme1',
        'name'      => 'Theme - One'
      ) ;

      // Loof through the templates.
      $_count = 2;
      while ( $_count <= 6 ) :

        $gscustom_login_free_templates["gscusl_theme{$_count}" ] = array(
          // 'img'       => plugins_url( 'img/bg.jpg', gscustom_login_ROOT_FILE ),
          'thumbnail' => GSCUSL_FILES_URI . '/inc/img/thumb'.$_count.'.jpg',
          'id'        => "gscusl_theme{$_count}",
          // 'id'        => "Theme - {$_count}",
          'name'      => $gscustom_login_theme_name[$_count],
          'pro'       => 'yes'
        );
        $_count++;
      endwhile;

      // 18th template for custom design.
      $gscustom_login_free_templates["default18" ] = array(
          'img'       => GSCUSL_FILES_URI . '/inc/img/bg17.jpg',
          'thumbnail' => GSCUSL_FILES_URI . '/inc/img/custom-design.png',
          'id'        => 'default18',
          'name'      => __( 'Custom Design', 'gscustom_login' ),
          'link'      => 'yes'
        );
      $gscustom_login_templates = apply_filters( 'gscustom_login_pro_add_template', $gscustom_login_free_templates );

      $wp_customize->add_control( new gscustom_login_Presets( $wp_customize, 'gs_customize_presets_settings',
      array(
        'section' => 'gs_customize_presets',
        // 'label'   => __( 'Themes', 'gscustom_login' ),
        'choices' => $gscustom_login_templates
      ) ) );
     //End of Presets.

    $wp_customize->add_section('gs_logo_section', array(
        'priority' => 5,
        'title' => __('Logo', 'gscs'),
        'panel'  => 'gs_panel',
    ));

    $wp_customize->add_section('gs_background_section', array(
        'priority' => 10,
        'title' => __('Background', 'gscs'),
        'panel'  => 'gs_panel',
    ));

    $wp_customize->add_section('gs_form_bg_section', array(
        'priority' => 15,
        'title' => __('Form Background', 'gscs'),
        'panel'  => 'gs_panel',
    ));

    $wp_customize->add_section('gs_form_section', array(
        'priority' => 20,
        'title' => __('Form Styling', 'gscs'),
        'panel'  => 'gs_panel',
    ));

    $wp_customize->add_section('gs_field_section', array(
        'priority' => 25,
        'title' => __('Fields Styling', 'gscs'),
        'panel'  => 'gs_panel',
    ));

    $wp_customize->add_section('gs_button_section', array(
        'priority' => 30,
        'title' => __('Button Styling', 'gscs'),
        'panel'  => 'gs_panel',
    ));

    $wp_customize->add_section('gs_form_footer_section', array(
        'priority' => 35,
        'title' => __('Form Footer', 'gscs'),
        'panel'  => 'gs_panel',
    ));
    $wp_customize->add_section('gs_error_section', array(
        'priority' => 40,
        'title' => __('Error Section', 'gscs'),
        'panel'  => 'gs_panel',
    ));
    $wp_customize->add_section('gs_other_section', array(
        'priority' => 45,
        'title' => __('Other', 'gscs'),
        'panel'  => 'gs_panel',
    ));

     $wp_customize->add_section('gs_customizer_social_section', array(
        'priority' => 47,
        'title' => __('Social Settings', 'gscs'),
        'panel'  => 'gs_panel',
    ));

    // logo settings

    $wp_customize->add_setting('gs_logo', array(
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'  => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'gs_logo', array(
        'label' => __('Login Logo', 'gscs'),
        'section' => 'gs_logo_section',
        'priority' => 5,
        'settings' => 'gs_logo'
    )));

    $wp_customize->add_setting('gs_logo_width', array(
        'default'           => '84',
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ));

    $wp_customize->add_control( new Gs_Customizer_Range_Value_Control( $wp_customize, 'gs_logo_width', array(
        'type'                => 'range-value',
        'section'             => 'gs_logo_section',
        'settings'            => 'gs_logo_width',
        'label'               => __( 'Logo Width' , 'gscs'),
        'input_attrs'         => array(
          'min'                 => 10,
          'max'                 => 1000,
          'step'                => 1,
          //'suffix' => 'px',
      ),
    ) ) );
    $wp_customize->add_setting('gs_logo_height', array(
        'default'           => '84',
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ));

    $wp_customize->add_control( new Gs_Customizer_Range_Value_Control( $wp_customize, 'gs_logo_height', array(
        'type'                => 'range-value',
        'section'             => 'gs_logo_section',
        'settings'            => 'gs_logo_height',
        'label'               => __('Logo Height', 'gscs'),
        'input_attrs'         => array(
          'min'                 => 10,
          'max'                 => 1000,
          'step'                => 1,
          //'suffix' => 'px',
      ),
    ) ) );
    $wp_customize->add_setting('gs_logo_padding', array(
        'default'           => '5',
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ));

    $wp_customize->add_control( new Gs_Customizer_Range_Value_Control( $wp_customize, 'gs_logo_padding', array(
        'type'                => 'range-value',
        'section'             => 'gs_logo_section',
        'settings'            => 'gs_logo_padding',
        'label'               => __('Bottom Spacing', 'gscs'),
        'input_attrs'         => array(
          'min'                 => 1,
          'max'                 => 500,
          'step'                => 1,
          //'suffix' => 'px',
      ),
    ) ) );

    $wp_customize->add_setting('gs_logo_title', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'  => 'postMessage'
    ));

    $wp_customize->add_control('gs_logo_title', array(
        'label' => __('Logo Title', 'gscs'),
        'section' => 'gs_logo_section',
        'priority' => 21,
        'settings' => 'gs_logo_title'
    ));
    $wp_customize->add_setting('gs_logo_url', array(
        'default' => '',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'  => 'postMessage'
    ));

    $wp_customize->add_control('gs_logo_url', array(
        'label' => __('Logo URL', 'gscs'),
        'section' => 'gs_logo_section',
        'type'   =>'url',
        'priority' => 22,
        'settings' => 'gs_logo_url'
    ));

   $wp_customize->add_setting( 'gs_logo_hide', array(
        'default' => 0,
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'  => 'postMessage'
    ) );

    $wp_customize->add_control( 'gs_logo_hide', array(
        'type'                => 'checkbox',
        'section'             => 'gs_logo_section', // Add a default or your own section
        'priority'            => 23,
        'label'               => __( 'Hide logo' ),
        'description'         => __( 'Do you want to hide default logo?' ),
        'settings'            => 'gs_logo_hide'
    ) );

    // background settings
    
    $wp_customize->add_setting('gs_bg_image', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'gs_bg_image', array(
        'label'             => __('Background Image', 'gscs'),
        'section'           => 'gs_background_section',
        'priority'          => 5,
        'settings'          => 'gs_bg_image'
    )));

    $wp_customize->add_setting( 'gs_back_hide', array(
        'default'           => 0,
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ) );

    $wp_customize->add_control( 'gs_back_hide', array(
        'type'                => 'checkbox',
        'section'             => 'gs_background_section', // Add a default or your own section
        'priority'            => 10,
        'label'               => __( 'Hide Background Image' ),
        'settings'            => 'gs_back_hide'
    ) );

    $wp_customize->add_setting('gs_bg_color', array(
        'default'           => '#F1F1F1',
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_bg_color', array(
        'label'             => __('Background Color', 'gscs'),
        'section'           => 'gs_background_section',
        'priority'          => 10,
        'settings'          => 'gs_bg_color'
    )));

    $wp_customize->add_setting( 'gs_bg_repeat', array(
        'default'             => 'no-repeat',
        'type'                => 'option',
        'capability'          => 'edit_theme_options',
        'transport'           => 'postMessage'
    ) );

    $wp_customize->add_control( 'gs_bg_repeat', array(
        'label'               => __( 'Background Repeat:', 'gscs' ),
        'section'             => 'gs_background_section',
        'priority'            => 15,
        'settings'            => 'gs_bg_repeat',
        'type'                => 'radio',
        'choices'             => array(
        'repeat'              => 'Repeat',
        'repeat-x'            => 'Repeat-x',
        'repeat-y'            => 'Repeat-y',
        'no-repeat'           => 'No-repeat',
        'initial'             => 'Initial',
        'inherit'             => 'Inherit',
      ),
    ) );


    $wp_customize->add_setting( 'gs_background_position', array(
        'default'             => 'center',
        'type'                => 'option',
        'capability'          => 'manage_options',
        'transport'           => 'postMessage'
    ) );
    $wp_customize->add_control( 'gs_background_position', array(
        'settings'            => 'gs_background_position',
        'label'               => __( 'Select Position:', 'gscs' ),
        'section'             => 'gs_background_section',
        'priority'            => 20,
        'type'                => 'select',
        'choices'             => array(
          'left top'            => 'Left top',
          'left center'         => 'Left center',
          'left bottom'         => 'Left bottom',
          'right top'           => 'Right top',
          'right center'        => 'Right center',
          'right bottom'        => 'Right bottom',
          'center top'          => 'Center top',
          'center'              => 'Center',
          'center bottom'       => 'Center bottom',
      ),
    ) );

    $wp_customize->add_setting('gs_bg_size', array(
        'type'              => 'option',
        'default'           => 'cover',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ));

    $wp_customize->add_control('gs_bg_size', array(
        'label'             => __('Background Size', 'gscs'),
        'section'           => 'gs_background_section',
        'priority'          => 25,
        'settings'          => 'gs_bg_size',
        'type'              => 'select',
        'choices'             => array(
            'auto'            => 'Auto',
            'cover'           => 'Cover',
            'contain'         => 'Contain',
            'initial'         => 'Initial',
            'inherit'         => 'Inherit',
          ),
    ));

    $wp_customize->add_setting('gs_form_bg_image', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'gs_form_bg_image', array(
        'label'             => __('Background Image', 'gscs'),
        'section'           => 'gs_form_bg_section',
        'priority'          => 5,
        'settings'          => 'gs_form_bg_image'
    )));

    $wp_customize->add_setting('gs_form_bg_color', array(
        'default'           => '#FFF',
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_form_bg_color', array(
        'label'             => __('Background Color', 'gscs'),
        'section'           => 'gs_form_bg_section',
        'priority'          => 10,
        'settings'          => 'gs_form_bg_color'
    )));

    $wp_customize->add_setting( 'gs_form_bg_repeat', array(
        'default'             => 'no-repeat',
        'type'                => 'option',
        'capability'          => 'edit_theme_options',
        'transport'           => 'postMessage'
    ) );

    $wp_customize->add_control( 'gs_form_bg_repeat', array(
        'label'               => __( 'Background Repeat:', 'gscs' ),
        'section'             => 'gs_form_bg_section',
        'priority'            => 15,
        'settings'            => 'gs_form_bg_repeat',
        'type'                => 'radio',
        'choices'             => array(
          'repeat'              => 'Repeat',
          'repeat-x'            => 'Repeat-x',
          'repeat-y'            => 'Repeat-y',
          'no-repeat'           => 'No-repeat',
          'initial'             => 'Initial',
          'inherit'             => 'Inherit',
      ),
    ) );

    $wp_customize->add_setting( 'gs_form_bg_position', array(
        'default'             => 'center',
        'type'                => 'option',
        'capability'          => 'manage_options',
        'transport'           => 'postMessage'
    ) );
    $wp_customize->add_control( 'gs_form_bg_position', array(
        'settings'            => 'gs_form_bg_position',
        'label'               => __( 'Select Position:', 'gscs' ),
        'section'             => 'gs_form_bg_section',
        'priority'            => 20,
        'type'                => 'select',
        'choices'             => array(
          'left top'            => 'Left Top',
          'left center'         => 'Left Center',
          'left bottom'         => 'Left Bottom',
          'right top'           => 'Right Top',
          'right center'        => 'Right Center',
          'right bottom'        => 'Right Bottom',
          'center top'          => 'Center Top',
          'center'              => 'Center',
          'center bottom'       => 'Center Bottom',
      ),
    ) );

    $wp_customize->add_setting('gs_form_bg_size', array(
        'type'              => 'option',
        'default'           => 'cover',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ));

    $wp_customize->add_control('gs_form_bg_size', array(
        'label'             => __('Background Size', 'gscs'),
        'section'           => 'gs_form_bg_section',
        'priority'          => 25,
        'settings'          => 'gs_form_bg_size',
        'type'              => 'select',
        'choices'           => array(
          'auto'              => 'Auto',
          'cover'             => 'Cover',
          'contain'           => 'Contain',
          'initial'           => 'Initial',
          'inherit'           => 'Inherit',
        ),
    ));

    // form style
    // 
    
    $wp_customize->add_setting('gs_form_width', array(
        'default'           => '320',
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ));

    $wp_customize->add_control( new Gs_Customizer_Range_Value_Control( $wp_customize, 'gs_form_width', array(
        'type'                => 'range-value',
        'section'             => 'gs_form_section',
        'settings'            => 'gs_form_width',
        'label'               => __( 'Width' ),
        'input_attrs'         => array(
          'min'                 => 200,
          'max'                 => 1000,
          'step'                => 1,
          //'suffix' => 'px',
      ),
  ) ) );

    $wp_customize->add_setting('gs_form_height', array(
        // 'default' => '194',
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ));

    $wp_customize->add_control( new Gs_Customizer_Range_Value_Control( $wp_customize, 'gs_form_height', array(
        'type'              => 'range-value',
        'section'           => 'gs_form_section',
        'settings'          => 'gs_form_height',
        'label'             => __( 'Height' ),
        'priority'          => 16,
        'input_attrs'       => array(
          'min'               => 200,
          'max'               => 1000,
          'step'              => 1,
          //'suffix'          => 'px',
        ),
    ) ) );

    $wp_customize->add_setting('gs_form_padding', array(
        'default'           => '26px 24px 46px',
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ));

    $wp_customize->add_control('gs_form_padding', array(
        'label'             => __('Padding', 'gscs'),
        'section'           => 'gs_form_section',
        'priority'          => 25,
        'settings'          => 'gs_form_padding'
    ));



    $wp_customize->add_setting('gs_form_animate', array(
        'type'              => 'option',
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'transport'         => 'refresh'
    ));

    $wp_customize->add_control('gs_form_animate', array(
        'label'             => __('Form Animation', 'gscs'),
        'section'           => 'gs_form_section',
        'priority'          => 31,
        'settings'          => 'gs_form_animate',
        'type'              => 'select',
        'choices'           => array(
          ''                  => __('No Animation', 'gscusl'),
          'bounce'            => __('Bounce', 'gscusl'),
          'flash'             => __('Flash', 'gscusl'),
          'pulse'             => __('Pulse', 'gscusl'),
          'rubberBand'        => __('RubberBand', 'gscusl'),
          'shake'             => __('Shake', 'gscusl'),
          'swing'             => __('Swing', 'gscusl'),
          'tada'              => __('Tada', 'gscusl'),
          'wobble'            => __('Wobble', 'gscusl'),
          'jello'             => __('Jello', 'gscusl'),
          'bounceIn'          => __('BounceIn', 'gscusl'),
          'bounceInDown'      => __('BounceInDown', 'gscusl'),
          'bounceInLeft'      => __('BounceInLeft', 'gscusl'),
          'bounceInRight'     => __('BounceInRight', 'gscusl'),
          'bounceInUp'        => __('BounceInUp', 'gscusl'),
          'fadeIn'            => __('BadeIn', 'gscusl'),
          'fadeInDown'        => __('FadeInDown', 'gscusl'),
          'fadeInDownBig'     => __('FadeInDownBig', 'gscusl'),
          'fadeInLeft'        => __('FadeInLeft', 'gscusl'),
          'fadeInLeftBig'     => __('FadeInLeftBig', 'gscusl'),
          'fadeInRight'       => __('FadeInRight', 'gscusl'),
          'fadeInRightBig'    => __('FadeInRightBig', 'gscusl'),
          'fadeInUp'          => __('FadeInUp', 'gscusl'),
          'fadeInUpBig'       => __('FadeInUpBig', 'gscusl'),
          'flipInX'           => __('FlipInX', 'gscusl'),
          'flipInY'           => __('FlipInY', 'gscusl'),
          'lightSpeedIn'      => __('LightSpeedIn', 'gscusl'),
          'rotateIn'          => __('RotateIn', 'gscusl'),
          'rotateInDownLeft'  => __('RotateInDownLeft', 'gscusl'),
          'rotateInDownRight' => __('RotateInDownRight', 'gscusl'),
          'rotateInUpLeft'    => __('RotateInUpLeft', 'gscusl'),
          'rotateInUpRight'   => __('RotateInUpRight', 'gscusl'),
          'hinge'             => __('Hinge', 'gscusl'),
          'rollIn'            => __('RollIn', 'gscusl'),
          'zoomIn'            => __('ZoomIn', 'gscusl'),
          'zoomInDown'        => __('ZoomInDown', 'gscusl'),
          'zoomInLeft'        => __('ZoomInLeft', 'gscusl'),
          'zoomInRight'       => __('ZoomInRight', 'gscusl'),
          'zoomInUp'          => __('ZoomInUp', 'gscusl'),
          'slideInDown'       => __('SlideInDown', 'gscusl'),
          'slideInLeft'       => __('SlideInLeft', 'gscusl'),
          'slideInRight'      => __('SlideInRight', 'gscusl'),
          'slideInUp'         => __('SlideInUp', 'gscusl'),
        ),
    ));
    $wp_customize->add_setting('gs_form_border_color', array(
        'default'           => '#FFF',
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_form_border_color', array(
        'label'             => __('Form Border Color', 'gscs'),
        'section'           => 'gs_form_section',
        'priority'          => 32,
        'settings'          => 'gs_form_border_color'
    )));

    $wp_customize->add_setting('gs_form_border_thick', array(
        'default'           => 2,
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ));

    $wp_customize->add_control( new Gs_Customizer_Range_Value_Control( $wp_customize, 'gs_form_border_thick', array(
        'type'                  => 'range-value',
        'section'               => 'gs_form_section',
        'settings'              => 'gs_form_border_thick',
        'label'                 => __( 'Form Border Thickness' ),
        'priority'              => 33,
        'input_attrs'           => array(
            'min'                 => 0,
            'max'                 => 10,
            'step'                => 1,
            //'suffix'              => 'px',
          ),
    ) ) );
    $wp_customize->add_setting('gs_form_border_style', array(
        'type'              => 'option',
        'default'           => 'none',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage'
    ));

    $wp_customize->add_control('gs_form_border_style', array(
        'label'             => __('Form Border Style', 'gscs'),
        'section'           => 'gs_form_section',
        'priority'          => 34,
        'settings'          => 'gs_form_border_style',
        'type'              => 'select',
        'choices'           => array(
          'none'              => 'None',
          'dotted'            => 'Dotted',
          'dashed'            => 'Dashed',
          'solid'             => 'Solid',
          'double'            => 'Double',
          'groove'            => 'Groove',
          'ridge'             => 'Ridge',
          'inset'             => 'Inset',
          'outset'            => 'Outset',
          'hidden'            => 'Hidden',
        ),
    ));

    $wp_customize->add_setting('gs_form_border_radius', array(
        'default'         => 0,
        'type'            => 'option',
        'capability'      => 'edit_theme_options',
        'transport'       => 'postMessage'
    ));

    $wp_customize->add_control( new Gs_Customizer_Range_Value_Control( $wp_customize, 'gs_form_border_radius', array(
        'type'            => 'range-value',
        'section'         => 'gs_form_section',
        'settings'        => 'gs_form_border_radius',
        'label'           => __( 'Form Border Radius' ),
        'priority'        => 35,
        'input_attrs'     => array(
          'min'             => 0,
          'max'             => 200,
          'step'            => 1,
          //'suffix'        => 'px',
        ),    
    ) ) );

    $wp_customize->add_setting('gs_form_font_sizes', array(
        'default' => 13,
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'     => 'postMessage'
    ));

    $wp_customize->add_control( new Gs_Customizer_Range_Value_Control( $wp_customize, 'gs_form_font_sizes', array(
        'type'     => 'range-value',
        'section'  => 'gs_form_section',
        'settings' => 'gs_form_font_sizes',
        'label'    => __( 'Font Size' ),
        'priority' => 40,
        'input_attrs' => array(
          'min'    => 2,
          'max'    => 200,
          'step'   => 1,
          //'suffix' => 'px',
        ),    
    ) ) );
    
  
    //fields style

    $wp_customize->add_setting('gs_field_width', array(
        //'default' => '100%',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'     => 'postMessage'
    ));

    $wp_customize->add_control( new Gs_Customizer_Range_Value_Control( $wp_customize, 'gs_field_width', array(
        'type'     => 'range-value',
        'section'  => 'gs_field_section',
        'settings' => 'gs_field_width',
        'label'    => __( 'Input Field Width' ),
        'priority' => 5,
        'input_attrs' => array(
          'min'    => 100,
          'max'    => 1000,
          'step'   => 1,
          //'suffix' => 'px',
        ),    
    
    ) ) );

    $wp_customize->add_setting('gs_field_margin', array(
        'default' => '2px 6px 16px 0px',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'     => 'postMessage'
    ));

    $wp_customize->add_control('gs_field_margin', array(
        'label' => __('Input Field Margin', 'gscs'),
        'section' => 'gs_field_section',
        'priority' => 10,
        'settings' => 'gs_field_margin'
    ));

    $wp_customize->add_setting('gs_field_bg', array(
        'default' => '#FFF',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'     => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_field_bg', array(
        'label' => __('Input Field Background', 'gscs'),
        'section' => 'gs_field_section',
        'priority' => 15,
        'settings' => 'gs_field_bg'
    )));

    $wp_customize->add_setting('gs_field_color', array(
        'default' => '#333',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'     => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_field_color', array(
        'label' => __('Input Field Color', 'gscs'),
        'section' => 'gs_field_section',
        'priority' => 20,
        'settings' => 'gs_field_color',
        'transport'     => 'postMessage'
    )));

    $wp_customize->add_setting('gs_field_label', array(
        'default' => '#777',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'     => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_field_label', array(
        'label' => __('Label Color', 'gscs'),
        'section' => 'gs_field_section',
        'priority' => 25,
        'settings' => 'gs_field_label'
    )));

    $wp_customize->add_setting('gs_field_border_color', array(
        'default' => '#000',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'     => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_field_border_color', array(
        'label' => __('Form Field Border Color', 'gscs'),
        'section' => 'gs_field_section',
        'priority' => 26,
        'settings' => 'gs_field_border_color'
    )));

    $wp_customize->add_setting('gs_form_field_border_thick', array(
        'default' => 1,
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'     => 'postMessage'
    ));

    $wp_customize->add_control( new Gs_Customizer_Range_Value_Control( $wp_customize, 'gs_form_field_border_thick', array(
        'type'     => 'range-value',
        'section'  => 'gs_field_section',
        'settings' => 'gs_form_field_border_thick',
        'label'    => __( 'Form Field Border Thickness' ),
        'priority' => 27,
        'min'    => 1,
        'max'    => 100,
        'step'   => 1,
    
    ) ) );

    $wp_customize->add_setting('gs_form_field_border_style', array(
        'type' => 'option',
        'default'    => 'solid',
        'capability' => 'edit_theme_options',
        'transport'     => 'postMessage'
    ));

    $wp_customize->add_control('gs_form_field_border_style', array(
        'label' => __('Form Field Border Style', 'gscs'),
        'section' => 'gs_field_section',
        'priority' => 30,
        'settings' => 'gs_form_field_border_style',
        'type'     => 'select',
        'choices'  => array(
            'none'      => 'None',
            'dotted'    => 'Dotted',
            'dashed'    => 'Dashed',
            'solid'     => 'Solid',
            'double'    => 'Double',
            'groove'    => 'Groove',
            'ridge'     => 'Ridge',
            'inset'     => 'Inset',
            'outset'    => 'Outset',
            'hidden'    => 'Hidden',
          ),
    ));

    // button settings

    $wp_customize->add_setting('gs_button_bg', array(
        'default' => '#2EA2CC',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'     => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_button_bg', array(
        'label' => __('Button Background', 'gscs'),
        'section' => 'gs_button_section',
        'priority' => 5,
        'settings' => 'gs_button_bg'
    )));

    $wp_customize->add_setting('gs_button_border', array(
        'default' => '#0074A2',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'     => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_button_border', array(
        'label' => __('Button Border', 'gscs'),
        'section' => 'gs_button_section',
        'priority' => 10,
        'settings' => 'gs_button_border'
    )));

    $wp_customize->add_setting('gs_button_hover_bg', array(
        'default' => '#1E8CBE',
        'type' => 'option',
        'capability' => 'edit_theme_options',

    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_button_hover_bg', array(
        'label' => __('Button Background (Hover)', 'gscs'),
        'section' => 'gs_button_section',
        'priority' => 15,
        'settings' => 'gs_button_hover_bg'
    )));

    $wp_customize->add_setting('gs_button_hover_border', array(
        'default' => '#0074A2',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_button_hover_border', array(
        'label' => __('Button Border (Hover)', 'gscs'),
        'section' => 'gs_button_section',
        'priority' => 20,
        'settings' => 'gs_button_hover_border'
    )));

    $wp_customize->add_setting('gs_button_shadow', array(
        'default' => '#78C8E6',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'     => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_button_shadow', array(
        'label' => __('Button Box Shadow', 'gscs'),
        'section' => 'gs_button_section',
        'priority' => 25,
        'settings' => 'gs_button_shadow'
    )));

    $wp_customize->add_setting('gs_button_color', array(
        'default' => '#FFF',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'     => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_button_color', array(
        'label' => __('Button Color', 'gscs'),
        'section' => 'gs_button_section',
        'priority' => 30,
        'settings' => 'gs_button_color'
    )));

    // error section

    $wp_customize->add_setting( 'gs_customize_error_seetings', array(
        'default'         => '',
        'type'						=> 'option',
        'capability'			=> 'manage_options',
        'transport'       => 'postMessage'
    ) );
    
    $wp_customize->add_control( new GScustom_Login_Promo( $wp_customize, 'gs_customize_error_seetings',
        array(
            'section'         => 'gs_error_section',
            'thumbnail'       => GSCUSL_FILES_URI.'/inc/img/error_options.png',
            'promo_text'      => __( 'Upgrade to Pro', 'gscs' ),
            'link'            => 'https://www.gsplugins.com/product/gs-custom-login'
    ) ) );
  

    // other section
    $wp_customize->add_setting('gs_other_color', array(
        'default' => '#999',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_other_color', array(
        'label' => __('Text Color', 'gscs'),
        'section' => 'gs_other_section',
        'priority' => 5,
        'settings' => 'gs_other_color'
    )));

    $wp_customize->add_setting('gs_other_color_hover', array(
        'default' => '#2EA2CC',
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_other_color_hover', array(
        'label' => __('Text Color (Hover)', 'gscs'),
        'section' => 'gs_other_section',
        'priority' => 10,
        'settings' => 'gs_other_color_hover'
    )));

    $wp_customize->add_setting( 'gs_login_footer_text', array(
        'default' => 'Lost your password?',
        'type'    => 'option',
        'capability' => 'edit_theme_options',
        'transport'       => 'postMessage'
    ) );

    $wp_customize->add_control( 'gs_login_footer_text', array(
        'label'    => __( 'Lost Password Text', 'gscs' ),
        'section'   => 'gs_form_footer_section',
        'priority'  => 5,
        'settings'  => 'gs_login_footer_text',
    ) );

    $wp_customize->add_setting( 'gs_footer_display_text', array(
        'default'   => 'block',
        'type'     => 'option',
        'capability' => 'edit_theme_options',
        'transport'   => 'postMessage'
    ));

    $wp_customize->add_control( 'gs_footer_display_text', array(
        'label'   => __( 'Footer Text Display:', 'gscs' ),
        'section'  => 'gs_form_footer_section',
        'priority' => 10,
        'settings' => 'gs_footer_display_text',
        'type'  => 'radio',
        'choices'   => array(
          'block'    => 'Show',
          'none'     => 'Hide',
        ),
    ) );

    $wp_customize->add_setting( 'gs_back_display_text', array(
        'default'   => 'block',
        'type'          => 'option',
        'capability'    => 'manage_options',
        'transport' => 'postMessage'
    ) );

    $wp_customize->add_control( 'gs_back_display_text', array(
        'label'      => __( '"Back to" Text Display:', 'gscs' ),
        'section'    => 'gs_form_footer_section',
        'priority'   => 45,
        'settings'   => 'gs_back_display_text',
        'type'           => 'radio',
        'choices'    => array(
          'block'=> 'Show',
          'none' => 'Hide',
      ),
    ) );

    $wp_customize->add_setting('gs_other_color', array(
        'default' => '#999',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'   => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_other_color', array(
        'label' => __('Text Color', 'gscs'),
        'section' => 'gs_form_footer_section',
        'priority' => 15,
        'settings' => 'gs_other_color'
    )));

    $wp_customize->add_setting('gs_other_color_hover', array(
        'default' => '#2EA2CC',
        'type' => 'option',
        'capability' => 'edit_theme_options',
        'transport'   => 'postMessage'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gs_other_color_hover', array(
        'label' => __('Text Color (Hover)', 'gscs'),
        'section' => 'gs_form_footer_section',
        'priority' => 20,
        'settings' => 'gs_other_color_hover'
    )));

    $wp_customize->add_setting('gscusl-login-icons', array(
        'type' => 'option',
        'default'    => 'block',
        'capability' => 'edit_theme_options',
        'transport'     => 'postMessage'
    ));

    $wp_customize->add_control('gscusl-login-icons', array(
        'label' => __('Login Field Icon', 'gscs'),
        'section' => 'gs_other_section',
        'priority' => 17,
        'settings' => 'gscusl-login-icons',
        'type'     => 'select',
        'choices'    => array(
            'block'  => 'On',
            'none'   => 'Off',
            
          ),
    ));

     $wp_customize->add_setting('gscusl-form-position', array(
        'type' => 'option',
        'default'    => 'gscusl_cc',
        'capability' => 'edit_theme_options',
        'transport'     => 'refresh'
    ));

    $wp_customize->add_control('gscusl-form-position', array(
        'label' => __('Form Position', 'gscs'),
        'section' => 'gs_form_section',
        'priority' => 18,
        'settings' => 'gscusl-form-position',
        'type'     => 'select',
        'choices'                 => array(
           'gscusl_tl'    => 'Top - Left',
            'gscusl_tc'   => 'Top - Center',
            'gscusl_tr'   => 'Top - Right',
            'gscusl_cl'   => 'Center - Left',
            'gscusl_cc'   => 'Center - Center',
            'gscusl_cr'   => 'Center - Right',
            'gscusl_bl'   => 'Bottom - Left',
            'gscusl_bc'   => 'Bottom - Center',
            'gscusl_br'   => 'Bottom - Right',
            
          ),
        //'render_callback' => 'gs_customize_partial_blogname',
    ));

    $wp_customize->add_setting('gs_other_css', array(
        'type' => 'option',
        'capability' => 'edit_theme_options',
    ));

    $wp_customize->add_control('gs_other_css', array(
        'label' => __('Custom CSS', 'gscs'),
        'type' => 'textarea',
        'section' => 'gs_other_section',
        'priority' => 19,
        'settings' => 'gs_other_css'
    ));


    //social controls

    $wp_customize->add_setting( 'gs_customize_social_seetings', array(
        'default'         => '',
        'type'			  => 'option',
        'capability'	  => 'manage_options',
        'transport'       => 'postMessage'
    ) );
    
    $wp_customize->add_control( new GScustom_Login_Promo( $wp_customize, 'gs_customize_social_seetings',
        array(
            'section'         => 'gs_customizer_social_section',
            'thumbnail'       => GSCUSL_FILES_URI.'/inc/img/socio_icons.png',
            'promo_text'      => __( 'Upgrade to Pro', 'gscs' ),
            'link'            => 'https://www.gsplugins.com/product/gs-custom-login'
    ) ) );

    //Recapta
    $wp_customize->add_section( 'gs_customize_reCAPTCHA', array(
        'title'                => __( 'reCAPTCHA', 'gscustom_login' ),
        //'description'    => __( 'reCAPTCHA', 'gscustom_login' ),
        'priority'             => 50,
        'panel'                => 'gs_panel',
    ) );

    $wp_customize->add_setting( 'gs_customize_reCAPTCHA_seetings', array(
        'default'         => '',
        'type'			  => 'option',
        'capability'	  => 'manage_options',
        'transport'       => 'postMessage'
    ) );
    
    $wp_customize->add_control( new GScustom_Login_Promo( $wp_customize, 'gs_customize_reCAPTCHA_seetings',
        array(
            'section'         => 'gs_customize_reCAPTCHA',
            'thumbnail'       => GSCUSL_FILES_URI.'/inc/img/recaptcha.png',
            'promo_text'      => __( 'Upgrade to Pro', 'gscs' ),
            'link'            => 'https://www.gsplugins.com/product/gs-custom-login'
    ) ) );
}
add_action('customize_register', 'gs_customize_register');



function gslogin_customizer_live_preview() {
    if( isset( $_GET['autofocus'] ) && $_GET['autofocus'] == 'gs_panel' ) { // 1.2.0
        $gs_panel_auto_focus = true;
    } else {
        $gs_panel_auto_focus = false;
    }
    wp_enqueue_script(
        'gs-themecustomizer',
        GSCUSL_FILES_URI . '/inc/js/customizer.js',
        array('jquery', 'customize-preview'),  //Define dependencies
        '',           //Define a version (optional) 
        true            //Put script in footer?
    );
    // Array for localize.
    $gs_localize = array(
        'admin_url'         => admin_url(),
        'ajaxurl'           => admin_url( 'admin-ajax.php' ),
        'autoFocusPanel'    => $gs_panel_auto_focus,
        'bgBack'    => get_option('gs_bg_image'),
        'tm1bg'    => GSCUSL_FILES_URI . '/inc/img/bg1.jpg',
     
      );
  
      wp_localize_script( 'gs-themecustomizer', 'gs_script', $gs_localize );
}
add_action('customize_controls_enqueue_scripts', 'gslogin_customizer_live_preview');

function remove_lostpassword_text ( $text ) {
    if ($text == 'Lost your password?'){ $text = get_option('gs_login_footer_text');}
        return $text;
}
add_filter( 'gettext', 'remove_lostpassword_text'  );


function customizer_presets_control_css() {
    ?>
    <style>
        #customize-control-gs_customize_presets_settings .gscustom_login_thumbnail:nth-child(odd) {
            float: left;
        }

        #customize-control-gs_customize_presets_settings .gscustom_login_thumbnail:hover {
            border-color: #ccc;
        }

        #customize-control-gs_customize_presets_settings .gscustom_login_thumbnail:nth-child(even) {
            float: right;
        }

        #customize-control-gs_customize_presets_settings .gscustom_login_thumbnail {
            width: calc(50% - 10px);
            margin-bottom: 10px;
            position: relative;
            border: 5px solid transparent;
            -webkit-transition: all 0.2s ease-in-out;
            -moz-transition: all 0.2s ease-in-out;
            -ms-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
            text-align: center;
        }

        #customize-control-gs_customize_presets_settings input[type=radio] {
            display: none;
        }

        #customize-control-gs_customize_presets_settings label {
            display: block;
            position: relative;
            width: 100%;
        }

        #customize-control-gs_customize_presets_settings label .gscustom_login_thumbnail_img:before {
            height: 6px;
            width: 3px;
            -webkit-transform-origin: left top;
            -moz-transform-origin: left top;
            -ms-transform-origin: left top;
            -o-transform-origin: left top;
            transform-origin: left top;
            border-right: 3px solid white;
            border-top: 3px solid white;
            border-radius: 2.5px !important;
            content: '';
            position: absolute;
            z-index: 2;
            opacity: 0;
            margin-top: 0px;
            margin-left: -7px;
            top: 5px;
            left: 4px;
        }

        #customize-control-gs_customize_presets_settings .gscustom_login_thumbnail_img {
            display: block;
            position: relative;
        }

        #customize-control-gs_customize_presets_settings input[type="radio"]:checked+label img {
            opacity: 1;
        }

        #customize-controls .customize-control-checkbox-multiple label img {
            max-width: 250px;
            height: auto;
            width: 100%;
            margin-bottom: 0;
            border: 0;
            display: block;
            min-height: 80px;
        }

        .no-available {
            top: 0;
            left: 0;
            background: rgba(204, 204, 204, 0.8);
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            z-index: 100;
            padding: 20px;
            text-align: center;
            font-weight: bold;
            color: #000;
            -webkit-transition: all 0.2s ease-in-out;
            -moz-transition: all 0.2s ease-in-out;
            -ms-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
            opacity: 0;
            visibility: hidden;
            -webkit-transform: scale(.5);
            -moz-transform: scale(.5);
            -ms-transform: scale(.5);
            transform: scale(.5);
            text-decoration: none !important;
        }

        #customize-control-gs_customize_presets_settings .gscustom_login_thumbnail:hover input[type="radio"]:disabled~.no-available {
            opacity: 1;
            visibility: visible;
            color: #000;
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            transform: scale(1);
        }

        #customize-control-gs_customize_presets_settings input[type="radio"]:checked+label .gscustom_login_thumbnail_img:before {
            -webkit-animation-delay: 100ms;
            -moz-animation-delay: 100ms;
            animation-delay: 100ms;
            -webkit-animation-duration: 1s;
            -moz-animation-duration: 1s;
            animation-duration: 1s;
            -webkit-animation-timing-function: ease;
            -moz-animation-timing-function: ease;
            animation-timing-function: ease;
            -webkit-animation-name: checkmark;
            -moz-animation-name: checkmark;
            animation-name: checkmark;
            -webkit-transform: scaleX(-1) rotate(135deg);
            -moz-transform: scaleX(-1) rotate(135deg);
            -ms-transform: scaleX(-1) rotate(135deg);
            -o-transform: scaleX(-1) rotate(135deg);
            transform: scaleX(-1) rotate(135deg);
            -webkit-animation-fill-mode: forwards;
            -moz-animation-fill-mode: forwards;
            animation-fill-mode: forwards;
            z-index: 2;
        }

        #customize-control-gs_customize_presets_settings input[type="radio"]:checked+label .gscustom_login_thumbnail_img:after {
            visibility: visible;
        }

        #customize-control-gs_customize_presets_settings label .gscustom_login_thumbnail_img:after {
            content: '';
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #2EB150;
            position: absolute;
            top: -5px;
            left: -5px;
            border-radius: 50%;
            visibility: hidden;
        }

        .gscustom_login_promo_thumbnail a{
            display: inline-block;
            position: relative;
            border:5px solid transparent;
        }
        .gscustom_login_promo_thumbnail a .customizer-promo-overlay{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(204, 204, 204, 0.8);
            content: '';
            -webkit-transition: all 0.2s ease-in-out;
            -moz-transition: all 0.2s ease-in-out;
            -ms-transition: all 0.2s ease-in-out;
            transition: all 0.2s ease-in-out;
            opacity: 0;
            visibility: hidden;
            -webkit-transform: scale(.5);
            -moz-transform: scale(.5);
            -ms-transform: scale(.5);
            transform: scale(.5);
        }
        .customizer-promo-text{
            line-height:1.2;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform:translate(-50%, -50%);
            transform:translate(-50%, -50%);
            width: 100%;
            font-size: 25px;
            color: #000;
            z-index: 100;
            text-align: center;
            opacity: 0;
        }
        .gscustom_login_promo_thumbnail a:hover{
            border-color: #ccc;
        }
        .gscustom_login_promo_thumbnail a:hover .customizer-promo-text{
            opacity: 1;
        }
        .gscustom_login_promo_thumbnail a:hover .customizer-promo-overlay{
            opacity: 1;
            visibility: visible;
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            transform: scale(1);
        }

        @-webkit-keyframes checkmark {
            0% {
                height: 0;
                width: 0;
                opacity: 1;
            }

            20% {
                height: 0;
                width: 5px;
                opacity: 1;
            }

            40% {
                height: 10px;
                width: 5px;
                opacity: 1;
            }

            100% {
                height: 10px;
                width: 5px;
                opacity: 1;
            }
        }

        @-moz-keyframes checkmark {
            0% {
                height: 0;
                width: 0;
                opacity: 1;
            }

            20% {
                height: 0;
                width: 5px;
                opacity: 1;
            }

            40% {
                height: 10px;
                width: 5px;
                opacity: 1;
            }

            100% {
                height: 10px;
                width: 5px;
                opacity: 1;
            }
        }

        @keyframes checkmark {
            0% {
                height: 0;
                width: 0;
                opacity: 1;
            }

            20% {
                height: 0;
                width: 5px;
                opacity: 1;
            }

            40% {
                height: 10px;
                width: 5px;
                opacity: 1;
            }

            100% {
                height: 10px;
                width: 5px;
                opacity: 1;
            }
        }
    </style>
    <?php
}
add_action('customize_controls_print_styles', 'customizer_presets_control_css');