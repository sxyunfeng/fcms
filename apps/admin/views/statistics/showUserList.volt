<!doctype html>
<html>
<head>
        <link rel="stylesheet" href="/css/admin/base.css">
<link rel="stylesheet" href="/css/stats/AdminLTE.min.css" >
<link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/admin/font-awesome.min.css" >
<link rel="stylesheet" href="/bootstrap/datetimepicker/bootstrap-datetimepicker.min.css">

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
}

span.normals{
	cursor:pointer;
	margin-right:0;
	margin-left:6px;
}

select.select-sm{
	float:left;
	border-radius: 3px;
    font-size: 12px;
    height: 30px;
    line-height: 1.5;
	margin-right: 7px;
}
select.select-pos{
	float:left;
	background-color: #fff;
    background-position: right center;
    background-repeat: no-repeat;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.075) inset;
    box-sizing: border-box;
    color: #333;
    font-size: 13px;
    min-height: 32px;
    outline: medium none;
    transition: all 0.15s ease-in 0s;
    vertical-align: middle;
}
div .input-pos{
	float:left;
 	width: 130px;
	background-color: #fff;
    background-position: right center;
    background-repeat: no-repeat;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.075) inset;
    box-sizing: border-box;
    color: #333;
    font-size: 13px;
    margin: 0;
    min-height: 32px;
    outline: medium none;
    padding: 7px 8px;
    transition: all 0.15s ease-in 0s;
    vertical-align: middle;
}

input.btn-small {
	float:left;
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    -moz-user-select: none;
    background-color: #eaeaea;
    background-image: linear-gradient(#fafafa, #eaeaea);
    background-repeat: repeat-x;
    border-color: #ddd #ddd #c5c5c5;
    border-image: none;
    border-radius: 3px;
    border-style: solid;
    border-width: 1px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    box-sizing: border-box;
    color: #333;
    cursor: pointer;
    display: inline-block;
    font-size: 13px;
    font-weight: bold;
    margin: 0;
     padding: 5px 15px;
    position: relative;
    text-shadow: 0 1px 0 rgba(255, 255, 255, 0.9);
    vertical-align: middle;
    white-space: nowrap;
}
</style>
</head>
<body class="wrap">
<ul class="nav nav-tabs" role="tablist" id="tabs">
    <li role="presentation"><a href="/admin/statistics/statMember">会员统计中心</a></li>
    <li role="presentation" class="active"><a href="#userList">用户统计中心</a></li>
</ul>
<div class="tab-content" style="padding:20px 0px;">
   <!-- 用户列表  -->
   <div role="tabpannel" class="tab-pane active" id="userList">
       <table class="table table-hover table-bordered">
          <thead>
          	  <tr>
          	  	<th colspan="5">基本信息</th>
          	  	<th colspan="2">查看</th>
          	  </tr>
              <tr>
                  <th>序号</th>
                  <th>编号</th>
                  <th>登陆名称</th>
                  <th>用户名称</th>
                  <th>用户性别</th>
                  <th width="120px;">用户消费金额</th>
                  <th width="120px;">用户订单量</th>
              </tr>
          </thead>
                    
         {% if page.items is defined and page.items is not empty %}
        <tbody id="fileList">
        	{% for i,item in page.items %}
            <tr>
                <td style="text-align:center">{{ i+1 }}</td>
                <td style="text-align:center">{{ item.id }}</td>
                <td>{{ item.login_name }}</td>
                {% if item.username is defined %}<td>{{ item.username }}</td> {% else %}<td style="text-align:center"> ------ </td> {% endif %}
                <td style="text-align:center">
                	{% if 1 == item.gender %}女{% else %}男{% endif %}
                </td>
                <td style="text-align:center">
                    <a href="javascript:void(0);" onclick="showAmtChart(this, {{ item.id }} );" title="点击查看统计详情"><i class="fa fa-line-chart fa-lg" ></i></a>
                </td>
                <td style="text-align:center">
                    <a href="javascript:void(0);" onclick="showOrderChart(this,{{ item.id }});" title="点击查看统计详情"><i class="fa fa-line-chart fa-lg" ></i></a>
                </td>
            </tr>
           {% endfor %}
        </tbody>
      {% endif %}
    </table>
                
      {% if page.total_pages > 1 %}
      <nav class="text-right" >
          <ul class="pagination pagination-sm" style="margin-top:0"> 
              <li class="{% if page.current == 1 %}disabled{% endif %}"><a href="{{ url( '/admin/statistics/showUserList?page=' ) }}{{page.before}}" >&laquo;</a></li>
              {% if  1 != page.current and 1 != page.before %}
              <li><a href="{{ url( '/admin/statistics/showUserList') }}">1</a></li>
              {% endif %}

              {% if page.before != page.current  %}
              <li><a href="{{ url( '/admin/statistics/showUserList?page=') }}{{ page.before }}"><span >{{ page.before }}</span></a></li>
              {% endif %}
              <li class="active"><a href="{{ url( '/admin/statistics/showUserList?page=') }}{{ page.current }}"><span >{{ page.current }}</span></a></li>
              {% if page.next != page.current %}
              <li><a href="{{ url( '/admin/statistics/showUserList?page=') }}{{ page.next }}">{{ page.next }}</a></li>
              {% endif %}
              {% if page.next  < page.last - 1 %}
              <li><a>...</a></li>
              {% endif %}
              {% if page.last != page.next %}
              <li><a href="{{ url( '/admin/statistics/showUserList?page=') }}{{ page.last }}">{{ page.last }}</a></li>
              {% endif %}
              <li class="{% if page.current == page.last %}disabled{% endif %}"><a href="{{ url( '/admin/statistics/showUserList?page=' ) }}{{page.next}}" >&raquo;</a></li>

          </ul>
      </nav>
      {% endif %}
      
      <div class="col-xs-12 text-center loading" style="display:none">
           <i class="fa fa-pulse fa-spinner fa-3x"></i>
      </div>
      <div style="color: #000;left: 40%;margin-left: -15px;margin-top: -15px;position: absolute;top: 40%; display:none">
          	<div class="alert alert-info alert-dismissable">
              <h4><i class="icon fa fa-info"></i> 提示信息!</h4>
              <p id="show_msg"></p>
            </div>
      </div>
	       	 
    </div>
    <!-- 用户列表  -->
    
    <!-- 统计图表   -->
    <div role="tabpannel" class="tab-pane" id="showAmtChartInfo">
    	<table class="table table-hover table-bordered">
           <thead>
           	<tr>
              <th><input type="hidden" id="amtid" name="amt" value="" /></th>
              <th style="width:150px;text-align:center">
              	  <a href="/admin/statistics/showUserList"><i class="fa fa-backward"></i> 返回</a>
              </th>
            </tr>
          </thead>
    	</table>
    	<div class="col-md-12">
			<div class="box box-success">
	         <div class="box-header ui-sortable-handle">
	           <i class="fa fa-user normals"></i>
	           <h3 class="box-title">消费金额曲线图</h3>
	           <div class="box-tools pull-right"> 
					<span class="normals" onclick="showDatePicker( this )">
						<i class="fa fa-calendar"></i>
					</span>
					<div class="input-group" style="display:none; float:left">
		                <input class="input-sm input-pos" readonly type="text" onclick="this.value=''" />
		                <select class="select-sm select-pos" onchange="changeFormatType(this)">
		                  <option value="0">天</option>
		                  <option value="1">年份</option>
		                  <option value="2">月份</option>
		                  <option value="3">小时</option>
		                  <option value="4">时间段</option>
		                </select>
		                <input class="btn-small" type="button" onclick="getItemDetail(this, 'amt')" value="确认">
		           	</div>
	           </div>
	         </div>
	         <div class="box-body">
	           <div class="chart tab-pane" id="amt_chart" style="position: relative; height: 500px;"></div>
	         </div>
			 
			 <div class="overlay" style="display:none">
				<i class="fa fa-refresh fa-spin"></i>
			 </div>
			 
			 <div style="color: #000;left: 40%;margin-left: -15px;margin-top: -15px;position: absolute;top: 40%; display:none">
	           	<div class="alert alert-info alert-dismissable">
	               <h4><i class="icon fa fa-info"></i> 提示信息!</h4>
	               <p class="dis_message"></p>
	             </div>
	       	 </div>
			 
	       </div>
	       
	  	</div>
    </div>
    
    <div role="tabpannel" class="tab-pane" id="showOrderChartInfo">
    	<table class="table table-hover table-bordered">
           <thead>
           	<tr>
              <th><input type="hidden" id="orderid" name="order" value="" /></th>
              <th style="width:150px;text-align:center">
              	  <a href="/admin/statistics/showUserList"><i class="fa fa-backward"></i> 返回</a>
              </th>
            </tr>
          </thead>
    	</table>
	  	<div class="col-md-12">
	  		<div class="box box-primary">
	         <div class="box-header ui-sortable-handle">
	           <i class="fa fa-inbox"></i>
	           <h3 class="box-title">用户订单量曲线图</h3>
	           <div class="box-tools pull-right"> 
					<span class="normals" onclick="showDatePicker( this )">
						<i class="fa fa-calendar"></i>
					</span>
					<div class="input-group" style="display:none; float:left">
		                <input class="input-sm input-pos" readonly type="text" onclick="this.value=''" />
		                <select class="select-sm select-pos" onchange="changeFormatType(this)">
		                  <option value="0">天</option>
		                  <option value="1">年份</option>
		                  <option value="2">月份</option>
		                  <option value="3">小时</option>
		                  <option value="4">时间段</option>
		                </select>
		                <input class="btn-small" type="button" onclick="getItemDetail(this , 'order' )" value="确认">
		           	</div>
	           </div>
	         </div>
	         <div class="box-body">
	           <div class="chart tab-pane" id="order_chart" style="position: relative; height: 500px;"></div>
	         </div>
	         
	         <div class="overlay" style="display:none">
				<i class="fa fa-refresh fa-spin"></i>
			 </div>
			 
			 <div style="color: #000;left: 40%;margin-left: -15px;margin-top: -15px;position: absolute;top: 40%; display:none">
	           	<div class="alert alert-info alert-dismissable">
	               <h4><i class="icon fa fa-info"></i> 提示信息!</h4>
	               <p class="dis_message"></p>
	             </div>
	       	 </div>
	       </div>
	  	</div>
    </div>
    <!-- 统计图表   -->
</div>
        
<script src="/js/jquery/jquery-1.11.1.min.js"></script>
<script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="/bootstrap/datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="/bootstrap/datetimepicker/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>

<script src="/charts/Echarts/echarts-all.js"></script>
<script src="/js/admin/statistics/stat_user.js"></script>
</body>
</html>