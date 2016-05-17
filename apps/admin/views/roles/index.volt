<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#rolesList">角色</a></li>
            <li role="presentation"><a href="/admin/roles/add">添加角色</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="rolesList">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>角色名</th>
                            <th>角色描述</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for item in rolesList %}
                        <tr>
                            <td>{{ item[ 'name' ] }}</td>
                            <td>{{ item[ 'descr' ]}}</td>
                            <td>
                                <i class="glyphicon glyphicon-trash operate roleDelete" data-id="{{ item[ 'id'] }}" style="margin-right: 10px;"></i>
                                <a href="{{ url( 'admin/roles/edit?id=' ) }}{{ item[ 'id' ] }}"><i class="glyphicon glyphicon-pencil operate userEdit" ></i></a>
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            
            </div>
        </div>
        <div class="alert alert-danger text-center col-xs-2" style="display:none;margin-left: 40%;">
            <span>删除失败</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script>
            $( function(){
                /*--------------图标颜色改变-----------------*/
               $( '.operate' ).hover( function(){
                   $( this ).css( 'cursor', 'pointer' );
                   $( this ).css( 'color', 'green' );
               }); 
               $( '.operate' ).mouseout( function(){
                   $( this ).css( 'cursor', '' );
                   $( this ).css( 'color', '' );
               });
               /*----------------删除-----------------*/
               $( 'table' ).delegate( '.roleDelete', 'click', function(){
                    var isDel = confirm( '是否删除该角色' );
                    if( isDel )
                    {
                        var id = $( this ).attr( 'data-id' );
                        var data = {'id': id, '<?php echo $this->security->getTokenKey();?>' : '<?php echo $this->security->getToken();?>'};
                        var _this = this;
                        
                        $.post( '/admin/roles/delete', data, function( ret ){
                            if( !ret.status )
                            {
                                $( _this ).parents( 'tr' ).remove();
                            }
                            else
                            {
                                $( '.alert' ).show().fadeOut(3000);
                            }
                        }, 'json').error(function(){ //网络不通
                            $( '.alert' ).show().fadeOut(3000);
                        });
                    }
               });
            })
        </script>
    </body>
</html>