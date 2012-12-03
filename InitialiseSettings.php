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


$wgConf->wikis = array( 'enwikidata', 'testwikidata', 'arwiki', 'dewiki', 'enwiki' );

$wgConf->settings = array(
	'wgSitename' => array(
		'enwikidata' => 'TestRepo',
		'testwikidata' => 'TestRepo',
		'enwiki' => 'TestClient',
		'arwiki' => 'TestClient',
		'dewiki' => 'TestClient',
	),
	'wgServer' => array(
		'enwikidata' => "http://en-wikidata.$wmgSiteDomain",
		'testwikidata' => "http://test-wikidata.$wmgSiteDomain",
		'enwiki' => "http://en-wiki.$wmgSiteDomain",
		'arwiki' => "http://ar-wiki.$wmgSiteDomain",
		'dewiki' => "http://de-wiki.$wmgSiteDomain",
	),
	'wgDBserver' => array(
		'enwikidata' => $wmgDBserver2,
		'testwikidata' => $wmgDBserver2,
		'dewiki' => 'localhost',
		'enwiki' => 'localhost',
		'arwiki' => 'localhost',
	),
	'wgDBname' => array(
		'enwikidata' => 'enwikidata',
		'testwikidata' => 'testwikidata',
		'enwiki' => 'enwiki',
		'arwiki' => 'arwiki',
		'dewiki' => 'dewiki',
	),
	'wgLanguageCode' => array(
		'enwikidata' => 'en',
		'testwikidata' => 'en',
		'enwiki' => 'en',
		'dewiki' => 'de',
		'arwiki' => 'ar',
	),
	'wgLogo' => array(
		'enwikidata' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/WikidataRepo.png/120px-WikidataRepo.png',
		'testwikidata' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/WikidataRepo.png/120px-WikidataRepo.png',
		'enwiki' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/WikidataRepo.png/120px-WikidataRepo.png',
		'arwiki' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/WikidataRepo.png/120px-WikidataRepo.png',
		'dewiki' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/WikidataRepo.png/120px-WikidataRepo.png',
	),
	'wgContentHandlerUseDB' => array(
		'enwikidata' => true,
		'testwikidata' => true,
		'enwiki' => false,
		'dewiki' => false,
		'arwiki' => false,
	),
	// debug
	'wmgDebugMode' => array(
		'enwikidata' => 'debug',
		'testwikidata' => 'debug',
		'enwiki' => 'debug',
		'arwiki' => 'debug',
		'dewiki' => 'debug',
	),
	// extensions
	'wmgUseCentralAuth' => array(
		'enwikidata' => true,
		'testwikidata' => true,
		'enwiki' => true,
		'arwiki' => true,
		'dewiki' => true,
	),
	'wmgUseAbuseFilter' => array(
		'enwikidata' => false,
		'testwikidata' => false,
		'enwiki' => false,
		'arwiki' => false,
		'dewiki' => false,
	),
	'wmgUseUniversalLanguageSelector' => array(
		'enwikidata' => true,
		'testwikidata' => true,
		'enwiki' => false,
		'arwiki' => false,
		'dewiki' => false,
	),
	'wmgUseWikibaseRepo' => array(
		'enwikidata' => true,
		'testwikidata' => true,
		'enwiki' => false,
		'dewiki' => false,
		'arwiki' => false,
	),
	'wmgUseWikibaseClient' => array(
		'enwikidata' => false,
		'testwikidata' => false,
		'enwiki' => true,
		'dewiki' => true,
		'arwiki' => true,
	),
	'wmgWikibaseItemNamespace' => array(
		'enwikidata' => 'item',
		'testwikidata' => 'main',
		'enwiki' => 'item',
		'dewiki' => 'item',
		'arwiki' => 'item',
	),
	'wmgUseDeployment' => array(
		'testwikidata' => true,
		'enwikidata' => false,
		'enwiki' => false,
		'arwiki' => false,
		'dewiki' => false,
	),
	'wmgWikibaseExperimental' => array(
		'enwikidata' => false, //true,
		'testwikidata' => false,
		'enwiki' => true,
		'arwiki' => false,
		'dewiki' => false,
	),
);

$wgLocalDatabases =& $wgConf->getLocalDatabases();

$globals = $wgConf->getAll(
	$wgSiteCode
);
extract( $globals );
