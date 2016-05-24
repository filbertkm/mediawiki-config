<?php

if ( $wmgUseWikibaseRepo || $wmgUseWikibaseClient ) {
	define( 'INSTANCE_OF_PID', 'P4' );
	define( 'IDENTIFIER_PROPERTY_QID', 'Q9791' );
	define( 'STATED_IN_PID', 'P31' );

	require_once "$IP/extensions/Wikidata/Wikidata.php";

	define( 'CONTENT_MODEL_MEDIAINFO', "wikibase-mediainfo" );

	$baseNs = 120;

	// NOTE: do *not* define WB_NS_ITEM and WB_NS_ITEM_TALK when using a core namespace for items!
	define( 'WB_NS_PROPERTY', $baseNs +2 );
	define( 'WB_NS_PROPERTY_TALK', $baseNs +3 );
	define( 'WB_NS_MEDIAINFO', $baseNs + 4 );
	define( 'WB_NS_MEDIAINFO_TALK', $baseNs + 5 );

	// Tell Wikibase which namespace to use for which kind of entity
	$wgWBEntityNamespaces = array(
		'wikibase-item' => NS_MAIN, // CONTENT_MODEL_WIKIBASE_ITEM
		'wikibase-property' => WB_NS_PROPERTY, // CONTENT_MODEL_WIKIBASE_PROPERTY
		'wikibase-mediainfo' => WB_NS_MEDIAINFO // CONTENT_MODEL_WIKIBASE_MEDIAINFO
	);
}

if ( $wmgUseWikibaseRepo ) {
//	wfLoadExtension( 'WikibaseElastic', "$IP/extensions/Wikidata/extensions/WikibaseElastic/extension.json" );

	// No extra namespace for items, using a core namespace for that.
	$wgExtraNamespaces[WB_NS_PROPERTY] = 'Property';
	$wgExtraNamespaces[WB_NS_PROPERTY_TALK] = 'Property_talk';
	$wgExtraNamespaces[WB_NS_MEDIAINFO] = 'MediaInfo';
	$wgExtraNamespaces[WB_NS_MEDIAINFO_TALK] = 'MediaInfo_talk';

	$wgWBRepoSettings['entityNamespaces'] = $wgWBEntityNamespaces;

	$wgGroupPermissions['*']['mediainfo-term'] = true;
	$wgGroupPermissions['*']['mediainfo-merge'] = true;
	$wgGroupPermissions['*']['mediainfo-redirect'] = true;

	$wgAvailableRights[] = 'mediainfo-term';
	$wgAvailableRights[] = 'mediainfo-merge';
	$wgAvailableRights[] = 'mediainfo-redirect';

	$wgGrantPermissions['editpage']['mediainfo-term'] = true;
	$wgGrantPermissions['editpage']['mediainfo-redirect'] = true;
	$wgGrantPermissions['editpage']['mediainfo-merge'] = true;

	$wgWBRepoSettings['clientDbList'] = array( 'enwiki', 'arwiki', 'dewiki', 'eswiki', 'frwiki' );
	$wgWBRepoSettings['subscriptionLookupMode'] = 'subscriptions+sitelinks';

	$wgWBRepoSettings['localClientDatabases'] = array_combine(
		$wgWBRepoSettings['clientDbList'],
		$wgWBRepoSettings['clientDbList']
	);

	$wgWBRepoSettings['siteLinkGroups'] = array(
		'wikipedia',
		'wikibooks',
	   	'wikinews',
		'wikiquote',
		'wikisource',
		'wikivoyage',
		'special'
	);

	$wgWBRepoSettings['specialSiteLinkGroups'] = array(
		'commons',
		'mediawiki',
		'meta',
		'species',
		'wikidata'
	);

	$wgWBRepoSettings['badgeItems'] = array(
		'Q3' => 'wb-badge-goodarticle',
		'Q2' => 'wb-badge-featuredarticle',
		'Q4' => 'wb-badge-recommended',
		'Q270' => 'wb-badge-incomplete',
		'Q271' => 'wb-badge-notproofread',
		'Q272' => 'wb-badge-proofread',
		'Q273' => 'wb-badge-validated'
	);

	$wgWBRepoSettings['formatterUrlProperty'] = 'P367';

	$wgWBRepoSettings['preferredGeoDataProperties'] = array(
		'P50',
		'P444'
	);

	$wgWBRepoSettings['preferredPageImagesProperties'] = array(
		'P113'
	);

	$wgWBRepoSettings['disabledDataTypes'] = array(
//		'external-id'
	);

	$wgWBRepoSettings['conceptBaseUri'] = 'http://www.wikidata.org/entity/';

	$wgWBRepoSettings['statementSections'] = array(
		'item' => array(
			'statements' => null,
			'identifiers' => array(
				'type' => 'dataType',
				'dataTypes' => array( 'string' ),
			)
		)
	);
}

if ( $wmgUseWikibaseClient ) {
	// require_once "$IP/extensions/Wikidata/extensions/WikibaseVE/WikibaseVE.php";

	$wgWBClientSettings['siteGlobalID'] = $wgDBname;

	$wgWBClientSettings['entityNamespaces'] = $wgWBEntityNamespaces;

	$wgWBClientSettings['changesDatabase'] = 'wikidatawiki';
	$wgWBClientSettings['repoDatabase'] = 'wikidatawiki';
	$wgWBClientSettings['repoUrl'] = 'http://wikidatawiki';

	$wgWBClientSettings['specialSiteLinkGroups'] = array(
		'commons',
		'mediawiki',
		'meta',
		'species',
		'wikidata'
	);

	$wgWBClientSettings['siteLinkGroups'] = array(
		'wikipedia',
		'wikibooks',
		'wikinews',
		'wikiquote',
		'wikisource',
		'wikivoyage',
		'special'
	);

	$wgWBClientSettings['badgeClassNames'] = array(
		'Q2' => 'badge-featuredarticle',
		'Q3' => 'badge-goodarticle',
		'Q4' => 'badge-recommended',
		'Q270' => 'badge-problematic',
		'Q271' => 'badge-notproofread',
		'Q272' => 'badge-proofread',
		'Q273' => 'badge-validated'
	);

	$wgWBClientSettings['otherProjectsLinksByDefault'] = true;

	$wgWikimediaBadgesCommonsCategoryProperty = 'P37';
}
