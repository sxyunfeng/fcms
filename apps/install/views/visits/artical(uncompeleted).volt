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
			table tr td,th{
				text-align:center
			}
			.cst-form-control {
			    background-color: #fff;
			    background-image: none;
			    border: 1px solid #ccc;
			    border-radius: 4px;
			    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
			    color: #555;
			    display: block;
			    font-size: 14px;
			    height: 34px;
			    line-height: 1.42857;
			    padding: 6px 12px;
			    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
			}
			span.info{
				font-size: 13px;
				color:#95a5a6;
			}
        </style>
    </head>
    <body class="wrap">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#defaultConfig">基本配置</a></li>
        </ul>
        <div class="tab-content" style="padding:20px 0px;">
            <div role="tabpannel" class="tab-pane active" id="defaultConfig">
                <table class="table table-bordered">
                    <tbody>
						<tr>
							<th rowspan="4" width="20%" style="vertical-align:middle;">基本配置</th>
							<td>是否显示访问次数</td>
							<td>
								<input type="radio" name="visits_check" id="check_no" value="0" checked> 不使用
                       			<input type="radio" name="visits_check" id="check_yes" value="1" style="margin-left:20%;"> 使用
							</td>
						</tr>
						<tr>
							<td>访问次数保存位置</td>
							<td>
								<input type="radio" name="visits_pos" id="pos_redis" value="0" checked> Redis
                       			<input type="radio" name="visits_pos" id="pos_mysql" value="1" style="margin-left:20%;"> Mysql
							</td>
						</tr>
						<tr>
							<td>缓存驱动选择</td>
							<td>
								<input type="radio" name="visits_driver" id="driver_redis" value="0" checked> Redis
                       			<input type="radio" name="visits_driver" id="driver_memcache" value="1" style="margin-left:10%;"> Memcache
								<input type="radio" name="visits_driver" id="driver_apc" value="2" style="margin-left:10%;"> Apc
								<input type="radio" name="visits_driver" id="driver_file" value="3" style="margin-left:10%;"> File
							</td>
						</tr>
						<tr>
	                       	<td colspan="2"></td>
	                       	<td>
	                       		<button type="button" id="btnBase" class="btn btn-primary">确认修改</button>
	                       		<input type="hidden" name="time_id" value="{% if base.id is defined and false != base.id  %}{{ base.id }}{% endif %}" />
	                       	</td>
						</tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div style="left: 30%;margin-left: -15px;margin-top: -15px;position: absolute;top: 50%; display:none;" class="text-center col-xs-4">
          	<div class="alert alert-dismissable ">
				<h4><i class="glyphicon glyphicon-info-sign"></i> 提示信息!</h4>
				<p id="dis_message"></p>
            </div>
    	</div>
        
        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/js/admin/static/index.js"></script>
        <script type="text/javascript">
        </script>
    </body>
</html>