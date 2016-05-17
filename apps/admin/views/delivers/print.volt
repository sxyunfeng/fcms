<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
          <style>
            .operate button {
                margin-right:50px;
                width:70px;
            }
            .col-xs-2 {
                padding-left:0;
            }
            li {
                list-style:outside none none;

                float:right;
            }
            .caption {
                margin-left:20px;
                display:inline-block;
                text-align:right;
                color:#666;
            }
        </style>
    </head>
    <body class="wrap">
        <style media="print">
            .noprint { 
              display:none
           }
        </style>
         <div class="col-xs-12 text-center">
            <h4 class=""> 购物清单 </h4>
        </div>
        <div class="col-xs-12" >
            <table class="" style="width:100%;border: 0">
                <tbody>
                    <tr >
                        <td>姓名：{{ username }}</td>
                        <td> 快递公司：{{ order[ 'freightCompany' ] }} </td>
                        <td width="200px" >订单号：{{ order[ 'id' ] }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">客户地址：{{ addressName }}</td>
                        <td > 客户电话：{{ receiver[ 'tel' ] }} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    
        <div class="col-xs-12">
            <table class="table table-bordered" style="margin-top:5px;">
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
                        <td >￥{{  item[ 'price' ] * item[ 'goods_num' ] }}</td>
                    </tr>
                    {% endfor %}
                    {% endif %}
                </tbody>
            </table>
        </div>
         {% if  order is defined %}
        <div  class='col-xs-12 pull-right'>
           <ul>
               <li>
                   <span class="caption">商品价格</span>
                   ￥{% if order[ 'order_amount' ] %}{{ order[ 'order_amount' ] }}{% else %} 0 {% endif %}
               </li>
               <li>
                   <span class="caption"> 运费 </span>
                   ￥{% if order[ 'freight_fee' ] %}{{ order[ 'freight_fee' ] }} {% else %} 0 {% endif %}
               </li>
               <li>
                   <span class="caption"> 发票税金</span>
                    ￥{% if order[ 'invoice_money' ] %}{{ order[ 'invoice_money' ] }} {% else %} 0 {% endif %}
               </li>
               <li>
                    <span class="caption"> 优惠金额</span>
                    ￥{% if order[ 'discount_amount' ] %}{{ order[ 'discount_amount' ] }} {% else %} 0 {% endif %}
               </li>
               <li>
                    <span class="caption"> 实付总金额</span>
                    ￥{{ order[ 'sum' ] }}
               </li>
           </ul>
       </div>
       {% endif %}
        <div class="col-xs-12 ">
            <dl>
                <dt>卖家备注</dt>
                <dd>祝您生活愉快，工作顺利，合家安康！</dd>
            </dl>
            
        </div>
        <div class="col-xs-12 text-center operate">
            <button class="btn btn-success btn-sm noprint" id="confirm" onclick='print();'> 打印 </button>
            <button class="btn btn-default btn-sm noprint" id="cancel" onclick="location='/admin/delivers/index';"> 返回 </button>
        </div>
        <div class="noprint">
             <div class="alert alert-danger text-center col-xs-offset-4 col-xs-3" style="display:none;margin-top:20px;">
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true" >×</span></button>
                <i class="glyphicon glyphicon-exclamation-sign pull-left"></i>
                <span class="msg"></span>
             </div>
        </div>
    </body>
</html>