<?php
/**
 * Created by IntelliJ IDEA.
 * User: gushe
 * Date: 01/09/2020
 * Time: 17:00
 */

/*
 * Download file.
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once(__DIR__ . '/../classes/Docxpresso/Utils.php');

use SDK_Docxpresso as SDK;

$template = $_GET['template'];
$token = $_GET['token'];

$options = get_option('docxpressoSaaS', array());

$optionsDocxpresso = array();
$optionsDocxpresso['pKey'] = $options['pKey'];
$optionsDocxpresso['docxpressoInstallation'] = $options['DocxpressoUrl'];
$email = $options['email'];


$APICall = new SDK\Utils($optionsDocxpresso);

$data = array(
    'id'=>$template,
    'token'=>$token
);

$link = $APICall->downloadDocument($data);

?>

<script>window.location.replace("<?php echo $link?>")</script>


