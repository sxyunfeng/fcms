<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#memberList">商品评论</a></li>
            <style>
                .glyphicon-star {
                    color:goldenrod;
                }
                .glyphicon-star:hover {
                    color:red;
                    cursor:pointer;
                }
                .operate {
                     margin-right:10px;
                     cursor:pointer;
                }
                .operate:hover {
                    color:green;
                }
            </style>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="userList">
                {% if page.items is defined and page.items is not empty %}
                <table class="table table-hover table-bordered" style="">
                    <thead>
                        <tr>
                            <th>商品名</th>
                            <th>商品评价</th>
                            <th>商品评分</th>
                            <th>服务评分</th>
                            <th>评价人</th>
                            <th>是否回复</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for item in page.items %}
                        <tr>
                            <td>{{ item.goods_name }}</td>
                            <td style="width:400px; "><div style="width:400px;overflow: hidden; text-overflow: ellipsis; "> {{ item.comment | e }}</div></td>
                            <td> 
                                <?php if( $item->goods_marks ) { for($i = 0;$i < $item->goods_marks; $i++ ){ ?>  
                                <i class="glyphicon glyphicon-star"></i> <?php } } ?> 
                            </td>
                            <td>
                                <?php if( $item->serv_marks ) { for($i = 0;$i < $item->serv_marks; $i++ ){ ?>  
                                <i class="glyphicon glyphicon-star"></i> <?php } } ?> 
                            </td>
                            <td>{{ item.username }}</td>
                            <td>{% if item.is_reply == 0 %} <span class="text-danger">未回复</span> {% else %} 回复 {% endif %}</td>
                            <td>
                                {% if page.shop_id == 0 %}
                                <i class="glyphicon glyphicon-trash operate commentsDelete" data-id="{{ item.id }}" ></i>
                                {% endif %}
                                <i class="glyphicon glyphicon-eye-close operate commentToggle" data-id="{{ item.id }}" title="隐藏或显示评论"></i>
                                <a href="{{ url( 'admin/goodscomments/reply?id=' ) }}{{ item.id }}"><i class="glyphicon glyphicon-comment operate commentReply" ></i></a>
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
                {% else %}
                <div class="col-xs-12 text-center">无商品评论 </div> 
                {% endif %}
                {% if page.total_pages > 1 %}
                <nav class="text-right" >
                    <ul class="pagination pagination-sm" style="margin-top:0"> 
                        <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="{{ url( 'admin/goodscomments/index?page=' ) }}{{page.before}}" >&laquo;</a></li>
                        {% if  1 != page.current and 1 != page.before %}
                        <li><a href="{{ url( 'admin/goodscomments/index') }}">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="{{ url( 'admin/goodscomments/index?page=') }}{{ page.before }}"><span >{{ page.before }}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="{{ url( 'admin/goodscomments/index?page=') }}{{ page.current }}"><span >{{ page.current }}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="{{ url( 'admin/goodscomments/index?page=') }}{{ page.next }}">{{ page.next }}</a></li>
                        {% endif %}
                        {% if page.next  < page.last - 1 %}
                        <li><a>...</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="{{ url( 'admin/goodscomments/index?page=') }}{{ page.last }}">{{ page.last }}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( 'admin/goodscomments/index?page=' ) }}{{page.next}}" >&raquo;</a></li>

                    </ul>
                </nav>
                {% endif %}
            </div>
        </div>
        <div class="alert alert-danger text-center col-xs-2" style="display:none;margin-left: 40%;">
            <span>删除失败</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script>
$( function(){
   /*----------------删除-----------------*/
   $( 'table' ).delegate( '.commentsDelete', 'click', function(){
        var isDel = confirm( '是否删除该评论' );
        if( isDel )
        {
            var id = $( this ).attr( 'data-id' );
            if( !id ) return fasle;
            
            var data = {'id': id, '<?php echo $this->security->getTokenKey();?>' : '<?php echo $this->security->getToken();?>'};
            var _this = this;

            $.post( '/admin/goodscomments/delete', data, function( ret ){
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
   /*----------------显示 和 隐藏-----------------*/
   $( 'table' ).delegate( '.commentToggle', 'click', function(){
        var id = $( this ).attr( 'data-id' );
        var toggle = 0;
        
        if( !id ) return fasle;
        if( $( this ).hasClass( 'glyphicon-eye-close' ) )
        {
            toggle = 1; //隐藏评论
        }
        var data = {'id': id, 'toggle' : toggle };
        var _this = this;
        $.post( '/admin/goodscomments/toggle', data, function( ret ){
            if( !ret.status )
            {
                var msg = '显示成功';
                if( toggle )
                {
                    $( _this ).removeClass( 'glyphicon-eye-close' ).addClass( 'glyphicon-eye-open' );
                    var msg = '隐藏成功';
                }
                else
                {
                    $( _this ).removeClass( 'glyphicon-eye-open' ).addClass( 'glyphicon-eye-close' );
                }
                successMsg( msg );
            }
            else
            {
               errorMsg( ret.msg );
            }
        }, 'json').error(function(){ //网络不通
            errorMsg( '网络不通' );
        });
        
   });
   
});
    function  errorMsg( msg )
    {
       $( '.alert span' ).text( msg );
       $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
       $( '.alert' ).show().fadeOut( 3000 );
    }
     function  successMsg( msg )
    {
       $( '.alert span' ).text( msg );
       $( '.alert' ).removeClass( 'alert-danger' ).addClass( 'alert-success' );
       $( '.alert' ).show().fadeOut( 3000 );
    }
        </script>
    </body>
</html>