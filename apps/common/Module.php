<?php

namespace apps\common;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Events\Manager as EventsManager;

class Module implements ModuleDefinitionInterface
{

    public function registerAutoloaders( \Phalcon\DiInterface $di = null )
    {
        $loader = new \Phalcon\Loader();

        $loader->registerNamespaces( array(
            'apps\common\controllers' => APP_ROOT . '/apps/common/controllers/',
            'apps\common\models'      => APP_ROOT . '/apps/common/models/',
            'apps\common\plugins'     => APP_ROOT . '/apps/common/plugins/',
            'apps\common\libraries'   => APP_ROOT . '/apps/common/libraries/',
            'apps\common\listeners'   => APP_ROOT . 'apps/common/listeners/',
            'apps\admin\controllers'  => APP_ROOT . '/apps/admin/controllers/',
            'apps\home\controllers'   => APP_ROOT . '/apps/home/controllers/',
            'apps\home\enums'          => APP_ROOT . '/apps/home/enums/'
        ) );

        $loader->register();
    }

    /**
     * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
     */
    public function registerServices( \Phalcon\DiInterface $di = null )
    {
        //Registering a dispatcher
        $di->set( 'dispatcher',
                function ( )
        {

            $dispatcher = new \Phalcon\Mvc\Dispatcher();

            //Attach a event listener to the dispatcher
            $eventManager = new \Phalcon\Events\Manager();
            //$eventManager->attach('dispatch', new \Acl( 'admin' ));


            $eventManager->attach( 'dispatch:beforeException',
                    function ( $event, $dispatcher, $exception )
            {

                if( $exception instanceof \Phalcon\Mvc\Dispatcher\Exception )
                {
                    $dispatcher->forward( array(
                        'module'     => 'common',
                        'controller' => 'error',
                        'action'     => 'err404' ) );

                    return false;
                }
            } );

            $eventManager->attach( 'dispatch:beforeDispatchLoop',
                    function ( $event, $dispatcher )
            {
                $keyParams = array();
                $params = $dispatcher->getParams();

                foreach( $params as $k => $v )
                {
                    if( $k & 1 )
                    {
                        $keyParams [ $params [ $k - 1 ] ] = $v;
                    }
                }

                $dispatcher->setParams( $keyParams );
            } );

            $dispatcher->setEventsManager( $eventManager );
            $dispatcher->setDefaultNamespace( "apps\\common\\controllers\\" );
            return $dispatcher;
        } );

        //Registering the view component
        $di->set( 'view',
                function ( )
        {
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir( '../apps/common/views/' );
            $view->registerEngines( array(
                '.volt' => function ( $view, $di )
                {
                    $volt = new VoltEngine( $view, $di );
                    $volt->setOptions( array(
                        'compiledPath'      => APP_ROOT . '/apps/common/cache/',
                        'compiledSeparator' => '_',
                        'compileAlways'     => true ) );
                    return $volt;
                },
                            //	'.phtml' => 'Phalcon\Mvc\View\Engine\Php'
                    ) );
                    return $view;
                } );

                $config = $di->get( 'config' );

                $di->set( 'db',
                        function () use($config )
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
                    $dbListener = new \apps\common\listeners\DbListener();

                    $eventsMgr->attach( 'db', $dbListener );

                    $db->setEventsManager( $eventsMgr );

                    return $db;
                }, true );
            }

        }
        