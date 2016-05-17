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
		.skinimg i:hover{-webkit-animation: tada 1s .2s ease both;-moz-animation: tada 1s .2s ease both;}
		@-webkit-keyframes tada{
			0%{-webkit-transform:scale(1);}
			10%, 
			20%{-webkit-transform:scale(0.9) rotate(-3deg);}
			30%, 50%, 70%, 
			90%{-webkit-transform:scale(1.1) rotate(3deg);}
			40%, 60%, 
			80%{-webkit-transform:scale(1.1) rotate(-3deg);}
			100%{-webkit-transform:scale(1) rotate(0);}
		}
		@-moz-keyframes tada{
			0%{-moz-transform:scale(1);}
			10%, 
			20%{-moz-transform:scale(0.9) rotate(-3deg);}
			30%, 50%, 70%, 
			90%{-moz-transform:scale(1.1) rotate(3deg);}
			40%, 60%, 
			80%{-moz-transform:scale(1.1) rotate(-3deg);}
			100%{-moz-transform:scale(1) rotate(0);}
		}
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#menuList">菜单管理</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="userList">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>菜单编号</th>
                            <th>模块</th>
                            <th>应用</th>
                            <th>菜单名称</th>
                            <th>状态</th>
                            <th>上一次操作时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    {% if  page.items is defined and  page.items is not empty %} 
                    <tbody>
                        {% for i,item in page.items %}
                        	<tr>
	                        	<td style="text-align:center">{{ i+1 }}</td>
	                        	<td style="text-align:center">{{ item.id }}</td>
	                        	<td>{{ item.module }}</td>
	                        	<td>{{ item.src }}</td>
	                        	<td>{{ item.name }}</td>
	                        	<td>{% if 1 == item.display %}显示{% else %}隐藏{% endif %}</th>
	                        	{% if item.uptime is defined %}<td>{{ item.uptime }}{% else %}</td><td>{{ item.addtime }}</td>{% endif %}
	                        	<td data-id = "{{ item.id | escape_attr }}" class="skinimg" style="padding-left:4%">
	                        		<font size="4"><i class="glyphicon glyphicon-plus-sign operate menuAddSeed" title="添加"></i></font>
	                        		<font size="4"><i class="glyphicon glyphicon-trash operate menuDelete" title="删除"></i></font>
		                            <font size="4"><i class="glyphicon glyphicon-pencil operate menuEditer" title="修改"></i></font>
	                        	</td>
                        	</tr>
                        {% endfor %}
                    </tbody>
                    {% endif %}
                </table>
                {% if page.total_pages > 1 %}
                <nav class="text-right" >
                    <ul class="pagination pagination-sm" style="margin-top:0"> 
                        <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="{{ url( '/admin/menu/backend?page=' ) }}{{page.before}}" >&laquo;</a></li>
                        {% if  1 != page.current and 1 != page.before %}
                        <li><a href="{{ url( '/admin/menu/backend') }}">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="{{ url( '/admin/menu/backend?page=') }}{{ page.before }}"><span >{{ page.before }}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="{{ url( '/admin/menu/backend?page=') }}{{ page.current }}"><span >{{ page.current }}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="{{ url( '/admin/menu/backend?page=') }}{{ page.next }}">{{ page.next }}</a></li>
                        {% endif %}
                        {% if page.next  < page.last - 1 %}
                        <li><a>...</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="{{ url( '/admin/menu/backend?page=') }}{{ page.last }}">{{ page.last }}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( '/admin/menu/backend?page=' ) }}{{page.next}}" >&raquo;</a></li>
                    </ul>
                </nav>
                {% endif %}
            </div>
        </div>
        <div class="alert alert-danger text-center col-xs-2" style="display:none;margin-left: 40%;">
            <span>删除失败</span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
    </body>
</html>