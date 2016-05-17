<?php
/**
 * 文件上传类
 * 暂不提供文件删除功能
 * 
 * @author bruce
 */
namespace apps\common\libraries;

!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );


/**
 * Created by JetBrains PhpStorm.
 * User: taoqili
 * Date: 12-7-18
 * Time: 上午11: 32
 * UEditor编辑器通用上传类
 */
class Uploader implements \Phalcon\Di\InjectionAwareInterface
{
	private $di;
    private $fileField; //文件域名
    private $file; //文件上传对象
    private $base64; //文件上传对象
    private $config; //配置信息
    private $oriName; //原始文件名
    private $fileName; //新文件名
    private $fullName; //完整文件名,即从当前配置目录开始的URL
    private $filePath; //完整文件名,即从当前配置目录开始的URL
    private $fileSize; //文件大小
    private $fileType; //文件类型
    private $stateInfo; //上传状态信息,
    private $group_name;//group name
    
    private $configEditor;//ueditor配置
    
    private $iEngineType;// 0 for filesystem 1 for fastdfs
    private $objConfigFS;//fs engine configuration
    private $objConfigFastDFS;//fastdfs engine configuraton
    private $objHitServer;//hitted server for upload file only for engine type 0
    
    private $stateMap = array( //上传状态映射表，国际化用户需考虑此处数据的国际化
        "SUCCESS", //上传成功标记，在UEditor中内不可改变，否则flash判断会出错
        "文件大小超出 upload_max_filesize 限制",
        "文件大小超出 MAX_FILE_SIZE 限制",
        "文件未被完整上传",
        "没有文件被上传",
        "上传文件为空",
        "ERROR_TMP_FILE" => "临时文件错误",
        "ERROR_TMP_FILE_NOT_FOUND" => "找不到临时文件",
        "ERROR_SIZE_EXCEED" => "文件大小超出网站限制",
        "ERROR_TYPE_NOT_ALLOWED" => "文件类型不允许",
        "ERROR_CREATE_DIR" => "目录创建失败",
        "ERROR_DIR_NOT_WRITEABLE" => "目录没有写权限",
        "ERROR_FILE_MOVE" => "文件保存时出错",
        "ERROR_FILE_NOT_FOUND" => "找不到上传文件",
        "ERROR_WRITE_CONTENT" => "写入文件内容错误",
        "ERROR_UNKNOWN" => "未知错误",
        "ERROR_DEAD_LINK" => "链接不可用",
        "ERROR_HTTP_LINK" => "链接不是http链接",
        "ERROR_HTTP_CONTENTTYPE" => "链接contentType不正确",
    	"ERROR_HTTP_AUTH" => "登陆后才能上传文件"
    );

    /**
     * 构造函数
     * @param string $fileField 表单名称
     * @param array $config 配置项
     * @param bool $base64 是否解析base64编码，可省略。若开启，则$fileField代表的是base64编码的字符串表单名
     */
    public function __construct($fileField, $config, $type = "upload", $di )
    {
        $this->fileField = $fileField;
        $this->config = $config;
        $this->type = $type;
        $this->di = $di;
        
        $this->configEditor = include APP_ROOT . 'config/ueditor.php';
        
        $this->iEngineType = $this->configEditor->type;
        
        if( !$this->iEngineType )
        {
            $this->objConfigFS = $this->configEditor->fs;
            
            if( $this->objConfigFS->mode == 1 )
            {// for random fs
                $arrPaths = $this->objConfigFS->paths;
            
                $arrRet = array();
                foreach( $arrPaths as $k => $v )
                {
                    if( !$v->full )
                    {
                        $arrRet[] = $v;
                    }
                }
            
                $iSize = count( $arrRet );
            
                $this->objHitServer = $arrRet[ $_SERVER[ 'REQUEST_TIME' ] % $iSize ];
            }
            else 
            {
            	$this->objHitServer = $this->objConfigFS->paths->{ $this->objConfigFS->cur };
            }
            
        }
        else 
        {
            $this->objConfigFastDFS = $this->configEditor->fastdfs;
        }
        
        if ( $type == "remote" ) 
        {
            $this->saveRemote();
        } 
        else if( $type == "base64" ) 
        {
            $this->upBase64();
        } 
        else 
        {
            $this->upFile();
        }
//        $msg =  $this->stateMap['ERROR_TYPE_NOT_ALLOWED'];
//        $this->stateMap['ERROR_TYPE_NOT_ALLOWED'] = iconv( 'GB2312', 'UTF-8',$msg );
    }

    private function saveRecForFastDFS( $arrFileInfo )
    {
        if( !$arrFileInfo )
        {
            echo 'Error!<br>';	
        }
        
        $mdb = $this->di->get( 'mongodb' );
        $session = $this->di->get( 'session' );
        
        $arr = array(
                'ip_addr' => $arrFileInfo[ 'ip_addr' ],
                'group_name' => $arrFileInfo[ 'group_name' ],
                'url' => 'http://' . $arrFileInfo[ 'ip_addr' ] . '/' . $arrFileInfo[ 'group_name' ] . '/' . $arrFileInfo[ 'filename' ],
                'filename' => $arrFileInfo[ 'filename' ],
                'createtime' => $_SERVER[ 'REQUEST_TIME' ],
                'updatetime' => 0
        );
        
        $uid = 0;
        switch( $_GET['bizt'] )
        {
        	case 'mem':
        	    $memInfo = $session->get( 'memInfo' );
        	    if( $memInfo )
        	    {
        	        $uid = $memInfo['id'];
        	    }
        
        	    $mem = $mdb->selectCollection( 'fastdfs_mem' );
        	    $arr[ 'uid' ] = $uid;
        	    $mem->insert( $arr );
        	    break;
        	case 'shop':
        	    $userInfo = $session->get( 'userinfo' );
        	    if( $userInfo )
        	    {
        	        $uid = $userInfo['shop_id'];
        	    }
        
        	    $shop = $mdb->selectCollection( 'fastdfs_shop' );
        	    $arr[ 'uid' ] = $uid;
        	    $shop->insert( $arr );
        	    break;
        	case 'user':
        	    $userInfo = $session->get( 'userInfo' );
        	    if( $userInfo )
        	    {
        	        $uid = $userInfo['id'];
        	    }
        
        	    $user = $mdb->selectCollection( 'fastdfs_user' );
        	    $arr[ 'uid' ] = $uid;
        	    $user->insert( $arr );
        	    break;
        }
        
    }
    
    private function saveRecForFS()
    {
        $mdb = $this->di->get( 'mongodb' );
        
        $arr = array( 
                    "url" => $this->objHitServer->url . $this->fullName,
                    "title" => $this->fileName,
                    "original" => $this->oriName,
                    "type" => $this->fileType,
                    "size" => $this->fileSize,
                    "createtime" => $_SERVER[ 'REQUEST_TIME' ]
                );
                
                
        $session = $this->di->get( 'session' );
    
        $uid = 0;
        switch( $_GET['bizt'] )
        {
        	case 'mem':
        	    $memInfo = $session->get( 'memInfo' );
        	    if( $memInfo )
        	    {
        	        $uid = $memInfo['id'];
        	    }
    
        	    $mem = $mdb->selectCollection( 'fs_mem' );
        	    $arr[ 'uid' ] = $uid;
        	    $mem->insert( $arr );
        	    break;
        	case 'shop':
        	    $userInfo = $session->get( 'userinfo' );
        	    if( $userInfo )
        	    {
        	        $uid = $userInfo['shop_id'];
        	    }
    
        	    $shop = $mdb->selectCollection( 'fs_shop' );
        	    $arr[ 'uid' ] = $uid;
        	    $shop->insert( $arr );
        	    break;
        	case 'user':
        	    $userInfo = $session->get( 'userInfo' );
        	    if( $userInfo )
        	    {
        	        $uid = $userInfo['id'];
        	    }
    
        	    $user = $mdb->selectCollection( 'fs_user' );
        	    $arr[ 'uid' ] = $uid;
        	    $user->insert( $arr );
        	    break;
        }
    
    }
    
    
    /**
     * 上传文件的主处理方法
     * @return mixed
     */
    private function upFile()
    {
        $file = $this->file = $_FILES[$this->fileField];
        if (!$file) {
            $this->stateInfo = $this->getStateInfo("ERROR_FILE_NOT_FOUND");
            return;
        }
        if ($this->file['error']) {
            $this->stateInfo = $this->getStateInfo($file['error']);
            return;
        } else if (!file_exists($file['tmp_name'])) {
            $this->stateInfo = $this->getStateInfo("ERROR_TMP_FILE_NOT_FOUND");
            return;
        } else if (!is_uploaded_file($file['tmp_name'])) {
            $this->stateInfo = $this->getStateInfo("ERROR_TMPFILE");
            return;
        }

        $this->oriName = $file['name'];
        $this->fileSize = $file['size'];
        $this->fileType = $this->getFileExt();
        
        //检查文件大小是否超出限制
        if (!$this->checkSize()) {
            $this->stateInfo = $this->getStateInfo("ERROR_SIZE_EXCEED");
            return;
        }

        //检查是否不允许的文件格式
        if (!$this->checkType()) {
            $this->stateInfo = $this->getStateInfo("ERROR_TYPE_NOT_ALLOWED");
            return;
        }

        
        if( $this->iEngineType )
        {
            $this->saveWithFastDFS( $file["tmp_name"], trim( $this->fileType, '.' ));
        }
        else 
        {
        	$this->saveWithFS( $file["tmp_name"], trim( $this->fileType, '.' ) );
        }
        
    }

    /**
     * 处理base64编码的图片上传
     * @return mixed
     */
    private function upBase64()
    {
        $base64Data = $_POST[$this->fileField];
        $img = base64_decode($base64Data);

        $this->oriName = $this->config['oriName'];
        $this->fileSize = strlen($img);
        $this->fileType = $this->getFileExt();

        //检查文件大小是否超出限制
        if (!$this->checkSize()) {
            $this->stateInfo = $this->getStateInfo("ERROR_SIZE_EXCEED");
            return;
        }

        if( $this->iEngineType )
        {
            $this->saveWithFastDFS( $img, trim( $this->fileType, '.' ), false );
        }
        else
        {
            $this->saveWithFS( $img, trim( $this->fileType, '.' ), false );
        }
        
    }

    /**
     * 拉取远程图片
     * @return mixed
     */
    private function saveRemote()
    {
        $imgUrl = htmlspecialchars($this->fileField);
        $imgUrl = str_replace("&amp;", "&", $imgUrl);

        //http开头验证
        if (strpos($imgUrl, "http") !== 0) {
            $this->stateInfo = $this->getStateInfo("ERROR_HTTP_LINK");
            return;
        }
        //获取请求头并检测死链
        $heads = get_headers($imgUrl);
        if (!(stristr($heads[0], "200") && stristr($heads[0], "OK"))) {
            $this->stateInfo = $this->getStateInfo("ERROR_DEAD_LINK");
            return;
        }
        //格式验证(扩展名验证和Content-Type验证)
        $fileType = strtolower(strrchr($imgUrl, '.'));
        if (!in_array($fileType, $this->config['allowFiles']) || stristr($heads['Content-Type'], "image")) {
            $this->stateInfo = $this->getStateInfo("ERROR_HTTP_CONTENTTYPE");
            return;
        }

        //打开输出缓冲区并获取远程图片
        ob_start();
        $context = stream_context_create(
            array('http' => array(
                'follow_location' => false // don't follow redirects
            ))
        );
        readfile($imgUrl, false, $context);
        $img = ob_get_contents();
        ob_end_clean();
        preg_match("/[\/]([^\/]*)[\.]?[^\.\/]*$/", $imgUrl, $m);

        $this->oriName = $m ? $m[1]:"";
        $this->fileSize = strlen($img);
        $this->fileType = $this->getFileExt();


        //检查文件大小是否超出限制
        if (!$this->checkSize()) {
            $this->stateInfo = $this->getStateInfo("ERROR_SIZE_EXCEED");
            return;
        }

        if( $this->iEngineType )
        {
            $this->saveWithFastDFS( $img, trim( $this->fileType, '.' ), false );
        }
        else
        {
            $this->saveWithFS( $img, trim( $this->fileType, '.' ), false );
        }
        
    }

    /**
     * 使用fastdfs保存文件
     * @param array $arrFileInfo
     * @param int $iType // 0 for file content 1 for file path
     * 
     */
    private function saveWithFastDFS( $strParam, $strExt = null, $bFilePath = true )
    {
        if( $bFilePath )
        {
            $arrFileInfo = FastDFSClient::uploadFile( $strParam, $strExt );
        }
        else 
        {
            $arrFileInfo = FastDFSClient::uploadFileByStuff( $strParam, $strExt );
        }
        
        if( $arrFileInfo !== false )
        {
            $this->stateInfo = 'FAIL';
        }
        
        $this->stateInfo = 'SUCCESS';
        $this->fullName = 'http://' . $arrFileInfo[ 'ip_addr' ] . '/' . $arrFileInfo[ 'group_name' ] . '/' . $arrFileInfo[ 'filename' ];
        $this->fileName = $arrFileInfo[ 'filename' ];
        $this->group_name = $arrFileInfo[ 'group_name' ];
        $this->ipAddr = $arrFileInfo[ 'ip_addr' ];
        
        $this->saveRecForFastDFS( $arrFileInfo );
    }
    
    /**
     * 使用file system保存文件
     * @param unknown $arrFileInfo
     */
    private function saveWithFS( $strParam, $strExt = null, $bFilePath = true )
    { 
        $this->fullName = $this->getFullName();
        $this->filePath = $this->getFilePath();
        $this->fileName = $this->getFileName();
        $dirname = dirname($this->filePath);

        //创建目录失败
        if (!file_exists($dirname) && !mkdir($dirname, 0777, true)) 
        {
            $this->stateInfo = $this->getStateInfo("ERROR_CREATE_DIR");
            echo $dirname;
            return;
        } 
        else if (!is_writeable($dirname)) 
        {
            $this->stateInfo = $this->getStateInfo("ERROR_DIR_NOT_WRITEABLE");
            return;
        }
    
        if( $bFilePath )
        {
            //移动文件
            if (!(move_uploaded_file( $strParam, $this->filePath ) && file_exists($this->filePath))) 
            { //移动失败
                $this->stateInfo = $this->getStateInfo("ERROR_FILE_MOVE");
            } 
            else 
            { //移动成功
                $this->stateInfo = $this->stateMap[0];
            }
        }
        else 
        {
            //移动文件
            if (!(file_put_contents( $this->filePath, $strParam ) && file_exists($this->filePath))) 
            { //移动失败
                $this->stateInfo = $this->getStateInfo("ERROR_WRITE_CONTENT");
            } 
            else 
            { //移动成功
                $this->stateInfo = $this->stateMap[0];
            }
        }
        
        $this->saveRecForFS();
        
    }
    
    
    /**
     * 上传错误检查
     * @param $errCode
     * @return string
     */
    private function getStateInfo($errCode)
    {
        return !$this->stateMap[$errCode] ? $this->stateMap["ERROR_UNKNOWN"] : $this->stateMap[$errCode];
    }

    /**
     * 获取文件扩展名
     * @return string
     */
    private function getFileExt()
    {
        return strtolower(strrchr($this->oriName, '.'));
    }

    /**
     * 重命名文件
     * @return string
     */
    private function getFullName()
    {
        //替换日期事件
        $t = $_SERVER[ 'REQUEST_TIME' ];
        $d = explode('-', date("Y-y-m-d-H-i-s"));
        $format = $this->config["pathFormat"];
        $format = str_replace("{yyyy}", $d[0], $format);
        $format = str_replace("{yy}", $d[1], $format);
        $format = str_replace("{mm}", $d[2], $format);
        $format = str_replace("{dd}", $d[3], $format);
        $format = str_replace("{hh}", $d[4], $format);
        $format = str_replace("{ii}", $d[5], $format);
        $format = str_replace("{ss}", $d[6], $format);
        $format = str_replace("{time}", $t, $format);

        $session = $this->di->get( 'session' );
        if( !$session->get( 'memInfo' ) && !$session->get( 'userInfo' ) )
        {
            $this->stateInfo = $this->getStateInfo("ERROR_HTTP_AUTH");
            return;
        }   
        
        $uid = 0;
        switch( $_GET['bizt'] )
        {
        	case 'mem':
                $memInfo = $session->get( 'memInfo' );
                if( $memInfo )
                {
                    $uid = $memInfo['id'];
                }
        		break;
        	case 'shop':
                $userInfo = $session->get( 'userinfo' );
                if( $userInfo )
                {
                    $uid = $userInfo['shop_id'];
                }
        		
        		break;
        	case 'user':
                $userInfo = $session->get( 'userInfo' );
                if( $userInfo )
                {
                    $uid = $userInfo['id'];
                }
        		
        		break;
        }
        
        $format = str_replace( "{uid}", $uid, $format );
        $format = str_replace( "{bizt}", $_GET[ 'bizt' ], $format );
        
        //过滤文件名的非法自负,并替换文件名
        $oriName = substr($this->oriName, 0, strrpos($this->oriName, '.'));
        $oriName = preg_replace("/[\|\?\"\<\>\/\*\\\\]+/", '', $oriName);
        $format = str_replace("{filename}", $oriName, $format);

        //替换随机字符串
        $randNum = rand(1, 10000000000) . rand(1, 10000000000);
        if (preg_match("/\{rand\:([\d]*)\}/i", $format, $matches)) {
            $format = preg_replace("/\{rand\:[\d]*\}/i", substr($randNum, 0, $matches[1]), $format);
        }

        $ext = $this->getFileExt();
        return $format . $ext;
    }

    /**
     * 获取文件名
     * @return string
     */
    private function getFileName () 
    {
        return substr($this->filePath, strrpos($this->filePath, '/') + 1);
    }

    /**
     * 获取文件完整路径
     * @return string
     */
    private function getFilePath()
    {
        $fullname = $this->fullName;

        if (substr($fullname, 0, 1) != '/') {
            $fullname = '/' . $fullname;
        }

        return $this->objHitServer->path . $fullname;
    }

    /**
     * 文件类型检测
     * @return bool
     */
    private function checkType()
    {
        return in_array($this->getFileExt(), $this->config["allowFiles"]);
    }

    /**
     * 文件大小检测
     * @return bool
     */
    private function  checkSize()
    {
        return $this->fileSize <= ($this->config["maxSize"]);
    }

    /**
     * 获取当前上传成功文件的各项信息
     * @return array
     */
    public function getFileInfo()
    {
        if( $this->iEngineType )
        {
            return array(
                "state" => $this->stateInfo,
                "url" => $this->fullName,
                "group_name" => $this->group_name,
                "title" => $this->fileName,
                "original" => $this->oriName,
                "type" => $this->fileType,
                "size" => $this->fileSize,
                "ip_addr" => $this->ipAddr,
            );        
        }
        else
        {
            return array(
                "state" => $this->stateInfo,
                "url" => $this->objHitServer->url . $this->fullName,
                "title" => $this->fileName,
                "original" => $this->oriName,
                "type" => $this->fileType,
                "size" => $this->fileSize,
            );        
        }
        
        

    }
    
	/* 
	 * @see \Phalcon\Di\InjectionAwareInterface::setDI()
	 */
	public function setDI( \Phalcon\DiInterface $di ) 
	{
		$this->di = $di;
	}

	/* 
	 * @see \Phalcon\Di\InjectionAwareInterface::getDI()
	 */
	public function getDI() 
	{
		return $this->di;
	}


}
