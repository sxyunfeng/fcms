<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/admin/order.css">
        <style>
            button {
                margin-right:50px;
                width:70px;
            }
            th {
                font-weight: normal;
            }
            table.order th, table.receiver th, table.return th {
                vertical-align: middle !important;
                text-align: left;
                width: 100px;
                background:#f5f5f5;
            }
            table.return td {
                vertical-align: middle !important;
            }
            .col-xs-2 {
                padding-left:0;
            }
        </style>
    </head>

    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist" id="tabs">
            <li role="presentation" class=""><a href="{{ url( 'admin/returns/index' ) }}">退货单</a></li>
            <li role="presentation" class="active"><a href="#returnsRead">退货单详情</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpannel" class="tab-pane fade in active" id="returnsRead" style="padding-top:20px;">
                <div data-target="#step-container" class="row-fluid" id="fuelux-wizard">
                    {% if goodsReturn is defined %}
                    {% if goodsReturn[ 'status' ] != 2 %}
                    <ul class="wizard-steps" style="margin-bottom:20px;">
                        <li class="active" data-target="#step1">
                            <span class="step">1</span>
                            <span class="title">处理中</span>
                        </li>
                        <li data-target="#step2" {% if goodsReturn['status'] >= 1 %} class="active" {% endif %}>
                            <span class="step">2</span>
                            <span class="title">
                               审核通过 
                            </span>
                        </li>
                        <li data-target="#step3" {% if goodsReturn['status'] >= 3 %} class="active" {% endif %}>
                            <span class="step">3</span>
                            <span class="title">买家发货</span>
                        </li>
                        <li data-target="#step4" {% if goodsReturn['status'] >= 4 %} class="active" {% endif %}>
                            <span class="step">4</span>
                            {% if goodsReturn[ 'type' ] == 1%}
                            <span class="title">卖家发货</span>
                            {% else %}
                             <span class="title">买家退款</span>
                            {% endif %}
                        </li>
                        <li data-target="#step5" {% if goodsReturn['status'] >= 6 %} class="active" {% endif %}>
                            <span class="step">5</span>
                            <span class="title">
                                完成
                            </span>
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
                                    <td>{{ goodsReturn[ 'addtime' ] }}</td>
                                    <td>申请退换货已经提交,请等待系统确认</td>
                                    <td>客户</td>
                                </tr>
                                {% if track is defined %}
                                    {% for item in track %}
                                    <tr>
                                        <td>{{ item[ 'addtime' ] }}</td>
                                        <td>{{ item[ 'content' ] }}</td>
                                        <td>{% if item[ 'name' ] %} {{ item[ 'name' ] }} {% else %} 客户 {% endif %}</td>
                                    </tr>
                                    {% endfor %}
                                {% endif %}
                            </tbody>
                        </table>
                    </div>
                    {% endif %}
                </div>
                 <div class="panel panel-default" style="position:relative;">
                    <div class="panel-heading">退货信息</div>
                    <table class="table return">
                        <tbody >
                            {% if goodsReturn is defined %}
                            <tr>
                                <th>退换货状态</th>
                                <td>
                                    {% if goodsReturn[ 'status' ] == 0 %} <span class="text-danger">审核处理中</span> 
                                    {% elseif goodsReturn[ 'status' ] == 1 %}<span class="text-success"> 审核通过</span> 
                                    {% elseif goodsReturn[ 'status' ] == 2 %}<span class="text-muted"> 审核未通过</span> 
                                    {% elseif goodsReturn[ 'status' ] == 3 %}<span class="text-info"> 买家发货 </span>
                                    {% elseif goodsReturn[ 'status' ] == 4 %}<span class="text-info"> 卖家发货 </span> 
                                    {% elseif goodsReturn[ 'status' ] == 5 %}<span class="text-success"> 退款成功 </span> 
                                    {% elseif goodsReturn[ 'status' ] == 6 %}<span class="text-primary"> 退换货完成</span> 
                                    {% endif %}
                                     {% if goodsReturn[ 'status' ] == 3  and goodsReturn[ 'type' ] == 0 %} 
                                     <button class="btn btn-success btn-sm pull-right" id="refund"> 退款</button></td>
                                     {% endif %}
                                </td>
                                <th> 申请时间 </th>
                                <td colspan='3'><?php if( isset( $receiver[ 'name' ]) ) echo $receiver[ 'name'];?> &nbsp;&nbsp;
                                    {{ goodsReturn[ 'addtime' ] }}</td>
                            </tr>
                            <tr>
                                <th>退换货类型</th>
                                <td>{% if goodsReturn[ 'type' ]  == 0 %} 退货 {% else %} 换货 {% endif %}
                                    <br>
                                    <span class="text-info">
                                        {% if goodsReturn[ 'reason_type' ] == 0 %} 重量不符 
                                        {% elseif goodsReturn[ 'reason_type' ] == 1 %} 变质
                                        {% endif %}
                                    </span>
                                </td>
                                <th>退换货凭证</th>
                                <td colspan='3'>
                                    <img style="width:50px; height:50px;" src="{{ goodsReturn[ 'img' ]}}" id="proof">
                                    <img style="position:absolute;width:200px; height:200px; left: 40%; bottom:70px;display:none; z-index: 100;" src="{{ goodsReturn[ 'img' ]}}" >
                                </td>
                            </tr>
                            <tr>
                                <th>退换货原因</th>
                                <td colspan='5'>{{ goodsReturn[ 'reason_content' ] | e}}</td>
                            </tr>
                            <tr>
                                <th>处理意见</th>
                                <td><input class="form-control" type="text" id="content" value="{{ goodsReturn[ 'handling_idea'] }}"></td>
                                <th>
                                    提交处理
                                </th>
                                <td colspan="3" style="color: "> 
                                    <label class="radio-inline" style="" > <input type="radio"  name="agree" value="1" checked/> 同意 </label>
                                    <label class="radio-inline"> <input type="radio"  name="agree" value="2"/> 不同意 </label>
                                    {% if goodsReturn[ 'status' ] == 0 %}
                                    <button class="btn btn-success btn-sm pull-right" id="save"> 提交</button>
                                    {% endif %}
                                </td>
                            </tr>
                            {% if goodsReturn[ 'status' ] >= 3 %} 
                            <tr>
                                <th>买家快递公司</th>
                                <td>{{ goodsReturn[ 'express_name' ]}}</td>
                                <th>买家快递单号</th>
                                <td colspan='3'>{{ goodsReturn[ 'express_no' ] | e}}</td>
                            </tr>
                            {% endif %}
                            {% if goodsReturn[ 'status' ] >= 3  and goodsReturn[ 'type' ] == 1 %} 
                            <tr>
                                <th>卖家快递公司</th>
                                <td>
                                    <div class="col-xs-6" style="padding-left:0;">
                                        <select class="form-control" id="send_express_id" >
                                        {% for item in sendExpress %}
                                        <option value="{{ item.id }}" {% if goodsReturn[ 'send_express_id' ] == item.id %} selected {% endif %}>{{ item.name }}</option>
                                        {% endfor %}
                                    </select>
                                    </div>
                                    
                                </td>
                                <th>卖家快递单号</th>
                                <td colspan='3'>
                                    <div class='col-xs-6' style='padding-left:0;'>
                                     <input class="form-control" type="text" id="send_express_no" value="{{ goodsReturn[ 'send_express_no'] }}">
                                    </div>
                                  {% if goodsReturn[ 'status' ] == 3 %} 
                                  <button class="btn btn-success btn-sm pull-right" id="send"> 发货</button>
                                  {% endif %}
                                </td>
                            </tr>
                            {% endif %}
                           
                         {% endif %}
                        </tbody>
                    </table>
                    <div class="alert alert-danger text-center " style="position:absolute;right:50px; bottom:0px; margin-bottom: -50px; width:200px; display:none;">
                        <i class="glyphicon glyphicon-warning-sign pull-left"></i>
                        <span> 网络不通</span>
                    </div>
                </div>
                 
                <div class="panel panel-default">
                    <div class="panel-heading">商品信息</div>
                    <table class="table">
                        <thead>
                             <tr>
                                <th>商品货号</th>
                                <th>商品名</th>
                                <th>价格</th>
                                <th>数量</th> 
                                <th>小计</th> 
                            </tr>
                        </thead>
                        <tbody>
                            {% if  goodsReturn is defined %}
                            <tr>
                                <td> {{ goodsReturn[ 'goods_id' ]}}</td>
                                <td>{{ goodsReturn[ 'name' ] | e }}</td>
                                <td>￥{{ goodsReturn[ 'price' ] }}</td>
                                <td>{{ goodsReturn[ 'goods_num' ] }}</td>
                                <td>￥{{ goodsReturn[ 'price' ] * goodsReturn[ 'goods_num' ] }}</td>
                            </tr>
                         
                            {% endif %}
                        </tbody>
                    </table>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">订单信息</div>
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
            </div>
        </div>
      
        <div class="col-xs-12 text-center" style="margin-bottom:50px;">
            <button class="btn btn-default btn-sm" id="cancel" onclick="location='/admin/returns/index';"> 返回 </button>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script>
            $( function(){
                $( '#save' ).click( function(){
                    if( confirm( '确认处理结果吗？' )) 
                    { 
                        var content = $( '#content' ).val();
                        var agree = $( 'input[name="agree"]:checked').val();
                        $.post( '/admin/returns/save' , { 'id' : '{{ goodsReturn[ 'id'] }}' , 'content' : content, 'agree': agree }, function( ret ){
                            if( ! ret.status )
                            {
                                location.reload();
                            }
                            else
                            {
                                error( ret.msg );
                            }
                        }, 'json').error( function(){
                            error( '网络不通' );
                        });
                    }
                });
                
                $( '#proof' ).hover( function(){
                    $( this ).siblings().show();
                },function(){
                    $( this ).siblings().hide();
                });
                
            /*----------------退款-----------------*/
            $( 'table' ).delegate( '#refund', 'click', function(){
                 var isRefund= confirm( '是否确认退款' );
                 if( isRefund )
                 {
                     var data = {'id': '{{ goodsReturn[ 'id'] }}', '<?php echo $this->security->getTokenKey();?>' : '<?php echo $this->security->getToken();?>'};
                     $.post( '/admin/returns/refund', data, function( ret ){
                         if( !ret.status )
                         {
                             location.reload();
                         }
                         else
                         {
                            error( ret.msg );
                         }
                     }, 'json').error(function(){ //网络不通
                         error( '网络不通' );
                     });
                 }
            });
             
            /*----------------发货-----------------*/
            $( 'table' ).delegate( '#send', 'click', function(){
                 var isSend= confirm( '是否确认发货' );
                 if( isSend )
                 {
                     var express_id = $( '#send_express_id' ).val();
                     var express_no = $( '#send_express_no' ).val();
                     var data = {'id': '{{ goodsReturn[ 'id'] }}',
                        'send_express_id' : express_id,
                        'send_express_no' : express_no,
                        '<?php echo $this->security->getTokenKey();?>' : '<?php echo $this->security->getToken();?>'};
                     $.post( '/admin/returns/send', data, function( ret ){
                         if( !ret.status )
                         {
                             location.reload();
                         }
                         else
                         {
                            error( ret.msg );
                         }
                     }, 'json').error(function(){ //网络不通
                         error( '网络不通' );
                     });
                 }
            }); 
            });
            function error( msg )
            {
                $( '.alert span' ).text( msg );
                $( '.alert' ).show().fadeOut( 3000 );
            }
        </script>
 
    </body>
</html>