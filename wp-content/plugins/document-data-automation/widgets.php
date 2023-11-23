<?php

//[DXPlainLink tid=13 redirect="dx-plain-link"]
function DXPlainLink_func( $atts ){
	$APICall = API();
	$opts = array();
	$opts['template'] = $atts['tid'];
	if (!empty($atts['redirect'])){
		$opts['responseURL'] = get_site_url() . '/' . $atts['redirect'];
	}
	$url = $APICall->previewDocument($opts);
	return $url;
}
add_shortcode( 'DXPlainLink', 'DXPlainLink_func' );

//[DXDownloadLink]
function DXDownloadLink_func( $atts ){
	$APICall = API();
	if (!empty($_GET['options'])){
		$options = base64_decode_url_safe($_GET['options']);
		$data = json_decode($options);
		//var_dump($data);
		$url = $APICall->downloadDocument(array('id' => $data->templateId, 'token' => $data->token));
		return $url;
	} else {
		return;
	}
}
add_shortcode( 'DXDownloadLink', 'DXDownloadLink_func' );

//[DXDashboard]
function DXDashboard_func( $atts ){
	ob_start();
	require_once dirname(__FILE__) . '/views/docxpresso_documents.php';
	$output = ob_get_contents();
	ob_clean();
	$code = '<div id="DXDashboard">';
	$code .= $output;
	$code .= '</div>';
	return $code;
}
add_shortcode( 'DXDashboard', 'DXDashboard_func' );

function base64_decode_url_safe($str){
	return base64_decode(strtr($str, '-_,', '+/='));
}

