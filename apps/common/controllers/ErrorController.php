<?php
namespace apps\common\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

class ErrorController extends \Phalcon\Mvc\Controller
{
    public function err404Action()
    {
        echo '<br>Sorry! We cann\'t find this page!<br>';
        
    }
}

?>