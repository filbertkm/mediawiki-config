<?php

ini_set( "display_errors", 1 );
error_reporting( -1 );

if ( isset( $_SERVER ) && array_key_exists( 'SERVER_NAME', $_SERVER ) ) {
	switch ( $_SERVER['SERVER_NAME'] ) {
		case 'wikidatawiki':
			$wgDBname = 'wikidatawiki';
			break;
		case 'enwiki':
			$wgDBname = 'enwiki';
			break;
		case 'arwiki':
			$wgDBname = 'arwiki';
			break;
		case 'dewiki':
			$wgDBname = 'dewiki';
			break;
		case 'eswiki':
			$wgDBname = 'eswiki';
			break;
		case 'frwiki':
			$wgDBname = 'frwiki';
			break;
		default:
			$wgDBname = 'wikidatawiki';
			break;
	}
}

if ( PHP_SAPI === 'cli' ) {
	if ( isset( $argv[1] ) && $argv[1] === '--wiki' ) {
		$wgDBname = $argv[2];
		array_shift( $argv );
		array_shift( $argv );
	} else {
		$wgDBname = 'wikidatawiki';
	}
}

require_once __DIR__ . '/DebugSettings.php';
require_once __DIR__ . '/SiteSettings.php';
require_once __DIR__ . '/CommonSettings.php';
require_once __DIR__ . '/Logging.php';

/*
$wgDBtype = "sqlite";
$wgSQLiteDataDir = '/var/www/wiki/db';
$wgDBserver = "";
$wgDBuser = "";
$wgDBpassword = "";
*/

require_once __DIR__ . '/ExtensionSettings.php';
require_once __DIR__ . '/Skins.php';
