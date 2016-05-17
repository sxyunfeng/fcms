<?php
return new \Phalcon\Config( 
        array(
                'type' => 0,  // 0 for filesystem 1 for fastdfs
                'fs' => array(
                        'cur' => 'f0',
                        'mode' => 1,// 0 for hard coded 1 for random 
                        'metadb' => 0, //0 for mongodb 1 for redis
                        'paths' => array(
                                'f0' => array(
                                        'key' => 'f0',
                                        'url' => 'http://img0.huaer.dev', 
                                        'path' => '/Users/bruce/develop/phpprjs/img0.huaer.dev',
                                        'full' => 0
                                ), 
                                'f1' => array(
                                        'key' => 'f1',
                                        'url' => 'http://img1.huaer.dev', 
                                        'path' => '/Users/bruce/develop/phpprjs/img1.huaer.dev', 
                                        'full' => 0
                                ), 
                                'f2' => array(
                                        'key' => 'f2',
                                        'url' => 'http://img2.huaer.dev', 
                                        'path' => '/Users/bruce/develop/phpprjs/img2.huaer.dev', 
                                        'full' => 0
                                )
                        )
                ),
                'fastdfs' => array(
                        	'metadb' => 0,//0 for mongodb 1 for redis 2 for mysql
                        )
        ) );