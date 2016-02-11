<?php

require_once "$IP/extensions/ParserFunctions/ParserFunctions.php";
require_once "$IP/extensions/Cite/Cite.php";
require_once "$IP/extensions/cldr/cldr.php";
require_once "$IP/extensions/WikiEditor/WikiEditor.php";

$wgDefaultUserOptions['usebetatoolbar'] = 1;
$wgDefaultUserOptions['usebetatoolbar-cgd'] = 1;
$wgDefaultUserOptions['wikieditor-preview'] = 1;

require_once "$IP/extensions/JsonConfig/JsonConfig.php";
require_once "$IP/extensions/Graph/Graph.php";

$wgGraphDataDomains = array(
	'mediawiki.org',
	'www.mediawiki.org'
);

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

require_once "$IP/extensions/BetaFeatures/BetaFeatures.php";

require_once "$IP/extensions/SyntaxHighlight_GeSHi/SyntaxHighlight_GeSHi.php";
require_once "$IP/extensions/CodeEditor/CodeEditor.php";
require_once "$IP/extensions/Scribunto/Scribunto.php";

$wgCodeEditorEnableCore = true;

$wgScribuntoUseGeSHi = true;
$wgScribuntoUseCodeEditor = true;

require_once "$IP/extensions/UniversalLanguageSelector/UniversalLanguageSelector.php";

require_once "$IP/extensions/Gadgets/Gadgets.php";

require_once "$IP/extensions/Elastica/Elastica.php";
require_once "$IP/extensions/CirrusSearch/CirrusSearch.php";

$wgSearchType = 'CirrusSearch';

$wgCirrusSearchShowNowUsing = true;
$wgCirrusSearchMoreAccurateScoringMode = false;
$wgCirrusSearchRefreshInterval = 30;
$wgCirrusSearchSearchShardTimeout[ 'regex' ] = '20s';
$wgCirrusSearchClientSideSearchTimeout[ 'regex' ] = 30;
$wgJobBackoffThrottling['cirrusSearchLinksUpdate'] = 5000;
$wgJobBackoffThrottling['cirrusSearchIncomingLinkCount'] = 1;
$wgCirrusSearchBannedPlugins[] = 'elasticsearch-analysis-hebrew';
$wgCirrusSearchConnectionAttempts = 3;

$wgCirrusSearchServers = array(
	'localhost',
);

$wgCirrusSearchWikimediaExtraPlugin = array(
	'regex' => array(
		'build',
		'use',
	),
	'super_detect_noop' => true,
	'field_value_factor_with_default' => false,
	'id_hash_mod_filter' => true,
);

if ( $wgDBname === 'wikidatawiki' ) {

	// $wgCirrusSearchNearMatchWeight = 2;

	$wgCirrusSearchRescoreProfiles += array(
		'wikidata' => array(
			'supported_namespaces' => array( 0 ),
			'fallback_profile' => 'default',
			'rescore' => array(
				array(
					'window' => 15000,
					'window_size_override' => 'CirrusSearchFunctionRescoreWindowSize',
					'type' => 'function_score',
					'function_chain' => 'wikibase_avg',
					'query_weight' => 1.2,
					'rescore_query_weight' => 0.01
				),
				array(
					'window' => 15000,
					'window_size_override' => 'CirrusSearchFunctionRescoreWindowSize',
					'type' => 'function_score',
					'function_chain' => 'optional_chain'
				)
			)
		)
	);

	$wgCirrusSearchRescoreFunctionScoreChains += array(
		'wikibase_avg' => array(
			'score_mode' => 'avg',
			'functions' => array(
				array(
					'type' => 'custom_field',
					'params' => array(
						'field' => 'sitelink_count',
						'missing' => 0,
					)
				),
				array(
					'type' => 'custom_field',
					'params' => array(
						'field' => 'label_count',
						'missing' => 0
					)
				),
				array(
					'type' => 'custom_field',
					'params' => array(
						'field' => 'statement_count',
						'missing' => 0
					)
				)
			)
		)
	);

	$wgCirrusSearchRescoreProfile = $wgCirrusSearchRescoreProfiles['wikidata'];
	// $wgCirrusSearchPrefixSearchRescoreProfile = $wgCirrusSearchRescoreFunctionScoreChains['default'];

}

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
$wgMobileFrontendLogo = '/../images/mobile/wikidata.png';

#require_once "$IP/extensions/Gather/Gather.php";
require_once "$IP/extensions/ZeroBanner/ZeroBanner.php";
require_once "$IP/extensions/ZeroPortal/ZeroPortal.php";

//$wgMFQueryPropModules = $wmgMFQueryPropModules;
$wgMFSearchAPIParams = $wmgMFSearchAPIParams;
$wgMFSearchUseDisplayTitle = false;

if ( $wgDBname === 'wikidatawiki' ) {
	$wgMFSearchGenerator = array(
		'name' => 'wbsearch',
		'prefix' => 'wbs'
	);
}

require_once "$IP/extensions/Babel/Babel.php";

$wgBabelMainCategory = 'User %code%';
$wgBabelDefaultLevel = 'N';
$wgBabelUseUserLanguage = true;

$wgBabelCategoryNames = array(
	'0' => 'User %code%-0',
	'1' => 'User %code%-1',
	'2' => 'User %code%-2',
	'3' => 'User %code%-3',
	'4' => 'User %code%-4',
	'5' => 'User %code%-5',
	'N' => 'User %code%-N',
);

require_once "$IP/extensions/VisualEditor/VisualEditor.php";

$wgVirtualRestConfig['modules']['parsoid'] = array(
	// URL to the Parsoid instance
	// Use port 8142 if you use the Debian package
	'url' => 'http://localhost:8000',
	// Parsoid "domain", see below (optional)
	'domain' => 'enwiki',
	// Parsoid "prefix", see below (optional)
	'prefix' => 'enwiki'
);

require_once __DIR__ . "/Wikibase.php";

wfLoadExtension( 'TemplateData' );
// wfLoadExtension( 'Disambiguator' );

require_once "$IP/extensions/Echo/Echo.php";
require_once "$IP/extensions/Flow/Flow.php";

$wgNamespaceContentModels[NS_PROJECT_TALK] = CONTENT_MODEL_FLOW_BOARD;
$wgNamespaceContentModels[NS_USER_TALK] = CONTENT_MODEL_FLOW_BOARD;
$wgGroupPermissions['sysop']['flow-create-board'] = true;

require_once "$IP/extensions/WikibaseImport/WikibaseImport.php";
require_once "$IP/extensions/WikidataQuery/WikidataQuery.php";

require_once "$IP/extensions/TemplateData/TemplateData.php";
require_once "$IP/extensions/AbuseFilter/AbuseFilter.php";

require_once "$IP/extensions/Math/Math.php";

// Set MathML as default rendering option;
$wgDefaultUserOptions['math'] = 'mathml';
$wgMathFullRestbaseURL= 'https://api.formulasearchengine.com/';

# require_once "$IP/extensions/WikiStream/WikiStream.php";

wfLoadExtension( 'Kartographer' );
# wfLoadExtension( 'ORES' );

require_once "$IP/extensions/AntiSpoof/AntiSpoof.php";

wfLoadExtension( 'SiteMatrix' );

$wgSiteMatrixFile = '/home/katie/src/mediawiki-config/dblists/langlist';
$wgSiteMatrixClosedSites = '/home/katie/src/mediawiki-config/dblists/closed.dblist';
$wgSiteMatrixPrivateSites = '/home/katie/src/mediawiki-config/dblists/private.dblist';
$wgSiteMatrixFishbowlSites = '/home/katie/src/mediawiki-config/dblists/fishbowl.dblist';

require_once "$IP/extensions/WikimediaMessages/WikimediaMessages.php";
