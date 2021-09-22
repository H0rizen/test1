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

@ob_start ();
@ob_implicit_flush ( 0 );

if( !defined( 'E_DEPRECATED' ) ) {

	@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
	@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );

} else {

	@error_reporting ( E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE );
	@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE );

}

@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );

define ( 'DATALIFEENGINE', true );
define ( 'ROOT_DIR', dirname ( __FILE__ ) );
define ( 'ENGINE_DIR', ROOT_DIR . '/engine' );

require_once ROOT_DIR . '/engine/init.php';

?>