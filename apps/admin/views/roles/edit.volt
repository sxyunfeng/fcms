<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/css/admin/font-awesome.min.css" >
        <style>
            dd {
                margin-left: 50px;
            }
            dl {
                margin-bottom: 10px;
            }
            dl label {
                width: 100px;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class=""><a href="{{ url( 'admin/roles/index' ) }}">角色</a></li>
            <li role="presentation"class=""><a href="{{ url( 'admin/roles/add' ) }}" >添加角色</a></li>
            <li role="presentation" class="active"><a href="#roleEdit">编辑角色</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="roleEdit" style="padding-top:20px;">
                {% if role is defined and role is not empty %}
                <form class="form-horizontal">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">角色名</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text"  name="roleName" maxlength="20" placeholder="请输入角色名" value="{{ role[ 'name' ]}}"/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">角色描述</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text"  name="roleDescr" placeholder="请输入角色描述" value="{{ role[ 'descr' ]}}"/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">权限项</label>
                         <div class="col-xs-10 text-left" id="selectRole">
                            <dl>
                                <dt><label class="checkbox-inline"><input class="allSelect" type="checkbox">全选</label></dt>
                            </dl>
                            {% for first in pris %}
                            <dl class="all_authorities">
                                <dt> 
                                    <label class='checkbox-inline'>
                                        <input type="checkbox" class="first" name="pris[]" value="{{ first[ 'id' ]}}"
                                               {% if rolePris and (first[ 'id' ] in rolePris) %} checked {% endif %}/>
                                        {{ first[ 'name' ] }}
                                    </label>
                                </dt>
                                <?php if( isset( $first[ 'sub' ] ) ) { ?>
                                    <?php if(  strpos( $first[ 'src' ], '/') === false ) { ?>
                                    {% for second in first[ 'sub' ] %}
                                    <dd>
                                         <label class="checkbox-inline">
                                            <input type="checkbox" class="second" name="pris[]" value="{{ second[  'id' ] }}"
                                                {% if rolePris and (second[ 'id' ] in rolePris) %} checked {% endif %}/>
                                            {{ second[ 'name' ] }}
                                        </label>
                                        {% if second[ 'sub' ] is defined %}
                                            {% for third in second[ 'sub' ] %}
                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="third" name="pris[]" value="{{ third['id'] }}"
                                                {% if rolePris and (third[ 'id' ] in rolePris) %} checked {% endif %}/>
                                                {{ third['name'] }}
                                            </label>
                                            {% endfor %}
                                            
                                        {% endif %}
                                    </dd>
                                    {% endfor %}
                                    <?php } else { ?>
                                    <dd>
                                    {% for second in first[ 'sub' ] %}
                                         <label class="checkbox-inline">
                                            <input type="checkbox" class="second" name="pris[]" value="{{ second[  'id' ] }}"
                                                {% if rolePris and (second[ 'id' ] in rolePris) %} checked {% endif %}/>
                                            {{ second[ 'name' ] }}
                                        </label>
                                    {% endfor %}   
                                    </dd>    
                                    <?php } ?>
                                <?php } ?>
                            </dl>
                            {% endfor %}
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success btn-sm" id="roleUpdate" style="margin-right: 50px;width:70px;">保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel" style="width:70px;" >取消</button>
                           
                        </div>
                        <div class="col-xs-12 text-center loading"  style="margin-top:-20px; display:none;"> 
                            <i class="fa fa-pulse fa-spinner  fa-2x"  > </i>
                        </div>
                    </div>
                    <input type="hidden" name="roleId" value="{{ role['id'] }}" />
                </form>
                {% else %}
                <div class="col-xs-12 text-center text-danger">没有数据</div>
                {% endif %}
            </div>
        </div>
        <div class="alert alert-danger col-xs-2 text-center" style="position:fixed;bottom:0;margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script>
            $( function(){
            	/*-------------表单全选---------------*/
            	var iChecked  = 0;
            	var allCheckbox = $( '#selectRole dl.all_authorities' ).find( 'input' ).length;
            	$( '#selectRole dl.all_authorities' ).find( 'input' ).each( function( index ){
            		if( true === $( this ).prop( 'checked' ) )
            		{
            			iChecked++;
            		}
            	});
            	
            	if( allCheckbox == iChecked )
            	{
            		$( '.allSelect' ).attr( 'checked', 'checked' );
            	}
            	
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
                
                $( '#roleUpdate' ).click( function(){
            		$( ':text' ).blur(); //重新检验一下数据
                    
					if( ! $( ':checked').length )
                    {
                        errorMsg( '请选择权限项' );
                    }
                    
                    if( ! $( 'form span' ).hasClass( 'glyphicon-remove') ) //数据正确可以提交表单了
                    {
                        var data = $( 'form' ).serialize();
                        var key = '&<?php echo $this->security->getTokenKey();?>=<?php echo $this->security->getToken();?>';
                        data += key;
                        
                        $( this ).attr( 'disabled', 'disabled' ); //防止重复提交
                        $( '.loading' ).show();
                        $.post( '/admin/roles/update', data, function( ret ){
                            if( ! ret.status )
                            {
                                location = '/admin/roles/index';
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
                });
                
                /* ----------取消---------------*/
                $( '#cancel' ).click( function(){
                     location = '/admin/roles/index';
                     return false;
                });
                
                 /*-------------------角色全选-------------------*/
                $( '.allSelect' ).click( function(){
                   var checked = $( this ).prop( 'checked' ); 
                   $( ':checkbox' ).prop( 'checked', checked );
                });
                
                 /*-----------一级角色的选择------------*/
                $( '#selectRole' ).delegate( '.first', 'change', function(){
                     var second = $( this ).parents( 'dl' ).find( '.second' );
                     if( second ) //不存在
                     {
                         var checked  = $( this ).prop( 'checked');
                         second.prop( 'checked', checked );
                         var third = second.parents( 'dd').find( '.third' );

                         if( third )
                         {
                             third.each( function(){
                                 $( this ).prop( 'checked', checked );
                             })
                         }
                     }
                });
                
                /*-----------二级角色的选择------------*/
                $( '#selectRole' ).delegate( '.second', 'change', function(){
                        var checked  = $( this ).prop( 'checked');
                        if( checked )
                        {
                            $( this ).parents( 'dl' ).find( '.first' ).prop( 'checked', checked ); //选中 一级
                        }
                        var third = $( this ).parents( 'dd').find( '.third' );

                        if( third )
                        {
                            third.each( function(){
                                $( this ).prop( 'checked', checked );
                            })
                        }
                });
                
                /*-----------三级角色的选择------------*/
                $( '#selectRole' ).delegate( '.third', 'change', function(){
                        var checked  = $( this ).prop( 'checked');
                        if( checked )
                        {
                            $( this ).parents( 'dl' ).find( '.first' ).prop( 'checked', checked ); //选中 一级
                            $( this ).parents( 'dd' ).find( '.second' ).prop( 'checked', checked );//选中二级
                        }
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