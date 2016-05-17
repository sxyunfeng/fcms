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
            <li role="presentation"><a href="/admin/menu/category">菜单分类</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="menuList">
                <table class="table table-hover table-bordered">
                    <thead>
                    	<tr>
                    		<th colspan="6">
                    			<div class="col-md-3">
                    				<select id="category" class="form-control" onchange="getMenusList( this )">
                    				{% if cates is defined and cates is not empty%}
                    					{% for item in cates %}
                    						<option value="{{item.id}}">{{item.name}}</option>
                    					{% endfor %}
                    				{% endif %}
                    				</select>
                    			</div>
                    			<div class="col-md-11"></div>
                    		</th>
                    		<th style="text-align:center"><a href="/admin/menu/addmenus"><i class="fa fa-plus-square" title="新建菜单"> 新建菜单</i></a></th>
                    	</tr>
                        <tr>
                            <th>序号</th>
                            <th>菜单编号</th>
                            <th>菜单名称</th>
                            <th>上一级菜单</th>
                            <th>状态</th>
                            <th>上一次操作时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    {% if  page.items is defined and  page.items is not empty %} 
                    <tbody>
                        {% for i,item in page.items %}
                        	<tr id="menu{{item.id}}">
	                        	<td style="text-align:center">{{ i+1 }}</td>
	                        	<td style="text-align:center">{{ item.id }}</td>
	                        	<td>{{ item.name }}</td>
	                        	<td style="text-align:center">{{ item.pname }}</td>
	                        	<td>{% if 0 == item.is_show %}显示{% else %}隐藏{% endif %}</th>
	                        	{% if item.uptime is defined %}<td>{{ item.uptime }}{% else %}</td><td>{{ item.addtime }}</td>{% endif %}
	                        	<td data-id = "{{ item.id | escape_attr }}" class="skinimg" style="padding-left:4%">
	                        		<a href="/admin/menu/addmenus/pid/{{item.id}}"><font size="4"><i class="glyphicon glyphicon-plus-sign operate menuAddSeed" title="新建"></i></font></a>
	                        		<font size="4"><i class="glyphicon glyphicon-trash operate menuDelete" title="删除"></i></font>
		                            <a href="/admin/menu/upmenus/id/{{item.id}}"><font size="4"><i class="glyphicon glyphicon-pencil operate menuEditer" title="修改"></i></font></a>
	                        	</td>
                        	</tr>
                        {% endfor %}
                    </tbody>
                    {% endif %}
                </table>
                {% if page.total_pages > 1 %}
                <nav class="text-right" >
                    <ul class="pagination pagination-sm" style="margin-top:0"> 
                        <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="{{ url( '/admin/menu/frontend?page=' ) }}{{page.before}}" >&laquo;</a></li>
                        {% if  1 != page.current and 1 != page.before %}
                        <li><a href="{{ url( '/admin/menu/frontend') }}">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="{{ url( '/admin/menu/frontend?page=') }}{{ page.before }}"><span >{{ page.before }}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="{{ url( '/admin/menu/frontend?page=') }}{{ page.current }}"><span >{{ page.current }}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="{{ url( '/admin/menu/frontend?page=') }}{{ page.next }}">{{ page.next }}</a></li>
                        {% endif %}
                        {% if page.next  < page.last - 1 %}
                        <li><a>...</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="{{ url( '/admin/menu/frontend?page=') }}{{ page.last }}">{{ page.last }}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( '/admin/menu/frontend?page=' ) }}{{page.next}}" >&raquo;</a></li>
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
        <script type="text/javascript">
        function getMenusList( itme )
        {
        	var selVal = $( '#category' ).val();
        	if( false == selVal )
       		{
        		 $( '#dis_message' ).html( '请选择要查看的菜单分类' );
    			 $( '#dis_message' ).parent().parent().addClass( 'alert-danger' ).removeClass( 'alert-success' );
				 $( '#dis_message' ).parent().parent().fadeIn( 500 );
				 setTimeout( function(){
				 	 $( '#dis_message' ).parent().parent().fadeOut( 1000 );
				 }, '2000' );
				 return false;
       		}
        	
        	$.get( '/admin/menu/search/cid/' + selVal , function( ret ){
        		if( 1 != ret.state )
       			{
        			//清除数据
       				$( '#menuList table tbody tr' ).remove();
        			$( '#menuList nav' ).remove();
        			//追加数据
        			var iLen = ret.data.length;
        			var strList = '';
        			for( var i=0; i<iLen; i++ )
       				{
        				if( 1 != ret.data[i].display )
        					var strDisplay = '显示';
        				else
        					var strDisplay = '隐藏';
        				
        				if( false != ret.data[i].uptime )
        					var strLastTime = ret.data[i].uptime;
       					else
       						var strLastTime = ret.data[i].addtime;
        				
       					strList = '<tr id="menu'+ret.data[i].id+'">'+
       							     	'<td style="text-align:center">'+ parseInt( i+1 )+'</td>' +
       							  		'<td style="text-align:center">'+ ret.data[i].id+'</td>' +
       							 		'<td>'+ret.data[i].name+'</td>' +
       							 		'<td style="text-align:center">'+ ret.data[i].pname+'</td>' +
       							 		'<td>'+strDisplay+'</td>' +
       							 		'<td>'+ strLastTime +'</td>' +
       							 		'<td data-id="'+ret.data[i].id+'" class="skinimg" style="padding-left:4%"><a href="/admin/menu/addmenus/pid/'+ ret.data[i].id +'"><font size="4"><i class="glyphicon glyphicon-plus-sign operate menuAddSeed" ></i></font></a>'+
    	                        		      '<font size="4"><i class="glyphicon glyphicon-trash operate menuDelete" ></i></font>'+
    		                            	 '<a href="/admin/menu/upmenus/id/'+ ret.data[i].id +'"><font size="4"><i class="glyphicon glyphicon-pencil operate menuEditer" ></i></font></a></td>' +
       							 '</tr>';
       				}
        			$( '#menuList table tbody' ).append( strList );
       			}
        		else
       			{
	        		 $( '#dis_message' ).html( ret.msg );
	       			 $( '#dis_message' ).parent().parent().addClass( 'alert-danger' ).removeClass( 'alert-success' );
	   				 $( '#dis_message' ).parent().parent().fadeIn( 500 );
	   				 setTimeout( function(){
	   				 	 $( '#dis_message' ).parent().parent().fadeOut( 1000 );
	   				 }, '2000' );
       			}
        	}, 'json');
        }
        
        $(function(){
        	$( 'i.menuDelete' ).click(function(){
        		var optid = $(this).parent().parent( 'td' ).attr( 'data-id' );
        		if( false == optid )
       			{
        			 $( '#dis_message' ).html( '参数配置错误,请稍后重试.' );
	       			 $( '#dis_message' ).parent().parent().addClass( 'alert-danger' ).removeClass( 'alert-success' );
	   				 $( '#dis_message' ).parent().parent().fadeIn( 500 );
	   				 setTimeout( function(){
	   				 	 $( '#dis_message' ).parent().parent().fadeOut( 1000 );
	   				 }, '2000' );
	   				 return false;
       			}
        		$.get( '/admin/menu/deleteMenu/id/' + optid, function( ret ){
        			if( 1 != ret.state )
           			{
        				 $( '#dis_message' ).html( ret.msg );
	   	       			 $( '#dis_message' ).parent().parent().addClass( 'alert-danger' ).removeClass( 'alert-success' );
	   	   				 $( '#dis_message' ).parent().parent().fadeIn( 500 );

	   	   				 $( '#menu' + ret.optid ).remove();
	   	   				 setTimeout( function(){
	   	   				 	 $( '#dis_message' ).parent().parent().fadeOut( 1000 );
	   	   				 }, '2000' );
           			}
            		else
           			{
    	        		 $( '#dis_message' ).html( ret.msg );
    	       			 $( '#dis_message' ).parent().parent().addClass( 'alert-danger' ).removeClass( 'alert-success' );
    	   				 $( '#dis_message' ).parent().parent().fadeIn( 500 );
    	   				 setTimeout( function(){
    	   				 	 $( '#dis_message' ).parent().parent().fadeOut( 1000 );
    	   				 }, '2000' );
           			}
        		}, 'json' );
        	});
        });
        </script>
    </body>
</html>