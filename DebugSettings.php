<?php

$wgShowExceptionDetails = true;
$wgShowDBErrorBacktrace = true;
$wgEnableJavaScriptTest = true;
$wgDebugToolbar = true;

$wgDebugLogGroups = array(
	'wikidata' => '/var/www/wiki/log/wikidata.log',
	'exception' => '/var/www/wiki/log/exception.log',
	'error' => '/var/www/wiki/log/error.log',
	'wfDebug' => '/var/www/wiki/log/debug.log'
);

function logBacktrace() {
	wfDebugLog( 'wikidata', __CLASS__ . ':' . __METHOD__ );
	ob_start();
	var_dump( debug_backtrace() );
	$backtrace = ob_get_clean();
	wfDebugLog( 'wikidata', $backtrace );
}
