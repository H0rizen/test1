<?php

if( ! defined( 'DATALIFEENGINE' ) ) {
	die( "Hacking attempt!" );
}

$config['version_id'] = "8.5";
$config['parse_links'] = "0";
$config['t_seite'] = "0";
$config['comments_minlen'] = "0";
$config['js_min'] = "0";
$config['outlinetype'] = "0";

$tableSchema = array();

$tableSchema[] = "ALTER TABLE `" . PREFIX . "_usergroups` ADD `allow_image_size` TINYINT( 1 ) NOT NULL DEFAULT '0'";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_usergroups` ADD `cat_allow_addnews` TEXT NOT NULL";
$tableSchema[] = "UPDATE " . PREFIX . "_usergroups SET `allow_image_size` = '1' WHERE id < '4'";
$tableSchema[] = "UPDATE " . PREFIX . "_usergroups SET `cat_allow_addnews` = 'all'";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_poll` CHANGE `answer` `answer` TEXT NOT NULL";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_vote` ADD `start` VARCHAR( 15 ) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_vote` ADD `end` VARCHAR( 15 ) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_banners` ADD `start` VARCHAR( 15 ) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_banners` ADD `end` VARCHAR( 15 ) NOT NULL DEFAULT ''";

foreach($tableSchema as $table) {
	$db->query ($table);
}


$handler = fopen(ENGINE_DIR.'/data/config.php', "w") or die("ШіШ·Ш­ ШЇШіШЄШ±ШіЩЉ ЩЃШ§ЩЉЩ„ <b>.engine/data/config.php</b>.<br /> Ш±Ш§ Ш±Щ€ЩЉ 666 Щ‚Ш±Ш§Ш± ШЇЩ‡ЩЉШЇ!");
fwrite($handler, "<?PHP \n\n//System Configurations\n\n\$config = array (\n\n");
foreach($config as $name => $value)
{
	fwrite($handler, "'{$name}' => \"{$value}\",\n\n");
}
fwrite($handler, ");\n\n?>");
fclose($handler);

require_once(ENGINE_DIR.'/data/videoconfig.php');

$video_config['flv_watermark'] = $config['flv_watermark'];

$handler = fopen(ENGINE_DIR.'/data/videoconfig.php', "w") or die("ШіШ·Ш­ ШЇШіШЄШ±ШіЩЉ ЩЃШ§ЩЉЩ„ <b>.engine/data/videoconfig.php</b>.<br /> Ш±Ш§ Ш±Щ€ЩЉ 666 Щ‚Ш±Ш§Ш± ШЇЩ‡ЩЉШЇ!");
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

if ($db->error_count) $error_info = "Всего запланировано запросов: <b>".$db->query_num."</b> Неудалось выполнить запросов: <b>".$db->error_count."</b>. Возможно они уже выполнены ранее."; else $error_info = "";

msgbox("info","Ш§Ш·Щ„Ш§Ш№Ш§ШЄ", "<form action=\"index.php\" method=\"GET\">ШЁШ±Щ€ШІШ±ШіШ§Щ†ЩЉ ШЇЩЉШЄШ§ШЁЩЉШі ШЁШ§ ШЄШЁШЇЩЉЩ„ Щ†ШіШ®Щ‡ Ш§ШІ <b>8.3</b> ШЁЩ‡ <b>8.5</b> ШЁШ§ Щ…Щ€ЩЃЩ‚ЩЉШЄ ШЁЩ‡ ЩѕШ§ЩЉШ§Щ† Ш±ШіЩЉШЇ.<br />Щ„Ш·ЩЃШ§Щ‹ ШЁШ±Ш§ЩЉ Ш§ШЇШ§Щ…Щ‡ ЩЉ ЩѕШ±ШЇШ§ШІШґ Щ‡Ш§ Ш±Щ€ЩЉ ШЇЪ©Щ…Щ‡ ЩЉ \" Ш§ШЇШ§Щ…Щ‡ \" Ъ©Щ„ЩЉЪ© Ъ©Щ†ЩЉШЇ.<br /><br /><input type=\"hidden\" name=\"next\" value=\"8.5\"><input class=\"edit\" type=\"submit\" value=\"Ш§ШЇШ§Щ…Щ‡...\"></form>");
?>