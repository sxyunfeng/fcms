<!doctype html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <style>
            .operate {
                margin-right: 10px;
            }
            .operate:hover {
                cursor:pointer;
                color:green;
            }
            
            table tr th{
				text-align:center;
            }
            
			body {
                font-family: "Arial","微软雅黑",sans-serif;
				padding: 20px 20px 70px;
            }
            .num {
                font-size: 24px;
                margin-left:5px;
            }
            .glyphicon {
                margin-right:5px;
            }
            .doc_root{
            	font-size:13.8px;
            	color:#FF8247;
            	text-decoration:underline;
            }
			pre {
				white-space: pre-wrap;
				word-wrap: break-word;
			}
            
        </style>
    </head>
    <body>
    
    	<!-- Modal -->
		<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Modal title</h4>
					</div>
					<div class="modal-body" style='text-align:center;'>
						<img src="/public/img/cms/default/loading.gif" type='hidden' style=";margin:0 auto;" />
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
    
    
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><a href="/admin/security/file">文件安全中心</a></li>
            <li role="presentation" class="active"><a href="#securityCenter">异常文件</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active">
                <table class="table table-hover table-bordered">
                    <thead>
                    	<tr>
                            <td colspan="6" style="text-align:left"><strong>DOCUMENT_ROOT：</strong><span class="doc_root"><?php echo $_SERVER[ 'DOCUMENT_ROOT' ] . '/'; ?></span></td>
                        </tr>
                    	<tr>
                            <th colspan="5"></th>
                            <th><a href="javascript:void(0)" onclick="handleAbnormal( 0 )">全部处理</a></th>
                        </tr>
                        <tr>
                            <th>序号</th>
                            <th>文件名称</th>
                            <th>文件位置</th>
                            <th>异常时间</th>
                            <th>上次处理时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    
                    <?php if( isset( $res ) && !empty( $res ) ){ ?>
                    <tbody id="fileList">
                    	{% for i,item in res %}
                        <tr id="abnormal{{item['id']}}">
                            <td style="text-align:center">{{i+1}}</td>
                            <td>{{ item['filename'] | e }}</td>
                            <td>{{ item['formatpath'] }}</td>
                            <td style="text-align:center">{{ item['uptime'] }}</td>
                            <td style="text-align:center">{% if item['opttime'] %} {{ item['opttime'] }}{% endif %}</td>
                            <td style="text-align:center">
                            	<i class="glyphicon glyphicon-search" title="查看" onclick="viewFile( {{ item['id'] }} )"style="cursor:pointer;" data-toggle="modal" data-target="#myModal"></i>
                            	<i class="glyphicon glyphicon-refresh" onclick="handleAbnormal( {{ item['id'] }} )" title="忽略" style="cursor:pointer;"></i>
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                    <?php } ?>
                </table>
               
            </div>
        </div>
		
		
		
		
        <div class="alert text-center col-xs-2" style="display:none;margin-left: 40%;">
            <span id="dis_message"></span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script type="text/javascript">
		function viewFile( id )
        {
			if( id )
			{
				$.get( '/admin/security/showFiles/id/' + id , function( ret ){
					$( '.modal-body' ).css( 'text-align', 'left' );
					$( '.modal-body' ).html( "<pre>" + ret.fileInfo + "</pre>" );
				}, 'json' );
			}
			
        }
		function handleAbnormal( id )
        {
        	$.get( '/admin/security/handle/id/' + id , function( ret ){
        		if( 1 != ret.state )
				{
        			switch( ret.type )
        			{
        				case 'all':
        					$( '#fileList tr' ).remove();
        				break;
        				case 'signle':
        					$( '#abnormal' + ret.optid ).remove();
        				break;
        				default:
        				break;
        			}
        			
					$( '#dis_message' ).html( ret.msg );
					$( '#dis_message' ).parent().addClass( 'alert-success' ).removeClass( 'alert-danger' );
					$( '#dis_message' ).parent().fadeIn( 500 );
					setTimeout( function(){
						$( '#dis_message' ).parent().fadeOut( 1000 );
					}, '3000' );
				}
				else
				{
					$( '#dis_message' ).html( ret.msg );
					$( '#dis_message' ).parent().addClass( 'alert-danger' ).removeClass( 'alert-success' );
					$( '#dis_message' ).parent().fadeIn( 500 );
					setTimeout( function(){
						$( '#dis_message' ).parent().fadeOut( 1000 );
					}, '3000' );
				}
        	}, 'json' );
        }
        </script>
    </body>
</html>