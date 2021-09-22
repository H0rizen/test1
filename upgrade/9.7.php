<?php

if( ! defined( 'DATALIFEENGINE' ) ) {
	die( "Hacking attempt!" );
}

$config['version_id'] = "9.8";
$config['allow_share'] = "1";
$config['auth_domain'] = "1";

$tableSchema = array();

$tableSchema[] = "ALTER TABLE `" . PREFIX . "_vote` ADD `grouplevel` VARCHAR(250) NOT NULL DEFAULT 'all'";

foreach($tableSchema as $table) {
	$db->query ($table);
}


$handler = fopen(ENGINE_DIR.'/data/config.php', "w") or die("سطح دسترسی فایل <b>.engine/data/config.php</b>.<br /> را روی 666 قرار دهید!");
fwrite($handler, "<?PHP \n\n//System Configurations\n\n\$config = array (\n\n");
foreach($config as $name => $value)
{
	fwrite($handler, "'{$name}' => \"{$value}\",\n\n");
}
fwrite($handler, ");\n\n?>");
fclose($handler);


$fdir = opendir( ENGINE_DIR . '/cache/system/' );
while ( $file = readdir( $fdir ) ) {
	if( $file != '.' and $file != '..' and $file != '.htaccess' ) {
		@unlink( ENGINE_DIR . '/cache/system/' . $file );
		
	}
}

@unlink(ENGINE_DIR.'/data/snap.db');

clear_cache();

if ($db->error_count) {

	$error_info = "مجموع داده های پردازش شده: <b>".$db->query_num."</b>داده های پردازش نشده: <b>".$db->error_count."</b>.";

	foreach ($db->query_list as $value) {

		$error_info .= $value['query']."<br /><br />";

	}

	$error_info .= "</div>";

} else $error_info = "";

msgbox("info","اطلاعات", "<form action=\"index.php\" method=\"GET\">پايگاه داده از <b>9.7</b> به <b>9.8</b> با موفقيت آپگريد شد.<br />{$error_info}<br />لطفا برای ادامه پردازش بر روی \"ادامه...\" کلیک کنید<br /><br /><input type=\"hidden\" name=\"next\" value=\"next\"><input class=\"edit\" type=\"submit\" value=\"ادامه ...\"></form>");
?>