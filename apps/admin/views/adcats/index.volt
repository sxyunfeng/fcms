<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet"  href="/css/admin/font-awesome.min.css" >
        <style>
            .fa, .glyphicon {
                margin-right:15px;
            }
            tr.first .fa-plus-square-o, tr.first .fa-mins {
                margin-right:10px;
            }
            tr.second, tr.third {
                display:none;
            }
            tr.second .fa-plus-square-o,  tr.second .fa-minus-square-o {
                margin-left:20px;
            }
            tr.third .fa-minus-square-o {
                margin-left:40px;
            }
            .operate:hover {
                cursor:pointer;
                color:green;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#adCatsList">广告分类</a></li>
            <li role="presentation"><a href="/admin/adCats/add">添加广告分类</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="userList">
                {% if adCats is defined and adCats is not empty %}    
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>分类</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for first in adCats %}
                        <tr class="first" data-id="{{ first[ 'id' ] | e }}">
                            <td class="catname"><i  class="fa fa-plus-square-o" ></i>{{ first[ 'name' ] | e }}</td>
                            <td>
                                <i class="glyphicon glyphicon-trash operate adCatsDelete" data-id="{{ first[ 'id' ] | e }}"></i>
                                <a href="{{ url( 'admin/adCats/edit?id=' ) | escape_attr }}{{ first[ 'id' ] | e }}"><i class="glyphicon glyphicon-pencil operate" ></i></a>
                            </td>
                        </tr>
                        {% if first[ 'sub' ] is defined %}
                            {% for second in first[ 'sub'] %}
                            <tr class="second id{{ first[ 'id'] | e }}" data-id="{{ second[ 'id' ] | e }}">
                                <td class="catname">
                                    <i class="fa {% if second[ 'sub' ] is defined %}fa-plus-square-o{% else %} fa-minus-square-o {% endif %}" ></i>{{ second[ 'name' ] | e }}</td>
                                <td>
                                    <i class="glyphicon glyphicon-trash operate adCatsDelete" data-id="{{ second[ 'id' ] | e }}"></i>
                                    <a href="{{ url( 'admin/adCats/edit?id=' ) | escape_attr }}{{ second[ 'id' ] | e }}"><i class="glyphicon glyphicon-pencil operate" ></i></a>
                                </td>
                            </tr>   
                            {% if second[ 'sub' ] is defined %}
                                {% for third in second[ 'sub'] %}
                                <tr class="third id{{ second[ 'id' ] | e }} id{{ first[ 'id' ] | e }}">
                                    <td class="catname" ><i class="fa fa-minus-square-o" ></i>{{ third[ 'name' ] | e }}</td>
                                    <td>
                                        <i class="glyphicon glyphicon-trash operate adCatsDelete" data-id="{{ third[ 'id' ] | e }}"></i>
                                        <a href="{{ url( 'admin/adCats/edit?id=' ) | e }}{{ third[ 'id' ] | e }}"><i class="glyphicon glyphicon-pencil operate" ></i></a>
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
    //一级分类展开和隐藏
    $( 'table' ).delegate( '.first .catname', 'click', function(){
        var id = $( this ).parent().attr( 'data-id' );
        var second = '.second.id' + id;
        var third = '.third.id' + id;
        
        if( $( second ).length )
        {
            $( second ).toggle();
            $( this ).find( 'i' ).toggleClass( 'fa-plus-square-o' );
            $( this ).find( 'i' ).toggleClass( 'fa-minus-square-o' );
        }
       
        if( $( second ).is( ':hidden' ) && $( third ).length )
        {
            $( second ).find( '.catname i' ).removeClass( 'fa-minus-square-o' ).addClass( 'fa-plus-square-o' );
            $( third ).hide();
        }
        
    });
    //二级分类展开
     $( 'table' ).delegate( '.second .catname', 'click', function(){
        var id = '.third.id' + $( this ).parent().attr( 'data-id' );
        if( $( id ).length )
        {
            $( id ).toggle();
            $( this ).find( 'i' ).toggleClass( 'fa-plus-square-o' );
            $( this ).find( 'i' ).toggleClass( 'fa-minus-square-o' );
        }
    });
    
   
   
   /*----------------删除-----------------*/
   $( 'table' ).delegate( '.adCatsDelete', 'click', function(){
        var isDel = confirm( '是否删除该分类' );
        if( isDel )
        {
            var id = $( this ).attr( 'data-id' );
            var data = {'id': id, '<?php echo $this->security->getTokenKey();?>' : '<?php echo $this->security->getToken();?>'};
            var _this = this;

            $.post( '/admin/adCats/delete', data, function( ret ){
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
});

function error( msg )
{
    $( '.alert span' ).text( msg );
    $( '.alert' ).show().fadeOut(3000);
}
        </script>
    </body>
</html>