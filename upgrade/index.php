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

session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

error_reporting(E_ALL ^ E_NOTICE);
@ini_set('display_errors', true);
@ini_set('html_errors', false);
@ini_set('error_reporting', E_ALL ^ E_NOTICE);

define('DATALIFEENGINE', true);
define('ROOT_DIR', "..");
define('ENGINE_DIR', ROOT_DIR.'/engine');

require_once(ENGINE_DIR.'/data/config.php');
require_once('mysql.php');
require_once(ENGINE_DIR.'/data/dbconfig.php');
require_once(ENGINE_DIR.'/inc/include/functions.inc.php');

$version_id = ($config_version_id) ? $config_version_id : $config['version_id'];

extract($_REQUEST, EXTR_SKIP);

$theme = ENGINE_DIR;

$dle_version = "11.0";
$distr_charset = "utf-8";

@header("Content-type: text/html; charset=".$distr_charset);

require_once(dirname (__FILE__).'/template.php');

if ( strtolower($config['charset']) != $distr_charset ) {
	msgbox("info", "اطلاعات", "Encoding دیتابیس شما با Encoding سایت شما برابر نیست. درحال حاضر Encoding سایت شما بر روی: <b>{$config['charset']}</b> قرار دارد. ولی دیتابیس شما <b>{$distr_charset}</b> هست. لطفاً تغییرات Encoding را در فایل Config انجام دهید.");
	die();
}

switch ($version_id) {

case $dle_version :
	include dirname (__FILE__).'/finish.php';
	break;

case "10.6" :
	include dirname (__FILE__).'/10.6.php';
	break;

case "10.5" :
	include dirname (__FILE__).'/10.5.php';
	break;

case "10.4" :
	include dirname (__FILE__).'/10.4.php';
	break;

case "10.3" :
	include dirname (__FILE__).'/10.3.php';
	break;

case "10.2" :
	include dirname (__FILE__).'/10.2.php';
	break;

case "10.1" :
	include dirname (__FILE__).'/10.1.php';
	break;

case "10.0" :
	include dirname (__FILE__).'/10.0.php';
	break;

case "9.8" :
	include dirname (__FILE__).'/9.8.php';
	break;

case "9.7" :
	include dirname (__FILE__).'/9.7.php';
	break;

case "9.6" :
	include dirname (__FILE__).'/9.6.php';
	break;

case "9.5" :
	include dirname (__FILE__).'/9.5.php';
	break;

case "9.4" :
	include dirname (__FILE__).'/9.4.php';
	break;

case "9.3" :
	include dirname (__FILE__).'/9.3.php';
	break;

case "9.2" :
	include dirname (__FILE__).'/9.2.php';
	break;

case "9.0" :
	include dirname (__FILE__).'/9.0.php';
	break;

case "8.5" :
	include dirname (__FILE__).'/8.5.php';
	break;

case "8.3" :
	include dirname (__FILE__).'/8.3.php';
	break;

case "8.2" :
	include dirname (__FILE__).'/8.2.php';
	break;

case "8.0" :
	include dirname (__FILE__).'/8.0.php';
	break;

case "7.5" :
	include dirname (__FILE__).'/7.5.php';
	break;

case "7.3" :
	include dirname (__FILE__).'/7.3.php';
	break;

case "7.2" :
	include dirname (__FILE__).'/7.2.php';
	break;

case "7.0" :
	include dirname (__FILE__).'/7.0.php';
	break;

case "6.7" :
	include dirname (__FILE__).'/6.7.php';
	break;

case "6.5" :
	include dirname (__FILE__).'/6.5.php';
	break;

case "6.3" :
	include dirname (__FILE__).'/6.3.php';
	break;

case "6.2" :
	include dirname (__FILE__).'/6.2.php';
	break;

case "6.0" :
	include dirname (__FILE__).'/6.0.php';
	break;

default:
	include dirname (__FILE__).'/error.php';
}

?>