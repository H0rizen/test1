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

if(!defined('DATALIFEENGINE')){
	die("Hacking attempt!");
}

$tpl->result['siteinfo'] = dle_cache("siteinfo", $config['skin']);

if( ! $tpl->result['siteinfo'] ){
	// Get News Stats
	$row = $db->super_query("SELECT COUNT(*) as count FROM " . PREFIX . "_post where date>NOW() - INTERVAL 1 HOUR;");
	$hour_news = $row['count'];

	$row = $db->super_query("SELECT COUNT(*) as count FROM " . PREFIX . "_post where date>NOW() - INTERVAL 1 DAY;");
	$day_news = $row['count'];

	$row = $db->super_query("SELECT COUNT(*) as count FROM " . PREFIX . "_post where date>NOW() - INTERVAL 1 MONTH;");
	$month_news = $row['count'];
	
	$row = $db->super_query("SELECT COUNT(*) as count FROM " . PREFIX . "_post");
	$total_news = $row['count'];
	
	$row = $db->super_query("SELECT COUNT(*) as count FROM " . PREFIX . "_comments");
	$total_comments = $row['count'];
	
	// Get Users Stats
	$row = $db->super_query("SELECT COUNT(*) as count FROM " . USERPREFIX . "_users where FROM_UNIXTIME(reg_date) > NOW() - INTERVAL 1 HOUR;");
	$hour_users = $row['count'];
	
	$row = $db->super_query("SELECT COUNT(*) as count FROM " . USERPREFIX . "_users where FROM_UNIXTIME(reg_date) > NOW() - INTERVAL 1 DAY;");
	$day_users = $row['count'];
	
	$row = $db->super_query("SELECT COUNT(*) as count FROM " . USERPREFIX . "_users where FROM_UNIXTIME(reg_date) > NOW() - INTERVAL 1 MONTH;");
	$month_users = $row['count'];
	
	$row = $db->super_query("SELECT COUNT(*) as count FROM " . USERPREFIX . "_users");
	$total_users = $row['count'];
	
	$sql_result = $db->query("SELECT name FROM " . USERPREFIX . "_users order by user_id DESC LIMIT 0,1");
	$row = $db->get_row($sql_result);
	$last_user = $row['name'];
	
	$row = $db->super_query("SELECT COUNT(*) as count FROM " . PREFIX . "_banned;");
	$banned_users = $row['count'];
	
	
	$tpl->load_template( 'siteinfo.tpl' );
	$tpl->set( '{hour_news}', $hour_news );
	$tpl->set( '{day_news}', $day_news );
	$tpl->set( '{month_news}', $month_news );
	$tpl->set( '{total_news}', $total_news );
	$tpl->set( '{total_comments}', $total_comments );
	$tpl->set( '{hour_users}', $hour_users );
	$tpl->set( '{day_users}', $day_users );
	$tpl->set( '{month_users}', $month_users );
	$tpl->set( '{total_users}', $total_users );
	$tpl->set( '{last_user}', $last_user );
	$tpl->set( '{banned_users}', $banned_users );
	$tpl->compile( 'siteinfo' );
	$tpl->clear();
	
	create_cache("siteinfo", $tpl->result['siteinfo'], $config['skin']);
}

echo $tpl->result['siteinfo'];

?>