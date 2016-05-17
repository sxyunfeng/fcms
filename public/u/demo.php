
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1"><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>
	UEditor演示
</title>
    <script src="jquery-1.10.2.min.js"></script>
    <script src="ueditor.config.js"></script>
    <script src="ueditor.all.js"></script>
    <style type="text/css">
        a { color: #444; text-decoration: none; margin: 0; padding: 0; }
        dl { width: 800px; margin: 10px auto; float: left; font-size: 12px; }
            dl dt { width: 340px; float: left; }
                dl dt input { width: 300px; }
            dl dd { width: 130px; float: left; margin: 0; }
                dl dd a { display: inline-block; width: 72px; height: 28px; text-align: center; line-height: 28px; border: #ddd; }
                dl dd img { width: 90px; height: 60px; }
        .editor { width: 800px; height: 300px; float: left; }
    </style>
</head>
<body>
<?php //phpinfo()?>
    <div>
        <dl>
            <dt><span>图片：</span><input type="text" id="picture" name="cover" /></dt>
            <dd><a href="javascript:void(0);" onclick="upImage();">上传图片</a></dd>
            <dd>
                <img id="preview" src="images/nopic.gif" /></dd>
        </dl>
        <dl>
            <dt><span>文件：</span><input type="text" id="file" /></dt>
            <dd><a href="javascript:void(0);" onclick="upFiles();">上传文件</a></dd>
        </dl>
        <div class="editor">
            <script type="text/plain" id="myEditor"></script>
            <script type="text/plain" id="upload_ue"></script>
        </div>
    </div>
    <?php 
$di = new \Phalcon\DI\FactoryDefault();

$di->set( 'session', function(){
 	$session = new \Phalcon\Session\Adapter\Libmemcached( array(
 		'servers' => array(
 		array( 'host' => '127.0.0.1', 'port' => 11211, 'weight' => 1 )
 	),
 		'client' => array(
 			Memcached::OPT_HASH => Memcached::HASH_MD5,
 			Memcached::OPT_PREFIX_KEY => 'huaer.'
 		),
 			'lifetime' => 3600,
 			'prefix' => 'huaer_'
 	));
 	session_set_cookie_params( 3600, '/', '.huaer.dev' );
 	ini_set("session.cookie_httponly", 1);
 	
 	$session->start();
 	
	return $session;
}, true );
?>
    <script type="text/javascript">
        //编辑器
        var editor = UE.getEditor('myEditor', {
            initialFrameWidth: 800,
            initialFrameHeight: 400,
            minFrameHeight: 400,
            initialStyle: 'body{font-size:12px}',
            topOffset: 200,
            sid: '<?php echo $di->get( 'session' )->getId();?>',
            serverUrl:'http://www.huaer.dev/common/img/',
        	bizt:'mem'
        });
        //上传独立使用
        var _editor = UE.getEditor('upload_ue',{ sid: '<?php echo $di->get( 'session' )->getId();?>',
            	bizt:'mem'} );
        _editor.ready(function () {
            _editor.hide();
            _editor.addListener('beforeInsertImage', function (t, arg) {     //侦听图片上传
                alert( 'beforeInsert' );
                $("#picture").attr("value", arg[0].src);                      //将地址赋值给相应的input
                $("#preview").attr("src", arg[0].src);
            });

            _editor.addListener( 'afterinsertimage', function( t, arg ){
                alert( 'afterinsertimage' );
                });
            _editor.addListener('afterUpfile', function (t, arg) {
          	  alert(  'afterUpfile' );
                $("#file").attr("value", _editor.options.UEDITOR_HOME_URL + arg[0].url);
            });

            _editor.setDisabled( [ 'insertimage', 'attachment' ]);
            
        });
        function upImage() {
            var myImage = _editor.getDialog("insertimage");
            myImage.open();
            
        }
        function upFiles() {
            var myFiles = _editor.getDialog("attachment");
            myFiles.open();
        }
    </script>
</body>
</html>