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
<title>账户配置</title>
</head>
<body>
    
    <div class="container self_main">
    
	    <form id="inputInfo">
	    
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
	                    <li><button class="self_btn_circular_active">数据创建</button></li>
	                    <li><button class="self_btn_circular">完成安装</button></li>
	                </ul>
	            </div>
	            
	            <!-- 正文 -->
	            <div class="col-xs-9">
	            
	                <!-- 数据部分 -->
	                <div class="row">
	                
	                   	<div class="col-xs-12">
		            	 	<div class="panel self_panel">
		                        <div class="panel-heading self_panel_heading">
		                        	<h4>数据库信息</h4>
		                        </div>
		                        <table class="table table-striped table-hover self_table">
		                            <tbody>
		                            	<tr>
			                                <td style="min-width:120px;">数据库主机：</td>
		                                	<td style="min-width:120px;"><input type="text" class="form-control self_input required hostInput" name="db_host" id="db_host" value="127.0.0.1"></td>
		                                	<td class="self_fixd_tdwidth" style="min-width:200px;"><span class="db_host_alert">数据库服务器地址，一般为127.0.0.1</span></td>
		                                </tr> 
		                                <tr>
			                                <td>数据库端口：</td>
		                                	<td><input type="text" class="form-control self_input required number" name="db_port" id="db_port" value="3306"></td>
		                                	<td class="db_port_alert">数据库服务器端口，一般为3306</td>
		                                </tr> 
		                                <tr>
			                                <td>数据库账号：</td>
		                                	<td> <input type="text" class="form-control self_input required commonInput" name="db_username" id="db_username" value="<?php $dbUsername = $this->cookies->get( 'dbUsername' );echo $dbUsername ? $dbUsername : ''; ?>"></td>
		                                	<td class="db_username_alert"></td>
		                                </tr> 
		                                <tr>
			                                <td>数据库密码：</td>
		                                	<td><input type="password" class="form-control self_input required commonInput" name="db_password" id="db_password"></td>
		                                	<td class="db_password_alert"></td>
		                                </tr> 
		                                <tr>
			                                <td>数据库名称：</td>
		                                	<td><input type="text" class="form-control self_input required commonInput" name="db_name" id="db_name" value="fcms"></td>
		                                	<td class="db_name_alert">建议使用默认</td>
		                                </tr> 
		                                <tr>
			                                <td>数据库前缀：</td>
		                                	<td><input type="text" class="form-control self_input required" name="db_prefix" id="db_prefix" value="fc_"></td>
		                                	<td class="db_prefix_alert">建议使用默认，同一数据库安装多个FCMS时需修改</td>
		                                </tr> 
		                                
		                            </tbody>
		                        </table>
	                        </div>
	                    </div>
	                    
	                </div>
	                
	                <div class="row" style="margin-top:20px;">
	                	<div class="col-xs-12">
		            	 	<div class="panel self_panel">
		                        <div class="panel-heading self_panel_heading">
		                        	<h4>管理员信息</h4>
		                        </div>
		                        <table class="table table-striped table-hover self_table">
		                            <tbody>
		                                <tr>
			                                <td style="min-width:120px;">管理员账号：</td>
		                                	<td style="min-width:120px;"><input type="text" class="form-control self_input required commonInput" name="master_username" id="master_username" value="<?php $masterUsername = $this->cookies->get( 'masterUsername' );echo $masterUsername ? $masterUsername : ''; ?>"></td>
		                                	<td class="self_fixd_tdwidth master_username_alert" style="min-width:200px;"></td>
		                                </tr>
		                                <tr>
			                                <td>管理员密码：</td>
		                                	<td><input type="password" class="form-control self_input required passwordInput" name="master_password" id="master_password"></td>
		                                	<td class="master_password_alert"></td>
		                                </tr> 
		                                <tr>
			                                <td>重复密码：</td>
		                                	<td><input type="password" class="form-control self_input required" name="master_confirmpassword" id="master_confirmpassword" ></td>
		                                	<td class="master_confirmpassword_alert"></td>
		                                </tr> 
		                                <tr>
			                                <td>管理员Email：</td>
		                                	<td><input type="text" class="form-control self_input required emailInput" name="master_email" id="master_email" value="<?php $masterEmail = $this->cookies->get( 'masterEmail' );echo $masterEmail ? $masterEmail : ''; ?>"></td>
		                                	<td class="master_email_alert"></td>
		                                </tr> 
		                            </tbody>
		                        </table>
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
	                        <a href="/install/index/check" class="btn btn-danger btn-lg self_btn_normal">上一步</a>
	                    </div>
	                    
	                    <!-- 下一步 -->
	                    <div class="col-xs-6 text-right">
	                    	<input type="submit" class="btn btn-danger btn-lg self_btn_normal" value="下一步" style="width:200px;">
	                    </div>
	                </div>
	            </div>
	        </div>
	        
	    </form>
        
    </div>


<script src="/js/jquery/jquery-1.11.1.min.js"></script>
<script src="/js/jquery/validate/jquery.validate.js"></script>
<script src="/js/jquery/validate/jquery.metadata.js"></script>
<script src="/bootstrap/3.3.0/js/bootstrap.js"></script>
<script src="/js/install/html5shiv.js"></script>
<script src="/js/install/respond.js"></script>
<script src="/js/install/formValidate.js"></script>


</body>
</html>