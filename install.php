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

@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );

define('DATALIFEENGINE', true);
define('ROOT_DIR', dirname (__FILE__));
define('ENGINE_DIR', ROOT_DIR.'/engine');

$distr_charset = "utf-8";
$db_charset = "utf8";

header("Content-type: text/html; charset=".$distr_charset);

require_once(ROOT_DIR.'/language/Farsi/adminpanel.lng');
require_once(ENGINE_DIR.'/inc/include/functions.inc.php');


$skin_header = <<<HTML
<!doctype html>
<html>
<head>
  <meta charset="{$distr_charset}">
  <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
  <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
  <title>DataLife Engine - نصب سیستم</title>
  <link href="engine/skins/stylesheets/application.css" media="screen" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="engine/skins/javascripts/application.js"></script>
<style type="text/css">
body {
	background: url("engine/skins/images/bg.png");

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
  <div class="navbar-header">
    <a class="navbar-brand" href="">نصب دیتالایف انجین</a>
  </div>
</nav>
<div class="container">
  <div class="col-md-8 col-md-offset-2">
    <div class="padded">
	    <div style="margin-top: 10px;">
<!--MAIN area-->
HTML;


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
global $lang, $skin_header, $skin_footer;

  if ($back) $back = "onclick=\"history.go(-1); return false;\""; else $back = "";

  echo $skin_header;

echo <<<HTML
<form action="install.php" method="get">
<div class="box">
  <div class="box-header">
    <div class="title">{$title}</div>
  </div>
  <div class="box-content">
	<div class="row box-section">
		{$text}
	</div>
	<div class="row box-section">
		<input {$back} class="btn btn-green" type=submit value="Next">
	</div>

  </div>
</div>
</form>
HTML;

  echo $skin_footer;

  exit();
}

function GetRandInt($max){

	if(function_exists('openssl_random_pseudo_bytes') && (version_compare(PHP_VERSION, '5.3.4') >= 0 || strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')) {
	     do{
	         $result = floor($max*(hexdec(bin2hex(openssl_random_pseudo_bytes(4)))/0xffffffff));
	     }while($result == $max);
	} else {

		$result = mt_rand( 0, $max );
	}

    return $result;
}

function generate_auth_key() {

    $arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',
                 'm','n','o','p','r','s',
                 't','u','v','x','y','z',
                 'A','B','C','D','E','F',
                 'G','H','I','J','K','L',
                 'M','N','O','P','R','S',
                 'T','U','V','X','Y','Z',
                 '1','2','3','4','5','6',
                 '7','8','9','0','.',',',
                 '(',')','[',']','!','?',
                 '&','^','%','@','*',' ',
                 '<','>','/','|','+','-',
                 '{','}','`','~','#',';',
                 '/','|','=',':','`');

    $key = "";
    for($i = 0; $i < 64; $i++)
    {
      $index = GetRandInt(count($arr))-1;
      $key .= $arr[$index];
    }
    return $key;
}

extract($_REQUEST, EXTR_SKIP);

if($_REQUEST['action'] == "eula")
{

if ( !$_SESSION['dle_install'] ) msg( "", "خطا", "به صفحه اصلی نصب سیستم بازگردید و مراحل نصب را از اول طی کنید.<br /><br /><a href=\"http://{$_SERVER['HTTP_HOST']}/install.php\">http://{$_SERVER['HTTP_HOST']}/install.php</a>" );

  echo $skin_header;

echo <<<HTML
<form method="get" action="">
<input type=hidden name="action" value="chmod_check">
<div class="box">
  <div class="box-header">
    <div class="title">بررسی تنظیمات سرور</div>
  </div>
  <div class="box-content">
  <div class="row box-section">
<table class="table table-normal table-bordered">
<tr>
<td width="250">نوع نیازمندی</td>
<td colspan="2">مقدار</td>
</tr>
HTML;

    $status = phpversion() < '5.3' ? '<font color=red><b>خیر</b></font>' : '<font color=green><b>بله</b></font>';

   echo "<tr>
         <td>نسخه PHP از 5.3 به بالا</td>
         <td colspan=2>$status</td>
         </tr>";

    $status = function_exists('mysqli_connect') ? '<font color=green><b>بله</b></font>' : '<font color=red><b>خیر</b></font>';

   echo "<tr>
         <td>پشتیبانی از MySQLi</td>
         <td colspan=2>$status</td>
         </tr>";


    $status = extension_loaded('zlib') ? '<font color=green><b>بله</b></font>' : '<font color=red><b>خیر</b></font>';

   echo "<tr>
         <td>پشتیبانی از فشرده ساز ZLib</td>
         <td colspan=2>$status</td>
         </tr>";

    $status = extension_loaded('xml') ? '<font color=green><b>بله</b></font>' : '<font color=red><b>خیر</b></font>';

   echo "<tr>
         <td>پشتیبانی از XML</td>
         <td colspan=2>$status</td>
         </tr>";

    $status = function_exists('mb_convert_encoding') ? '<font color=green><b>بله</b></font>' : '<font color=red><b>No</b></font>';;

   echo "<tr>
         <td>پشتیبانی رشته های چند بایتی</td>
         <td colspan=2>$status</td>
         </tr>";

   echo "<tr>
         <td colspan=3><br />اگر مقدار هر یک از آیتم های بالا خیر بود، قبل از ادامه مراحل نصب، نسبت به تصحیح آیتم مورد نظر اقدام کنید (با مدیریت سرور تماس بگیرید).<br /><br /></td>
         </tr>";

    echo "<tr>
    <td>تنظیمات توصیه شده</td>
    <td width=\"200\">مقدار توصیه شده</td>
    <td>مقدار موجود</td>
    </tr>";

    $status = ini_get('safe_mode') ? '<font color=red><b>فعال</b></font>' : '<font color=green><b>غیرفعال</b></font>';

    echo"<tr>
         <td>Safe Mode</td>
         <td>غیرفعال</td>
         <td>$status</td>
         </tr>";

    $status = ini_get('file_uploads') ? '<font color=green><b>فعال</b></font>' : '<font color=red><b>غیرفعال</b></font>';

    echo"<tr>
         <td>آپلود فایل</td>
         <td>فعال</td>
         <td>$status</td>
         </tr>";

    $status = ini_get('output_buffering') ? '<font color=red><b>فعال</b></font>' : '<font color=green><b>غیرفعال</b></font>';

   echo "<tr>
         <td>Output buffering</td>
         <td>غیرفعال</td>
         <td>$status</td>
         </tr>";

    $status = ini_get('magic_quotes_runtime') ? '<font color=red><b>فعال</b></font>' : '<font color=green><b>غیرفعال</b></font>';

   echo "<tr>
         <td>Magic Quotes Runtime</td>
         <td>غیرفعال</td>
         <td>$status</td>
         </tr>";

    $status = ini_get('register_globals') ? '<font color=red><b>فعال</b></font>' : '<font color=green><b>غیرفعال</b></font>';

   echo "<tr>
         <td>Register Globals</td>
         <td>غیرفعال</td>
         <td>$status</td>
         </tr>";

    $status = ini_get('session.auto_start') ? '<font color=red><b>فعال</b></font>' : '<font color=green><b>غیرفعال</b></font>';

   echo "<tr>
         <td>Session auto start</td>
         <td>غیرفعال</td>
         <td>$status</td>
         </tr>";

   echo "<tr>
         <td colspan=3 class=\"note lagre\"><br />آیتم های بالا صرفاً جهت سازگاری کامل سیستم با سرور شما توصیه شده است. اسکریپت دیتالایف انجین قادر هست بدون آیتم های بالا هم بر روی سرور شما کار کند.<br /><br /></td>
         </tr>";

echo <<<HTML
</table>
	</div>
	<div class="row box-section">
		<input class="btn btn-green" type=submit value="مرحله بعد">
	</div>

  </div>
</div></form>
HTML;

}
// ********************************************************************************
// Checking write permissions
// ********************************************************************************
elseif($_REQUEST['action'] == "chmod_check")
{

if ( !$_SESSION['dle_install'] ) msg( "", "خطا", "به صفحه اصلی نصب سیستم بازگردید و مراحل نصب را از اول طی کنید.<br /><br /><a href=\"http://{$_SERVER['HTTP_HOST']}/install.php\">http://{$_SERVER['HTTP_HOST']}/install.php</a>" );

  echo $skin_header;

echo <<<HTML
<form method="get" action="">
<input type=hidden name="action" value="doconfig">
<div class="box">
  <div class="box-header">
    <div class="title">سطح دسترسی فولدرها</div>
  </div>
  <div class="box-content">
	<div class="row box-section">
<table class="table table-normal table-bordered" dir="ltr">
HTML;

echo"<thead><tr>
<td>Directory/File</td>
<td width=\"100\">CHMOD</td>
<td width=\"100\">وضعیت</td></tr></thead><tbody>";

$important_files = array(
'./backup/',
'./engine/data/',
'./engine/cache/',
'./engine/cache/system/',
'./uploads/',
'./uploads/files/',
'./uploads/fotos/',
'./uploads/posts/',
'./uploads/posts/thumbs/',
'./uploads/posts/medium/',
'./uploads/thumbs/',
'./templates/',
'./templates/Default/',
);


$chmod_errors = 0;
$not_found_errors = 0;
    foreach($important_files as $file){

        if(!file_exists($file)){
            $file_status = "<font color=red>نادرست!</font>";
            $not_found_errors ++;
        }
        elseif(is_writable($file)){
            $file_status = "<font color=green>درست</font>";
        }
        else{
            @chmod($file, 0777);
            if(is_writable($file)){
                $file_status = "<font color=green>درست</font>";
            }else{
                @chmod("$file", 0755);
                if(is_writable($file)){
                    $file_status = "<font color=green>درست</font>";
                }else{
                    $file_status = "<font color=red>نادرست</font>";
                    $chmod_errors ++;
                }
            }
        }
        $chmod_value = @decoct(@fileperms($file)) % 1000;

    echo"<tr>
         <td>$file</td>
         <td align='center'>$chmod_value</td>
         <td align='center'>$file_status</td>
         </tr>";
    }

if($chmod_errors == 0 and $not_found_errors == 0){

    $status_report = 'سطح دسترسی فولدرها بدون مشکل بوده و شما می توانید به ادامه روند نصب سیستم بپردازید.';

} else {
    
    if($chmod_errors > 0){
        $status_report = "<font color=red>خطا!!!</font><br /><br />در چک کردن فولدرها، مشاهده شد که <b>$chmod_errors</b> امکان نوشتن در آن وجود ندارد. !<br />لطفاً سطح دسترسی به فولدرهای مشخص شده با رنگ قرمز را بر روی 777 قرار دهید.<br /><br />تصحیح این مورد قبل از ادامه روند کار <font color=red><b>به شدت</b></font> توصیه می شود.<br />";
    }

    if($not_found_errors > 0){
        $status_report .= "<font color=red>خطا!!!</font><br />در چک کردن فولدرها، <b>$not_found_errors</b> فایل پیدا نشد!<br /><br />تصحیح این مورد قبل از ادامه روند کار <font color=red><b>به شدت</b></font> توصیه می شود.<br />";
    }
}

echo"<tr><td height=\"25\" align='right' colspan=3><span style='display: inline-block; direction: rtl; text-align: right'>نتیجه وضعیت سطح دسترسی:</span></td></tr><tr><td align='right' style=\"padding: 5px\" colspan=3><span style='display: inline-block; direction: rtl; text-align: right'>$status_report</span></td></tr>";

echo <<<HTML
</tbody></table>
	</div>
	<div class="row box-section">
		<input class="btn btn-green" type=submit value="مرحله بعد">
	</div>

  </div>
</div></form>
HTML;

} elseif($_REQUEST['action'] == "doconfig") {

    if ( !$_SESSION['dle_install'] ) msgbox( "", "خطا", "به صفحه اصلی نصب سیستم بازگردید و مراحل نصب را از اول طی کنید.<br /><br /><a href=\"http://{$_SERVER['HTTP_HOST']}/install.php\">http://{$_SERVER['HTTP_HOST']}/install.php</a>" );
    
    
    $url  = preg_replace( "'/install.php'", "", $_SERVER['HTTP_REFERER']);
    $url  = preg_replace( "'\?(.*)'", "", $url);
    
    if(substr("$url", -1) == "/"){
        $url = substr($url, 0, -1);
    }

  echo $skin_header;

  echo <<<HTML
<style>
.install-tbl { border-top: 1px solid #ddd; margin-top: 15px }
.install-tbl tr { margin: 2px; }
.install-tbl td { border-bottom: 1px solid #ddd; }
.install-tbl td:first-child { border-left: 1px solid #ddd; }
.install-tbl td:nth-child( odd ) { background: #f7f7f7; }
.install-tbl td:nth-child( even ) { background: #efefef; }
.table-head { background: #1177cc !important; color: #fff; border-left: 0 !important; text-align: center }
</style>
<form method="post" action="">
<input type=hidden name="action" value="doinstall">
<div class="box">
  <div class="box-header">
    <div class="title">پیکربندی سیستم</div>
  </div>
  <div class="box-content">
	<div class="row box-section">
جهت نصب سیستم مدیریت محتوای دیتالایف انجین، فرم زیر را تکمیل نمائید. در صورت نیاز، می توانید از آموزش نصب استفاده کنید. <a href="http://www.datalifeengine.ir/tutorial-video/2918-%D8%A2%D9%85%D9%88%D8%B2%D8%B4-%D9%86%D8%B5%D8%A8-%D8%AF%DB%8C%D8%AA%D8%A7%D9%84%D8%A7%DB%8C%D9%81-%D8%A7%D9%86%D8%AC%DB%8C%D9%86-%D8%B1%D9%88%DB%8C-%D9%84%D9%88%DA%A9%D8%A7%D9%84-%D9%87%D8%A7%D8%B3%D8%AA.html" target="_blank" style="color: #1177cc">ویدئو آموزش نصب</a>
<table width="100%" class="install-tbl" cellpadding="0" cellspacing="0">
HTML;

if ( $distr_charset == "utf-8" ) {
  
  $mb4 = '<tr><td style="padding: 5px;">استفاده از <span dir=ltr>4-Byte UTF-8</span>:<td style="padding: 5px;"><input type="checkbox" id="allow_mb4" name="allow_mb4" value="1" style="vertical-align: middle"> فعال<br /><span class="note large">برخی از نمادهای غیرمعمول ( مثل کاراکترهای تاریخی، موسیقی و Emoji ) به فضای بیشتری جهت ذخیره شدن در بانک اطلاعاتی نیاز دارند. اگر این گزینه را فعال نکنید، کاربران سایت امکان استفاده از این نوع کاراکترها را نخواهند داشت.</span></tr>';

} else $mb4 = "";

echo'<tr>
<td width="175" style="padding: 5px;" valign=top>آدرس جایگاه سیستم:
<td style="padding: 5px; line-height: 20px;"><input dir=ltr name=url value="'.$url.'/" size=38 type=text class="edit"><br/><span class="note large">آدرس محلی که این سیستم قرار دارد را وارد نمائید.<br/><b>توجه:</b> در پایان آدرس <font color=#FF0000>حتماً</font> کاراکتر <font color=#7722cc>/</font> باشد.<br />بطور مثال: <font color=#4400ff>/http://mysite.com/dle</font> یا <font color=#4400ff>/http://mysite.com</font></span></td></tr>
<tr><td colspan="3" height="40" class="table-head">اطلاعات مربوط به پایگاه داده ها (دیتابیس)<td></tr>
<tr><td style="padding: 5px;">سرور MYSQL:<td style="padding: 5px;"><input dir=ltr class="edit" type=text size="28" name="dbhost" value="localhost"> <span class="navigation" title="به صورت پیشفرض در بیشتر هاست ها، localhost هست."></span></tr>
<tr><td style="padding: 5px;">نام دیتابیس:<td style="padding: 5px;"><input dir=ltr class="edit" type=text size="28" name="dbname"></tr>
<tr><td style="padding: 5px;">نام کاربری دیتابیس:<td style="padding: 5px;"><input dir=ltr class="edit" type=text size="28" name="dbuser"></tr>
<tr><td style="padding: 5px;">کلمه عبور دیتابیس:<td style="padding: 5px;"><input dir=ltr class="edit" type=text size="28" name="dbpasswd"></tr>
<tr><td style="padding: 5px;">پیشوند جداول:<td style="padding: 5px;"><input dir=ltr class="edit" type=text size="28" name="dbprefix" value="dle"> <span class="navigation">[Prefix]</span></tr>
'.$mb4.'
<tr><td colspan="3" height="40" class="table-head">اطلاعات مربوط به مدیریت سایت<td></tr>
<tr><td style="padding: 5px;">نام کاربری مدیر سایت:<td style="padding: 5px;"><input dir=ltr class="edit" type=text size="28" name="reg_username" ></tr>
<tr><td style="padding: 5px;">کلمه عبور:<td style="padding: 5px;"><input dir=ltr class="edit" type=password size="28" name="reg_password1"></tr>
<tr><td style="padding: 5px;">تکرار کلمه عبور:<td style="padding: 5px;"><input dir=ltr class="edit" type=password size="28" name="reg_password2"></tr>
<tr><td style="padding: 5px;">ایمیل:<td style="padding: 5px;"><input dir=ltr class="edit" type=text size="28" name="reg_email"></tr>
<tr><td style="padding: 5px;">نام شما:<td style="padding: 5px;"><input dir=rtl class="edit" type=text size="28" name="fullname"></tr>
<tr><td colspan="3" height="40" class="table-head">تنظیمات سیستم<td></tr>
<tr><td style="padding: 5px;">عنوان سایت:<td style="padding: 5px;"><input dir=rtl class="edit" type=text size="28" name="site_title" value="دیتالایف انجین"></tr>
<tr><td style="padding: 5px;">فعال بودن لینک‌های دوستانه: 
<td style="padding: 5px;">
<select class=rating name="alt_url"><option value="0">خیر</option><option value="1">بله</option></select><br/>
<span class="note large">منظور از لینک‌های دوستانه یا Friendly URL، لینک‌هایی هستند که اخبار و صفحات داخلی سایت را بهینه شده و خوانا نمایش می‌سازند. طوری که تاثیر به سزایی در موتورهای جستجو دارند. یکی از روش های مهم سئو (SEO) بودن سایت، فعال بودن همین گزینه هست.</span>
</tr>';

echo <<<HTML
</table>
	</div>
	<div class="row box-section">
		<input class="btn btn-green" type=submit value="نصب سیستم">
	</div>

  </div>
</div></form>
HTML;

}
// ********************************************************************************
// Do Install
// ********************************************************************************
elseif($_REQUEST['action'] == "doinstall")
{

    if ( !$_SESSION['dle_install'] ) msg( "", "خطا", "به صفحه اصلی نصب سیستم بازگردید و مراحل نصب را از اول طی کنید.<br /><br /><a href=\"http://{$_SERVER['HTTP_HOST']}/install.php\">http://{$_SERVER['HTTP_HOST']}/install.php</a>" );

    if(!$reg_username or !$reg_email or !$reg_password1 or !$url or $reg_password1 != $reg_password2){ msgbox("error", "خطا!!!" ,"لطفاً تمامی فیلدهای مربوط به مدیریت رو وارد نمایید!", "history.go(-1)"); }
    if (preg_match("/[\||\'|\<|\>|\[|\]|\"|\!|\?|\$|\@|\#|\/|\\\|\&\~\*\{\+]/", $reg_username))
    {
      msgbox("error", "خطا!!!" ,"نام کاربری مدیریت معتبر نیست!", "javascript:history.go(-1)");  
    }

    $reg_password = md5(md5($reg_password1));

	$url = htmlspecialchars( $url, ENT_QUOTES, 'ISO-8859-1');
	$reg_email = htmlspecialchars( $reg_email, ENT_QUOTES, 'ISO-8859-1');
	$alt_url = intval( $alt_url );
	$url = str_replace( "$", "&#036;", $url );
	$reg_email = str_replace( "$", "&#036;", $reg_email );
	$timezone = date_default_timezone_get();
	
	$timezones = array('Pacific/Midway','US/Samoa','US/Hawaii','US/Alaska','US/Pacific','America/Tijuana','US/Arizona','US/Mountain','America/Chihuahua','America/Mazatlan','America/Mexico_City','America/Monterrey','US/Central','US/Eastern','US/East-Indiana','America/Lima','America/Caracas','Canada/Atlantic','America/La_Paz','America/Santiago','Canada/Newfoundland','America/Buenos_Aires','Greenland','Atlantic/Stanley','Atlantic/Azores','Africa/Casablanca','Europe/Dublin','Europe/Lisbon','Europe/London','Europe/Amsterdam','Europe/Belgrade','Europe/Berlin','Europe/Bratislava','Europe/Brussels','Europe/Budapest','Europe/Copenhagen','Europe/Madrid','Europe/Paris','Europe/Prague','Europe/Rome','Europe/Sarajevo','Europe/Stockholm','Europe/Vienna','Europe/Warsaw','Europe/Zagreb','Europe/Athens','Europe/Bucharest','Europe/Helsinki','Europe/Istanbul','Asia/Jerusalem','Europe/Kiev','Europe/Minsk','Europe/Riga','Europe/Sofia','Europe/Tallinn','Europe/Vilnius','Asia/Baghdad','Asia/Kuwait','Africa/Nairobi','Asia/Tehran','Europe/Kaliningrad','Europe/Moscow','Europe/Volgograd','Europe/Samara','Asia/Baku','Asia/Muscat','Asia/Tbilisi','Asia/Yerevan','Asia/Kabul','Asia/Yekaterinburg','Asia/Tashkent','Asia/Kolkata','Asia/Kathmandu','Asia/Almaty','Asia/Novosibirsk','Asia/Jakarta','Asia/Krasnoyarsk','Asia/Hong_Kong','Asia/Kuala_Lumpur','Asia/Singapore','Asia/Taipei','Asia/Ulaanbaatar','Asia/Urumqi','Asia/Irkutsk','Asia/Seoul','Asia/Tokyo','Australia/Adelaide','Australia/Darwin','Asia/Yakutsk','Australia/Brisbane','Pacific/Port_Moresby','Australia/Sydney','Asia/Vladivostok','Asia/Sakhalin','Asia/Magadan','Pacific/Auckland','Pacific/Fiji');

	if ( !in_array($timezone, $timezones) ) {
		$timezone = "Europe/Moscow";
		date_default_timezone_set ( $timezone );
	}

  if ( $distr_charset == "utf-8" AND $_POST['allow_mb4']) {
    $db_charset = "utf8mb4";
  }

$config = <<<HTML
<?PHP

//System Configurations

\$config = array (

'version_id' => "11.0",

'home_title' => "$site_title",

'http_home_url' => "{$url}",

'charset' => "{$distr_charset}",

'admin_mail' => "{$reg_email}",

'description' => "DataLife Engine Farsi v11",

'keywords' => "DataLife, Engine, Data, Life, Content, Management, System, CMS, PHP script, دیتالایف, انجین",

'date_adjust' => "{$timezone}",

'site_offline' => "0",

'allow_alt_url' => "{$alt_url}",

'langs' => "Farsi",

'skin' => "Default",

'allow_gzip' => "0",

'allow_admin_wysiwyg' => "0",

'allow_static_wysiwyg' => "0",

'news_number' => "10",

'smilies' => "bowtie,smile,laughing,blush,smiley,relaxed,smirk,heart_eyes,kissing_heart,kissing_closed_eyes,flushed,relieved,satisfied,grin,wink,stuck_out_tongue_winking_eye,stuck_out_tongue_closed_eyes,grinning,kissing,stuck_out_tongue,sleeping,worried,frowning,anguished,open_mouth,grimacing,confused,hushed,expressionless,unamused,sweat_smile,sweat,disappointed_relieved,weary,pensive,disappointed,confounded,fearful,cold_sweat,persevere,cry,sob,joy,astonished,scream,tired_face,angry,rage,triumph,sleepy,yum,mask,sunglasses,dizzy_face,imp,smiling_imp,neutral_face,no_mouth,innocent",

'timestamp_active' => "j M Y, H:i",

'news_sort' => "date",

'news_msort' => "DESC",

'hide_full_link' => "0",

'allow_site_wysiwyg' => "0",

'allow_comments' => "1",

'comm_nummers' => "30",

'comm_msort' => "ASC",

'flood_time' => "30",

'auto_wrap' => "80",

'timestamp_comment' => "j F Y H:i",

'allow_comments_wysiwyg' => "0",

'allow_registration' => "1",

'allow_cache' => "0",

'allow_votes' => "1",

'allow_topnews' => "1",

'allow_read_count' => "1",

'allow_calendar' => "1",

'allow_archives' => "1",

'files_allow' => "1",

'files_count' => "1",

'reg_group' => "4",

'registration_type' => "0",

'allow_sec_code' => "1",

'allow_skin_change' => "1",

'max_users' => "0",

'max_users_day' => "0",

'max_up_size' => "200",

'max_image_days' => "2",

'allow_watermark' => "1",

'max_watermark' => "150",

'max_image' => "200",

'jpeg_quality' => "85",

'files_antileech' => "1",

'allow_banner' => "1",

'log_hash' => "0",

'show_sub_cats' => "1",

'tag_img_width' => "0",

'mail_metod' => "php",

'smtp_host' => "localhost",

'smtp_port' => "25",

'smtp_user' => "",

'smtp_pass' => "",

'mail_bcc' => "0",

'speedbar' => "1",

'extra_login' => "0",

'image_align' => "left",

'ip_control' => "1",

'cache_count' => "0",

'related_news' => "1",

'no_date' => "1",

'mail_news' => "1",

'mail_comments' => "1",

'admin_path' => "admin.php",

'rss_informer' => "1",

'allow_cmod' => "0",

'max_up_side' => "0",

'files_force' => "1",

'short_rating' => "1",

'full_search' => "0",

'allow_multi_category' => "1",

'short_title' => "$site_title",

'allow_rss' => "1",

'rss_mtype' => "0",

'rss_number' => "10",

'rss_format' => "1",

'comments_maxlen' => "3000",

'offline_reason' => "درحال حاضر دسترسی به این وب‌سایت امکان پذیر نمی‌باشد<br /><br />لطفاً ساعاتی بعد از این وب‌سایت بازدید نمائید.",

'catalog_sort' => "date",

'catalog_msort' => "DESC",

'related_number' => "5",

'seo_type' => "2",

'max_moderation' => "0",

'allow_quick_wysiwyg' => "0",

'sec_addnews' => "2",

'mail_pm' => "1",

'allow_change_sort' => "1",

'registration_rules' => "1",

'allow_tags' => "1",

'allow_add_tags' => "1",

'allow_fixed' => "1",

'max_file_count' => "0",

'allow_smartphone' => "0",

'allow_smart_images' => "0",

'allow_smart_video' => "0",

'allow_search_print' => "1",

'allow_search_link' => "1",

'allow_smart_format' => "1",

'thumb_dimming' => "0",

'thumb_gallery' => "1",

'max_comments_days' => "0",

'allow_combine' => "1",

'allow_subscribe' => "1",

'parse_links' => "0",

't_seite' => "0",

'comments_minlen' => "10",

'js_min' => "0",

'outlinetype' => "0",

'fast_search' => "1",

'login_log' => "5",

'allow_recaptcha' => "0",

'recaptcha_public_key' => "",

'recaptcha_private_key' => "",

'search_number' => "10",

'news_navigation' => "1",

'smtp_mail' => "",

'seo_control' => "0",

'news_restricted' => "0",

'comments_restricted' => "0",

'auth_metod' => "0",

'comments_ajax' => "0",

'create_catalog' => "0",

'mobile_news' => "10",

'reg_question' => "0",

'news_future' => "0",

'cache_type' => "0",

'memcache_server' => "localhost:11211",

'allow_comments_cache' => "1",

'reg_multi_ip' => "1",

'top_number' => "10",

'tags_number' => "40",

'mail_title' => "",

'o_seite' => "0",

'online_status' => "1",

'avatar_size' => "100",

'allow_share' => "1",

'auth_domain' => "0",

'start_site' => "1",

'clear_cache' => "0",

'allow_complaint_mail' => "0",

'spam_api_key' => "",

'create_metatags' => '1',

'admin_allowed_ip' => '',

'related_only_cats' => '0',

'allow_links' => '1',

'comments_lazyload' => '0',

'category_separator' => '/',

'speedbar_separator' => '&raquo;',

'adminlog_maxdays' => '30',

'allow_social' => '0',

'medium_image' => '450',

'login_ban_timeout' => '20',

'watermark_seite' => '4',

'auth_only_social' => '0',

'rating_type' => '0',

'allow_comments_rating' => '1',

'comments_rating_type' => '1',

'tree_comments' => '0',

'tree_comments_level' => '5',

'simple_reply' => '0',

'recaptcha_theme' => "light",

'smtp_secure' => '',

'search_pages' => '5',

'profile_news' => '1',

'key' => '',

);

?>
HTML;

$dbhost = str_replace ('"', '\"', str_replace ("$", "\\$", $dbhost) );
$dbname = str_replace ('"', '\"', str_replace ("$", "\\$", $dbname) );
$dbuser = str_replace ('"', '\"', str_replace ("$", "\\$", $dbuser) );
$dbpasswd = str_replace ('"', '\"', str_replace ("$", "\\$", $dbpasswd) );
$dbprefix = str_replace ('"', '\"', str_replace ("$", "\\$", $dbprefix) );
$auth_key = generate_auth_key();

$dbconfig = <<<HTML
<?PHP

define ("DBHOST", "{$dbhost}");

define ("DBNAME", "{$dbname}");

define ("DBUSER", "{$dbuser}");

define ("DBPASS", "{$dbpasswd}");

define ("PREFIX", "{$dbprefix}");

define ("USERPREFIX", "{$dbprefix}");

define ("COLLATE", "{$db_charset}");

define('SECURE_AUTH_KEY', '{$auth_key}');

\$db = new db;

?>
HTML;


$video_config = <<<HTML
<?PHP

//Videoplayers Configurations

\$video_config = array (

'width' => "425",

'height' => "325",

'play' => "false",

'progressBarColor' => "0xFFFFFF",

'tube_related' => "0",

'tube_dle' => "0",

'audio_width' => "425",

'preload' => '1',

);

?>
HTML;


$social_config = <<<HTML
<?PHP

//Social Configurations

\$social_config = array (

'vk' => '0',

'vkid' => '',

'vksecret' => '',

'od' => '0',

'odid' => '',

'odpublic' => '',

'odsecret' => '',

'fc' => '0',

'fcid' => '',

'fcsecret' => '',

'google' => '0',

'googleid' => '',

'googlesecret' => '',

'mailru' => '0',

'mailruid' => '',

'mailrusecret' => '',

'yandex' => '0',

'yandexid' => '',

'yandexsecret' => '',

);

?>
HTML;

$con_file = fopen("engine/data/config.php", "w+") or die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"><font size=2 face=tahoma>شما باید سطح دسترسی فایل <b>.engine/data/config.php</b>. را 666 بگذارید.");
fwrite($con_file, $config);
fclose($con_file);
@chmod("engine/data/config.php", 0666);

$con_file = fopen("engine/data/dbconfig.php", "w+") or die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"><font size=2 face=tahoma>شما باید سطح دسترسی فایل <b>.engine/data/dbconfig.php</b>. را 666 بگذارید.");
fwrite($con_file, $dbconfig);
fclose($con_file);
@chmod("engine/data/dbconfig.php", 0666);

$con_file = fopen("engine/data/videoconfig.php", "w+") or die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"><font size=2 face=tahoma>شما باید سطح دسترسی فایل <b>.engine/data/videoconfig.php</b>. را 666 بگذارید.");
fwrite($con_file, $video_config);
fclose($con_file);
@chmod("engine/data/videoconfig.php", 0666);

$con_file = fopen("engine/data/socialconfig.php", "w+") or die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"><font size=2 face=tahoma>شما باید سطح دسترسی فایل <b>.engine/data/socialconfig.php</b>. را 666 بگذارید.");
fwrite($con_file, $social_config);
fclose($con_file);
@chmod("engine/data/socialconfig.php", 0666);

$con_file = fopen("engine/data/wordfilter.db.php", "w+") or die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"><font size=2 face=tahoma>شما باید سطح دسترسی فایل  <b>.engine/data/wordfilter.db.php</b>. را 666 بگذارید.");
fwrite($con_file, '');
fclose($con_file);
@chmod("engine/data/wordfilter.db.php", 0666);

$con_file = fopen("engine/data/xfields.txt", "w+") or die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"><font size=2 face=tahoma>شما باید سطح دسترسی فایل  <b>.engine/data/xfields.txt</b>. را 666 بگذارید.");
fwrite($con_file, '');
fclose($con_file);
@chmod("engine/data/xfields.txt", 0666);

$con_file = fopen("engine/data/xprofile.txt", "w+") or die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"><font size=2 face=tahoma>شما باید سطح دسترسی فایل  <b>.engine/data/xprofile.txt</b>. را 666 بگذارید.");
fwrite($con_file, '');
fclose($con_file);
@chmod("engine/data/xprofile.txt", 0666);

@unlink(ENGINE_DIR.'/cache/system/usergroup.php');
@unlink(ENGINE_DIR.'/cache/system/vote.php');
@unlink(ENGINE_DIR.'/cache/system/banners.php');
@unlink(ENGINE_DIR.'/cache/system/category.php');
@unlink(ENGINE_DIR.'/cache/system/banned.php');
@unlink(ENGINE_DIR.'/cache/system/cron.php');
@unlink(ENGINE_DIR.'/cache/system/informers.php');
@unlink(ENGINE_DIR.'/data/snap.db');

define ("PREFIX", $dbprefix);
define ("COLLATE", $db_charset);

$tableSchema = array();

// DatalifeEngine.IR Added
$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_obmen";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_obmen (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `icq` varchar(255) NOT NULL default '',
  `mail` varchar(255) NOT NULL default '',
  `posit` smallint(5) NOT NULL default '1',
  `description` varchar(255) default NULL,
  `bold` char(1) default '',
  `color` varchar(255) default '',
  `target` varchar(255) default '',
  PRIMARY KEY  (`id`)
  ) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "INSERT INTO `" . PREFIX . "_obmen` VALUES (1, 'Datalife Engine Farsi', 'http://datalifeengine.ir', '', 'info@datalifeengine.ir', 0, 'Datalife Engine Farsi', '0', '', '')";
// DatalifeEngine.IR Added

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_category";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_category (
  `id` mediumint(8) NOT NULL auto_increment,
  `parentid` mediumint(8) NOT NULL default '0',
  `posi` mediumint(8) NOT NULL default '1',
  `name` varchar(50) NOT NULL default '',
  `alt_name` varchar(50) NOT NULL default '',
  `icon` varchar(200) NOT NULL default '',
  `skin` varchar(50) NOT NULL default '',
  `descr` varchar(200) NOT NULL default '',
  `keywords` text NOT NULL,
  `news_sort` varchar(10) NOT NULL default '',
  `news_msort` varchar(4) NOT NULL default '',
  `news_number` smallint(5) NOT NULL default '0',
  `short_tpl` varchar(40) NOT NULL default '',
  `full_tpl` varchar(40) NOT NULL default '',
  `metatitle` varchar(255) NOT NULL default '',
  `show_sub` tinyint(1) NOT NULL default '0',
  `allow_rss` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
  ) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_comments";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_comments (
  `id` int(10) unsigned NOT NULL auto_increment,
  `post_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '2000-01-01 00:00:00',
  `autor` varchar(40) NOT NULL default '',
  `email` varchar(40) NOT NULL default '',
  `text` text NOT NULL,
  `ip` varchar(40) NOT NULL default '',
  `is_register` tinyint(1) NOT NULL default '0',
  `approve` tinyint(1) NOT NULL default '1',
  `rating` int(11) NOT NULL default '0',
  `vote_num` int(11) NOT NULL default '0',
  `parent` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  KEY `approve` (`approve`),
  KEY `parent` (`parent`),
  FULLTEXT KEY `text` (`text`)
  ) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_email";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_email (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(10) NOT NULL default '',
  `template` text NOT NULL,
  `use_html` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
  ) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";


$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_flood";

$tableSchema[] = "CREATE TABLE  " . PREFIX . "_flood (
  `f_id` int(11) unsigned NOT NULL auto_increment,
  `ip` varchar(40) NOT NULL default '',
  `id` varchar(20) NOT NULL default '',
  `flag` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`f_id`),
  KEY `ip` (`ip`),
  KEY `id` (`id`),
  KEY `flag` (`flag`)
  ) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_images";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_images (
  `id` int(10) unsigned NOT NULL auto_increment,
  `images` text NOT NULL,
  `news_id` int(10) NOT NULL default '0',
  `author` varchar(40) NOT NULL default '',
  `date` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `author` (`author`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_logs";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_logs (
  `id` int(10) unsigned NOT NULL auto_increment,
  `news_id` int(10) NOT NULL default '0',
  `member` varchar(40) NOT NULL default '',
  `ip` varchar(40) NOT NULL default '',
  `rating` TINYINT(4) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `member` (`member`),
  KEY `ip` (`ip`)
  ) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_vote";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_vote (
  `id` mediumint(8) NOT NULL auto_increment,
  `category` text NOT NULL,
  `vote_num` mediumint(8) NOT NULL default '0',
  `date` varchar(25) NOT NULL default '0',
  `title` varchar(200) NOT NULL default '',
  `body` text NOT NULL,
  `approve` tinyint(1) NOT NULL default '1',
  `start` varchar(15) NOT NULL default '',
  `end` varchar(15) NOT NULL default '',
  `grouplevel` varchar(250) NOT NULL default 'all',
  PRIMARY KEY  (`id`),
  KEY `approve` (`approve`)
  ) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_vote_result";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_vote_result (
  `id` int(10) NOT NULL auto_increment,
  `ip` varchar(40) NOT NULL default '',
  `name` varchar(40) NOT NULL default '',
  `vote_id` mediumint(8) NOT NULL default '0',
  `answer` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `answer` (`answer`),
  KEY `vote_id` (`vote_id`),
  KEY `ip` (`ip`),
  KEY `name` (`name`)
  ) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_lostdb";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_lostdb (
  `id` mediumint(8) NOT NULL auto_increment,
  `lostname` mediumint(8) NOT NULL default '0',
  `lostid` varchar( 40 ) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `lostid` (`lostid`)
  ) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_pm";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_pm (
  `id` int(11) unsigned NOT NULL auto_increment,
  `subj` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `user` MEDIUMINT(8) NOT NULL default '0',
  `user_from` varchar(40) NOT NULL default '',
  `date` int(11) unsigned NOT NULL default '0',
  `pm_read` TINYINT(1) NOT NULL default '0',
  `folder` varchar(10) NOT NULL default '',
  `reply` tinyint(1) NOT NULL default '0',
  `sendid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `folder` (`folder`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`),
  KEY `pm_read` (`pm_read`)
  ) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_post";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_post (
  `id` int(11) NOT NULL auto_increment,
  `autor` varchar(40) NOT NULL default '',
  `date` datetime NOT NULL default '2000-01-01 00:00:00',
  `short_story` text NOT NULL,
  `full_story` text NOT NULL,
  `xfields` text NOT NULL,
  `title` varchar(255) NOT NULL default '',
  `descr` varchar(200) NOT NULL default '',
  `keywords` text NOT NULL,
  `category` varchar(200) NOT NULL default '0',
  `alt_name` varchar(200) NOT NULL default '',
  `comm_num` mediumint(8) unsigned NOT NULL default '0',
  `allow_comm` tinyint(1) NOT NULL default '1',
  `allow_main` tinyint(1) unsigned NOT NULL default '1',
  `approve` tinyint(1) NOT NULL default '0',
  `fixed` tinyint(1) NOT NULL default '0',
  `allow_br` tinyint(1) NOT NULL default '1',
  `symbol` varchar(3) NOT NULL default '',
  `tags` VARCHAR(250) NOT NULL default '',
  `metatitle` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `autor` (`autor`),
  KEY `alt_name` (`alt_name`),
  KEY `category` (`category`),
  KEY `approve` (`approve`),
  KEY `allow_main` (`allow_main`),
  KEY `date` (`date`),
  KEY `symbol` (`symbol`),
  KEY `comm_num` (`comm_num`),
  KEY `tags` (`tags`),
  KEY `fixed` (`fixed`),
  FULLTEXT KEY `short_story` (`short_story`,`full_story`,`xfields`,`title`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_post_extras";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_post_extras (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL DEFAULT '0',
  `news_read` int(11) NOT NULL DEFAULT '0',
  `allow_rate` tinyint(1) NOT NULL DEFAULT '1',
  `rating` int(11) NOT NULL DEFAULT '0',
  `vote_num` int(11) NOT NULL DEFAULT '0',
  `votes` tinyint(1) NOT NULL DEFAULT '0',
  `view_edit` tinyint(1) NOT NULL DEFAULT '0',
  `disable_index` tinyint(1) NOT NULL DEFAULT '0',
  `related_ids` varchar(255) NOT NULL DEFAULT '',
  `access` varchar(150) NOT NULL DEFAULT '',
  `editdate` int(11) NOT NULL DEFAULT '0',
  `editor` varchar(40) NOT NULL DEFAULT '',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`eid`),
  KEY `news_id` (`news_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_static";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_static (
  `id` MEDIUMINT(8) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `descr` varchar(255) NOT NULL default '',
  `template` text NOT NULL,
  `allow_br` tinyint(1) NOT NULL default '0',
  `allow_template` tinyint(1) NOT NULL default '0',
  `grouplevel` varchar(100) NOT NULL default 'all',
  `tpl` varchar(40) NOT NULL default '',
  `metadescr` varchar(200) NOT NULL default '',
  `metakeys` text NOT NULL,
  `views` mediumint(8) NOT NULL default '0',
  `template_folder` varchar(50) NOT NULL default '',
  `date` int(11) unsigned NOT NULL default '0',
  `metatitle` varchar(255) NOT NULL default '',
  `allow_count` tinyint(1) NOT NULL default '1',
  `sitemap` tinyint(1) NOT NULL default '1',
  `disable_index` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  FULLTEXT KEY `template` (`template`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_users";

$tableSchema[] = "CREATE TABLE " . PREFIX . "_users (
  `email` varchar(50) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `name` varchar(40) NOT NULL default '',
  `user_id` int(11) NOT NULL auto_increment,
  `news_num` mediumint(8) NOT NULL default '0',
  `comm_num` mediumint(8) NOT NULL default '0',
  `user_group` smallint(5) NOT NULL default '4',
  `lastdate` varchar(20) default NULL,
  `reg_date` varchar(20) default NULL,
  `banned` varchar(5) NOT NULL default '',
  `allow_mail` tinyint(1) NOT NULL default '1',
  `info` text NOT NULL,
  `signature` text NOT NULL,
  `foto` varchar(255) NOT NULL default '',
  `fullname` varchar(100) NOT NULL default '',
  `land` varchar(100) NOT NULL default '',
  `icq` varchar(20) NOT NULL default '',
  `yahoo` varchar(60) NOT NULL default '',
  `favorites` text NOT NULL,
  `pm_all` smallint(5) NOT NULL default '0',
  `pm_unread` smallint(5) NOT NULL default '0',
  `time_limit` varchar(20) NOT NULL default '',
  `xfields` text NOT NULL,
  `allowed_ip` varchar(255) NOT NULL default '',
  `hash` varchar(32) NOT NULL default '',
  `logged_ip` varchar(40) NOT NULL default '',
  `restricted` TINYINT(1) NOT NULL default '0',
  `restricted_days` SMALLINT(4) NOT NULL default '0',
  `restricted_date` VARCHAR(15) NOT NULL default '',
  `timezone` VARCHAR(100) NOT NULL default '',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_banned";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_banned (
  `id` smallint(5) NOT NULL auto_increment,
  `users_id` mediumint(8) NOT NULL default '0',
  `descr` text NOT NULL,
  `date` varchar(15) NOT NULL default '',
  `days` smallint(4) NOT NULL default '0',
  `ip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`users_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_files";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_files (
  `id`  MEDIUMINT(8) NOT NULL auto_increment,
  `news_id` int(10) NOT NULL default '0',
  `name` varchar(250) NOT NULL default '',
  `onserver` varchar(250) NOT NULL default '',
  `author` varchar(40) NOT NULL default '',
  `date` varchar(15) NOT NULL default '',
  `dcount` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_usergroups";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_usergroups (
  `id` smallint(5) NOT NULL auto_increment,
  `group_name` varchar(32) NOT NULL default '',
  `allow_cats` text NOT NULL,
  `allow_adds` tinyint(1) NOT NULL default '1',
  `cat_add` text NOT NULL,
  `allow_admin` tinyint(1) NOT NULL default '0',
  `allow_addc` tinyint(1) NOT NULL default '0',
  `allow_editc` tinyint(1) NOT NULL default '0',
  `allow_delc` tinyint(1) NOT NULL default '0',
  `edit_allc` tinyint(1) NOT NULL default '0',
  `del_allc` tinyint(1) NOT NULL default '0',
  `moderation` tinyint(1) NOT NULL default '0',
  `allow_all_edit` tinyint(1) NOT NULL default '0',
  `allow_edit` tinyint(1) NOT NULL default '0',
  `allow_pm` tinyint(1) NOT NULL default '0',
  `max_pm` smallint(5) NOT NULL default '0',
  `max_foto` VARCHAR(10) NOT NULL default '',
  `allow_files` tinyint(1) NOT NULL default '0',
  `allow_hide` tinyint(1) NOT NULL default '1',
  `allow_short` tinyint(1) NOT NULL default '0',
  `time_limit` tinyint(1) NOT NULL default '0',
  `rid` smallint(5) NOT NULL default '0',
  `allow_fixed` tinyint(1) NOT NULL default '0',
  `allow_feed`  tinyint(1) NOT NULL default '1',
  `allow_search`  tinyint(1) NOT NULL default '1',
  `allow_poll`  tinyint(1) NOT NULL default '1',
  `allow_main`  tinyint(1) NOT NULL default '1',
  `captcha`  tinyint(1) NOT NULL default '0',
  `icon` varchar(200) NOT NULL default '',
  `allow_modc`  tinyint(1) NOT NULL default '0',
  `allow_rating` tinyint(1) NOT NULL default '1',
  `allow_offline` tinyint(1) NOT NULL default '0',
  `allow_image_upload` tinyint(1) NOT NULL default '0',
  `allow_file_upload` tinyint(1) NOT NULL default '0',
  `allow_signature` tinyint(1) NOT NULL default '0',
  `allow_url` tinyint(1) NOT NULL default '1',
  `news_sec_code` tinyint(1) NOT NULL default '1',
  `allow_image` tinyint(1) NOT NULL default '0',
  `max_signature` SMALLINT(6) NOT NULL default '0',
  `max_info` SMALLINT(6) NOT NULL default '0',
  `admin_addnews` tinyint(1) NOT NULL default '0',
  `admin_editnews` tinyint(1) NOT NULL default '0',
  `admin_comments` tinyint(1) NOT NULL default '0',
  `admin_categories` tinyint(1) NOT NULL default '0',
  `admin_editusers` tinyint(1) NOT NULL default '0',
  `admin_wordfilter` tinyint(1) NOT NULL default '0',
  `admin_xfields` tinyint(1) NOT NULL default '0',
  `admin_userfields` tinyint(1) NOT NULL default '0',
  `admin_static` tinyint(1) NOT NULL default '0',
  `admin_editvote` tinyint(1) NOT NULL default '0',
  `admin_newsletter` tinyint(1) NOT NULL default '0',
  `admin_blockip` tinyint(1) NOT NULL default '0',
  `admin_banners` tinyint(1) NOT NULL default '0',
  `admin_rss` tinyint(1) NOT NULL default '0',
  `admin_iptools` tinyint(1) NOT NULL default '0',
  `admin_rssinform` tinyint(1) NOT NULL default '0',
  `admin_googlemap` tinyint(1) NOT NULL default '0',
  `allow_html` tinyint(1) NOT NULL default '1',
  `group_prefix` text NOT NULL,
  `group_suffix` text NOT NULL,
  `allow_subscribe` tinyint(1) NOT NULL default '0',
  `allow_image_size` tinyint(1) NOT NULL default '0',
  `cat_allow_addnews` text NOT NULL,
  `flood_news` smallint(6) NOT NULL default '0',
  `max_day_news` smallint(6) NOT NULL default '0',
  `force_leech` tinyint(1) NOT NULL default '0',
  `edit_limit` smallint(6) NOT NULL default '0',
  `captcha_pm` tinyint(1) NOT NULL default '0',
  `max_pm_day` smallint(6) NOT NULL default '0',
  `max_mail_day` smallint(6) NOT NULL default '0',
  `admin_tagscloud` tinyint(1) NOT NULL default '0',
  `allow_vote` tinyint(1) NOT NULL default '0',
  `admin_complaint` tinyint(1) NOT NULL default '0',
  `news_question` tinyint(1) NOT NULL default '0',
  `comments_question` tinyint(1) NOT NULL default '0',
  `max_comment_day` smallint(6) NOT NULL default '0',
  `max_images` smallint(6) NOT NULL default '0',
  `max_files` smallint(6) NOT NULL default '0',
  `disable_news_captcha` smallint(6) NOT NULL default '0',
  `disable_comments_captcha` smallint(6) NOT NULL default '0',
  `pm_question` tinyint(1) NOT NULL default '0',
  `captcha_feedback` tinyint(1) NOT NULL default '1',
  `feedback_question` tinyint(1) NOT NULL default '0',
  `files_type` varchar(255) NOT NULL default '',
  `max_file_size` mediumint(9) NOT NULL default '0',
  `files_max_speed` smallint(6) NOT NULL default '0',
  `allow_lostpassword` tinyint(1) NOT NULL default '1',
  `spamfilter` tinyint(1) NOT NULL default '2',
  `allow_comments_rating` tinyint(1) NOT NULL default '1',
  `max_edit_days` tinyint(1) NOT NULL default '0',
  `spampmfilter` tinyint(1) NOT NULL default '0',
  `force_reg` TINYINT(1) NOT NULL default '0',
  `force_reg_days` MEDIUMINT(9) NOT NULL default '0',
  `force_reg_group` SMALLINT(6) NOT NULL default '4',
  `force_news` TINYINT(1) NOT NULL default '0',
  `force_news_count` MEDIUMINT(9) NOT NULL default '0',
  `force_news_group` SMALLINT(6) NOT NULL default '4',
  `force_comments` TINYINT(1) NOT NULL default '0',
  `force_comments_count` MEDIUMINT(9) NOT NULL default '0',
  `force_comments_group` SMALLINT(6) NOT NULL default '4',
  `force_rating` TINYINT(1) NOT NULL default '0',
  `force_rating_count` MEDIUMINT(9) NOT NULL default '0',
  `force_rating_group` SMALLINT(6) NOT NULL default '4',
  `not_allow_cats` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_poll";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_poll (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `news_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(200) NOT NULL default '',
  `frage` varchar(200) NOT NULL default '',
  `body` text NOT NULL,
  `votes` mediumint(8) NOT NULL default '0',
  `multiple` tinyint(1) NOT NULL default '0',
  `answer` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_poll_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_poll_log (
  `id` int(10) unsigned NOT NULL auto_increment,
  `news_id` int(10) unsigned NOT NULL default '0',
  `member` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`,`member`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_banners";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_banners (
  `id` smallint(5) NOT NULL auto_increment,
  `banner_tag` varchar(40) NOT NULL default '',
  `descr` varchar(200) NOT NULL default '',
  `code` text NOT NULL,
  `approve` tinyint(1) NOT NULL default '0',
  `short_place` tinyint(1) NOT NULL default '0',
  `bstick` tinyint(1) NOT NULL default '0',
  `main` tinyint(1) NOT NULL default '0',
  `category` VARCHAR(255) NOT NULL default '',
  `grouplevel` varchar(100) NOT NULL default 'all',
  `start` varchar(15) NOT NULL default '',
  `end` varchar(15) NOT NULL default '',
  `fpage` tinyint(1) NOT NULL default '0',
  `innews` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_rss";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_rss (
  `id` smallint(5) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `allow_main` tinyint(1) NOT NULL default '0',
  `allow_rating` tinyint(1) NOT NULL default '0',
  `allow_comm` tinyint(1) NOT NULL default '0',
  `text_type` tinyint(1) NOT NULL default '0',
  `date` tinyint(1) NOT NULL default '0',
  `search` text NOT NULL,
  `max_news` tinyint(3) NOT NULL default '0',
  `cookie` text NOT NULL,
  `category` smallint(5) NOT NULL default '0',
  `lastdate` INT(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_views";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_views (
  `id` int(11) NOT NULL auto_increment,
  `news_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";


$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_rssinform";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_rssinform (
  `id` smallint(5) NOT NULL auto_increment,
  `tag` varchar(40) NOT NULL default '',
  `descr` varchar(255) NOT NULL default '',
  `category` varchar(200) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `template` varchar(40) NOT NULL default '',
  `news_max` smallint(5) NOT NULL default '0',
  `tmax` smallint(5) NOT NULL default '0',
  `dmax` smallint(5) NOT NULL default '0',
  `approve` tinyint(1) NOT NULL default '1',
  `rss_date_format` VARCHAR(20) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_notice";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_notice (
  `id` mediumint(8) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `notice` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_static_files";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_static_files (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `static_id` mediumint(8) NOT NULL default '0',
  `author` varchar(40) NOT NULL default '',
  `date` varchar(50) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `onserver` varchar(250) NOT NULL default '',
  `dcount` mediumint(8) NOT NULL default '0',
  PRIMARY KEY (`id`),
  KEY `static_id` (`static_id`),
  KEY `onserver` (`onserver`),
  KEY `author` (`author`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_tags";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_tags (
  `id` INT(11) NOT NULL auto_increment,
  `news_id` INT(11) NOT NULL default '0',
  `tag` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `tag` (`tag`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_post_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_post_log (
  `id` INT(11) NOT NULL auto_increment,
  `news_id` INT(11) NOT NULL default '0',
  `expires` varchar(15) NOT NULL default '',
  `action` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `expires` (`expires`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_admin_sections";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_admin_sections (
  `id` mediumint(8) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `descr` varchar(255) NOT NULL default '',
  `icon` varchar(255) NOT NULL default '',
  `allow_groups` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_subscribe";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_subscribe (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `name` varchar(40) NOT NULL default '',
  `email`  varchar(50) NOT NULL default '',
  `news_id` int(11) NOT NULL default '0',
  `hash` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_sendlog";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_sendlog (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(40) NOT NULL DEFAULT '',
  `date` INT(11) unsigned NOT NULL DEFAULT '0',
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `date` (`date`),
  KEY `flag` (`flag`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_login_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_login_log (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(40) NOT NULL DEFAULT '',
  `count` smallint(6) NOT NULL DEFAULT '0',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`),
  KEY `date` (`date`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_mail_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_mail_log (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `mail` varchar(50) NOT NULL DEFAULT '',
  `hash` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `hash` (`hash`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_complaint";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_complaint (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL DEFAULT '0',
  `c_id` int(11) NOT NULL DEFAULT '0',
  `n_id` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `from` varchar(40) NOT NULL DEFAULT '',
  `to` varchar(255) NOT NULL DEFAULT '',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `c_id` (`c_id`),
  KEY `p_id` (`p_id`),
  KEY `n_id` (`n_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_ignore_list";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_ignore_list (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL default '0',
  `user_from` VARCHAR(40) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `user` (`user`),
  KEY `user_from` (`user_from`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_admin_logs";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_admin_logs (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(40) NOT NULL DEFAULT '',
  `action` int(11) NOT NULL DEFAULT '0',
  `extras` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `date` (`date`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_question";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_question (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL DEFAULT '',
  `answer` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_read_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_read_log (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_spam_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_spam_log (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(40) NOT NULL DEFAULT '',
  `is_spammer` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL DEFAULT '',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`),
  KEY `is_spammer` (`is_spammer`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_links";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_links (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `only_one` tinyint(1) NOT NULL DEFAULT '0',
  `replacearea` tinyint(1) NOT NULL DEFAULT '1',
  `rcount` tinyint(3) NOT NULL DEFAULT '0',
  `targetblank` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_social_login";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_social_login (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` varchar(40) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL DEFAULT '0',
  `password` varchar(32) NOT NULL DEFAULT '',
  `provider` varchar(15) NOT NULL DEFAULT '',
  `wait` tinyint(1) NOT NULL DEFAULT '0',
  `waitlogin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_comment_rating_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_comment_rating_log (
  `id` int unsigned NOT NULL auto_increment,
  `c_id` int NOT NULL default '0',
  `member` varchar(40) NOT NULL default '',
  `ip` varchar(40) NOT NULL default '',
  `rating` TINYINT(4) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`),
  KEY `c_id` (`c_id`),
  KEY `member` (`member`),
  KEY `ip` (`ip`)
  ) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_xfsearch";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_xfsearch (
  `id` INT(11) NOT NULL auto_increment,
  `news_id` INT(11) NOT NULL default '0',
  `tagname` varchar(50) NOT NULL default '',
  `tagvalue` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `news_id` (`news_id`),
  KEY `tagname` (`tagname`),
  KEY `tagvalue` (`tagvalue`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

if (strpos($url, "//") === 0) $url = "http:".$url;
elseif (strpos($url, "/") === 0) $url = "http://".$_SERVER['HTTP_HOST'].$url;

$tableSchema[] = "INSERT INTO " . PREFIX . "_rssinform VALUES (1, 'dle', 'اخبار سایت دیتالایف انجین فارسی', '0', 'http://www.datalifeengine.ir/rss.xml', 'informer', 3, 0, 200, 1, 'j F Y H:i')";

$tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (1, 'مدیر کل', 'all', 1, 'all', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 50, 101, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0, '{THEME}/images/icon_1.gif', 0, 1, 1, 1, 1, 1, 1, 0, 1,500,1000,1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1,1,'<b><span style=\"color:red\">','</span></b>',1,1,'all', 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 0, 2, 1, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 1, '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (2, 'مدیر', 'all', 1, 'all', 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 50, 101, 1, 1, 1, 0, 2, 1, 1, 1, 1, 1, 0, '{THEME}/images/icon_2.gif', 0, 1, 0, 1, 1, 1, 1, 0, 1,500,1000,1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,1,'','',1,1,'all', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 1, 2, 1, 0, 0, 0, 0, 2, 0, 0, 2, 0, 0, 2, 0, 0, 2, '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (3, 'ویرایشگر', 'all', 1, 'all', 1, 1, 1, 1, 0, 0, 1, 0, 1, 1, 50, 101, 1, 1, 1, 0, 3, 0, 1, 1, 1, 1, 0, '{THEME}/images/icon_3.gif', 0, 1, 0, 1, 1, 1, 1, 0, 1,500,1000,1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,1,'','',1,1,'all', 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 1, 2, 1, 0, 0, 0, 0, 3, 0, 0, 3, 0, 0, 3, 0, 0, 3, '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (4, 'عضو سایت', 'all', 1, 'all', 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 20, 101, 1, 1, 1, 0, 4, 0, 1, 1, 1, 1, 0, '{THEME}/images/icon_4.gif', 0, 1, 0, 1, 0, 1, 1, 1, 0,500,1000,0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,1,'','',1,0,'all', 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'zip,rar,exe,doc,pdf,swf', 4096, 0, 1, 2, 1, 0, 2, 0, 0, 4, 0, 0, 4, 0, 0, 4, 0, 0, 4, '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_usergroups VALUES (5, 'میهمان', 'all', 0, 'all', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 5, 0, 1, 1, 1, 0, 1, '{THEME}/images/icon_5.gif', 0, 1, 0, 0, 0, 0, 1, 1, 0,1,1,0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,0,'','',0,0,'all', 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '', 0, 0, 0, 2, 1, 0, 2, 0, 0, 5, 0, 0, 5, 0, 0, 5, 0, 0, 5, '')";

$tableSchema[] = "INSERT INTO " . PREFIX . "_rss VALUES (1, 'http://www.datalifeengine.ir/rss.xml', 'DataLife Engine Farsi', 1, 1, 1, 1, 1, '<div class=\"full-post-content row\">{get}</div><div class=\"full-post-footer ignore-select\">', 5, '', 1, 0)";

$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (1, 'reg_mail', 'با سلام خدمت شما کاربر گرامی {%username%},\r\n\r\nاز اینکه در وب سایت $url ثبت نام کرده اید، متشکریم؛ \r\n\r\n مشخصات شما در این وب سایت به شرح زیر می‌باشد:\r\n\r\nنام کاربری: {%username%}\r\nرمز عبور: {%password%}\r\n\r\n\r\nاکنون جهت تکمیل و اتمام مراحل ثبت نام در سایت، بر روی لینک زیر کلیک نمائید:\r\n\r\n{%validationlink%}', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (2, 'feed_mail', 'با سلام خدمت شما کاربر گرامی {%username_to%},\r\n\r\nایمیلی از طرف نام کاربری {%username_from%} در سایت $url  برای شما ارسال شده است.\r\n\r\nمتن پیام به شرح زیر می‌باشد:\r\n\r\n{%text%}\r\n\r\nIP ارسال کننده: {%ip%}', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (3, 'lost_mail', 'با سلام خدمت شما کاربر گرامی {%username%},\r\n\r\nبرای اکانت کاربری شما در وب سایت $url  درخواست تغییر رمزعبور داده شده است.\r\n در صورتی که این درخواست از جانب شما بوده است بر روی لینک زیر کلیک نمایید تا فرایند تغییر کلمه عبور شما تکمیل گردد؛ در غیر این صورت این ایمیل را نادیده بگیرید: \r\n\r\n{%lostlink%}\r\n\r\nIP ارسال کننده: {%ip%}', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (4, 'new_news', 'با سلام خدمت شما مدیریت محترم سایت $url \r\n\r\nمطلب جدیدی در سایت با مشخصات زیر ارسال گردید:\r\n\r\nفرستنده: {%username%}\r\nعنوان مطلب: {%title%}\r\nموضوع: {%category%}\r\nتاریخ ارسال: {%date%}', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (5, 'comments', 'با سلام خدمت شما کاربر گرامی {%username_to%},\r\n\r\nنظر جدیدی در وب سایت  $url  توسط شخصی با نام کاربری {%username%} ارسال شده است.\r\nتاریخ ارسال: {%date%}\r\nلینک خبر:  {%link%}\r\n\r\nمتن نظر به شرح زیر است:\r\n{%text%}\r\n\r\n\r\n اگر شما می‌خواهید اشتراک خود را از آگاهی نظر جدید این خبر حذف کنید، بر روی لینک زیر کلیک نمائید: \r\n{%unsubscribe%}', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (6, 'pm', 'با سلام خدمت شما کاربر گرامی {%username%},\r\n\r\nشما در وب سایت $url پیغام خصوصی جدیدی دریافت کرده اید. \r\n\r\n مشخصات این پیغام خصوصی به شرح زیر می‌باشد:\r\n\r\n فرستنده: {%fromusername%}\r\nتاریخ ارسال: {%date%}\r\nعنوان پیام: {%title%}\r\n\r\nمتن پیام به شرح زیر می‌باشد:\r\n{%text%}', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (7, 'wait_mail', '{%username%} عزیز,\r\n\r\nشما در سایت $url با استفاده از شبکه اجتماعی {%network%} ثبت نام کرده اید. بخاطر مسائل امنیتی، بر روی لینک زیر کلیک کنید تا مراحل ثبت نام تکمیل شود: \r\n\r\n------------------------------------------------\r\n{%link%}\r\n------------------------------------------------\r\n\r\nتوجه، 
در صورتی که قبلاً در این سایت حساب کاربری ایجاد کرده باشید (بدون شبکه اجتماعی)، رمز عبور شما تغییر خواهد یافت و به صورت قبل امکان ورود ندارید و فقط با استفاده از شبکه اجتماعی قادر خواهید بود وارد سایت شوید.\r\n\r\nاگر شما این درخواست را ارسال نکرده اید، بر روی لینک بالا کلیک نکنید و این ایمیل را نادیده بگیرید.\r\n\r\nآی پی شخص درخواست کننده: {%ip%}\r\n\r\nبا تشکر،\r\n\r\nمدیریت سایت $url', 0)";
$tableSchema[] = "INSERT INTO " . PREFIX . "_email values (8, 'newsletter', '<html>\r\n<head>\r\n<title>{%title%}</title>\r\n<meta content=\"text/html; charset={%charset%}\" http-equiv=Content-Type>\r\n<style type=\"text/css\">\r\nhtml,body{\r\n    font-family: Tahoma;\r\n    word-spacing: 0.1em;\r\n    letter-spacing: 0;\r\n    direction: rtl;\r\n    text-align: right;\r\n    line-height: 1.5em;\r\n    font-size: 11px;\r\n}\r\n\r\np {\r\n margin:0px;\r\n padding: 0px;\r\n}\r\n\r\na:active,\r\na:visited,\r\na:link {\r\n color: #4b719e;\r\n text-decoration:none;\r\n}\r\n\r\na:hover {\r\n color: #4b719e;\r\n text-decoration: underline;\r\n}\r\n</style>\r\n</head>\r\n<body>\r\n{%content%}\r\n</body>\r\n</html>', 0)";


$tableSchema[] = "INSERT INTO " . PREFIX . "_category (name, alt_name, keywords) values ('خبرها', 'main', '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_banners (banner_tag, descr, code, approve, short_place, bstick, main, category) values ('header', 'Top banner', '<div align=\"center\"><a href=\"http://www.datalifeengine.ir/\" target=\"_blank\"><img src=\"{$url}templates/Default/images/_banner_.gif\" style=\"border: none;\" alt=\"\" /></a></div>', 1, 0, 0, 0, 0)";

$add_time = time();
$thistime = date ("Y-m-d H:i:s", $add_time);

$tableSchema[] = "INSERT INTO " . PREFIX . "_static (`name`, `descr`, `template`, `allow_br`, `allow_template`, `grouplevel`, `tpl`, `metadescr`, `metakeys`, `views`, `template_folder`, `date`) VALUES ('dle-rules-page', 'قوانین عمومی سایت', '<b>قوانین عمومی طرز رفتار در سایت</b><br /><br />برای شروع سایت، با ارتباط برقرار کردن صدها نفر از مردم از ادیان و اعتقادات مختلف، و بسیاری از میهمانان سایت، شما موظف هستید که به یک سری از قوانین سایت عمل کنید. شما را توصیه به خواندن این قوانین می کنیم که در کل بیشتر از پنج دقیقه طول نمی کشد.<br />
<br />
1. این وب سایت تابع قوانین جمهوری اسلامی ایران می باشد.<br />
2. کپی مطلب از این وب سایت با ذکر منبع بلامانع است.<br />
3. نمایش مطالب هر عضو در سایت به معنای تایید آن نیست و مسئولیت آن بر عهده خود نویسنده مطلب می باشد.<br />
4. توهین به هر شخص ،  نژاد ، قوم و زبانی در این سایت ممنوع می باشد.<br />
5. در حد امکان از بحث ها تفرقه انگیز بین اقوام ایرانی و طرح مطالبی که موجب ایجاد تنش بین اعضای سایت می گردد خودداری شود.<br />
<br />
<b>در صورتی که شخصی از قوانین سایت خارج گردد نام کاربری ایشان مسدود خواهد شد.</b><br /><div align=\"center\">{ACCEPT-DECLINE}</div>', 1, 1, 'all', '', 'قوانین عمومی', 'قوانین عمومی', 0, '', '{$add_time}')";

$tableSchema[] = "INSERT INTO " . PREFIX . "_users (name, password, email, reg_date, lastdate, fullname, user_group, news_num, info, signature, favorites, xfields) values ('$reg_username', '$reg_password', '$reg_email', '$add_time', '$add_time', '$fullname', '1', '1', '', '', '', '')";
$tableSchema[] = "INSERT INTO " . PREFIX . "_vote (category, vote_num, date, title, body) VALUES ('all', '0', '$thistime', 'نظرشما در مورد سیستم؟', 'عالی<br />خوب<br />متوسط<br />بد')";

$title = "دیتالایف انجین فارسی نسخه 11";
$short_story = "
با سلام خدمت شما کاربر گرامی؛<br /><br />از اینکه این سیستم را برای سایت خود در نظر گرفته اید متشکریم.<br /><br />خواهشمندیم در صورت برخورد با هر اشکالی در این سیستم و یا اگر پیشنهادی در بهتر سازی آن دارید ما را توسط ایمیل زیر با خبر فرمایید.<br /><br />برای دانلود قالب های فارسی و امکانات اضافی دیگر به سایت زیر مراجعه فرمایید.<br /><br /><br /><div align=\"left\">E-Mail: <a href=\"http://info@datalifeengine.ir\" target=\"_blank\">info@datalifeengine.ir</a><br /><br />Offical website: <a href=\"http://datalifeengine.ir\" target=\"_blank\">www.datalifeengine.ir</a><br /><br />Support forum: <a href=\"http://forum.datalifeengine.ir\" target=\"_blank\">www.forum.Datalifeengine.ir</a><br /><br />Free template: <a href=\"http://themes.datalifeengine.ir\" target=\"_blank\">www.themes.datalifeEngine.ir</a></div><br/><div align=\"center\"><img src=\"uploads/boxsmall.jpg\" align=\"center\" /></div><br />شاد و پیروز باشید.";
$full_story = "";

$tableSchema[] = "INSERT INTO " . PREFIX . "_post (date, autor, short_story, full_story, xfields, title, keywords, category, alt_name, allow_comm, approve, allow_main, tags) values ('$thistime', '$reg_username', '$short_story', '$full_story', '', '$title', '', '1', 'post1', '1', '1', '1', 'Datalife, Engine, CMS')";


$tableSchema[] = "INSERT INTO " . PREFIX . "_post_extras (news_id, user_id) values ('1', '1')";

$tableSchema[] = "INSERT INTO " . PREFIX . "_tags (news_id, tag) values ('1', 'DLE'), ('1', 'Datalife'), ('1', 'Engine'), ('1', 'CMS'), ('1', 'Farsi'), ('1', 'DatalifeEngine.ir')";

include ENGINE_DIR.'/classes/mysql.php';
include ENGINE_DIR.'/data/dbconfig.php';

      foreach($tableSchema as $table) {

        $db->query($table);

      }

  echo $skin_header;


echo <<<HTML
<form action="index.php" method="get">
<div class="box">
  <div class="box-header">
    <div class="title">{$title}</div>
  </div>
  <div class="box-content">
    <div class="row box-section" style="line-height: 20px;">
          سیستم مدیریت محتوای دیتالایف انجین با موفقیت بر روی سایت شما نصب گردید.<br/> برای دیدن صفحه اصلی سایت <B><a href="index.php"><font color="#1176CC" size="2">اینجا</font></a></B> کلیک کنید و یا اگر می خواهید کنترل پنل مدیریت سایت را ببینید <B><a href="admin.php"><font color="#1176CC" size="2">اینجا</font></a></B> کلیک کنید. 
  <br /><br /><font color="red">به یاد داشته باشید که فایل <b>install.php</b> را برای امنیت بیشتر سایت حذف کنید.</font><br /><br />موفق باشید.<br />  </div>
    <div class="row box-section"> 
		<input class="btn btn-green" type=submit value="ورود به سایت">
	</div>

  </div>
</div>

HTML;

}
else {

	if (@file_exists(ENGINE_DIR.'/data/config.php')) {

		msgbox( "", "خطا در نصب سیستم", "به دلیل وجود فایل <b>engine/data/config.php/</b> شما نمی توانید دوباره این سیستم را نصب کنید. [مگر آنکه فایل مذکور را حذف کنید]" );

		die ();
	}

$_SESSION['dle_install'] = 1;

// ********************************************************************************
// Greeting
// ********************************************************************************

  echo $skin_header;

echo <<<HTML
<form method="get" action="">
<input type="hidden" name="action" value="eula">
<div class="box">
  <div class="box-header">
    <div class="title">نصب و راه اندازی سیستم دیتالایف انجین</div>
  </div>
  <div class="box-content">
	<div class="row box-section">
        با سلام خدمت شما کاربر گرامی،<br/><br/>
        به صفحۀ نصب سیستم مدیریت محتوای فارسی دیتالایف انجین نسخه 11 خوش آمدید.<br />
        <br />
        <font color="red">توجه: برای امنیت بیشتر سایت، ضروریست که بعد از نصب، فایل <B>install.php</b> را از سرور خود پاک کنید.</font><br />
        <br/><font color="#555555">امیدواریم از امکانات این سیستم لذت ببرید.</font><br />
	</div>
	<div class="row box-section">
		<input class="btn btn-green" type=submit value="شروع به نصب">
	</div>

  </div>
</div>
</form>
HTML;
}


echo $skin_footer;
?>