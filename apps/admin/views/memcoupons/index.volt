<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#couponList">优惠券</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="couponList">
                {% if page.items is defined and page.items is not empty %}
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>会员名</th>
                            <th>优惠券名</th>
                            <th>起始日期</th>
                            <th>截止日期</th>
                            <th>有效时间（天）</th>
                            <th>方式</th>
                            <th>最低消费</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for item in page.items %}
                        <tr data-id="{{ item.couponid | escape_attr }}">
                            <td>{{ item.username | e }}</td>
                            <td>{{ item.title | e }}</td>
                            <td>{{ item.datefrom | e  }}</td>
                            <td> {{ item.dateto | e  }} </td>
                            <td>{{ item.dateinterval | e  }}</td>
                            <td>{% if item.type %} 时间间隔 {% else %} 时间范围 {% endif %}</td>
                            <td>￥{{ item.lowlimit | e  }}</td>
                            <td>{% if item.is_used  %} 已使用 {% else %} <span class="text-success">未使用</span> {% endif %}</td>
                            <td>
                                <i class="glyphicon glyphicon-trash operate couponDelete" data-id="{{ item.id | escape_attr }}" style="margin-right: 10px;"></i>
                                <a href="{{ url( 'admin/memcoupons/read?id=' ) }}{{ item.couponid | escape_attr  }}"><i class="glyphicon glyphicon-eye-open operate" ></i></a>
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
                {% else %}
                <div class="col-xs-12 text-center">无优惠券 </div>
                {% endif %}
                {% if page.total_pages > 1 %}
                <nav class="text-right" >
                    <ul class="pagination pagination-sm" style="margin-top:0"> 
                        <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="{{ url( 'admin/memcoupons/index?page=' ) }}{{page.before}}" >&laquo;</a></li>
                        {% if  1 != page.current and 1 != page.before %}
                        <li><a href="{{ url( 'admin/memcoupons/index') }}">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="{{ url( 'admin/memcoupons/index?page=') }}{{ page.before }}"><span >{{ page.before }}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="{{ url( 'admin/memcoupons/index?page=') }}{{ page.current }}"><span >{{ page.current }}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="{{ url( 'admin/memcoupons/index?page=') }}{{ page.next }}">{{ page.next }}</a></li>
                        {% endif %}
                        {% if page.next  < page.last - 1 %}
                        <li><a>...</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="{{ url( 'admin/memcoupons/index?page=') }}{{ page.last }}">{{ page.last }}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( 'admin/memcoupons/index?page=' ) }}{{page.next}}" >&raquo;</a></li>

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
        /*--------------图标颜色改变-----------------*/
       $( '.operate' ).hover( function(){
           $( this ).css( 'cursor', 'pointer' );
           $( this ).css( 'color', 'green' );
       }); 
       $( '.operate' ).mouseout( function(){
           $( this ).css( 'cursor', '' );
           $( this ).css( 'color', '' );
       }); 
       /*----------------点击表格行---------------*/
       $( 'table' ).delegate( 'tr', 'click', function( e ){
            var tag = e.target.tagName;
            if(  tag === 'TD' ) 
            {
                location = '/admin/memcoupons/read?id=' + $( this ).attr( 'data-id' );
            }
       });
       /*----------------删除-----------------*/
       $( 'table' ).delegate( '.couponDelete', 'click', function(){
            var isDel = confirm( '是否删除该会员' );
            if( isDel )
            {
                var id = $( this ).attr( 'data-id' );
                var data = {'id': id, '<?php echo $this->security->getTokenKey();?>' : '<?php echo $this->security->getToken();?>'};
                var _this = this;

                $.post( '/admin/memcoupons/delete', data, function( ret ){
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
            return false;
       });
    });
    function  errorMsg( msg )
    {
       $( '.alert span' ).text( msg );
       $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
       $( '.alert' ).show().fadeOut( 3000 );
    }
        </script>
    </body>
</html>