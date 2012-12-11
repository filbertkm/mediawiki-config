<?php

if ( !defined( 'MEDIAWIKI' ) ) {
        die( 'Invalid entry point.' );
}

require_once( "$IP/extensions/ParserFunctions/ParserFunctions.php" );
require_once( "$IP/extensions/Cite/Cite.php" );
require_once( "$IP/extensions/Vector/Vector.php" );

$wgVectorFeatures['collapsibletabs']['user'] = true;

require_once( "$IP/extensions/WikiEditor/WikiEditor.php" );

$wgDefaultUserOptions['usebetatoolbar'] = 1;
$wgDefaultUserOptions['usebetatoolbar-cgd'] = 1;
$wgDefaultUserOptions['wikieditor-preview'] = 1;

// see https://github.com/filbertkm/MultiWiki
require_once( "$IP/extensions/MultiWiki/MultiWiki.php" );

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
	if ( $wmgUseDeployment ) {
		require_once( "$IP/extensions/ULS-1.21/UniversalLanguageSelector.php" );
	} else {
		require_once( "$IP/extensions/UniversalLanguageSelector/UniversalLanguageSelector.php" );
	}
}

if ( $wmgUseWikibaseRepo ) {
    if ( $wmgWikibaseExperimental ) {
        define( 'WB_EXPERIMENTAL_FEATURES', 1 );
    }

	if ( $wmgUseDeployment ) {
		require_once( "$IP/extensions/Diff-1.21/Diff.php" );
		require_once( "$IP/extensions/Wikibase-1.21/lib/WikibaseLib.php" );
		require_once( "$IP/extensions/Wikibase-1.21/repo/Wikibase.php" );
	} else {
		require_once( "$IP/extensions/DataValues/DataValues.php" );
		require_once( "$IP/extensions/Diff/Diff.php" );
		require_once( "$IP/extensions/Wikibase/lib/WikibaseLib.php" );
		require_once( "$IP/extensions/Wikibase/repo/Wikibase.php" );
	}

	// Define custom namespaces. Use these exact constant names.
	$baseNs = 100;

	define( 'WB_NS_PROPERTY', $baseNs + 2 );
	define( 'WB_NS_PROPERTY_TALK', $baseNs + 3 );
	define( 'WB_NS_QUERY', $baseNs + 4 );
	define( 'WB_NS_QUERY_TALK', $baseNs + 5 );

	$wgWBSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_PROPERTY] = WB_NS_PROPERTY;
	$wgWBSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_QUERY] = WB_NS_QUERY;

	$wgContentHandlerUseDB = true;

	$wgWBSettings['apiInDebug'] = false;
	$wgWBSettings['apiInTest'] = false;
	$wgWBSettings['apiWithRights'] = true;
	$wgWBSettings['apiWithTokens'] = false;

	$wgGroupPermissions['wbeditor']['item-set'] = false;

	if ( $wmgWikibaseItemNamespace === 'main' ) {

		// Register extra namespaces.
		$wgExtraNamespaces[WB_NS_PROPERTY] = 'Property';
		$wgExtraNamespaces[WB_NS_PROPERTY_TALK] = 'Property_talk';
		$wgExtraNamespaces[WB_NS_QUERY] = 'Query';
		$wgExtraNamespaces[WB_NS_QUERY_TALK] = 'Query_talk';

		$wgNamespaceAliases['Item'] = NS_MAIN;
		$wgNamespaceAliases['Item_talk'] = NS_TALK;

		// Tell Wikibase which namespace to use for which kind of entity
		$wgWBSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_ITEM] = NS_MAIN;
	} else {
		define( 'WB_NS_ITEM', $baseNs );
		define( 'WB_NS_ITEM_TALK', $baseNs + 1 );

		// Register extra namespaces.
		$wgExtraNamespaces[WB_NS_ITEM] = 'Item';
		$wgExtraNamespaces[WB_NS_ITEM_TALK] = 'Item_talk';

		$wgWBSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_ITEM] = WB_NS_ITEM;

		$wgWBSettings['withoutTermSearchKey'] = true;
	}
}

if ( $wmgUseWikibaseClient ) {
    if ( $wmgWikibaseExperimental ) {
		define( 'WB_EXPERIMENTAL_FEATURES', 1 );
	}

	require_once( "$IP/extensions/DataValues/DataValues.php" );
    require_once( "$IP/extensions/DataValues/ValueParsers/ValueParsers.php" );
	require_once( "$IP/extensions/Diff/Diff.php" );
	require_once( "$IP/extensions/Wikibase/lib/WikibaseLib.php" );
	require_once( "$IP/extensions/Wikibase/client/WikibaseClient.php" );

	$wgWBSettings['repoUrl'] = "//en-wikidata.$wmgSiteDomain";
//	$wgWBSettings['repoScriptPath'] = '';
//	$wgWBSettings['repoArticlePath'] = "/wiki/$1";

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
