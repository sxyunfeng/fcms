<!doctype html>
<html>
<head>
<link rel="stylesheet" href="/css/admin/base.css">
<link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/bootstrap/toastr/toastr.min.css">
<link rel="stylesheet" type="text/css" href="/nprogress/nprogress.css">
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
	p.no_info{
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
	    <li role="presentation" class="active"><a href="#backup">备份列表</a></li>
	    <li role="presentation"><a href="/admin/backup/add">添加备份</a></li>
	</ul>
	
	<div class="tab-content" style="padding:20px 0px;">
		<div role="tabpannel" class="tab-pane active">
		    <?php if( isset( $backups->items ) && count( $backups->items ) > 0 ){ ?>
		    <table class="table table-hover table-bordered">
		        <thead>
		            <tr>
		                <th>序号</th>
		                <th>备份名称</th>
		                <th>文件大小（KB）</th>
		                <th>备份类型</th>
		                <th>创建者</th>
		                <th>备份时间</th>
		                <th>操作</th>
		            </tr>
		        </thead>
		        <tbody>
		            {% for i,item in backups.items %}
		            <tr>
		            	<td class="backup_num">{{ i+1 }}</td>
		                <td class="backup_name">{{ item.name }}</td>
		                <td class="backup_size">{{ item.size }}</td>
		                <td class="backup_type">{% if 0 == item.type %}全备份{% elseif 1 == item.type %}仅图片{% elseif 2== item.type %}仅数据库{% endif %}</td>
		                <td class="backup_creator">{{ item.creator }}</td>
		                <td class="backup_addtime">{{ item.addtime }}</td>
		                <td data-id="{{ item.id | escape_attr }}" class="skinimg" style="padding-left:2%" >
		                    <i class="glyphicon glyphicon glyphicon-repeat operate backupReverse" title="恢复"></i>
		                    <i class="glyphicon glyphicon-trash operate backupDelete" style="margin-right:10px;" title="删除"></i>
		                    <a href="/admin/backup/download/method/{{item.method}}/name/{{ item.name }}"><i class="glyphicon glyphicon-download operate backupDownload" style="margin-right:10px;" title="下载"></i></a>
		                </td>
		            </tr>
		            {% endfor %}
		        </tbody>
		    </table>
		    <?php }else{ ?>
		    	<p class="no_info">无备份文件</p>
		    <?php } ?>
		    {% if backups.items is defined and backups.items is not empty and backups.total_pages > 1 %}
		    <nav class="text-right" >
		        <ul class="pagination pagination-sm" style="margin-top:0">
	                <li class="{% if backups.current == 1 %}disabled{% endif %}"><a href="{{ url( 'admin/backup/index?page=' | escape_attr) }}{{ backups.before | escape_attr}}" >&laquo;</a></li>
	                {% if  1 != backups.current and 1 != backups.before %}
	                <li><a href="{{ url( 'admin/backup/index') | escape_attr }}">1</a></li>
	                {% endif %}
	
	                {% if backups.before != backups.current  %}
	                <li><a href="{{ url( 'admin/backup/index?page=') | escape_attr }}{{ backups.before | escape_attr }}"><span >{{ backups.before | e}}</span></a></li>
	                {% endif %}
	                <li class="active"><a href="{{ url( 'admin/backup/index?page=') | escape_attr }}{{ backups.current  | escape_attr }}"><span >{{ backups.current | e}}</span></a></li>
	                {% if backups.next != backups.current %}
	                <li><a href="{{ url( 'admin/backup/index?page=') | escape_attr }}{{ backups.next | escape_attr }}">{{ backups.next | e}}</a></li>
	                {% endif %}
	                {% if backups.next < backups.last - 1 %}
	                <li><a>...</a></li>
	                {% endif %}
	                {% if backups.last != backups.next %}
	                <li><a href="{{ url( 'admin/backup/index?page=') | escape_attr }}{{ backups.last | escape_attr }}">{{ backups.last | e }}</a></li>
	                {% endif %}
	                <li class="{% if backups.current == backups.last %}disabled{% endif %}"><a href="{{ url( 'admin/backup/index?page=' ) }}{{ backups.next | escape_attr }}" >&raquo;</a></li>
		
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
	<script src="/nprogress/nprogress.js"></script>
	<script>
		var page = "<?php if( isset( $backups ) && !empty( $backups ) ) echo $backups->current; else echo 0; ?>";
		var key = "<?php echo $this->security->getTokenKey();?>";
		var token = "<?php echo $this->security->getToken();?>";
		var dataId = 0;
		
		/*--------------单条内容的删除-----------------*/
		$( 'i.backupDelete' ).click( function(){
		 	dataId = parseInt( $( this ).parent( 'td' ).attr( 'data-id' ) );
		 	$( '#deleteModal' ).modal( 'toggle' );
		} );
		 
		function deleteData(){
			if( !dataId ){
				alert( '参数错误！' );
				return;
		  	}else{
		  		var data = { 'id' : dataId, 'key' : key, 'token' : token };
		  	    var _this = $( "td[data-id=" + dataId + "]" );
		  	    $.post( '/admin/backup/delete', data, function( ret ){
		  	        if( 1 != ret.status ){
		  	        	toastr.success( ret.msg );
		  	        	$( _this ).parents( 'tr' ).remove();
		  	        }else{
		  	        	toastr.error( ret.msg );
		  	        }
		            $( '#deleteModal' ).modal( 'hide' );
		  	      	key = ret.key;
		  	    	token = ret.token;
		  	    }, 'json' ).error( function(){
		  	    	toastr.error( '网络不通' );
		  	    } );
		  	}
		}
		/*--------------单条内容的删除结束-----------------*/
        
		/*--------------备份恢复-----------------*/
		$( 'i.backupReverse' ).click( function(){
			NProgress.start();
			var id = $( this ).parent( 'td' ).attr( 'data-id' );
			$.get( '/admin/backup/reverse/id/' + id, function( ret ){
				switch( parseInt( ret.state ) ){
					case 0:
						toastr.success( '恢复成功' );
						break;
					case 1:
						toastr.error( '参数传递失败，恢复失败' );
						break;
					case 2:
						toastr.error( '该数据在数据库中不存在，请检查' );
						break;
					case 3:
						toastr.error( '文件解压缩失败，请检查' );
						break;
					case 4:
						toastr.error( '恢复失败' );
						break;
				}
				NProgress.done();
			}, 'json' );
		} );
		
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