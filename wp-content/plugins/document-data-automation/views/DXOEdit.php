<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

$baseURL = get_site_url() . '/me/';

require_once(__DIR__ . '/../classes/Docxpresso/Utils.php');

use SDK_Docxpresso as SDK;

$template = $_POST['template'];
$token = $_POST['token'];
$metadata = $_POST['metaData'];

//base64_decode

$options = get_option('docxpressoSaaS', array());

$optionsDocxpresso = array();
$optionsDocxpresso['pKey'] = $options['pKey'];
$optionsDocxpresso['docxpressoInstallation'] = $options['DocxpressoUrl'];
$email = $options['email']; // Aquí está el problema. ! Debería tener el email del admin del Saas


$APICall = new SDK\Utils($optionsDocxpresso);


$responseURL = basename(dirname(__DIR__)) . '%2Fviews%2FDXOResponseURL.php';

$responseURL = site_url() . "/wp-admin/admin.php?page=" . $responseURL;
/*
 * Security:
 * Check if apikey is correct
 * Check if options->plugin is 1
 * Check if options->domain is equal to userLogin (current user)
 *
 * Get options to load the same values from original usage configuration:
 * - editableVars
 * - enforceValidation
 * - prefix
 * - reference
 */
$formFlag = false;
$tampering = false;


$editableVars = "";
$enforceValidation = "";
$prefix = "";
$reference = "";
$enduserid = "";

if ($metadata != "") {
    $metadata = rawurldecode($metadata);
    $metadata = stripslashes($metadata);
    $metaDataJson = json_decode($metadata);

    $it = 0;
    $totalUsages = count($metaDataJson);

    // Get first plugin usage
    do {
        $usageElement = $metaDataJson[$it];
        $pluginValue = $usageElement->plugin;
        $it++;
    } while ($pluginValue != 1 && $it < $totalUsages);

    //CheckSecurity APIKEY
    $timestamp = $usageElement->timestamp;
    $uniqid = $usageElement->uniqid;
    $APIKEY = $usageElement->APIKEY;
    $optionsUsageStr = $usageElement->options;

    $control = '';
    $control .= $template . '-';
    $control .= $timestamp . '-' . $uniqid;
    $control .= '-' . $optionsUsageStr;

    $dataKey = sha1($control, true);

    if ($APICall->apikey_control($APIKEY, $dataKey, $optionsDocxpresso['pKey'])) {
        $optionsUsageStr = $APICall->base64_decode_url_safe($optionsUsageStr);
        $optionsUsageJson = json_decode($optionsUsageStr);

        $display = $usageElement->display;

        // Get configuration from original usage
        if ($display != 'document') {
            $formFlag = true;
        }

        if (isset($optionsUsageJson->editableVars)) {
            $editableVars = $optionsUsageJson->editableVars;
        }

        if (isset($optionsUsageJson->enforceValidation)) {
            $enforceValidation = $optionsUsageJson->enforceValidation;
        }

        if (isset($optionsUsageJson->prefix)) {
            $prefix = $optionsUsageJson->prefix;
        }

        if (isset($optionsUsageJson->reference)) {
            $reference = $optionsUsageJson->reference;
        }
        // Check security, domain must be equal to current user.
        if (isset($optionsUsageJson->domain)) {
            $current_user = wp_get_current_user();
            $userLogin = $current_user->user_login;

            if ($optionsUsageJson->domain != $baseURL . $userLogin) {
                //echo "tampering por domain";
                $tampering = true;
            }
        }
        if (isset($optionsUsageJson->enduserid)) {
            $enduserid = $optionsUsageJson->enduserid;
        }

        // check security, the usage must be from plugin.
        if($optionsUsageJson->plugin != 1 ){
            //echo "tampering por plugin";
            $tampering = true;
        }

    } else {
        //echo "tampering por apikey";
        $tampering = true;
    }
}

$data = array(
    'template' => $template,
    'token' => $token,
    'responseURL' => $responseURL,
    'editableVars' => $editableVars,
    'enforceValidation' => $enforceValidation,
    'prefix' => $prefix,
    'reference' => $reference,
    'plugin' => 1,
    'enduserid' => $enduserid
);

if ($formFlag) {
    $data['form'] = 1;
}

$link = $APICall->previewDocument($data);

if (!$tampering) {
    ?>

    <script>window.location.href = "<?php echo $link?>"</script>
    <?php
} else {
    echo "Access denied";
}
?>
