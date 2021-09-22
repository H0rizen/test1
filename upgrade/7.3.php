<?php

$config['version_id'] = "7.5";
$config['allow_smartphone'] = "0";
$config['allow_smart_images'] = "0";

$tableSchema = array();

$tableSchema[] = "ALTER TABLE `" . PREFIX . "_static` ADD `date` VARCHAR( 15 ) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_usergroups` ADD `max_signature` SMALLINT( 6 ) NOT NULL DEFAULT '1'";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_usergroups` ADD `max_info` SMALLINT( 6 ) NOT NULL DEFAULT '1'";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_static_files` ADD `onserver` VARCHAR( 255 ) NOT NULL DEFAULT ''";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_static_files` ADD `dcount` SMALLINT( 5 ) NOT NULL DEFAULT '0'";
$tableSchema[] = "ALTER TABLE `" . PREFIX . "_static_files` ADD INDEX ( `onserver` )";
$tableSchema[] = "UPDATE " . PREFIX . "_usergroups SET max_signature='500'";
$tableSchema[] = "UPDATE " . PREFIX . "_usergroups SET max_info='1000'";

foreach($tableSchema as $table) {
	$db->query ($table);
}


$handler = fopen(ENGINE_DIR.'/data/config.php', "w") or die("سيستم نمي تواند متني را در فايل <b>.engine/data/config.php</b> ذخيره کند.<br />لطفاً سطح دسترسي اين فايل را به 777 تغيير بدين.!");
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

if ($db->error_count) $error_info = "Error: <b>".$db->query_num."</b> Υ䥠쯱졢찮쮨㼠衯ᯱ <b>".$db->error_count."</b>. î譮箮 ﮨ 䧥 㼯שּׂ殻 ᡭ楮"; else $error_info = "";

msgbox("info","اطلاعات", "<form action=\"index.php\" method=\"GET\">بروزرساني ديتابيس با تبديل نسخه از <b>7.3</b> به <b>7.5</b> با موفقيت به پايان رسيد.<br />لطفاً براي ادامه ي پردازش ها روي دکمه ي \" ادامه \" کليک کنيد.<br /><br /><input type=\"hidden\" name=\"next\" value=\"7.5\"><input class=\"edit\" type=\"submit\" value=\"ادامه...\"></form>");
?>