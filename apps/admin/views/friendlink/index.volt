<!doctype html>
<html>
    <head>
   		<link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet"  href="/css/admin/font-awesome.min.css" >
        <style>
            .operate {
                margin-right: 10px;
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
            <li role="presentation" class="active"><a href="#friendLink">友情链接</a></li>
            <li role="presentation"><a href="/admin/friendlink/add">添加友情链接</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="friendLink">
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                        	<th>序号</th>
                        	<th>编号</th>
                            <th>链接名称</th>
                            <th>链接地址</th>
                            <th>是否允许抓取</th>
                            <th>最后一次操作时间</th>
                            <th>管理操作</th>
                        </tr>
                    </thead>
                    {% if page.items is defined and page.items is not empty %}
                    <tbody>
                        {% for i,item in page.items %}
                        <tr id="friendLink{{item.id}}">
                        	<td style="text-align:center">{{i+1}}</td>
                            <td style="text-align:center">{{ item.id }}</td>
                            <td style="text-align:center">{{ item.name | e }}</td>
                            <td><a href="{{ item.url | e }}" target="_blank">{{ item.url | e }}</a></td>
                            <td style="text-align:center">{% if 1 == item.nofollow %}允许{% else %}不允许{% endif %}</td>
                            <td>{% if item.uptime is defined  %} {{item.uptime}} {% else %} {{ item.addtime }} {% endif %}</td>
                            <td data-id = "{{ item.id | escape_attr }}" class="skinimg" style="padding-left:2%">
                                <font size="4"><i class="glyphicon glyphicon-trash operate sensDelete" title="删除"></i></font>
                                <a href="/admin/friendlink/update/id/{{item.id}}" ><font size="4"><i class="glyphicon glyphicon-pencil operate sensEditer" title="修改"></i></font></a>
                            </td>
                        </tr>
                    </tbody>
                    {% endfor %}
                </table>
                {% else %}
                {% endif %}
                {% if page.total_pages > 1 %}
                <nav class="text-right" >
                    <ul class="pagination pagination-sm" style="margin-top:0"> 
                        <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="{{ url( '/admin/friendlink/index?page=' ) }}{{page.before}}" >&laquo;</a></li>
                        {% if  1 != page.current and 1 != page.before %}
                        <li><a href="{{ url( '/admin/friendlink/index') }}">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="{{ url( '/admin/friendlink/index?page=') }}{{ page.before }}"><span >{{ page.before }}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="{{ url( '/admin/friendlink/index?page=') }}{{ page.current }}"><span >{{ page.current }}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="{{ url( '/admin/friendlink/index?page=') }}{{ page.next }}">{{ page.next }}</a></li>
                        {% endif %}
                        {% if page.next  < page.last - 1 %}
                        <li><a>...</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="{{ url( '/admin/friendlink/index?page=') }}{{ page.last }}">{{ page.last }}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( '/admin/friendlink/index?page=' ) }}{{page.next}}" >&raquo;</a></li>

                    </ul>
                </nav>
                {% endif %}
            </div>
        </div>
        
       	<div style="left: 30%;margin-left: -15px;margin-top: -15px;position: absolute;top: 50%; display:none;" class="text-center col-xs-4">
          	<div class="alert alert-dismissable ">
              <h4><i class="glyphicon glyphicon-info-sign"></i> 提示信息!</h4>
              <p id="dis_message"></p>
            </div>
    	</div>
       
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">
         $(function(){
        	 $( 'td i.sensDelete' ).click(function(){
        		var optid = $( this ).parent( 'font' ).parent().parent( 'td' ).attr( 'data-id' );
        		$.get( '/admin/friendlink/delete/id/' + optid, function( ret ){
					if( 1 != ret.state )
					{
						$( '#friendLink' + ret.optid ).remove();
						
						$( '#dis_message' ).html( ret.msg );
						$( '#dis_message' ).parent().parent().addClass( 'alert-success' ).removeClass( 'alert-danger' );
						$( '#dis_message' ).parent().parent().fadeIn( 500 );
						setTimeout( function(){
							$( '#dis_message' ).parent().parent().fadeOut( 1000 );
						}, '3000' );
					}
					else
					{
						$( '#dis_message' ).html( ret.msg );
						$( '#dis_message' ).parent().parent().addClass( 'alert-danger' ).removeClass( 'alert-success' );
						$( '#dis_message' ).parent().parent().fadeIn( 500 );
						setTimeout( function(){
							$( '#dis_message' ).parent().parent().fadeOut( 1000 );
						}, '3000' );
					}
        		}, 'json' );
        	 });
         });
        </script>
    </body>
</html>