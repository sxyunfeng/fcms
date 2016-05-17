<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet"  href="/css/admin/font-awesome.min.css" >
        <style>
            .fa, .glyphicon {
                margin-right:15px;
            }
            tr.first .fa-plus-square-o, tr.first .fa-mins {
                margin-right:10px;
            }
            tr.second, tr.third {
                display:none;
            }
            tr.second .fa-plus-square-o,  tr.second .fa-minus-square-o {
                margin-left:20px;
            }
            tr.third .fa-minus-square-o {
                margin-left:40px;
            }
            .operate:hover {
                cursor:pointer;
                color:green;
            }
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#catsAttrList">分类属性</a></li>
            <li role="presentation"><a href="/admin/catsAttr/add">添加分类属性</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="userList">
                {% if page.items is defined and page.items is not empty %}
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>属性标题</th>
                          
                   
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for item in page.items %}
                        <tr>
                            <td>{{ item.title | e }}</td>
                            <td>{{ item.uptime | e }}</td>
                            <td data-id = "{{ item.id | escape_attr }}" >
                                <i class="glyphicon glyphicon-trash operate catsAttrDelete" ></i>
                                <a href="{{ url( 'admin/catsAttr/edit?id=' ) }}{{ item.id | escape_attr }}"><i class="glyphicon glyphicon-pencil operate" ></i></a>
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
                        <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="{{ url( 'admin/catsAttr/index?page=' ) }}{{page.before}}" >&laquo;</a></li>
                        {% if  1 != page.current and 1 != page.before %}
                        <li><a href="{{ url( 'admin/catsAttr/index') }}">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="{{ url( 'admin/catsAttr/index?page=') }}{{ page.before }}"><span >{{ page.before }}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="{{ url( 'admin/catsAttr/index?page=') }}{{ page.current }}"><span >{{ page.current }}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="{{ url( 'admin/catsAttr/index?page=') }}{{ page.next }}">{{ page.next }}</a></li>
                        {% endif %}
                        {% if page.next  < page.last - 1 %}
                        <li><a>...</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="{{ url( 'admin/catsAttr/index?page=') }}{{ page.last }}">{{ page.last }}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( 'admin/catsAttr/index?page=' ) }}{{page.next}}" >&raquo;</a></li>

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
   $( 'table' ).delegate( '.catsAttrDelete', 'click', function(){
        var isDel = confirm( '是否删除该属性' );
        if( isDel )
        {
            var id = $( this ).parent().attr( 'data-id' );
            var data = {'id': id, '<?php echo $this->security->getTokenKey();?>' : '<?php echo $this->security->getToken();?>'};
            var _this = this;

            $.post( '/admin/catsAttr/delete', data, function( ret ){
                if( !ret.status )
                {
                    $( _this ).parents( 'tr' ).remove();
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
    $( '.alert' ).show().fadeOut(3000);
}
        </script>
    </body>
</html>