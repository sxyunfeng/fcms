<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <style>
            .operate {
                margin-right:10px;
            }
            .operate:hover {
                cursor:pointer;
                color:green;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#orderList">订单</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="userList">
                {% if page.items is defined and page.items is not empty %}
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>订单号</th>
                            <!--<th>商品名称</th>-->
                            <th>下单时间</th>
                            <!--<th>订单金额</th>-->
                            <th>结算金额</th>
                            <th>支付方式</th>
                            <th>当前状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for item in page.items %}
                        <tr data-id="{{ item.id | e }}">
                            <td>{{ item.order_sn | e }}</td>
                            <!--<td>{{ item.goods_name }}</td>-->
                            <td>{{ item.addtime | e }} </td>
                            <!--<td>￥{{ item.order_amount }}</td>-->
                            <td>￥{{ item.sum | e }}</td>
                            <td>{{ item.pay_name | e }}</td>
                            <td>{% if item.status == 1 %} <span class="text-danger">未付款</span> 
                                {% elseif item.status == 2 %}<span class="text-danger"> 待发货 </span> 
                                {% elseif item.status == 3 %}<span class="text-info"> 待收货 </span> 
                                {% elseif item.status == 4 %}<span class="text-info"> 确认收货 </span>
                                {% elseif item.status == 5 %}<span class="text-success"> 订单取消 </span> 
                                {% endif %}
                            </td>
                            <td>
                                <i class="glyphicon glyphicon-print operate orderPrint"  title="打印"  ></i>
                                <i class="glyphicon glyphicon-trash operate orderDelete"  title="删除" data-id="{{ item.id }}" ></i>
                                <a href="#" class="orderRead"><i class="glyphicon glyphicon-eye-open operate " title="查看"></i></a>
                                {% if item.status == 2 %} 
                                 <i class="glyphicon glyphicon-send operate orderDeliver" title="发货"  ></i>
                                {% endif %}
                                {% if item.pay_id == 5 and item.status == 1 %}
                                <i class="glyphicon glyphicon-piggy-bank operate orderBalance" title="结算"></i>
                                {% endif %}
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
                {% else %}
                <div class="col-xs-12 text-center">无订单 </div>
                {% endif %}
                {% if page.total_pages > 1 %}
                <nav class="text-right" >
                    <ul class="pagination pagination-sm" style="margin-top:0"> 
                        <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="{{ url( 'admin/orders/index?page=' ) }}{{page.before}}" >&laquo;</a></li>
                        {% if  1 != page.current and 1 != page.before %}
                        <li><a href="{{ url( 'admin/orders/index') }}">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="{{ url( 'admin/orders/index?page=') }}{{ page.before }}"><span >{{ page.before }}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="{{ url( 'admin/orders/index?page=') }}{{ page.current }}"><span >{{ page.current }}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="{{ url( 'admin/orders/index?page=') }}{{ page.next }}">{{ page.next }}</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="{{ url( 'admin/orders/index?page=') }}{{ page.last }}">{{ page.last }}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( 'admin/orders/index?page=' ) }}{{page.next}}" >&raquo;</a></li>

                    </ul>
                </nav>
                {% endif %}
            </div>
        </div>
        <div class="alert alert-danger text-center col-xs-3" style="display:none;margin-left: 40%;">
            <i class="glyphicon glyphicon-warning-sign pull-left"></i>
            <span>删除失败</span>
        </div>

        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script>
$( function(){
    /*---------------订单结算--------------*/
    $( 'table' ).delegate( '.orderBalance', 'click', function(){
        var id = $( this ).parents( 'tr' ).attr( 'data-id' );
        $.post( '/admin/orders/balance', { 'id' : id }, function( ret ){
            if( ! ret.status )
            {
                successMsg( ret.msg );
                setTimeout( 'location.reload()', 2500 );
            }
            else
            {
                errorMsg( ret.msg );
            }
        }, 'json' ).error( function(){
            errorMsg( '网络不通' );
        } );
    } );
    /*----------------打印-----------------*/
    $( 'table' ).delegate( '.orderPrint', 'click', function(){
        var id = $( this ).parents( 'tr' ).attr( 'data-id' );
        location = '/admin/orders/print?id=' + id;
        return false;
    } );
    
    /*----------------发货-----------------*/
    $( 'table' ).delegate( '.orderDeliver', 'click', function(){
        var id = $( this ).parents( 'tr' ).attr( 'data-id' );
        location = '/admin/orders/deliver?id=' + id;
        return false;
    } );
    
    /*----------------查看-----------------*/
    $( 'table' ).delegate( '.orderRead', 'click', function(){
        var id = $( this ).parents( 'tr' ).attr( 'data-id' );
        location = '/admin/orders/read?id=' + id;
        return false;
    } );
    
    /*----------------点击表格-------------------*/
    $( 'tbody' ).delegate( 'tr', 'click', function( event ){
        var target = event.target.tagName;
        if( target === 'TD')
        {
            var id = $( this ).attr( 'data-id' );
            location = '/admin/orders/read?id=' + id;
        }    
    });
    
   /*----------------删除-----------------*/
   $( 'table' ).delegate( '.orderDelete', 'click', function(){
        var isDel = confirm( '是否删除订单' );
        if( isDel )
        {
            var id = $( this ).attr( 'data-id' );
            var data = {'id': id, '<?php echo $this->security->getTokenKey();?>' : '<?php echo $this->security->getToken();?>'};
            var _this = this;

            $.post( '/admin/orders/delete', data, function( ret ){
                if( !ret.status )
                {
                    $( _this ).parents( 'tr' ).remove();
                }
                else
                {
                   errorMsg( ret.msg );
                }
            }, 'json').error(function(){ //网络不通
                errorMsg( '网络不通' );
            });
        }
   });
});
    function  errorMsg( msg )
    {
       $( '.alert span' ).text( msg );
       $( '.alert i' ).addClass( 'glyphicon-warning-sign' ).removeClass( 'glyphicon-ok' );
       $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
       $( '.alert' ).show().fadeOut( 3000 );
    }
    function  successMsg( msg )
    {
       $( '.alert span' ).text( msg );
       $( '.alert i' ).removeClass( 'glyphicon-warning-sign' ).addClass( 'glyphicon-ok' );
       $( '.alert' ).addClass( 'alert-success' ).removeClass( 'alert-danger' );
       $( '.alert' ).show().fadeOut( 3000 );
    }
        </script>
    </body>
</html>
