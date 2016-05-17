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
            .goods-table td {
                vertical-align:middle !important;
            }
            .goods-table img {
                width:30px;height:30px; margin-right:10px;
            }
            .glyphicon-search {
                cursor:pointer;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#goodsList">商品</a></li>
            <li role="presentation"><a href="/admin/goods/add">添加商品</a></li>
        </ul>
        <div  class="input-group input-group-sm col-xs-2 pull-right" style="margin-top:-30px;">
            <input type='text' class='form-control'id="searchGoods" placeholder="请输入商品名称" {% if search is defined %} value="{{ search }}" {% endif %} >
            <div class="input-group-addon" id="search"><i class="glyphicon glyphicon-search"></i></div>
        </div>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="userList">
                {% if page.items is defined and page.items is not empty %}
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>商品名称</th>
                            <th>商品分类</th>
                            <th>商品货号</th>
                            <th>商品价格</th>
                            <th>商品销量</th>
                            <th>商品剩余</th>
                            <th>是否上架</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody  class="goods-table" id="goodsTable">
                        {% for item in page.items %}
                        <tr>
                            <td><a href="/home/goods/index/id/{{ item.id }}"> <img style="" src="{{ item.thumb_url | escape_attr }}"/>{{ item.name | e }}</a> </td>
                            <td>{{ item.category_name | e }}</td>
                            <td>{{ item.id | e }}</td>
                            <td><span style="font-size:12px;">￥</span>{{ item.price | e }}</td>
                            <td>{% if item.skuaccum %} {{ item.skuaccum | e }} {% else %} 0 {% endif %}</td>
                            <td><span class="{% if item.skuleft == 0 %}text-danger{% endif %}">{{ item.skuleft | e }}</span></td>
                            <td class="status">{% if item.status == 0 %} <span class="text-danger">下架</span> 
                                {% else %}<span class="text-success">上架</span> {% endif %}</td>
                            <td data-id = "{{ item.id | e }}" >
                                <i class="glyphicon glyphicon-trash operate goodsDelete" ></i>
                                <a href="{{ url( 'admin/goods/edit?id=' ) }}{{ item.id }}"><i class="glyphicon glyphicon-pencil operate" ></i></a>
                                <i class="glyphicon glyphicon-hand-up operate shelve" title="上架"></i>
                                <i class="glyphicon glyphicon-hand-down operate unshelve" title="下架"></i>
                                <a target="blank" href="/home/goods/index/id/{{ item.id }}"><i class="glyphicon glyphicon-eye-open operate" title="预览"></i></a>
                            </td>
                        </tr>
                        {% endfor %}

                    </tbody>
                </table>
                {% else %}
                <div class="col-xs-12 text-center"> 无相关数据  </div>
                {% endif %}
                {% if page.total_pages > 1 %}
                <nav class="text-right" >
                    <ul class="pagination pagination-sm" style="margin-top:0"> 
                        <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="{{ url( 'admin/goods/index?page=' ) }}{{ page.before | e }}" >&laquo;</a></li>
                        {% if  1 != page.current and 1 != page.before %}
                        <li><a href="{{ url( 'admin/goods/index') }}">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="{{ url( 'admin/goods/index?page=') }}{{ page.before }}"><span >{{ page.before | e }}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="{{ url( 'admin/goods/index?page=') }}{{ page.current }}"><span >{{ page.current | e }}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="{{ url( 'admin/goods/index?page=') }}{{ page.next }}">{{ page.next | e }}</a></li>
                        {% endif %}
                        {% if page.next  < page.last - 1 %}
                        <li><a>...</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="{{ url( 'admin/goods/index?page=') }}{{ page.last }}">{{ page.last | e }}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( 'admin/goods/index?page=' ) }}{{ page.next | e }}" >&raquo;</a></li>
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
$( function(){
    /*----------------搜索商品--------------------*/
    $( '#search' ).click( function(){
        var goods = $( '#searchGoods' ).val();
        console.log( goods );
        if( goods )
        {
            location = '/admin/goods/index?goodsName=' +  goods;
        }
        else
        {
            location = '/admin/goods/index';
        }
    } );
    /*----------------删除-----------------*/
    $( 'table' ).delegate( '.goodsDelete', 'click', function(){
        var isDel = confirm( '是否删除该商品' );
        if( isDel )
        {
            var id = $( this ).parent().attr( 'data-id' );
            var data = { 'id': id, '<?php echo $this->security->getTokenKey(); ?>': '<?php echo $this->security->getToken(); ?>' };
            var _this = this;

            $.post( '/admin/goods/delete', data, function( ret ){
                if( !ret.status )
                {
                    $( _this ).parents( 'tr' ).remove();
                }
                else
                {
                    error( ret.msg );
                }
            }, 'json' ).error( function(){ //网络不通
                error( '网络不通' );
            } );
        }
    } );

    /*----------------上架-----------------*/
    $( 'table' ).delegate( '.shelve', 'click', function(){
        var isDel = confirm( '是否确认上架' );
        if( isDel )
        {
            var id = $( this ).parent().attr( 'data-id' );
            var data = { 'id': id, '<?php echo $this->security->getTokenKey(); ?>': '<?php echo $this->security->getToken(); ?>' };
            var _this = this;

            $.post( '/admin/goods/shelve', data, function( ret ){
                if( !ret.status )
                {
                    $( _this ).parents( 'tr' ).find( '.status' ).html( '<span class="text-success">上架</span>' );
                    success( ret.msg );
                }
                else
                {
                    error( ret.msg );
                }
            }, 'json' ).error( function(){ //网络不通
                error( '网络不通' );
            } );
        }
    } );

    /*----------------下架-----------------*/
    $( 'table' ).delegate( '.unshelve', 'click', function(){
        var isDel = confirm( '是否确认下架' );
        if( isDel )
        {
            var id = $( this ).parent().attr( 'data-id' );
            var data = { 'id': id, '<?php echo $this->security->getTokenKey(); ?>': '<?php echo $this->security->getToken(); ?>' };
            var _this = this;

            $.post( '/admin/goods/unshelve', data, function( ret ){
                if( !ret.status )
                {
                    $( _this ).parents( 'tr' ).find( '.status' ).html( '<span class="text-danger">下架</span>' );
                    success( ret.msg );
                }
                else
                {
                    error( ret.msg );
                }
            }, 'json' ).error( function(){ //网络不通
                error( '网络不通' );
            } );
        }
    } );


} );
function success( msg )
{
    $( '.alert span' ).text( msg );
    $( '.alert' ).removeClass( 'alert-danger' ).addClass( 'alert-success' );
    $( '.alert' ).show().fadeOut( 3000 );
}
function  error( msg )
{
    $( '.alert span' ).text( msg );
    $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
    $( '.alert' ).show().fadeOut( 3000 );
}
        </script>
    </body>
</html>