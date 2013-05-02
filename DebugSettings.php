<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'horrible death!' );
}

# Debug settings
//$wgDebugToolbar = true;
$wgShowExceptionDetails = true;
//$wgShowSQLErrors        = true;
$wgEnableJavaScriptTest = true;

$wgResourceLoaderDebug = true;

$wgProfiler['class'] = 'Profiler';

// Only record profiling info for pages that took longer than this
$wgProfileLimit = 0.0;
// Don't put non-profiling info into log file
$wgProfileOnly = false;
// Log sums from profiling into "profiling" table in db
$wgProfileToDatabase = true;
// If true, print a raw call tree instead of per-function report
$wgProfileCallTree = false;
// Should application server host be put into profiling table
$wgProfilePerHost = false;

// Detects non-matching wfProfileIn/wfProfileOut calls
$wgDebugProfiling = true;
// Output debug message on every wfProfileIn/wfProfileOut
$wgDebugFunctionEntry = 0;
// Lots of debugging output from SquidUpdate.php
$wgDebugSquid = false;

$wgEnableProfileInfo = true;

$wgDebugLogGroups = array(
	'dispatcher' => '/var/log/wikibase/dispatcher.log',
	'wikidata'     => '/var/log/mediawiki/wikidata.log',
	'Wikibase\ChangeNotificationJob' => '/var/log/mediawiki/jobrunner.log',
//	'Wikibase\LangLinkHandler' => '/var/log/wikibase/langlinkhandler.log'
	'Wikibase\ChangeHandler' => '/var/log/mediawiki/changehandler.log'
);

//$wgDebugLogFile = '/var/log/mediawiki/mediawiki.log';
