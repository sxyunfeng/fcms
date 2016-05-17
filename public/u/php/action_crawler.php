<?php
exit( 'Access Deny!' );
/**
 * 抓取远程图片
 * User: Jinqn
 * Date: 14-04-14
 * Time: 下午19:18
 */
set_time_limit(0);
include("Uploader.class.php");

global $session;

if( !($session->get( 'memInfo' ) || $session->get( 'userInfo' ) ))
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
            $uid = $memInfo['id'];
        }
        break;
    case 'shop':
        $shopInfo = $session->get( 'shop_id' );
        if( $shopInfo )
        {
            $uid = $shopInfo['shop_id'];
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

$path = str_replace( "{uid}", $uid, $CONFIG['catcherPathFormat'] );
$path = str_replace( "{bizt}", $_GET[ 'bizt' ], $path );
/* 上传配置 */
$config = array(
    "pathFormat" => $path,
    "maxSize" => $CONFIG['catcherMaxSize'],
    "allowFiles" => $CONFIG['catcherAllowFiles'],
    "oriName" => "remote.png"
);
$fieldName = $CONFIG['catcherFieldName'];

/* 抓取远程图片 */
$list = array();
if (isset($_POST[$fieldName])) {
    $source = $_POST[$fieldName];
} else {
    $source = $_GET[$fieldName];
}
foreach ($source as $imgUrl) {
    $item = new Uploader($imgUrl, $config, "remote");
    $info = $item->getFileInfo();
    array_push($list, array(
        "state" => $info["state"],
        "url" => $info["url"],
        "size" => $info["size"],
        "title" => htmlspecialchars($info["title"]),
        "original" => htmlspecialchars($info["original"]),
        "source" => htmlspecialchars($imgUrl)
    ));
}

/* 返回抓取数据 */
return json_encode(array(
    'state'=> count($list) ? 'SUCCESS':'ERROR',
    'list'=> $list
));