<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="/css/admin/base.css">
        <link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/admin/font-awesome.min.css" >
        <style>
            .operate {
                margin-right: 10px;
            }
            .operate:hover {
                cursor:pointer;
                color:green;
            }
            
            table tr th{
				text-align:right;
            }
            
			body {
                 font-family: "Arial","微软雅黑",sans-serif;
            }
            .num {
                font-size: 24px;
                margin-left:5px;
            }
            .glyphicon {
                margin-right:5px;
            }
            #abnormal a{
				text-decoration:none;
            	color: red;
            }
            
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#securityCenter">文件安全中心</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active">
                <table class="table table-hover" >
                    <thead>
                    	<tr>
                            <th align="right">
                            	<button onclick="scanningFile( 'all' )" class="btn btn-default btn-sm" type="button">全站扫描</button>&nbsp;&nbsp;
                            	<button onclick="scanningFile( 'unusual' )" class="btn btn-default btn-sm" type="button">异常扫描</button>
                            </th>
                        </tr>
                </table>
            
            	<div class="col-xs-4">
		           <div class="panel panel-warning">
		               <div class="panel-heading"><i class="glyphicon glyphicon-file"></i>扫描总计</div>
		                <div class="panel-body text-center">
		                     <div class="col-xs-5"></div>
		                      <div class="col-xs-9">
		                         	共扫描文件： <span class="num" id="allfiles"> {% if allfiles %} {{allfiles}} {% else %} 0 {% endif %} 个</span>
		                     </div>
		                 </div>  
		            </div>
		        </div>
		        
		        <div class="col-xs-4">
		           <div class="panel panel-success">
		               <div class="panel-heading"><i class="glyphicon glyphicon-file"></i>正常文件</div>
		                <div class="panel-body text-center">
		                     <div class="col-xs-5"></div>
		                      <div class="col-xs-9">
		                        	 正常文件总数： <span class="num" id="normal">{% if normal %} {{normal}} {% else %} 0 {% endif %} 个</span>
		                     </div>
		                 </div>  
		            </div>
		        </div>  	
		        
		        <div class="col-xs-4">
		           <div class="panel panel-danger" id="file_danger_count">
		               <div class="panel-heading"><i class="glyphicon glyphicon-file"></i>异常文件</div>
		                <div class="panel-body text-center">
		                     <div class="col-xs-5"></div>
		                      <div class="col-xs-9">
		                        	 异常文件总数： <span class="num" id="abnormal">
		                        	 	{% if abnormal %} 
		                        	 	<a href="/admin/security/abnomalList"  data-toggle="tooltip" data-placement="top" title="点击查看异常文件列表">{{abnormal}}个</a> 
		                        	 	{% else %} 暂无 
		                        	 	{% endif %}
		                        	 	
		                        	 </span>
		                     </div>
		                 </div>
		            </div>
		        </div>  	
		        
		        
	           <div class="col-xs-12 text-center loading" style="display:none">
                   <i class="fa fa-pulse fa-spinner  fa-2x"></i>
               </div>
                
            </div>
        </div>
        <div class="alert text-center col-xs-2" style="display:none;margin-left: 40%;">
            <span id="dis_message"></span>
        </div>
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
		<script type="text/javascript">
		var file_abnormal = <?php if( isset( $abnormal ) && false != $abnormal ) echo $abnormal; else echo 0; ?>;
		$(function(){
			if( false != file_abnormal )
			{
				var oBox = document.getElementById("file_danger_count");
				var timer = null;  
				var i = 0; 
				clearInterval(timer);
				oBox.onmouseover = function(){
					clearInterval(timer);
				};
				timer = setInterval(function () {
				  oBox.style.display = i++ % 2 ? "none" : "block";
				  i > 6 && (clearInterval(timer))
				}, 500 );
			}
		});
		
		function scanningFile( type )
		{
			if( 'all' == type )
			{
				$( 'div.loading' ).show();
				//点击 全站扫描 
				$.get( '/admin/security/scanWebSite', function( ret ){
					$( 'div.loading' ).hide();
					if( 1 != ret.state )
					{
						$( '#dis_message' ).html( ret.msg );
						$( '#dis_message' ).parent().addClass( 'alert-success' ).removeClass( 'alert-danger' );
						$( '#dis_message' ).parent().fadeIn( 500 );
						setTimeout( function(){
							$( '#dis_message' ).parent().fadeOut( 1000 );
						}, '3000' );
						
						if( 0 == ret.abnormal )
							var abnormal = '暂无';
						else
							var abnormal = ret.abnormal  + '个';
								
						$( '#allfiles' ).html( ret.allfiles + '个' );
						$( '#normal' ).html( ret.normal  + '个'  );
						$( '#abnormal' ).html( abnormal );
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
			else if( 'unusual' == type )
			{
				$( 'div.loading' ).show();
				//异常扫描
				$.get( '/admin/security/scanAbnormal', function( ret ){
					$( 'div.loading' ).hide();
					if( 1 != ret.state )
					{
						$( '#dis_message' ).html( ret.msg );
						if( ret.abnormal > 0 )
							$( '#dis_message' ).parent().addClass( 'alert-danger' ).removeClass( 'alert-success' );
						else
							$( '#dis_message' ).parent().addClass( 'alert-success' ).removeClass( 'alert-danger' );
						
						$( '#dis_message' ).parent().fadeIn( 500 );
						setTimeout( function(){
							$( '#dis_message' ).parent().fadeOut( 1000 );
						}, '3000' );
						
						if( 0 == ret.abnormal )
							var abnormal = '暂无';
						else
							var abnormal = '<a href="/admin/security/abnomalList"  data-toggle="tooltip" data-placement="top" title="点击查看异常文件列表">' + 
											ret.abnormal  + '个</a>';
						
						$( '#normal' ).html( ret.normal  + '个'  );
						$( '#abnormal' ).html( abnormal );
						
						var oBox = document.getElementById("file_danger_count");
						var timer = null;  
						var i = 0; 
						clearInterval(timer);
						oBox.onmouseover = function(){
							clearInterval(timer);
						};
						timer = setInterval(function () {
						  oBox.style.display = i++ % 2 ? "none" : "block";
						  i > 8 && (clearInterval(timer))
						}, 500 );
						
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
		}
		
		</script>
    </body>
</html>