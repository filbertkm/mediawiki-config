<?php
error_reporting( -1 );
ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
//error_reporting( E_ALL | E_STRICT );

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

require_once __DIR__ . '/SiteSettings.php';

$wgEdititis = true;

$wgScriptPath = "";
$wgArticlePath = "/wiki/$1";
$wgUsePathInfo = true;

require_once "$IP/skins/Vector/Vector.php";
require_once "$IP/skins/MonoBook/MonoBook.php";
require_once "$IP/skins/Modern/Modern.php";
require_once "$IP/skins/CologneBlue/CologneBlue.php";
require_once "$IP/skins/Metrolook/Metrolook.php";

$wgStylePath = "$wgScriptPath/skins";
$wgValidSkins = array( 'cologneblue', 'modern', 'monobook', 'vector', 'tempo', 'tomas',
	'Metrolook', 'truglass', 'daddio' );

if ( !isset( $wgLogo ) ) {
	$wgLogo = "$wgStylePath/common/images/wiki.png";
}

$wgMetaNamespace =  $wgDBname === 'testrepo' ? 'Wikidata' : 'Project';
$wgMetaNamespaceTalk = $wgDBname === 'testrepo' ? 'Wikidata_talk' : 'Project_talk';

$wgEnableEmail	  = true;
$wgEnableUserEmail  = true; # UPO

$wgEmergencyContact = "apache@localhost";
$wgPasswordSender   = "apache@localhost";
//$wgPasswordDefault = 'B';

$wgEnotifUserTalk	  = false; # UPO
$wgEnotifWatchlist	 = true;
$wgEmailAuthentication = true;

$wgJobRunRate = 0;

$wgMainCacheType	= CACHE_MEMCACHED;
//$wgMainCacheType = 'memcached-pecl';
$wgMemCachedServers = array( '127.0.0.1:11211' );
$wgCacheEpoch = '20140925125000';
$wgResourceLoaderStorageEnabled = true;
$wgRevisionCacheExpiry = 86400 * 7;
$wgEnableSidebarCache = false;

$wgSitesCacheFile = "$IP/sites.json";

//$wgLocalisationCacheConf['manualRecache'] = true;
//$wgUseLocalMessageCache = true;
$wgCacheDirectory = __DIR__ . '/../cache';

$wgEnableUploads = true;
#$wgUseImageMagick = true;
#$wgImageMagickConvertCommand = "/usr/bin/convert";
$wgUseInstantCommons = true;

$wgShellLocale = "en_US.UTF-8";

#$wgHashedUploadDirectory = false;
#$wgCacheDirectory = "$IP/cache";

if ( !isset( $wgLanguageCode ) ) {
	$wgLanguageCode = "en";
}

$wgSecretKey = "b3d2411fac4b4d56d68b7a097f81ede946516bf39857ae055e3ca86c3e45d9d7";
$wgUpgradeKey = "9e4905c852ba2f01";

$wgDefaultSkin = "vector";

$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl  = "//creativecommons.org/licenses/by-sa/3.0/";
$wgRightsText = "Creative Commons Attribution-Share Alike 3.0";
$wgRightsIcon = "//creativecommons.org/images/public/somerights20.png";

$wgDiff3 = "/usr/bin/diff3";

$wgResourceLoaderMaxQueryLength = -1;
$wgIncludejQueryMigrate = true;

$wgAllowUserJs = true;
$wgAllowUserCss = true;

$wgCrossSiteAJAXdomains = array(
	'wikidata-repo',
	'wikidata-client'
);

$wgDefaultUserOptions['watchdefault'] = 0;
$wgDefaultUserOptions['enotifwatchlistpages'] = 0;
$wgDefaultUserOptions['usenewrc'] = 0;

#$wgAmericanDates = true;

$wgDebugToolbar = false;
$wgShowExceptionDetails = true;
$wgShowSQLErrors		= true;
$wgEnableJavaScriptTest = true;
$wgDevelopmentWarnings = true;
$wgShowDBErrorBacktrace = true;
#$wgResourceLoaderDebug = true;
$wgDeprecationReleaseLimit = '1.20';

require_once __DIR__ . '/Profile.php';

$wgHooks['LoginAuthenticateAudit'][] = function( $user, $pass, $retval ) {
	if ( $user->isAllowed( 'delete' ) ) {

	}

	return true;
};

$wgAutoConfirmAge = 4 * 3600 * 24;
$wgAutoConfirmCount = 10;

$wgAutopromote = array(
	'autoconfirmed' => array( '&',
		array( APCOND_EDITCOUNT, $wgAutoConfirmCount ),
		array( APCOND_AGE, $wgAutoConfirmAge ),
	),
);

$wgAutopromoteOnce = array(
	'onEdit' => array(),
	'onView' => array()
);

global $wgGroupPermissions;
$wgGroupPermissions['confirmed'] = $wgGroupPermissions['autoconfirmed'];

$wgGroupPermissions['sysop']['deletelogentry'] = true;
$wgGroupPermissions['sysop']['deleterevision'] = true;
$wgGroupPermissions['sysop']['hideuser'] = true;
$wgGroupPermissions['sysop']['suppressrevision'] = true;
$wgGroupPermissions['sysop']['suppressionlog'] = true;

$wgExtraLanguageNames = array(
	'ota' => 'لسان توركى'
);

$wgHooks['SkinTemplateOutputPageBeforeExec'][] = function( $sk, $tpl ) {
	$reportVars = array(
		'wgMemoryUsage' => memory_get_usage()
	);

	$reportTime = $tpl->get( 'reporttime' );
	$tpl->set( 'reporttime', $reportTime . Skin::makeVariablesScript( $reportVars ) );
};

require_once __DIR__ . '/ExtensionMessages.php';

function logBacktrace() {
	wfDebugLog( 'wikidata', __CLASS__ . ':' . __METHOD__ );
	ob_start();
	var_dump( debug_backtrace() );
	$backtrace = ob_get_clean();
	wfDebugLog( 'wikidata', $backtrace );
}

function exportData( $object ) {
	ob_start();
	var_dump( $object );
	$data = ob_get_clean();
	var_export( $data );
}

function logData( $object ) {
	wfDebugLog( 'wikidata', var_export( $object, true ) );
}

function logString( $string ) {
	wfDebugLog( 'wikidata', $string );
}

$wgPreviousUsage = null;

function wfMemoryUsage( $class = null, $object = null ) {
	global $wgPreviousUsage;
	return;
	$usage = memory_get_usage( true );
	echo $usage;

	if ( $wgPreviousUsage === null ) {
		$wgPreviousUsage = $usage;
	}

	if ( $usage > $wgPreviousUsage && $object !== null ) {
		echo "\n*****\n";
		var_export( $object );
		echo "\n";
	}

	$wgPreviousUsage = $usage;

	$callers = debug_backtrace();
	echo ': ';

	if ( $class && is_string( $class ) ) {
		echo $class . ':';
	}

	echo $callers[1]['function'];

	if ( $object ) {
		echo ' - ' . is_object( $object ) ? get_class( $object ) : gettype( $object );
	}

	echo "\n";
}

$wgDebugLogGroups = array(
	'memcached' => '/Library/WebServer/Documents/logs/memcached.log',
	'wikidata' => '/Library/WebServer/Documents/logs/wikidata.log',
	'exception' => '/Library/WebServer/Documents/logs/exception.log'
);
