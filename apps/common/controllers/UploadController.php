<?php

/**
 * 处理图片
 * @author Bruce
 * @date 2015-07-17
 */
namespace apps\common\controllers;
!defined( 'APP_ROOT' ) && exit( 'Direct Access Deny!' );


use apps\common\libraries\Uploader;


class UploadController extends \Phalcon\Mvc\Controller
{

    private $configEditor;
    
    public function initialize()
    {
        $this->configEditor = include APP_ROOT . 'config/ueditor.php';
    }

    /**
     * @comment( value = '测试程序' )
     */
    public function indexAction()
    {
    }

    public function testAction()
    {
        	echo __LINE__;
    }
    
    private function upload( $CONFIG )
    {
        /* 上传配置 */
        $base64 = "upload";
        switch (htmlspecialchars($_GET['action'])) {
        	case 'uploadimage':
        	    $config = array(
        	    "pathFormat" => $CONFIG['imagePathFormat'],
        	    "maxSize" => $CONFIG['imageMaxSize'],
        	    "allowFiles" => $CONFIG['imageAllowFiles']
        	    );
        	    $fieldName = $CONFIG['imageFieldName'];
        	    break;
        	case 'uploadscrawl':
        	    $config = array(
        	    "pathFormat" => $CONFIG['scrawlPathFormat'],
        	    "maxSize" => $CONFIG['scrawlMaxSize'],
        	    "allowFiles" => $CONFIG['scrawlAllowFiles'],
        	    "oriName" => "scrawl.png"
        	            );
        	            $fieldName = $CONFIG['scrawlFieldName'];
        	            $base64 = "base64";
        	            break;
        	case 'uploadvideo':
        	    $config = array(
        	    "pathFormat" => $CONFIG['videoPathFormat'],
        	    "maxSize" => $CONFIG['videoMaxSize'],
        	    "allowFiles" => $CONFIG['videoAllowFiles']
        	    );
        	    $fieldName = $CONFIG['videoFieldName'];
        	    break;
        	case 'uploadfile':
        	default:
        	    $config = array(
        	    "pathFormat" => $CONFIG['filePathFormat'],
        	    "maxSize" => $CONFIG['fileMaxSize'],
        	    "allowFiles" => $CONFIG['fileAllowFiles']
        	    );
        	    $fieldName = $CONFIG['fileFieldName'];
        	    break;
        }
        
        /* 生成上传实例对象并完成上传 */
        $up = new Uploader( $fieldName, $config, $base64, $this->di  );
        
        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
        */
        
        /* 返回数据 */
        return json_encode($up->getFileInfo());
    }
    
    private function listFiles( $CONFIG )
    {
        if( !$this->session->get( 'memInfo' ) && !$this->session->get( 'userInfo' ) )
        {
            echo '先登陆后才能上传图片';
            return;
        }
        
        /* 判断类型 */
        switch ($_GET['action']) {
            /* 列出文件 */
        	case 'listfile':
        	    $allowFiles = $CONFIG['fileManagerAllowFiles'];
        	    $listSize = $CONFIG['fileManagerListSize'];
        
        	    break;
        	    /* 列出图片 */
        	case 'listimage':
        	default:
        	    $allowFiles = $CONFIG['imageManagerAllowFiles'];
        	    $listSize = $CONFIG['imageManagerListSize'];
        }
        $allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);
        
        /* 获取参数 */
        $size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : $listSize;
        $start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : 0;
//         $end = $start + $size;
        
        /* 获取文件列表 */
        if( $this->configEditor->type )
        {
            $files = $this->getFilesRecFromMongDB( $size, false );
        }
        else 
        {
        	$files = $this->getFilesRecFromMongDB( $size, true );
        }
            
        if (!count($files)) {
            return json_encode(array(
                    "state" => "no match file",
                    "list" => array(),
                    "start" => $start,
                    "total" => count($files)
            ));
        }
        
        $list = array();
        foreach( $files as $v )
        {
            $list[] = array( 'url' => $v['url'], 'mtime' => $v[ 'createtime' ] );
        }
        
        //倒序
        //for ($i = $end, $list = array(); $i < $len && $i < $end; $i++){
        //    $list[] = $files[$i];
        //}
        
        /* 返回数据 */
        $result = json_encode(array(
                "state" => "SUCCESS",
                "list" => $list,
                "start" => $start,
                "total" => count($list)
        ));
        
        return $result;
    }
    
    /**
     * 遍历获取目录下的指定类型的文件
     * @param $path
     * @param array $files
     * @return array
     */
    private function getFilesRecFromMongDB( $iSize = 0, $bFS = true )
    {
        $uid = 0;
        
        switch( $_GET['bizt'] )
        {
        	case 'mem':
        	    $memInfo = $this->session->get( 'memInfo' );
        	    if( $memInfo )
        	    {
        	        $uid = $memInfo['id'];
        	    }
        	    
        	    if( $bFS )
        	    {
        	        $mem = $this->mongodb->selectCollection( 'fs_mem' );
        	    }
        	    else 
        	    {
    	           $mem = $this->mongodb->selectCollection( 'fastdfs_mem' );
        	    }
        	    
    	        if( !$iSize )
    	            return iterator_to_array( $mem->find( array( 'uid' => $uid ))->sort( array( 'createtime' => -1 ) ));
    	        else
    	            return iterator_to_array( $mem->find( array( 'uid' => $uid ))->sort( array( 'createtime' => -1 ) )->limit( $iSize ));
        	    
        	case 'shop':
        	    $userInfo = $this->session->get( 'userInfo' );
        	    if( $userInfo )
        	    {
        	        $uid = $userInfo['shop_id'];
        	    }
        	    
        	    if( $bFS )
        	    {
        	        $shop = $this->mongodb->selectCollection( 'fs_shop' );
        	    }
        	    else
        	    {
        	        $shop = $this->mongodb->selectCollection( 'fastdfs_shop' );
        	    }
    	        
    	        if( !$iSize )
    	            return iterator_to_array( $shop->find( array( 'uid' => $uid ))->sort( array( 'createtime' => -1 ) ));
    	        else
    	            return iterator_to_array( $shop->find( array( 'uid' => $uid ))->sort( array( 'createtime' => -1 ) )->limit( $iSize ));
        	        	
        	case 'user':
        	    $userInfo = $this->session->get( 'userInfo' );
        	    if( $userInfo )
        	    {
        	        $uid = $userInfo['id'];
        	    }
        	    
        	    if( $bFS )
        	    {
        	        $user = $this->mongodb->selectCollection( 'fs_user' );
        	    }
        	    else
        	    {
        	        $user = $this->mongodb->selectCollection( 'fastdfs_user' );
        	    }
    	        if( !$iSize )
    	            return iterator_to_array( $user->find( array( 'uid' => $uid ))->sort( array( 'createtime' => -1 ) ));
    	        else
    	            return iterator_to_array( $user->find( array( 'uid' => $uid ))->sort( array( 'createtime' => -1 ) )->limit( $iSize ));
        	default:
        	    return null;
        }
    
    }
    
//     /**
//      * 遍历获取目录下的指定类型的文件
//      * @param $path
//      * @param array $files
//      * @return array
//      */
//     private function getFilesForFS($path, $allowFiles, &$files = array())
//     {
//         if (!is_dir($path)) return null;
//         if(substr($path, strlen($path) - 1) != '/') $path .= '/';
//         $handle = opendir($path);
//         while (false !== ($file = readdir($handle))) {
//             if ($file != '.' && $file != '..') {
//                 $path2 = $path . $file;
//                 if (is_dir($path2)) {
//                     $this->getFilesForFS($path2, $allowFiles, $files);
//                 } else {
//                     if (preg_match("/\.(".$allowFiles.")$/i", $file)) {
//                         $files[] = array(
//                                 'url'=> substr($path2, strlen($this->configEditor->fs->paths{ $this->configEditor->fs->cur }->path)),
//                                 'createtime'=> filemtime($path2)
//                         );
//                     }
//                 }
//             }
//         }
//         return $files;
//     }
    
    
    
    public function ctrlAction()
    {
        date_default_timezone_set( "Asia/chongqing" );
        
        $CONFIG = json_decode( 
                preg_replace( "/\/\*[\s\S]+?\*\//", "", 
                        file_get_contents( APP_ROOT . '/config/' . 'ueditor.json' ) ), true );

        if( $this->session->getId() != $_GET[ 'sid' ] )
        {
            echo '必须登陆后才能上传文件！';
            exit();
        }
        // 设置保存目录
        /*
         *
         * ---------------------------------------------------------------------------------------
         */
        $action = $_GET[ 'action' ];
        
        switch( $action )
        {
            case 'config':
                $result = json_encode( $CONFIG );
                break;
            /* 上传图片 */
            case 'uploadimage':
            /* 上传涂鸦 */
            case 'uploadscrawl':
            /* 上传视频 */
            case 'uploadvideo':
            /* 上传文件 */
            case 'uploadfile':
//                 $result = include ( "action_upload.php" );
                $result = $this->upload( $CONFIG );
                break;
            /* 列出图片 */
            case 'listimage':
            // $result = include("action_list.php");
            // break;
            /* 列出文件 */
            case 'listfile':
//                 $result = include ( "action_list.php" );
                $result = $this->listFiles( $CONFIG );
                
                break;
            /* 抓取远程文件 */
            case 'catchimage':
                $result = include ( "action_crawler.php" );
                break;
            default:
                $result = json_encode( 
                        array(
                                'state' => '请求地址出错'
                        ) );
                break;
        }
        /* 输出结果 */
        if( isset( $_GET[ "callback" ] ) )
        {
            if( preg_match( "/^[\w_]+$/", $_GET[ "callback" ] ) )
            {
                echo htmlspecialchars( $_GET[ "callback" ] ) . '(' . $result .
                         ')';
            }
            else
            {
                echo json_encode( 
                        array(
                                'state' => 'callback参数不合法'
                        ) );
            }
        }
        else
        {
            echo $result;
        }
    }
}