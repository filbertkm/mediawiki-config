<?php

$handlers = array(
	'null' => array(
		'class' => '\\Monolog\\Handler\\NullHandler'
	),
	'console' => array(
		'class' => '\\Monolog\\Handler\\StreamHandler',
		'args' => array( 'php://stdout' ),
		'formatter' => 'line'
	)
);

$loggers = array(
	'@default' => array(
		'handlers' => array( 'null' )
	),
	'console' => array(
		'handlers' => array( 'console' )
	),
);

foreach( $wgDebugLogGroups as $group => $file ) {
	$handlers[$group] = array(
		'class' => '\\Monolog\\Handler\\StreamHandler',
		'args' => array( $file ),
		'formatter' => 'line'
	);

	$loggers[$group] = array(
		'handlers' => array( $group )
	);
}

$wgMWLoggerDefaultSpi = array(
	'class' => '\\MediaWiki\\Logger\\MonologSpi',
	'args' => array( array(
		'loggers' => $loggers,
		'processors' => array(
			'wiki' => array(
				'class' => '\\MediaWiki\\Logger\\Monolog\\WikiProcessor',
			),
			'psr' => array(
				'class' => '\\Monolog\\Processor\\PsrLogMessageProcessor',
			),
			'pid' => array(
				'class' => '\\Monolog\\Processor\\ProcessIdProcessor',
			),
			'uid' => array(
				'class' => '\\Monolog\\Processor\\UidProcessor',
			),
			'web' => array(
				'class' => '\\Monolog\\Processor\\WebProcessor',
			),
		),
		'handlers' => $handlers,
		'formatters' => array(
			'line' => array(
				'class' => '\\Monolog\\Formatter\\LineFormatter',
				'args' => array(
					null,
					null,
					true,
					false,
					true
				)
			)
		)
	) )
);
