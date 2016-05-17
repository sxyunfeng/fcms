<?php
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

return new \Phalcon\Config(
    array(
        
    	'f_cms_version'	=> 'alpha1',
        //每多少次文章总访问量更新一次数据库
        'fcmsUpdateTimes' => 5,
        //每隔多少秒之后重置用户请求，这时再访问统一页面访问次数会加1
        'fcmsResetTime' => 5,
    )
);