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
                width: 100px;
                background:#f5f5f5;
            }
            .col-xs-2, .col-xs-6 {
                padding-left:0;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation" class=""><a href="{{ url( 'admin/orders/index' ) }}">订单</a></li>
            <li role="presentation" class="active"><a href="#ordersDeliver">发货</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane active" id="ordersDeliver" style="padding-top:20px; ">
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
                    <div class="panel-heading">发货信息</div>
                    <table class="table receiver">
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
                                    {% if pay is defined %}{{ pay[ 'pay_name' ]}} {% endif %}
                                </td>
                                <th>运费</th>
                                <td>￥{{ order[ 'freight_fee' ] }}</td>
                            </tr>
                            {% endif %}
                            {% if  receiver is defined %}
                            <tr>
                                <th> 物流公司 </th>
                                <td>
                                    {% if ship is defined %}
                                    <div class="col-xs-6">
                                    <select class="form-control input-sm" id="freight_company">
                                    {% for item in ship %} 
                                    <option value='{{ item[ 'id' ]}}' > {{ item[ 'name' ] }}</option>
                                    {% endfor %}
                                    </select>
                                    </div>
                                    {% endif %}
                                </td>
                                <th> 物流单号 </th>
                                <td> <div class="col-xs-6"><input class="form-control input-sm" type="text" id="freight_sn" value=""/>  </div></td>
                            </tr>
                            <tr>
                                <th>收货人姓名</th>
                                <td>{{ receiver[ 'name' ] | e }}</td>
                                <th>联系手机</th>
                                <td>{{ receiver[ 'tel' ] }}</td>
                                <th>邮编</th>
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
                                <td colspan="5"><div class="col-xs-6"><input class="form-control input-sm" type="text"  value="{{ receiver[ 'detail' ] }}"/>  </div></td>
                            </tr>
                         
                            {% endif %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-xs-12 text-center">
            {% if order[ 'status' ] == 2 %}
            <button class="btn btn-success btn-sm" id="confirm"> 保存 </button>
            {% endif %}
            <button class="btn btn-default btn-sm" id="cancel"> 返回 </button>
        </div>
        
        <div class="alert alert-danger col-xs-2 text-center" style="margin-left:40%;display:none;">
            <span>网络错误</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script>
    $( function(){
       /*-----------------订单发货----------------*/
       $( '#confirm' ).click( function(){
           var orderId = '{{ order[ "id" ] }}';
           var freight_company =  $.trim( $( '#freight_company' ).val() );
           var freight_sn = $.trim( $( '#freight_sn' ).val() );
           
            if( !confirm( '确认发货吗？' ))
            {
                 return false;
            }
           
            if( ! freight_sn )
            {
                errorMsg( '请输入物流单号' );
                return false;
            }
            var data = { 'id' : orderId, 'freight_company': freight_company, 'freight_sn' : freight_sn };
            $.post( '/admin/orders/saveDeliver', data, function( ret ){
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