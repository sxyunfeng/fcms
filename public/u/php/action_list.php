<?php
/**
 * 获取已上传的文件列表
 * User: Jinqn
 * Date: 14-04-09
 * Time: 上午10:17
 */
include "Uploader.class.php";

global $di;
$session = $di->get( 'session' );
if( !( $session->get( 'memInfo' ) || $session->get( 'userInfo' ) ))
{
	echo '先登陆后才能上传图片';
	return;
}
$uid = 0;
switch( $_GET['bizt'] )
{
	case 'mem':
        $memInfo = $session->get( 'memInfo' );
            
        if( $memInfo )
        {
            $uid = $memInfo['mem_id'];
        }
        break;
    case 'shop':
        $userInfo = $session->get( 'userInfo' );
        if( $userInfo )
        {
            $uid = $userInfo['shopid'];
        }

        break;
    case 'user':
        $userInfo = $session->get( 'userInfo' );
        if( $userInfo )
        {
            $uid = $userInfo['id'];
        }
    break;
    case 'article':
    	$userInfo = $session->get( 'userInfo' );
    	if( $userInfo )
    	{
    		$uid = $userInfo['id'];
    	}
    break;
}
/* 判断类型 */
switch ($_GET['action']) {
    /* 列出文件 */
    case 'listfile':
        $allowFiles = $CONFIG['fileManagerAllowFiles'];
        $listSize = $CONFIG['fileManagerListSize'];
        
         $path = $CONFIG['fileManagerListPath'];
         $path = str_replace( "{uid}", $uid, $CONFIG['fileManagerListPath'] );
         $path = str_replace( "{bizt}", $_GET[ 'bizt' ], $path );
        break;
    /* 列出图片 */
    case 'listimage':
    default:
        $allowFiles = $CONFIG['imageManagerAllowFiles'];
        $listSize = $CONFIG['imageManagerListSize'];
        
        $path = $CONFIG['imageManagerListPath'];
        $path = str_replace( "{uid}", $uid, $CONFIG['imageManagerListPath'] );
        $path = str_replace( "{bizt}", $_GET[ 'bizt' ], $path );
}
$allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);

/* 获取参数 */
$size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : $listSize;
$start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : 0;
$end = $start + $size;

/* 获取文件列表 */


$rootPath =  $_SERVER['DOCUMENT_ROOT'];
if( strpos( $rootPath, 'public' ) === false )
{
    $rootPath .= '/public';
}
$path =  $rootPath . (substr($path, 0, 1) == "/" ? "":"/") . $path;
$a = array();
$files = getfiles( $path, $allowFiles, $a, $size );

if (!count($files)) {
    return json_encode(array(
        "state" => "no match file",
        "list" => array(),
        "start" => $start,
        "total" => count($files)
    ));
}
// var_dump( $files );
/* 获取指定范围的列表 */
// $len = count($files);

// for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--){
//     $list[] = $files[$i];
// }

$len = count($files);
for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--){
    $list[] = $files[$i];
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


/**
 * 遍历获取目录下的指定类型的文件
 * @param $path
 * @param array $files
 * @return array
 */
function getfiles( $path, $allowFiles,  &$files = array(),$iSize = 0 )
{
    global $editorConfig;
    
    if( $editorConfig[ 'type' ] )
    {
         global $di;
    
        $mdb = $di->get( 'mongodb' );
        $session = $di->get( 'session' );

        $uid = 0;
        switch( $_GET['bizt'] )
        {
            case 'mem':
                $memInfo = $session->get( 'memInfo' );
                if( $memInfo )
                {
                    $uid = $memInfo['mem_id'];
                }
                $mem = $mdb->selectCollection( 'mem' );
                break;
            case 'shop':
                $userInfo = $session->get( 'userInfo' );
                if( $userInfo )
                {
                    $uid = $userInfo['shop_id'];
                }
                $shop = $mdb->selectCollection( 'shop' );
                break;
            case 'user':
                $userInfo = $session->get( 'userInfo' );
                if( $userInfo )
                {
                    $uid = $userInfo['id'];
                }
                $user = $mdb->selectCollection( 'user' );
               break;
            case 'article':
             	$userInfo = $session->get( 'userInfo' );
               	if( $userInfo )
               	{
               		$uid = $userInfo['id'];
               	}
               	$article = $mdb->selectCollection( 'article' );
            break;
               
        }
        if( !$iSize )
            return iterator_to_array( $user->find( array( 'uid' => $uid ))->sort( array( 'addtime' => -1 ) ));
        else 
           return iterator_to_array( $user->find( array( 'uid' => $uid ))->sort( array( 'addtime' => -1 ) )->limit( $iSize ));
        
    }
    else
    {
        if (!is_dir($path)) return null;
        if(substr($path, strlen($path) - 1) != '/') $path .= '/';
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $path2 = $path . $file;
                
                if (is_dir($path2)) {
                    getfiles($path2, $allowFiles, $files, 0);
                } else {
                    if (preg_match("/\.(".$allowFiles.")$/i", $file)) {
                        $rootPath = $_SERVER['DOCUMENT_ROOT'];
                        if( strpos( $rootPath, 'public' ) === false )
                        {
                            $rootPath .= '/public';
                        }
                        $files[] = array(
                            'url'=> substr($path2, strlen($rootPath)),
                            'mtime'=> filemtime($path2)
                        );
                    }
                }
            }
        }
       return $files;
    }
   
    
   
}
