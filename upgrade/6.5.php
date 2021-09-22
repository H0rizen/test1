<?php

$config['version_id'] = "6.7";
$config['key'] = "";
$config['comments_maxlen'] = "3000";
$config['offline_reason'] = "سايت تعطيل هست.";


$handler = fopen(ENGINE_DIR.'/data/config.php', "w") or die("سيستم نمي تواند متني را در فايل <b>.engine/data/config.php</b> ذخيره کند.<br />لطفاً سطح دسترسي اين فايل را به 666 تغيير بدين.!");
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

msgbox("info","اطلاعات", "<form action=\"index.php\" method=\"GET\">بروزرساني ديتابيس با تبديل نسخه از <b>6.5</b> به <b>6.7</b> با موفقيت به پايان رسيد.<br />لطفاً براي ادامه ي پردازش ها روي دکمه ي \" ادامه \" کليک کنيد.<br /><br /><input type=\"hidden\" name=\"next\" value=\"7.0\"><input class=\"edit\" type=\"submit\" value=\"ادامه...\"></form>");
?>