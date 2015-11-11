<?php

require_once "$IP/extensions/ParserFunctions/ParserFunctions.php";
require_once "$IP/extensions/Cite/Cite.php";
require_once "$IP/extensions/WikiEditor/WikiEditor.php";

$wgDefaultUserOptions['usebetatoolbar'] = 1;
$wgDefaultUserOptions['usebetatoolbar-cgd'] = 1;
$wgDefaultUserOptions['wikieditor-preview'] = 1;

require_once "$IP/extensions/JsonConfig/JsonConfig.php";
require_once "$IP/extensions/Graph/Graph.php";

#require_once "$IP/extensions/SpamBlacklist/SpamBlacklist.php";

require_once "$IP/extensions/AntiSpoof/AntiSpoof.php";
require_once "$IP/extensions/AbuseFilter/AbuseFilter.php";

$wgGroupPermissions['sysop']['abusefilter-modify'] = true;
$wgGroupPermissions['*']['abusefilter-log-detail'] = true;
$wgGroupPermissions['*']['abusefilter-view'] = true;
$wgGroupPermissions['*']['abusefilter-log'] = true;
$wgGroupPermissions['sysop']['abusefilter-private'] = true;
$wgGroupPermissions['sysop']['abusefilter-modify-restricted'] = true;
$wgGroupPermissions['sysop']['abusefilter-revert'] = true;

//require_once "$IP/extensions/BetaFeatures/BetaFeatures.php";

require_once "$IP/extensions/SyntaxHighlight_GeSHi/SyntaxHighlight_GeSHi.php";
require_once "$IP/extensions/CodeEditor/CodeEditor.php";
require_once "$IP/extensions/Scribunto/Scribunto.php";

$wgCodeEditorEnableCore = true;

$wgScribuntoUseGeSHi = true;
$wgScribuntoUseCodeEditor = true;

require_once "$IP/extensions/UniversalLanguageSelector/UniversalLanguageSelector.php";

require_once "$IP/extensions/Gadgets/Gadgets.php";

wfLoadExtension( 'MediaWikiSearch' );

require_once "$IP/extensions/Elastica/Elastica.php";
require_once "$IP/extensions/CirrusSearch/CirrusSearch.php";

$wgSearchType = 'CirrusSearch';
$wgCirrusSearchShowNowUsing = true;
$wgCirrusSearchMoreAccurateScoringMode = false;
$wgCirrusSearchRefreshInterval = 30;
$wgCirrusSearchSearchShardTimeout[ 'regex' ] = '40s';
$wgCirrusSearchClientSideSearchTimeout[ 'regex' ] = 80;
$wgJobBackoffThrottling['cirrusSearchLinksUpdate'] = 5000;
$wgJobBackoffThrottling['cirrusSearchIncomingLinkCount'] = 1;
$wgCirrusSearchBannedPlugins[] = 'elasticsearch-analysis-hebrew';
$wgCirrusSearchConnectionAttempts = 3;
$wgCirrusSearchWikimediaExtraPlugin[ 'id_hash_mod_filter' ] = true;

$wgCirrusSearchServers = array(
    'localhost',
);

$wgCirrusSearchCustomFields = array(
	'content' => array(
		'kittens' => 'double'
	)
);

require_once "$IP/extensions/PageImages/PageImages.php";
require_once "$IP/extensions/GeoData/GeoData.php";

$wgGeoDataBackend = 'elastic';
$wgMaxCoordinatesPerPage = 2000;
$wgMaxGeoSearchRadius = 50000;
$wgGeoDataDebug = false;

// mobile

require_once "$IP/extensions/MobileFrontend/MobileFrontend.php";

$wgMFNearby = true;
$wgMFNearbyRange = 25000;
$wgMFUseWikibaseDescription = true;
$wgMFDisplayWikibaseDescription = true;

if ( isset( $wgMFQueryPropModules ) && !in_array( 'pageterms', $wgMFQueryPropModules ) ) {
	$wgMFQueryPropModules[] = 'pageterms';
}

if ( isset( $wgMFSearchAPIParams ) ) {
	$wgMFSearchAPIParams['wbptterms'] = array( 'label' );
}

require_once "$IP/extensions/Gather/Gather.php";
require_once "$IP/extensions/ZeroBanner/ZeroBanner.php";
require_once "$IP/extensions/ZeroPortal/ZeroPortal.php";

require_once __DIR__ . "/Wikibase.php";
require_once "$IP/extensions/WikibaseSearch/WikibaseSearch.php";

wfLoadExtension( 'TemplateData' );
wfLoadExtension( 'Conference' );
wfLoadExtension( 'Disambiguator' );

require_once "$IP/extensions/Babel/Babel.php";
require_once "$IP/extensions/Flow/Flow.php";

require_once "$IP/extensions/WikibaseImport/WikibaseImport.php";
require_once "$IP/extensions/WikidataQuery/WikidataQuery.php";

require_once "$IP/extensions/TemplateData/TemplateData.php";
require_once "$IP/extensions/AbuseFilter/AbuseFilter.php";
#require_once "$IP/extensions/Sites/Sites.php";

wfLoadExtension( 'SiteMatrix' );

$wgSiteMatrixFile = '/home/katie/src/mediawiki-config/dblists/langlist';
$wgSiteMatrixClosedSites = '/home/katie/src/mediawiki-config/dblists/closed.dblist';
$wgSiteMatrixPrivateSites = '/home/katie/src/mediawiki-config/dblists/private.dblist';
$wgSiteMatrixFishbowlSites = '/home/katie/src/mediawiki-config/dblists/fishbowl.dblist';

require_once "$IP/extensions/WikimediaMessages/WikimediaMessages.php";
