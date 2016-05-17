<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <style>
            .glyphicon {
                margin-right:15px;
                cursor:pointer;
            }
            tr.first .glyphicon-plus, tr.first .glyphicon-mins {
                font-size:12px;
                margin-right:10px;
            }
            tr.second, tr.third {
                display:none;
            }
            tr.second .glyphicon-plus,  tr.second .glyphicon-minus {
                font-size:10px;
                margin-left:20px;
            }
            tr.third .glyphicon-minus {
                font-size:10px;
                margin-left:40px;
            }

        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#categorysList">分类</a></li>
            <li role="presentation"><a href="/admin/categorys/add">添加分类</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="userList">
                {% if categorys is defined and categorys is not empty %}    
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>商品分类</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for first in categorys %}
                        <tr class="first" data-id="{{ first[ 'id' ]}}">
                            <td class="catname"><i  class="glyphicon glyphicon-plus" ></i>{{ first[ 'name' ] }}</td>
                            <td>
                                <i class="glyphicon glyphicon-trash operate categoryDelete" data-id="{{ first[ 'id' ] }}"></i>
                                <a href="{{ url( 'admin/categorys/edit?id=' ) }}{{ first[ 'id' ] }}"><i class="glyphicon glyphicon-pencil operate" ></i></a>
                            </td>
                        </tr>
                        {% if first[ 'sub' ] is defined %}
                            {% for second in first[ 'sub'] %}
                            <tr class="second id{{ first[ 'id'] }}" data-id="{{ second[ 'id' ]}}">
                                <td class="catname">
                                    <i class="glyphicon {% if second[ 'sub' ] is defined %}glyphicon-plus{% else %} glyphicon-minus {% endif %}" ></i>{{ second[ 'name' ] }}</td>
                                <td>
                                    <i class="glyphicon glyphicon-trash operate categoryDelete" data-id="{{ second[ 'id' ] }}"></i>
                                    <a href="{{ url( 'admin/categorys/edit?id=' ) }}{{ second[ 'id' ] }}"><i class="glyphicon glyphicon-pencil operate" ></i></a>
                                </td>
                            </tr>   
                            {% if second[ 'sub' ] is defined %}
                                {% for third in second[ 'sub'] %}
                                <tr class="third id{{ second[ 'id' ] }} id{{ first[ 'id' ]}}">
                                    <td class="catname" ><i class="glyphicon glyphicon-minus" ></i>{{ third[ 'name' ] }}</td>
                                    <td>
                                        <i class="glyphicon glyphicon-trash operate categoryDelete" data-id="{{ third[ 'id' ] }}"></i>
                                        <a href="{{ url( 'admin/categorys/edit?id=' ) }}{{ third[ 'id' ] }}"><i class="glyphicon glyphicon-pencil operate" ></i></a>
                                    </td>
                                </tr>   
                                {% endfor %}
                            {% endif %}
                            {% endfor %}
                        {% endif %}
                        {% endfor %}
                    </tbody>
                </table>
                {% else %}
                <div class="col-xs-12 text-center"> 没有数据 </div>
                {% endif %}
            </div>
        </div>
        <div class="alert alert-danger text-center col-xs-2" style="display:none;margin-left: 40%;">
            <span>删除失败</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script>
$( function(){
    /*-------------分类的展开--------------------*/
    $( 'table' ).delegate( '.first .catname', 'click', function(){
        var id = $( this ).parent().attr( 'data-id' );
        var second = '.second.id' + id;
        var third = '.third.id' + id;
        
        if( $( second ).length )
        {
            $( second ).toggle();
        }
        
        if( $( second ).is( ':hidden' ) && $( third ).length )
        {
            $( second ).find( '.catname i' ).removeClass( 'glyphicon-minus' ).addClass( 'glyphicon-plus' );
            $( third ).hide();
        }
        
       $( this ).find( 'i' ).toggleClass( 'glyphicon-plus' );
       $( this ).find( 'i' ).toggleClass( 'glyphicon-minus' );
    });
    //二级分类展开
     $( 'table' ).delegate( '.second .catname', 'click', function(){
        var id = '.third.id' + $( this ).parent().attr( 'data-id' );
        if( $( id ).length )
        {
            $( id ).toggle();
            $( this ).find( 'i' ).toggleClass( 'glyphicon-plus' );
            $( this ).find( 'i' ).toggleClass( 'glyphicon-minus' );
        }
        
    });
    
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
   $( 'table' ).delegate( '.categoryDelete', 'click', function(){
        var isDel = confirm( '是否删除该分类' );
        if( isDel )
        {
            var id = $( this ).attr( 'data-id' );
            var data = {'id': id, '<?php echo $this->security->getTokenKey();?>' : '<?php echo $this->security->getToken();?>'};
            var _this = this;

            $.post( '/admin/categorys/delete', data, function( ret ){
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
});
        </script>
    </body>
</html>