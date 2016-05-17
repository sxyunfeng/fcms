<?php

$di = new \Phalcon\DI\FactoryDefault();

 $di->set( 'session', function(){
// 	$session = new \Phalcon\Session\Adapter\Libmemcached( array(
// 		'servers' => array(
// 		array( 'host' => '127.0.0.1', 'port' => 11211, 'weight' => 1 )
// 	),
// 		'client' => array(
// 			Memcached::OPT_HASH => Memcached::HASH_MD5,
// 			Memcached::OPT_PREFIX_KEY => 'huaer.'
// 		),
// 			'lifetime' => 3600,
// 			'prefix' => 'huaer_'
// 	));
    $session = new \Phalcon\Session\Adapter\Memcache();
 	session_set_cookie_params( 3600, '/', '.huaer.dev' );
 	ini_set("session.cookie_httponly", 1);
 	
 	$session->start();
 	
	return $session;
 });
 

$session = $di->get( 'session' );
$session->close();
$memInfo = array( 'id' => 3 );
$session->set( 'memInfo', $memInfo );

// $memInfo = array( 'shop_id' => 4 );
// $session->set( 'userInfo', $userInfo );

var_dump( $session->get( 'memInfo' ));