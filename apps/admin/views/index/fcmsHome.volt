<!DOCTYPE html>
<html lang="zh_CN">
<head>
	<title>后台详情首页</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge" />
	<meta name="renderer" content="webkit">
	<meta charset="utf-8">
	<meta name="description" content="This is page-header">
	<meta name="keywords" content="后台详情首页">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel='icon' href='/public/favicon.ico' mce_href='/public/favicon.ico' type='image/x-icon'>
	<link rel='shortcut icon' href='/public/favicon.ico' mce_href='/public/favicon.ico' type='image/x-icon'>
	<link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/public/css/fcmsindex/home.css">
</head>

<body>
	<div class="home_main container-fluid">
	
		<div class="home_square_data">
		
			<!-- <div class="home_square_header">
				<span class="glyphicon glyphicon-list" style="font-size:14px;"></span>&nbsp;&nbsp;数据信息
			</div> -->
			
			<div class="row" style="width:100%;margin:10px auto;padding-left:10px;">
				<div class="col-xs-6 col-sm-3 home_square" style="background-color:#64b2e3;">
					<div class="home_square_icon">
						<img src="/public/img/admin/fcms/square_icon1.png" width="60px">
					</div>
					<div class="home_square_content">
						<p class="home_square_head"><?php if( $this->backendHome->getUserNums() ){ echo ( int )$this->backendHome->getUserNums(); }else{ echo 0; } ?></p>
						<p class="home_square_body">注册会员数</p>
					</div>
					<div style="clear:both;"></div>
				</div>
				
				<div class="col-xs-6 col-sm-3 home_square" style="background-color:#FFB748;">
					<div class="home_square_icon">
						<img src="/public/img/admin/fcms/square_icon3.png" width="60px">
					</div>
					<div class="home_square_content">
						<p class="home_square_head"><?php if( $this->backendHome->getArticleNums() ){ echo ( int )$this->backendHome->getArticleNums(); }else{ echo 0; } ?></p>
						<p class="home_square_body">发表文章数</p>
					</div>
					<div style="clear:both;"></div>
				</div>
				
				<div class="col-xs-6 col-sm-3 home_square" style="background-color:#6ada43;">
					<div class="home_square_icon">
						<img src="/public/img/admin/fcms/square_icon2.png" width="60px">
					</div>
					<div class="home_square_content">
						<p class="home_square_head">1953</p>
						<p class="home_square_body">商家入驻数（示例）</p>
					</div>
					<div style="clear:both;"></div>
				</div>
				
				<div class="col-xs-6 col-sm-3 home_square" style="background-color:#FD5F56;margin-right:0;">
					<div class="home_square_icon">
						<img src="/public/img/admin/fcms/square_icon4.png" width="60px">
					</div>
					<div class="home_square_content">
						<p class="home_square_head">36992</p>
						<p class="home_square_body">商品发布数（示例）</p>
					</div>
					<div style="clear:both;"></div>
				</div>
			
			</div>
		
		</div>
		
		<div class="row" style="margin:0;">
			
			<div class="home_part col-xs-5" style="width:49%;">
				<div class="home_header home_part_header">
					<span class="glyphicon glyphicon-list" style="font-size:14px;"></span><span style="margin-left:0.5em;"></span>访问来源（示例）
				</div>
				<div class="row home_part_main">
					<div class="home_part_body col-xs-6">
						<canvas id="home_canvas" width="200px" height="200px"></canvas>
					</div>
					<div class="home_part_footer col-xs-6">
						<div class="home_part_footer_square">
							<p><span class="glyphicon glyphicon-stop" style='color:#F38630'></span><span style="margin-left:0.5em;"></span>PC端</p>
							<p><span class="glyphicon glyphicon-stop" style='color:#E0E4CC'></span><span style="margin-left:0.5em;"></span>平板端</p>
							<p><span class="glyphicon glyphicon-stop" style='color:#69D2E7'></span><span style="margin-left:0.5em;"></span>手机端</p>
						</div>
					</div>
				</div>
			</div>
			
			<div class="" style="width:2%;height:100px;float:left;"></div>
			
			<div class="home_part col-xs-5" style="width:49%;">
				<div class="home_header home_part_header">
					<span class="glyphicon glyphicon-list" style="font-size:14px;"></span><span style="margin-left:0.5em;"></span>访问来源（示例）
				</div>
				<div class="row home_part_main">
					<div class="home_part_body col-xs-6">
						<canvas id="home_doughnut" width="200px" height="200px"></canvas>
					</div>
					<div class="home_part_footer col-xs-6">
						<div>
							<p><span class="glyphicon glyphicon-stop" style='color:#F38630'></span><span style="margin-left:0.5em;"></span>PC端</p>
							<p><span class="glyphicon glyphicon-stop" style='color:#E0E4CC'></span><span style="margin-left:0.5em;"></span>平板端</p>
							<p><span class="glyphicon glyphicon-stop" style='color:#69D2E7'></span><span style="margin-left:0.5em;"></span>手机端</p>
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
		
		

		<div class="row" style="margin:0;">
			<div class="home_part col-xs-12">
				<div class="home_header home_part_header">
					<span class="glyphicon glyphicon-list" style="font-size:14px;"></span><span style="margin-left:0.5em;"></span>开发团队
				</div>
				<div class="home_part_main" style="margin:10px;font-size:16px;color:#fff;">
					<p style="background-color:#888888;border-radius:3px;height:35px;line-height:35px;padding:0 24px;"><span>开</span><span style="margin-left:2em;">发</span>:<span style="margin-left:0.5em;"></span>云峰技术团队</p>
				</div>
			</div>
		
		</div>
		
		
		
		<!-- <div class="row" style="margin:0;">
		
			<div class="home_part col-xs-7" style="width:58%;">
				<div class="home_header home_part_header">
					<span class="glyphicon glyphicon-list" style="font-size:14px;"></span>&nbsp;&nbsp;访问来源
				</div>
				<div class="row home_part_main">
					<div class="home_part_body col-xs-9">
						<canvas id="home_line" width="400px" height="200px;"></canvas>
					</div>
					<div class="home_part_footer col-xs-3">
						<div>
							<p><span class="glyphicon glyphicon-stop" style='color:#F38630'></span>&nbsp;&nbsp;PC端</p>
							<p><span class="glyphicon glyphicon-stop" style='color:#E0E4CC'></span>&nbsp;&nbsp;平板端</p>
							<p><span class="glyphicon glyphicon-stop" style='color:#69D2E7'></span>&nbsp;&nbsp;手机端</p>
						</div>
					</div>
				</div>
			</div>
			
			<div class="" style="width:2%;height:100px;float:left;"></div>
			
			<div class="home_part col-xs-4" style="width:40%;">
				<div class="home_header home_part_header">
					<span class="glyphicon glyphicon-list" style="font-size:14px;"></span>&nbsp;&nbsp;访问来源
				</div>
				<div class="row home_part_main">
					<div class="home_part_body col-xs-9">
						<canvas id="home_line" width="400px" height="200px;"></canvas>
					</div>
					<div class="home_part_footer col-xs-3">
						<div>
							<p><span class="glyphicon glyphicon-stop" style='color:#F38630'></span>&nbsp;&nbsp;PC端</p>
							<p><span class="glyphicon glyphicon-stop" style='color:#E0E4CC'></span>&nbsp;&nbsp;平板端</p>
							<p><span class="glyphicon glyphicon-stop" style='color:#69D2E7'></span>&nbsp;&nbsp;手机端</p>
						</div>
					</div>
				</div>
			</div>
			
		</div> -->
		
	</div>
	
	<script src="/js/jquery/jquery-1.11.1.min.js"></script>
	<script src="/bootstrap/3.3.0/js/bootstrap.js"></script>
	<script src="/js/install/html5shiv.js"></script>
	<script src="/js/install/respond.js"></script>
	<script src="/js/jquery/plugins/jquery.animate-colors.js"></script>
	<script src="/bootstrap/Chart.js/Chart.js"></script>
	<script>
		
		$( document ).ready( function(){
			
			/*------------ 访问来源扇形图 -----------*/
			var canvasCtx = $( "#home_canvas" ).get( 0 ).getContext( "2d" );
			var data = [
		       	{
		       		value: 30,
		       		color:"#F38630"
		       	},
		       	{
		       		value : 50,
		       		color : "#E0E4CC"
		       	},
		       	{
		       		value : 100,
		       		color : "#69D2E7"
		       	}			
			]
			var homeCanvas = new Chart( canvasCtx ).Pie( data );
			
			/*------------ 环形图 -----------*/
			var doughnutCtx = $( "#home_doughnut" ).get( 0 ).getContext( "2d" );
			var data = [
			        	{
			        		value: 30,
			        		color:"#FA4444"
			        	},
			        	{
			        		value : 50,
			        		color : "#6FC174"
			        	},
			        	{
			        		value : 100,
			        		color : "#FFB553"
			        	},
			        	{
			        		value : 40,
			        		color : "#949FB2"
			        	},
			        	{
			        		value : 120,
			        		color : "#64B2E3"
			        	}
			        ]
			new Chart( doughnutCtx ).Doughnut( data );
			
//			/*------------ 访问量曲线图 -----------*/
//			var lineCtx = $( "#home_line" ).get( 0 ).getContext( "2d" );
//			var data = {
//					labels : ["January","February","March","April","May","June","July"],
//					datasets : [
//						{
//							fillColor : "rgba(58,157,226,0.5)",
//							strokeColor : "rgba(58,157,226,1)",
//							pointColor : "rgba(58,157,226,1)",
//							pointStrokeColor : "#fff",//圆点边框颜色
//							data : [65,59,90,81,56,55,40]
//						},
//						{
//							fillColor : "rgba(253,95,86,0.5)",
//							strokeColor : "rgba(253,95,86,1)",
//							pointColor : "rgba(253,95,86,1)",
//							pointStrokeColor : "#fff",
//							data : [28,48,40,19,96,27,100]
//						}
//					]
//				}
//			new Chart( lineCtx ).Line( data );
			
		} );

		
	</script>
</body>

</html>