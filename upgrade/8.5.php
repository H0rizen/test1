 <?php

if( ! defined( 'DATALIFEENGINE' ) ) {
	die( "Hacking attempt!" );
}

$config['version_id'] = "9.0";
$config['fast_search'] = "0";
$config['login_log'] = "0";
unset($config['ajax']);

$tableSchema = array();

$tableSchema[] = "ALTER TABLE `" . PREFIX . "_usergroups` ADD `flood_news` SMALLINT( 6 ) NOT NULL DEFAULT '0', ADD `max_day_news` SMALLINT( 6 ) NOT NULL DEFAULT '0', ADD `force_leech` TINYINT( 1 ) NOT NULL DEFAULT '0', ADD `edit_limit` SMALLINT( 6 ) NOT NULL DEFAULT '0', ADD `captcha_pm` TINYINT( 1 ) NOT NULL DEFAULT '0', ADD `max_pm_day` SMALLINT( 6 ) NOT NULL DEFAULT '0', ADD `max_mail_day` SMALLINT( 6 ) NOT NULL DEFAULT '0'";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_flood` CHANGE `ip` `ip` VARCHAR( 40 ) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . USERPREFIX . "_users` ADD `yahoo` VARCHAR( 100 ) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_flood` ADD `flag` TINYINT( 1 ) NOT NULL DEFAULT '0', ADD INDEX ( `flag` )";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_sendlog";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_sendlog (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(40) NOT NULL DEFAULT '',
  `date` varchar(20) NOT NULL DEFAULT '',
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `date` (`date`),
  KEY `flag` (`flag`)
) TYPE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_login_log";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_login_log (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(16) NOT NULL DEFAULT '',
  `count` smallint(6) NOT NULL DEFAULT '0',
  `date` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`),
  KEY `date` (`date`)
) TYPE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";

foreach($tableSchema as $table) {
	$db->query ($table);
}


$handler = fopen(ENGINE_DIR.'/data/config.php', "w") or die("سطح دسترسي فايل <b>.engine/data/config.php</b>.<br /> را روي 666 قرار دهيد!");
fwrite($handler, "<?PHP \n\n//System Configurations\n\n\$config = array (\n\n");
foreach($config as $name => $value)
{
	fwrite($handler, "'{$name}' => \"{$value}\",\n\n");
}
fwrite($handler, ");\n\n?>");
fclose($handler);

require_once(ENGINE_DIR.'/data/videoconfig.php');

$video_config['tube_related'] = "1";
$video_config['tube_dle'] = "0";

$handler = fopen(ENGINE_DIR.'/data/videoconfig.php', "w") or die("سطح دسترسي فايل <b>.engine/data/videoconfig.php</b>.<br /> را روي 666 قرار دهيد!");
fwrite( $con_file, "<?PHP \n\n//Videoplayers Configurations\n\n\$video_config = array (\n\n" );
foreach ( $video_config as $name => $value ) {
		
	fwrite( $con_file, "'{$name}' => \"{$value}\",\n\n" );
	
}
fwrite( $con_file, ");\n\n?>" );
fclose($con_file);

$fdir = opendir( ENGINE_DIR . '/cache/system/' );
while ( $file = readdir( $fdir ) ) {
	if( $file != '.' and $file != '..' and $file != '.htaccess' ) {
		@unlink( ENGINE_DIR . '/cache/system/' . $file );
		
	}
}

@unlink(ENGINE_DIR.'/data/snap.db');

clear_cache();

if ($db->error_count) 	$error_info = "مجموع داده های پردازش شده: <b>".$db->query_num."</b>داده های پردازش نشده: <b>".$db->error_count."</b>.";
 else $error_info = "";

msgbox("info","Information", "<form action=\"index.php\" method=\"GET\">بروزرساني ديتابيس با تبديل نسخه از <b>8.5</b> به <b>9.0</b> با موفقيت به پايان رسيد.<br />{$error_info}<br />لطفاً براي ادامه ي پردازش ها روي دکمه ي \" ادامه \" کليک کنيد.<br /><br /><input type=\"hidden\" name=\"next\" value=\"next\"><input class=\"edit\" type=\"submit\" value=\"ادامه ...\"></form>");
?>