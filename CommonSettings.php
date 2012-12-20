<?php
error_reporting( E_DEPRECATED | E_USER_DEPRECATED | E_ALL | E_STRICT );

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

require_once( "$IP/../PrivateSettings.php" );
require_once( "$IP/../InitialiseSettings.php" );
require_once( "$IP/../DBSettings.php" );

if ( isset( $_SERBER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ) {
	$wgServer = preg_replace( '/^http:/', 'https:', $wgServer );
}

$wgScriptPath       = "";
$wgArticlePath      = "/wiki/$1";
$wgScriptExtension  = ".php";

$wgStylePath        = "$wgScriptPath/skins";

if ( !isset( $wgLogo ) ) {
	$wgLogo             = "$wgStylePath/common/images/wiki.png";
}

$wgEnableEmail      = true;
$wgEnableUserEmail  = true; # UPO

$wgEmergencyContact = "apache@localhost";
$wgPasswordSender   = "apache@localhost";

$wgEnotifUserTalk      = false; # UPO
$wgEnotifWatchlist     = false; # UPO
$wgEmailAuthentication = true;

$wgDBtype           = "mysql";

# MySQL specific settings
$wgDBprefix         = "";

# MySQL table options to use during installation or update
$wgDBTableOptions   = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

# Experimental charset support for MySQL 5.0.
$wgDBmysql5 = false;

## Shared memory settings
$wgMainCacheType    = CACHE_MEMCACHED;
$wgMemCachedServers = array( '127.0.0.1:11211' );

## Localisation cache
$wgLocalisationCacheConf['manualRecache'] = true;

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads  = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from http://commons.wikimedia.org
$wgUseInstantCommons  = true;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "en_US.utf8";

## If you want to use image uploads under safe mode,
## create the directories images/archive, images/thumb and
## images/temp, and make them all writable. Then uncomment
## this, if it's not already uncommented:
#$wgHashedUploadDirectory = false;

$wgSecretKey = "362f52aa65f94f306ec758c6b8e5f6c30293774dc8c23e7d3fac6c362e762d00";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = "b736600c24d29e02";

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'standard', 'nostalgia', 'cologneblue', 'monobook', 'vector':
$wgDefaultSkin = "vector";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl  = "";
$wgRightsText = "";
$wgRightsIcon = "";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

# Query string length limit for ResourceLoader. You should only set this if
# your web server has a query string length limit (then set it to that limit),
# or if you have suhosin.get.max_value_length set in php.ini (then set it to
# that value)
$wgResourceLoaderMaxQueryLength = 1024;

$wgMetaNamespace = 'Project';
$wgMetaNamespaceTalk = 'Project talk';

$wgAllowUserJs = true;
$wgAllowUserCss = true;

$wgGroupPermissions['sysop']['deletelogentry']  = true;
$wgGroupPermissions['sysop']['deleterevision']  = true;
$wgGroupPermissions['sysop']['hideuser'] = true;
$wgGroupPermissions['sysop']['suppressrevision'] = true;
$wgGroupPermissions['sysop']['editinterface'] = true;
$wgGroupPermissions['sysop']['suppressionlog'] = true;

if ( in_array( $wmgDebugMode, array( 'debug', 'testing' ) ) ) {
	require_once( "$IP/../DebugSettings.php" );
}

require_once( "$IP/../ExtensionSettings.php" );
