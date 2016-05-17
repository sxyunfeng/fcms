<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <style>
            .operate {
                margin-right: 10px;
            }
            .operate:hover {
                color:green;
                cursor:pointer;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#memberList">会员</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="memberList">
                {% if page.items is defined and page.items is not empty %}
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>用户名</th>
                            <th>姓名</th>
                            <th>积分</th>
                            <th>邮箱</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for item in page.items %}
                        <tr data-id="{{ item.id | escape_attr }}">
                            <td>{{ item.login_name | e }}</td>
                            <td>{{ item.username | e  }}</td>
                            <td> {{ item.rest_points | e  }} </td>
                            <td>{{ item.email | e  }}</td>
                            <td>{{ item.status | e }}</td>
                            <td >
                                <i class="glyphicon glyphicon-trash operate memberDelete" title="删除"></i>
                                <a href="{{ url( 'admin/members/read?id=' ) }}{{ item.id | escape_attr  }}" title="查看"><i class="glyphicon glyphicon-eye-open operate" ></i></a>
                                <i class="glyphicon glyphicon-send operate memberCoupon" title="发送优惠券"  ></i>
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
                {% else %}
                <div class="col-xs-12 text-center">无会员 </div>
                {% endif %}
                {% if page.total_pages > 1 %}
                <nav class="text-right" >
                    <ul class="pagination pagination-sm" style="margin-top:0"> 
                        <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="{{ url( 'admin/members/index?page=' ) }}{{page.before}}" >&laquo;</a></li>
                        {% if  1 != page.current and 1 != page.before %}
                        <li><a href="{{ url( 'admin/members/index') }}">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="{{ url( 'admin/members/index?page=') }}{{ page.before }}"><span >{{ page.before }}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="{{ url( 'admin/members/index?page=') }}{{ page.current }}"><span >{{ page.current }}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="{{ url( 'admin/members/index?page=') }}{{ page.next }}">{{ page.next }}</a></li>
                        {% endif %}
                        {% if page.next  < page.last - 1 %}
                        <li><a>...</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="{{ url( 'admin/members/index?page=') }}{{ page.last }}">{{ page.last }}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( 'admin/members/index?page=' ) }}{{page.next}}" >&raquo;</a></li>

                    </ul>
                </nav>
                {% endif %}
            </div>
        </div>
        <div class="alert alert-danger text-center col-xs-2" style="display:none;margin-left: 40%;">
            <span>删除失败</span>
        </div>
         <!------优惠券列表----->
        <div class="modal fade" id="couponModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" >
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                    <div class="modal-body">
                        
                       {% if coupon is defined %}
                            {% for item in coupon %}
                            <div class="radio">
                                <label>
                                    <input type="radio" name="coupon" value="{{ item[ 'id' ] | escape_attr }}"> 
                                    {{ item[ 'title'] | e }}
                                </label>
                            </div>
                            {% endfor %}
                       {% endif %}
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm" id="sendCoupon">发送</button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">取消</button>
                    </div>
              </div>
            </div>
        </div>
        
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/public/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script>
$( function(){
   /*----------------删除-----------------*/
   $( 'table' ).delegate( '.memberDelete', 'click', function(){
        var isDel = confirm( '是否删除该会员' );
        if( isDel )
        {
            var id = $( this ).parents( 'tr' ).attr( 'data-id' );
            var data = {'id': id, '<?php echo $this->security->getTokenKey();?>' : '<?php echo $this->security->getToken();?>'};
            var _this = this;

            $.post( '/admin/members/delete', data, function( ret ){
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
   /*-------------发送优惠券---------------*/
   $( 'table' ).delegate( '.memberCoupon', 'click', function(){
        $( '#couponModal' ).modal( 'toggle' );
        $( '.modal-backdrop' ).hide();
        var memId = $( this ).parents( 'tr' ).attr( 'data-id' );
        $( '#couponModal' ).data( 'memId', memId );
   });
   $( '#sendCoupon' ).click( function(){
        var couponId = $( 'input[name="coupon"]:checked' ).val();
        var memId = $( '#couponModal' ).data( 'memId' );
        var data = {  'memId': memId, 'couponId' : couponId };
        $.post( '/admin/memcoupons/insert', data , function( ret ){
            if( ! ret.status )
            {
                  successMsg( ret.msg );
            }
            else
            {
                errorMsg( ret.msg );
            }
            $( '#couponModal' ).modal( 'toggle' );
        }, 'json' ).error( function(){ //网络不通
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