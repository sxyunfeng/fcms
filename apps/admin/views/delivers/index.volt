<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
    </head>
    <style>
        .operate {
            margin-right:10px;
        }
        .operate:hover {
            cursor:pointer;
            color:green;
        }
    </style>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#orderList">发货单</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="userList">
                {% if page.items is defined and page.items is not empty %}
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>订单编号</th>
                            <th>物流单号</th>
                            <th>物流公司</th>
                            <th>收货人</th>
                            <th>收货电话</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for item in page.items %}
                        <tr>
                            <td>{{ item.id }}</td>
                            <td>{{ item.freight_sn }} </td>
                            <td>{{ item.freight_name | e }}</td>
                            <td>{{ item.name | e }}</td>
                            <td>{{ item.tel | e }}</td>
                            <td>{{ item.freight_accesstime | e }}</td>
                            <td>
                                <a class="text-muted" href="{{ url( 'admin/delivers/print?id=' ) }}{{ item.id }}"><i class="glyphicon glyphicon-print operate deliverPrint" title="打印"></i></a>
                                <a href="{{ url( 'admin/delivers/read?id=' ) }}{{ item.id }}"><i class="glyphicon glyphicon-eye-open operate " title="查看"></i></a>
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
                        <li><a href="{{ url( 'admin/delivers/index') }}">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="{{ url( 'admin/delivers/index?page=') }}{{ page.before }}"><span >{{ page.before }}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="{{ url( 'admin/delivers/index?page=') }}{{ page.current }}"><span >{{ page.current }}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="{{ url( 'admin/delivers/index?page=') }}{{ page.next }}">{{ page.next }}</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="{{ url( 'admin/delivers/index?page=') }}{{ page.last }}">{{ page.last }}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( 'admin/delivers/index?page=' ) }}{{page.next}}" >&raquo;</a></li>
                    </ul>
                </nav>
                {% endif %}
            </div>
        </div>
    </body>
</html>