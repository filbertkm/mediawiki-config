<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Invalid entry point.' );
}

$wgEnableWikibaseRepo = false;
$wgEnableWikibaseClient = false;

$wgExtensionEntryPointListFiles[] = "$IP/extensions/WikidataBuild/extension-list-wikidata";
#require_once "$IP/extensions/WikidataBuild/Wikidata.localisation.php";

if ( $wmgUseWikibaseRepo || $wmgUseWikibaseClient ) {
	if ( $wmgUseWikibaseExperimental ) {
		define( 'WB_EXPERIMENTAL_FEATURES', 1 );
	}

	if ( $wmgUseWikibaseBuild ) {
		require_once "$IP/extensions/WikidataBuild/Wikidata.php";
		//require_once "$IP/extensions/Wikidata/Wikidata.php";
		require_once "$IP/extensions/WikibaseSystemTests/WikibaseSystemTests.php";
	}
}

if ( $wmgUseWikibaseRepo ) {
	if ( !$wmgUseWikibaseBuild ) {
		require_once ( "$IP/extensions/Wikibase/repo/Wikibase.php" );
	}

	//require_once( "$IP/extensions/WikibaseMobile/WikibaseMobile.php" );
	//require_once "$IP/extensions/WikidataBuild/extensions/WikibaseMwElastic/WikibaseElastic.php";
	require_once "$IP/extensions/GlobalUsage/GlobalUsage.php";

	if ( $wmgSingleInstance ) {
		$baseNs = 120;

		// Define custom namespaces. Use these exact constant names.
		define( 'WB_NS_ITEM', $baseNs );
		define( 'WB_NS_ITEM_TALK', $baseNs + 1 );
		define( 'WB_NS_PROPERTY', $baseNs + 2 );
		define( 'WB_NS_PROPERTY_TALK', $baseNs + 3 );

		// Register extra namespaces.
		$wgExtraNamespaces[WB_NS_ITEM] = 'Item';
		$wgExtraNamespaces[WB_NS_ITEM_TALK] = 'Item_talk';
		$wgExtraNamespaces[WB_NS_PROPERTY] = 'Property';
		$wgExtraNamespaces[WB_NS_PROPERTY_TALK] = 'Property_talk';

		// Tell Wikibase which namespace to use for which kind of entity
		$wgWBRepoSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_ITEM] = WB_NS_ITEM;
		$wgWBRepoSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_PROPERTY] = WB_NS_PROPERTY;

		// NOTE: no need to set up $wgNamespaceContentModels, Wikibase will do that automatically based on $wgWBRepoSettings

		// Tell MediaWIki to search the item namespace
		$wgNamespacesToBeSearchedDefault = array(
			WB_NS_ITEM => 1,
			WB_NS_PROPERTY => 1
		);
	} else {
		// Define custom namespaces. Use these exact constant names.
		$baseNs = 100;

		$wgNamespaceAliases['Item'] = NS_MAIN;
		$wgNamespaceAliases['Item_talk'] = NS_TALK;

		// Tell Wikibase which namespace to use for which kind of entity
		$wgWBRepoSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_ITEM] = NS_MAIN;

		define( 'WB_NS_PROPERTY', $baseNs + 2 );
		define( 'WB_NS_PROPERTY_TALK', $baseNs + 3 );

		$wgWBRepoSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_PROPERTY] = WB_NS_PROPERTY;

		// Register extra namespaces.
		$wgWBNamespaces[WB_NS_PROPERTY] = 'Property';
		$wgWBNamespaces[WB_NS_PROPERTY_TALK] = 'Property_talk';

		global $wgExtraNamespaces;
		$wgExtraNamespaces = $wgWBNamespaces + $wgExtraNamespaces;
	}

	// Make sure we use the same keys on repo and clients, so we can share cached objects.
	$wgWBRepoSettings['sharedCacheKeyPrefix'] = 'wikidatawiki/master2';
	$wgWBRepoSettings['sharedCacheDuration'] = 60 * 60 * 24;

	$wgContentHandlerUseDB = true;

	if ( $wgDBname === 'wikidatawiki' ) {
		$wgWBClientDbList = array( 'enwiki', 'wikidatawiki' );
	} else {
		$wgWBClientDbList = array( 'testclient' );
	}

	$wgWBRepoSettings['localClientDatabases'] = array_combine( $wgWBClientDbList, $wgWBClientDbList );

	$wgWBRepoSettings['badgeItems'] = array(
		'Q337' => 'wb-badge-goodarticle',
		'Q338' => 'wb-badge-featuredarticle'
	);

	$wgWBRepoSettings['siteLinkGroups'] = array(
		'wikipedia',
		'wikibooks',
		'wikinews',
		'wikiquote',
		'wikivoyage',
		'wikisource',
		'special'
	);

	$wgWBRepoSettings['specialSiteLinkGroups'] = array( 'commons', 'wikidata' );

	$wgWBRepoSettings['datalicensetext'] = 'CC-0';
	$wgWBRepoSettings['datalicenseurl'] = 'https://creativecommons.org';

	$wgWBRepoSettings['apiInDebug'] = false;
	$wgWBRepoSettings['apiInTest'] = false;
	$wgWBRepoSettings['apiWithRights'] = true;
	$wgWBRepoSettings['apiWithTokens'] = true;

/*
	$wgGroupPermissions['propertycreator'] = array(
		'property-create' => true
	);

	$wgGroupPermissions['*']['property-create'] = false;
*/
}

if ( $wmgUseWikibaseClient ) {
	if ( !$wmgUseWikibaseBuild ) {
		require_once "$IP/extensions/Wikibase/client/WikibaseClient.php";
	}

	require_once "$IP/extensions/WikibaseGraph/WikibaseGraph.php";

	$wgWBClientSettings['otherProjectsLinksBeta'] = true;
	//$wgWBClientSettings['otherProjectsLinksByDefault'] = true;

	$wgWBClientSettings['siteLinkGroups'] = array(
		'wikipedia',
		'wikiquote',
		'wikivoyage',
		'wikisource',
		'special'
	);

	$wgWBClientSettings['specialSiteLinkGroups'] = array( 'commons' );

	$wgWBClientSettings['siteGroup'] = 'wikipedia';
	#$wgWBClientSettings['languageLinkSiteGroup'] = 'wikipedia';

	$wgWBClientSettings['badgeClassNames'] = array(
		'Q337' => 'badge-featuredarticle'
	);

	if ( !$wmgUseWikibaseRepo ) {
		$wgWBClientSettings['repoUrl'] = $wgDBname === 'enwiki' ? 'http://wikidata-all' : 'http://wikidata-repo';
		$wgWBClientSettings['repoScriptPath'] = $wgScriptPath;
		$wgWBClientSettings['repoArticlePath'] = $wgArticlePath;
		$wgWBClientSettings['repoSiteName'] = 'wikibase-repo-name';

		// The global site ID by which this wiki is known on the repo.
		$wgWBClientSettings['siteGlobalID'] = "enwiki";

		$wgExtraNamespaces[130] = 'Author';
		$wgExtraNamespaces[131] = 'Author_talk';

		$wgWBClientSettings['namespaces'] = array( NS_MAIN );

		// Database name of the repository, for use by the pollForChanges script.
		// This requires the given database name to be known to LBFactory, see
		// $wgLBFactoryConf below.
		if ( $wgDBname === 'enwiki' ) {
			$wgWBClientSettings['changesDatabase'] = 'wikidatawiki';
			$wgWBClientSettings['repoDatabase'] = 'wikidatawiki';
		} else {
			$wgWBClientSettings['changesDatabase'] = 'testrepo';
			$wgWBClientSettings['repoDatabase'] = 'testrepo';
		}
	}

	$wgWBClientSettings['allowArbitraryDataAccess'] = true;
	$wgWBClientSettings['useLegacyUsageIndex'] = true;
	$wgWBClientSettings['useLegacyChangesSubscription'] = true;

	if ( $wgDBname === 'testrepo' || $wgDBname === 'wikidatawiki' ) {
		$wgWBClientSettings['siteGlobalID'] = "wikidatawiki";

		$wgWBClientSettings['namespaces'] = array(
			NS_PROJECT,
			NS_TEMPLATE,
			NS_HELP
		);

		$wgWBClientSettings['languageLinkSiteGroup'] = 'wikipedia';

		$wgWBClientSettings['propagateChangesToRepo'] = false;
		$wgWBClientSettings['injectRecentChanges'] = false;
		$wgWBClientSettings['showExternalRecentChanges'] = false;
	}

}
