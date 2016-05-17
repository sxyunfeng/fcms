<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <style>
            .operate {
                margin-right: 10px;
            }
            .operate:hover {
                cursor:pointer;
                color:green;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#adList">广告</a></li>
            <li role="presentation"><a href="/admin/ad/add">添加广告</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="userList">
                {% if page.items is defined and page.items is not empty %}
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>广告标题</th>
                            <th>广告分类</th>
                            <th>广告类型</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>是否展示</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for item in page.items %}
                        <tr>
                            <td>{{ item.name | e }}</td>
                            <td>{{ item.cat_name | e }}</td>
                            <td>{% if item.media_type ==0 %} 图片 {% else %} 视频 {% endif %}</td>
                            <td><?php echo $this->escaper->escapeHtml(date('Y-m-d',$item->begin_time))?></td>
                            <td><?php echo $this->escaper->escapeHtml(date('Y-m-d',$item->end_time))?></td>
                             <td>{% if item.enabled ==0 %} 否 {% else %} 是 {% endif %}</td>
                            <td data-id = "{{ item.id | escape_attr }}" >
                                <i class="glyphicon glyphicon-trash operate adDelete" ></i>
                                <a href="{{ url( 'admin/ad/edit?id=' ) }}{{ item.id | escape_attr }}"><i class="glyphicon glyphicon-pencil operate" ></i></a>
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
                {% else %}
                {% endif %}
                {% if page.total_pages > 1 %}
                <nav class="text-right" >
                    <ul class="pagination pagination-sm" style="margin-top:0"> 
                        <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="{{ url( 'admin/ad/index?page=' ) }}{{page.before | escape_attr }}" >&laquo;</a></li>
                        {% if  1 != page.current and 1 != page.before %}
                        <li><a href="{{ url( 'admin/ad/index') | escape_attr }}">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="{{ url( 'admin/ad/index?page=') }}{{ page.before | escape_attr }}"><span >{{ page.before |e}}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="{{ url( 'admin/ad/index?page=') }}{{ page.current | escape_attr }}"><span >{{ page.current |e}}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="{{ url( 'admin/ad/index?page=') }}{{ page.next | escape_attr }}">{{ page.next |e}}</a></li>
                        {% endif %}
                        {% if page.next  < page.last - 1 %}
                        <li><a>...</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="{{ url( 'admin/ad/index?page=') }}{{ page.last | escape_attr }}">{{ page.last |e}}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( 'admin/ad/index?page=' ) }}{{page.next | escape_attr }}" >&raquo;</a></li>

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
    $( 'table' ).delegate( '.adDelete', 'click', function(){
        var isDel = confirm( '是否删除该广告' );
        if( isDel )
        {
            var id = $( this ).parent().attr( 'data-id' );
            var data = { 'id': id, '<?php echo $this->security->getTokenKey(); ?>': '<?php echo $this->security->getToken(); ?>' };
            var _this = this;

            $.post( '/admin/ad/delete', data, function( ret ){
                if( !ret.status )
                {
                    $( _this ).parents( 'tr' ).remove();
                }
                else
                {
                    error( ret.msg );
                }
            }, 'json' ).error( function(){ //网络不通
                error( '网络不通' );
            } );
        }
    } );
    

} );

function  error( msg )
{
    $( '.alert span' ).text( msg );
    $( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
    $( '.alert' ).show().fadeOut( 3000 );
}
        </script>
    </body>
</html>