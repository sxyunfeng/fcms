<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/css/admin/fcmslogin.css">
        <link href="/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <title>FCMS登录</title>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="text-center">
	    <div class="container-fluid self_login_box" style="display:none">
	        <!-- BEGIN LOGO -->
	        <div class="logo self_logo" style="margin-top:10%;">
	        	<img src="{{url.getBaseUri()}}img/admin/fcms/logo.png" alt="" />
			</div>
	        <!-- END LOGO -->
	        <!-- BEGIN LOGIN -->
            <!-- BEGIN LOGIN FORM -->
            <form class="" action="" name="" method="" id="">
            	<!-- 用户名 -->
				<div class="form-group has-feedback">
		           	<div class="input-group self_input_group">
						<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-user self_icon1"></span></span>
						<input type="text" class="form-control" placeholder="请输入用户名" aria-describedby="basic-addon1" name="loginname" id="loginname">
						<span class="glyphicon glyphicon-ok form-control-feedback sr-only user-icon"></span>
					</div>
				</div>
				<!-- 密码 -->
				<div class="form-group has-feedback">
					<div class="input-group self_input_group">
						<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-lock self_icon2"></span></span>
						{% if password is defined and password is not empty %}
						<input type="password" class="form-control" placeholder="Password" value="********" id="passwordRemember" aria-describedby="basic-addon2">
						<input type="hidden" placeholder="请输入密码" name="password" id="password" value="{{ password }}"/>
						{% else %}
						<input class="form-control" type="password" placeholder="请输入密码" name="password" id="password"/>
	                    {% endif %}
	                    <span class="glyphicon glyphicon-ok form-control-feedback sr-only password-icon"></span>
					</div>
				</div>
				<!-- 验证码 -->
				<div class="form-group">
					<div class="input-group self_input_group">
						<input type="text" class="form-control" aria-describedby="basic-addon3" id="code" placeholder='请输入验证码' style="width:64%;">
						<img src="/admin/login/verify" id="verify" style="width:130px;height:32px;display:block-inline;padding:2px 0 0 5px;">
					</div>
				</div>
				<!-- 按钮 -->
				<div class="form-group">
                    <div class=" pull-left">
                        <label class="checkbox-inline sr-only">
                            <input type="checkbox" name="remember" value="1" {%if remember is defined %} checked="checked" {% endif %} id="remember"/>记住密码
                        </label>
                    </div>
                    <button type="button" class="btn btn-danger self_submit" id="submit">点击登录</button>
                    <!--<input type="" class="btn btn-success btn-sm  pull-right" name="" id="submit"   value=" 登 录 ">-->
                </div>
			</form>
			<!-- 错误提示 -->
			<div class="alert alert-danger" style=" position:fixed;bottom:20px;left:45%;display:none;width:auto!important;" id="show_error" role="alert" >
	            <i class="glyphicon glyphicon-warning-sign pull-left"></i>&nbsp;&nbsp;
	        	<span class="error-msg">您的用户名，请重新输入！</span> 
	        </div>
	        
		</div>
			
        <!-- BEGIN COPYRIGHT -->
        <div class="copyright sr-only" style=""> 2015 &copy; 华尔商城 </div>
        <!-- END COPYRIGHT -->
        <script type="text/javascript" src="{{url.getBaseUri()}}js/jquery/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="{{url.getBaseUri()}}js/jsut/md5.js"></script>
        <script type="text/javascript">
		var submitId = false;
$( document ).ready( function(){
	/*-----------------防止重复提交------------------*/
	$( 'input' ).keydown( function(){
		if( submitId )
		{
			submitId = false;
		}
	} ).change( function(){
		if( submitId )
		{
			submitId = false;
		}
	} );
	/*-----------------渐变显示------------------*/
	$( ".self_login_box" ).fadeIn( 1500 );
	/*-----------------输入框样式------------------*/
	$( document ).ready( function(){
		$( "#loginname" ).focus( function(){
			$( ".self_icon1" ).addClass( "self_icon_toggle" );
		} );
		$( "#loginname" ).blur( function(){
			$( ".self_icon1" ).removeClass( "self_icon_toggle" );
		} );
		$( "#password" ).focus( function(){
			$( ".self_icon2" ).addClass( "self_icon_toggle" );
		} );
		$( "#password" ).blur( function(){
			$( ".self_icon2" ).removeClass( "self_icon_toggle" );
		} );
		$( "#code" ).focus( function(){
			$( ".self_icon3" ).addClass( "self_icon_toggle" );
		} );
		$( "#code" ).blur( function(){
			$( ".self_icon3" ).removeClass( "self_icon_toggle" );
		} );
	} );
    /*-----------------验证码------------------*/
    $( '#verify' ).click( function(){
        $( this ).attr( 'src', '/admin/login/verify/' + Math.random() );
    });
    //密码改变
    $( '#passwordRemember' ).change( function(){
        $( this ).attr( 'name', 'password' );
        $( '#password' ).removeAttr( 'name' );
    });
    /*-------------用户验证--------------*/
    $( '#loginname' ).change( function(){
        if( $( '#loginname' ).val() ){
            $( '.user-icon' ).removeClass( 'sr-only' );
            $( this ).parents( '.form-group' ).addClass( 'has-success' ).removeClass( 'has-error');
        } else{
            $( '.user-icon' ).addClass( 'sr-only' );
            $( this ).parents( '.form-group' ).addClass( 'has-error' ).removeClass( 'has-success');
        }
    } );
    /*----------密码验证 ----------*/
    $( '#password' ).change( function(){
        if( $( 'input[ name="password" ]' ).val() ){
            $( '.password-icon' ).removeClass( 'sr-only' );
            $( this ).parents( '.form-group' ).addClass( 'has-success' ).removeClass( 'has-error');
            
        } else{
            $( '.password-icon' ).addClass( 'sr-only' );
            $( this ).parents( '.form-group' ).addClass( 'has-error' ).removeClass( 'has-success');

        }
    } );
    /*-----------表单提交------------*/
    $( "#submit" ).click( function(){
    	if( !submitId )
    	{
    		var loginname = $.trim( $( '#loginname' ).val() );
            var password = $.trim( $( 'input[name="password"]' ).val() );
       
            var code = $( '#code' ).val();
            var remember = 0;

            if( $( '#remember' ).prop( 'checked' ))
            {
                remember = 1;
            }
          
            if( loginname != '' &&  password  != '' && code != '')
            {
                if( password.length < 32 ) //没有加密的, 也即是人输入的密码，不是记忆中的密码
                {
                    password = MD5( password );
                }
                password = MD5( "{{sid}}" + password );
                var data = { 'loginname': loginname, 'password': password, 'remember' : remember, 'code' : code,
                    '<?php echo $this->security->getTokenKey(); ?>' : '<?php echo $this->security->getToken(); ?>' };
                
                submitId = true;
                $.ajax( {
                    "url": "/admin/login/dologin", //与此php页面沟通 
                    "type": "post", //以post方式与后台	
                    "dataType": "json",
                    "data": data,
                    "success": function( ret ){
                        if( ret.status === 0 )
                        {
                           location = "{{url.getBaseUri()}}" + 'admin/index/index';
                           return true;
                        }
                        else if( ret.status === 1 ) //密码不对
                        {  
                            $( ':password' ).val( '' );
                            $( '.password-icon' ).addClass( 'sr-only' );
                            $( ':password' ).focus();
                        }
                        else if( ret.status === 2 )  //用户不对
                        { 
                            $( "#loginname" ).val( '' );
                            $( '.user-icon' ).addClass( 'sr-only' );
                            $( "#loginname" ).focus();
                        }
                       
                        $( '#verify' ).attr( 'src', '/admin/login/verify/' + Math.random() );
                        error( ret.msg );
                    },
                    "error": function( XMLHttpRequest, textStatus, errorThrown ){
                        error( '你检查你的网络' );
                        return false;
                    }
                } );
            }
            if( !loginname ){
                error( '请输入用户名' );
            }
            if( !password ){
                error( '请输入密码' );
            }
            if( !code )
            {
                error( '请输入验证码' );
            }
    	}
    	else
    	{
    		error( '登录中，请耐心等待' );
    	}
		
    } );
    $("html").on( 'keydown', function(event){
        if( event.keyCode == 13 )
        {
            $( '#submit' ).trigger( 'click' );
            return false;
        }
    })
} );

/**
 * 错误消息显示
 * @param {type} msg
 * @returns 
 */
function error( msg ){
    $( '.error-msg' ).text( msg );
    $( '#show_error' ).show().fadeOut( 5000 );
}
        </script>
    </body>
</html>
