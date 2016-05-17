<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="/css/admin/base.css">
		<link rel="stylesheet" href="/css/fcmsIndex/common.css" />
		<link rel="stylesheet" href="/css/fcmsIndex/demo.css" />
		<link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="/bootstrap/toastr/toastr.min.css">
	</head>
	<body class="wrap">
		<!-- 标题 -->
		<div class="title">示例页面</div>
    
		<!-- 筛选 -->
		<div class="list-filterbox clearfix">
			<div class="list-addbtn">
				<button type="button" class="btn btn-primary" style="width:100px;">新建</button>
			</div>
    	
			<div class="right">
				<span class="glyphicon glyphicon-repeat list-refresh" title="刷新"></span>
			</div>
    	
			<div class="list-search">
				<input type="text" class="form-control" placeholder="请输入用户名">
				<span class="glyphicon glyphicon-remove"></span>
			</div>
         
			<div class="dropdown list-filter">
				<div class="dropdown-toggle list-filter-text" data-toggle="dropdown">
					<span id="list-filter-text" groupId="-1">全部分组</span>
					<span class="caret"></span>
				</div>
				<ul class="dropdown-menu pull-right"> 
					<li groupId="-1"><a>全部分组</a></li>  
				</ul>
			</div>
		</div>

		<!-- 列表 -->
		<div class="list-table">
			<table class="table">
				<thead>
					<tr>
						<th style="width:8%">用户名</th>
						<th style="width:8%">昵称</th>
						<th style="width:18%">姓名</th>
						<th style="width:16%">用户组</th>
						<th style="width:18%">邮箱</th>
						<th style="width:10%">状态</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				<!-- 展示列表数据 -->
				</tbody>
			</table>
		</div>
    
		<!-- 分页 -->
		<ul class="pager">
			<li><a>首页</a></li>
			<li><a>上一页</a></li>
			<li>
				<input class="list-curpage" value="1"></input>
			</li>
			<li>/</li>
			<li class="list-total_pages">
				1
			</li>
			<li><a>下一页</a></li>
			<li><a>尾页</a></li>
		</ul>
		{% include "index/common.volt" %}
    
		<script src="/js/jquery/jquery-1.11.1.min.js"></script>
		<script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="/bootstrap/toastr/toastr.min.js"></script>
		<script src="/js/fcmsIndex/demo/demoData.js"></script>
		<script src="/js/fcmsIndex/demo/demo.js"></script>
	</body>
</html>