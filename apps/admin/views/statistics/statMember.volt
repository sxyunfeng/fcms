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
      <li role="presentation" class="active"><a href="#usersCenter">会员统计中心</a></li>
  </ul>
  <div class="row" style="margin-top:10px;">
 	<div class="col-lg-3 col-xs-6">
  		<div class="small-box bg-green">
             <div class="inner">
               <h3>{{ allUserNum }}</h3>
               <p>会员总数</p>
             </div>
             <div class="icon">
                  <i class="ion-person-stalker"></i>
             </div>
             <a class="small-box-footer" href="/admin/statistics/showUserList">更多<i class="fa fa-arrow-circle-right"></i></a>
       </div>
    </div>
     
     <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
            <div class="inner">
               <h3>{{deluser}}</h3>
              <p>注销用户</p>
            </div>
            <div class="icon">
                 <i class="ion-backspace-outline"></i>
            </div>
            <a class="small-box-footer" href="/admin/statistics/showUserList">更多 <i class="fa fa-arrow-circle-right"></i></a>
      </div>  
  	</div>
     
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ allMaleNum }}</h3>
              <p>男会员总数</p>
            </div>
            <div class="icon">
                 <i class=" ion-male"></i>
            </div>
            <a class="small-box-footer" href="/admin/statistics/showUserList">更多 <i class="fa fa-arrow-circle-right"></i></a>
      </div>  
  	</div>
   
   	<div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
            <div class="inner">
               <h3>{{ allFemaleNum }}</h3>
              <p>女会总员数</p>
            </div>
            <div class="icon">
                 <i class="ion-female"></i>
            </div>
            <a class="small-box-footer" href="/admin/statistics/showUserList">更多 <i class="fa fa-arrow-circle-right"></i></a>
      </div>  
  	</div>
  	
  </div>
  
  <section class="content">
  	<div class="col-md-6">
		<div class="box box-success">
         <div class="box-header ui-sortable-handle">
           <i class="fa fa-user normals"></i>
           <h3 class="box-title">会员增长</h3>
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
	                <input class="btn-small" type="button" onclick="getItemDetail(this, 'user')" value="确认">
	           	</div>
           </div>
         </div>
         <div class="box-body">
           <div class="chart tab-pane" id="user-chart" style="position: relative; height: 400px;"></div>
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
           <h3 class="box-title">消费量</h3>
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
	                <input class="btn-small" type="button" onclick="getItemDetail(this , 'consume' )" value="确认">
	           	</div>
			
          		<a href="/admin/statistics/showUserList" class="btn btn-box-tool">
          		 	<span class="box-title" style="font-size:16px;">详细</span> <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>
				</a>
           </div>
         </div>
         <div class="box-body">
           <div class="chart tab-pane" id="all_amt" style="position: relative; height: 400px;"></div>
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
  		<div class="box box-info">
         <div class="box-header ui-sortable-handle">
           <i class="fa fa-bar-chart-o"></i>
           <h3 class="box-title">会员年龄段</h3>
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
	                <input class="btn-small" type="button" onclick="getItemDetail(this , 'age' )" value="确认">
	           	</div>
			
           </div>
         </div>
         <div class="box-body">
           <div class="chart tab-pane" id="user_age_seg" style="position: relative; height: 500px;"></div>
         </div>
         
         <div class="overlay" style="display:none">
			<i class="fa fa-refresh fa-spin"></i>
		 </div>
		 
		 <div style="color: #000;left: 40%; margin-left: -15px;margin-top: -15px;position: absolute;top: 40%; display:none">
           	<div class="alert alert-info alert-dismissable">
               <h4><i class="icon fa fa-info"></i> 提示信息!</h4>
               <p class="dis_message"></p>
             </div>
       	 </div>
         
       </div>
  	</div>
  	
  	<div class="col-md-6">
  		<div class="box box-info">
         <div class="box-header ui-sortable-handle">
           <i class="fa fa-bar-chart-o"></i>
           <h3 class="box-title">会员区域分布</h3>
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
	                <input class="btn-small" type="button" onclick="getItemDetail(this , 'map' )" value="确认">
	           	</div>
	           	
				<a href="/admin/statistics/getDistList" class="btn btn-box-tool">
          		 	<span class="box-title" style="font-size:16px;">详细</span> <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>
				</a>
           </div>
         </div>
         <div class="box-body">
           <div class="chart tab-pane" id="user_district" style="position: relative; height: 500px;"></div>
         </div>
         
         <div class="overlay" style="display:none">
			<i class="fa fa-refresh fa-spin"></i>
		 </div>
		 
		 <div style="color: #000;left: 40%; margin-left: -15px;margin-top: -15px;position: absolute;top: 40%; display:none">
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

<script src="/charts/echarts/echarts-all.js"></script>
<script src="/js/admin/statistics/stat_users.js"></script>
<script type="text/javascript">
var statTime = "<?php if( isset( $title ) ) echo $title ?>";
var userXalias 	= <?php if( isset( $xalias ) ) echo $xalias; ?>; //x轴坐标

//----------------------- 用户增长量 折柱图 ---
var allUsers 	= <?php if( isset( $memAdds ) ) echo $memAdds; ?>; //所有会员
var femaleUsers = <?php if( isset( $femaleAdds ) ) echo $femaleAdds; ?>; //女会员
var maleUsers   = <?php if( isset( $maleAdds ) ) echo $maleAdds; ?>;	//男会员
var userChart = echarts.init( document.getElementById('user-chart') , 'macarons' );
userChart.setOption({
	title:{
		text: statTime+'份 用户增长率统计',
		x: 'center',
	},
    tooltip : {
        trigger: 'axis',
    },
    legend: {
        data:['总增长','女会员','男会员'],
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
    calculable : true,  //是否支持拖拽  默认false
    xAxis : [
        {
            type : 'category',
            data :userXalias,
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
            name:'总增长',
            type:'line',
            data:allUsers,
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
            data:femaleUsers,
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
            data:maleUsers,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
        },
    ]
});

//----------------------- 用户消费金额  折柱图 ---
var allAmts = <?php if( isset( $amtAdds ) ) echo $amtAdds; ?>; //总消费走势
var amtChart = echarts.init( document.getElementById('all_amt') , 'macarons' );
amtChart.setOption({
	title:{
		text: statTime+'份 用户总消费金额统计',
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
            data :userXalias,
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
            name:'总增长',
            type:'bar',
            data:allAmts,
        },
    ]
});

//----------------------- 用户会员年龄段  折柱图 ---
var ageXalias 	= <?php if( isset( $agexalias ) ) echo $agexalias; ?>; //x轴坐标
var allMems 	= <?php if( isset( $allmem ) ) echo $allmem; ?>; //所有会员
var allMidlife 	= <?php if( isset( $midlife ) ) echo $midlife; ?>; //中年
var allYouth   	= <?php if( isset( $youth ) ) echo $youth; ?>;	//青年
var allPubertas	= <?php if( isset( $pubertas ) ) echo $pubertas; ?>;//青少年
var ageChart = echarts.init( document.getElementById('user_age_seg') , 'macarons' );
ageChart.setOption({
	title:{
		text: statTime+'份 用户年龄段统计',
		x: 'center',
	},
    tooltip : {
        trigger: 'axis',
    },
    legend: {
        data:['总增长','中年','少年','青少年'],
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
    xAxis:[
        {
            type:'category',
            data:ageXalias,
        }
    ],
    yAxis:[
        {
            type : 'value',
            splitArea : {show : true}
        }
    ],
    series:[
		{
		    name:'总增长',
		    type:'line',
		    data:allMems,
		    markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
		},
        {
            name:'中年',
            type:'line',
            data:allMidlife,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
        },
        {
            name:'少年',
            type:'line',
            data:allYouth,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
        },
        {
            name:'青少年',
            type:'line',
            data:allPubertas,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
        },
    ]
});

//----------------------- 用户区域地图  map---
var myChart = echarts.init( document.getElementById('user_district') , 'macarons' );
var curIndx = 0;
var mapType = [
    'china',
    // 23个省
    '广东', '青海', '四川', '海南', '陕西', 
    '甘肃', '云南', '湖南', '湖北', '黑龙江',
    '贵州', '山东', '江西', '河南', '河北',
    '山西', '安徽', '福建', '浙江', '江苏', 
    '吉林', '辽宁', '台湾',
    // 5个自治区
    '新疆', '广西', '宁夏', '内蒙古', '西藏', 
    // 4个直辖市
    '北京', '天津', '上海', '重庆',
    // 2个特别行政区
    '香港', '澳门'
];
var pMap = <?php if( isset( $pMap ) ) echo $pMap ?>;
var cMap = <?php if( isset( $cMap ) ) echo $cMap ?>;
var max = <?php if( isset( $hMax ) ) echo $hMax; ?>;
var PrOption = {
    title: {
        text : '会员分布省市区域统计图',
        subtext : '点击可切换查看省市分布'
    },
    tooltip : {
        trigger: 'item',
        formatter: '点击进入：{b}'
    },
    legend: {
        orient: 'vertical',
        x:'right',
        data:['会员个数']
    },
    dataRange: {
        min: 0,
        max: max,
        color:['orange','yellow'],
        text:['高','低'],           // 文本，默认为数值文本
        calculable : true
    },
    toolbox: {
        show: true,
        orient : 'vertical',
        x: 'right',
        y: 'center',
        feature : {
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    series : [
	    {
	    	name: '会员个数',
            type: 'map',
            mapType: 'china',
            selectedMode : 'single',
            itemStyle:{
                normal:{label:{show:true}},
                emphasis:{label:{show:true}}
            },
	        data:pMap,
	    }
	]
};
var  CityOption= {
	    title: {
	        text : '会员分布省市区域统计图',
	        subtext : '点击可切换查看省市分布'
	    },
	    tooltip : {
	        trigger: 'item',
	        formatter: '点击进入：{b}'
	    },
	    legend: {
	        orient: 'vertical',
	        x:'right',
	        data:['会员个数']
	    },
	    dataRange: {
	        min: 0,
	        max: max,
	        color:['orange','yellow'],
	        text:['高','低'],           // 文本，默认为数值文本
	        calculable : true
	    },
	    toolbox: {
	        show: true,
	        orient : 'vertical',
	        x: 'right',
	        y: 'center',
	        feature : {
	            restore : {show: true},
	            saveAsImage : {show: true}
	        }
	    },
	    series : [
		    {
		    	name: '会员个数',
	            type: 'map',
	            mapType: 'china',
	            selectedMode : 'single',
	            itemStyle:{
	                normal:{label:{show:true}},
	                emphasis:{label:{show:true}}
	            },
		        data:cMap,
		    }
		]
	};
myChart.setOption( PrOption, true);

var ecConfig = {
		 // 图表类型
       CHART_TYPE_LINE: 'line',
       CHART_TYPE_BAR: 'bar',
       CHART_TYPE_SCATTER: 'scatter',
       CHART_TYPE_PIE: 'pie',
       CHART_TYPE_RADAR: 'radar',
       CHART_TYPE_VENN: 'venn',
       CHART_TYPE_TREEMAP: 'treemap',
       CHART_TYPE_TREE: 'tree',
       CHART_TYPE_MAP: 'map',
       CHART_TYPE_K: 'k',
       CHART_TYPE_ISLAND: 'island',
       CHART_TYPE_FORCE: 'force',
       CHART_TYPE_CHORD: 'chord',
       CHART_TYPE_GAUGE: 'gauge',
       CHART_TYPE_FUNNEL: 'funnel',
       CHART_TYPE_EVENTRIVER: 'eventRiver',
       CHART_TYPE_WORDCLOUD: 'wordCloud',
       CHART_TYPE_HEATMAP: 'heatmap',

       // 组件类型
       COMPONENT_TYPE_TITLE: 'title',
       COMPONENT_TYPE_LEGEND: 'legend',
       COMPONENT_TYPE_DATARANGE: 'dataRange',
       COMPONENT_TYPE_DATAVIEW: 'dataView',
       COMPONENT_TYPE_DATAZOOM: 'dataZoom',
       COMPONENT_TYPE_TOOLBOX: 'toolbox',
       COMPONENT_TYPE_TOOLTIP: 'tooltip',
       COMPONENT_TYPE_GRID: 'grid',
       COMPONENT_TYPE_AXIS: 'axis',
       COMPONENT_TYPE_POLAR: 'polar',
       COMPONENT_TYPE_X_AXIS: 'xAxis',
       COMPONENT_TYPE_Y_AXIS: 'yAxis',
       COMPONENT_TYPE_AXIS_CATEGORY: 'categoryAxis',
       COMPONENT_TYPE_AXIS_VALUE: 'valueAxis',
       COMPONENT_TYPE_TIMELINE: 'timeline',
       COMPONENT_TYPE_ROAMCONTROLLER: 'roamController',

       // 全图默认背景
       backgroundColor: 'rgba(0,0,0,0)',
       
       // 默认色板
       color: ['#ff7f50','#87cefa','#da70d6','#32cd32','#6495ed',
               '#ff69b4','#ba55d3','#cd5c5c','#ffa500','#40e0d0',
               '#1e90ff','#ff6347','#7b68ee','#00fa9a','#ffd700',
               '#6699FF','#ff6666','#3cb371','#b8860b','#30e0e0'],

       markPoint: {
           clickable: true,
           symbol: 'pin',         // 标注类型
           symbolSize: 20,        // 标注大小，半宽（半径）参数，当图形为方向或菱形则总宽度为symbolSize * 2
           // symbolRotate: null, // 标注旋转控制
           large: false,
           effect: {
               show: false,
               loop: true,
               period: 15,             // 运动周期，无单位，值越大越慢
               type: 'scale',          // 可用为 scale | bounce
               scaleSize: 2,           // 放大倍数，以markPoint点size为基准
               bounceDistance: 10     // 跳动距离，单位px
               // color: 'gold',
               // shadowColor: 'rgba(255,215,0,0.8)',
               // shadowBlur: 0          // 炫光模糊
           },
           itemStyle: {
               normal: {
                   // color: 各异，
                   // borderColor: 各异,        // 标注边线颜色，优先于color 
                   borderWidth: 2,             // 标注边线线宽，单位px，默认为1
                   label: {
                       show: true,
                       // 标签文本格式器，同Tooltip.formatter，不支持回调
                       // formatter: null,
                       position: 'inside'      // 可选为'left'|'right'|'top'|'bottom'
                       // textStyle: null      // 默认使用全局文本样式，详见TEXTSTYLE
                   }
               },
               emphasis: {
                   // color: 各异
                   label: {
                       show: true
                       // 标签文本格式器，同Tooltip.formatter，不支持回调
                       // formatter: null,
                       // position: 'inside'  // 'left'|'right'|'top'|'bottom'
                       // textStyle: null     // 默认使用全局文本样式，详见TEXTSTYLE
                   }
               }
           }
       },
       
       markLine: {
           clickable: true,
           // 标线起始和结束的symbol介绍类型，如果都一样，可以直接传string
           symbol: ['circle', 'arrow'],
           // 标线起始和结束的symbol大小，半宽（半径）参数，当图形为方向或菱形则总宽度为symbolSize * 2
           symbolSize: [2, 4],
           // 标线起始和结束的symbol旋转控制
           //symbolRotate: null,
           //smooth: false,
           smoothness: 0.2,    // 平滑度
           precision: 2,
           effect: {
               show: false,
               loop: true,
               period: 15,                     // 运动周期，无单位，值越大越慢
               scaleSize: 2                    // 放大倍数，以markLine线lineWidth为基准
               // color: 'gold',
               // shadowColor: 'rgba(255,215,0,0.8)',
               // shadowBlur: lineWidth * 2    // 炫光模糊，默认等于scaleSize计算所得
           },
           // 边捆绑
           bundling: {
               enable: false,
               // [0, 90]
               maxTurningAngle: 45
           },
           itemStyle: {
               normal: {
                   // color: 各异,               // 标线主色，线色，symbol主色
                   // borderColor: 随color,     // 标线symbol边框颜色，优先于color 
                   borderWidth: 1.5,           // 标线symbol边框线宽，单位px，默认为2
                   label: {
                       show: true,
                       // 标签文本格式器，同Tooltip.formatter，不支持回调
                       // formatter: null,
                       // 可选为 'start'|'end'|'left'|'right'|'top'|'bottom'
                       position: 'end'
                       // textStyle: null      // 默认使用全局文本样式，详见TEXTSTYLE
                   },
                   lineStyle: {
                       // color: 随borderColor, // 主色，线色，优先级高于borderColor和color
                       // width: 随borderWidth, // 优先于borderWidth
                       type: 'dashed'
                       // shadowColor: 'rgba(0,0,0,0)', //默认透明
                       // shadowBlur: 0,
                       // shadowOffsetX: 0,
                       // shadowOffsetY: 0
                   }
               },
               emphasis: {
                   // color: 各异
                   label: {
                       show: false
                       // 标签文本格式器，同Tooltip.formatter，不支持回调
                       // formatter: null,
                       // position: 'inside' // 'left'|'right'|'top'|'bottom'
                       // textStyle: null    // 默认使用全局文本样式，详见TEXTSTYLE
                   },
                   lineStyle: {}
               }
           }
       },

       // 主题，主题
       textStyle: {
           decoration: 'none',
           fontFamily: 'Arial, Verdana, sans-serif',
           fontFamily2: '微软雅黑',    // IE8- 字体模糊并且，不支持不同字体混排，额外指定一份
           fontSize: 12,
           fontStyle: 'normal',
           fontWeight: 'normal'
       },

       EVENT: {
           // -------全局通用
           REFRESH: 'refresh',
           RESTORE: 'restore',
           RESIZE: 'resize',
           CLICK: 'click',
           DBLCLICK: 'dblclick',
           HOVER: 'hover',
           MOUSEOUT: 'mouseout',
           //MOUSEWHEEL: 'mousewheel',
           // -------业务交互逻辑
           DATA_CHANGED: 'dataChanged',
           DATA_ZOOM: 'dataZoom',
           DATA_RANGE: 'dataRange',
           DATA_RANGE_SELECTED: 'dataRangeSelected',
           DATA_RANGE_HOVERLINK: 'dataRangeHoverLink',
           LEGEND_SELECTED: 'legendSelected',
           LEGEND_HOVERLINK: 'legendHoverLink',
           MAP_SELECTED: 'mapSelected',
           PIE_SELECTED: 'pieSelected',
           MAGIC_TYPE_CHANGED: 'magicTypeChanged',
           DATA_VIEW_CHANGED: 'dataViewChanged',
           TIMELINE_CHANGED: 'timelineChanged',
           MAP_ROAM: 'mapRoam',
           FORCE_LAYOUT_END: 'forceLayoutEnd',
           // -------内部通信
           TOOLTIP_HOVER: 'tooltipHover',
           TOOLTIP_IN_GRID: 'tooltipInGrid',
           TOOLTIP_OUT_GRID: 'tooltipOutGrid',
           ROAMCONTROLLER: 'roamController'
       },
       DRAG_ENABLE_TIME: 120,   // 降低图表内元素拖拽敏感度，单位ms，不建议外部干预
       EFFECT_ZLEVEL : 10,       // 特效动画zlevel
       effectBlendAlpha: 0.95,
       // 主题，默认标志图形类型列表
       symbolList: [
         'circle', 'rectangle', 'triangle', 'diamond',
         'emptyCircle', 'emptyRectangle', 'emptyTriangle', 'emptyDiamond'
       ],
       loadingEffect: 'spin',
       loadingText: '数据读取中...',
       noDataEffect: 'bubble',
       noDataText: '暂无数据',
       // noDataLoadingOption: null,
       // 可计算特性配置，孤岛，提示颜色
       calculable: false,                      // 默认关闭可计算特性
       calculableColor: 'rgba(255,165,0,0.6)', // 拖拽提示边框颜色
       calculableHolderColor: '#ccc',          // 可计算占位提示颜色
       nameConnector: ' & ',
       valueConnector: ': ',
       animation: true,                // 过渡动画是否开启
       addDataAnimation: true,         // 动态数据接口是否开启动画效果
       animationThreshold: 2000,       // 动画元素阀值，产生的图形原素超过2000不出动画
       animationDuration: 2000,        // 过渡动画参数：进入
       animationDurationUpdate: 500,   // 过渡动画参数：更新
       animationEasing: 'ExponentialOut'    //BounceOut
};

myChart.on(ecConfig.EVENT.MAP_SELECTED, function (param){
   var len = mapType.length;
   var mt = mapType[curIndx % len];
   if (mt == 'china') {
       // 全国选择时指定到选中的省份
       var selected = param.selected;
       for (var i in selected) {
           if (selected[i]) {
               mt = i;
               while (len--) {
                   if (mapType[len] == mt) {
                       curIndx = len;
                   }
               }
               break;
           }
       }
       
       CityOption.tooltip.formatter = '{b}：{c}';
       CityOption.series[0].mapType = mt;
       myChart.hideLoading();
       myChart.setOption( CityOption, true);
   }
   else 
   {
       curIndx = 0;
       mt = 'china';
       PrOption.tooltip.formatter = '点击进入：{b}';
       PrOption.series[0].mapType = mt;
       myChart.hideLoading();
       myChart.setOption( PrOption, true);
   }
});

</script>
</body>
