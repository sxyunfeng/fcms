<!doctype html>
<html>
<head>
<link rel="stylesheet" href="/css/admin/base.css">
<link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css">
<style>
body {
	font-family: "Arial", "微软雅黑", sans-serif;
}

.num {
	font-size: 20px;
	margin: 0 5px;
}

.glyphicon {
	margin-right: 5px;
}
</style>
</head>
<body class="wrap">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-success">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title"> 系统通知  </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        系统通知
      </div>
    </div>
  </div>
  <div class="panel panel-success">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title"> 系统信息  </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
         <table class="table">
			<tbody>
				<tr>
					<td>操作系统</td>
					<td><?php echo $this->sysinfo->getos(); ?></td>
				</tr>
				<tr>
					<td>运行环境</td>
					<td><?php echo $this->sysinfo->getevn(); ?></td>
				</tr>
				<tr>
					<td>PHP版本</td>
					<td><?php echo $this->sysinfo->getphpversion(); ?></td>
				</tr>
				<tr>
					<td>PHP运行方式</td>
					<td><?php echo $this->sysinfo->getphprunway(); ?></td>
				</tr>
				<tr>
					<td>MYSQL版本</td>
					<td> <?php echo $this->sysinfo->getsqlversion(); ?> </td>
				</tr>
				<tr>
					<td>程序版本</td>
					<td><?php echo $this->sysinfo->getcmsversion(); ?></td>
				</tr>
				<tr>
					<td>上传附件限制</td>
					<td><?php echo $this->sysinfo->getuploadlimit(); ?></td>
				</tr>
				<tr>
					<td>执行时间限制</td>
					<td><?php echo $this->sysinfo->getexecutelimit(); ?></td>
				</tr>
				<tr>
					<td>剩余空间大小</td>
					<td><?php echo $this->sysinfo->getsurplusspace(); ?></td>
				</tr>
			</tbody>
        </table>
      </div>
    </div>
  </div>
 <div class="panel panel-success">
    <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title"> 开发团队 </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body">
      	产品策划:&nbsp;&nbsp;&nbsp;&nbsp;钱志锋<br>
      	开&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;发:&nbsp;&nbsp;&nbsp;&nbsp;黄凤灿 牛志伟 钱志锋 田涛 杨彦龙 周立文（按字母顺序） 
      </div>
    </div>
  </div>
  
  <div class="panel panel-success">
    <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title">  鸣谢 </h4>
    </div>
    <div id="contributor" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body">
        云锋公司其他默默的奉献者
      </div>
    </div>
  </div>
  
</div>
</body>
<script src="/js/jquery/jquery-1.11.1.min.js"></script>
<script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</html>