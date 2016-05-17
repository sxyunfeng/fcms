<?php
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );
return new \Phalcon\Config(array(
    'email' => array(
            'protocol' => 'smtp',
            'charset' => 'utf8',
            'smtp_host' => 'smtp.163.com',
            'smtp_user' => 'sina163163126@163.com',
            'smtp_pass' => 'testtest',
            'user'  => 'huaer company'
    )
));
