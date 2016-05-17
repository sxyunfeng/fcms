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
            <div class="col-xs-9" style="position:relative;">
            
                <div class="row" style="margin-top:20px;">
                    <div class="col-xs-12" style="text-align:center;">
                    	<h3><span class='glyphicon glyphicon-ok' style='color:#8bcc2f;font-size:150px;'></h3>
                        <h3>安装完成，请您删除install安装文件</h3>
                    </div>
                </div>
                
                <div class="row self_choose_step" style="margin-top:50px;">
                    <div class="col-xs-12" style="text-align:center;">
                    	<button class="btn btn-danger btn-lg self_btn_normal" onclick="javascript:location.href='/admin/login/index'">登录FCMS</button>
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
</body>
</html>