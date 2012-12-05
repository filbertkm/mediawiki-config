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
        'wikidata'     => '/var/www/' . MW_SITE_DOMAIN . '/wikimedia-dev/logs/wikidata.log',
);
