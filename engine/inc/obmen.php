<?PHP
/*
=====================================================
 DataLife Engine v11
-----------------------------------------------------
 Persian support site: http://datalifeengine.ir
-----------------------------------------------------
 Copyright (c) 2006-2016, All rights reserved.
=====================================================
*/

if(!defined('DATALIFEENGINE')) {
	die("Hacking attempt!");
}

if ($action == "sort" || $action == "delete" || $_POST['obmen-submit']) {
	@unlink( ENGINE_DIR . '/cache/system/obmen.php' );
}

$js_array[] = "engine/skins/obmen/colorpicker.js";
$colorPicker = <<<HTML
<link rel="stylesheet" media="screen" type="text/css" href="engine/skins/obmen/colorpicker.css" />
<script type="text/javascript">
\$('#colorSelector').ColorPicker({
	color: \$('#colorSelector').val(),
	onShow: function (colpkr) {
		\$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		\$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		\$('#colorSelector').val(hex);
	}
});
</script>
HTML;

if ($action == "edit") {

	if( isset($_POST['obmen-submit']) AND ($_POST['obmen-submit'] == "true") ){
		$id = $db->safesql(intval($_REQUEST['id'])); 
		$title = $db->safesql(stripslashes($_POST['title']));
		$color = $db->safesql(stripslashes($_POST['color']));
		$bold = $db->safesql(stripslashes($_POST['bold']));
		$link = $db->safesql(stripslashes($_POST['link']));
		$mail = $db->safesql(stripslashes($_POST['mail']));
		$posit = $db->safesql(stripslashes($_POST['posit']));
		$target = $db->safesql(stripslashes($_POST['target']));
		$description = $db->safesql(substr(strip_tags(stripslashes($_REQUEST['description'])), 0, 350));
		$db->query("UPDATE " . PREFIX . "_obmen set title='$title', color='$color', bold='$bold', link='$link', mail='$mail', description='$description', posit='$posit', target='$target' where id='$id'");
		msg("info", "اطلاعات", "لینک {$title} با موفقیت بروز شد.", "$PHP_SELF?mod=obmen");
	} else {
	
		echoheader("لینک ها", "مدیریت " . $lang['opt_obmen']);

		$db->query("SELECT * FROM " . PREFIX . "_obmen WHERE id=" . (int)$_REQUEST['id'] . " ORDER BY posit ASC");
		$row = $db->get_row();

		if ($row["bold"]) $boldchecked = " checked=\"true\"";
		
		if ($row["target"] == "_blank") $blankselected = " selected=\"true\"";
		if ($row["target"] == "_top") $topselected = " selected=\"true\"";
		
		$id = $row['id'];
		$title = $row['title'];
		$link = $row['link'];
		$color = $row['color'];
		$mail = $row['mail'];
		$description = $row['description'];
		
		$posit = "";
		
		for($i = 0; $i <= 20; $i++){
			$posit .= "<option value=\"{$i}\"";
			$posit .= ($row['posit'] == $i) ? " selected=\"true\"" : "";
			$posit .= ">{$i}</option>";
		}
		
		echo <<<HTML

<form method="post" action="" class="form-horizontal" >


<div class="box">
  <div class="box-header">
    <div class="title">ویرایش لینک</div>
  </div>
  <div class="box-content">

	<div class="row box-section">
	
		<div class="form-group">
		  <label class="control-label col-lg-2">عنوان لینک:</label>
		  <div class="col-lg-10">
			<input type="text" name="title" style="width:100%;max-width:437px;" value="{$title}">
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2">آدرس:</label>
		  <div class="col-lg-10">
			<input type="text" name="link" style="width:100%;max-width:437px;" dir="ltr" value="{$link}">
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2">توضیح:<br/></label>
		  <div class="col-lg-10">
			<input type="text" name="description" style="width:100%;max-width:437px;" value="{$description}">&nbsp;<span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content=" این قسمت برای خاصیت title لینک می باشد." >?</span>
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2">ایمیل مدیر وب سایت:</label>
		  <div class="col-lg-10">
			<input type="text" name="mail" style="width:100%;max-width:437px;" dir="ltr" value="{$mail}">
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2">محل قرارگیری:</label>
		  <div class="col-lg-10">
			<select name="posit" class="uniform">
				{$posit}
			</select>
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2">هدف:</label>
		  <div class="col-lg-10">
			<select name="target" class="uniform">
				<option value="">بدون انتخاب</option>
				<option value="_blank"{$blankselected}>پنجره یا تب جدید (_blank)</option>
				<option value="_top"{$topselected}>پنجره فعلی (_top)</option>
			</select>
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2">رنگ لینک:</label>
		  <div class="col-lg-10">
			<input type="text" name="color" id="colorSelector" maxlength="6" size="6" style="width: 120px;max-width:437px;" dir="ltr" value="{$color}">#
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2">پر رنگ بودن لینک:</label>
		  <div class="col-lg-10">
			<input class="icheck" type="checkbox" id="bold_id" name="bold" value="1" {$boldchecked}><label for="bold_id">بله</label>
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2"></label>
		  <div class="col-lg-10">
			<input type="submit" class="btn btn-green" value="ویرایش"> <input onclick="confirmdelete();return false" type="button" class="btn btn-red" value=" حذف لینک  " />
		  </div>
		 </div>		 
	</div>
	
   </div>
</div>
<input name="obmen-submit" value="true" type="hidden">
</form>
<script type="text/javascript">
<!--
function confirmdelete(){
	DLEconfirm("آیا واقعا میخواهید این لینک را حذف کنید؟" ,"حذف لینک",function(){
		document.location="{$PHP_SELF}?mod=obmen&action=delete&id={$id}";
	});
}
//-->
</script>
HTML;

		echo $colorPicker;
		echofooter();
	}
} elseif ($action == "sort") {
	foreach ($_POST["posit"] as $id => $posit) {
		if($posit != "") {
			$posi = intval($posit);
			$id = intval($id);
			$query = $db->query("UPDATE " . PREFIX . "_obmen SET posit=$posi WHERE id = $id");
		}
	}
	msg("info", "اطلاعات", "لینک ها با موفقیت چیده شدند.", "{$PHP_SELF}?mod=obmen");

} elseif ($action == "add") {

	if( isset($_POST['obmen-submit']) AND ($_POST['obmen-submit'] == "true") ){
		$title = $db->safesql(stripslashes($_POST['title']));
		$color = $db->safesql(stripslashes($_POST['color']));
		$bold = $db->safesql(stripslashes($_POST['bold']));
		$link = $db->safesql(stripslashes($_POST['link']));
		$mail = $db->safesql(stripslashes($_POST['mail']));
		$posit = $db->safesql(stripslashes($_POST['posit']));
		$target = $db->safesql(stripslashes($_POST['target']));
		$description = $db->safesql(substr(strip_tags(stripslashes($_REQUEST['description'])), 0, 350));
		$sql_insert = $db->query("INSERT INTO " . PREFIX . "_obmen (title, color, bold, link, mail, description, target, posit) values ('$title', '$color', '$bold', '$link', '$mail', '$description', '$target', '$posit')");
		msg("info", "اطلاعات", "لینک {$title} با موفقیت اضافه شد.", "{$PHP_SELF}?mod=obmen");
	} else {
		echoheader("لینک ها", "مدیریت " . $lang['opt_obmen']);
		
		$posit = "";
		
		for($i = 0; $i <= 20; $i++){
			$posit .= "<option value=\"{$i}\">{$i}</option>";
		}
		
		echo <<<HTML
<form method="post" action="" class="form-horizontal">

<div class="box">
  <div class="box-header">
    <div class="title">اضافه کردن لینک</div>
  </div>
  <div class="box-content">

	<div class="row box-section">
	
		<div class="form-group">
		  <label class="control-label col-lg-2">عنوان لینک:</label>
		  <div class="col-lg-10">
			<input type="text" name="title" style="width:100%;max-width:437px;">
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2">آدرس:</label>
		  <div class="col-lg-10">
			<input type="text" name="link" style="width:100%;max-width:437px;" dir="ltr" value="http://">
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2">توضیح:<br/></label>
		  <div class="col-lg-10">
			<input type="text" name="description" style="width:100%;max-width:437px;">&nbsp;<span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content=" این قسمت برای خاصیت title لینک می باشد." >?</span> ( اختیاری )
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2">ایمیل مدیر وب سایت:</label>
		  <div class="col-lg-10">
			<input type="text" name="mail" style="width:100%;max-width:437px;" dir="ltr"> ( اختیاری )
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2">محل قرارگیری:</label>
		  <div class="col-lg-10">
			<select name="posit" class="uniform">
				{$posit}
			</select>
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2">هدف:</label>
		  <div class="col-lg-10">
			<select name="target" class="uniform">
				<option value="">بدون انتخاب</option>
				<option value="_blank">پنجره یا تب جدید (_blank)</option>
				<option value="_top">پنجره فعلی (_top)</option>
			</select>
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2">رنگ لینک:</label>
		  <div class="col-lg-10">
			<input type="text" name="color" id="colorSelector" maxlength="6" size="6" style="width: 120px;max-width:437px;" dir="ltr">#
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2">پر رنگ بودن لینک:</label>
		  <div class="col-lg-10">
			<input class="icheck" type="checkbox" id="bold_id" name="bold" value="1"><label for="bold_id">بله</label>
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2"></label>
		  <div class="col-lg-10">
			<input type="submit" class="btn btn-green" value="درج لینک">
		  </div>
		 </div>		 
	</div>
	
   </div>
</div>

<input name="obmen-submit" value="true" type="hidden">
</form>
HTML;

		echo $colorPicker;
		echofooter();
	}
} elseif ($action == "delete") {
	$db->query ("DELETE FROM " . PREFIX . "_obmen WHERE id = '{$_REQUEST['id']}'");
	msg("info", "اطلاعات", "این لینک با موفقیت حذف شد.", "$PHP_SELF?mod=obmen");

} else {


	echoheader( "<i class=\"icon-user\"></i>".$lang['opt_obmen'], "مدیریت لینک ها" );
	

	echo <<<HTML
<script type="text/javascript">
<!--
function check_rank( host, id ){
ShowLoading("");
\$.post("{$config['http_home_url']}engine/ajax/ranksite.php",{'idsea':host},function(a){\$('#rank-'+id).fadeOut('normal',function(){\$(this).html(a).fadeIn();HideLoading("");});});
return false;
}

function confirmdelete(id){
DLEconfirm("آیا واقعا میخواهید این لینک را حذف کنید؟","حذف لینک",function(){
document.location="{$PHP_SELF}?mod=obmen&action=delete&id="+id;
});
}
//-->
</script>
HTML;
	$result = $db->query("SELECT * FROM " . PREFIX . "_obmen ORDER BY posit ASC");
	while($row = $db->get_row($result)) {
		$link = $row['link'];
		$id = $row['id'];
		$title = $row['title'];
		$color = $row['color'];
		$bold = $row['bold'];
		$mail = $row['mail'];
		$posit = $row['posit'];
		$description = $row['description'];

		$che = parse_url("$link");
		$host = $che['host'];

		$entry .= <<<HTML

<tr>
<td width="60"><input name="posit[{$id}]" value="{$posit}" class="edit" size="2" /></td>
<td><a href="{$PHP_SELF}?mod=obmen&action=edit&id={$id}">{$title}</a></td>
<td style="text-align: left;"><a href="{$link}" target="_blank" class="ltr">{$host}</a></td>
<td width="200" align="center"><span id="rank-{$id}">---</span></td>
<td width="80">

<div class="btn-group">
	<button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="icon-pencil"></i> {$lang['filter_action']} <span class="caret"></span></button>
	<ul class="dropdown-menu text-left">
		<li><a href="?mod=obmen&action=edit&id={$id}"><i class="icon-pencil"></i> ویرایش</a></li>
		<li class="divider"></li>
		<li><a href="#" onclick="confirmdelete({$id}); return(false)"><i class="icon-trash"></i> حذف</a></li>
		<li class="divider"></li>
		<li><a href="#" onclick="check_rank('{$host}', '{$id}'); return(false)"><i class="icon-link"></i> گرفتن رتبه گوگل</a></li>
	</ul>
</div>

</td>
</tr>
HTML;
	}

	if ($_POST['action'] == "send_notice") {
		
		$obmen_config = array();
		
		foreach($_POST as $name => $value){
			if($name == "action") continue;
			$obmen_config[$name] = $_POST[$name];
		}
		
		$f = fopen( ENGINE_DIR . "/data/obmen.php", 'w' );
		fwrite( $f, serialize($obmen_config) );
		fclose( $f );
	}

	$obmen_config = unserialize( @file_get_contents( ENGINE_DIR . "/data/obmen.php" ));

	$text1 = $obmen_config['text']['1'];
	$text2 = $obmen_config['text']['2'];
	$showchecked1 = $obmen_config['showchecked']['1'];
	$showchecked2 = $obmen_config['showchecked']['2'];
	$showchecked3 = $obmen_config['showchecked']['3'];

	if ( $showchecked1 == '1' ) $ifchecked1 = "checked";
	if ( $showchecked2 == '1' ) $ifchecked2 = "checked";

	if ($showchecked3 == '1' ) $ifchecked3 = "checked";

	echo <<<HTML
<form method="post" action="$PHP_SELF?mod=obmen&action=sort">


<div class="box">
  <div class="box-header">
    <div class="title">فهرست لینک ها</div>
  </div>
  <div class="box-content">

    <table class="table table-normal table-hover">
HTML;
	
	if ($entry) $entry = <<<HTML
      <thead>
<tr>
<td>مکان</td>
<td>عنوان لینک</td>
<td>آدرس</td>
<td width="200">رتبه گوگل</td>
<td width="80">عملیات</td>
</tr>
      </thead>
{$entry}
HTML;
	else $entry = "<tr><td align=\"center\" height=\"30\" colspan=\"5\" align=\"center\" class=\"navigation\">- هیچ لینکی وجود ندارد -</td></tr>";
	$row = $db->super_query("SELECT COUNT(*) as count FROM " . PREFIX . "_obmen");
	$sites = $row['count'];
	echo <<<HTML
<tbody>{$entry}</tbody>
</table>

<div class="box-footer padded">
	<input type='button' value=' اضافه کردن لینک جدید ' class='btn btn-green' onclick="window.location='$PHP_SELF?mod=obmen&action=add'">
	<input type='button' value=' تنظیمات ' class='btn btn-blue' onclick="javascript:ShowOrHide('options')">
	<input type="submit" value=' چیدن لینک ها ' class='btn btn-black'>
</div>	

</form>
</div>
</div>

<div id="options" style="display:none;">
<form method="post" action="" class="form-horizontal" >
<input type="hidden" name="action" value="send_notice">

<div class="box">
  <div class="box-header">
    <div class="title">تنظیمات</div>
  </div>
  <div class="box-content">

	<div class="row box-section">
	
		<div class="form-group">
		  <label class="control-label col-lg-2">متن در بالای لینک ها:</label>
		  <div class="col-lg-10">
			<input type="text" name="text[1]" style="width:100%;max-width:437px;" value="{$text1}"> <input class="icheck" type="checkbox" id="show_1" {$ifchecked1} name="showchecked[1]" value="1" value="1"><label for="show_1">نمایش</label>
		  </div>
		 </div>
	
		<div class="form-group">
		  <label class="control-label col-lg-2">متن در پایین لینک ها:</label>
		  <div class="col-lg-10">
			<input type="text" name="text[2]" style="width:100%;max-width:437px;" value="{$text2}"> <input class="icheck" type="checkbox" id="show_2" {$ifchecked2} name="showchecked[2]" value="1" value="1"><label for="show_2">نمایش</label>
		  </div>
		 </div>
		 
		 
		<div class="form-group">
		  <label class="control-label col-lg-2">حرکت به سمت بالا:</label>
		  <div class="col-lg-10">
			<input class="icheck" type="checkbox"  {$ifchecked3} name="showchecked[3]" value="1" id="check3" value="1"><label for="check3">بله</label>
		  </div>
		 </div>
		 
		<div class="form-group">
		  <label class="control-label col-lg-2"></label>
		  <div class="col-lg-10">
			<input type="submit" class="btn btn-green" value="ذخیره">
		  </div>
		 </div>		 
	</div>
	
   </div>
</div>
</form></div>
HTML;

	echofooter();
}

?>