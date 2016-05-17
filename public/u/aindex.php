<?php

$di = new \Phalcon\DI\FactoryDefault();

 $di->set( 'session', function(){
 	$session = new \Phalcon\Session\Adapter\Libmemcached( array(
 		'servers' => array(
 		array( 'host' => '127.0.0.1', 'port' => 11211, 'weight' => 1 )
 	),
 		'client' => array(
 			Memcached::OPT_HASH => Memcached::HASH_MD5,
 			Memcached::OPT_PREFIX_KEY => 'huaer.'
 		),
 			'lifetime' => 3600,
 			'prefix' => 'huaer_'
 	));
 	session_set_cookie_params( 3600, '/', '.huaer.dev' );
 	ini_set("session.cookie_httponly", 1);
 	
 	$session->start();
 	
	return $session;
 });
 

$session = $di->get( 'session' );
$session->close();
$session->set( 'a', '3' );

echo $session->get( 'a' );