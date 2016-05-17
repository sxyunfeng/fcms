<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <style>
            body {
                 font-family: "Arial","微软雅黑",sans-serif;
            }
            .num {
                font-size: 20px;
                margin:0 5px;
            }
            .glyphicon {
                margin-right:5px;
            }
        </style>
    </head>
    <body class="wrap">
         {% if count[ 'user' ] is defined and count[ 'order_user' ] is defined %}
        <div class="col-xs-4">
             <div class="panel panel-success mem">
                 <div class="panel-heading"><i class="glyphicon glyphicon-user"></i>会员</div>
                 <div class="panel-body text-center">
                     <div class="col-xs-6">
                         会员总数 <span class="num">{{ count[ 'user' ] | e }}</span>
                     </div>
                      <div class="col-xs-6">
                         有订单的会员数 <span class="num">{{ count[ 'order_user' ] | e }}</span>
                     </div>
                 </div>
            </div>
        </div>
        {% endif %}
        {% if count[ 'order' ] is defined and count[ 'wait_order' ] is defined %}
        <div class="col-xs-4">
           <div class="panel panel-warning order">
               <div class="panel-heading"><i class="glyphicon glyphicon-bookmark"></i>订单</div>
                <div class="panel-body text-center">
                     <div class="col-xs-6">
                         订单总数 <span class="num">{{ count[ 'order' ] | e }}</span>
                     </div>
                      <div class="col-xs-6">
                         待发货订单数 <span class="num">{{ count[ 'wait_order' ] | e }}</span>
                     </div>
                 </div>  
            </div>
        </div>  
        {% endif %}
        {% if count[ 'goods' ] is defined and count[ 'alert_goods' ] is defined %}
        <div class="col-xs-4">
            <div class="panel panel-info goods">
                <div class="panel-heading"><i class="glyphicon glyphicon-gift"></i>商品</div>
                    <div class="panel-body text-center">
                        <div class="col-xs-6">
                            商品总数 <span class="num"> {{ count[ 'goods' ] | e }} </span>
                        </div>
                        <div class="col-xs-6">
                            库存告警数 <span class="num">{{ count[ 'alert_goods' ] | e }} </span>
                        </div>
                </div>
            </div>
        </div>
        {% endif %}
        
        <div class="" style="position:fixed;width:280px;z-index:100;right:0px;">
            <div role="alert" class="alert alert-success alert-dismissible fade in alert-template waitDeliver"  
                 {% if count[ 'wait_order' ] %} style="display:block" {% else %} style="display:none" {% endif %}>
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <div id="order">
                    <strong class="title">待发货订单</strong><br/>
                    <span >您有<span class="num">{{ count[ 'wait_order']}}</span>个待发货订单，请处理。</span> 
                </div>
            </div>
            <div role="alert" class="alert alert-success alert-dismissible fade in applyReturn"
                 {% if count[ 'order_return' ] %} style="display:block" {% else %} style="display:none" {% endif %} >
                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                <div id="return">
                    <strong>退货申请</strong> <br/>
                    <span>您有<span class="num">{{ count[ "order_return" ] }}</span>个退货申请，请处理。</span>
                </div>
            </div>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script> 
/*----------------------通知点击响应----------------------------*/
    var applyReturnNum = waitDeliverNum = 0;
    $( '.close' ).click( function(){
       var parent = $( this ).parent();
       if( parent.hasClass( 'waitDeliver' ) )
       {
           waitDeliverNum = 0;
       }
       else if( parent.hasClass( 'applyReturn' ))
       {
           applyReturnNum = 0;
       }
       parent.toggle(); 
    });
    $( '#order' ).click( function(){
        var order = $( '#order', parent.document ).click(); //访问父类的元素
        $( '.waitDeliver' ).hide();
        waitDeliverNum = 0;
    });
   $( '#return' ).click( function(){
       var returns = $( '#return', parent.document ).click(); //访问父类的元素
       $( '.applyReturn' ).hide();
        applyReturnNum = 0;
   });
/*----------------------通知服务---------------------------*/
    var lastModifiedSince = lastNoneMatch = '';
    var timeId = 0;
    var enable = false; //第一次接收的通知放弃
    
    function subscribe( ) {
        timeId = window.setInterval( showNotice, 3000 ); //3s没有收到数据就显示通知
        $.ajax({
            type: 'get', // 获取头信息，type=HEAD即可
            url : 'http://xa.huaer.dev/sub?id=shop' + '{{ shopId }}' ,
            headers: {
                  "If-Modified-Since": lastModifiedSince,
                  "If-None-Match": lastNoneMatch
              },
            success: function(data, status, xhr) {  
                var obj = eval( '(' + data + ')' );
                addNotice( obj.type );
                modifiedSince = xhr.getResponseHeader( 'Last-Modified' );
                etag =  xhr.getResponseHeader( 'Etag' ) ;
               
                if( lastModifiedSince == modifiedSince && lastNoneMatch == etag )
                {
                    return false; //没有了新数据了
                }
                else
                {
                    lastModifiedSince = modifiedSince;
                    lastNoneMatch = etag;
                    timeId && window.clearInterval( timeId );
                    subscribe(); //继续获得新数据
                }
            } 
        });
    }
    subscribe();

    function addNotice( type )
    {
        if( type === 'applyReturn' )
        {
            applyReturnNum++;
        } 
        else if( type === 'waitDeliver' )
        {
            waitDeliverNum++;   
        }
    }
    function showNotice()
    {
        if( applyReturnNum && enable )
        {
            $( '.applyReturn .num' ).text( applyReturnNum );
            $( '.applyReturn' ).show();
        }
        if( waitDeliverNum && enable )
        {
            $( '.waitDeliver .num' ).text( waitDeliverNum );
            $( '.waitDeliver' ).show();
        }
        if( ! enable )
        {
            applyReturnNum = 0;
            waitDeliverNum = 0;//第一次的数据全部清零
            enable = true;
        }
        timeId && window.clearInterval( timeId );
    }
        
</script>
    </body>
</html>