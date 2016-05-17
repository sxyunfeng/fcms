<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap/switch/css/bootstrap-switch.min.css">
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class=""><a href="{{ url( 'admin/departments/index' ) }}">部门</a></li>
            <li role="presentation" class="active"><a href="#groupEdit">编辑部门</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="groupEdit" style="padding-top:20px;">
                {% if dept is defined and dept is not empty %}
                <form class="form-horizontal">
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">部门名</label>
                        <div class="col-xs-3">
                            <input class="form-control" type="text" id="name" name="name" placeholder="请输入部门名" value='{{ dept[ 'name' ] | escape_attr }}'/>
                        </div>
                    </div>
                    <div class="form-group has-feedback text-right">
                        <label class="col-xs-2 control-label">排序</label>
                        <div class="col-xs-2">
                            <input class="form-control" type="text" id="name" name="sort" placeholder="请输入排序" value='{{ dept[ 'sort' ] | escape_attr }}'/>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <label class="col-xs-2 control-label">状态</label>
                        <div class="col-xs-3 text-left">
                            <input name="status" type="checkbox" {% if ! dept[ 'status' ] %} checked {% endif %} />
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 30px;">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success btn-sm" id="update" style="margin-right: 50px;width:70px;">保存</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel" style="width:70px;" >取消</button>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{ dept['id'] | escape_attr }}" />
                </form>
                {% else %}
                <div class="col-xs-12 text-center text-danger" >没有数据</div>
                {% endif %}
            </div>
        </div>
        <div class="alert alert-danger col-xs-2 text-center" style="margin-left:40%;display:none;">
            <i class="glyphicon glyphicon-exclamation-sign pull-left"  style="font-size:20px;"></i>
            <span>网络错误</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/switch/js/bootstrap-switch.min.js"></script>
        <script>
            $( function(){
                /*----------状态切换------------*/
                $("[name='status']").bootstrapSwitch( {  'size': 'small', 'onColor': 'success',  'onText' : '开启', 'offText' : '关闭' });
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
                $( '#update' ).click( function(){
                    $( ':text' ).blur(); //重新检验一下数据
                  
                    if( ! $( 'form span' ).hasClass( 'glyphicon-remove') ) //数据正确可以提交表单了
                    {
                        var data = $( 'form' ).serialize();
                        var key = '&<?php echo $this->security->getTokenKey();?>=<?php echo $this->security->getToken();?>';
                        data += key;
                       
                        $.post( '/admin/departments/update', data, function( ret ){
                            if( ! ret.status )
                            {
                                location = '/admin/departments/index';
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
                     location = '/admin/departments/index';
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