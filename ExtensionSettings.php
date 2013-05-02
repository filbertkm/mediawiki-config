<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Invalid entry point.' );
}

// extensions enabled by default on all wikis
require_once( "$IP/extensions/ParserFunctions/ParserFunctions.php" );
require_once( "$IP/extensions/Cite/Cite.php" );
require_once( "$IP/extensions/CheckUser/CheckUser.php" );
require_once( "$IP/extensions/cldr/cldr.php" );
//require_once( "$IP/extensions/CategoryTree/CategoryTree.php" );
require_once( "$IP/extensions/SiteMatrix/SiteMatrix.php" );
//require_once( "$IP/extensions/Vector/Vector.php" );
//require_once( "$IP/extensions/MobileFrontend/MobileFrontend.php" );

$wgVectorFeatures['collapsibletabs']['user'] = true;

$wgVectorFeatures['simplesearch'] = array( 'global' => true, 'user' => false );
$wgVectorFeatures['expandablesearch'] = array( 'global' => false, 'user' => false );
$wgVectorUseSimpleSearch = true;

//require_once( "$IP/extensions/WikiEditor/WikiEditor.php" );

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
//	require_once( "$IP/extensions/CentralAuth/CentralAuth.php" );

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

if ( $wmgUseFlaggedRevs ) {
	require_once( "$IP/extensions/FlaggedRevs/FlaggedRevs.php" );

	$wgFlaggedRevTags = array(
		'accuracy' => array( 'levels' => 2, 'quality' => 2, 'pristine' => 4 ),
	);
	$wgFlagRestrictions = array(
		'accuracy' => array( 'review' => 1, 'autoreview' => 1 ),
	);
	$wgGroupPermissions['autoconfirmed']['movestable'] = true; // bug 14166

	$wmfStandardAutoPromote = $wgFlaggedRevsAutopromote; // flaggedrevs defaults
	$wgFlaggedRevsAutopromote = false;

	$wgGroupPermissions['sysop']['stablesettings'] = false; // -aaron 3/20/10

	$wgEnableValidationStatisticsUpdates = false;

	# Rights for Bureaucrats (b/c)
/*	if ( !in_array( 'reviewer', $wgAddGroups['bureaucrat'] ) ) {
		$wgAddGroups['bureaucrat'][] = 'reviewer'; // promote to full reviewers
	}
	if ( !in_array( 'reviewer', $wgRemoveGroups['bureaucrat'] ) ) {
		$wgRemoveGroups['bureaucrat'][] = 'reviewer'; // demote from full reviewers
	}
*/
	$wgFlaggedRevsNamespaces = array( NS_MAIN );
}

if ( $wmgUseScribunto ) {
	require_once( "$IP/extensions/Scribunto/Scribunto.php" );
	$wgScribuntoDefaultEngine = 'luastandalone';
}

if ( $wmgUseVisualEditor ) {
	require_once("$IP/extensions/VisualEditor/VisualEditor.php");

	// Create VisualEditor namespace
	define( 'NS_VISUALEDITOR', 2500 );
	define( 'NS_VISUALEDITOR_TALK', 2501 );
	$wgExtraNamespaces[NS_VISUALEDITOR] = 'VisualEditor';
	$wgExtraNamespaces[NS_VISUALEDITOR_TALK] = 'VisualEditor_talk';

	// Allow using VisualEditor in the main namespace only (default)
	$wgVisualEditorNamespaces = array( NS_MAIN );

	// Enable by default for everybody
	$wgDefaultUserOptions['visualeditor-enable'] = 1;

	// Don't allow users to disable it
	$wgHiddenPrefs[] = 'visualeditor-enable';

	$wgVisualEditorParsoidURL = 'http://127.0.0.1:8000/';
	$wgVisualEditorParsoidPrefix = 'en-wiki';
}

if ( $wmgUseUniversalLanguageSelector ) {
	require_once( "$IP/extensions/UniversalLanguageSelector/UniversalLanguageSelector.php" );
	$wgULSGeoService = true;
	$wgULSEnableAnon = true;
}

if ( $wmgUseUploadWizard ) {
	require_once( "$IP/extensions/UploadWizard/UploadWizard.php" );
}

if ( $wmgUseWikibaseRepo && $wmgUseWikibaseClient ) {
	die( "<strong>Error</strong>: Wikibase Repo and Client should not be enabled on the same wiki!" );
}

if ( $wmgUseWikibaseRepo || $wmgUseWikibaseClient ) {

	require_once( "$IP/extensions/DataValues/DataValues.php" );
	require_once( "$IP/extensions/Diff/Diff.php" );
	require_once( "$IP/extensions/Wikibase/lib/WikibaseLib.php" );

	function setWikibaseNamespaces( $main = false ) {
		global $wmgWikibaseItemsInMainNS, $wgWBRepoSettings, $wgWBSettings,
			$wgWBNamespaces, $wgNamespaceAliases;

		// Define custom namespaces. Use these exact constant names.
		$baseNs = 100;

		if ( $wmgWikibaseItemsInMainNS ) {
			$wgNamespaceAliases['Item'] = NS_MAIN;
			$wgNamespaceAliases['Item_talk'] = NS_TALK;

			// Tell Wikibase which namespace to use for which kind of entity
			$wgWBRepoSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_ITEM] = NS_MAIN;
		} else {
			// default to items in Item namespace
			define( 'WB_NS_ITEM', $baseNs );
			define( 'WB_NS_ITEM_TALK', $baseNs + 1 );

			// Register extra namespaces.
			$wgWBNamespaces[WB_NS_ITEM] = 'Item';
			$wgWBNamespaces[WB_NS_ITEM_TALK] = 'Item_talk';

			$wgWBRepoSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_ITEM] = WB_NS_ITEM;
		}

		define( 'WB_NS_PROPERTY', $baseNs + 2 );
		define( 'WB_NS_PROPERTY_TALK', $baseNs + 3 );
		define( 'WB_NS_QUERY', $baseNs + 4 );
		define( 'WB_NS_QUERY_TALK', $baseNs + 5 );

		$wgWBRepoSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_PROPERTY] = WB_NS_PROPERTY;
	//	$wgWBSettings['entityNamespaces'][CONTENT_MODEL_WIKIBASE_QUERY] = WB_NS_QUERY;

		// Register extra namespaces.
		$wgWBNamespaces[WB_NS_PROPERTY] = 'Property';
		$wgWBNamespaces[WB_NS_PROPERTY_TALK] = 'Property_talk';
	//	$wgWBNamespaces[WB_NS_QUERY] = 'Query';
	//	$wgWBNamespaces[WB_NS_QUERY_TALK] = 'Query_talk';
	}

	$wgWBClientDbList = array_merge(
		array_map( 'trim', file( getRealmSpecificFilename( "$IP/../wikipedia.dblist" ) ) )
	);

//	$wgWBClientDbList = array( 'enwiki', 'hewiki', 'dewiki', 'eswiki', 'frwiki', 'itwiki' );

	$wgWBSettings['localClientDatabases'] = array_combine( $wgWBClientDbList, $wgWBClientDbList );

//	setWikibaseNamespaces( $wmgWikibaseItemsInMainNS );

	if ( $wmgWikibaseExperimental ) {
		define( 'WB_EXPERIMENTAL_FEATURES', 1 );
	}

	if ( $wmgUseWikibaseRepo ) {
		require_once( "$IP/extensions/Wikibase/repo/Wikibase.php" );

		setWikibaseNamespaces( $wmgWikibaseItemsInMainNS );

		$wgExtraNamespaces = $wgWBNamespaces + $wgExtraNamespaces;

		$wgContentHandlerUseDB = true;

	//	$wgWBRepoSettings['withoutTermSearchKey'] = true;

		$wgWBSettings['disabledSpecialPages'] = array(
			'Mostinterwikis',
			'Withoutinterwiki'
		);

		$wgWBSettings['dataTypes'] = array(
			'wikibase-item',
			'commonsMedia',
			'string'
		);

		$wgWBRepoSettings['apiInDebug'] = false;
		$wgWBRepoSettings['apiInTest'] = false;
		$wgWBRepoSettings['apiWithRights'] = true;
		$wgWBRepoSettings['apiWithTokens'] = false;

		$wgGroupPermissions['wbeditor']['item-set'] = true;
	}

	if ( $wmgUseWikibaseClient ) {
		require_once( "$IP/extensions/ExternalChanges/ExternalChanges.php" );
		require_once( "$IP/extensions/Wikibase/client/WikibaseClient.php" );

		$wgWBSettings['repoUrl'] = "http://en-wikidata.$wmgSiteDomain";

		// The global site ID by which this wiki is known on the repo.
		$wgWBSettings['siteGlobalID'] = $wgDBname;

		// Database name of the repository, for use by the pollForChanges script.
		// This requires the given database name to be known to LBFactory, see
		// $wgLBFactoryConf below.
		$wgWBSettings['changesDatabase'] = "enwikidata";
		$wgWBSettings['repoDatabase'] = "enwikidata";

		$wgWBClientSettings['enableSiteLinkWidget'] = true;
		$wgWBClientSettings['allowDataTransclusion'] = true;

		if ( $wmgWikibaseItemsInMainNS ) {
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

		$wgHooks['SetupAfterCache'][] = 'wmfWBClientExcludeNS';

		function wmfWBClientExcludeNS() {
			global $wgWBClientSettings;

			$wgWBClientSettings['excludeNamespaces'] = array_merge(
				MWNamespace::getTalkNamespaces(),
				array( NS_USER )
			);

			return true;
		};

		foreach( $wmgWikibaseClientSettings as $setting => $value ) {
			$wgWBSettings[$setting] = $value;
		}
	}
}
