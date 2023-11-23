<?php
//error_reporting(0);
if (!defined('ABSPATH')) exit; // Exit if accessed directly


require_once(__DIR__ . '/../classes/Docxpresso/Utils.php');

use SDK_Docxpresso as SDK;

/*
 * Url to redirect download and edit.
 */
$LocationsVars = array(
    'urlDXODownload' => basename(dirname(__DIR__)) . '%2Fviews%2FDXODownload.php',
    'urlDXOEdit' => basename(dirname(__DIR__)) . '%2Fviews%2FDXOEdit.php'
);


// Register the script
wp_register_script('dxo_thick', plugins_url('/js/dxo-tb-usages.js', __DIR__));
wp_register_script('dxo_peity', plugins_url('/lib/vendor/js/jquery.peity.min.js', __DIR__));
wp_localize_script('dxo_thick', 'LocationVars', $LocationsVars);
wp_enqueue_style('dxosaas', plugins_url('/css/dxosaas.css', __DIR__));
wp_enqueue_style('font-awesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

wp_enqueue_script('dxo_thick', plugins_url('/js/dxo-tb-usages.js', __DIR__));
wp_enqueue_script('dxo_peity', plugins_url('/lib/vendor/js/jquery.peity.min.js', __DIR__));

if (!class_exists('WP_Http')) {
    include_once(ABSPATH . WPINC . '/class-http.php');
}

add_thickbox();

$Templates = array();
$options = get_option('docxpressoSaaS', array());

$optionsDocxpresso = array();
$optionsDocxpresso['pKey'] = $options['pKey'];
$optionsDocxpresso['docxpressoInstallation'] = $options['DocxpressoUrl'];
$email = $options['email'];

$APICall = new SDK\Utils($optionsDocxpresso);

//Log into the Docxpresso instance
$dxo_logged = false;

//Get current user. Domain value.
$current_user = wp_get_current_user();
$userLogin = $current_user->user_login;

if (isset($_POST['filterReference'])) {
    $filterReference = $_POST['filterReference'];
    $filterIdentifier = $_POST['filterIdentifier'];
    $filterPeriod = $_POST['filterPeriod'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    //2018-04-01
    $startDateArray = explode("-", $startDate);
	if(!empty($startDateArray[2])){
		$dayAfter = $startDateArray[2];
	} else {
		$dayAfter = "";
	}
	if(!empty($startDateArray[1])){
		$monthAfter = $startDateArray[1];
	} else {
		$monthAfter = "";
	}
    
    $yearAfter = $startDateArray[0];

    $endDateArray = explode("-", $endDate);
	if(!empty($endDateArray[2])){
		$dayBefore = $endDateArray[2];
	} else {
		$dayBefore = "";
	}
	if(!empty($endDateArray[1])){
		$monthBefore = $endDateArray[1];
	} else {
		$monthBefore = "";
	}
    $yearBefore = $endDateArray[0];

} else {
    $filterReference = "";
    $filterIdentifier = "";
    $filterPeriod = "";

    $dayAfter = "";
    $monthAfter = "";
    $yearAfter = "";

    $startDate = "";
    $endDate = "";

    //Before today 2020-09-01 16:46:54
    $today = current_time('mysql');
    $todayArray = explode(" ", $today);
    $today2Str = $todayArray['0'];

    $todayArray2 = explode("-", $today2Str);
    $dayBefore = $todayArray2[2];
    $monthBefore = $todayArray2[1];
    $yearBefore = $todayArray2[0];

}
$domainToSearch = get_site_url() . '/me/' . $userLogin;
$usagesToLoad = $APICall->getUsageDataPaginated(1, array('domain' => $domainToSearch, 'identifier' => $filterIdentifier, 'reference' => $filterReference, 'period' => $filterPeriod, 'startDate' => $startDate, 'endDate' => $endDate));
/*
 * User capabilites.
 * get user data, if not exists, default values.
 */

$user_data_array = get_user_meta($current_user->ID, "DXOCapabilities", true);

if (empty($user_data_array)) {
    // Create for defaults

    if (isset($options['DXOCapabilitiesEditDefault'])) {
        $editDefault = $options['DXOCapabilitiesEditDefault'];
    } else {
        $editDefault = 0;
    }

    if (isset($options['DXOCapabilitiesDownloadDefault'])) {
        $downloadDefault = $options['DXOCapabilitiesDownloadDefault'];
    } else {
        $downloadDefault = 1;
    }

    $user_data_array = array(
        'Edit' => $editDefault,
        'Download' => $downloadDefault,
        'info' => ''
    );


    $updated = update_user_meta($current_user->ID, 'DXOCapabilities', $user_data_array);
}

$DXOUserCapEdit = $user_data_array['Edit'];
$DXOUserCapDownload = $user_data_array['Download'];

echo '<script>' . PHP_EOL;
echo 'var DXO = {};' . PHP_EOL;
echo 'DXO.siteURL = "' . get_site_url() . '";' . PHP_EOL;
echo 'DXO.installation = "' . $options['DocxpressoUrl'] . '";' . PHP_EOL;
echo 'DXO.usages = "' . $usagesToLoad . '";' . PHP_EOL;

echo 'DXO.user_login = "' . $userLogin . '";' . PHP_EOL;
echo 'DXO.closeConnection = 0;' . PHP_EOL;
echo 'DXO.templateSelected = 0;' . PHP_EOL;
echo 'function LogOutDXO(){window.location.href="' . get_site_url() . '/wp-admin";}' . PHP_EOL;
echo 'DXO.user_edit = "' . $DXOUserCapEdit . '";' . PHP_EOL;
echo 'DXO.user_download = "' . $DXOUserCapDownload . '";' . PHP_EOL;

//add the required tranlations
echo 'var trans_DXO = {};' . PHP_EOL;
echo 'trans_DXO.selectTemplate = "' . __('Select Docxpresso Template', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.name = "' . __('Name', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.actions = "' . __('Actions', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.comp = "' . __('Comp.', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.last = "' . __('Last use', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.uses = "' . __('# uses', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.created = "' . __('Created', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.identifier = "' . __('Identifier', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.reference = "' . __('Reference', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.of = "' . __('of', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.loading = "' . __('Loading data', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.document = "' . __('Document', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.data = "' . __('Data', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.template = "' . __('Template', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.usage = "' . __('Usage', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.edit = "' . __('Edit', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.workflowactions = "' . __('You cannot perform the action because the document has a workflow associated', 'document-data-automation') . '";' . PHP_EOL;
echo 'trans_DXO.templateName = "' . __('Templates', 'document-data-automation') . '";' . PHP_EOL;
echo '</script>' . PHP_EOL;
if (function_exists('get_current_screen')) {
	require_once dirname(__FILE__) . '/partials/dashboard_admin.php';
} else {
	require_once dirname(__FILE__) . '/partials/dashboard_user.php';
}
?>