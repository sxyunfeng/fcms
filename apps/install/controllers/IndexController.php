<?php

namespace apps\install\controllers;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use Phalcon\Mvc\Controller;
use Phalcon\Annotations\Annotation;
use apps\install\models\FcmsInstall;
use libraries\ZipUtils;
use apps\install\utils\ReturnInfo;
use Phalcon\DI\FactoryDefault;
use apps\admin\models\Ad;
use apps\install\models\userType;
use enums;

/**
 * CMS安装主页
 * @author New
 * @date 2015/10/22
 */
class IndexController extends Controller
{
    const LOG_PATH = "logs/fcms_install_logs.txt";
    
    const STR_RIGHT = "<span class='glyphicon glyphicon-ok' style='color:green;'></span>";

    const STR_WRONG = "<span class='glyphicon glyphicon-remove' style='color:red;'></span>";

    public function initialize()
    {
        if( file_exists( APP_ROOT . 'apps/install/cache/install.lock' ) )
        {
            echo '已经安装无需重复安装，<br>若需重复安装请先删除apps/install/cache/install.lock';
            $this->view->disable();
        }
    }

    /**
     *
     * @author ( author='New' )
     * @date( date = '2015.10.22' )
     * @comment( comment = 'cms安装主页' )
     * @method ( method = 'indexAction' )
     * @op( op = '' )
     */
    public function indexAction()
    {
        
    }

    /**
     *
     * @author ( author='New' )
     * @date( date = '2015.10.22' )
     * @comment( comment = 'cms账户配置主页' )
     * @method ( method = 'createAction' )
     * @op( op = '' )
     */
    public function createAction()
    {
        
    }

    /**
     *
     * @author ( author='New' )
     * @date( date = '2015.10.22' )
     * @comment( comment = 'cms完成安装主页' )
     * @method ( method = 'doneAction' )
     * @op( op = '' )
     */
    public function doneAction()
    {
        
    }
    
    /**
     *
     * @author ( author='New' )
     * @date( date = '2015.10.22' )
     * @comment( comment = 'cms环境检测主页' )
     * @method ( method = 'listAction' )
     * @op( op = '' )
     */
    public function checkAction()
    {
        
        // 检查操作系统
        $systemInfo = PHP_OS;
        if( $systemInfo == 'WINNT' )
        {
            $systemInfo = 'Windows';
        }
        
        $this->view->setVars( array( 'systemInfo' => $systemInfo, "systemId" => self::STR_RIGHT ) );
        
        // 检查服务器版本
        $serverInfo = $_SERVER[ "SERVER_SOFTWARE" ];
        $serverArr = explode( ' ', $serverInfo );
        $this->view->setVar( 'serverInfo', $serverArr[ 0 ] );
        
        // 检查php版本
        $phpVersion = phpversion();
        $this->view->setVar( 'phpVersion', $phpVersion );
        if( $phpVersion >= 5.3 )
        {
            $this->view->setVar( "phpVersionId", self::STR_RIGHT );
        }
        else
       {
            $this->view->setVar( "phpVersionId", self::STR_WRONG );
        }
        
        // 检查文件上传限制
        $uploadLimit = get_cfg_var( 'upload_max_filesize' );
        if( $uploadLimit >= 2 )
        {
            $uploadId = self::STR_RIGHT;
        }
        else
       {
            $uploadId = self::STR_WRONG;
        }
        $this->view->setVars( array( 'uploadLimitInfo' => $uploadLimit, 'uploadLimitId' => $uploadId ) );
        
        // 检查内存限制大小
        $memoryLimit = get_cfg_var( 'memory_limit' );
        if( $memoryLimit >= 128 )
        {
            $memoryLimitId = self::STR_RIGHT;
        }
        else
       {
            $memoryLimitId = self::STR_WRONG;
        }
        $this->view->setVars( 
                array( 'memoryLimitInfo' => $memoryLimit, 'memoryLimitId' => $memoryLimitId ) );
        
        // 检查扩展是否存在
        $this->checkExtension( array( 'mysql', 'mysqli', 'pdo_mysql', 'mongo', 'apc', 'phalcon', 'curl', 'gd',
                 'memcache', 'memcached' ) );
        
        // 检查文件与文件夹写权限
        $installCachePath = APP_MODULE . 'install/cache';
        $cmsCachePath = APP_MODULE . 'cms/cache';
        $adminCachePath = APP_MODULE . 'admin/cache';
        $configPath = APP_ROOT . 'config/config.php';
        $routerPath = APP_ROOT . 'config/router.php';
        $logsPath = APP_ROOT . self::LOG_PATH;
        
        $this->dirWritable( array(
        	array(
        		'name' => 'installCache',
        	    'path' => $installCachePath
        	),
            array(
                'name' => 'cmsCache',
                'path' => $cmsCachePath
            ),
            array(
                'name' => 'adminCache',
                'path' => $adminCachePath
            )
        ) );
        
        $this->fileWritable( array(
            array(
                'name' => 'config',
                'path' => $configPath
            ),
            array(
                'name' => 'router',
                'path' => $routerPath
            ),
            array(
                'name' => 'logs',
                'path' => $logsPath
            )
        ) );
    }

    /**
     *
     * @author ( author='New' )
     * @date( date = '2015年10月23日' )
     * @comment( comment = '检查所需扩展是否存在并输出信息到视图' )
     * @method ( method = 'checkExtension' )
     * @op( op = '' )
     */
    private function checkExtension( $needles )
    {
        foreach ( $needles as $needle )
        {
            if( extension_loaded( $needle ) )
            {
                $loadedInfo = '支持';
                $loadedId = self::STR_RIGHT;
            }
            else
            {
                $loadedInfo = '不支持';
                $loadedId = self::STR_WRONG;
            }
            $this->view->setVars( array( $needle . 'Info' => $loadedInfo, $needle . 'Id' => $loadedId ) );
        }
    }

    /**
     *
     * @author ( author='New' )
     * @date( date = '2015年10月23日' )
     * @comment( comment = '检查文件夹写权限' )
     * @method ( method = 'dirWritable' )
     * @op( op = '' )
     */
    private function dirWritable( $dirs )
    {
        foreach ( $dirs as $dir )
        {
        	$name = $dir[ 'name' ];
        	$path = $dir[ 'path' ];
        	
        	if( is_dir( $path ) )
        	{
        	    // 可写
        	    if( $fp = @fopen( "$path/testexample.txt", 'w' ) )
        	    {
        	        @fclose( $fp );
        	        @unlink( "$path/testexample.txt" );
        	        $status = self::STR_RIGHT;
        	    } // 不可写
        	    else
        	    {
        	        $status = self::STR_WRONG;
        	    }
        	}
        	else
        	{
        	    @mkdir( $path, 0777 );
        	    $status = self::STR_RIGHT;
        	}
        	$this->view->setVars( array( $name . 'WriteId' => $status, $name . 'Path' => $path ) );
        }
    }

    /**
     *
     * @author ( author='New' )
     * @date( date = '2015-11-18' )
     * @comment( comment = '检查文件写权限' )
     * @method ( method = 'fileWritable' )
     * @op( op = '' )
     */
    private function fileWritable( $files )
    {
        foreach ( $files as $file )
        {
        	$name = $file[ 'name' ];
        	$path = $file[ 'path' ];
        	
        	if( file_exists( $path ) )
        	{
        	    if( is_writable( $path ) )
        	    {
        	        $status = self::STR_RIGHT;
        	    }
        	    else
        	    {
        	        $status = self::STR_WRONG;
        	    }
        	}
        	else
        	{
        	    $fp = fopen( $path, "w+" );
        	    fclose( $fp );
        	    $status = self::STR_RIGHT;
        	}
        	$this->view->setVars( array( $name . 'WriteId' => $status, $name . 'Path' => $path ) );
        }
    }

    /**
     *
     * @author ( author='New' )
     * @date( date = '2015年10月24日' )
     * @comment( comment = '检查用户提交数据，完成后存储到cookie中一小时' )
     * @method ( method = 'checkInputInfo' )
     * @op( op = '' )
     */
    public function checkInputInfoAction()
    {
        $dbHost = trim( $this->request->getPost( 'dbHost', 'string' ) );
        $dbPort = trim( $this->request->getPost( 'dbPort', 'int' ) );
        $dbUsername = trim( $this->request->getPost( 'dbUsername', 'string' ) );
        $dbPassword = trim( $this->request->getPost( 'dbPassword', 'string' ) );
        $dbName = trim( $this->request->getPost( 'dbName', 'string' ) );
        $dbPrefix = trim( $this->request->getPost( 'dbPrefix', 'string' ) );
        
        if( !get_magic_quotes_gpc() )
        {
            $dbHost = addslashes( $dbHost );
            $dbPort = addslashes( $dbPort );
            $dbUsername = addslashes( $dbUsername );
            $dbPassword = addslashes( $dbPassword );
            $dbName = addslashes( $dbName );
            $dbPrefix = addslashes( $dbPrefix );
        }
        
        $res = 0;
        $install = new FcmsInstall();
        if( !$install->connectDb( $dbHost, $dbPort, $dbUsername, $dbPassword ) )
        {
            $res = "数据库配置信息有误";
            file_put_contents( APP_ROOT . self::LOG_PATH, date( 'Y-m-d H:i:s' ) . '数据库配置信息有误' . PHP_EOL, 
                    FILE_APPEND );
        }
        else
        {
            // 后台再次判断输入的用户名密码邮箱
            $masterUsername = trim( $this->request->getPost( 'masterUsername', 'string' ) );
            $masterPassword = trim( $this->request->getPost( 'masterPassword', 'string' ) );
            $masterEmail = trim( $this->request->getPost( 'masterEmail', 'string' ) );
            if( !get_magic_quotes_gpc() )
            {
                $masterUsername = addslashes( $masterUsername );
                $masterPassword = addslashes( $masterPassword );
                $masterEmail = addslashes( $masterEmail );
            }
            $usernamePattern = "/^\w{3,32}$/";
            $passwordPattern = "/^\w{6,32}$/";
            $userEmailPattern = "/^\w+(\.\w+)*@\w+(\.\w+)+$/";
            
            if( !preg_match( $usernamePattern, $masterUsername ) )
            {
                $res = "管理员用户名输入非法";
                file_put_contents( APP_ROOT . self::LOG_PATH, date( 'Y-m-d H:i:s' ) . '管理员用户名输入非法' . PHP_EOL, FILE_APPEND );
            }
            else if( !preg_match( $passwordPattern, $masterPassword ) )
            {
                $res = "管理员密码输入非法";
                file_put_contents( APP_ROOT . self::LOG_PATH, date( 'Y-m-d H:i:s' ) . '管理员密码输入非法' . PHP_EOL, FILE_APPEND );
            }
            else if( !preg_match( $userEmailPattern, $masterEmail ) )
            {
                $res = "管理员邮箱输入非法";
                file_put_contents( APP_ROOT . self::LOG_PATH, date( 'Y-m-d H:i:s' ) . '管理员邮箱输入非法' . PHP_EOL, FILE_APPEND );
            }
            else
           {
                $this->cookies->set( "dbHost", $dbHost, time() + 7200 );
                $this->cookies->set( "dbPort", $dbPort, time() + 7200 );
                $this->cookies->set( "dbUsername", $dbUsername, time() + 7200 );
                $this->cookies->set( "dbPassword", $dbPassword, time() + 7200 );
                $this->cookies->set( "dbName", $dbName, time() + 7200 );
                $this->cookies->set( "dbPrefix", $dbPrefix, time() + 7200 );
                $this->cookies->set( "masterUsername", $masterUsername, time() + 7200 );
                $this->cookies->set( "masterPassword", md5( $masterPassword ), time() + 7200 );
                $this->cookies->set( "masterEmail", $masterEmail, time() + 7200 );
            }
        }
        
        echo $res;
    }

    /**
     *
     * @author ( author='New' )
     * @date( date = '2015.10.26' )
     * @comment( comment = '循环执行步骤并输出' )
     * @method ( method = 'installStep' )
     * @op( op = '' )
     */
    public function installStepAction()
    {
        set_time_limit( 0 );
        //目前执行到的循环数
        $iStep = $this->dispatcher->getParam( 'step' ); 
        $res = array();
        
        if( !$iStep )
        {
            $res = ReturnInfo::resInfo( 1, 
                    "<p>未取到step参数或参数为0（第一步参数为1）！&nbsp;&nbsp;' .
	        		'<span class='glyphicon glyphicon-remove' style='color:red;'></p>" );
            
            file_put_contents( APP_ROOT . self::LOG_PATH, 
                    date( 'Y-m-d H:i:s' ) . 'step参数设置错误' . PHP_EOL, FILE_APPEND );
            
            exit( json_encode( $res ) );
        }
        
        switch( $iStep )
        {
            // 导入数据库文件
            case 1:
                $sqlId = $this->dispatcher->getParam( 'sqlId' );//选择是否添加示例数据
                $dbHost = $this->cookies->get( "dbHost" );
                $dbPort = $this->cookies->get( "dbPort" );
                $dbUsername = $this->cookies->get( "dbUsername" );
                $dbPassword = $this->cookies->get( "dbPassword" );
                $dbName = $this->cookies->get( "dbName" );
                $dbPrefix = $this->cookies->get( "dbPrefix" );
                
                $install = new FcmsInstall();
                $link = $this->checkLink( $dbHost, $dbPort, $dbUsername, $dbPassword, $dbName, $install );
                $file = ( ( 1 == $sqlId ) ? APP_MODULE . "install/sql/install.sql" : APP_MODULE . "install/sql/installEmpty.sql" );
                if( !file_exists( $file ) )
                {
                    $res = ReturnInfo::resInfo( 8, 
                            "<p>安装文件不完整，请检查后重新安装！" .
                                     "&nbsp;&nbsp;<span class='glyphicon glyphicon-remove' style='color:red;'></p>" );
                    file_put_contents( APP_ROOT . self::LOG_PATH, 
                            date( 'Y-m-d H:i:s' ) . '安装文件不完整' . PHP_EOL, FILE_APPEND );
                    exit( json_encode( $res ) );
                }
                $res = $install->importDb( $link, $file, $dbName );
                // 如果全部导入成功则循环次数加1，前台将自动进入下一循环
                if( 0 === $res[ 'status' ] )
                {
                    $res[ 'n' ] = ++$iStep;
                    file_put_contents( APP_ROOT . self::LOG_PATH, 
                            date( 'Y-m-d H:i:s' ) . '数据库文件导入成功' . PHP_EOL, FILE_APPEND );
                }
                echo json_encode( $res );
                break;
            // 存储用户信息
            case 2:
                $dbHost = $this->cookies->get( "dbHost" );
                $dbPort = $this->cookies->get( "dbPort" );
                $dbUsername = $this->cookies->get( "dbUsername" );
                $dbPassword = $this->cookies->get( "dbPassword" );
                $dbName = $this->cookies->get( "dbName" );
                $dbPrefix = $this->cookies->get( "dbPrefix" );
                
                $masterUsername = $this->cookies->get( 'masterUsername' );
                $masterPassword = $this->cookies->get( 'masterPassword' );
                $masterEmail = $this->cookies->get( 'masterEmail' );
                
                $install = new FcmsInstall();
                $link = $this->checkLink( $dbHost, $dbPort, $dbUsername, $dbPassword, $dbName, $install );
                $res = $install->insertInfo( $iStep, $link, $dbName, $masterUsername, $masterPassword, $masterEmail );

                echo json_encode( $res );
                
                break;
            // 更改本地数据库配置信息
            case 3:
                if( false === $this->changeDb() )
                {
                    $res = ReturnInfo::resInfo( 6, 
                            "<p>第三步，写入配置文件失败！&nbsp;&nbsp;<span class='glyphicon glyphicon-remove' style='color:red;'></p>" );
                    file_put_contents( APP_ROOT . self::LOG_PATH, 
                            date( 'Y-m-d H:i:s' ) . '写入配置文件失败' . PHP_EOL, FILE_APPEND );
                }
                else
              {
                    $res = ReturnInfo::resInfo( 20, 
                            "<p>第三步，写入配置文件成功！&nbsp;&nbsp;<span class='glyphicon glyphicon-ok' style='color:green;'></p>" );
                    $res[ 'n' ] = ++$iStep;
                    file_put_contents( APP_ROOT . self::LOG_PATH, 
                            date( 'Y-m-d H:i:s' ) . '写入配置文件成功' . PHP_EOL, FILE_APPEND );
                }
                echo json_encode( $res );
                break;
            // 改变router.php中默认路由规则
            case 4:
                $routerFile = APP_ROOT . 'config/router.php';
                $thirdChange = $this->changeRouter( $routerFile );
                
                file_put_contents( $routerFile, $thirdChange );
                file_put_contents( APP_ROOT . self::LOG_PATH, 
                        date( 'Y-m-d H:i:s' ) . '默认路由已改为后台登录页面' . PHP_EOL, FILE_APPEND );
                
                $res = ReturnInfo::resInfo( 30, "" );
                $res[ 'n' ] = ++$iStep;
                
                //安装完成生成lock文件
                file_put_contents( APP_ROOT . 'apps/install/cache/install.lock', time() );
                
                echo json_encode( $res );
                break;
        }
    }


    /**
     *
     * @author ( author='New' )
     * @date( date = '2015年11月5日' )
     * @comment( comment = '返回标记量和输出信息' )
     * @method ( method = 'resInfo' )
     * @op( op = '' )
     */
    private function resInfo( $status, $msg )
    {
        $res[ 'status' ] = $status;
        $res[ 'msg' ] = $msg;
        return $res;
    }

    /**
     *
     * @author ( author='New' )
     * @date( date = '2015年11月6日' )
     * @comment( comment = '返回现在的百分比' )
     * @method ( method = 'showPercentage' )
     * @op( op = '' )
     */
    public function showPercentageAction()
    {
        $percentage = isset( $_SESSION[ 'percentage' ] ) ? $_SESSION[ 'percentage' ] : '0%';
        echo json_encode( $percentage );
    }

    
    private function checkLink( $dbHost, $dbPort, $dbUsername, $dbPassword, $dbName, $install )
    {
        $link = $install->connectDb( $dbHost, $dbPort, $dbUsername, $dbPassword );
        if( !$link )
        {
            //数据库连接失败，cookie信息已失效或cookie未开启，请检查并返回上一页重新提交！
            $res = ReturnInfo::resInfo( 3,
                    "<p>数据库连接失败，cookie信息已失效或cookie未开启，请检查并返回上一页重新提交！" .
                    "&nbsp;&nbsp;<span class='glyphicon glyphicon-remove' style='color:red;'></p>" );
            file_put_contents( APP_ROOT . self::LOG_PATH,
            date( 'Y-m-d H:i:s' ) . '数据库连接失败' . PHP_EOL, FILE_APPEND );
            exit( json_encode( $res ) );
        }
        else
       {
       	    return $link;
        }
    }
    
    
    /**
     * @author( author='New' )
     * @date( date = '2015-11-23' )
     * @comment( comment = '更改config.php中数据库配置' )	
     * @method( method = 'changeDb' )
     * @op( op = '' )		
    */
    private function changeDb()
    {
        $configStr = file_get_contents( APP_ROOT . 'config/config.php' );
        
        $dbHost = $this->cookies->get( 'dbHost' );
        $hostPattern = "/\'host\'(\s)*=>(\s)*\'.*\'/U";
        $firstRep = preg_replace( $hostPattern, "'host'     => '" . $dbHost . "'", $configStr );
        
        $dbUsername = $this->cookies->get( "dbUsername" );
        $usernamePattern = "/\'username\'(\s)*=>(\s)*\'.*\'/U";
        $secondRep = preg_replace( $usernamePattern, "'username' => '" . $dbUsername . "'", $firstRep );
        
        $dbPassword = $this->cookies->get( "dbPassword" );
        $passwordPattern = "/\'password\'(\s)*=>(\s)*\'.*\'/U";
        $thirdRep = preg_replace( $passwordPattern, "'password' => '" . $dbPassword . "'", $secondRep );
        
        $dbName = $this->cookies->get( "dbName" );
        $dbnamePattern = "/\'dbname\'(\s)*=>(\s)*\'.*\'/U";
        $fourthRep = preg_replace( $dbnamePattern, "'dbname'   => '" . $dbName . "'", $thirdRep );
        
        $dbPrefix = $this->cookies->get( "dbPrefix" );
        $prefixPattern = "/\'prefix\'(\s)*=>(\s)*\'.*\'/U";
        $fifthRep = preg_replace( $prefixPattern, "'prefix'   => '" . $dbPrefix . "'", $fourthRep );
        
        return file_put_contents( APP_ROOT . 'config/config.php', $fifthRep );
        
    }
    
    
    /**
     * @author( author='New' )
     * @date( date = '2015-11-23' )
     * @comment( comment = '更改router.php中默认路由配置' )	
     * @method( method = 'changeRouter' )
     * @op( op = '' )		
    */
    private function changeRouter( $routerFile )
    {
        $routerContent = file_get_contents( $routerFile );
        
        $modulePattern = "/setDefaultModule(\s)*\((\s)*\'(\w)*\'(\s)*\)(\s)*;/";
        $moduleRep = "setDefaultModule( 'cms' );";
        $firstChange = preg_replace( $modulePattern, $moduleRep, $routerContent );
        
        $controllerPattern = "/setDefaultController(\s)*\((\s)*\'(\w)*\'(\s)*\)(\s)*;/";
        $controllerRep = "setDefaultController( 'index' );";
        $secondChange = preg_replace( $controllerPattern, $controllerRep, $firstChange );
        
        $actionPattern = "/setDefaultAction(\s)*\((\s)*\'(\w)*\'(\s)*\)(\s)*;/";
        $actionRep = "setDefaultAction( 'index' );";
        $thirdChange = preg_replace( $actionPattern, $actionRep, $secondChange );
        return $thirdChange;
    }
    
}

?>
