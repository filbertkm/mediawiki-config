<?php

$wgConf = new SiteConfiguration;

$wgConf->suffixes = array(
	'wikipedia' => 'wiki',
	'wikidata',
	'wikisource',
	'wikivoyage'
);

$wgConf->wikis = array( 'wikidatawiki', 'testrepo', 'testclient', 'enwikisource' );

$wgConf->settings = array(
	'wgSitename' => array(
		'wikidatawiki' => 'Test Wikidata',
		'testrepo' => 'Test Wikidata',
		'testclient' => 'Test Wikipedia',
		'enwikisource' => 'Wikisource'
	),
	'wmgUseWikibasePropertySuggester' => array(
		'default' => false,
		'testrepo' => true,
	),
);

$wgConf->siteParamsCallback = function( $conf, $wiki ) {
	return array(
		'suffix' => $wiki,
		'lang' => 'en',
		'params' => array(
			'lang' => 'en',
			'site' => $wiki,
			'wiki' => $wiki,
		),
		'tags' => array()
	);
};

$globals = $wgConf->getAll(
		$wgDBname
);

extract( $globals );
