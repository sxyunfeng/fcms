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
	p.no_slide{
		text-align:center;
	}
</style>
</head>

<body class="wrap">

	<!-- 预览Modal -->
	<div class="modal fade bs-example-modal-lg" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">幻灯片预览</h4>
				</div>
				<div class="modal-body slide_img" style='text-align:center;'>
					<img src="/public/img/cms/default/loading.gif" type='hidden' style="margin:0 auto;" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- 删除弹出框Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog self_modal_dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">
						<span class="glyphicon glyphicon-question-sign"></span>
						您确定要删除这条数据吗？
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
	    <li role="presentation" class="active"><a href="#slide">幻灯片管理</a></li>
	    <li role="presentation"><a href="/admin/slide/add">添加幻灯片</a></li>
	</ul>
	
	<div class="tab-content" style="padding:20px 0px;">
		<div role="tabpannel" class="tab-pane active">
		    <?php if( isset( $slides->items ) && count( $slides->items ) > 0 ){ ?>
		    <table class="table table-hover table-bordered">
		        <thead>
		            <tr>
		                <th>序号</th>
		                <th>排序</th>
		                <th>分组</th>
		                <th>标题</th>
		                <th>描述</th>
		                <th>链接</th>
		                <th>状态</th>
		                <th>操作</th>
		            </tr>
		        </thead>
		        <tbody>
		            {% for i,item in slides.items %}
		            <tr>
		            	<td>{{ i+1 }}</td>
		                <td>{{ item.sort | e }}</td>
		                <td>{% if item.slidegroup is defined %}{{ item.slidegroup.name | e }}{% else %}未找到分组{% endif %}</td>
		                <td>{{ item.title | e }}</td>
		                <td>{{ item.content | e }}</td>
		                <td>{{ item.url | e }}</td>
		                <td>{% if item.isshow === '1' %}显示{% else %}隐藏{% endif %}</td>
		                <td data-id="{{ item.id | escape_attr }}" class="skinimg" style="padding-left:2%" >
		                	<i class="glyphicon glyphicon-search slidePreview" data-id="{{ item.id | escape_attr }}" style="margin-right:10px;cursor:pointer;" title="查看幻灯片" onclick="previewSlide( {{ item.id | escape_attr }} )" data-toggle="modal" data-target="#previewModal"></i>
		                    <a href="/admin/slide/edit/id/{{ item.id | escape_attr }}" style="color:black;"><i class="glyphicon glyphicon-pencil operate slideEdit" title="修改"></i></a>
		                    <i class="glyphicon glyphicon-trash operate slideDelete" data-id="{{ item.id | escape_attr }}" style="margin-right: 10px;" title="删除"></i>
		                </td>
		            </tr>
		            {% endfor %}
		        </tbody>
		    </table>
		    <?php }else{ ?>
		    	<p class="no_slide">无幻灯片</p>
		    <?php } ?>
		    {% if slides.items is defined and slides.items is not empty and slides.total_pages > 1 %}
		    <nav class="text-right" >
		        <ul class="pagination pagination-sm" style="margin-top:0">
	                <li class="{% if slides.current == 1 %}disabled{% endif %}"><a href="{{ url( 'admin/slide/index?page=' | escape_attr) }}{{ slides.before | escape_attr}}" >&laquo;</a></li>
	                {% if  1 != slides.current and 1 != slides.before %}
	                <li><a href="{{ url( 'admin/slide/index') | escape_attr }}">1</a></li>
	                {% endif %}
	
	                {% if slides.before != slides.current  %}
	                <li><a href="{{ url( 'admin/slide/index?page=') | escape_attr }}{{ slides.before | escape_attr }}"><span >{{ slides.before | e}}</span></a></li>
	                {% endif %}
	                <li class="active"><a href="{{ url( 'admin/slide/index?page=') | escape_attr }}{{ slides.current  | escape_attr }}"><span >{{ slides.current | e}}</span></a></li>
	                {% if slides.next != slides.current %}
	                <li><a href="{{ url( 'admin/slide/index?page=') | escape_attr }}{{ slides.next | escape_attr }}">{{ slides.next | e}}</a></li>
	                {% endif %}
	                {% if slides.next < slides.last - 1 %}
	                <li><a>...</a></li>
	                {% endif %}
	                {% if slides.last != slides.next %}
	                <li><a href="{{ url( 'admin/slide/index?page=') | escape_attr }}{{ slides.last | escape_attr }}">{{ slides.last | e }}</a></li>
	                {% endif %}
	                <li class="{% if slides.current == slides.last %}disabled{% endif %}"><a href="{{ url( 'admin/slide/index?page=' ) }}{{ slides.next | escape_attr }}" >&raquo;</a></li>
		
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
		var page = "<?php if( isset( $slides ) && !empty( $slides ) ) echo $slides->current; else echo 0; ?>";
		var key = "<?php echo $this->security->getTokenKey();?>";
		var token = "<?php echo $this->security->getToken();?>";
		var dataId = 0;
		
		/*--------------幻灯片预览-----------------*/
		function previewSlide( id ){
			if( id ){
				$.get( '/admin/slide/getDir/id/' + id, function( ret ){
	        		if( !parseInt( ret.state ) ){
	        			$( '.slide_img' ).html( "<img src='" + ret.dir + "' style='margin:0 auto;max-height:250px;max-width:900px;' />" );
	        		}else{
	        			$( '.slide_img' ).html( '预览失败' );
	        		}
	        	}, 'json' );
			}else{
				$( '.slide_img' ).html( '预览失败' );
			}
        }
		
		/*--------------单条内容的删除-----------------*/
		$( 'i.slideDelete' ).click( function(){
		 	dataId = parseInt( $( this ).attr( 'data-id' ) );
		 	$( '#deleteModal' ).modal( 'toggle' );
		} );
		 
		function deleteData(){
			if( !dataId ){
				alert( '参数错误！' );
				return;
		  	}else{
		  		var data = { 'id' : dataId, 'key' : key, 'token' : token };
		  	    var _this = $( "td[data-id=" + dataId + "]" );
		  	    $.post( '/admin/slide/delete', data, function( ret ){
		  	        if( 1 != ret.status ){
		  	        	success( ret.msg );
		  	        	$( _this ).parents( 'tr' ).remove();
		  	        }else{
		  				error( ret.msg );
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