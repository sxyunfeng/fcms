<!doctype html>
<html>
    <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
      <style>
        .operate button {
            margin-right:50px;
            width:70px;
        }
       
        .table {
            margin-bottom: 0;
            /*border-bottom: 1px solid #ddd;*/
        }
        .col-xs-2 {
            padding-left:0;
        }
        li {
            list-style:outside none none;
            margin-bottom: 3px;
        }
        .caption {
            padding-right:10px;
            display:inline-block;
            width:100px; 
            text-align:right;
            color:#666;
        }
    </style>
    <body class="wrap">
        <style media="print">
            .noprint { 
              display:none
           }
        </style>
         <div class="col-xs-12 text-center">
            <h4 class=""> 订单 </h4>
        </div>
        <div class="col-xs-12" >
            <table class="table" style="border-bottom: 1px solid #ddd; margin-bottom:0;">
                <tbody>
                    <tr>
                        <td><b>订单号：{{ order[ 'id' ] }}</b></td>
                        <td width="240px" align="right"> 订购日期：{{ order[ 'addtime' ] }} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    
        <div class="col-xs-12">
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
                        <td >￥{{ item[ 'price' ] * item[ 'goods_num' ] }}</td>
                    </tr>
                    {% endfor %}
                    {% endif %}
                    
                </tbody>
            </table>
             <table class="table order" style="marign-bottom:0;">
                <tbody>
                    {% if  order is defined %}
                     <tr>
                        <td style="vertical-align:middle;"> 订单结算 </td>
                        <td width="200px" >
                            <ul>
                                <li>
                                     <span class="caption">商品价格</span>
                                    ￥{{ order[ 'order_amount' ] }}
                                </li>
                                 <li>
                                    <span class="caption"> 运费 </span>
                                    ￥{{ order[ 'freight_fee' ] }}
                                </li>
                                <li >
                                    <span class="caption"> 发票税金</span>
                                     ￥{{ order[ 'invoice_money' ] }}
                                </li>
                                <li>
                                     <span class="caption"> 优惠金额</span>
                                     ￥{{ order[ 'discount_amount' ] }}
                                </li>
                                <li>
                                     <span class="caption"> 实付总金额</span>
                                     ￥{{ order[ 'sum' ] }}
                                </li>
                            </ul>
                        </td>
                    </tr>
                    {% endif %}
                </tbody>
            </table>
            <table class="table receiver" style="margin-bottom: 20px; border-bottom:1px solid #ddd;">
                <tbody>
                    {% if  receiver is defined %}
                    <tr>
                        <td>
                            <span style="margin-right:20px;"> 收货人: {{ receiver[ 'name' ] | e }} </span>
                        联系手机: {{ receiver[ 'tel' ] }}</td>
                        <td align="right"> 收货地址: {{ addressName }} </td>
                    </tr>
                    {% endif %}
                </tbody>
            </table>
        </div>
        <div class="col-xs-12 text-center operate">
            <button class="btn btn-success btn-sm noprint" id="confirm" > 打印 </button>
            <button class="btn btn-default btn-sm noprint" id="cancel" onclick="location='/admin/orders/index';"> 返回 </button>
        </div>
        <div class="noprint">
             <div class="alert alert-danger text-center col-xs-offset-4 col-xs-3" style="display:none;margin-top:20px;">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true" >×</span></button>
                <i class="glyphicon glyphicon-exclamation-sign pull-left"></i>
                <span class="msg"></span>
             </div>
        </div>
       
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script>
            $( '#confirm' ).click( function(){
               $.post( '/admin/orders/lock', { 'id' : '{{ order[ "id" ]}}'}, function( ret ){
                   if( ! ret.status )
                   {
                       window.print();
                   }
                   else
                   {
                       $( '.alert .msg' ).text( ret.msg );
                       $( '.alert' ).toggle();
                   }
               }, 'json' ) ; 
            });
        </script>
    </body>
</html>