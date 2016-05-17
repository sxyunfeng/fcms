<?php
namespace apps\admin\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );

use enums\SystemEnums;
use apps\admin\models\Backup;
use Phalcon\Paginator\Adapter\QueryBuilder;
use libraries\TimeUtils;
use libraries\ZipUtils;
use libraries\EportDbUtils;
use libraries\ImportDbUtils;
use libraries\FileUtils;
use apps\install\models\FcmsInstall;
use libraries\ExportDbUtils;

/**
 * 备份管理
 * @author nzw
 * time 2016-04-14
 */
class BackupController extends AdminBaseController
{
    /**
     * 生成的备份zip文件的保存路径
     * @author nzw
     * time 2016-04-15
     */
    private $saveDir = '';
    
    /**
     * 需要备份的文件的位置（在本项目中就是默认的图片的保存位置）
     * @author nzw
     * time 2016-04-16
     */
    private $fileDir = '';
    
    public function initialize()
    {
        parent::initialize();
        
        $this->saveDir = $this->config[ 'backupDir' ];
        $this->fileDir = '/public/upload/';
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2016-3-16' )
     * @comment( comment = '显示备份管理主页' )
     * @method( method = 'index' )
     * @op( op = '' )
     */
    public function indexAction()
    {
        $pageNum = $this->request->getQuery( 'page', 'int' );
        $currentPage = $pageNum ?: 1;
        
    	$builder = $this->modelsManager->createBuilder()
    	           ->from( 'apps\admin\models\Backup' )
    	           ->where( "delsign=" . SystemEnums::DELSIGN_NO );
    	
    	$pagination = new QueryBuilder( [
	        'builder' => $builder,
	        'limit'   => 10,
	        'page'    => $currentPage
    	] );
    	$page = $pagination->getPaginate();
    	$this->view->backups = $page;
    	
    }
    /**
     * @author( author='New' )
     * @date( date = '2016-3-16' )
     * @comment( comment = '显示备份添加页' )
     * @method( method = 'add' )
     * @op( op = 'r' )
     */
    public function addAction()
    {
        $where = [
        	'conditions' => 'delsign=?0',
            'bind' => [ SystemEnums::DELSIGN_NO ]
        ];
    	$groups = Backup::find( $where );
		$this->view->groups = count( $groups ) > 0 ? $groups : false;
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2016-4-14' )
     * @comment( comment = '添加新备份到数据库' )	
     * @method( method = 'insert' )
     * @op( op = 'w' )		
    */
    public function insertAction()
    {
        $this->csrfCheck();

    	if( $this->request->getPost() )
    	{
    		$name = $this->request->getPost( 'name', 'string' );
    		$backupOpt = intval( $this->request->getPost( 'backupOpt', 'int' ) );//1为全部备份，0为自定义备份
    		$sql = 'true' === $this->request->getPost( 'sql' )?true:false;//bool
    		$image = 'true' === $this->request->getPost( 'image' )?true:false;//bool
    		$method = intval($this->request->getPost( 'method', 'int' ) );//0为保存到服务器，1为直接下载
    	}
    	
    	$pattern = '/^[\d\w]{1,32}$/';
    	if( !preg_match( $pattern, $name ) )
    	{
    		$res[ 'state' ] = 1;//备份名称不合法
    	}
    	else
    	{
    	    $zipName = $name . '-' . TimeUtils::getFullTimeFileName() . '.zip';//生成的zip文件名
    	    if( !$method )
    	    {//如果选择的是保存到服务器，则压缩到指定路径，之后保存到数据库中
    	        if( !is_dir( $_SERVER[ 'DOCUMENT_ROOT' ] . $this->saveDir ) )
    	        {//如果保存到服务器的指定文件夹不存在，那么创建该文件夹
    	            $dirArr = array();
    	            $this->createDir( $this->saveDir, $dirArr );
    	        }
                $saveName = $_SERVER[ 'DOCUMENT_ROOT' ] . $this->saveDir . TimeUtils::getTimeFileName() . '/' . $zipName;
                if( !is_dir( $_SERVER[ 'DOCUMENT_ROOT' ] . $this->saveDir . TimeUtils::getTimeFileName()  ) )
                {
                    mkdir( $_SERVER[ 'DOCUMENT_ROOT' ] . $this->saveDir . TimeUtils::getTimeFileName(), 0777 );
                }
                
                $zipFileRes = $this->zipFile( $backupOpt, $image, $sql, $name, $saveName );
        	    
        	    if( $backupOpt || ( $sql && $image ) )
        	    {
        	    	$type = 0;//全备份
        	    }
        	    elseif( !$backupOpt && !$sql && $image )
        	    {
        	        $type = 1;//只备份图片
        	    }
        	    elseif( !$backupOpt && $sql && !$image )
        	    {
        	        $type = 2;//只备份数据库
        	    }
        	    
        		//保存到数据库
    		    $backupModel = new Backup();
    		    $backupModel->addtime = $backupModel->uptime = TimeUtils::getFullTime();
    		    $backupModel->delsign = SystemEnums::DELSIGN_NO;
    		    $backupModel->name = $zipName;
    		    $backupModel->type = $type;
    		    $backupModel->creator = $this->session->get( 'userInfo' )[ 'nickname' ]?:$this->session->get( 'userInfo' )[ 'username' ];
    		    $backupModel->size = sprintf( "%.2f",filesize( $saveName ) / 1024 );
    		    $backupModel->method = $method;
    		    $backupModel->save();
    	    }
    	    else
    	    {//选择的是直接下载，则压缩到临时路径后提供下载
    	        $tmpPath = APP_ROOT . $this->config[ 'tmpDownloadDir' ];
    	        if( !is_dir( $tmpPath ) )
    	        {
    	        	mkdir( $tmpPath, 0777 );
    	        }
    	        $tmpName = $tmpPath . $zipName;
    	        $zipFileRes = $this->zipFile( $backupOpt, $image, $sql, $name, $tmpName );
    	        $ret[ 'zipName' ] = $zipName;
    	    }
    	    switch( $zipFileRes )
    	    {
    	    	case 0:
    	    	    $ret[ 'state' ] = 0; // 压缩成功
    	    	    break;
    	    	case 1:
    	    	    $ret[ 'state' ] = 2; // 压缩失败
    	    	    break;
    	    	case 2:
    	    	    $ret[ 'state' ] = 3; // 请至少选择一个备份的内容
    	    	    break;
	    	    case 3:
	    	        $ret[ 'state' ] = 4; // 无法导出数据库
	    	        break;
    	        case 4:
    	            $ret[ 'state' ] = 5; // 数据库中没有表
    	            break;
    	    }
    	}
    	$ret[ 'method' ] = $method;//0为保存到服务器，1为直接下载
    	$ret[ 'key' ] = $this->security->getTokenKey();
    	$ret[ 'token' ] = $this->security->getToken();
    	
    	echo json_encode( $ret );
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2016-4-15' )
     * @comment( comment = '直接下载' )	
     * @method( method = 'download' )
     * @op( op = '' )		
    */
    public function downloadAction()
    {
        $name = $this->dispatcher->getParam( 'name', 'string' );
        if( !$name )
        {
        	echo '<script>alert( \'文件名传递错误，下载失败\' );</script>';
        	exit;
        }
        $tmpArr = explode( '-', $name );
        $timeStamp = substr( end( $tmpArr ), 0, 8 );
        
        $method = intval( $this->dispatcher->getParam( 'method', 'int' ) );
        
        if( isset( $method ) && 0 == $method )
        {//保存到服务器
            $dir = $this->config[ 'backupDir' ] . $timeStamp . '/';
        }
        else
       {//直接下载
            $dir = $this->config[ 'tmpDownloadDir' ];
        } 
        
        $downloadFile = APP_ROOT . $dir . $name;
        if( file_exists( $downloadFile ) )
        {
            //文件的类型
            header( 'Content-type:application/zip' );
            //下载显示的名字
            header( 'Content-Disposition:attachment;filename="' . $name . '"' );
            readfile( $downloadFile );
        }
        else 
       {//文件不存在
            echo '<script>alert( \'文件不存在或已被删除\' );</script>';
        }
        
    }
    
    
    /**
     * @author( author='New' )
     * @date( date = '2016-4-15' )
     * @comment( comment = '压缩需要备份的文件' )	
     * @method( method = 'zipFile' )
     * @op( op = '' )		
    */
    private function zipFile( $backupOpt, $image, $sql, $name, $saveName )
    {
        $sqlDir = $_SERVER[ 'DOCUMENT_ROOT' ] . $this->fileDir . 'sql/';
        $sqlName = $sqlDir . $name . '-' . TimeUtils::getFullTimeFileName() . '.sql';
        
        if( $backupOpt || $sql )
        { // 如果选中备份所有或选中备份数据库，则导出数据库，否则不需要导出数据库
            $exportDbRes = $this->exportDb( $backupOpt, $sql, $sqlDir, $sqlName );
            if( $exportDbRes )
            {//导出sql文件出错，则输出错误码，并不再往下执行
                switch( $exportDbRes )
                {
                	case 1:
                	    $exportRes = 3; // 无法导出数据库
                	    break;
                	case 2:
                	    $exportRes = 4; // 数据库中没有表
                	    break;
                }
                return $exportRes;
                exit;
            }
        }
            
        $zipUtils = new ZipUtils();
        if( !$image && $sql )
        { // 未选中备份图片但选中数据库时，就只压缩单独的数据库文件
            if( $zipUtils->Zip( $sqlDir, $saveName ) )
            { // 压缩成功，将信息保存到数据库中
                $zipRes = 0; // 压缩成功，成功之后删除sql文件
            }
            else
           {
                $zipRes = 1; //压缩失败
            }
        }
        elseif( $backupOpt || $image )
        { // 全选或只要选中了备份图片，则压缩整个upload文件夹
            if( $zipUtils->Zip( $_SERVER[ 'DOCUMENT_ROOT' ] . $this->fileDir, $saveName ) )
            {
                $zipRes = 0; // 压缩成功，成功之后删除sql文件
            }
            else
           {
                $zipRes = 1; // 压缩失败
            }
        }
        elseif( !$backupOpt && !$image && !$sql )
        { // 既没有选中全选也没有选中任何一个内容，报错
            $zipRes = 2; // 请至少选择一个备份的内容
        }
        //执行完压缩后删除生成的sql文件夹及其中的sql文件（如果存在的话）
        if( is_dir( $sqlDir ) )
        {
            FileUtils::delDirAndFile( $sqlDir );
        }
        return $zipRes;
    }
    
    
    /**
     * @author( author='New' )
     * @date( date = '2016-4-14' )
     * @comment( comment = '导出数据库文件' )
     * @method( method = 'exportDb' )
     * @op( op = '' )
     */
    private function exportDb( $backupOpt, $sql, $sqlDir, $sqlName )
    {
        $arrConfig = $this->config[ 'database' ];
        
        if( is_dir( $sqlDir ) )
        { // 判断文件夹是否存在
            if( !is_readable( $sqlDir ) || !is_writable( $sqlDir ) )
            { // 判断是否有读写权限，没有则赋予其读写权限
                chmod( $sqlDir, 0777 );
            }
        }
        else
       { // 没有则创建文件夹，并赋予其读写权限
            mkdir( $sqlDir, 0777 );
        }
        $exportDbRes = ExportDbUtils::dbDump( $arrConfig[ 'host' ], $arrConfig[ 'username' ],
                $arrConfig[ 'password' ], $arrConfig[ 'dbname' ], array( 'fcms_backup' ), $sqlName );
        
        return $exportDbRes;//0为成功，1、2都为失败
    }
    
    
    /**
     * @author( author='New' )
     * @date( date = '2016-4-14' )
     * @comment( comment = '显示备份设置页面' )	
     * @method( method = 'backupSetting' )
     * @op( op = '' )		
    */
    public function backupSettingAction()
    {
    	$this->view->backupDir = $this->config[ 'backupDir' ];
     	$this->view->pick( 'backup/backupSetting' );
    }
    
    
    /**
     * @author( author='New' )
     * @date( date = '2016-4-14' )
     * @comment( comment = '改变备份路径' )	
     * @method( method = 'changeBackupDir' )
     * @op( op = '' )		
    */
    public function changeBackupDirAction()
    {
        $this->csrfCheck();
        
    	if( $dir = $this->request->getPost( 'backupDir' ) )
    	{
    		$dirPattern = '/(((https|http|ftp|rtsp|mms){1}\:\/\/)|(\/))?[\d\w\-]{1,}([\.\/\?\&\=]{1}[\d\w\-]{1,}){1,}(\/)?/';
    		if( preg_match( $dirPattern, $dir ) )
    		{
    		    if( preg_match( '/.*\/$/', $dir ) )
    		    {//是以/结尾，则继续判断
    		        if( preg_match( '/(.*[^\/]{1}\/{1})(\/{1,})$/', $dir, $matches ) )
    		        {//不止1个/结尾
    		        	$dir = $matches[ 1 ];
    		        }
    		    }
    		    else
    		    {//不是以/结尾，则加上一个/
    		        $dir = $dir . '/';
    		    }
    		    
    		    $config = APP_ROOT . 'config/config.php';
    		    $dirStr = file_get_contents( $config );
    		    $configPattern = '/[\'\"]\s*backupDir\s*[\'\"]\s*\=\>\s*[\'\"]\s*((((https|http|ftp|rtsp|mms){1}\:\/\/)|(\/))?[\d\w\-]{1,}([\.\/\?\&\=]{1}[\d\w\-]{1,}){1,})(\/)?\s*[\'\"]/';
    		    if( $replace = preg_replace( $configPattern, "'backupDir' => '$dir'", $dirStr ) )
    		    {
        		    file_put_contents( $config, $replace );
        		    $ret[ 'state' ] = 0;//设置成功
        		    $ret[ 'dir' ] = $dir;
    		    }
    		    else
    		    {
    		        $ret[ 'state' ] = 1;//设置失败，请重新设置
    		    }
    		}
    		else
    		{
    		    $ret[ 'state' ] = 2;//输入的路径非法，请重新设置
    		}
    	}
    	else
    	{
    	    $ret[ 'state' ] = 3;//信息发送失败，请重新设置
    	}
    	
    	$ret[ 'key' ] = $this->security->getTokenKey();
    	$ret[ 'token' ] = $this->security->getToken();
    	
    	echo json_encode( $ret );
    }
    
    /**
     * @author( author='New' )
     * @date( date = '2016-4-16' )
     * @comment( comment = '恢复数据' )	
     * @method( method = 'reverse' )
     * @op( op = '' )		
    */
    public function reverseAction()
    {
        $id = intval( $this->dispatcher->getParam( 'id', 'int' ) );
        
        if( $id )
        {
            $where = [
                'columns'    => 'name,type,addtime',
                'conditions' => 'id=?0 and delsign=?1',
                'bind'       => [ $id, SystemEnums::DELSIGN_NO ]
            ];
            $backupObj = Backup::findFirst( $where );
            
            if( $backupObj )
            {
                $type = intval( $backupObj->type );
                $name = $backupObj->name;
                $time = date( 'Ymd', strtotime( $backupObj->addtime ) );
                $zipFile = $_SERVER[ 'DOCUMENT_ROOT' ] . $this->saveDir . $time .'/' . $backupObj->name;
                $tmpDir = str_replace( '\\', '/', APP_ROOT . $this->config[ 'tmpReverseDir' ] );//临时存放解压出来的文件的路径
        	    
        	    if( $this->unZip( $zipFile, $tmpDir ) )
        	    {//解压成功
        	        $imageDir = $tmpDir . 'image';//解压出来的图片的路径
        	        $imageAimDir = $_SERVER[ 'DOCUMENT_ROOT' ] . $this->fileDir . 'image/';
        	        if( !is_dir( $imageAimDir ) )
        	        {//如果将要保存的路径不存在，则创建该路径
        	            $dirArr = [];
        	        	$this->createDir( $this->fileDir . 'image/', $dirArr );
        	        }
        	        $sqlName = substr_replace( $backupObj->name, 'sql', -3, 3 );//解压出来的sql文件的路径
        	        switch( $type )
        	        {
        	        	case 0://全备份
        	        	    $state = ( $this->reverseImage( $imageDir, $_SERVER[ 'DOCUMENT_ROOT' ] . $this->fileDir . 'image/' ) && $this->reverseSql( $tmpDir, $sqlName ) )?1:0;
        	        	    break;
        	        	case 1://只有图片
        	        	    $state = $this->reverseImage( $imageDir, $_SERVER[ 'DOCUMENT_ROOT' ] . $this->fileDir . 'image/' )?1:0;
        	        	    break;
        	        	case 2://只有sql
        	        	    $state = $this->reverseSql( $tmpDir, $sqlName )?1:0;
        	        	    break;
        	        }
        	        
        	        //删除tmp文件
    	            FileUtils::delDirAndFile(  APP_ROOT . $this->config[ 'tmpReverseDir' ] );
    	            
        	        if( $state )
        	        {//恢复成功
        	            $ret[ 'state' ] = 0;
        	        }
        	        else
        	       {//恢复失败
        	           $ret[ 'state' ] = 4;
        	        }
        	    }
        	    else
        	    {//解压失败
        	        $ret[ 'state' ] = 3;//文件解压缩失败，请检查
        	    }
        	    
            }
            else
           {
               $ret[ 'state' ] = 2;//该数据在数据库中不存在，请检查
            }
            
        }
        else
        {
        	$ret[ 'state' ] = 1;//参数传递失败
        }
        echo json_encode( $ret );
    }
    
    
    /**
     * @author( author='New' )
     * @date( date = '2016-4-16' )
     * @comment( comment = '恢复图片' )	
     * @method( method = 'reverseImage' )
     * @op( op = '' )		
    */
    private function reverseImage( $floder, $aimFolder )
    {
        if( $floder )
        {//如果文件夹存在
            FileUtils::moveDir( $floder, $aimFolder );
            return true;
        }
        else
       {
        	return false;
        }
    }
    
    
    /**
     * @author( author='New' )
     * @date( date = '2016-4-16' )
     * @comment( comment = '恢复数据库' )
     * @method( method = 'reverseSql' )
     * @op( op = '' )
     */
    private function reverseSql( $tmpDir, $sqlName )
    {
        if( $tmpDir )
        {//如果文件存在
        	if( is_dir( $tmpDir . 'sql' ) )
        	{//如果sql文件夹存在，说明是选择的全备份；如果不存在该文件夹，说明是只有sql文件
        		$file = $tmpDir . 'sql/' . $sqlName;
        	}
        	else
        	{
        		$file = $tmpDir . $sqlName;
        	}
        	
    		$link = @mysql_connect( $this->config[ 'database' ][ 'host' ], $this->config[ 'database' ][ 'username' ], $this->config[ 'database' ][ 'password' ] );//指定数据库连接参数
    		$ImportDbUtiles = new ImportDbUtils();
    		return $ImportDbUtiles->importDb( $link, $file, $this->config[ 'database' ][ 'dbname' ] );
        }
        else
        {
        	return false;
        }
    }
    
    
    /**
     * @author( author='New' )
     * @date( date = '2016-4-16' )
     * @comment( comment = '解压缩zip文件' )	
     * @method( method = 'unZip' )
     * @op( op = '' )		
    */
    private function unZip( $file, $des )
    { 
        if( !is_dir( $des ) )
        {
        	mkdir( $des, 0777 );
        }
        $zip = new \ZipArchive(); 
        //打开zip文档，如果打开失败返回提示信息 
        if( $zip->open( $file ) !== true )
        { 
            die( "zip文件打开失败" ); 
        } 
        //将压缩文件解压到指定的目录下 
        $des = iconv( "utf-8", "gb2312", $des );
        $res = $zip->extractTo( $des );
        //关闭zip文档 
        $zip->close(); 
        
        return $res;
    }
    
    
    /**
     * @author( author='New' )
     * @date( date = '2016-4-19' )
     * @comment( comment = '循环创建所需要的路径' )	
     * @method( method = 'createDir' )
     * @op( op = '' )		
    */
    private function createDir( $dir, $dirArr )
    {
        if( !is_dir( APP_ROOT . $dir ) )
        {//如果路径不存在，则将该路径名存到数组中，以供以后创建
            array_push( $dirArr, APP_ROOT . $dir );
            $nextDir = dirname( $dir );
            $this->createDir( $nextDir, $dirArr );
        }
        else
       {//如果路径已经存在，则创建之前保存在数组中的未创建的路径（当然是先判断原先是否保存了未创建的路径，如果没有就不需要创建）
            if( $dirArr )
            {
                $dirArr = array_reverse( $dirArr );
                foreach( $dirArr as $emptyDir )
                {
                    mkdir( $emptyDir, 0777 );
                }
            }
        }
    }
    
    
    public function testAction()
    {
        $dir = $this->config[ 'backupDir' ];
        $dirArr = array();
        $this->createDir( $dir, $dirArr );
    }
    
    
    
}
