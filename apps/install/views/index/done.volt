<!Doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.css" />
<link rel="stylesheet" href="/css/install/main.css" />
<style type="text/css">

</style>
<title>完成安装</title>
</head>
<body>
    
    <div class="container self_main">
    
        <!-- 标题 -->
        <div class="row">
            <div class="col-xs-12">
                <div class="page-header self_header">
                    <p><em>FCMS安装向导</em></p>
                </div>
            </div>
        </div>
        
        <!-- 内容 -->
        <div class="row">
        
            <!-- 流程 -->
            <div class="col-xs-3">
                <ul class="self_procedure">
                    <li><button class="self_btn_circular">安装须知</button></li>
                    <li><button class="self_btn_circular">环境检测</button></li>
                    <li><button class="self_btn_circular">数据创建</button></li>
                    <li><button class="self_btn_circular_active">完成安装</button></li>
                </ul>
            </div>
            
            <!-- 正文 -->
            <div class="col-xs-9">
            	<!-- 选择数据库文件 -->
            	<div class="row">
            		<div class="col-xs-12">
            			<span style="font-weight:bold;font-size:16px;">安装选项：</span>
						<div class="checkbox" style="display:inline-block">
							<label for="exampleData" style="padding:0">&nbsp;是否安装示例数据&nbsp;</label>
							<input type="checkbox" name="exampleData" id="exampleData" checked style="margin-left:5px">
					   </div>
            		</div>
            	</div>
            	
                <!-- 安装须知 -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="self_license_content" style="height:200px;">
                       		<!-- 第一步 -->
                        	<p>
                        		<span id="self_step1"></span>
                        		<span id='self_percentage'></span>
                        	</p>
                        </div>
                    </div>
                    
                </div>
                
                <div class="row" style="margin-top:50px;">
                    <div class="col-xs-12" style="text-align:center;">
                        <h3 id='self_waiting'>点击下方按钮开始配置FCMS</h3>
                        <!-- <p><span class="glyphicon glyphicon-ok" style="color:green;font-size:72px;"></span></p> -->
                        <div id="self_waiting_img" style="margin-top:20px;display:none;">
							<img src="/img/install/loading.gif" style="height:75px;width:75px;">
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
        
        <div class="row">
            <div class="col-xs-12">
                <!-- 上、下一步按钮 -->
                <div class="row self_choose_step">
                    <!-- 上一步 -->
                    <div class="col-xs-6 text-left">
                        <a href="/install/index/create" class="btn btn-danger btn-lg self_btn_normal self_forward">上一步</a>
                    </div>
                    
                    <!-- 开始安装 -->
                    <div class="col-xs-6 text-right">
                        <button class="btn btn-danger btn-lg self_btn_normal self_start" onclick="startInstall()">开始安装</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>


<script src="/js/jquery/jquery-1.11.1.min.js"></script>
<script src="/bootstrap/3.3.0/js/bootstrap.js"></script>
<script src="/js/install/html5shiv.js"></script>
<script src="/js/install/respond.js"></script>
<script src="/js/install/fcmsInstall.js"></script>

<script>

</script>
</body>
</html>