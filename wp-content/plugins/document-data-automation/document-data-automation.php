<?php

/*
  Plugin Name: Document & Data Automation
  Description: Connects to your Docxpresso Cloud installation
  Text Domain: document-data-automation
  Domain Path: languages
  Version: 1.6.1
  Author: No-nonsense Labs
  Author URI: http://www.docxpresso.com
 */

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

require_once dirname(__FILE__) . "/classes/Docxpresso/Utils.php";
require_once dirname(__FILE__) . "/custom.php";

use SDK_Docxpresso as SDK;

if (is_admin()) {
    include dirname(__FILE__) . '/admin.php';
}

function docxpresso_saas_call($attrs, $content = null) {
    //get optins
    $options = get_option('docxpressoSaaS', array());
    //js scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('iframejs', plugins_url('/lib/vendor/js/iframeResizer.min.js', __FILE__));
    wp_enqueue_script('resizerscript', plugins_url('/js/resizerscript.js', __FILE__));
    wp_register_script('DXOMessaging', plugins_url('/js/docxpresso_messaging.js', __FILE__));

    //css
    wp_enqueue_style('dxosaas', plugins_url('/css/dxosaas.css', __FILE__));
    //test for adding user customized styles
    $custom_css = ".DXOiFrame iframe{" . $options['dxoFrameStyle'] . "}" . PHP_EOL;
    $custom_css .= ".DXONotify{" . $options['dxoMessageStyle'] . "}" . PHP_EOL;
    //$custom_css = ".DXOiFrame{border: 10px solid red;}";
    wp_add_inline_style('dxosaas', $custom_css);


    $urlDocxpresso = $options['DocxpressoUrl'];
    if (substr($urlDocxpresso, -1) == '/') {
        $urlDocxpresso = substr($urlDocxpresso, 0, -1);
    }
    $optionsDocxpresso = array();
    $optionsDocxpresso['pKey'] = $options['pKey'];
    $optionsDocxpresso['docxpressoInstallation'] = $urlDocxpresso;

    $APICall = new SDK\Utils($optionsDocxpresso);

    $data = array();

    $data['template'] = $attrs['template'];
    $nameDocument = $attrs['name'];
    $postType = $attrs['typecontent'];
    $label = $attrs['label'];

    if (empty($label)) {
        $label = "data request";
    }

    if (strcmp($attrs['typecontent'], "true") == 0) {
        $postType = "tipoContenido";
    } else {
        $postType = "0";
    }

    $target = $attrs['target'];
    if ($attrs['form'] == 'true') {
        $data['form'] = true;
    } else {
        $data['form'] = false;
    }

    if (strcmp($attrs['enforcevalidation'], "true") == 0) {
        $data['enforceValidation'] = $attrs['enforcevalidation'];
    }
    /*
     * This is commented because the redirection must be done within WP
    if (!empty($attrs['responseurl'])) {
        $data['responseURL'] = $attrs['responseurl'];
    }
    */
    
    //go over advanced variables
    if (!empty($attrs['prefix'])){
        $data['prefix'] = $attrs['prefix'];
    }
    if (!empty($attrs['editablevars'])){
        $data['editableVars'] = $attrs['editablevars'];
    }

    /*
     * Modification for managing user documents
     */
    if(wp_get_current_user() !== 0){
        // user is logged
        $current_user = wp_get_current_user();
        $userLogin = $current_user->user_login;

        $data['domain'] = get_site_url() . '/me/' . $userLogin;
		//we add the wp_ prefix to now this user is a plugin user within Docxpresso
        $data['enduserid'] = 'wp_'.$userLogin;

    }else{
        $data['domain'] = get_site_url();
    }

    $data['custom'] = 'Wordpress';

    
    /* CUSTOM DATA */
    //here we have to do whatever to include extra options to the Docxpresso URL
    if (function_exists('forwardDocxpressoData')){
        //the Docxpresso template id is stored in $data['template'];
        $data = forwardDocxpressoData($data);
    }
    
    /* USAGE TOKEN */
    //check if there is Docxpresso token in the URL
    $token = get_query_var('dxoToken');
    if(!empty($token)){
        $data['token'] = $token;
    }

    if (!empty($attrs['targetlink'])) {
        $targetWindow = $attrs['targetlink'];
    } else {
        $targetWindow = '_self';
    }

    $data['plugin'] = 1;

    if ($target == 'embebed') {
        $url = $APICall->previewDocument($data);
        $urlFinal = '<div class="DXOiFrame"><iframe src=' . $url . ' width="100%" scrolling="no" allow="geolocation; microphone; camera"></iframe></div>';
    } else if ($target == 'link') {
        if (!empty($attrs['responseurl']) && $attrs['response'] == 'url') {
            $data['responseURL'] = $attrs['responseurl'];
        } else if ($attrs['response'] == 'url'){
            $data['responseURL'] = $options['dxoRedirectURL'];
        }
        $url = $APICall->previewDocument($data);
        $urlFinal = '<a href="' . $url . '" target="' . $targetWindow . '">' . $label . '</a> ';
    }

    $DXOptions = [];
    $DXOptions['type'] = $attrs['response'];
    $DXOptions['installation'] = $urlDocxpresso;
    if ($DXOptions['type'] == 'message') {
        if (!empty($attrs['message'])) {
            $DXOptions['message'] = $attrs['message'];
        } else {
            $DXOptions['message'] = $options['dxoMessage'];
        }
    } else if ($DXOptions['type'] == 'url') {
        if (!empty($attrs['responseurl'])) {
            $DXOptions['url'] = $attrs['responseurl'];
        } else {
            $DXOptions['url'] = $options['dxoRedirectURL'];
        }
    }

    wp_localize_script('DXOMessaging', 'DXOptions', $DXOptions);
    wp_enqueue_script('DXOMessaging', plugins_url('/js/docxpresso_messaging.js', __FILE__));

    return $urlFinal;
}

function myplugin_load_textdomain() {
    load_plugin_textdomain('document-data-automation', false, basename(dirname(__FILE__)) . '/languages');
}

function dxo_query_vars($qvars) {
    $qvars[] = 'dxoToken';
    return $qvars;
}

add_action('init', 'myplugin_load_textdomain');
add_shortcode('docxpresso_document', 'docxpresso_saas_call');
add_filter('query_vars', 'dxo_query_vars');

//Include widgets
function API(){
	$options = get_option('docxpressoSaaS', array());
	$urlDocxpresso = $options['DocxpressoUrl'];
    if (substr($urlDocxpresso, -1) == '/') {
        $urlDocxpresso = substr($urlDocxpresso, 0, -1);
    }
	$optionsDocxpresso = array();
    $optionsDocxpresso['pKey'] = $options['pKey'];
    $optionsDocxpresso['docxpressoInstallation'] = $urlDocxpresso;

    $APICall = new SDK\Utils($optionsDocxpresso);
	return $APICall;
}
require_once dirname(__FILE__) . "/widgets.php";
