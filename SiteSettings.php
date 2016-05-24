<?php

$wgConf = new SiteConfiguration();

$wgConf->suffixes = array(
	// 'wikipedia',
	'wikipedia' => 'wiki',
	'wiktionary',
	'wikiquote',
	'wikibooks',
	'wikiquote',
	'wikinews',
	'wikisource',
	'wikiversity',
	'wikimedia',
	'wikivoyage',
	'wikidata'
);

$wgConf->wikis = array_map( 'trim', file( '/home/katie/src/mediawiki-config/dblists/all.dblist' ) );

$wgConf->settings = array(
	'wmgUseWikibaseQualityExternalValidation' => array(
		'default' => true,
	),
	'wmgUseWikibaseQuality' => array(
		'default' => true,
	),
	'wmgUseArticlePlaceholder' => array(
		'enwiki' => true,
	),
	'wgLanguageCode' => array(
		'default' => 'en',
		'arwiki' => 'ar',
		'dewiki' => 'de',
		'eswiki' => 'es',
		'frwiki' => 'fr'
	),
	'wgCanonicalServer' => array(
		'defulat' => 'http://localhost',
		'wikidata' => 'http://wikidatawiki',
		'wikidatawiki' => 'http://wikidatawiki',
		'enwiki' => 'http://enwiki'
	),
	'wgServer' => array(
		'default' => 'http://localhost',
		'arwiki' => 'http://arwiki',
		'dewiki' => 'http://dewiki',
		'enwiki' => 'http://enwiki',
		'eswiki' => 'http://eswiki',
		'frwiki' => 'http://frwiki',
		'wikidata' => 'http://wikidatawiki',
		'wikidatawiki' => 'http://wikidatawiki',
	),
	'wgArticlePath' => array(
		'default' => '/wiki/$1',
	),
	'wgSitename' => array(
		'wikipedia' => 'Wikipedia',
		'wikisource' => 'Wikisource',
		'wikidata' => 'Wikidata',
		'wikidatawiki' => 'Wikidata'
	),
	'wmgUseWikibaseRepo' => array(
		'default' => false,
		'wikidata' => true,
		'wikidatawiki' => true,
	),
	'wmgUseWikibaseClient' => array(
		'default' => true
	),
	'wmgMFQueryPropModules' => array(
		// workaround for T125672
		'default' => array( 'pageprops' ),
		'wikidatawiki' => array( 'pageterms' ),
	),
	'wmgMFSearchAPIParams' => array(
		// workaround for T125672, though also fixes T120197
		'default' => array(
			'ppprop' => 'displaytitle'
		),
		'wikidatawiki' => array(
			'wbptterms' => 'label'

		)
	),
);

$wgLocalDatabases =& $wgConf->getLocalDatabases();

$globals = $wgConf->getAll(
	$wgDBname
);

extract( $globals );
