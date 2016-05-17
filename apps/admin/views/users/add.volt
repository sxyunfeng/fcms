<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <style>
            .modal .radio-inline {
                margin-left:10px;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class=""><a href="/admin/users/index">用户</a></li>
            <li role="presentation"class="active"><a href="#userAdd" >添加用户</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="userAdd" style="padding-top:20px;">
                <form class="form-horizontal">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">姓名</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="name" name="name" placeholder="请输入姓名"/>
                        </div>
                    </div>
                     <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">昵称</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="nickname" name="nickname" placeholder="请输入昵称"/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">账号</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="loginname" name="loginname" placeholder="请输入登录账号" />
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">密码</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="password" id="password" name="password" placeholder="请输入密码" />
                        </div>
                    </div>
                     <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">确认密码</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="password" id="repassword" name="repassword" placeholder="请再次输入密码" />
                        </div>
                    </div>
                    <div class="form-group  has-feedback text-right">
                        <label class="col-xs-2 control-label">邮箱</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="email" id="email" name="email" placeholder="请输入邮箱" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-2 control-label"> 所属用户组</label>
                        <div class="col-xs-8">
                            {% for key,group in groups %}
                            {% if key %}
                            <label class="radio-inline"><input type="radio" name="groupId" value="{{ group[ 'id' ] }}"/>{{ group[ 'name' ] }}</label>
                            {% endif %}
                            {% endfor %}
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success btn-sm" id="userInsert" style="margin-right: 50px;width:70px;">保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel" style="width:70px;">取消</button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
        <div class="alert alert-danger text-center col-xs-2" style="margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>
        
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/public/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script>
           var csrfName = "<?php echo $this->security->getTokenKey();?>";
	        var csrfValue = "<?php echo $this->security->getToken();?>";
        	var submitId = false;
            $( function(){
            	/*---------------防止重复点击-------------*/
        		$( 'input' ).change( function(){
        			if( submitId )
        			{
        				submitId = false;
        			}
        		} ).keydown( function(){
        			if( submitId )
        			{
        				submitId = false;
        			}
        		} );
            	
                $( '#selectShop' ).click( function(){
                    $( '#shopModal' ).modal( 'toggle' );
                    $( '#shopModal' ).find( '.modal-backdrop' ).hide();
                });
                $( '#selectShopSave' ).click( function(){
                    $( '#shopModal' ).modal( 'toggle' );
                    
                    var obj = $( 'input[name="shopId"]:checked' );
                    var shopId = obj.val();
                    var shopName = obj.parent().text();
                    var str = '<span style="margin-right:10px;"><input type="hidden" name="shopId" value=' + shopId +'><span>'+ shopName +'</span></span>';
                    $( '#selectShop' ).prev().remove();
                    $( '#selectShop' ).before( str );
                }); 
                var is_check = false;
                $( 'input' ).blur( function(){
                    var objParent = $( this ).parents( '.form-group' );
                    objParent.find( 'span' ).remove();
                    var value = $.trim( $( this ).val() );
                    
                    if( value )
                    {
                        var id = $( this ).attr( 'id' );
                        if( 'loginname' === id &&　! is_check ) //是登录名， 就去检验一下是否重复
                        {
                            $.post( '/admin/users/checkLoginName', { 'loginname' : value }, function( ret ){
                                if( ret.status ) //已经存在账户了
                                {
                                    objParent.find( 'span' ).remove();
                                    var msg =  '<span id="helpBlock" class="help-block text-left" style="">' + ret.msg +'</span>';
                                    objParent.append( msg ); 
                                    error( objParent );
                                    return false;
                                }
                                else
                             {
                                    is_check = true;
                                    return true;
                                }
                                
                            }, 'json').error( function(){
                                errorMsg( '网络不通' );
                            });
                        }
                        else if( 'email' === id ) //是邮箱，就去验证邮箱是否正确
                        {
                            var filter  = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
                            if( ! filter.test( value ) ) 
                            {
                                error( objParent );
                                return false;
                            }
                        }
                        else if( 'password' === id ) //判断密码是否符合6-15位且不包含非法字符
                        {
                        	var pattern = /^[\w]{6,15}$/;
                        	if( !pattern.test( value ) )
                        	{
                        		objParent.find( 'span' ).remove();
                                var msg =  '<span id="helpBlock" class="help-block text-left" style="">请输入6-15位数字、字母和下划线组成的密码</span>';
                                objParent.append( msg ); 
                                error( objParent );
                                $( "#repassword" ).focus().select();
                                return false;
                        	}
                        }
                        else if( 'repassword' === id ) //是二次输入密码，就判断与第一次输入是否一致
                        {
                       		if( value !== $( '#password' ).val() )
                               {
                               	objParent.find( 'span' ).remove();
                                   var msg =  '<span id="helpBlock" class="help-block text-left" style="">两次密码输入不一致</span>';
                                   objParent.append( msg ); 
                                   error( objParent );
                                   return false;
                               }
                        }
                        else if( 'groupId' === id ) //是所属分组
                        {
                            if( ! $( '#groupId' ).attr( 'checked' ))
                            {
                                error( objParent );
                                return false;
                            }
                        }
                        success( objParent );
                     }
                     else
                   {
                        error( objParent );
                     }
                });
                
       	       
                /*-----------添加数据-----------*/
                $( '#userInsert' ).click( function(){
                	
                	if( !submitId )
                	{
                		$( ':text' ).blur(); //重新检验一下数据
                        
                        if( ! $( 'input[name="groupId"]:checked' ).length  )
                        {
                            errorMsg( '请选择用户组' );
                            return false;
                        }
                        
                        if( ! $( 'form span' ).hasClass( 'glyphicon-remove') ) //数据正确可以提交表单了
                        {
                            var data = $( 'form' ).serialize();
                            var key = '&'+csrfName+'='+csrfValue;
                            data += key;
                            $( this ).attr( 'disabled', 'disabled' ); //防止重复提交
                            $( '.loading' ).show();
                            
                            submitId = true;
                            $.post( '/admin/users/insert', data, function( ret ){
                                if( ! ret.status )
                                {
                                    location = '/admin/users/index';
                                }
                                else
								{
                                    errorMsg( ret.msg );
                                }
                                 
                            }, 'json').error(function(){
                                errorMsg( '网络不通' );
                            });
                        }
                      
                        return false;
                	}
                	else
              		{
                		error( '数据重复，请勿重复提交！' );
              		}
                });
               /* ----------取消---------------*/
               $( '#cancel' ).click( function(){
                    location = '/admin/users/index';
                    return false;
               });
            });
            function success( obj )
            {
                 obj.addClass( 'has-success').removeClass('has-error');
                 obj.find('.form-control').after( '<span class="glyphicon glyphicon-ok form-control-feedback"></span>' );
            }
            function error( obj )
            {
                 obj.addClass( 'has-error').removeClass('has-success');
                 obj.find('.form-control').after( '<span class="glyphicon glyphicon-remove form-control-feedback"></span>' );
            }
            function errorMsg( msg )
            {
                $( '.alert span' ).text( msg );
                $( '.alert' ).show().fadeOut( 3000 );
            }
        </script>
    </body>
</html>