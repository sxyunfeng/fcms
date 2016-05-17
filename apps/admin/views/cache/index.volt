<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <style>
            .operate {
                margin-right: 10px;
            }
            .operate:hover {
                cursor:pointer;
                color:green;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#cacheList">缓存管理</a></li>
            <li role="presentation"><a href="/admin/cache/add">添加缓存</a></li>
        </ul>
        <div  class="input-group input-group-sm col-xs-offset-7 col-xs-2 " style="margin-top:-30px;">

            <select class="form-control" id="module" name="module" value="" required="required">
                <option value="0" >请选择</option>
                <option value="1" >后台</option>
                <option value="2" >OA</option>
                <option value="3" >Common</option>
                <option value="4" >前台</option>
            </select>
        </div>
        <div  class="input-group input-group-sm col-xs-2 pull-right" style="margin-top:-30px;">
            <input type='text' class='form-control'id="searchCache" placeholder="请输入缓存名称"/>

            <div class="input-group-addon" id="search"><i class="glyphicon glyphicon-search"></i></div>
        </div>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="userList">
                {% if page.items is defined and page.items is not empty %}
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                        	<th>序号</th>
                        	<th>缓存编号</th>
                            <th>缓存名称</th>
                            <th>缓存英文名</th>
                            <th>缓存类型</th>
                            <th>缓存时间</th>
                            <th>是否预热</th>
                            <th>模块归属</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody id="goodsTable">
                        {% for i,item in page.items %}
                        <tr>
                        	<td>{{ i+1 }}</td>
                        	<td>{{ item.id }}</td>
                            <td>{{ item.name | e }}</td>
                            <td>{{ item.ename | e }}</td>
                            <td>{% if item.type == 0 %} Memcache
                                {% elseif item.type ==1  %} Redis 
                                {% elseif item.type ==2  %} Mongodb 
                                {% elseif item.type ==3  %} File
                                {% elseif item.type ==5  %} Apc
                                {% elseif item.type ==4  %} Memcached
                                {% elseif item.type ==6  %} XCache 
                                {% elseif item.type ==7  %} Mongo 
                                {% endif %}
                            </td>
                            <td><?php echo $this->escaper->escapeHtml( $item->cache_time ) ?> 分钟</td>
                            <td>{% if item.is_warm_up ==0 %} 否 {% else %} 是 {% endif %}</td>
                            <td>{% if item.module ==0 %} 前台
                                {% elseif item.module ==1 %} 后台 
                                {% elseif item.module ==4 %} CMS 
                                {% elseif item.module ==2 %} OA 
                                {% elseif item.module ==3 %} COMMON
                                {% endif %}
                            </td>
                            <td data-id = "{{ item.id | escape_attr }}" >
                                <i class="glyphicon glyphicon-trash operate cacheDelete" title="删除"></i>
                                <a href="{{ url( 'admin/cache/edit?id=' ) }}{{ item.id | escape_attr }}"><i class="glyphicon glyphicon-pencil operate" title="修改"></i></a>
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
                {% else %}
                {% endif %}
                {% if page.total_pages > 1 %}
                <nav class="text-right" >
                    <ul class="pagination pagination-sm" style="margin-top:0"> 
                        <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="{{ url( 'admin/cache/index?page=' ) }}{{page.before | escape_attr }}" >&laquo;</a></li>
                        {% if  1 != page.current and 1 != page.before %}
                        <li><a href="{{ url( 'admin/cache/index') | escape_attr }}">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="{{ url( 'admin/cache/index?page=') }}{{ page.before | escape_attr }}"><span >{{ page.before |e}}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="{{ url( 'admin/cache/index?page=') }}{{ page.current | escape_attr }}"><span >{{ page.current |e}}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="{{ url( 'admin/cache/index?page=') }}{{ page.next | escape_attr }}">{{ page.next |e}}</a></li>
                        {% endif %}
                        {% if page.next  < page.last - 1 %}
                        <li><a>...</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="{{ url( 'admin/cache/index?page=') }}{{ page.last | escape_attr }}">{{ page.last |e}}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( 'admin/cache/index?page=' ) }}{{page.next | escape_attr }}" >&raquo;</a></li>

                    </ul>
                </nav>
                {% endif %}
            </div>
        </div>
        <div class="alert alert-danger text-center col-xs-2" style="display:none;margin-left: 40%;">
            <span>删除失败</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script>
$( function( ){
    /*----------------搜索商品--------------------*/
    $( '#search' ).click( function( ){
        var goods = $( '#searchCache' ).val( );
        var module = $( '#module' ).val( );
        $.get( '/admin/cache/search', { name: goods, module: module }, function( ret ){
            if( !ret.status )
            {
                $( '#goodsTable' ).html( '' );
                console.log( ret.goods );
                for( var i in ret.goods )
                {
                    var goods = ret.goods[ i ];

                    if( goods.is_warm_up == 0 )
                    {
                        goods.is_warm_up = '否';
                    }
                    else
                    {
                        goods.is_warm_up = '是';
                    }

                    if( goods.type == 0 )
                    {
                        goods.type = 'memcahce';
                    }
                    else if( goods.type == 1 )
                    {
                        goods.type = 'memcahcedb';
                    }
                    else if( goods.type == 2 )
                    {
                        goods.type = 'redis';
                    }
                    else if( goods.type == 3 )
                    {
                        goods.type = 'mongodb';
                    }
                    else if( goods.type == 4 )
                    {
                        goods.type = 'mysql';
                    }

                    if( goods.module == 0 )
                    {
                        goods.module = '前台';
                    }
                    else if( goods.module == 1 )
                    {
                        goods.module = '后台';
                    }
                    else if( goods.module == 2 )
                    {
                        goods.module = 'OA';
                    }
                    else if( goods.module == 3 )
                    {
                        goods.module = 'Common';
                    }

                    var str = '<tr>' +
                            '<td> ' + goods.name +
                            '</td><td>' + goods.ename +
                            '</td> <td>' + goods.type +
                            '</td><td>' + goods.cache_time +
                            '分钟</td><td>' +
                            goods.is_warm_up +
                            '</td><td>'
                            + goods.module +
                            '</td><td data-id = "' + goods.id +
                            '"><i class="glyphicon glyphicon-trash operate cacheDelete" ></i>' +
                            '<a href="/admin/cache/edit?id=' + goods.id + '"><i class="glyphicon glyphicon-pencil operate" ></i></a>' +
                            '</td>' +
                            ' </tr>';
                    $( '#goodsTable' ).append( str );
                }
            }
            else
            {
                error( ret.msg );
            }
        }, 'json' ).error( function( ){
            error( '网络不通' );
        } );
    } );
    /*----------------删除-----------------*/
    $( 'table' ).delegate( '.cacheDelete', 'click', function( ){
        var isDel = confirm( '是否删除该缓存' );
        if( isDel )
        {
            var id = $( this ).parent( ).attr( 'data-id' );
            var data = { 'id': id, '<?php echo $this->security->getTokenKey(); ?>': '<?php echo $this->security->getToken(); ?>' };
            var _this = this;
            $.post( '/admin/cache/delete', data, function( ret ){
                if( !ret.status )
                {
                    $( _this ).parents( 'tr' ).remove( );
                }
                else
                {
                    error( ret.msg );
                }
            }, 'json' ).error( function( ){ //网络不通
                error( '网络不通' );
            } );
        }
    } );
} );
function  error( msg )
{
    $( '.alert span' ).text( msg );
    $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
    $( '.alert' ).show( ).fadeOut( 3000 );
}
        </script>
    </body>
</html>