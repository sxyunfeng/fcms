<?php

namespace apps\cms;

! defined ( 'APP_ROOT' ) && exit ( 'Direct Access Deny!' );

use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Events\Manager as EventsManager;
use apps\cms\libraries\ArticleData;
use apps\cms\libraries\AdsData;
use apps\cms\libraries\SitesData;
use apps\cms\libraries\FriendLinkData;
use apps\cms\libraries\MenusData;
use apps\cms\libraries\SearchData;
use Phalcon\Cache\Frontend\Output as OutputFrontend; 

class Module implements ModuleDefinitionInterface {
	public function registerAutoloaders(\Phalcon\DiInterface $di=null) {
		$loader = new \Phalcon\Loader ();
		
		$loader->registerNamespaces ( array (
				'apps\cms\controllers' => APP_ROOT . '/apps/cms/controllers/',
				'apps\cms\models' => APP_ROOT . '/apps/cms/models/',
				'apps\admin\models' => APP_ROOT . '/apps/admin/models/',
				'apps\cms\plugins' => APP_ROOT . '/apps/cms/plugins/',
				'apps\cms\libraries' => APP_ROOT . '/apps/cms/libraries/',
				'apps\cms\listeners' => APP_ROOT . 'apps/cms/listeners/',
				'apps\cms\vos' => APP_ROOT . 'apps/cms/vos/' 
				) );
		
		$loader->register ();
	}
	
	/**
	 * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
	 */
	public function registerServices(\Phalcon\DiInterface $di = null) {
		// Registering a dispatcher
		$di->set ( 'dispatcher', function () {
			
			$dispatcher = new \Phalcon\Mvc\Dispatcher ();
			
			// Attach a event listener to the dispatcher
			$eventManager = new \Phalcon\Events\Manager ();
			// $eventManager->attach('dispatch', new \Acl( 'admin' ));
			
			$eventManager->attach ( 'dispatch:beforeException', function ($event, $dispatcher, $exception) {
				
				if ($exception instanceof \Phalcon\Mvc\Dispatcher\Exception) {
					$dispatcher->forward ( array (
							'module' => 'cms',
							'controller' => 'error',
							'action' => 'err404' 
					) );
					
					return false;
				}
			} );
			
			$eventManager->attach ( 'dispatch:beforeDispatchLoop', function ($event, $dispatcher) {
				$keyParams = array ();
				$params = $dispatcher->getParams ();
				
				foreach ( $params as $k => $v ) {
					if ($k & 1) {
						$keyParams [$params [$k - 1]] = $v;
					}
				}
				
				$dispatcher->setParams ( $keyParams );
			} );
			
			$dispatcher->setEventsManager ( $eventManager );
			$dispatcher->setDefaultNamespace ( "apps\\cms\\controllers\\" );
			return $dispatcher;
		} );
		
		// Registering the view component
		$di->set ( 'view', function () {
			$view = new \Phalcon\Mvc\View ();
			$view->setViewsDir ( '../apps/cms/views/' );
			$view->registerEngines ( array (
					'.volt' => function ($view, $di) {
						$volt = new VoltEngine ( $view, $di );
						$volt->setOptions ( array (
								'compiledPath' => APP_ROOT . '/apps/cms/cache/',
								'compiledSeparator' => '_',
								'compileAlways' => false 
						) );
						return $volt;
					} 
			// '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
						) );
			return $view;
		} );

		//设置视图缓存
		$di->set( 'viewCache', function(){
			$frontCache = new OutputFrontend( array(
				'lefttime'	=> 	86400,
			));
			$cache = new \Phalcon\Cache\Backend\Apc( $frontCache, array( 'prefix' => 'fcms' ));
			return $cache;
		});

		$config = $di->get( 'config' );
		$di->set ( 'db', function () use($config) {
			$db = new \Phalcon\Db\Adapter\Pdo\Mysql ( array (
					'adapter' => $config->database->adapter,
					'host' => $config->database->host,
					'username' => $config->database->username,
					'password' => $config->database->password,
					'dbname' => $config->database->dbname,
					'charset' => $config->database->charset 
			) );
			
			$eventsMgr = new EventsManager ();
			$dbListener = new \apps\cms\listeners\DbListener ();
			
			$eventsMgr->attach ( 'db', $dbListener );
			
			$db->setEventsManager ( $eventsMgr );
			
			return $db;
		}, true );
		
		$di->module = 'cms';
		
		$di->set ( 'article',function(){ return new ArticleData (); }, true);
		$di->set ( 'ad',	function(){ return new AdsData(); }, true );
		$di->set ( 'site' , function(){ return new SitesData(); }, true );
		$di->set ( 'flink', function(){ return new FriendLinkData(); }, true );
		$di->set ( 'menu', 	function(){ return new MenusData(); }, true );
		$di->set ( 'search', 	function(){ return new SearchData(); }, true );
		
	}
}
        
