<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

$wmgUseWikibaseRepo = false;
$wmgUseWikibaseClient = false;
$wmgUseWikibaseQuery = false;
$wmgUseWikibaseExperimental = false;
$wmgUseWikibaseBuild = true;
$wmgSingleInstance = false;
$wgDBname = 'testrepo';

if ( isset( $_SERVER ) && array_key_exists( 'SERVER_NAME', $_SERVER ) ) {
	switch ( $_SERVER['SERVER_NAME'] ) {
		case 'wikidata-repo':
			$wgDBname = 'testrepo';
			break;
		case 'wikidata-client':
			$wgDBname = 'testclient';
			break;
		case 'enwiki':
			$wgDBname = 'enwiki';
			break;
		case 'wikidata-all':
			$wgDBname = 'wikidatawiki';
			break;
		case 'wikidata-example':
			$wgDBname = 'wikidata_example';
			break;
		default:
			die( 'cannot find wiki' );
			break;
	}
}

if ( PHP_SAPI === 'cli' ) {
	if ( isset( $argv[0] ) && $argv[0] === '--wiki' ) {
		$wgDBname = $argv[1];
		array_shift( $argv );
		array_shift( $argv );
	}
}

if ( $wgDBname === 'wikidata_sqlite' ) {
	$wgDBtype = "sqlite";
	$wgSQLiteDataDir = '/Library/WebServer/Documents/config';
} else {
	require_once ( "$IP/../config/DBSettings.php" );
}

if ( $wgDBname === 'testrepo' ) {
	$wmgUseWikibaseRepo = true;
	$wmgUseWikibaseClient = true;
	$wmgUseWikibaseExperimental = true;
	$wgSitename = "TestRepo";
	$wgServer = "http://wikidata-repo";
} elseif ( $wgDBname === 'testclient' || $wgDBname === 'enwikisource' ) {
	$wmgUseWikibaseClient = true;
	$wgSitename = "TestClient";
	$wgServer = "http://wikidata-client";
} elseif ( $wgDBname === 'enwiki' ) {
	$wmgUseWikibaseClient = true;
	$wgSitename = "Wikipedia";
	$wgServer = 'http://enwiki';
} elseif ( $wgDBname === 'wikidatawiki' ) {
	$wmgUseWikibaseRepo = true;
	$wmgUseWikibaseClient = true;
	$wmgUseWikibasePropertySuggester = true;
	$wgSiteName = "TestAll";
	$wgServer = "http://wikidata-all";
} elseif ( $wgDBname === 'wikidata_sqlite' ) {
	$wmgUseWikibaseRepo = true;
	$wmgUseWikibaseClient = true;
	$wmgUseWikibaseExperimental = true;
	$wgSitename = "ExampleRepo";
	$wgServer = "http://wikidata-example";
}

$wgLogo = "http://upload.wikimedia.org/wikipedia/commons/thumb/4/43/"
	. "Wikidata-logo-en-black.svg/135px-Wikidata-logo-en-black.svg.png";

$wgLanguageCode = "en";

require_once "$IP/../config/CommonSettings.php";
require_once "$IP/../config/ExtensionSettings.php";
require_once "$IP/../config/WikibaseSettings.php";
//require_once "$IP/../config/Wikibase.php";
require_once "$IP/../config/PrivateSettings.php";
