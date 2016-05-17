1.下载(或clone)fcms
2.把fcms文件夹放入web目录下
3.配置vhost后在浏览器时直接输入配置的地址即可安装

trouble shoot

1.如果不能完成安装只需要修改config/router.php中的default设置为

$router->setDefaultModule( 'install' );

$router->setDefaultController( 'Index' );

$router->setDefaultAction( 'index' );

2.若用户想手动安装只需要把apps/install/sql中的sql文件导入即可 其中一个为无例子的sql文件另一个为有例子的sql文件， 之后只须修改router.php中的Default为
$router->setDefaultModule( 'home' );

$router->setDefaultController( 'Index' );

$router->setDefaultAction( 'index' );
