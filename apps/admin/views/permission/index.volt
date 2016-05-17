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
            <li role="presentation" class="active"><a href="#permissionList">所有权限</a></li>
            <li role="presentation"><a href="/admin/permission/add">添加权限</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="userList">
                {% if page.items is defined and page.items is not empty %}
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>订单编号</th>
                            <th>商品名称</th>
                            <th>方式</th>
                            <th>创建时间</th>
                            <th>退货人</th>
                            <th>操作人</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for item in page.items %}
                        <tr>
                            <td>{{ item.order_sn }}</td>
                            <td>{{ item.goods_name | e }}</td>
                             <td>{% if item.type %} 换货 {% else %} 退货退款 {% endif %}</td>
                            <td>{{ item.addtime }} </td>
                            <td>{{ item.member_name | e }}</td>
                            <td>{{ item.user_name | e }}</td>
                            <td>
                                {% if item.status == 0 %} <span class="text-danger">等待审核中</span> 
                                {% elseif item.status == 1 %}<span class="text-success"> 审核通过</span> 
                                {% elseif item.status == 2 %}<span class="text-muted"> 审核未通过</span> 
                                {% elseif item.status == 3 %}<span class="text-info"> 买家发货 </span>
                                {% elseif item.status == 4 %}<span class="text-info"> 卖家发货 </span> 
                                {% elseif item.status == 5 %}<span class="text-success"> 退款成功 </span> 
                                {% elseif item.status == 6 %}<span class="text-primary"> 退换货完成</span> 
                                {% endif %}
                            </td>
                            <td>
                                <i class="glyphicon glyphicon-trash operate returnDelete"  title="删除" data-id="{{ item.id }}" ></i>
                                <a href="{{ url( 'admin/returns/read?id=' ) }}{{ item.id }}"><i class="glyphicon glyphicon-wrench operate" title="处理"></i></a>

                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
                {% else %}
                 <div class="col-xs-12 text-center">无收货单 </div>
                {% endif %}
                {% if page.total_pages > 1 %}
                <nav class="text-right" >
                    <ul class="pagination pagination-sm" style="margin-top:0"> 
                        <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="{{ url( 'admin/orders/index?page=' ) }}{{page.before}}" >&laquo;</a></li>
                        {% if  1 != page.current and 1 != page.before %}
                        <li><a href="{{ url( 'admin/returns/index') }}">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="{{ url( 'admin/returns/index?page=') }}{{ page.before }}"><span >{{ page.before }}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="{{ url( 'admin/returns/index?page=') }}{{ page.current }}"><span >{{ page.current }}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="{{ url( 'admin/returns/index?page=') }}{{ page.next }}">{{ page.next }}</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="{{ url( 'admin/returns/index?page=') }}{{ page.last }}">{{ page.last }}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( 'admin/returns/index?page=' ) }}{{page.next}}" >&raquo;</a></li>
                    </ul>
                </nav>
                {% endif %}
            </div>
        </div>
 <script src="/js/jquery/jquery-1.11.1.min.js"></script>
<script>
    $( function(){
		
    });
    function errorMsg( msg )
    {
		$( '.alert span' ).text( msg );
		$( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
		$( '.alert' ).show().fadeOut( 3000 );
    }
</script>
    </body>
</html>