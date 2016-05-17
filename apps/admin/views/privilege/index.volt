<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap/toastr/toastr.min.css">
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" href="/css/admin/privilege.css">
        <link rel="stylesheet" href="/bootstrap/jqueryConfirm/2.5.0/jquery-confirm.css">
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist"> 
            <li role="presentation" class="active"><a href="#">权限</a></li>
            <li role="presentation"><a href="/admin/privilege/add">添加</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0;">
            <div role="tabpannel" class="tab-pane active">
                {% if page.items is not empty %}
                <table class="table table-hover ">
                    <thead>
                        <tr>
                            <th>名称</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="template">
                            <td class="name"><span class="glyphicon glyphicon-menu-right"></span><span class="pri-name"></span></td>
                            <td class="op">
                                <i class="glyphicon glyphicon-trash remove" title="删除"></i>
                                <i class="glyphicon glyphicon-pencil edit" title="编辑"></i>
                                <i class="glyphicon glyphicon-plus add" title="添加"></i>
                            </td>
                        </tr>
                        {% for item in page.items %}
                        <tr class="first pid{{ item.pid | escape_attr }}" data-id="{{ item.id | escape_attr }}" data-pid="{{ item.pid | escape_attr }}">
                            <td class="name"><span class="glyphicon glyphicon-menu-right"></span>{{ item.name | e }}</td>
                            <td class="op">
                                <i class="glyphicon glyphicon-trash remove" title="删除"></i>
                                <i class="glyphicon glyphicon-pencil edit" title="编辑"></i>
                                <i class="glyphicon glyphicon-plus add" title="添加"></i>
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
                {% else %}
                 无相关数据
                {% endif %}
                  {% if page is  not empty %}
                {% if page.total_pages > 1 %}
                <nav class="text-right" >
                    <ul class="pagination pagination-sm" style="margin-top:0"> 
                        <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="{{ url( 'admin/privilege/index?page=' ) }}{{ page.before | e }}" >&laquo;</a></li>
                        {% if  1 != page.current and 1 != page.before %}
                        <li><a href="{{ url( 'admin/privilege/index') }}">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="{{ url( 'admin/privilege/index?page=') }}{{ page.before }}"><span >{{ page.before | e }}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="{{ url( 'admin/privilege/index?page=') }}{{ page.current }}"><span >{{ page.current | e }}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="{{ url( 'admin/privilege/index?page=') }}{{ page.next }}">{{ page.next | e }}</a></li>
                        {% endif %}
                        {% if page.next  < page.last - 1 %}
                        <li><a>...</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="{{ url( 'admin/privilege/index?page=') }}{{ page.last }}">{{ page.last | e }}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( 'admin/privilege/index?page=' ) }}{{ page.next | e }}" >&raquo;</a></li>
                    </ul>
                </nav>
                {% endif %}
                {% endif %}
            </div>
        </div>
<script src="/js/jquery/jquery-1.11.1.min.js"></script>
<script src="/bootstrap/toastr/toastr.min.js"></script>
<script src="/bootstrap/jqueryConfirm/2.5.0/jquery-confirm.js"></script>
<script>
    var csrf = { key : '{{ security.getTokenKey() }}', token :  '{{ security.getToken() }}'};
    //删除权限
    $( document ).delegate( '.remove', 'click',function(){
       var obj = $( this ).parents( 'tr' );
       var id = obj.attr( 'data-id' ); 
       var data = $.extend( csrf, { id : id });
       
       $.confirm(  { title: '确认要删除吗？',confirm: function(){
       
           $.post( '/admin/privilege/delete', data, function( ret ){
               if( ! ret.status )
               {
                   location.reload();
               }
               else
               {
                   toastr.error( ret.msg );
               }
               csrf.key = ret.key;
               csrf.token = ret.token;
           }, 'json' );
       }});
       return false;
    });
    //编辑权限
    $( document ).delegate( '.edit' ,'click', function(){
        var id = $( this ).parents( 'tr').attr( 'data-id' );
        location = '/admin/privilege/edit?id=' + id;
        return false;
    });
    //添加权限
    $( document ).delegate( '.add', 'click', function(){
        location = '/admin/privilege/add?pid=' + $( this ).parents( 'tr' ).attr( 'data-id' );
        return false;
    });

    //一级的点击
    $( document ).delegate( '.first', 'click', function(){
        //二级的状态都归位
        $( '.second' ).hide().find( '.name .glyphicon' ).removeClass( 'glyphicon-menu-down' ).addClass( 'glyphicon-menu-right' );
        showSub( this, 'second' );
    } );
    //二级的点击
    $( document ).delegate( '.second', 'click', function(){
        showSub( this, 'third' );
    } );

    //获取数据
    function showSub( _this, level )
    {
        //同级别的状态
        var pid = $( _this ).attr( 'data-pid' );
        $( _this ).siblings( '.pid' + pid ).find( '.name .glyphicon' ).removeClass( 'glyphicon-menu-down' ).addClass( 'glyphicon-menu-right' );
        //当前的状态
        var icon = $( _this ).find( '.name .glyphicon' );
        if( icon.hasClass( 'glyphicon-menu-right'))
        {
            icon.removeClass( 'glyphicon-menu-right' ).addClass( 'glyphicon-menu-down');//此时处于展开状态
        }
        else
        {
            icon.removeClass( 'glyphicon-menu-down' ).addClass( 'glyphicon-menu-right'); //处于原始状态
        }
        $( '.third, .add' ).hide();
        $( _this ).find( '.add' ).show();
        
        var id = $( _this ).attr( 'data-id' );
        var sub = $( '.pid' +　id );
        if( sub.length ) //已经存在子菜单了
        {
            if(  icon.hasClass( 'glyphicon-menu-right')) //处于原始状态
            {
                sub.hide();//子菜单恢复
            }
            else
            {
                sub.show();//子菜单展开
            }   
            return false;
        }
        
        $.get( '/admin/privilege/getSub', { id : id }, function( ret ){
            if( ! ret.status )
            {
                var target = $( _this ).next();
                for( var i in ret.data )
                {
                    var clone = $( '.template' ).clone().removeClass( 'template').addClass( level + ' pid' + id ) 
                            .attr({ 'data-id' :  ret.data[i].id, 'data-pid' : id });
                    clone.find( '.pri-name' ).text( ret.data[i].name );
                    
                    if( target.length )
                    {
                        target.before( clone );
                    }
                    else
                    {
              
                        $( 'tbody' ).append( clone );
                    }
                }
            }
    }, 'json');
    }
</script>
    </body>
</html>