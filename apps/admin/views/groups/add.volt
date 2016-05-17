<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet"  href="/bootstrap/3.3.0/css/bootstrap.min.css">
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class=""><a href="/admin/groups/index">用户组</a></li>
            <li role="presentation"class="active"><a href="#groupAdd" >添加用户组</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="userAdd" style="padding-top:20px;">
                <form class="form-horizontal">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">组名</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="groupName" name="groupName" placeholder="请输入组名"/>
                        </div>
                    </div>
                    
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">角色</label>
                        <div class="col-xs-8 text-left">
                            {% for item in roles %}
                            <label class="checkbox-inline"><input type="checkbox" name="roles[]" value="{{ item['id'] }}"/>{{ item['name'] }}</label>
                            {% endfor %}
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success btn-sm" id="groupInsert" style="margin-right: 50px;width:70px;">保存</button>
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
        <script>
        	var submitId = false;
        	var csrfName = "<?php echo $this->security->getTokenKey();?>";
         	var csrfValue = "<?php echo $this->security->getToken();?>";
            $( function(){
            	/*-------------防止重复提交------------*/
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
            	
                var is_check = false;
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

                /*-----------添加数据-----------*/
                $( '#groupInsert' ).click( function(){
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
                            var key = '&'+csrfName+'='+csrfValue;
                            data += key;
                            
                            submitId = true;
                            
                            $.post( '/admin/groups/insert', data, function( ret ){
                                if( ! ret.status )
                                {
                                    location = '/admin/groups/index';
                                }
                                else
                             {
                                    errorMsg( ret.msg );
                                    submitId = false;
                                }
                                csrfName = ret.csrfname;
                                csrfValue = ret.csrfval;
                                
                            }, 'json');
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