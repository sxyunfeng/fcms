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
      <li role="presentation" class="active"><a href="#usersCenter">广告统计中心</a></li>
  </ul>
  <div class="row" style="margin-top:10px;">
 	<div class="col-lg-3 col-xs-6">
  		<div class="small-box bg-green">
             <div class="inner">
               <h3>{{all}}</h3>
               <p>广告总数</p>
             </div>
             <div class="icon">
                  <i class="ion-record"></i>
             </div>
             <a class="small-box-footer" href="/admin/statistics/showAdList">更多<i class="fa fa-arrow-circle-right"></i></a>
       </div>
    </div>
     
     <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
            <div class="inner">
               <h3>{{shopad}}</h3>
              <p>商家广告</p>
            </div>
            <div class="icon">
                 <i class="ion-contrast"></i>
            </div>
            <a class="small-box-footer" href="/admin/statistics/showAdList">更多 <i class="fa fa-arrow-circle-right"></i></a>
      </div>  
  	</div>
     
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{selfad}}</h3>
              <p>自营广告</p>
            </div>
            <div class="icon">
                 <i class="ion-contrast"></i>
            </div>
            <a class="small-box-footer" href="/admin/statistics/showAdList">更多 <i class="fa fa-arrow-circle-right"></i></a>
      </div>  
  	</div>
   
   	<div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
            <div class="inner">
               <h3>{{isShow}}</h3>
              <p>启用数</p>
            </div>
            <div class="icon">
                 <i class="fa fa-cloud"></i>
            </div>
            <a class="small-box-footer" href="/admin/statistics/showAdList">更多 <i class="fa fa-arrow-circle-right"></i></a>
      </div>  
  	</div>
  	
  </div>
  
  <section class="content">
  	<div class="col-md-6">
		<div class="box box-success">
         <div class="box-header ui-sortable-handle">
           <i class="fa fa-user normals"></i>
           <h3 class="box-title">广告总点击率</h3>
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
	                <input class="btn-small" type="button" onclick="getItemDetail(this, 'all')" value="确认">
	           	</div>
	           	<a href="/admin/statistics/showAdList" class="btn btn-box-tool">
          		 	<span class="box-title" style="font-size:16px;">详细</span> <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>
				</a>
           </div>
         </div>
         <div class="box-body">
           <div class="chart tab-pane" id="adsclk-chart" style="position: relative; height: 400px;"></div>
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
           <i class="fa fa-inbox"></i>
           <h3 class="box-title">总人数 男/女比例</h3>
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
	                <input class="btn-small" type="button" onclick="getItemDetail(this , 'gender' )" value="确认">
	           	</div>
			
          		<a href="/admin/statistics/showAdList" class="btn btn-box-tool">
          		 	<span class="box-title" style="font-size:16px;">详细</span> <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>
				</a>
           </div>
         </div>
         <div class="box-body">
           <div class="chart tab-pane" id="gender-chart" style="position: relative; height: 400px;"></div>
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
<script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="/bootstrap/datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="/bootstrap/datetimepicker/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>


<script src="/charts/Echarts/echarts-all.js"></script>
<script src="/js/admin/statistics/stat_ads.js"></script>
<script type="text/javascript">
var statTime = "<?php if( isset( $title ) ) echo $title ?>";
var xalias 	= <?php if( isset( $xalias ) ) echo $xalias; ?>;

//----------------------- 广告点击次数  折柱图 ---
var allClk=<?php if( isset( $click_num ) ) echo $click_num; ?>;
var adClkChart = echarts.init( document.getElementById('adsclk-chart') , 'macarons' );
adClkChart.setOption({
	title:{
		text: statTime+'份 广告点击总次数统计',
		x: 'left',
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
            data :xalias,
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
            name:'点击次数',
            type:'line',
            data:allClk,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
        },
    ]
});

//----------------------- 广告点击总人数 男女个数  折柱图 ---
var allMem  = <?php if( isset( $allmem ) ) echo $allmem; ?>;
var female = <?php if( isset( $female ) ) echo $female; ?>;
var male   = <?php if( isset( $male ) ) echo $male; ?>;
var clkCateChart = echarts.init( document.getElementById( 'gender-chart') , 'macarons' );
clkCateChart.setOption({
	title:{
		text: statTime+'份 点击总人数、男女人数统计',
		x: 'left',
	},
    tooltip : {
        trigger: 'axis',
    },
    legend: {
        data:['总人数','女会员','男会员'],
        y: 'bottom'
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
            data :xalias,
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
            name:'总人数',
            type:'line',
            data:allMem,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
        },
        {
            name:'女会员',
            type:'line',
            data:female,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
        },
        {
            name:'男会员',
            type:'line',
            data:male,
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
