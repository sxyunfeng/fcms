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
            <li role="presentation"><a href="/admin/staticcache/index">配置项</a></li>
            <li role="presentation"><a href="/admin/staticcache/column">栏目配置</a></li>
            <li role="presentation"><a href="/admin/staticcache/list">列表配置</a></li>
            <li role="presentation" class="active"><a href="#detailConfig">详细页配置</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="detailConfig">
                <table class="table table-hover table-bordered">
                     <thead>
                    	<tr>
                    		<th colspan="7"></th>
                    		<th style="text-align:center"><a href="/admin/staticcache/optdetail"><i class="fa fa-plus-square"> 添加配置项</i></a></th>
                    	</tr>
                        <tr>
                        	<th>序号</th>
                            <th>编号</th>
                            <th>配置名称</th>
                            <th>缓存类型</th>
                            <th>前         缀</th>
                            <th>缓存时间</th>
                            <th>最近一次操作时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                     {% if page.items is defined and page.items is not empty %}
                    <tbody>
                        {% for i,item in page.items %}
                        <tr id="detailCfg{{item.id}}">
                        	<td>{{ i+1 }}</td>
                        	<td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>
                            <td style="text-align:center">
                                {% if item.type == 1  %} File 
                                {% elseif item.type == 2  %} Memcache 
                                {% endif %}
                            </td>
                            <td>{{ item.prefix }}</td>
                            {% if item.cache_time is defined and false != item.cache_time  %}
                            <td><?php echo $this->escaper->escapeHtml( $item->cache_time ) ?> 分钟</td>
                            {% else %}
                            <td style="text-align:center">/</td>
                            {% endif %}
                            <td>{% if false != item.uptime %} {{item.uptime}} {% else %} {{item.addtime}} {% endif %}</td>
                           <td data-id = "{{ item.id | escape_attr }}" class="skinimg" style="padding-left:4%">
                                <font size="4"><i class="glyphicon glyphicon-trash operate cacheDelete" title="删除"></i></font>
                                <a href="{{ url( '/admin/staticcache/optdetail/id/' ) }}{{ item.id | escape_attr }}"><font size="4"><i class="glyphicon glyphicon-pencil operate" title="修改"></i></font></a>
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                     {% else %}
                </table>
                {% endif %}
                {% if page.total_pages > 1 %}
                <nav class="text-right" >
                    <ul class="pagination pagination-sm" style="margin-top:0"> 
                        <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="{{ url( 'admin/staticcache/detail?page=' ) }}{{page.before | escape_attr }}" >&laquo;</a></li>
                        {% if  1 != page.current and 1 != page.before %}
                        <li><a href="{{ url( 'admin/staticcache/detail') | escape_attr }}">1</a></li>
                        {% endif %}
                        {% if page.before != page.current  %}
                        <li><a href="{{ url( 'admin/staticcache/detail?page=') }}{{ page.before | escape_attr }}"><span >{{ page.before |e}}</span></a></li>
                        {% endif %}
                        <li class="active"><a href="{{ url( 'admin/staticcache/detail?page=') }}{{ page.current | escape_attr }}"><span >{{ page.current |e}}</span></a></li>
                        {% if page.next != page.current %}
                        <li><a href="{{ url( 'admin/staticcache/detail?page=') }}{{ page.next | escape_attr }}">{{ page.next |e}}</a></li>
                        {% endif %}
                        {% if page.next  < page.last - 1 %}
                        <li><a>...</a></li>
                        {% endif %}
                        {% if page.last != page.next %}
                        <li><a href="{{ url( 'admin/staticcache/detail?page=') }}{{ page.last | escape_attr }}">{{ page.last |e}}</a></li>
                        {% endif %}
                        <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( 'admin/staticcache/detail?page=' ) }}{{page.next | escape_attr }}" >&raquo;</a></li>

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
        $(function(){
        	
        	$( 'i.cacheDelete' ).click(function(){
	        	var optid = $( this ).parent().parent( 'td' ).attr( 'data-id' );
	        	if( false == optid )
        		{
	        		$( '#dis_message' ).html( '参数配置错误,请刷新后再试...' );
					$( '#dis_message' ).parent().parent().addClass( 'alert-danger' ).removeClass( 'alert-success' );
					$( '#dis_message' ).parent().parent().fadeIn( 500 );
					setTimeout( function(){
						$( '#dis_message' ).parent().parent().fadeOut( 1000 );
					}, '3000' );
        		}
	        	
	        	$.get( '/admin/staticcache/delDetail/id/' + optid , function( ret ){
	        		if( 1 != ret.state )
					{
						$( '#detailCfg' + ret.optid ).remove();
						
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