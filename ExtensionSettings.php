<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Invalid entry point.' );
}

// extensions enabled by default on all wikis
require_once "$IP/extensions/ParserFunctions/ParserFunctions.php";
require_once "$IP/extensions/CharInsert/CharInsert.php";
require_once "$IP/extensions/Cite/Cite.php";
#require_once "$IP/extensions/CiteThisPage/CiteThisPage.php";
require_once "$IP/extensions/InputBox/InputBox.php";
require_once "$IP/extensions/ImageMap/ImageMap.php";
require_once "$IP/extensions/SyntaxHighlight_GeSHi/SyntaxHighlight_GeSHi.php";
require_once "$IP/extensions/Poem/Poem.php";
require_once "$IP/extensions/CategoryTree/CategoryTree.php";
require_once "$IP/extensions/CheckUser/CheckUser.php";
require_once "$IP/extensions/cldr/cldr.php";

# SpamBlacklist
require_once "$IP/extensions/SpamBlacklist/SpamBlacklist.php";

$wgBlacklistSettings = array(
	'spam' => array(
		'files' => array(
			'http://meta.wikimedia.org/w/index.php?title=Spam_blacklist&action=raw&sb_ver=1'
		),
	),
);

$wgLogSpamBlacklistHits = true;

require_once "$IP/extensions/TitleBlacklist/TitleBlacklist.php";

$wgTitleBlacklistSources = array(
    array(
        'type' => TBLSRC_URL,
        'src'  => "//meta.wikimedia.org/w/index.php?title=Title_blacklist&action=raw&tb_ver=1",
    ),
);

require_once "$IP/extensions/Gadgets/Gadgets.php";

# search!
require_once "$IP/extensions/Elastica/Elastica.php";
require_once "$IP/extensions/CirrusSearch/CirrusSearch.php";
$wgSearchType = 'CirrusSearch';
$wgCirrusSearchShowNowUsing = true;
$wgCirrusSearchMoreAccurateScoringMode = false;
$wgCirrusSearchRefreshInterval = 30;
$wgCirrusSearchSearchShardTimeout[ 'regex' ] = '40s';
$wgCirrusSearchClientSideSearchTimeout[ 'regex' ] = 80;
$wgJobBackoffThrottling['cirrusSearchLinksUpdate'] = 5;
$wgJobBackoffThrottling['cirrusSearchIncomingLinkCount'] = 1;
$wgCirrusSearchBannedPlugins[] = 'elasticsearch-analysis-hebrew';
$wgCirrusSearchUseExperimentalHighlighter = true;
$wgCirrusSearchOptimizeIndexForExperimentalHighlighter = true;
$wgCirrusSearchConnectionAttempts = 3;

$wgCirrusSearchServers = array(
    'localhost',
);

# Vector
require_once"$IP/extensions/VectorBeta/VectorBeta.php";

require_once "$IP/extensions/BetaFeatures/BetaFeatures.php";
require_once "$IP/extensions/Popups/Popups.php";
require_once "$IP/extensions/GuidedTour/GuidedTour.php";

# WikiEditor
require_once( "$IP/extensions/WikiEditor/WikiEditor.php" );

$wgDefaultUserOptions['usebetatoolbar'] = 1;
$wgDefaultUserOptions['usebetatoolbar-cgd'] = 1;
$wgDefaultUserOptions['wikieditor-preview'] = 1;

# Abuse Filter
require_once( "$IP/extensions/AntiSpoof/AntiSpoof.php" );
require_once( "$IP/extensions/AbuseFilter/AbuseFilter.php" );

$wgAbuseFilterCentralDB = 'abusefilter';
$wgAbuseFilterIsCentral = true;

$wgGroupPermissions['sysop']['abusefilter-modify'] = true;
$wgGroupPermissions['*']['abusefilter-log-detail'] = true;
$wgGroupPermissions['*']['abusefilter-view'] = true;
$wgGroupPermissions['*']['abusefilter-log'] = true;
$wgGroupPermissions['sysop']['abusefilter-private'] = true;
$wgGroupPermissions['sysop']['abusefilter-modify-restricted'] = true;
$wgGroupPermissions['sysop']['abusefilter-revert'] = true;

# CentralAuth
if ( !defined( 'MW_PHPUNIT_TEST' ) ) {
/*
	require_once( "$IP/extensions/CentralAuth/CentralAuth.php" );

	$wgCentralAuthCookies = true;
	$wgCentralAuthAutoNew = true;

	$wgHooks['CentralAuthWikiList'][] = 'wmfCentralAuthWikiList';
	function wmfCentralAuthWikiList( &$list ) {
		global $wgLocalDatabases;
		$list = $wgLocalDatabases;
		return true;
	}
*/
}

require_once "$IP/extensions/Mantle/Mantle.php";
require_once "$IP/extensions/MobileFrontend/MobileFrontend.php";

require_once "$IP/extensions/ApiSandbox/ApiSandbox.php";

require_once "$IP/extensions/CodeEditor/CodeEditor.php";
require_once "$IP/extensions/Scribunto/Scribunto.php";
$wgScribuntoUseGeSHi = true;
$wgScribuntoUseCodeEditor = true;
$wgScribuntoDefaultEngine = 'luastandalone';

require_once "$IP/extensions/UniversalLanguageSelector/UniversalLanguageSelector.php";
$wgULSGeoService = true;
$wgULSEnableAnon = true;

require_once "$IP/extensions/CustomData/CustomData.php";
require_once "$IP/extensions/GeoCrumbs/GeoCrumbs.php";
require_once "$IP/extensions/MapSources/MapSources.php";
