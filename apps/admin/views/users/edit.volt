<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/toastr/toastr.min.css">
        <style>
            button {
                margin-right:50px;
                width:70px;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation" class=""><a href="{{ url( 'admin/users/index' ) }}">用户</a></li>
            <li role="presentation" class="active"><a href="#userEdit">编辑用户</a></li>
            <li role="presentation" class=""><a href="#changePassword">修改密码</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="userEdit" style="padding-top:20px;">
                {% if user is defined and user is not empty %}
                <form class="form-horizontal" id="userInfo">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">姓名</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="name" name="name" placeholder="请输入姓名" value='{{ user[ 'name' ] | e }}'/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">昵称</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="nickname" name="nickname" placeholder="请输入昵称" value='{{ user[ 'nickname' ] | e }}'/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">账号</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="loginname" name="loginname" placeholder="请输入登录账号" value='{{ user[ 'loginname' ] | e }}' disabled="" />
                        </div>
                    </div>
                    <div class="form-group  has-feedback text-right">
                        <label class="col-xs-2 control-label">邮箱</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="email" id="email" name="email" placeholder="请输入邮箱" value="{{ user[ 'email' ] | e }}"/>
                        </div>
                    </div>
                    {% if shop is defined %}
                     <div class="form-group">
                        <label class="col-xs-2 control-label"> 所属商铺</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" name="shopId" value="{{ shop[ 'name' ] | e }}" disabled=""/>
                        </div>
                    </div>
                    {% endif %}
                    {% if  user[ 'groupid' ] is defined  %}
                    <div class="form-group" id="userGroup">
                        <label class="col-xs-2 control-label"> 所属用户组</label>
                        <div class="col-xs-8">
                            {% for key,group in groups %}
                            {% if key %}
                            <label class="radio-inline"><input type="radio" name="groupId" value="{{ group[ 'id' ] | e }}"
                            {% if user[ 'groupid' ] ==  group[ 'id' ] %} checked {% endif %}/>{{ group[ 'name' ] | e }}</label>
                            {% endif %}
                            {% endfor %}
                        </div>
                    </div>
                    {% endif %}
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success btn-sm" id="userUpdate">保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel" >取消</button>
                        </div>
                    </div>
                    <input type="hidden" name="userId"  value="{{ user['id'] }}" />
                </form>
                {% else %}
                <div class="col-xs-12 text-center text-danger">没有数据</div>
                {% endif %}
            </div>
            <div role="tabpannel" class="tab-pane" id="changePassword" style="padding-top:20px;">
                 <form class="form-horizontal" id="userPassword">
                    <div class="form-group has-feedback text-right ">
                        <label class="col-xs-2 control-label">原密码</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="password" id="oldPassword"  placeholder="******" value='' />
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right ">
                        <label class="col-xs-2 control-label">密码</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="password" id="password" name="password"  placeholder="******" value='' />
                        </div>
                    </div>
                     <div class="form-group has-feedback text-right ">
                        <label class="col-xs-2 control-label">确认密码</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="password" id="repassword" name="repassword" placeholder="******" value="" />
                        </div>
                    </div>
                     <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-info btn-sm" id="savePassword"  >保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancelChange" >取消</button>
                        </div>
                    </div>
                    <input type="hidden" name="userId" id="userId" value="{{ user['id'] }}" />
                 </form>
            </div>
        </div>
        <div class="alert alert-danger col-xs-2 text-center" style="margin-left:40%;display:none;">
            <i class="glyphicon glyphicon-warning-sign"></i>
            <span>网络错误</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/js/jsut/md5.js"></script>
        <script src="/bootstrap/toastr/toastr.min.js"></script>
        <script>
		var submitId = false;
		/*---------------防止重复点击-------------*/
		$( 'input, select' ).change( function(){
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
    $( function(){
        /*------------------分页切换-----------------*/
        $('#tabs a').click(function (e) {
            if( $( this ).parent().index() === 0 ) 
                return;
            e.preventDefault();
            $(this).tab( 'show' );
          });
        $( '#cancelChange' ).click( function(){
            $('#tabs li:eq(1) a').tab( 'show' ); 
        });
        /*-------------用户信息验证---------------*/
        $( '#userInfo :text' ).blur( function(){
            var objParent = $( this ).parents( '.form-group' );
            objParent.find( 'span' ).remove();
            var value = $( this ).val();
            var id = $( this ).attr( 'id' );
            if( value )
            {
                if( 'email' === id ) //是邮箱，就去验证邮箱是否正确
                {
                    var filter  = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
                    if(  ! filter.test( value ) ) 
                    {
                        error( objParent );
                        return;
                    }
                }   
                success( objParent );
             }
             else
             {
          
                error( objParent );
             }
        });

        /*-----------更新用户-----------*/
        $( '#userUpdate' ).click( function(){
        	if( !submitId )
        	{
        		$( '#userInfo :text' ).blur(); //重新检验一下数据
                if( ! $( ':checked' ).length && $( '#userGroup' ).length ) 
                 {
                     errorMsg( '请选择用户组' );
                     return false;
                 }

                 if( ! $( '#userInfo span' ).hasClass( 'glyphicon-remove') ) //数据正确可以提交表单了
                 {
                     var data = $( '#userInfo' ).serialize();
                     var key = '&<?php echo $this->security->getTokenKey();?>=<?php echo $this->security->getToken();?>';
                     data += key;
					
                     submitId = true;
                     $.post( '/admin/users/update', data, function( ret ){
                         if( ! ret.status )
                         {
                             successMsg( ret.msg );
                         }
                         else
                       {
                             errorMsg( ret.msg );
                         }

                     }, 'json').error( function(){
                         errorMsg( '网络不通' );
                     });
                 }

                 return false;
        	}
        	else
        	{
        		toastr.error( '数据重复，请勿重复提交！' );
        	}
        });
        
        /*---------------密码填写---------------*/
        $( '#userPassword :password' ).blur( function(){
            var objParent = $( this ).parents( '.form-group' );
            objParent.find( 'span' ).remove();
            var value = $( this ).val();
            var id = $( this ).attr( 'id' );
            if( value )
            {
                if( 'repassword' === id ) //是密码，就去验证密码输入是否一致
                {
                    if( value !== $( '#password' ).val() )
                    {
                        error( objParent );
                        return;
                    }
                }
                success( objParent );
             }
             else
             {
          
                error( objParent );
             }
        });
        /*---------------密码提交---------------*/
         $( '#savePassword' ).click( function(){       
            $( '#userPassword :password' ).blur(); //重新检验一下数据
            if( ! $( '#userPassword span' ).hasClass( 'glyphicon-remove') ) //数据正确可以提交表单了
            {
                var userId = $( '#userId').val();
                var password = MD5( $( '#password' ).val() );
                var repassword = MD5( $( '#repassword' ).val() );
                var oldPassword = MD5( $( '#oldPassword' ).val());
                
                oldPassword = MD5( "<?php echo $this->session->getId(); ?>"  +  oldPassword );
                var data = { 'password' : password, 'repassword': repassword, 'oldPassword':oldPassword, 'userId':userId,
                  '<?php echo $this->security->getTokenKey();?>':'<?php echo $this->security->getToken();?>'}
                
                $.post( '/admin/users/changePassword', data, function( ret ){
                    if( ! ret.status )
                    {
                        successMsg( ret.msg );
                    }
                    else
                    {
                        errorMsg( ret.msg );
                    }

                }, 'json').error( function(){
                    errorMsg( '网络不通' );
                });
            }
            else
            {
                errorMsg( '请填写正确密码' );
            }

            return false;
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
        $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
        $( '.alert span' ).text( msg );
        $( '.alert' ).show().fadeOut( 3000 );
    }
    function successMsg( msg )
    {
        $( '.alert' ).addClass( 'alert-success' ).removeClass( 'alert-danger' );
        $( '.alert span' ).text( msg );
        $( '.alert' ).show().fadeOut( 3000 );
    }
        </script>
    </body>
</html>