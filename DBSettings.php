<?php

if ( !defined( 'MEDIAWIKI' ) ) {
		die( 'Illegal entry point' );
}

$wgDBtype           = "mysql";

# MySQL specific settings
$wgDBprefix         = "";

# Experimental charset support for MySQL 5.0.
$wgDBmysql5 = false;

$wgDBTableOptions   = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

function setDbSection( $dblist, $value ) {
	$newDbList = array();

	foreach( $dblist as $item ) {
		$newDbList[$item] = $value;
	}

	return $newDbList;
}

$wikilist = array_map( 'trim', file( "/var/www/common/wikipedia.dblist" ) );

$dbSections = array_merge(
	array( 'enwikidata' => 's2', 'testwikidata' => 's2', 'centralauth' => 's2' ),
	array()
//	setDbSection( $wikilist, 'DEFAULT' )
);

$wgLBFactoryConf = array(
	'class' => 'LBFactory_Multi',

	// Connect to all databases using the same credentials.
	'serverTemplate' => array(
		'dbname'	  => $wgDBname,
		'user'	  => $wgDBuser,
		'password'  => $wgDBpassword,
		'type'	  => 'mysql',
		'flags'	=> DBO_DEFAULT | DBO_DEBUG,
	),

	// Configure two sections, one for the repo and one for the client.
	// Each section contains only one server.
	'sectionLoads' => array(
		'DEFAULT' => array(
			'localhost' => 1,
		),
		's2' => array(
			'linode2' => 1,
		),
	),

	// Map the wiki database names to sections. Database names must be unique,
	// i.e. may not exist in more than one section.
	'sectionsByDB' => $dbSections,

	// Map host names to IP addresses to bypass DNS.
	//
	// NOTE: Even if all sections run on the same MySQL server (typical for a test setup),
	// they must use different IP addresses, and MySQL must listen on all of them.
	// The easiest way to do this is to set bind-address = 0.0.0.0 in the MySQL
	// configuration. Beware that this makes MySQL listen on you ethernet port too.
	// Safer alternatives include setting up mysql-proxy or mysqld_multi.
	'hostsByName' => array(
		'localhost' => '127.0.0.1:3306',
		'linode2' => $wmgDBserver2,
	),

	// Set up as fake master, because there are no slaves.
	'masterTemplateOverrides' => array( 'fakeMaster' => true ),

	'externalLoads' => array(
		'cluster25' => array(
			'127.0.0.1:3306' => 1,
		),
	),

	'templateOverridesByCluster' => array(
		'cluster25' => array( 'blobs table' => 'blobs_cluster25' ),
	),
);

$wgDefaultExternalStore = 'DB://cluster25';
