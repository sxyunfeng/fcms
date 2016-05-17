<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/toastr/toastr.min.css">
        <style>
			.col-xs-2{
                padding-right: 0;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation" class="active"><a href="#backupSetting" >备份设置</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" style="padding-top:20px;">
                <form class="form-horizontal">
                    <div class="form-group has-feedback">
                        <label class="col-xs-2 control-label">备份位置</label>
                        <div class="col-xs-3">
                            <input class="form-control" id="backupDir" name="backupDir" value="{% if backupDir is defined %}{{ backupDir | escape_attr }}{% endif %}" />
                        </div>
						<span class="col-xs-5 text-left alertMsg" style="height:34px;line-height:34px;">默认备份到服务器（必须是相对路径且以/结束）</span>
                    </div>
                    
                    
                    <div class="form-group" style="margin-top:30px;">
                        <div class="col-xs-offset-2 col-sm-3">
                            <button type="button" class="btn btn-success btn-sm" id="save" style="margin-right:50px;width:70px;">提交</button>
                            <button type="button" class="btn btn-default btn-sm" id="reset" style="width:70px;">重置</button>
                        </div>
                    </div>
                    
                </form>
                
            </div>
            
        </div>
        
        <div class="alert alert-danger text-center col-xs-2" style="position:fixed; bottom:0; margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>
        
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="/bootstrap/toastr/toastr.min.js"></script>
        <script src="/js/fcmsIndex/iframeStyle.js"></script>
        <script>
		var oldDir = "{% if backupDir is defined %}{{ backupDir | e }}{% else %}''{% endif %}";
		
		var key = '<?php echo $this->security->getTokenKey(); ?>';
        var token = '<?php echo $this->security->getToken(); ?>';
        
		var pattern = /(((https|http|ftp|rtsp|mms){1}\:\/\/)|(\/))?[\d\w\-]{1,}([\.\/\?\&\=]{1}[\d\w\-]{1,}){1,}(\/)?/;

		var obj = $( 'input#backupDir' );
		var objParent = obj.parents( 'div.form-group' );
		
		$( 'input#backupDir' ).blur( function(){
			clear( objParent );
			if( pattern.test( obj.val() ) ){
				if( oldDir == obj.val() ){
					error( objParent );
					errorAlert( objParent, '数据未修改，请勿重复提交' );
				}else{
					success( objParent );
					successAlert( objParent );
				}
			}else{
				error( objParent );
				errorAlert( objParent, '备份位置不合法，请重新输入' );
			}
		} );
		
		//提交
		$( 'button#save' ).click( function(){
			obj.blur();
			if( !$( 'div.form-group' ).hasClass( 'has-error' ) ){
				var data = { 'backupDir' : obj.val(), 'key' : key, 'token' : token };
				$.post( "/admin/backup/changeBackupDir", data, function( ret ){
					switch( parseInt( ret.state ) ){
						case 0:
							toastr.success( '设置成功' );
							clear( objParent );
							$( '#backupDir' ).val( ret.dir );
							oldDir = ret.dir;
							break;
						case 1:
							toastr.error( '设置失败，请重新设置' );
							clear( objParent );
							successAlert( objParent );
							break;
						case 2:
							toastr.error( '备份位置不合法，请重新输入' );
							error( objParent );
							errorAlert( objParent, '备份位置不合法，请重新输入' );
							break;
						case 3:
							toastr.error( '信息发送失败，请重新设置' );
							clear( objParent );
							successAlert( objParent );
							break;
					}
					key = ret.key;
			        token = ret.token;
				}, 'json' );
			}
		} );
		
		/* ----------取消---------------*/
		$( '#reset' ).click( function(){
			obj.val( oldDir );
			clear( objParent );
			successAlert( objParent );
			return false;
		} );
		
	    function success( obj ){
			obj.addClass( 'has-success' ).removeClass( 'has-error' );
	    }
	    
	    function error( obj ){
	        obj.addClass( 'has-error' ).removeClass( 'has-success' );
	    }
	    
	    function clear( obj ){
	    	obj.removeClass( 'has-error' ).removeClass( 'has-success' );
	    }
	    
	    function errorMsg( msg ){
	        $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
	        $( '.alert span' ).text( msg );
	        $( '.alert' ).show().fadeOut( 3000 );
	    }
	    
	    function successMsg( msg ){
	        $( '.alert' ).addClass( 'alert-success' ).removeClass( 'alert-danger' );
	        $( '.alert span' ).text( msg );
	        $( '.alert' ).show().fadeOut( 3000 );
	    }
	    
	    function successAlert( obj ){
	    	obj.find( '.alertMsg' ).html( '默认备份到服务器（必须以/结束）' ).css( 'color', 'black' );
	    }
	    
	    function errorAlert( obj, msg ){
	    	obj.find( '.alertMsg' ).html( msg ).css( 'color', '#BA4442' );
	    }
		    
    	</script>
    </body>
</html>
