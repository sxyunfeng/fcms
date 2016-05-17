<?php
namespace apps\install;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Events\Manager as EventsManager;
use apps\install\listeners\DispatcherListener;

class Module implements ModuleDefinitionInterface
{

	public function registerAutoloaders(\Phalcon\DiInterface $di=null)
	{
		$loader = new \Phalcon\Loader();
		$loader->registerNamespaces(array(
			'apps\install\controllers' => APP_ROOT . 'apps/install/controllers/',
			'apps\install\models' => APP_ROOT . 'apps/install/models/',
			'apps\install\listeners' => APP_ROOT . 'apps/install/listeners/',
		    'apps\install\enums' => APP_ROOT . 'apps/install/enums',
		    'apps\install\utils' => APP_ROOT . 'apps/install/utils'
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
			//$eventManager->attach('dispatch', new \Acl( 'install' ));
			
 			$eventManager->attach( 'dispatch', new DispatcherListener() );
			
			$dispatcher->setEventsManager( $eventManager );
			$dispatcher->setDefaultNamespace( "apps\\install\\controllers\\" );
			return $dispatcher;
		});

		//Registering the view component
		$di->set('view', function() {
			$view = new \Phalcon\Mvc\View();
			$view->setViewsDir(APP_ROOT . 'apps/install/views/');
			$view->registerEngines(array(
					'.volt' => function ($view, $di) {
						$volt = new VoltEngine($view, $di);
						$volt->setOptions(array(
								'compiledPath' => APP_ROOT . 'apps/install/cache/',
								'compiledSeparator' => '_',
								'compileAlways' => true
						));
						return $volt;
					},
				//	'.phtml' => 'Phalcon\Mvc\View\Engine\Php'
				));
			return $view;
		});

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
					$dbListener = new \apps\install\listeners\DbListener();
		
					$eventsMgr->attach( 'db', $dbListener );
		
					$db->setEventsManager( $eventsMgr );
		
					return $db;
				}, true );
		
		$di->module = 'install';
	}
	
	

}