<!doctype html>
<html>
<head>
        <link rel="stylesheet" href="/css/admin/base.css">

<link rel="stylesheet" href="/css/stats/AdminLTE.min.css" >

<link rel="stylesheet" type="text/css" href="/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/admin/font-awesome.min.css" >

<link rel="stylesheet" href="/bootstrap/datetimepicker/bootstrap-datetimepicker.min.css">

<!-- Ionicons -->
<link rel="stylesheet" href="/ionicons/css/ionicons.min.css">

<style>
 .operate {
     margin-right: 10px;
 }
 .operate:hover {
     cursor:pointer;
     color:green;
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
  <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#OrderCenter">订单统计中心</a></li>
  </ul>
  
  <section class="content">
  	<div class="col-md-6">
		<div class="box box-success">
         <div class="box-header ui-sortable-handle">
           <i class="fa fa-bar-chart normals"></i>
           <h3 class="box-title">订单总量</h3>
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
	                <input class="btn-small" type="button" onclick="getItemDetail(this, 'num')" value="确认">
	           	</div>
           </div>
         </div>
         <div class="box-body">
           <div class="chart tab-pane" id="order_num" style="position: relative; height: 400px;"></div>
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
  	
  	<div class="col-md-6">
  		<div class="box box-primary">
         <div class="box-header ui-sortable-handle">
           <i class="fa fa-bar-chart"></i>
           <h3 class="box-title">订单总额 </h3>
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
	                <input class="btn-small" type="button" onclick="getItemDetail(this , 'amt' )" value="确认">
	           	</div>
           </div>
         </div>
         <div class="box-body">
           <div class="chart tab-pane" id="order_amt" style="position: relative; height: 400px;"></div>
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
  	
  </section>

<script src="/js/jquery/jquery-1.11.1.min.js"></script>
<script src="/charts/chartJS/Chart.min.js"></script>
<script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="/bootstrap/datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="/bootstrap/datetimepicker/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>

<script src="/charts/Echarts/echarts-all.js"></script>
<script src="/js/admin/statistics/stat_order.js"></script>
<script type="text/javascript">
var orderXalias = <?php if( isset( $xalias ) ) echo $xalias; ?>; //x轴坐标
var statTime 	= "<?php if( isset( $title ) ) echo $title ?>";

//----------------------- 总订单数销售金额  折柱图 ---
var ordersAmt 	= <?php if( isset( $ordersAdds ) ) echo $ordersAdds; ?>;
var amtChart = echarts.init( document.getElementById('order_amt') , 'macarons' );
amtChart.setOption({
	title:{
		text: statTime+'份 订单总额统计信息',
		x: 'center',
	},
    tooltip : {
        trigger: 'axis',
    },
    toolbox: {
        show : true,
        feature : {
            magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            data :orderXalias,
        }
    ],
    yAxis : [
        {
            type : 'value',
            splitArea : {show : true}
        }
    ],
    series : [
        {
            name:'总金额',
            type:'line',
            data:ordersAmt,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
        },
    ]
});

//----------------------- 订单数量  折柱图 ---
var ordersAdds = <?php if( isset( $ordersAmt ) ) echo $ordersAmt; ?>;
var orderChart = echarts.init( document.getElementById('order_num') , 'macarons' );
orderChart.setOption({
	title:{
		text: statTime+'份 订单总量统计信息',
		x: 'center',
	},
    tooltip : {
        trigger: 'axis',
    },
    toolbox: {
        show : true,
        feature : {
            magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            data :orderXalias,
        }
    ],
    yAxis : [
        {
            type : 'value',
            splitArea : {show : true}
        }
    ],
    series : [
        {
            name:'订单量',
            type:'line',
            data:ordersAdds,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
        },
    ]
});
</script>
</body>
