<?php
namespace apps\admin;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Events\Manager as EventsManager;
use apps\admin\listeners\DispatcherListener;
use apps\admin\libraries\GoodsDatas;
use apps\admin\libraries\ArticlesData;
use apps\admin\libraries\SysInfoData;

class Module implements ModuleDefinitionInterface
{

	public function registerAutoloaders(\Phalcon\DiInterface $di=null)
	{

		$loader = new \Phalcon\Loader();

		$loader->registerNamespaces(array(
			'apps\admin\controllers' => APP_ROOT . 'apps/admin/controllers/',
			'apps\admin\models' => APP_ROOT . 'apps/admin/models/',
			'apps\admin\plugins' => APP_ROOT . 'apps/admin/plugins/',
            'apps\admin\commbiz' => APP_ROOT . 'apps/admin/commbiz/',
			'apps\admin\listeners' => APP_ROOT . 'apps/admin/listeners/',
		    'apps\oa\models' => APP_ROOT . 'apps/oa/models',
			'apps\admin\enums' => APP_ROOT . 'apps/admin/enums/',
			'apps\admin\libraries' => APP_ROOT . 'apps/admin/libraries/',
		));

		$loader->register();
	}

	/**
	 * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
	 */
	public function registerServices(\Phalcon\DiInterface $di=null)
	{
		//Registering a dispatcher
		$di->set('dispatcher', function() {

			$dispatcher = new \Phalcon\Mvc\Dispatcher();

			//Attach a event listener to the dispatcher
			$eventManager = new \Phalcon\Events\Manager();
			//$eventManager->attach('dispatch', new \Acl( 'admin' ));
			

 			
 			$eventManager->attach( 'dispatch', new DispatcherListener() );
			
			$dispatcher->setEventsManager( $eventManager );
			$dispatcher->setDefaultNamespace( "apps\\admin\\controllers\\" );
			return $dispatcher;
		});

		//Registering the view component
		$di->set('view', function() {
			$view = new \Phalcon\Mvc\View();
			$view->setViewsDir(APP_ROOT . 'apps/admin/views/');
			$view->registerEngines(array(
					'.volt' => function ($view, $di) {
						$volt = new VoltEngine($view, $di);
						$volt->setOptions(array(
								'compiledPath' => APP_ROOT . 'apps/admin/cache/',
								'compiledSeparator' => '_',
								'compileAlways' => true
						));
						return $volt;
					},
				//	'.phtml' => 'Phalcon\Mvc\View\Engine\Php'
				));
			return $view;
		});

		$di->set( 'adminInfo', function(){
			return new \apps\admin\commbiz\AdminInfo();
		}, true );
		
		$config = $di->get( 'config' );
		
		$di->set( 'db',
				function () use( $config )
				{
					$db = new \Phalcon\Db\Adapter\Pdo\Mysql( array(
							'adapter'  => $config->database->adapter,
							'host'     => $config->database->host,
							'username' => $config->database->username,
							'password' => $config->database->password,
							'dbname'   => $config->database->dbname,
							'charset'  => $config->database->charset
					) );
		
					$eventsMgr = new EventsManager();
					$dbListener = new \apps\admin\listeners\DbListener();
		
					$eventsMgr->attach( 'db', $dbListener );
		
					$db->setEventsManager( $eventsMgr );
		
					return $db;
				}, true );
		
		
		$di->module = 'admin';
		
		$di->set ( 'goods',function(){ return new GoodsDatas(); }, true);
		$di->set ( 'article',	function(){ return new ArticlesData(); }, true );
		$di->set ( 'sysinfo' , function(){ return new SysInfoData(); }, true );
		
	}
	
	

}