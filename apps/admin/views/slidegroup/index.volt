<!doctype html>
<html>
<head>
<link rel="stylesheet" href="/css/admin/base.css">
<link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/bootstrap/toastr/toastr.min.css">
<link rel="stylesheet" href="/css/fcmsIndex/common.css" />
<style>
	.operate {
        margin-right: 10px;
    }
    .operate:hover {
        cursor:pointer;
        color:#337AB7;
    }
	.skinimg i:hover{
    	-webkit-animation: tada 1s .2s ease both;-moz-animation: tada 1s .2s ease both;
	}
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
	span.info{
		font-size: 14px;
		color:#95a5a6;
	}
	p.no_group{
		text-align:center;
	}
</style>
</head>

<body class="wrap">

	<!-- 删除弹出框Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog self_modal_dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">
						<span class="glyphicon glyphicon-question-sign"></span>
						删除该组会同时删除组中所有幻灯片，确定要删除吗？
					</h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default self_modal_btn" data-dismiss="modal">取消</button>
					<button type="button" id="modal_confirm" class="btn btn-primary self_modal_btn" onclick="deleteData()">确定</button>
				</div>
			</div>
		</div>
	</div>
   	
	<ul class="nav nav-tabs" role="tablist">
	    <li role="presentation" class="active"><a href="#slideGroup">幻灯片组管理</a></li>
	    <li role="presentation"><a href="/admin/slideGroup/add">添加幻灯片组</a></li>
	</ul>
	
	<div class="tab-content" style="padding:20px 0px;">
		<div role="tabpannel" class="tab-pane active" id="userList">
		    {% if groups.items is defined and groups.items is not empty %}
		    <table class="table table-hover table-bordered">
		        <thead>
		            <tr>
		                <th>序号</th>
		                <th>组名</th>
		                <th>显示类型</th>
		                <th>宽度</th>
		                <th>高度</th>
		                <th>大小限制</th>
		                <th>限制宽高</th>
		                <th>操作</th>
		            </tr>
		        </thead>
		        <tbody>
		            {% for i,group in groups.items %}
		            <tr>
		            	<td>{{ i+1 }}</td>
		                <td>{{ group.name | e }}</td>
		                <td>{% if group.type === '1' %}图片{% elseif group.type === '2' %}FLASH{% elseif group.type === '3' %}视频{% else %}信息错误{% endif %}</td>
		                <td>{{ group.width | e }}</td>
		                <td>{{ group.height | e }}</td>
		                <td>{{ group.size | e }}</td>
		                <td>{% if group.islimit === '0' %}不限制{% elseif group.islimit === '1' %}限制{% else %}信息错误{% endif %}</td>
		                <td data-id="{{ group.id | escape_attr }}" class="skinimg" style="padding-left:2%" >
		                    <a href="{{ url( 'admin/slidegroup/edit?id=' ) }}{{ group.id | e }}" style="color:black;"><i class="glyphicon glyphicon-pencil operate slideGroupEdit" title="修改"></i></a>
		                    <i class="glyphicon glyphicon-trash operate slideGroupDelete" data-id="{{ group.id | e }}" style="margin-right: 10px;" title="删除"></i>
		                </td>
		            </tr>
		            {% endfor %}
		        </tbody>
		    </table>
		    {% else %}
		    	<p class="no_group">无幻灯片组</p>
		    {% endif %}
		    {% if groups.total_pages > 1 %}
		    <nav class="text-right" >
		        <ul class="pagination pagination-sm" style="margin-top:0">
	                <li class="{% if groups.current == 1 %}disabled{% endif %}"><a href="{{ url( 'admin/slidegroup/index?page=' ) }}{{ groups.before }}" >&laquo;</a></li>
	                {% if  1 != groups.current and 1 != groups.before %}
	                <li><a href="{{ url( 'admin/slidegroup/index') }}">1</a></li>
	                {% endif %}
	
	                {% if groups.before != groups.current  %}
	                <li><a href="{{ url( 'admin/slidegroup/index?page=') }}{{ groups.before }}"><span >{{ groups.before }}</span></a></li>
	                {% endif %}
	                <li class="active"><a href="{{ url( 'admin/slidegroup/index?page=') }}{{ groups.current }}"><span >{{ groups.current }}</span></a></li>
	                {% if groups.next != groups.current %}
	                <li><a href="{{ url( 'admin/slidegroup/index?page=') }}{{ groups.next }}">{{ groups.next }}</a></li>
	                {% endif %}
	                {% if groups.next < groups.last - 1 %}
	                <li><a>...</a></li>
	                {% endif %}
	                {% if groups.last != groups.next %}
	                <li><a href="{{ url( 'admin/slidegroup/index?page=') }}{{ groups.last }}">{{ groups.last }}</a></li>
	                {% endif %}
	                <li class="{% if groups.current == groups.last %}disabled{% endif %}"><a href="{{ url( 'admin/slidegroup/index?page=' ) }}{{groups.next}}" >&raquo;</a></li>
		
		        </ul>
		    </nav>
		    {% endif %}
		</div>
	</div>
	
	<div class="alert alert-danger text-center col-xs-2" style="display:none;margin-left: 40%;">
	    <span>删除失败</span>
	</div>
   
	<script src="/js/jquery/jquery-1.11.1.min.js"></script>
	<script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script src="/bootstrap/toastr/toastr.min.js"></script>
    
	<script>
		var page = "<?php if( isset( $page ) && !empty( $page ) ) echo $page->current; else echo 0; ?>";
		var key = "<?php echo $this->security->getTokenKey();?>";
		var token = "<?php echo $this->security->getToken();?>";
		
		/*--------------单条内容的删除-----------------*/
		var dataId = 0;
		$( 'i.slideGroupDelete' ).click( function(){
		 	dataId = parseInt( $( this ).parents( 'td.skinimg' ).attr( 'data-id' ) );
		 	$( '#deleteModal' ).modal( 'toggle' );
		} );
		 
		function deleteData(){
			if( !dataId ){
				alert( '参数错误！' );
				return;
		  	}else{
		  		var data = { 'id' : dataId, 'key' : key, 'token' : token };
		  	    var _this = $( "td[data-id=" + dataId + "]" );
		  	    $.post( '/admin/slidegroup/delete', data, function( ret ){
			  	    switch( parseInt( ret.state ) ){
			  	        case 0:
			  	        	success( '删除成功' );
			  	        	$( _this ).parents( 'tr' ).remove();
			  	        	break;
			  	        case 1:
			  	        	error( '删除失败' );
			  	        	break;
			  	        case 2:
			  	        	error( '未找到该条数据' );
			  	        	break;
		  	        }
		            $( '#deleteModal' ).modal( 'hide' );
		  	      	key = ret.key;
		  	    	token = ret.token;
		  	    }, 'json' ).error( function(){
		  	        error( '网络不通' );
		  	    } );
		  	}
		}
		/*--------------单条内容的删除结束-----------------*/
		
		/*----------------输出正确信息-----------------*/
		function success( msg ){
			$( '.alert span' ).text( msg );
			$( '.alert' ).removeClass( 'alert-danger' ).addClass( 'alert-success' );
			$( '.alert' ).show().fadeOut( 3000 );
		}
		/*----------------输出错误信息-----------------*/
		function error( msg ){
			$( '.alert span' ).text( msg );
			$( '.alert' ).removeClass( 'alert-success' ).addClass( 'alert-danger' );
			$( '.alert' ).show().fadeOut( 3000 );
		}
	</script>
</body>
</html>