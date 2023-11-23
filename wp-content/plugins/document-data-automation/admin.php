<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once dirname(__FILE__) . "/classes/Docxpresso/Utils.php";
require_once dirname(__FILE__) . "/custom.php";

use SDK_Docxpresso as SDK;

//add actions
//menu
add_action('admin_menu', 'docxpresso_saas_menu');
//shortcodes
add_action('media_buttons', 'add_docxpresso_saas_button', 15);
add_action('wp_enqueue_media', 'include_docxpresso_saas_js');
add_action( 'init', 'docxpressoSaaS_block' );
//filters
add_filter( 'https_local_ssl_verify', '__return_false' );
add_filter( 'https_ssl_verify', '__return_false' );
add_filter( 'block_local_requests', '__return_false' );

function docxpressoSaaS_block() {
    if ( ! function_exists( 'register_block_type' ) ) {
            // Gutenberg is not active.
            return;
    }
	
    wp_register_script(
        'docxpressoSaaS/Gutenberg',
        plugins_url( 'gutenberg/block.js', __FILE__ ),
        array( 'wp-blocks', 'wp-element', 'wp-i18n', 'wp-components', 'wp-editor')
    );
	
    wp_register_style(
        'docxpressoSaaS/Gutenberg',
        plugins_url( 'gutenberg/style.css', __FILE__ ),
        array( )
    );

    register_block_type( 'docxpresso-saas/plugin', array(
		'style' => 'docxpressoSaaS/Gutenberg',
		'editor_script' => 'docxpressoSaaS/Gutenberg')
    );
}

function add_docxpresso_saas_button() {
	wp_enqueue_style( 'dxosaas', plugins_url('/css/dxosaas.css',__FILE__));
	//Insert the button to open the Docxpresso popup
    echo '<a href="#" id="insert-docxpresso-saas" class="button open-my-dialog insert-docxpresso-saas">';
	echo '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAPAgMAAABGuH3ZAAAAA3NCSVQICAjb4U/gAAAACVBMVEX////MzMyBgYFQ1Uj9AAAAA3RSTlMA//9EUNYhAAAACXBIWXMAAArwAAAK8AFCrDSYAAAAIHRFWHRTb2Z0d2FyZQBNYWNyb21lZGlhIEZpcmV3b3JrcyBNWLuRKiQAAAAWdEVYdENyZWF0aW9uIFRpbWUAMDYvMDUvMTUjouemAAAAPUlEQVR4nGNgAINVK4DE1CggMYGrgYFBgHECg9YKhgkMrKFAggvEYgSxmEAshqkgYgKIWLUKSIiGBoDNAAAPGg6OmqVKSwAAAABJRU5ErkJggg==" />';
	echo 'Docxpresso SaaS</a>';
}

function include_docxpresso_saas_js() {
	// Register the script
	wp_register_script( 'media_saas_button', plugins_url('/js/docxpresso_saas.js',__FILE__ ) );
	wp_register_script( 'dxo_tb', plugins_url('/js/dxo-tb.js',__DIR__ ) );
	wp_enqueue_style( 'thickbox' );
	wp_enqueue_style( 'dxosaas', plugins_url('/css/dxosaas.css',__FILE__));
	// Localize the script with new data
	// Get the required links from the SDK
    $options = get_option('docxpressoSaaS', array());
    $optionsDocxpresso = array();
    $optionsDocxpresso['pKey'] = $options['pKey'];
    $optionsDocxpresso['docxpressoInstallation'] = $options['DocxpressoUrl'];
	$email = $options['email'];
    $APICall = new SDK\Utils($optionsDocxpresso);

	$openSelectDocWindow = $APICall->accessByTokenAction(array('email' => $email, 'url' => '/documents/plugin/tree', 'referer' => get_site_url()));
	
	$DXO = [];
	$DXO['openCategoriesPopUp'] = $openSelectDocWindow;
	$DXO['installation'] = $options['DocxpressoUrl'];
	$DXO['closeConnection'] = 1;
	$DXO['templateShortcode'] = array();
	$DXO['popupTitle'] = __('Select Docxpresso Template', 'document-data-automation');
	$options = get_option('docxpressoSaaS', array());

	wp_localize_script('media_saas_button', 'DXO', $DXO );
	wp_enqueue_script('media_saas_button', plugins_url('/js/docxpresso_saas.js',__FILE__));
}

function docxpresso_saas_menu() {
	//This function handles the WP menu entries associated with the plugin

    add_menu_page('Docxpresso Saas', 'Docxpresso SaaS', 'manage_options', __DIR__.'/views/template.php','',plugins_url('/img/micro-dxo-wp.png',__FILE__));
    add_submenu_page(__DIR__.'/views/template.php', __('Templates','document-data-automation'), __('Templates','document-data-automation'), 'manage_options',__DIR__.'/views/template.php');
    add_submenu_page(__DIR__.'/views/template.php', __('Options','document-data-automation'), __('Options','document-data-automation'), 'manage_options', __DIR__.'/views/options.php');
    add_submenu_page(__DIR__.'/views/template.php', __('Users','document-data-automation'), __('Users','document-data-automation'), 'manage_options', __DIR__.'/views/DXOoptionsUsers.php');

    add_menu_page(__('My Documents','document-data-automation'), __('My Documents','document-data-automation'), 'read', __DIR__.'/views/docxpresso_documents.php','',plugins_url('/img/micro-dxo-wp.png',__FILE__));
    add_submenu_page(__DIR__.'/views/docxpresso_documents.php', __('Documents','document-data-automation'), __('Documents','document-data-automation'), 'read',__DIR__.'/views/docxpresso_documents.php');


    add_submenu_page('','Docxpresso documents', 'Docxpresso documents', 'read',__DIR__.'/views/DXODownload.php');
    add_submenu_page('','Docxpresso documents', 'Docxpresso documents', 'read',__DIR__.'/views/DXOEdit.php');
    add_submenu_page('','Docxpresso documents', 'Docxpresso documents', 'read',__DIR__.'/views/DXOResponseURL.php');
}





