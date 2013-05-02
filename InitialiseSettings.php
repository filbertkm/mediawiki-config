<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

# Get the version object for this Wiki (must be set by now, along with $IP)
if ( !class_exists( 'MWMultiVersion' ) ) {
	die( "No MWMultiVersion instance initialized! MWScript.php wrapper not used?\n" );
}
$multiVersion = MWMultiVersion::getInstance();
$wgSiteCode = $multiVersion->getDatabase();

$wgConf = new SiteConfiguration;

$wgConf->suffixes = array(
	'wiki',
	'wikidata',
);

$repos = array( 'enwikidata', 'testwikidata' );
$wgConf->wikis = array_merge( $repos,
	array_map( 'trim', file( getRealmSpecificFilename( "$IP/../wikipedia.dblist" ) ) )
);

$wgConf->settings = array(
	'wgSitename' => array(
		'default' => 'TestClient',
		'enwikidata' => 'TestRepo',
		'testwikidata' => 'TestRepo',
		'enwiki' => 'TestClient',
		'arwiki' => 'TestClient',
		'dewiki' => 'TestClient',
		'hewiki' => 'TestClient',
	),
	'wgServer' => array(
		'enwikidata' => "http://en-wikidata.$wmgSiteDomain",
		'testwikidata' => "http://test-wikidata.$wmgSiteDomain",
		'enwiki' => "http://en-wiki.$wmgSiteDomain",
		'arwiki' => "http://ar-wiki.$wmgSiteDomain",
		'dewiki' => "http://de-wiki.$wmgSiteDomain",
		'hewiki' => "http://he-wiki.$wmgSiteDomain",
		'afwiki' => "http://af-wiki.$wmgSiteDomain",
		'azwiki' => "http://az-wiki.$wmgSiteDomain",
		'cawiki' => "http://ca-wiki.$wmgSiteDomain",
		'elwiki' => "http://el-wiki.$wmgSiteDomain",
		'eswiki' => "http://es-wiki.$wmgSiteDomain",
		'frwiki' => "http://fr-wiki.$wmgSiteDomain",
		'fiwiki' => "http://fi-wiki.$wmgSiteDomain",
		'fawiki' => "http://fa-wiki.$wmgSiteDomain",
		'iswiki' => "http://is-wiki.$wmgSiteDomain",
		'idwiki' => "http://id-wiki.$wmgSiteDomain",
		'itwiki' => "http://it-wiki.$wmgSiteDomain",
		'jawiki' => "http://ja-wiki.$wmgSiteDomain",
		'kowiki' => "http://ko-wiki.$wmgSiteDomain",
		'plwiki' => "http://pl-wiki.$wmgSiteDomain",
		'ptwiki' => "http://pt-wiki.$wmgSiteDomain",
		'ruwiki' => "http://ru-wiki.$wmgSiteDomain",
		'svwiki' => "http://sv-wiki.$wmgSiteDomain",
		'trwiki' => "http://tr-wiki.$wmgSiteDomain",
		'urwiki' => "http://ur-wiki.$wmgSiteDomain",
		'zhwiki' => "http://zh-wiki.$wmgSiteDomain",

	),
	'wgDBserver' => array(
		'default' => 'localhost',
		'enwikidata' => $wmgDBserver2,
		'testwikidata' => $wmgDBserver2,
	),
	'wgDBprefix' => array(
		'default' => '',
		'testwikidata' => 'testdb_',
	),
	'wgDBname' => array_combine( $wgConf->wikis, $wgConf->wikis ),
	'wgExternalStores' => array(
		'default' => array( 'DB' ),
	),
	'wgLanguageCode' => array(
		'default' => 'en',
		'dewiki' => 'de',
		'afwiki' => 'af',
		'arwiki' => 'ar',
		'azwiki' => 'az',
		'cawiki' => 'ca',
		'elwiki' => 'el',
		'eswiki' => 'es',
		'fawiki' => 'fa',
		'fiwiki' => 'fi',
		'frwiki' => 'fr',
		'hewiki' => 'he',
		'idwiki' => 'id',
		'itwiki' => 'it',
		'iswiki' => 'is',
		'jawiki' => 'ja',
		'kowiki' => 'ko',
		'ptwiki' => 'pt',
		'plwiki' => 'pl',
		'ruwiki' => 'ru',
		'svwiki' => 'sv',
		'trwiki' => 'tr',
		'urwiki' => 'ur',
		'zhwiki' => 'zh',
	),
	'wgLogo' => array(
		'default' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/WikidataClient.png/120px-WikidataClient.png',
		'enwikidata' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/WikidataRepo.png/120px-WikidataRepo.png',
		'testwikidata' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/WikidataRepo.png/120px-WikidataRepo.png',
	),
	'wgCacheDirectory' => array(
		'default' => '/tmp/mw-cache/client',
		'enwikidata' => '/tmp/mw-cache/enwikidata',
		'testwikidata' => '/tmp/mw-cache/testwikidata',
		'enwiki' => '/tmp/mw-cache/enwiki',
		'arwiki' => '/tmp/mw-cache/arwiki',
		'dewiki' => '/tmp/mw-cache/dewiki',
		'hewiki' => '/tmp/mw-cache/hewiki',
		'huwiki' => '/tmp/mw-cache/huwiki',
	),
	'wgContentNamespaces' => array(
		'default' => array( NS_MAIN ),
		'enwikidata' => array( 100 )
	),
	'wgUseRCPatrol' => array(
		'default' => false,
		'enwiki' => true,
		'enwikidata' => true,
	),
	'wgContentHandlerUseDB' => array(
		'default' => false,
		'enwikidata' => true,
		'testwikidata' => true,
	),
	// debug
	'wmgDebugMode' => array(
		'default' => true,
	),
	// extensions
	'wmgUseCentralAuth' => array(
		'default' => true,
	),
	'wmgUseAbuseFilter' => array(
		'default' => false,
	),
	'wmgUseFlaggedRevs' => array(
		'default' => false,
		'enwiki' => true,
	),
	'wmgUseScribunto' => array(
		'default' => false,
		'enwiki' => true
	),
	'wmgUseUniversalLanguageSelector' => array(
		'default' => false,
		'enwikidata' => true,
		'testwikidata' => true,
	),
	'wmgUseWikibaseRepo' => array(
		'default' => false,
		'enwikidata' => true,
		'testwikidata' => true,
	),
	'wmgUseWikibaseClient' => array(
		'default' => true,
		'enwikidata' => false,
		'testwikidata' => false,
	),
	'wmgWikibaseClientSettings' => array(
		'enwiki' => array(
			'sort' => 'alphabetic_sr',
		),
		'huwiki' => array(
			'sortPrepend' => array( 'en' ),
		),
		'hewiki' => array(
			'sortPrepend' => array( 'en' ),
		),
	),
	'wmgWikibaseItemsInMainNS' => array(
		'default' => false,
		'testwikidata' => true,
	),
	'wmgWikibaseExperimental' => array(
		'default' => true,
		'enwikidata' => true,
		'enwiki' => false,
		'hewiki' => false,
	),
	'wmgUseWikimaniaScholarships' => array(
		'default' => false,
		'enwiki' => true,
	),
	'wmgUseMultiWiki' => array(
		'default' => true,
		'testwikidata' => false,
	),
	'wmgUseUploadWizard' => array(
		'default' => false,
		'enwiki' => true,
	),
	'wmgUseVisualEditor' => array(
		'default' => false,
		'enwiki' => true,
		'arwiki' => true
	)
);

$wgLocalDatabases =& $wgConf->getLocalDatabases();

$globals = $wgConf->getAll(
	$wgSiteCode
);
extract( $globals );
