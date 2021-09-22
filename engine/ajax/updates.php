<?php
/*
=====================================================
 DataLife Engine v11
-----------------------------------------------------
 Persian support site: http://datalifeengine.ir
-----------------------------------------------------
 Copyright (c) 2006-2016, All rights reserved.
=====================================================
*/

@error_reporting(7);
@ini_set('display_errors', true);
@ini_set('html_errors', false);

define('DATALIFEENGINE', true);
define('ROOT_DIR', '../..');
define('ENGINE_DIR', '..');

include ENGINE_DIR.'/data/config.php';

if ($config['http_home_url'] == "") {

	$config['http_home_url'] = explode("engine/ajax/updates.php", $_SERVER['PHP_SELF']);
	$config['http_home_url'] = reset($config['http_home_url']);
	$config['http_home_url'] = "http://".$_SERVER['HTTP_HOST'].$config['http_home_url'];

}

require_once ENGINE_DIR.'/inc/include/functions.inc.php';

$selected_language = $config['langs'];

if (isset( $_COOKIE['selected_language'] )) { 

	$_COOKIE['selected_language'] = totranslit( $_COOKIE['selected_language'], false, false );

	if (@is_dir ( ROOT_DIR . '/language/' . $_COOKIE['selected_language'] )) {
		$selected_language = $_COOKIE['selected_language'];
	}

}

require_once ROOT_DIR.'/language/'.$selected_language.'/adminpanel.lng';

$config['charset'] = ($lang['charset'] != '') ? $lang['charset'] : $config['charset'];

@header("HTTP/1.0 200 OK");
@header("HTTP/1.1 200 OK");
@header("Cache-Control: no-cache, must-revalidate, max-age=0");
@header("Expires: 0");
@header("Pragma: no-cache");
@header("Content-type: text/css; charset=".$config['charset']);

$data = @file_get_contents("http://www.datalifeengine.ir/updatesdle.php?version_id=".$_REQUEST['versionid']);

if (!strlen($data)) echo $lang['no_update']; else echo $data;
?>