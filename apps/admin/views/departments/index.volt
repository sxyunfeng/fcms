<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel='stylesheet' href='/css/admin/font-awesome.min.css'>
        <style>
            .fa {
                font-size:22px;
            }
            .glyphicon {
                margin-right: 10px;
            }
            .fa:hover, .glyphicon:hover {
                cursor:pointer;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#groupList">部门</a></li>
            <li role="presentation"><a href="/admin/departments/add">添加部门</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="userList">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>部门</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for item in deptList %}
                        <tr>
                            <td>{{ item[ 'name' ] | e }}</td>
                            <td data-id="{{ item[ 'id' ] }}">{% if ! item[ 'status' ]  %} <i class="fa fa-lightbulb-o text-success status" title="点击切换"></i> {% else %} 
                                <i class="fa fa-lightbulb-o text-muted status" title="点击切换"></i>{% endif %}</td>
                            <td>
                                <i class="glyphicon glyphicon-trash operate delete"  data-id="{{ item[ 'id'] }}" title="删除"></i>
                                <a href="{{ url( 'admin/departments/edit?id=' ) }}{{ item[ 'id' ] }}"><i class="glyphicon glyphicon-pencil operate userEdit" title="编辑" ></i></a>
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            
            </div>
        </div>
        <div class="alert alert-danger text-center col-xs-2" style="display:none;margin-left: 40%;">
            <i class="glyphicon glyphicon-exclamation-sign pull-left"  style="font-size:20px;"></i>
            <span>删除失败</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script>
            $( function(){
           
               /*----------------删除-----------------*/
               $( 'table' ).delegate( '.delete', 'click', function(){
                    var isDel = confirm( '是否删除该部门' );
                    if( isDel )
                    {
                        var id = $( this ).attr( 'data-id' );
                        var data = {'id': id, '<?php echo $this->security->getTokenKey();?>' : '<?php echo $this->security->getToken();?>'};
                        var _this = this;
                        
                        $.post( '/admin/departments/delete', data, function( ret ){
                            if( !ret.status )
                            {
                                $( _this ).parents( 'tr' ).remove();
                            }
                            else
                            {
                                error( ret.msg );
                            }
                        }, 'json').error(function(){ //网络不通
                            error( '网络不通' );
                        });
                    }
               });
               
                /*---------------启用 关闭部门-----------------*/
                $( 'table' ).delegate( '.status', 'click', function(){
                    var msg = '是否开启部门';
                    var status = 0;
                    if( $( this ).hasClass( 'text-success' ))
                    {
                        msg = '是否关闭部门';
                        status = 1;
                    }
                   
                    if( confirm( msg ) )
                    {
                        var id = $( this ).parent().attr( 'data-id' );
                        var data = {'id': id, 'status' : status, '<?php echo $this->security->getTokenKey();?>' : '<?php echo $this->security->getToken();?>'};
                        var _this = this;
                        
                        $.post( '/admin/departments/toggle', data, function( ret ){
                            if( !ret.status )
                            {
                                $( _this ).toggleClass( 'text-success' ).toggleClass( 'text-muted' );
                            }
                            else
                            {
                                error( ret.msg );
                            }
                        }, 'json').error(function(){ //网络不通
                            error( '网络不通' );
                        });
                    }
               });
            });
            
            function error( msg )
            {
                $( '.alert' ).find( 'span' ).text( msg );
                $( '.alert' ).show().fadeOut( 3000 );
            }
        </script>
    </body>
</html>