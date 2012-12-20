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


$wgConf->wikis = array( 'enwikidata', 'testwikidata', 'arwiki', 'dewiki', 'enwiki', 'huwiki' );

$wgConf->settings = array(
	'wgSitename' => array(
		'enwikidata' => 'TestRepo',
		'testwikidata' => 'TestRepo',
		'enwiki' => 'TestClient',
		'arwiki' => 'TestClient',
		'dewiki' => 'TestClient',
		'huwiki' => 'TestClient',
	),
	'wgServer' => array(
		'enwikidata' => "http://en-wikidata.$wmgSiteDomain",
		'testwikidata' => "http://test-wikidata.$wmgSiteDomain",
		'enwiki' => "http://en-wiki.$wmgSiteDomain",
		'arwiki' => "http://ar-wiki.$wmgSiteDomain",
		'dewiki' => "http://de-wiki.$wmgSiteDomain",
		'huwiki' => "http://hu-wiki.$wmgSiteDomain",
	),
	'wgDBserver' => array(
		'enwikidata' => $wmgDBserver2,
		'testwikidata' => $wmgDBserver2,
		'dewiki' => 'localhost',
		'enwiki' => 'localhost',
		'arwiki' => 'localhost',
		'huwiki' => 'localhost',
	),
	'wgDBname' => array(
		'enwikidata' => 'enwikidata',
		'testwikidata' => 'testwikidata',
		'enwiki' => 'enwiki',
		'arwiki' => 'arwiki',
		'dewiki' => 'dewiki',
		'huwiki' => 'huwiki',
	),
	'wgExternalStores' => array(
		'enwikidata' => array( 'DB' ),
		'testwikidata' => array( 'DB' ),
		'enwiki' => array( 'DB' ),
		'arwiki' => array( 'DB' ),
		'dewiki' => array( 'DB' ),
		'huwiki' => array( 'DB' ),
	),
	'wgLanguageCode' => array(
		'enwikidata' => 'en',
		'testwikidata' => 'en',
		'enwiki' => 'en',
		'dewiki' => 'de',
		'arwiki' => 'ar',
		'huwiki' => 'hu',
	),
	'wgLogo' => array(
		'enwikidata' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/WikidataRepo.png/120px-WikidataRepo.png',
		'testwikidata' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/WikidataRepo.png/120px-WikidataRepo.png',
		'enwiki' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/WikidataRepo.png/120px-WikidataRepo.png',
		'arwiki' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/WikidataRepo.png/120px-WikidataRepo.png',
		'dewiki' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/WikidataRepo.png/120px-WikidataRepo.png',
		'huwiki' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/WikidataRepo.png/120px-WikidataRepo.png',
	),
	'wgCacheDirectory' => array(
		'enwikidata' => '/tmp/mw-cache/enwikidata',
		'testwikidata' => '/tmp/mw-cache/testwikidata',
		'enwiki' => '/tmp/mw-cache/enwiki',
		'arwiki' => '/tmp/mw-cache/arwiki',
		'dewiki' => '/tmp/mw-cache/dewiki',
		'huwiki' => '/tmp/mw-cache/huwiki',
	),
	'wgContentHandlerUseDB' => array(
		'enwikidata' => true,
		'testwikidata' => true,
		'enwiki' => false,
		'dewiki' => false,
		'arwiki' => false,
		'huwiki' => false,
	),
	// debug
	'wmgDebugMode' => array(
		'enwikidata' => 'debug',
		'testwikidata' => 'debug',
		'enwiki' => 'debug',
		'arwiki' => 'debug',
		'dewiki' => 'debug',
		'huwiki' => 'debug',
	),
	// extensions
	'wmgUseCentralAuth' => array(
		'enwikidata' => true,
		'testwikidata' => true,
		'enwiki' => true,
		'arwiki' => true,
		'dewiki' => true,
		'huwiki' => true,
	),
	'wmgUseAbuseFilter' => array(
		'enwikidata' => false,
		'testwikidata' => false,
		'enwiki' => false,
		'arwiki' => false,
		'dewiki' => false,
		'huwiki' => false,
	),
	'wmgUseUniversalLanguageSelector' => array(
		'enwikidata' => true,
		'testwikidata' => true,
		'enwiki' => false,
		'arwiki' => false,
		'dewiki' => false,
		'huwiki' => false,
	),
	'wmgUseWikibaseRepo' => array(
		'enwikidata' => true,
		'testwikidata' => true,
		'enwiki' => false,
		'dewiki' => false,
		'arwiki' => false,
		'huwiki' => false,
	),
	'wmgUseWikibaseClient' => array(
		'enwikidata' => false,
		'testwikidata' => false,
		'enwiki' => true,
		'dewiki' => true,
		'arwiki' => true,
		'huwiki' => false,
	),
	'wmgWikibaseItemNamespace' => array(
		'enwikidata' => 'item',
		'testwikidata' => 'main',
		'enwiki' => 'item',
		'dewiki' => 'item',
		'arwiki' => 'item',
		'huwiki' => 'item',
	),
	'wmgUseDeployment' => array(
		'testwikidata' => true,
		'enwikidata' => false,
		'enwiki' => false,
		'arwiki' => false,
		'dewiki' => false,
		'huwiki' => false,
	),
	'wmgWikibaseExperimental' => array(
		'enwikidata' => true, //true,
		'testwikidata' => false,
		'enwiki' => true,
		'arwiki' => false,
		'dewiki' => false,
		'huwiki' => false,
	),
);

$wgLocalDatabases =& $wgConf->getLocalDatabases();

$globals = $wgConf->getAll(
	$wgSiteCode
);
extract( $globals );
