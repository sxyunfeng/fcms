<?php
if( !defined( 'APP_ROOT' ) ) exit( 'Do not allow direct access!<br>' );

$router = new \Phalcon\Mvc\Router( false );

$router->removeExtraSlashes( true );

$router->add( '/admin.php', array(
		'module' => 'admin',
		'controller' => 'login',
		'action' => 'index'
));



$router->add( '/admin', array(
		'module' => 'admin',
		'controller' => 'login',
		'action' => 'index'
));

$router->add( '/common/upload/ctrl.php', array(
        'module' => 'common',
        'controller' => 'upload',
        'action' => 'ctrl'
));

$router->add('/:module/:controller/:action/:params', array(
		'module' => 1,
		'controller' => 2,
		'action' => 3,
		'params' => 4
));

// url router
$router->setDefaultModule( 'install' );
$router->setDefaultController( 'index' );
$router->setDefaultAction( 'index' );

// $router->add( '/',array(
// // 	'module' => 'home',
//     'controller' => 'index',
//     'index' => 'index'	
// ));



// $router->add('/:controller/:action/:params', array(
//     'module' => 'home',
//     'controller' => 1,
//     'action' => 2,
//     'params' => 3
// ));


/*
$router->add('/sys/:controller/:action/:params', array(
    'module' => 'sys',
    'controller' => 1,
    'action' => 2,
    'params' => 3
));

$router->add('/appmgr/:controller/:action/:params', array(
    'module' => 'appmgr',
    'controller' => 1,
    'action' => 2,
    'params' => 3
));

$router->add('/pri/:controller/:action/:params', array(
    'module' => 'pri',
    'controller' => 1,
    'action' => 2,
    'params' => 3
));

*/
?>
