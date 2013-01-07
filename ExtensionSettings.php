<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Invalid entry point.' );
}

// extensions enabled by default on all wikis
require_once( "$IP/extensions/ParserFunctions/ParserFunctions.php" );
require_once( "$IP/extensions/Cite/Cite.php" );
require_once( "$IP/extensions/CheckUser/CheckUser.php" );
require_once( "$IP/extensions/cldr/cldr.php" );
require_once( "$IP/extensions/CategoryTree/CategoryTree.php" );
require_once( "$IP/extensions/SiteMatrix/SiteMatrix.php" );
require_once( "$IP/extensions/Vector/Vector.php" );

$wgVectorFeatures['collapsibletabs']['user'] = true;

require_once( "$IP/extensions/WikiEditor/WikiEditor.php" );

$wgDefaultUserOptions['usebetatoolbar'] = 1;
$wgDefaultUserOptions['usebetatoolbar-cgd'] = 1;
$wgDefaultUserOptions['wikieditor-preview'] = 1;

if ( $wmgUseMultiWiki ) {
	// see https://github.com/filbertkm/MultiWiki
	require_once( "$IP/extensions/MultiWiki/MultiWiki.php" );
}

if ( $wmgUseAbuseFilter ) {
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

}

if ( $wmgUseCentralAuth ) {
	require_once( "$IP/extensions/CentralAuth/CentralAuth.php" );

	$wgCentralAuthCookies = true;
	$wgCentralAuthAutoNew = true;

	$wgHooks['CentralAuthWikiList'][] = 'wmfCentralAuthWikiList';
	function wmfCentralAuthWikiList( &$list ) {
		global $wgLocalDatabases;
		$list = $wgLocalDatabases;
		return true;
	}

	$wgCentralAuthAutoLoginWikis = array(
		"en-wiki.$wmgSiteDomain" => 'enwiki',
		"en-wikidata.$wmgSiteDomain"  => 'enwikidata',
	);
}

if ( $wmgUseUniversalLanguageSelector ) {
	require_once( "$IP/extensions/UniversalLanguageSelector/UniversalLanguageSelector.php" );
}

if ( $wmgUseWikibaseRepo && $wmgUseWikibaseClient ) {
	die( "<strong>Error</strong>: Wikibase Repo and Client should not be enabled on the same wiki!" );
}

if ( $wmgUseWikibaseRepo || $wmgUseWikibaseClient ) {

	require_once( "$IP/extensions/DataValues/DataValues.php" );
	require_once( "$IP/extensions/Diff/Diff.php" );
	require_once( "$IP/extensions/Wikibase/lib/WikibaseLib.php" );

	function setWikibaseNamespaces( $main = false ) {
		global $wgWBSettings, $wgWBNamespaces, $wgNamespaceAliases;

		// Define custom namespaces. Use these exact constant names.
		$baseNs = 100;

		if ( $main ) {
			$wgNamespaceAliases['Item'] = NS_MAIN;
			$wgNamespaceAliases['Item_talk'] = NS_TALK;

			// Tell Wikibase which namespace to use for which kind of entity
			$wgWBSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_ITEM] = NS_MAIN;
		} else {
			// default to items in Item namespace
			define( 'WB_NS_ITEM', $baseNs );
			define( 'WB_NS_ITEM_TALK', $baseNs + 1 );

			// Register extra namespaces.
			$wgWBNamespaces[WB_NS_ITEM] = 'Item';
			$wgWBNamespaces[WB_NS_ITEM_TALK] = 'Item_talk';

			$wgWBSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_ITEM] = WB_NS_ITEM;
		}

		define( 'WB_NS_PROPERTY', $baseNs + 2 );
		define( 'WB_NS_PROPERTY_TALK', $baseNs + 3 );
		define( 'WB_NS_QUERY', $baseNs + 4 );
		define( 'WB_NS_QUERY_TALK', $baseNs + 5 );

		$wgWBSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_PROPERTY] = WB_NS_PROPERTY;
		$wgWBSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_QUERY] = WB_NS_QUERY;

		// Register extra namespaces.
		$wgWBNamespaces[WB_NS_PROPERTY] = 'Property';
		$wgWBNamespaces[WB_NS_PROPERTY_TALK] = 'Property_talk';
		$wgWBNamespaces[WB_NS_QUERY] = 'Query';
		$wgWBNamespaces[WB_NS_QUERY_TALK] = 'Query_talk';
	}

	setWikibaseNamespaces( $wmgWikibaseItemsInMainNS );

	if ( $wmgWikibaseExperimental ) {
		define( 'WB_EXPERIMENTAL_FEATURES', 1 );
	}

	if ( $wmgUseWikibaseRepo ) {
		require_once( "$IP/extensions/Wikibase/repo/Wikibase.php" );

		$wgExtraNamespaces = $wgWBNamespaces + $wgExtraNamespaces;

		$wgContentHandlerUseDB = true;

		$wgWBSettings['withoutTermSearchKey'] = true;

		$wgWBSettings['apiInDebug'] = false;
		$wgWBSettings['apiInTest'] = false;
		$wgWBSettings['apiWithRights'] = true;
		$wgWBSettings['apiWithTokens'] = false;

		$wgGroupPermissions['wbeditor']['item-set'] = false;
	}

	if ( $wmgUseWikibaseClient ) {
		require_once( "$IP/extensions/Wikibase/client/WikibaseClient.php" );

		$wgWBSettings['repoUrl'] = "//en-wikidata.$wmgSiteDomain";

		// The global site ID by which this wiki is known on the repo.
		$wgWBSettings['siteGlobalID'] = $wgDBname;

		// Database name of the repository, for use by the pollForChanges script.
		// This requires the given database name to be known to LBFactory, see
		// $wgLBFactoryConf below.
		$wgWBSettings['changesDatabase'] = "enwikidata";
		$wgWBSettings['repoDatabase'] = "enwikidata";

		if ( $wmgWikibaseItemNamespace === 'main' ) {
			$wgWBSettings['repoNamespaces'] = array(
			//  'wikibase-item' => '',
				'wikibase-property' => 'Property'
			);
		} else {
			$wgWBSettings['repoNamespaces'] = array(
				'wikibase-item' => 'Item',
				'wikibase-property' => 'Property'
			);
		}
	}
}
