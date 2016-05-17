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
                width: 105px;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class=""><a href="/admin/roles/index">角色</a></li>
            <li role="presentation"class="active"><a href="#groupAdd" >添加角色</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="userAdd" style="padding-top:20px;">
                <form class="form-horizontal">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">角色名</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" name="roleName" placeholder="请输入角色名"/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">角色描述</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text"  name="roleDescr" placeholder="请输入角色描述"/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">角色</label>
                        <div class="col-xs-10 text-left" id="selectRole">
                            <dl>
                                <dt><label class="checkbox-inline"><input class="allSelect" type="checkbox">全选</label></dt>
                            </dl>
                            {% for first in pris %}
                            <dl class="all_authorities">
                                <dt class=""> 
                                    <label class='checkbox-inline'>
                                        <input type="checkbox" class="first" name="pris[]" value="{{ first[ 'id' ]}}"/>
                                        {{ first[ 'name' ] }}
                                    </label>
                                </dt>
                                {% if first[ 'sub' ] is defined %}
                                    <?php if( strpos( $first[ 'src'], '/') === false ){ ?>
                                    {% for second in first[ 'sub' ] %}
                                    <dd>
                                         <label class="checkbox-inline">
                                            <input type="checkbox" class="second" name="pris[]" value="{{ second[  'id' ] }}"/>
                                            {{ second[ 'name' ] }}
                                        </label>
                                        <br>
                                        {% if second[ 'sub' ] is defined %}
                                            {% for third in second[ 'sub' ] %}
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="checkbox-inline">
                                                <input type="checkbox" class="third" name="pris[]" value="{{ third['id'] }}"/>
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
                                            <input type="checkbox" class="second" name="pris[]" value="{{ second[  'id' ] }}"/>
                                            {{ second[ 'name' ] }}
                                        </label>
                                    {% endfor %}
                                    </dd>
                                    <?php } ?>
                                {% endif %}
                            </dl>
                            {% endfor %}
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success btn-sm" id="roleInsert" style="margin-right: 50px;width:70px;">保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel" style="width:70px;">取消</button>
                        </div>
                         <div class="col-xs-12 text-center loading"  style="margin-top:-20px; display:none;"> 
                            <i class="fa fa-pulse fa-spinner  fa-2x"  > </i>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
        <div class="alert alert-danger text-center col-xs-2" style="position: fixed;bottom:0;margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script>
        
        	var csrfName = "<?php echo $this->security->getTokenKey();?>";
         	var csrfValue = "<?php echo $this->security->getToken();?>";
         	
            $( function(){
            	
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
                $( '#roleInsert' ).click( function(){
	                $( ':text' ).blur(); //重新检验一下数据
	                
	               if( ! $( ':checked' ).length ) 
	                {
	                    errorMsg( '请选择权限项' );
	                }
	                
	                if( ! $( 'form span' ).hasClass( 'glyphicon-remove') ) //数据正确可以提交表单了
	                {
	                    var data = $( 'form' ).serialize();
	                    var key = '&'+csrfName+'='+csrfValue;
	                    data += key;
	                    
	                    $( '#roleInsert' ).attr( 'disabled', 'disabled' );
	                    $.post( '/admin/roles/insert', data, function( ret ){
	                        if( ! ret.status )
	                        {
	                            location = '/admin/roles/index';
	                        }
	                        else
	                      {
	                            errorMsg( ret.msg );
	                        	csrfName = ret.csrfname;
                                csrfValue = ret.csrfval;
                                $( '#roleInsert' ).removeAttr( 'disabled' );
	                        }
	                        
	                    }, 'json').error( function(){
	                        errorMsg( '网络不通' );
	                        $( '#roleInsert' ).removeAttr( 'disabled' );
	                    } );
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