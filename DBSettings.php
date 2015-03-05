<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Illegal entry point' );
}

$wgDBtype		   = "mysql";
#$wgDBserver		 = "localhost";
$wgDBuser		   = "mwuser";
$wgDBpassword	   = "password";

$wgDBprefix		 = "";

$wgDBTableOptions   = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

$wgDBmysql5 = false;

$wgLBFactoryConf = array(
	// In order to seamlessly access a remote wiki, as the pollForChanges script needs to do,
	// LBFactory_Multi must be used.
	'class' => 'LBFactoryMulti',

	// Connect to all databases using the same credentials.
	'serverTemplate' => array(
		'dbname'	  => $wgDBname,
		'user'		=> $wgDBuser,
		'password'	=> $wgDBpassword,
		'type'		=> 'mysql',
		'flags'	   => DBO_DEFAULT | DBO_DEBUG,
	),

	// Configure two sections, one for the repo and one for the client.
	// Each section contains only one server.
	'sectionLoads' => array(
		'DEFAULT' => array(
			'localhost' => 1
		),
		's1' => array(
			'localhost' => 1
		),
		's2' => array(
			'localhost' => 1
		)
	),

	// Map the wiki database names to sections. Database names must be unique,
	// i.e. may not exist in more than one section.
	'sectionsByDB' => array(
		'testrepo' => 's2',
		'testclient' => 's1'
	),

	// Map host names to IP addresses to bypass DNS.
	//
	// NOTE: Even if all sections run on the same MySQL server (typical for a test setup),
	// they must use different IP addresses, and MySQL must listen on all of them.
	// The easiest way to do this is to set bind-address = 0.0.0.0 in the MySQL
	// configuration. Beware that this makes MySQL listen on you ethernet port too.
	// Safer alternatives include setting up mysql-proxy or mysqld_multi.
	'hostsByName' => array(
		'localhost' => '127.0.0.1',
	),

	// Set up as fake master, because there are no slaves.
	'masterTemplateOverrides' => array( 'fakeMaster' => true ),
);

$wgWBDumpDbConfig = array(
	'dbname' => 'wikidata',
	'user' => 'katie',
	'password' => '',
	'host' => 'localhost',
	'driver' => 'pdo_pgsql',
);
