<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <style>
            button {
                margin-right:50px;
                width:70px;
            }
            th {
                font-weight: normal;
            }
            table.order th, table.receiver th {
                text-align: left;
                width: 90px;
                background:#f5f5f5;
            }
            .col-xs-2 {
                padding-left:0;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation" class=""><a href="{{ url( 'admin/delivers/index' ) }}">发货单</a></li>
            <li role="presentation" class="active"><a href="#deliversRead">发货单详情</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="deliversRead" style="padding-top:20px;">
                
                 <div class="panel panel-default">
                    <div class="panel-heading">收货人信息</div>
                    <table class="table receiver">
                        <tbody>
                            {% if order is defined %}
                            <tr>
                                <th>订单编号</th>
                                <td>{{ order[ 'id' ] }}</td>
                                <th> 发货时间 </th>
                                <td colspan='3'> {{ order[ 'freight_accesstime' ] }}</td>
                            </tr>
                            <tr>
                                <th>快递公司</th>
                                <td>{{ order[ 'freightCompany' ] }}</td>
                                <th>快递单号</th>
                                <td colspan='3'>{{ order[ 'freight_sn' ] }}</td>
                            </tr>
                            {% endif %}
                            {% if  receiver is defined %}
                            <tr>
                                <th> 收货人姓名</th>
                                <td>{{ receiver[ 'name' ] | e }}</td>
                                <th> 联系手机</th>
                                <td>{{ receiver[ 'tel' ] }}</td>
                                <th>邮编</th>
                                <td>{{ receiver[ 'zipcode' ] }}</td>
                            </tr>
                          
                             <tr>
                                <th>收货地址</th>
                                <td colspan="5">{{ addressName }}</td>
                            </tr>
                         
                            {% endif %}
                        </tbody>
                    </table>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">商品信息</div>
                    <table class="table">
                        <thead>
                             <tr>
                                <th>货号</th>
                                <th>商品名</th>
                                <th>价格</th>
                                <th>数量</th> 
                                <th>小计</th> 
                            </tr>
                        </thead>
                        <tbody>
                            {% if  goodsInfo is defined %}
                            {% for item in goodsInfo %}
                            <tr>
                                <td>{{ item[ 'id' ]}}</td>
                                <td>{{ item[ 'name' ] | e }}</td>
                                <td>￥{{ item[ 'price' ] }}</td>
                                <td>{{ item[ 'goods_num' ] }}</td>
                                <td>￥{{ item[ 'price' ] * item[ 'goods_num' ] }}</td>
                            </tr>
                            {% endfor %}
                            {% endif %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-xs-12 text-center">
            <button class="btn btn-default btn-sm" id="cancel" onclick="location='/admin/delivers/index';"> 返回 </button>
        </div>
       
 
    </body>
</html>