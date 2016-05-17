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
      <li role="presentation" class="active"><a href="#goodsCenter">商品统计中心</a></li>
  </ul>
  <div class="row" style="margin-top:10px;">
 	<div class="col-lg-3 col-xs-6">
  		<div class="small-box bg-green">
             <div class="inner">
               <h3>{{goods}}</h3>
               <p>总商品数</p>
             </div>
             <div class="icon">
                  <i class="ion-podium"></i>
             </div>
             <a class="small-box-footer" href="/admin/statistics/goodsList">更多<i class="fa fa-arrow-circle-right"></i></a>
       </div>
    </div>
     
     <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
            <div class="inner">
               <h3>{{shops}}</h3>
              <p>入住商家</p>
            </div>
            <div class="icon">
                 <i class="fa fa-truck"></i>
            </div>
            <a class="small-box-footer" href="/admin/statistics/goodsList">更多 <i class="fa fa-arrow-circle-right"></i></a>
      </div>  
  	</div>
     
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{lineup}}</h3>
              <p>上线商品数</p>
            </div>
            <div class="icon">
                 <i class="ion-ios-cart"></i>
            </div>
            <a class="small-box-footer" href="/admin/statistics/goodsList">更多 <i class="fa fa-arrow-circle-right"></i></a>
      </div>  
  	</div>
   
   	<div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
            <div class="inner">
               <h3>{{linedown}}</h3>
              <p>下架商品数</p>
            </div>
            <div class="icon">
                 <i class="ion-bookmark"></i>
            </div>
            <a class="small-box-footer" href="/admin/statistics/goodsList">更多 <i class="fa fa-arrow-circle-right"></i></a>
      </div>  
  	</div>
  	
  </div>
  
  <section class="content">
  	<div class="col-md-6">
		<div class="box box-success">
         <div class="box-header ui-sortable-handle">
           <i class="fa fa-line-chart normals"></i>
           <h3 class="box-title">商品销售总金额</h3>
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
	           	<a href="/admin/statistics/goodsList" class="btn btn-box-tool">
          		 	<span class="box-title" style="font-size:16px;">详细</span> <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>
				</a>
           </div>
         </div>
         <div class="box-body">
           <div class="chart tab-pane" id="goods-amt" style="position: relative; height: 400px;"></div>
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
           <h3 class="box-title">商品销售总量</h3>
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
	                <input class="btn-small" type="button" onclick="getItemDetail(this , 'sale' )" value="确认">
	           	</div>
			
          		<a href="/admin/statistics/goodsList" class="btn btn-box-tool">
          		 	<span class="box-title" style="font-size:16px;">详细</span> <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>
				</a>
           </div>
         </div>
         <div class="box-body">
           <div class="chart tab-pane" id="gooods-sales" style="position: relative; height: 400px;"></div>
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
  		<div class="box box-warning">
         <div class="box-header ui-sortable-handle">
           <i class="fa fa-bar-chart"></i>
           <h3 class="box-title">商品浏览总量</h3>
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
	                <input class="btn-small" type="button" onclick="getItemDetail(this , 'glance' )" value="确认">
	           	</div>
			
          		<a href="/admin/statistics/goodsList" class="btn btn-box-tool">
          		 	<span class="box-title" style="font-size:16px;">详细</span> <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>
				</a>
           </div>
         </div>
         <div class="box-body">
           <div class="chart tab-pane" id="goods-glance" style="position: relative; height: 400px;"></div>
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
  		<div class="box box-default">
         <div class="box-header ui-sortable-handle">
           <i class="fa fa-star-o"></i>
           <h3 class="box-title">商品收藏和好评总量</h3>
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
	                <input class="btn-small" type="button" onclick="getItemDetail(this , 'collect' )" value="确认">
	           	</div>
			
          		<a href="/admin/statistics/goodsList" class="btn btn-box-tool">
          		 	<span class="box-title" style="font-size:16px;">详细</span> <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>
				</a>
           </div>
         </div>
         <div class="box-body">
           <div class="chart tab-pane" id="goods-collects" style="position: relative; height: 400px;"></div>
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
  	  	
  	<div class="col-md-12">
  		<div class="box box-info">
         <div class="box-header ui-sortable-handle">
           <i class="fa fa-bar-chart-o"></i>
           <h3 class="box-title">到达来源统计</h3>
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
	                <input class="btn-small" type="button" onclick="getItemDetail(this , 'source' )" value="确认">
	           	</div>
				<a href="/admin/statistics/goodsList" class="btn btn-box-tool">
          		 	<span class="box-title" style="font-size:16px;">详细</span> <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>
				</a>
           </div>
         </div>
         <div class="box-body">
           <div class="chart tab-pane" id="goods-source" style="position: relative; height: 400px;"></div>
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

<script src="/charts/Echarts/echarts-all.js"></script>
<script src="/js/admin/statistics/stat_goods.js"></script>
<script type="text/javascript">
var statTime = "<?php if( isset( $title ) ) echo $title ?>";
var goodsXalias = <?php if( isset( $xalias ) ) echo $xalias; ?>;
//金额
var goodsAmt = <?php if( isset( $amtadds ) ) echo $amtadds; ?>;
var amtChart = echarts.init( document.getElementById('goods-amt') , 'macarons' );
amtChart.setOption({
	title:{
		text: statTime+' 商品销售总金额统计',
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
            data :goodsXalias,
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
            name:'销售金额',
            type:'line',
            data:goodsAmt,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
        },
    ]
});

//销量
var goodsSale = <?php if( isset( $saleadds ) ) echo $saleadds; ?>;
var saleChart = echarts.init( document.getElementById('gooods-sales') , 'macarons' );
saleChart.setOption({
	title:{
		text: statTime+' 商品销售总量统计',
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
            data :goodsXalias,
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
            name:'销售量',
            type:'line',
            data:goodsSale,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
        },
    ]
});

//浏览量  收藏量  好评率
var goodsGlance = <?php if( isset( $glance ) ) echo $glance; ?>;
var goodsCollect = <?php if( isset( $collect ) ) echo $collect; ?>;
var goodsFavourite = <?php if( isset( $favourite ) ) echo $favourite; ?>;

var glanceChart = echarts.init( document.getElementById('goods-glance') , 'macarons' );
glanceChart.setOption({
	title:{
		text: statTime+' 商品浏览量统计',
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
            data :goodsXalias,
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
            name:'浏览量',
            type:'line',
            data:goodsGlance,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
        },
    ]
});

var othersChart = echarts.init( document.getElementById( 'goods-collects') , 'macarons' );
othersChart.setOption({
	title:{
		text: statTime+' 商品收藏量、好评率统计',
		x: 'left',
	},
    tooltip : {
        trigger: 'axis',
    },
    legend: {
        data:['收藏量','好评率'],
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
            data :goodsXalias,
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
            name:'收藏量',
            type:'line',
            data:goodsCollect,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
        },
        {
            name:'好评率',
            type:'line',
            data:goodsFavourite,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },
        },
    ]
});

//到达来源
var fBaidu	=  <?php if( isset( $baidu ) ) echo $baidu; ?>;
var fSougou = <?php if( isset( $sougou ) ) echo $sougou; ?>;
var fGoogle = <?php if( isset( $google ) ) echo $google; ?>;
var fQihu   = <?php if( isset( $qihu ) ) echo $qihu; ?>;

var sourceChart = echarts.init( document.getElementById( 'goods-source') , 'macarons' );
sourceChart.setOption({
	title:{
		text: statTime+' 商品到达来源统计图',
		x: 'center',
	},
    tooltip : {
        trigger: 'axis',
    },
    legend: {
        data:['百度','搜狗', '谷歌', '360'],
        x: 'left'
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
            data :goodsXalias,
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
            name:'百度',
            type:'bar',
            data:fBaidu,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                ]
            },
        },
        {
            name:'搜狗',
            type:'bar',
            data:fSougou,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                ]
            },
        },
        {
            name:'谷歌',
            type:'bar',
            data:fGoogle,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                ]
            },
        },
        {
            name:'360',
            type:'bar',
            data:fQihu,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                ]
            },
        },
    ]
});

</script>
</body>
