<?php

if( ! class_exists( 'GSPlugins_wps' ) ){
    
    class GSPlugins_wps{
        
        /**
         * Singleton Instance
         *
         * @access private static
         */
        private static $_instance;
        
        public function __construct() {
            add_action( 'admin_menu', array( $this, 'gs_main_menu' ) );
            add_action( 'init',array( $this, 'redirect_to_customizar_page' ) );
            add_action( 'admin_menu',array( $this, 'gs_menu_url' ), 10 );
        }
        
        /**
         * Get class singleton instance
         *
         * @return Class Instance
         */
        public static function get_instance() {
            if ( ! self::$_instance instanceof GSPlugins_wps ) {
                self::$_instance = new GSPlugins_wps();
            }
            
            return self::$_instance;
        }
        
        public function gs_main_menu() {
            add_menu_page(
                        __( 'GS Plugins', 'gscusl' ),
                        __( 'GS Plugins', 'gscusl' ),
                        'manage_options',
                        'gsp-main',
                        array( $this, 'gs_main_menu_cb' ),
                        '',
                        GSCUSL_MENU_POSITION
                    );
            add_submenu_page( 'gsp-main', __( 'GS Login Customizer', 'gscusl' ), __( 'GS Login Customizer', 'gscusl' ), 'manage_options', "gsp-customizar", '__return_null' );
        }

        public function redirect_to_customizar_page() {
          if ( ! empty($_GET['page'] ) ) {

            if( ( $_GET['page'] == "gsp-customizar" ) ) {
                wp_redirect(get_admin_url()."customize.php?url=".wp_login_url(). '&autofocus=gs_panel');
            }
          }
        }  
       

        /**
        * Redirect to the Admin Panel After Closing  Customizer
        *
        * @since  1.0.0
        * @return null
        * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
          public function gs_menu_url() {

            global $submenu;

            $parent = 'index.php';
            $page    = 'gsp-customizar';

            // Create specific url for login view
            $login_url = wp_login_url();
            $url             = add_query_arg(
            array(
              'url'     => urlencode( $login_url ),
              'return' => admin_url( 'themes.php' ),
            ),
            admin_url( 'customize.php' )
            );

            // If is Not Design Menu, return
            if ( ! isset( $submenu[ $parent ] ) ) {
              return NULL;
            }

            foreach ( $submenu[ $parent ] as $key => $value ) {
              // Set new URL for menu item
              if ( $page === $value[ 2 ] ) {
                $submenu[ $parent ][ $key ][ 2 ] = $url;
                break;
              }
            }
          }
        
        public function gs_main_menu_cb() {
            $protocol = is_ssl() ? 'https' : 'http';
            $promo_content = wp_remote_get( $protocol . '://gsplugins.com/gs_plugins_list/index.php' );
            echo $promo_content['body'];
        }
    }
    
    $tmev = GSPlugins_wps::get_instance(); 
}