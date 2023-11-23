<?php
defined( 'ABSPATH' ) OR exit;
/**
 * Plugin Name: Simple Signup Form Free
 * Plugin URI: https://wordpress.org/plugins/simple-signup-form
 * Description: Easily add and manage signup forms
 * Author: Pantherius
 * Version: 1.6.5
 * Author URI: http://pantherius.com
 */
 
define( 'WP_SSP_TEXT_DOMAIN' , 'wp_ssp' );
 
if ( ! class_exists( 'simple_signup_form' ) ) {
	class simple_signup_form {
		protected static $instance = null;
		/**
		 * Construct the plugin object
		 */
		public function __construct() {
			global $wpdb;
			// installation and uninstallation hooks
			register_activation_hook( __FILE__, array( 'simple_signup_form', 'activate' ) );
			register_deactivation_hook( __FILE__, array( 'simple_signup_form', 'deactivate' ) );
			register_uninstall_hook( __FILE__, array( 'simple_signup_form', 'uninstall' ) );
			add_action( 'plugins_loaded', array( $this, 'wpssp_localization' ) );
			if ( is_admin() ) {
				if ( ! isset( $_COOKIE[ 'ssf-pop' ] ) ) {
					setcookie( "ssf-pop", '1', 0, COOKIEPATH, COOKIE_DOMAIN, false );
				}
				require_once( sprintf( "%s/settings.php", dirname( __FILE__ ) ) );
				$simple_signup_form_settings = new simple_signup_form_settings();
				$plugin = plugin_basename( __FILE__ );
				add_filter( "plugin_action_links_$plugin", array( &$this, 'plugin_settings_link' ) );
			}
			else {
				$simple_signup_form_url = $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];
				$simple_signup_form_load = true;
				if ( ( strpos( $simple_signup_form_url, 'wp-login' ) ) !== false ) {
					$simple_signup_form_load = false;
				}
				if ( ( strpos( $simple_signup_form_url,'wp-admin' ) ) !== false ) {
					$simple_signup_form_load = false;
				}
				if ( $simple_signup_form_load || isset( $_REQUEST[ 'sspcmd' ] ) ) {
					//integrate the public functions
					add_action( 'init', array( &$this, 'enqueue_custom_scripts_and_styles' ) );
					add_shortcode( 'ssf', array( &$this, 'ssf_shortcodes' ) );
				}
			}
		}
		public static function getInstance() {
			if ( ! isset( $instance ) ) {
				$instance = new simple_signup_form;
			}
			return $instance;
		}

		public function wpssp_localization() {
			// Localization
			load_plugin_textdomain( 'wp_ssp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		/**
		* Activate the plugin
		**/
		public static function activate() {
			global $wpdb;
			$db_info = array();
			//define custom data tables
			$charset_collate = '';
			if ( ! empty( $wpdb->charset ) ) {
			  $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
			}

			if ( ! empty( $wpdb->collate ) ) {
			  $charset_collate .= " COLLATE {$wpdb->collate}";
			}
			//creating custom tables
			$sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . 'simple_subscription_popup' . " (
			  id varchar(255) NOT NULL,
			  name varchar(255) NOT NULL,
			  options text NOT NULL,
			  global tinyint(1) NOT NULL,
			  autoid mediumint(9) NOT NULL AUTO_INCREMENT,
			  UNIQUE KEY autoid (autoid)
			) $charset_collate";
			$wpdb->query( $sql );
		}
		/**
		* Deactivate the plugin
		**/
		public static function deactivate() {
			wp_unregister_sidebar_widget( 'simple_signup_form' );
		}
		
		/**
		* Uninstall the plugin
		**/
		public static function uninstall() {
			global $wpdb;
			$db_info = array();
			//define custom data tables
			$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . 'simple_subscription_popup' );
		}
			
		public function ssf_shortcodes( $atts ) {
			global $wpdb;
			extract( shortcode_atts( array(
					'id' => '-1'
				), $atts, 'ssf' ) );
				$args = array( 'id' => $atts[ 'id' ] );
				if ( ! is_single() && ! is_page() ) {
					return( '' );
				}
			wp_deregister_script( 'simple_signup_form_script' );
			wp_dequeue_style( 'simple_signup_form_script' );
			wp_register_script( 'simple_signup_form_script', plugins_url( '/templates/assets/js/ssf.min.js', __FILE__ ), array( 'jquery' ), '1.0.0.2', true );
			$sql = "SELECT * FROM " . $wpdb->prefix . "simple_subscription_popup ssp WHERE ssp.id='" . $args[ 'id' ] . "' ORDER BY ssp.id ASC";
			$ssp_sql = $wpdb->get_results( $sql );
			if ( ! empty( $ssp_sql ) ) {
			$ssp_options = json_decode( stripslashes( $ssp_sql[ 0 ]->options ) );
			if ( $ssp_options[ 10 ] ) {
				$ssp_options[ 18 ] = $ssp_options[ 18 ] * 1000;
			}
			$ssp_options[ 100 ] = admin_url( 'admin-ajax.php' );
			$ssp_options[ 101 ] = $ssp_sql[ 0 ]->id;
			wp_localize_script( 'simple_signup_form_script', 'passed', $ssp_options );
			wp_enqueue_script( 'simple_signup_form_script' );
			}
		}
			
		function enqueue_custom_scripts_and_styles() {
			global $wpdb;
			wp_enqueue_style( 'simple_signup_form_style', plugins_url( '/templates/assets/css/ssf.css', __FILE__ ) );
			wp_enqueue_script( 'jquery' );
			wp_register_script('simple_signup_form_script', plugins_url('/templates/assets/js/ssf.min.js', __FILE__ ), array( 'jquery' ), '1.0.0.1', true );
			$sql = "SELECT * FROM " . $wpdb->prefix . "simple_subscription_popup ssp WHERE global = 1 ORDER BY ssp.id ASC";
			$ssp_sql = $wpdb->get_results( $sql );
			if ( ! empty( $ssp_sql ) ) {
				$ssp_options = json_decode( stripslashes( $ssp_sql[ 0 ]->options ) );
				if ( $ssp_options[ 10 ] ) {
					$ssp_options[ 18 ] = $ssp_options[ 18 ] * 1000;
				}
				$ssp_options[ 100 ] = admin_url( 'admin-ajax.php' );
				$ssp_options[ 101 ] = $ssp_sql[ 0 ]->id;
				wp_localize_script( 'simple_signup_form_script', 'passed', $ssp_options );
				wp_enqueue_script( 'simple_signup_form_script' );
			}
		}
		/**
		* Add the settings link to the plugins page
		**/
		function plugin_settings_link( $links ) { 
			$settings_link = '<a href="options-general.php?page=simple_signup_form">' . esc_html__( 'Settings', WP_SSP_TEXT_DOMAIN ) . '</a>';
			array_unshift( $links, $settings_link );
			return $links; 
		}
	}
}
if ( class_exists( 'simple_signup_form' ) ) {
	// call the main class
	$simple_signup_form = simple_signup_form::getInstance();
}
?>