<?php
if ( ! class_exists( 'simple_signup_form_settings' ) ) {
	class simple_signup_form_settings extends simple_signup_form {
	/**
	* Construct the plugin object
	**/
		public function __construct() {
			global $wpdb;
			$this->wpdb =& $wpdb;
			/**
			* register actions, hook into WP's admin_init action hook
			**/
			add_action( 'admin_init', array( &$this, 'admin_init' ) );
			add_action( 'admin_menu', array( &$this, 'add_menu' ) );
			add_action( 'wp_ajax_ajax_ssp', array( &$this, 'ajax_ssp' ) );
			add_action( 'wp_ajax_nopriv_ajax_ssp', array( &$this, 'ajax_ssp' ) );
		}
		/**
		* include custom scripts and style to the admin page
		**/
		function enqueue_admin_custom_scripts_and_styles() {
			wp_enqueue_style( 'simple_signup_form_admin_style', plugins_url( '/templates/assets/css/ssf_settings.css', __FILE__ ) );
			wp_enqueue_style( 'simple_signup_form_style', plugins_url( '/templates/assets/css/ssf.css', __FILE__ ) );
			wp_enqueue_style( 'simple_signup_form_ui_style', plugins_url( '/templates/assets/css/jquery-ui.css', __FILE__ ) );
			wp_enqueue_script( 'jquery');
			wp_enqueue_script( 'jquery-ui-core', array( 'jquery' ) );
			wp_enqueue_script( 'jquery-ui-tabs', array( 'jquery-ui-core' ) );
			wp_enqueue_script( 'jquery-ui-slider', array( 'jquery-ui-core' ) );
			wp_enqueue_script( 'jquery-ui-tooltip', array( 'jquery-ui-core' ) );
			wp_enqueue_script( 'jquery-ui-accordion', array( 'jquery-ui-core' ) );
			wp_enqueue_script( 'jquery-ui-dialog', array( 'jquery-ui-core' ) );
			wp_enqueue_script( 'jquery-effects-core', array( 'jquery' ) );
			wp_enqueue_script( 'jquery-effects-fade', array( 'jquery-effects-core' ) );
			wp_register_script('simple_signup_form_admin', plugins_url( '/templates/assets/js/ssf_admin.js', __FILE__ ), array( 'jquery', 'jquery-ui-core', 'jquery-effects-core' ), '100018', true );
			wp_enqueue_script('simple_signup_form_script', plugins_url( '/templates/assets/js/ssf.min.js', __FILE__ ), array( 'jquery', 'jquery-ui-core', 'jquery-effects-core' ), '100018' );
			wp_localize_script( 'simple_signup_form_admin', 'sspa_params', array( 'plugin_url'=>plugins_url( '' , __FILE__ ), 'admin_url'=>admin_url( 'admin-ajax.php' ) ) );
			wp_enqueue_script( 'simple_signup_form_admin' );
			wp_enqueue_script( "simple_signup_form_colorpicker_script", plugins_url('/templates/assets/js/colorpicker.js', __FILE__ ) );
			wp_enqueue_style( 'simple_signup_form_colorpicker_style', plugins_url( '/templates/assets/css/colorpicker.css', __FILE__ ) );
			wp_enqueue_script( 'ssf_acustom', plugins_url( '/templates/assets/js/acustom.js', __FILE__ ), array( 'jquery' ), '100017', true );
		}
		/**
		* initialize datas on wp admin
		**/
		public function admin_init() {
		$settings_page = '';
			if ( isset( $_REQUEST[ 'page' ] ) ) {
				$settings_page = sanitize_title( $_REQUEST[ 'page' ] );
			}
			if ( $settings_page == 'simple_signup_form' ) {
				add_action( 'admin_head', array( &$this, 'enqueue_admin_custom_scripts_and_styles' ) );
			}
			// Possibly do additional admin_init tasks
		}
		/**
		* add a menu
		**/		
		public function add_menu() {
			// Add a page to manage this plugin's settings
			add_options_page( 'Simple Signup Form FREE', 'Simple Signup Form FREE', 'manage_options', 'simple_signup_form', array( &$this, 'plugin_settings_page' ) );
		}
		/**
		* Menu Callback
		**/		
		public function plugin_settings_page() {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
			}
			// Render the settings template
			include( sprintf( "%s/templates/settings.php", dirname( __FILE__ ) ) );
		}
		public function settings_section_simple_signup_form() {
		
		}

		public function ajax_ssp() {
			global $wpdb;
			if ( isset( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) && ( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] == 'XMLHttpRequest' ) ) {
				$signup_form_id = "";
				$form_name = "";
				$form_options = "";
				$form_global = "";
				if ( isset( $_REQUEST[ 'signup_form_id' ] ) ) {
					$signup_form_id = sanitize_text_field( $_REQUEST[ 'signup_form_id' ] );
				}
				else {
					$signup_form_id = "";
				}
				if (isset($_REQUEST['form_name'])) $form_name = sanitize_text_field($_REQUEST['form_name']);
				else $form_name = "";
				if (isset($_REQUEST['global_use'])) $form_global = sanitize_text_field($_REQUEST['global_use']);
				else $form_global = "";
				if (isset($_REQUEST['options'])) $form_options = sanitize_text_field($_REQUEST['options']);
				else $form_options = "";
				if (!empty($signup_form_id)&&($signup_form_id>0)) $form_check = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".$wpdb->prefix."simple_subscription_popup WHERE `id` = %d",$signup_form_id));
				else $form_check = 0;
				if ($_REQUEST['sspcmd']=="save")
				{
				if(!current_user_can('manage_options')) die();
				if ($form_check>0) {
				//update signup form
					$wpdb->update( $wpdb->prefix."simple_subscription_popup", array( "options" => $form_options, 'global' => $form_global),array('id' => $signup_form_id));
					die("updated");
				}
				else {
				//insert signup form
					$wpdb->insert( $wpdb->prefix."simple_subscription_popup", array( 
						'id' => $signup_form_id, 
						'name' => $form_name, 
						'options' => $form_options, 
						'global'=> $form_global
						) );
					die('success');
				}
				}
				elseif($_REQUEST['sspcmd']=="delete")
				{
				if(!current_user_can('manage_options')) die();
				if ($form_check>0) {
					$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."simple_subscription_popup WHERE `id` = %d",$signup_form_id));
					die("deleted");
				}
				}
				elseif ($_REQUEST['sspcmd']=="subscription_signup")
				{
					$form_options = "";
					if (isset($_REQUEST['email'])) $email = sanitize_email($_REQUEST['email']);
					else $email = "";
					if (isset($_REQUEST['mode'])) $mode = sanitize_text_field($_REQUEST['mode']);
					else $mode = "";
					if (isset($_REQUEST['double_optin'])) $double_optin = sanitize_text_field($_REQUEST['double_optin']);
					else $double_optin = "";
					if (isset($_REQUEST['update_existing'])) $update_existing = sanitize_text_field($_REQUEST['update_existing']);
					else $update_existing = "";
					if (isset($_REQUEST['replace_interests'])) $replace_interests = sanitize_text_field($_REQUEST['replace_interests']);
					else $replace_interests = "";
					if (isset($_REQUEST['mailchimp_listid'])) $mailchimp_listid = sanitize_text_field($_REQUEST['mailchimp_listid']);
					else $mailchimp_listid = "";
					if (isset($_REQUEST['send_welcome'])) $send_welcome = sanitize_text_field($_REQUEST['send_welcome']);
					else $send_welcome = "";
					$customfields = '';
					if (isset($_REQUEST['customfieldsarray']))
					{
						if (!empty($_REQUEST['customfieldsarray']))
						{
							foreach($_REQUEST['customfieldsarray'] as $cfa)
							{
								$mv[$cfa] = sanitize_text_field($_REQUEST[$cfa]);
								$customfields .='
		'.sanitize_text_field($cfa).': '.sanitize_text_field($_REQUEST[$cfa]);
							}
						}
					}
					else $mv = '';
					$customfields .='
							
	IP Address: ' . $_SERVER[ 'REMOTE_ADDR' ] . '
							
	Date: ' . date( "d-m-Y H:i" ); 
					if (!empty($signup_form_id)&&($signup_form_id>0))
					{
					$form_check = $wpdb->get_var($wpdb->prepare("SELECT options FROM ".$wpdb->prefix."simple_subscription_popup WHERE `id` = %d",$signup_form_id));
					if (!empty($form_check)) $form_options = json_decode(stripslashes($form_check));
					}
					if (empty($form_check)&&!empty($signup_form_id)) $form_options[35] = sanitize_email($signup_form_id);
					if (!isset($form_options[35])) die('Error: Missing Recipient Email');
					else
					{
						if (!filter_var($email, FILTER_VALIDATE_EMAIL)) die( 'Error: ' . esc_html__( 'Invalid Email Address', WP_SSP_TEXT_DOMAIN ) );
						else
						{
						if ($mode=='mail')
						{
							$body = "You've got a new signup on the http://" . $_SERVER[ 'HTTP_HOST' ] . str_replace( '/wp-admin/admin-ajax.php', '', $_SERVER[ 'REQUEST_URI' ] ) . " website with the following mail address: " . $email . $customfields . "
							
							";
							$from_a = 'noreply@' . str_replace( "www.", "", $_SERVER[ 'HTTP_HOST' ] );
							$from_name = 'Simple Signup Form';
							$header = 'MIME-Version: 1.0' . '\r\n';
							$header .= 'From: "' . $from_name . '" <' . $from_a . '>\r\n';
							$header .= 'Content-type: text/plain; charset=UTF-8';
							if ( wp_mail( $form_options[ 35 ], 'SUBSCRIPTION SIGNUP', $body, $header ) ) {
								$result = true;
							}
							else {
								$result = false;
							}
						}
						if ( $result == true ) {
							die( "success" );
						}
						else {
							die( "Error: " . esc_html__( 'Mail Sending Failure', WP_SSP_TEXT_DOMAIN ) );
						}
						}			
					}
					}
				}
			}
	}
}
?>