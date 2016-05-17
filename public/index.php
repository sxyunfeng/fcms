<?php

error_reporting( E_ALL );
ini_set( 'display_errors', '1' );

//将出错信息输出到一个文本文件
ini_set( 'error_log', dirname( __DIR__ ) . '/logs/php_error_log.txt' );

//定义常量 APP_ROOT web root
define( 'APP_ROOT', dirname( __DIR__ ) . '/' );
define( 'APP_MODULE', dirname( __DIR__ ) . '/apps/' );

use
Phalcon\Mvc\Dispatcher as MvcDispatcher,
Phalcon\Events\Manager as EventsManager,
Phalcon\Mvc\Dispatcher\Exception as DispatchException;
		
$di = new \Phalcon\DI\FactoryDefault();

//Registering config
$di->set( 'config', require APP_ROOT . 'config/config.php' );
$di->set( 'cmscfg', require APP_MODULE . 'cms/config/config.php' );

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */

$loader->registerNamespaces( array(
	'libraries' 	=> APP_ROOT . 'libraries/',
	'utils'		=> APP_ROOT . 'apps/utils/',
	'api'		=> APP_ROOT . 'apps/api/',
	'enums'		=> APP_ROOT . 'enums/',
	'listeners'	=> APP_ROOT . 'listeners/',
    'vendors' => APP_ROOT . 'vendors/'
));

$loader->register();


$app = new \Phalcon\Mvc\Application($di);

require APP_ROOT . 'config/services.php';//加载公共services

// Register the installed modules
$app->registerModules( array(
        
//      'frontend' => 
// 		array(
//             'className' => 'Mp\Frontend\Module',
//             'path' => APP_ROOT . 'apps/frontend/Module.php'
//         ),
        'admin' => 
		array(
            'className' => 'apps\admin\Module',
            'path' => APP_ROOT . 'apps/admin/Module.php'
        ),
		'sys' =>
		array(
    		'className' => 'Mp\sys\Module',
    		'path' => APP_ROOT . 'apps/sys/Module.php'
		),
		'pri' =>
		array(
			'className' => 'Mp\pri\Module',
			'path' => APP_ROOT . 'apps/pri/Module.php'
		),
		'appmgr' =>
		array(
			'className' => 'Mp\appmgr\Module',
			'path' => APP_ROOT . 'apps/appmgr/Module.php'
		),
		'home' =>
		array(
			'className' => 'apps\home\Module',
			'path' => APP_ROOT . 'apps/home/Module.php'
		),
        'common' => 
		array(
            'className' => 'apps\common\Module',
            'path' => APP_ROOT . 'apps/common/Module.php'
        ),
        'oa' => 
		array(
            'className' => 'apps\oa\Module',
            'path' => APP_ROOT . 'apps/oa/Module.php'
        ),
        'cms' => 
        array(
    		'className' => 'apps\cms\Module',
    		'path' => APP_ROOT . 'apps/cms/Module.php'
        ),
        'stock' => 
		array(
            'className' => 'apps\stock\Module',
            'path' => APP_ROOT . 'apps/stock/Module.php'
        ),
        'install' =>
        array(
            'className' => 'apps\install\Module',
            'path' => APP_ROOT . 'apps/install/Module.php'
        ),
        'pack' =>
        array(
        	'className' => 'apps\pack\Module',
        	'path' => APP_ROOT . 'apps/pack/Module.php'
        )
        
));

try
{
    echo $app->handle()->getContent();
}
catch( \Exception $e )
{
	echo $e->getTraceAsString();
}

 
