<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/admin/order.css">
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation" class=""><a href="{{ url( 'admin/orders/index' ) }}">订单</a></li>
            <li role="presentation" class="active"><a href="#ordersRead">订单详情</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="ordersRead" style="padding-top:20px;">
                <div data-target="#step-container" class="row-fluid" id="fuelux-wizard">
                    {% if order is defined %}
                    {% if order[ 'status' ] != 5 %}
                    <ul class="wizard-steps" style="margin-bottom:20px;">
                        <li class="active" data-target="#step1">
                            <span class="step">1</span>
                            <span class="title">提交订单</span>
                        </li>
                        <li data-target="#step2" {% if order['status'] >= 1 %} class="active" {% endif %}>
                            <span class="step">2</span>
                            <span class="title">等待付款</span>
                        </li>
                        <li data-target="#step3" {% if order['status'] >= 2 %} class="active" {% endif %}>
                            <span class="step">3</span>
                            <span class="title">等待发货</span>
                        </li>
                        <li data-target="#step4" {% if order['status'] >= 3 %} class="active" {% endif %}>
                            <span class="step">4</span>
                            <span class="title">等待收货</span>
                        </li>
                        <li data-target="#step5" {% if order['status'] >= 4 %} class="active" {% endif %}>
                            <span class="step">5</span>
                            <span class="title">完成</span>
                        </li>
                    </ul>
                    {% endif %}
                    <div class="panel panel-default">
                        <div class="panel-heading">订单跟踪</div>
                        <table class="table">
                             <thead>
                                <tr>
                                   <th>处理时间</th>
                                   <th>处理信息</th>
                                   <th>处理人</th>
                               </tr>
                             </thead>
                            <tbody>
                                <tr>
                                    <td>{{ order[ 'addtime' ] }}</td>
                                    <td>你的订单已经提交,请等待系统确认</td>
                                    <td>客户</td>
                                </tr>
                                {% if track is defined %}
                                    {% for item in track %}
                                    <tr>
                                        <td>{{ item[ 'addtime' ] }}</td>
                                        <td>{{ item[ 'content' ] }}</td>
                                        <td>{% if item['name'] is not empty %} {{ item[ 'name' ] }} {% else %} 客户 {% endif %}</td>
                                    </tr>
                                    {% endfor %}
                                {% endif %}
                            </tbody>
                        </table>
                    </div>
                    {% endif %}
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
                <div class="panel panel-default">
                    <div class="panel-heading">订单信息</div>
                    <table class="table order">
                        <tbody>
                            {% if  order is defined %}
                            <tr>
                                <th> 订单号</th>
                                <td>{{ order[ 'order_sn' ] }}</td>
                                <th> 下单时间</th>
                                <td>{{ order[ 'addtime' ] }}</td>
                            </tr>
                             <tr>
                                <th>支付方式</th>
                                <td>
                                    {% if pay is defined %} {{ pay[ 'pay_name' ]}} {% endif %}
                                </td>
                                <th>运费</th>
                                <td>￥{{ order[ 'freight_fee' ] }}</td>
                            </tr>
                    
                             <tr>
                                <th>应付商品金额</th>
                                <td>{{ order[ 'order_amount' ] }}</td>
                                
                                <th>优惠金额</th>
                                <td>{{ order[ 'discount_amount' ] }}</td>
                                
                            </tr>
                            <tr>
                                <th>发票税金</th>
                                <td>{% if order[ 'invoice_money' ] %} ￥{{ order[ 'invoice_money' ] }} {% endif %}</td>
                                 <th>实付总金额</th>
                                <td>￥{{ order[ 'sum' ] }}</td>
                            </tr>
                            {% if order[ 'freightCompany' ] is defined %}
                            <tr>
                                <th>快递公司</th>
                                <td>{{ order[ 'freightCompany' ] }}</td>
                                <th>快递单号</th>
                                <td colspan='3'>{{ order[ 'freight_sn' ] }}</td>
                            </tr>
                            {% endif %}
                            {% endif %}
                        </tbody>
                    </table>
                </div>
                 <div class="panel panel-default">
                    <div class="panel-heading">收货人信息</div>
                    <table class="table receiver">
                        <tbody>
                            {% if  receiver is defined %}
                            <tr>
                                <th> 收货人姓名</th>
                                <td>{{ receiver[ 'name' ] | e }}</td>
                                <th> 联系手机</th>
                                <td>{{ receiver[ 'tel' ] }}</td>
                                <th> 邮编</th>
                                <td>{{ receiver[ 'zipcode' ] }}</td>
                            </tr>
                             <tr>
                                <th>收货地区</th>
                                <td colspan="5" >
                                  {{ province[ 'name'] }} &nbsp; {{ city[ 'name' ] }} &nbsp; {{ country[ 'name'] }}
                                </td>
                            </tr>
                             <tr>
                                <th>收货地址</th>
                                <td colspan="5">{{ receiver[ 'detail' ] }}</td>
                            </tr>
                         
                            {% endif %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-xs-12 text-center" style="margin-bottom: 50px;">
            {% if order[ 'status' ] == 0 %}
            <button class="btn btn-success btn-sm" id="confirm"> 确认 </button>
            {% endif %}
            <button class="btn btn-default btn-sm" id="cancel"> 返回 </button>
        </div>
        
        <div class="alert alert-danger col-xs-2 text-center" style="margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script>
    $( function(){
       /*-----------------订单确认----------------*/
       $( '#confirm' ).click( function(){
           var orderId = '{{ order[ "id" ] }}';
           $.post( '/admin/orders/confirm', { 'orderId' : orderId }, function( ret ){
               if( ! ret.status )
               {
                   location = '/admin/orders/index';
               }
               else
               {
                   errorMsg( ret.msg );
               }
           }, 'json' ).error( function(){
               errorMsg( '网络不通' );
           });
       });
        
        
        /* ----------取消---------------*/
        $( '#cancel' ).click( function(){
             location = '/admin/orders/index';
             return false;
        });
    });
    function success( obj )
    {
         obj.addClass( 'has-success').removeClass('has-error');
         obj.find('.form-control').after( '<span class="glyphicon glyphicon-ok form-control-feedback"></span>' );
    }
    function error( obj )
    {
         obj.addClass( 'has-error').removeClass('has-success');
         obj.find('.form-control').after( '<span class="glyphicon glyphicon-remove form-control-feedback"></span>' );
    }
    function errorMsg( msg )
    {
        $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
        $( '.alert span' ).text( msg );
        $( '.alert' ).show().fadeOut( 3000 );
    }
    function successMsg( msg )
    {
        $( '.alert' ).addClass( 'alert-success' ).removeClass( 'alert-danger' );
        $( '.alert span' ).text( msg );
        $( '.alert' ).show().fadeOut( 3000 );
    }
        </script>
    </body>
</html>