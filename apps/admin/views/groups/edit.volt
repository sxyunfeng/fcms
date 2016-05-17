<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class=""><a href="{{ url( 'admin/groups/index' ) }}">用户组</a></li>
            <li role="presentation"class=""><a href="{{ url( 'admin/groups/add' ) }}" >添加用户组</a></li>
            <li role="presentation" class="active"><a href="#groupEdit">编辑用户组</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="groupEdit" style="padding-top:20px;">
                {% if group is defined and group is not empty %}
                <form class="form-horizontal">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">组名</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="name" name="groupName" placeholder="请输入用户组名" value='{{ group[ 'name' ] | escape_attr }}'/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">角色</label>
                        <div class="col-xs-8 text-left">
                            {% for role in roles %}
                            <label class="checkbox-inline">
                                <input type="checkbox" name="roles[]" value="{{ role[ 'id' ] | escape_attr }}"  {% if role[ 'id' ] in groupRoles %}
                                checked {% endif %} />{{ role[ 'name' ] | e }}</label>
                            {% endfor %}
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success btn-sm" id="groupUpdate" style="margin-right: 50px;width:70px;">保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel" style="width:70px;" >取消</button>
                        </div>
                    </div>
                    <input type="hidden" name="groupId" value="{{ group['id'] | escape_attr }}" />
                </form>
                {% else %}
                <div class="col-xs-12 text-center text-danger" >没有数据</div>
                {% endif %}
            </div>
        </div>
        <div class="alert alert-danger col-xs-2 text-center" style="margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script>
        var submitId = false;
            $( function(){
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
                /*-------------表单数据验证---------------*/
                $( ':text' ).blur( function(){
                    var objParent = $( this ).parents( '.form-group' );
                    objParent.find( 'span' ).remove();
                    var value = $( this ).val();
                    
                    if( value )
                    {
                        success( objParent );
                     }
                     else
                     {
                        error( objParent );
                     }
                });
                
                /*-----------更新数据-----------*/
                $( '#groupUpdate' ).click( function(){
                	if( !submitId )
                	{
                		$( ':text' ).blur(); //重新检验一下数据
                      if( ! $( ':checked' ).length )
                        {
                            errorMsg( '请选择角色' );
                            return false;
                        }
                        if( ! $( 'form span' ).hasClass( 'glyphicon-remove') ) //数据正确可以提交表单了
                        {
                            var data = $( 'form' ).serialize();
                            var key = '&<?php echo $this->security->getTokenKey();?>=<?php echo $this->security->getToken();?>';
                            data += key;
                           
                            submitId = true;
                            $.post( '/admin/groups/update', data, function( ret ){
                                if( ! ret.status )
                                {
                                    location = '/admin/groups/index';
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
                });
                
                /* ----------取消---------------*/
                $( '#cancel' ).click( function(){
                     location = '/admin/groups/index';
                     return false;
                });
            });
            function success( obj )
            {
                 obj.addClass( 'has-success' ).removeClass( 'has-error' );
                 obj.find( '.form-control' ).after( '<span class="glyphicon glyphicon-ok form-control-feedback"></span>' );
            }
            
            function error( obj )
            {
                 obj.addClass( 'has-error' ).removeClass( 'has-success' );
                 obj.find( '.form-control' ).after( '<span class="glyphicon glyphicon-remove form-control-feedback"></span>' );
            }
            
            function errorMsg( msg )
            {
                $( '.alert span' ).text( msg );
                $( '.alert' ).show().fadeOut( 3000 );
            }
        </script>
    </body>
</html>