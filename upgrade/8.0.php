<?php

if( ! defined( 'DATALIFEENGINE' ) ) {
	die( "Hacking attempt!" );
}

$config['version_id'] = "8.2";
$config['thumb_dimming'] = "0";
$config['thumb_gallery'] = "0";
$config['max_comments_days'] = "0";

$tableSchema = array();

$tableSchema[] = "DROP TABLE IF EXISTS " . PREFIX . "_admin_sections";
$tableSchema[] = "CREATE TABLE " . PREFIX . "_admin_sections (
  `id` mediumint(8) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `descr` varchar(255) NOT NULL default '',
  `icon` varchar(255) NOT NULL default '',
  `allow_groups` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";


$tableSchema[] = "ALTER TABLE `" . PREFIX . "_lostdb` CHANGE `lostid` `lostid` VARCHAR( 40 ) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_category` ADD `metatitle` VARCHAR( 255 ) NOT NULL DEFAULT ''";


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


@unlink(ENGINE_DIR.'/cache/system/usergroup.php');
@unlink(ENGINE_DIR.'/cache/system/vote.php');
@unlink(ENGINE_DIR.'/cache/system/banners.php');
@unlink(ENGINE_DIR.'/cache/system/category.php');
@unlink(ENGINE_DIR.'/cache/system/banned.php');
@unlink(ENGINE_DIR.'/cache/system/cron.php');
@unlink(ENGINE_DIR.'/data/snap.db');

clear_cache();

if ($db->error_count) $error_info = "Всего запланировано запросов: <b>".$db->query_num."</b> Неудалось выполнить запросов: <b>".$db->error_count."</b>. Возможно они уже выполнены ранее."; else $error_info = "";

msgbox("info","Ш§Ш·Щ„Ш§Ш№Ш§ШЄ", "<form action=\"index.php\" method=\"GET\">ШЁШ±Щ€ШІШ±ШіШ§Щ†ЩЉ ШЇЩЉШЄШ§ШЁЩЉШі ШЁШ§ ШЄШЁШЇЩЉЩ„ Щ†ШіШ®Щ‡ Ш§ШІ <b>8/0</b> ШЁЩ‡ <b>8.2</b> ШЁШ§ Щ…Щ€ЩЃЩ‚ЩЉШЄ ШЁЩ‡ ЩѕШ§ЩЉШ§Щ† Ш±ШіЩЉШЇ.<br />Щ„Ш·ЩЃШ§Щ‹ ШЁШ±Ш§ЩЉ Ш§ШЇШ§Щ…Щ‡ ЩЉ ЩѕШ±ШЇШ§ШІШґ Щ‡Ш§ Ш±Щ€ЩЉ ШЇЪ©Щ…Щ‡ ЩЉ \" Ш§ШЇШ§Щ…Щ‡ \" Ъ©Щ„ЩЉЪ© Ъ©Щ†ЩЉШЇ.<br /><br /><input type=\"hidden\" name=\"next\" value=\"8.2\"><input class=\"edit\" type=\"submit\" value=\"Ш§ШЇШ§Щ…Щ‡...\"></form>");
?>