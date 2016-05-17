<!DOCTYPE html>
<html lang="zh_CN">
<head>
<title>个人资料</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge" />
<meta name="renderer" content="webkit">
<meta charset="utf-8">
<meta name="description" content="This is page-header">
<meta name="keywords" content="个人资料">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel='icon' href='/public/favicon.ico' mce_href='/public/favicon.ico' type='image/x-icon'>
<link rel='shortcut icon' href='/public/favicon.ico' mce_href='/public/favicon.ico' type='image/x-icon'>
<link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="/public/css/fcmsIndex/user.css">
<link rel="stylesheet" type="text/css" href="/bootstrap/toastr/toastr.min.css">
<style type="text/css">
.user_modal_tr{
	height:50px;
	line-height:50px;
}
.modal-body > table > tr{
	height:50px;
	line-height:50px;
}
.user_psw{
	display:inline-block;
	width:300px;
	margin-left:17px;
}
.has-feedback label ~ .form-control-feedback{
	top:0;
}
.ih-item.circle.effect5 {
    perspective: 900px;
}
.ih-item.circle {
    border-radius: 50%;
    height: 220px;
    position: relative;
    width: 220px;
}
.ih-item, .ih-item * {
    box-sizing: border-box;
}
.ih-item a {
    color: #333;
}
.ih-item, .ih-item * {
    box-sizing: border-box;
}
a {
    color: #428bca;
	outline: medium none;
    text-decoration: none;
	 background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
}
a:hover, a:focus {
    color: #2a6496;
    text-decoration: underline;
}
a:focus {
    outline: thin dotted;
    outline-offset: -2px;
}
.ih-item.circle .img {
    border-radius: 50%;
    height: 220px;
    position: relative;
    width: 220px;
}
.ih-item, .ih-item * {
    box-sizing: border-box;
}
.ih-item.circle .img img {
    border-radius: 50%;
}
.ih-item img {
    height: 100%;
    width: 100%;
}
.ih-item, .ih-item * {
    box-sizing: border-box;
}
img {
    vertical-align: middle;
}
.ih-item.circle.effect5 .info {
    transform-style: preserve-3d;
    transition: all 0.35s ease-in-out 0s;
}
.ih-item.circle .info {
    backface-visibility: hidden;
    border-radius: 50%;
    bottom: 0;
    left: 0;
    position: absolute;
    right: 0;
    text-align: center;
    top: 0;
}
.ih-item, .ih-item * {
    box-sizing: border-box;
}
.ih-item.circle.effect5 .info .info-back {
    backface-visibility: hidden;
    background: rgba(0, 0, 0, 0.6) none repeat scroll 0 0;
    border-radius: 50%;
    height: 100%;
    transform: rotate3d(0, 1, 0, 180deg);
    visibility: hidden;
    width: 100%;
}
.ih-item.circle.effect5 .info h3 {
    color: #fff;
    font-size: 22px;
    height: 110px;
    letter-spacing: 2px;
    margin: 0 30px;
    padding: 55px 0 0;
    position: relative;
    text-shadow: 0 0 1px white, 0 1px 2px rgba(0, 0, 0, 0.3);
    text-transform: uppercase;
}
.ih-item.circle.effect5 .info p {
    border-top: 1px solid rgba(255, 255, 255, 0.5);
    color: #bbb;
    font-size: 12px;
    font-style: italic;
    margin: 0 30px;
    padding: 10px 5px;
}
.ih-item.circle .img::before {
    border-radius: 50%;
    content: "";
    display: block;
    height: 100%;
    position: absolute;
    transition: all 0.35s ease-in-out 0s;
    width: 100%;
}
.ih-item.circle.effect5 a:hover .info {
    transform: rotate3d(0, 1, 0, -180deg);
}
.ih-item.circle.effect5 a:hover .info .info-back {
    visibility: visible;
}
</style>
</head>

<body style="background-color:#ddd;">
	<!-- Modal -->
	<div class="modal fade" id="user_modal" tabindex="-1">
		<div class="modal-dialog" role="document" style="width:400px;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">修改密码</h4>
				</div>
				<div class="modal-body">
					<div class="form-group has-feedback">
                        <label class="control-label">原密码:</label>
                        <input class="form-control user_psw" type="password" id="user_old_psw" name="旧密码" placeholder="请输入密码"/>
                    </div>
					<div class="form-group has-feedback">
                        <label class="control-label">新密码:</label>
                        <input class="form-control user_psw" type="password" id="user_new_psw" name="新密码" placeholder="请输入密码"/>
                    </div>
					<div class="form-group has-feedback">
                        <label class="control-label">确认密码:</label>
                        <input class="form-control user_psw" type="password" id="user_again_psw" name="重复新密码" placeholder="请再次输入密码" style="margin-left:3px;"/>
                    </div>
				</div>
				
				<div class="modal-footer" style="border:none;">
					<button type="button" class="btn btn-primary" id="user_pswconfirm_btn" style="width:70px">确认</button>
					<button type="button" class="btn btn-default" data-dismiss="modal" style="width:70px">取消</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="user_main container-fluid">
		<div class="user_photo">
			<div style="position:relative;display:inline-block;">
            <div class="ih-item circle effect5">
            	<a href="javascript:void(0);" onclick="uploadMyProfile( this );">
	                <div class="img">
	                	<img alt="我的头像" src="{% if userInfo['avatar'] is defined %}{{userInfo['avatar']}}{%else%}/public/img/home/avatar_male.png{% endif %}" />
	                </div>
	                <div class="info">
	                    <div class="info-back">
	                        <h3>我的头像</h3>
	                        <p>点击设置新的头像...</p>
	                    </div>
	                </div>
             	</a>
            </div>
        </div>
	</div>
		
		<div class="user_info">
			<table align="center">
				<tr>
					<td align="left">登录名：</td>
					<td align="right" btn-id="1" class="user_change_info">
						<input btn-id="1" value="{% if userInfo is defined %}{{ userInfo[ 'loginname' ] }}{% else %}visitor{% endif %}" type="text" class="form-control user_info_input" readonly style="background-color:#ddd">
					</td>
				</tr>
				<tr>
					<td align="left">姓名：</td>
					<td align="right" btn-id="2" class="user_change_info">
						<input btn-id="2" value="{% if userInfo is defined %}{{ userInfo[ 'name' ] }}{% else %}visitor{% endif %}" type="text" class="form-control user_info_input" readonly style="background-color:#ddd">
					</td>
					<td align="left">
						<span class="user_change_btn glyphicon glyphicon-pencil" title="change Name" btn-id="2"></span>
					</td>
				</tr>
				<tr>
					<td align="left">昵称：</td>
					<td align="right" btn-id="3" class="user_change_info">
						<input btn-id="3" value="{% if userInfo is defined %}{{ userInfo[ 'nickname' ] }}{% else %}visitor{% endif %}" type="text" class="form-control user_info_input" readonly style="background-color:#ddd">
					</td>
					<td align="left">
						<span class="user_change_btn glyphicon glyphicon-pencil" title="change NickName" btn-id="3"></span>
					</td>
				</tr>
				<tr>
					<td align="left">邮箱：</td>
					<td align="right" btn-id="4" class="user_change_info">
						<input btn-id="4" value="{% if userInfo is defined %}{{ userInfo[ 'email' ] }}{% else %}email{% endif %}" type="text" class="user_info_input form-control" readonly style="background-color:#ddd">
					</td>
					<td align="left">
						<span class="user_change_btn glyphicon glyphicon-pencil" title="change Email" btn-id="4"></span>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<div class="user_hidden_square" style="height:30px;width:100%;"></div>
						<button class="user_confirm_btn">确认</button>
						<button class="user_concel_btn">取消</button>
					</td>
				</tr>
			</table>
		</div>
		
		
		<div class="user_btn row">
			<!-- 上传头像 -->
			<div class="col-xs-offset-4 col-xs-2">
				<span class="glyphicon glyphicon-cloud-upload" title="上传头像"></span>
				<p>上传头像</p>
			</div>
			<!-- 修改资料 -->
			<div class="col-xs-2 user_change_psw">
				<span class="glyphicon glyphicon-pencil" title="修改密码" data-toggle="modal" data-target="#user_modal"></span>
				<p>修改密码</p>
			</div>
		
		</div>
		
	</div>
	
	<script type="text/plain" id="upload_user_header" style="display:none"></script>
	<script src="/js/jquery/jquery-1.11.1.min.js"></script>
	<script src="/bootstrap/3.3.0/js/bootstrap.js"></script>
	<script src="/bootstrap/toastr/toastr.min.js"></script>
	<script src="/js/jsut/md5.js"></script>
	<script src="/u/ueditor.config.js"></script>
    <script src="/u/ueditor.all.js"></script>
    <script type="text/javascript" charset="utf-8" src="/u/lang/zh-cn/zh-cn.js"></script>
	<script>
		var key   = "<?php echo $this->security->getTokenKey();?>";
	 	var token = "<?php echo $this->security->getToken();?>";
		/*---------------图片添加-------*/    
		var _editor = UE.getEditor('upload_user_header',{ 
			bizt:'user',
            serverUrl:'/common/upload/ctrl.php'
		});
	    
		_editor.ready(function () {
			_editor.hide();
			_editor.addListener('beforeInsertImage', function (t, arg) { //侦听图片上传
				if( arg )
				{
					var imgSrc = arg[0].src;
					var objParams = {};
					objParams.src = imgSrc;
					objParams.key = key;
					objParams.token=token;
					
					$.post( '/admin/index/avatar', objParams , function( ret ){
						if( ret.status )
						{
							toastr.error( ret.msg );
							return;
						}
						if( 1 != ret.state )
						{
							toastr.success( ret.msg );
							$( 'div.effect5 a div.img' ).find( 'img' ).attr( 'src' , imgSrc );
							$( 'div.bsc_user div.img img', parent.document ).attr( 'src' , imgSrc )
						}
						else
						{
							toastr.error( ret.msg );
						}
						key = ret.key;
						token = ret.token;
					},'json' );
					window.parent.iframeStyle( 0 );
				}
	        });
	        _editor.setDisabled( [ 'insertimage' ]);
	    });
	    
		/* ------确认退出登录------- */
		$( '.user_logout' ).click( function(){
			if( confirm( '确认要退出登录吗' ) ){
				location.href="/admin/login/logout";
			}
		} );
		
		/* ------点击铅笔修改单项个人常规信息事件------- */
		var btnId = '';
		var oldInfo = '';
		$( '.user_change_btn' ).click( function(){
			var $obj = $( this ).parent().parent();
			$obj.find( 'td > input' ).css( 'background-color', 'rgba(255,255,255,0.8)' );
			btnId = $( this ).attr( 'btn-id' );
			oldInfo = $obj.parent().find( 'tr > td > input' ).attr( 'value' );
			$( ".user_info input[btn-id='" + btnId + "']" ).removeAttr( 'readonly' ).focus();
			$( '.user_hidden_square' ).css( 'display', 'none' );
			$( '.user_confirm_btn,.user_concel_btn' ).css( 'display', 'inline-block' );
		} );
		
		if( 'inline' == $( 'td > input' ).css( 'display' ) ){
			$( 'td > input[btn-id=' + btnId + ']' ).deleblur( function(){
				$( 'td > input' ).css( 'display', 'none' );
				$( 'td > div' ).css( 'display', 'inline' );
			} );
		}
		
		/* ------提交修改信息------- */
		var isCorrect = false;
		var isChange = false;
		$( '.user_confirm_btn' ).click( function(){
			var data = {
				name: $( "input[btn-id='2']" ).val(),
				nickname: $( "input[btn-id='3']" ).val(),
				email: $( "input[btn-id='4']" ).val(),
				key : key,//5
				token:token,//6
			};
			
			//将该值每次点击确认提交时重新初始化，以防止多次修改时isChange失效
			isChange = false;
			//验证数据
			checkData( data );
			//判断成功后做ajax
			if( isCorrect ){
				if( isChange ){
					$.post( '/admin/index/changeuserinfo', data, function( res ){
						//恢复更新前的样式
						$( '.user_info input' ).css( 'background-color', 'rgba(255,255,255,0)' ).attr( 'readonly', 'readonly' );
						$( '.user_hidden_square' ).css( 'display', 'block' );
						$( '.user_confirm_btn,.user_concel_btn' ).css( 'display', 'none' );
						
						//更改父框架中登录信息模块中的内容
						$( '#bsc_user_nickname', parent.document ).html( userInfo[ 'nickname' ] );
						
						//操作提示信息
						switch ( res.state ){
							case 0:
								toastr.success( '数据更新成功' );
								break;
							case 1:
								toastr.error( '数据更新失败' );
								break;
							case 2:
								toastr.error( '数据库中用户信息不存在' );
								break;
							case 3:
								toastr.error( '登录用户信息不存在，请退出后重新登录' );
								break;
							case 4:
								toastr.error( '用户信息发送失败，请重试' );
								break;
						}
						
						key = res.key;
						token = res.token;
					}, 'json' );
				}else{
					$( '.user_info input' ).css( 'background-color', 'rgba(255,255,255,0)' ).attr( 'readonly', 'readonly' );
					$( '.user_hidden_square' ).css( 'display', 'inline-block' );
					$( '.user_confirm_btn,.user_concel_btn' ).css( 'display', 'none' );
				}
			}
		} );

		/* ------从后台取到用户信息数据------- */
		var userInfo = {% if userInfo != empty %}{{ userInfo | json_encode }}{% else %}{{ [] | json_encode }}{% endif %};
		
		/* ------取消修改信息------- */
		$( '.user_concel_btn' ).click( function(){
			$( '.user_info input' ).css( 'background-color', 'rgba(255,255,255,0)' ).attr( 'readonly', 'readonly' );
			$( "input[btn-id='2']" ).val( userInfo[ 'name' ] );
			$( "input[btn-id='3']" ).val( userInfo[ 'nickname' ] );
			$( "input[btn-id='4']" ).val( userInfo[ 'email' ] );
			$( '.user_hidden_square' ).css( 'display', 'inline-block' );
			$( '.user_confirm_btn,.user_concel_btn' ).css( 'display', 'none' );
		} );
		
		/* ------封装验证、判空所修改信息的函数------- */
		function checkData( data ){
			//信息格式包括所有数字、字母、中文、下划线、空格和特殊半角字符，不超过128位
			var pattern = /^[\w\s-(\u0391-\uFFE5)\`\~\!\@\#\$\%\^\&\*\(\)\-\+\=\|\;\:\,\.\?\/\·\￥\…\（\）]{1,128}$/;
			var i = 2;
			for( var name in data ){
				if( i == 5 || i == 6 ){
					continue;
				}
				var value = data[ name ];
				if( 'email' == name ){
					pattern = /^\w+(\.\w+)*@\w+(\.\w+)+$/;
				}
				
				if( pattern.test( value ) ){
					isCorrect = true;
					if( userInfo[ name ] != value ){
						userInfo[ name ] = value;
						isChange = true;
					}
				}else{
					isCorrect = false;
					$( "input[btn-id=" + i + "]" ).focus();
					toastr.error( name + '格式非法，请检查！' );
					break;
				}
				i++;
			}
		}
		
		/*-----------------密码修改----------------*/
		//密码验证
		$( 'input:password' ).blur( function(){
            var objParent = $( this ).parents( '.form-group' );
            objParent.find( 'span.glyphicon' ).remove();
            var value = $( this ).val();
            var id = $( this ).attr( 'id' );
            var pattern = /^[\w\`\~\!\@\#\$\%\^\&\*\(\)\-\+\=\|\;\:\,\.\?\/\·\￥\…\（\）]{6,15}$/;
			if( value ){
				if( pattern.test( $( this ).val() ) ){
					switch( id ){
						case 'user_new_psw':
							if( value == $( '#user_old_psw' ).val() ){
								error( objParent );
								toastr.error( '新密码与旧密码相同' );
							}else{
								success( objParent );
							}
							break;
						case 'user_again_psw':
							if( value !== $( '#user_new_psw' ).val() ){
		                        error( objParent );
		                        toastr.error( '密码与第一次输入不一致' );
		                    }else{
		                    	success( objParent );
		                    }
							break;
						default:
							success( objParent );
		                	break;
					}
				}else{
					error( objParent );
					toastr.error( '请输入6-15位只包含数字、字母、下划线或特殊字符的密码！' );
				}
			}else{
				error( objParent );
				toastr.error( $( this ).attr( 'name' ) + '不能为空' );
			}
		} );

		//密码提交
		$( '#user_pswconfirm_btn' ).click( function(){
			$( 'input:password' ).blur();
			if( !$( '#user_modal div.form-group' ).hasClass( 'has-error' ) ){
				var data = { 'oldPassword':MD5( $( '#user_old_psw' ).val() ), 'newPassword':MD5( $( '#user_new_psw' ).val() ), 'rePassword':MD5( $( '#user_again_psw' ).val() ), 'key':key, 'token':token };
				$.post( '/admin/index/changePsw', data, function( res ){
					switch ( res.state ){
						case 0:
							toastr.success( '密码修改成功' );
							$( '#user_modal' ).modal( 'hide' );
							$( '.user_psw' ).val( '' );
							break;
						case 1:
							toastr.error( '密码修改失败' );
							break;
						case 2:
							toastr.error( '用户信息不存在' );
							break;
						case 3:
							toastr.error( '登录用户信息不存在，请退出后重新登录' );
							break;
						case 4:
							toastr.error( '输入密码错误，请重新输入' );
							$( '#user_old_psw' ).val( '' );
							var objParent = $( '#user_old_psw' ).parents( '.form-group' );
							objParent.find( 'span' ).remove();
							error( objParent );
							break;
						case 5:
							toastr.error( '信息传递失败，请重试' );
							break;
					}
					key = res.key;
					token = res.token;
				}, 'json' );
			}
		} );
		
		//输入信息验证显示
		function success( obj ){
             obj.addClass( 'has-success').removeClass('has-error');
             obj.find('.form-control').after( '<span class="glyphicon glyphicon-ok form-control-feedback"></span>' );
        }
        function error( obj ){
             obj.addClass( 'has-error').removeClass('has-success');
             obj.find('.form-control').after( '<span class="glyphicon glyphicon-remove form-control-feedback"></span>' );
        }
		
        /*-----------------上传用户头像信息----------------*/
		function uploadMyProfile( item ){
        	var myImage = _editor.getDialog("insertimage");
	        myImage.open();
        }
        
        $( 'span.glyphicon-cloud-upload' ).click(function(){
        	var myImage = _editor.getDialog("insertimage");
	        myImage.open();
        } );
	</script>
</body>

</html>