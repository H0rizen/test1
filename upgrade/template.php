<?php

if( ! defined( 'DATALIFEENGINE' ) ) {
	die( "Hacking attempt!" );
}


$skin_header = <<<HTML
<!doctype html>
<html>
<head>
  <meta charset="{$config['charset']}">
  <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
  <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
  <title>DataLife Engine - آپگرید سیستم</title>
  <link href="../engine/skins/stylesheets/application.css" media="screen" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="../engine/skins/javascripts/application.js"></script>
<style type="text/css">
body {
	background: url("../engine/skins/images/bg.png");
}
</style>
</head>
<body>
<script language="javascript" type="text/javascript">
<!--
var dle_act_lang   = ["بله", "خیر", "ورود", "انصراف", "آپلود فایل و تصاویر به سرور"];
var cal_language   = {en:{months:['ژانویه','فبریه','مارس','آوریل','می','ژوئن','جولای','آگوست','سپتامبر','اکتبر','نوامبر','دسامبر'],dayOfWeek:["یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنجشنبه", "جمعه", "شنبه"]}};
//-->
</script>
<nav class="navbar navbar-default navbar-inverse navbar-static-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <a class="navbar-brand" href="">دیتالایف انجین فارسی</a>
  </div>
</nav>
<div class="container">
  <div class="col-md-8 col-md-offset-2">
    <div class="padded">
	    <div style="margin-top: 80px;">
<!--MAIN area-->
HTML;

// ********************************************************************************
// Skin FOOTER
// ********************************************************************************
$skin_footer = <<<HTML
	 <!--MAIN area-->
    </div>
  </div>
</div>
</div>

</body>
</html>
HTML;

function msgbox($type, $title, $text, $back=FALSE){
global $lang, $skin_header, $skin_footer, $config;

$_SESSION['dle_update']=intval($_SESSION['dle_update'])+1;
if( $back ) $post_action=$config['http_home_url']; else $post_action="index.php";

  echo $skin_header;

echo <<<HTML
<form action="{$post_action}" method="get">
<div class="box">
  <div class="box-header">
    <div class="title">{$title}</div>
  </div>
  <div class="box-content">
	<div class="row box-section">
		{$text}
	</div>
	<div class="row box-section">	
		<input class="btn btn-green" type=submit value="مرحله بعد">
	</div>
	
  </div>
</div>
<input type="hidden" name="next" value="{$_SESSION['dle_update']}">
</form>
HTML;

  echo $skin_footer;

  exit();
}

$login_panel = <<<HTML
<!doctype html>
<html>
<head>
  <meta charset="{$config['charset']}">
  <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
  <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
  <title>DataLife Engine</title>
  <link href="../engine/skins/stylesheets/application.css" media="screen" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="../engine/skins/javascripts/application.js"></script>
<style type="text/css">
div.selector {
  width: 100%;
  height: 38px;
  margin-left: 2px;
}
div.selector:after {
    top: 6px;
}
div.selector span {
    padding: 0;	
    padding-left: 40px;
    height: 36px;
    line-height: 36px;
}
body {
	background: url("../engine/skins/images/bg.png");
  font-family: tahoma;
  direction: rtl;
  font-size: 11px;

}
.box {
	margin-bottom: 5px;
}
label {
    margin-bottom:0px;
}
.input-group input[type="text"], .input-group input[type="password"], .input-group input[type="email"], .input-group input[type="number"], .input-group input[type="text"], .input-group input[type="password"], .input-group input[type="email"], .input-group input[type="number"] {
    line-height: normal;
}
.input-group, .input-group {
  line-height: normal;
}
</style>
</head>
<body>

<script language="javascript" type="text/javascript">
<!--
var dle_act_lang   = [];
var cal_language   = {en:{months:[],dayOfWeek:[]}};
//-->
</script>
<nav class="navbar navbar-default navbar-inverse navbar-static-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <a class="navbar-brand" href=""><img src="../engine/skins/images/logo.png" /></a>
  </div>
</nav>
<div class="container">
  <div class="col-md-4 col-md-offset-4">
    <div class="padded">
<!--MAIN area-->


	<div class="login box" style="margin-top: 80px;">

      <div class="box-header">
        <span class="title">اطلاعات ورود</span>
      </div>
	  
      <div class="box-content padded">
        <form  name="login" action="" method="post" class="separate-sections"><input type="hidden" name="action" value="dologin">
          <div class="input-group addon-left">
            <span class="input-group-addon">
              <i class="icon-user"></i>
            </span>
            <input type="text" name="username" placeholder="نام کاربری را وارد کنید">
          </div>

          <div class="input-group addon-left">
            <span class="input-group-addon">
              <i class="icon-key"></i>
            </span>
            <input type="password" name="password" placeholder="رمز عبور را وارد کنید">
          </div>

		  <div class="input-group addon-left">
			برای آپگرید سیستم، نام کاربری و رمز عبور مدیریت را وارد کنید
			<br /><br /><button type="submit" class="btn btn-blue btn-block">ورود <i class="icon-signin"></i></button>
          </div>

        </form>

        <div>
          {result}
        </div>
      </div>

    </div>
	<div class="text-center">Copyright 2006-2015 &copy; <a href="http://datalifeengine.ir" target="_blank">Datalife Engine Farsi</a>. All rights reserved.</div>



	 <!--MAIN area-->
  </div>
</div>
</div>

</body>
</html>
HTML;

$is_logged = false;
$result="";

if ($_SESSION['member_name'] != "") {

	$member_name = $db->safesql($_SESSION['member_name']);
	$password = $db->safesql($_SESSION['member_password']);

	if (version_compare($version_id, '4.2', ">")) $password = md5($_SESSION['member_password']);

	if (!defined('USERPREFIX')) {
		define('USERPREFIX', PREFIX);
	}

	$db->query("SELECT * FROM " . USERPREFIX . "_users WHERE name='$member_name' AND password='$password' AND user_group = '1'");

	if ($db->num_rows() > 0){
		$member_id = $db->get_row();
		$is_logged = TRUE;
	}

	$db->free();
}

if ($_POST['action'] == "dologin")
{

	$login_name = $db->safesql($_POST['username']);
	
	$login_password = md5($_POST['password']);

	if (version_compare($version_id, '4.2', ">")) $pass = md5($login_password); else $pass = $login_password;

	if (!defined('USERPREFIX')) {
		define('USERPREFIX', PREFIX);
	}

	$db->query("SELECT * FROM " . USERPREFIX . "_users where name='$login_name' and password='$pass' and user_group = '1'");

	if ($db->num_rows() > 0){
	
			$member_id = $db->get_row();
	
	        $_SESSION['member_name']        = $member_id['name'];
	        $_SESSION['member_password']    = $login_password;
	
	        $is_logged = TRUE;
	} else $result="<font color=\"red\">نام کاربری یا رمز عبور نادرست است!</font>";

	$db->free();
}

if(!$is_logged) {
	$login_panel = str_replace("{result}", $result, $login_panel);
	echo $login_panel;
	exit();
}

if(!is_writable(ENGINE_DIR.'/data/')){
  msgbox("info","پیام سیستم", "دسترسی بر روی پوشه 'engine/data/' را روی 777 تنظیم کنید");
}

if(!is_writable(ENGINE_DIR.'/data/config.php')){
  msgbox("info","پیام سیستم", "دسترسی بر روی فایل 'engine/data/config.php' را روی 666 تنظیم کنید");
}

if(!is_writable(ENGINE_DIR.'/data/dbconfig.php')){
  msgbox("info","پیام سیستم", "دسترسی بر روی فایل 'engine/data/dbconfig.php' را روی 666 تنظیم کنید");
}

if(!is_writable(ENGINE_DIR.'/data/xfields.txt')){
  msgbox("info","پیام سیستم", "دسترسی بر روی فایل 'engine/data/xfields.txt' را روی 666 تنظیم کنید");
}

if( !$_SESSION['dle_update'] ) {

  echo $skin_header;
  
echo <<<HTML
<form action="index.php" method="GET">
<input type="hidden" name="next" value="start">
<div class="box">
  <div class="box-header">
    <div class="title">پیام سیستم</div>
  </div>
  <div class="box-content">
  <div class="row box-section">
    <font color="red"><b>توجه:</b></font> قبل از آپگريد ديتالايف انجين به نسخه جديد، حتماً بک آپ کامل هم از سايت و  هم از ديتابيس گرفته باشيد تا در صورت انجام عمل اشتباه، بتوانيد سايت را به حالت اوليه برگردانيد.
  </div>
  <div class="row box-section">
    نسخه فعلي اسکريپت شما: <b>{$version_id}</b>, نسخه موجود براي آپگريد: <b>{$dle_version}</b>
  </div>
  <div class="row box-section"> 
    <input class="btn btn-green" type=submit value="شروع آپگرید">
  </div>
  
  </div>
</div>
</form>
HTML;

	echo $skin_footer;
	
	$_SESSION['dle_update'] =1;
	exit();
}
?>