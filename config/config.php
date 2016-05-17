<?php
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );
return new \Phalcon\Config(array(
    'database' => array(
        'adapter'  => 'Mysql',
        'host'     => '127.0.0.1',
        'username' => 'root',
        'password' => 'mysql',
        'dbname'   => 'pfcms',
        'charset'  => 'utf8',
        'prefix'   => 'pfc_',
    ),    
	'application' => array(
        'pluginsDir'     => APP_ROOT . 'plugins/',
        'libraryDir'     => APP_ROOT . 'libraries/',
        'cacheDir'       => APP_ROOT . 'cache/',
        'enumsDir'		 => APP_ROOT . 'enums/',
        'logs' 			 => APP_ROOT . 'logs/',
        'listenersDir'	 => APP_ROOT . 'listeners/',
        'baseUri'        => '/',
    ),
	'cache' => array(
        'htmlCacheTime'    => 300,
        'fileCacheTime'    => 86400,
        'memCacheTime'     => 14400,
        'apcCacheTime'     => 7200,
        'xcacheTime'       => 3600,
        'eacceleratorTime' => 3600,
        'inMemCacheTime'   => 1800,
        'mongoTime'        => 7200,
        'redisTime'        => 7200,
        'metaCacheTime'    => 60
    ),
    'cacheAdapter'	 =>  'memcache',
	'memcache'	     => array(
		'host'     => '127.0.0.1',
		'port'       => '11211'
	),
	'mongodb'	     => array(
		'server'     => "mongodb://localhost", 
		'db'         => 'caches',
		'collection' => 'images',
	),
    'admin_regenrator_time_interval' => 3 * 60,
    'home_regenarater_time_interval' => 3 * 60,
    'sensitive_default_replace'		 => '**',
    )
);