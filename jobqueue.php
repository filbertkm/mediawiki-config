<?php

$wgJobTypeConf['default'] = array(
    'class'       => 'JobQueueRedis',
    'redisServer' => '127.0.0.1',
    #'redisServer' => '10.64.32.77', # rdb1002 (slave)
    'redisConfig' => array( 'connectTimeout' => 1 ),
	'checkDelay' => true
);

// Note: on server failure, this should be changed to any other redis server
$wgJobQueueAggregator = array(
    'class'       => 'JobQueueAggregatorRedis',
    'redisServer' => '127.0.0.1',
    'redisConfig' => array( 'connectTimeout' => 1 )
);
# vim: set sts=4 sw=4 et :

$wgJobQueueMigrationConfig = array(
    'db'    => array(
        'class' => 'JobQueueDB'
    ),
    'redis' => array(
        'class'       => 'JobQueueRedis',
        'redisServer' => '127.0.0.1',
        'redisConfig' => array( 'connectTimeout' => 1 )
    )
);

/*
$wgJobClasses = array(
    'refreshLinks' => 'RefreshLinksJob',
    'refreshLinks2' => 'RefreshLinksJob2',
    'htmlCacheUpdate' => 'HTMLCacheUpdateJob',
    'html_cache_update' => 'HTMLCacheUpdateJob', // backwards-compatible
    'sendMail' => 'EmaillingJob',
    'enotifNotify' => 'EnotifNotifyJob',
    'fixDoubleRedirect' => 'DoubleRedirectJob',
    'uploadFromUrl' => 'UploadFromUrlJob',
    'AssembleUploadChunks' => 'AssembleUploadChunksJob',
    'PublishStashedFile' => 'PublishStashedFileJob',
    'null' => 'NullJob'
);

$wgJobTypesExcludedFromDefaultQueue = array( 'AssembleUploadChunks', 'PublishStashedFile' );

$wgJobTypeConf = array(
    'default' => array( 'class' => 'JobQueueDB', 'order' => 'random' ),
);

$wgJobQueueAggregator = array(
    'class' => 'JobQueueAggregatorMemc'
);

$wgJobTypeConf['null'] = array(
    'class'       => 'JobQueueRedis',
    'redisServer' => '127.0.0.1:6379',
    'redisConfig' => array( 'connectTimeout' => 1 )
);

$wgJobTypeConf['refreshLinks'] = $wgJobTypeConf['null'];
$wgJobTypeConf['refreshLinks2'] = $wgJobTypeConf['null'];
//$wgJobTypeConf['ChangeNotification'] = $wgJobTypeConf['null'];

$wgJobQueueAggregator = array(
    'class'       => 'JobQueueAggregatorRedis',
    'redisServer' => '127.0.0.1:6379',
    'redisConfig' => array( 'connectTimeout' => 1 )
);
# vim: set sts=4 sw=4 et :

$wgJobQueueMigrationConfig = array(
    'db'    => array(
        'class' => 'JobQueueDB'
    ),
    'redis' => array(
        'class'       => 'JobQueueRedis',
        'redisServer' => '127.0.0.1:6379',
        'redisConfig' => array( 'connectTimeout' => 1 )
    )
);
*/
