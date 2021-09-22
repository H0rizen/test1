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

if( ! defined('DATALIFEENGINE') ) {
	die( "Hacking attempt!" );
}

function getSubCategories($id = 0){
	global $cat_info;
	
	foreach ( $cat_info as $cats ) {
		if( $cats['parentid'] == $id ) {
			$subfound[] = $cats['id'];
		}
	}
	
	if( $subfound ){
		foreach ($cat_info as $cats) {
			if(in_array($cats['id'], $subfound)){
				$found[] = $cats;
			}
		}
		return $found;
	}
	return false;
}

function getCategories($id = 0){
	global $config;
	$output = '';
	
	$results = getSubCategories($id);
	
	foreach ($results as $result) {
		$output .= "<li>";
		
		if ( $config['allow_alt_url'] == "yes" )
			$url = $config['http_home_url'] . get_url( $result['id'] ) . "/";
		else
			$url = $PHP_SELF . '?do=cat&amp;category=' . $result['alt_name'];
		
		if ($result["desc"] == "") $result["desc"] = $result["name"];
		
		$output .= '<a href="' . $url . '" title="' . $result["desc"] . '">' . $result["name"] . '</a>';
		
		if ( $subcat = getCategories($result['id']) )
			$output .= $subcat;
		
		$output .= "</li>\n";
	}
	
	if ( $results != '' )
		return "<ul>\n" . $output . "</ul>\n";
	else
		return false;
}

echo getCategories();

?>