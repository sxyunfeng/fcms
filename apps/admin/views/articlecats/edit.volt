<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class=""><a href="{{ url( 'admin/articlecats/index' ) | escape_attr }}">文章分类</a></li>
            <li role="presentation"class=""><a href="{{ url( 'admin/articlecats/add' ) | escape_attr }}" >添加文章分类</a></li>
            <li role="presentation" class="active"><a href="#articlecatsEdit">编辑文章分类</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="articlecatsEdit" style="padding-top:20px;">
                {% if articleCats is defined and articleCats is not empty %}
                <form class="form-horizontal">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">姓名</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="cateName" name="cateName" placeholder="请输入分类" value='{{ articleCats[ 'name' ] | escape_attr }}'/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">上级分类</label>
                        <div class="col-xs-3">
                            <select class="form-control" id="parentId" name="parentId" value="">
                                <option value="0" class="text-center">无上级分类</option>
                                {% if allCats is not empty %}
                                {% for first in allCats %}
                                <option  value="{{ first[ 'id' ] | escape_attr }}" 
                                    {% if articleCats[ 'pid' ] == first[ 'id' ] %}selected{% endif %}>{{ first[ 'name' ] | e }}</option>
                                {% if first[ 'sub' ] is defined %}
                                    {% for second in first[ 'sub' ] %}
                                        <option value="{{ second[ 'id' ] | escape_attr }}" style="padding-left:20px;" 
                                            {% if articleCats[ 'pid' ] == second[ 'id' ] %}selected{% endif %}>--{{ second[ 'name' ] | e }}</option>
                                         {% if second[ 'sub' ] is defined %}
                                            {% for third in second[ 'sub' ] %}
                                            <option value="{{ third[ 'id' ] | escape_attr }}" style="padding-left:40px;" 
                                                {% if articleCats[ 'pid' ] is third[ 'id' ] %}selected{% endif %}>---{{ third[ 'name' ] | e }}</option>
                                            {% endfor %}
                                        {% endif %}
                                    {% endfor %}
                                {% endif %}
                                {% endfor %}
                                {% endif %}
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success btn-sm" id="articlecatsUpdate" style="margin-right: 50px;width:70px;">保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel" style="width:70px;" >取消</button>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{ articleCats['id'] | e }}" />
                </form>
                {% else %}
                <div class="col-xs-12 text-center text-danger">没有数据</div>
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
                    var name = $( this ).val();
                    var oldName = "{{ articleCats[ 'name' ] | e }}";
                    var objParent = $( this ).parents( '.form-group' );
                    if( name  )
                    {
                        if( name !== oldName )
                        {
                            $.post( '/admin/articlecats/checkname', { 'name' : name }, function( ret ){
                               if( ret.status )
                               {
                                   error( objParent );
                                   errorMsg( ret.msg );
                               }
                               else
                               {
                                   success( objParent );
                               }
                           }, 'json' );
                        }
                        else
                        {
                            success( objParent );
                        }
                    }
                    else
                    {
                       error( objParent );
                    }
                });
                
                /*-----------更新数据-----------*/
                $( '#articlecatsUpdate' ).click( function(){
					if( !submitId )
					{
						var name = $( '#cateName' ).val( );
	                    if( ! name )
	                    {
	                        error( $( '#cateName' ).parents( '.form-group' ) );
	                    }
	                    
	                    if( ! $( ':checked' ).length )
	                    {
	                        errorMsg( '请选择用户组' );
	                        return false;
	                    }
	                    
	                    if( ! $( 'form span' ).hasClass( 'glyphicon-remove') ) //数据正确可以提交表单了
	                    {
	                        var data = $( 'form' ).serialize();
	                        
	                        submitId = true;
	                        $.post( '/admin/articlecats/update', data, function( ret ){
	                            if( ! ret.status )
	                            {
	                                location = '/admin/articlecats/index';
	                            }
	                            else
								{
	                            	errorMsg( ret.msg );
                                    submitId = false;
	                            }
	                            
	                        }, 'json').error( function(){
	                            errorMsg( '网络不通' );
	                        });
	                    }
	                  
	                    return false;
					}
					else
					{
						submitId = false;
					}
                } );
                
                /* ----------取消---------------*/
                $( '#cancel' ).click( function(){
                     location = '/admin/articlecats/index';
                     return false;
                } );
            } );
            function success( obj )
            {
                 obj.find( 'span' ).remove(); 
                 obj.addClass( 'has-success').removeClass('has-error');
                 obj.find('.form-control').after( '<span class="glyphicon glyphicon-ok form-control-feedback"></span>' );
            }
            function error( obj )
            {
                 obj.find( 'span' ).remove(); 
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