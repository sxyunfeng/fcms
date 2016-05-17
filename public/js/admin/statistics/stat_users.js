//js

//选择   年 月 日 时 段  日期插件
function showDatePicker( item )
{
	$( item ).parent().find( 'a' ).fadeOut();
	$( item ).find( 'i' ).addClass( 'fa-2x' );
	$( item ).next( 'div.input-group' ).show();
	
	//清除input / select 框
	//$(item).next( 'div.input-group' ).find( 'input[type="text"]' ).val( '' );
	//$(item).next( 'div.input-group' ).find( 'select' ).val( 0 );

	$( item ).parent( 'div' ).find( 'div.input-group>input[type="text"]' ).datetimepicker({
		language: 'zh-CN',
 	    autoclose: true,
 	    todayBtn: true,
 	    pickerPosition: "bottom-right",
	 	minView:'year',
	 	startView:3,
 	    format: 'yyyy-mm',
 	   	fontAwesome:true,
	});

}

//改变时间插件的格式化方式
function changeFormatType( item )
{
	var formatType = $( item ).val();
	if( false !== formatType )
	{
		switch( parseInt( formatType ) )
		{
			case 1://年
			case 2://月
				var options = {
					language: 'zh-CN',
					autoclose: true,
			 	    todayBtn: true,
			 	    pickerPosition: "bottom-right",
			 	    minuteStep: 5,
				 	startView:4,
			 	    minView:'decade',
			 	    format: 'yyyy',
			 	   	fontAwesome:true,
				};
			break;
			case 3://时 
			case 4://段
				var options = {
					language: 'zh-CN',
					autoclose: true,
			 	    todayBtn: true,
			 	    pickerPosition: "bottom-right",
			 	    minuteStep: 5,
				 	startView:2,
				 	minView:'month',
			 	    format: 'yyyy-mm-dd',
			 	    fontAwesome:true,
				};
			break;
			case 0://天
			default:
				var options = {
					language: 'zh-CN',
			 	    autoclose: true,
			 	    todayBtn: true,
			 	    pickerPosition: "bottom-right",
			 	    minuteStep: 5,
				 	startView:3,
				 	minView:'year',
			 	    format: 'yyyy-mm',
			 	    fontAwesome:true,
				};
			break;
		}
		$( item ).prev( 'input[type="text"]' ).datetimepicker('remove');
		
		$( item ).prev( 'input[type="text"]' ).datetimepicker( options );
	}
}

//选择 年 月 日 时 段 进行展示数据
function getItemDetail( item, type )
{
	$( item ).parent().find( 'a' ).fadeIn();
	$( item ).parent( 'div.input-group' ).siblings( 'span' ).find( 'i' ).removeClass( 'fa-2x' );
	$( item ).parent( 'div.input-group' ).next( 'a' ).show();

	$( item ).parent( 'div.input-group' ).hide();

	var selTimeStmp = $.trim( $( item ).parent().find( 'input[type="text"]' ).val() );
	var selTimeType = $.trim( $( item ).parent().find( 'select' ).val() );
	if( false != selTimeStmp && false !== selTimeType )
	{
		$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div.overlay' ).show();
		
		switch( type )
		{
			case 'user':
				var setUrl = '/admin/statistics/getUserDetail/point/' + selTimeStmp + '/timeType/' + selTimeType;
			break;
			case 'consume':
				var setUrl = '/admin/statistics/getAmtDetail/point/' + selTimeStmp + '/timeType/' + selTimeType;
			break;
			case 'age':
				var setUrl = '/admin/statistics/getAgeDetail/point/' + selTimeStmp + '/timeType/' + selTimeType;
			break;
			case 'pit':
				var setUrl = '/admin/statistics/getPitDetail/point/' + selTimeStmp + '/timeType/' + selTimeType;
			break;
			case 'map':
				var setUrl = '/admin/statistics/getDetailMap/point/' + selTimeStmp + '/timeType/' + selTimeType;
			break;
			default:
			break;
		}
		
		if( false != setUrl )
		{
			$.get( setUrl , function( ret ){
				$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div.overlay' ).hide();
				if( 1 != ret.state )
				{
					$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div.box-body' ).find( 'canvas' ).remove();//移除之前画布
					switch( type )
					{
						case 'user':
							var userChart = echarts.init( document.getElementById('user-chart') , 'macarons' );
							userChart.setOption({
								title:{
									text: ret.title,
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
							        orient:'vertical',
							        y:'center',
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
							            data :ret.xalias,
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
							            data:ret.memAdds,
							        },
							        {
							            name:'女会员',
							            type:'line',
							            data:ret.femaleAdds,
							        },
							        {
							            name:'男会员',
							            type:'line',
							            data:ret.maleAdds,
							        },
							    ]
							});
						break;
						case 'consume':
							var amtChart = echarts.init( document.getElementById('all_amt') , 'macarons' );
							amtChart.setOption({
								title:{
									text: ret.title,
									x: 'center',
								},
							    tooltip : {
							        trigger: 'axis',
							    },
							    toolbox: {
							        show : true,
							        orient:'vertical',
							        y:'center',
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
							            data :ret.xalias,
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
							            data:ret.amtAdds,
							        },
							    ]
							});
						break;
						case 'age':
							var ageChart = echarts.init( document.getElementById('user_age_seg') , 'macarons' );
							ageChart.setOption({
								title:{
									text: ret.title,
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
							        orient:'vertical',
							        y:'center',
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
							            data:ret.agexalias,
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
									    data:ret.allmem,
									},
							        {
							            name:'中年',
							            type:'line',
							            data:ret.midlife,
							        },
							        {
							            name:'少年',
							            type:'line',
							            data:ret.youth,
							        },
							        {
							            name:'青少年',
							            type:'line',
							            data:ret.pubertas,
							        },
							    ]
							});
						break;
						case 'pit':
							$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div.box-body' ).html( '<canvas class="chart tab-pane" id="user_district" style="position: relative; height: 300px;"></canvas>' );
							
							var areaDoughnutChart = $("#user_district").get(0).getContext("2d");
							var areaChart = new Chart( areaDoughnutChart );
							areaChart.Doughnut( ret.data, doughnutChartOptions );
						break;
						case 'map':
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
						
						PrOption.title.text = ret.selTime+' 会员分布省市区域统计图';
						PrOption.dataRange.max = ret.max;
						PrOption.series[0].data = ret.province?ret.province:0;
						
						CityOption.title.text = ret.selTime +' 会员分布省市区域统计图'; 
						CityOption.dataRange.max = ret.max;
						CityOption.series[0].data = ret.city?ret.city:0;
						
						myChart.setOption( PrOption, true);
						
						myChart.on(ecConfig.EVENT.MAP_SELECTED, function (param){
							   var len = mapType.length;
							   var mt = mapType[curIndx % len];
							   if (mt == 'china') {
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
						break;
						default:
						break;
					}
				}
				else
				{ 
					$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div' ).find( 'p.dis_message' ).html( ret.msg );
					$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div' ).find( 'p.dis_message' ).parent( 'div' ).parent( 'div' ).fadeIn( 1000 );
					setTimeout( function(){
						$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div' ).find( 'p.dis_message' ).parent( 'div' ).parent( 'div' ).fadeOut( 500 );
					}, 3000 );
				}
			}, 'json' );
		}
		
	}
//	else
//	{
//		$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div' ).find( 'p.dis_message' ).html( '未知错误,获取信息失败.' );
//		$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div' ).find( 'p.dis_message' ).parent( 'div' ).parent( 'div' ).fadeIn( 1000 );
//		setTimeout( function(){
//			$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div' ).find( 'p.dis_message' ).parent( 'div' ).parent( 'div' ).fadeOut( 500 );
//		}, 3000 );
//	}
	
}

