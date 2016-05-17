<?php

/**
 * utest
 * @author hfc
 * time 2015-7-8
 */
namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );
class TestController extends \Phalcon\Mvc\Controller
{
    public function initialize()
    {
    }
    public function indexAction()
    {
        $this->loginController();
    }
    /**
     * 登录的单元测试
     */
    private function loginController()
    {
        $_POST[ $this->security->getTokenKey() ] = $this->security->getToken();
        echo $this->utest->run( $this->security->checkToken(), true, 'csrf' );
        $this->memCache->save( 'test', 'hello world a' );
        echo $this->utest->run( $this->memCache->get( 'test' ), 'hello world', 'memcache' );
    }
}
