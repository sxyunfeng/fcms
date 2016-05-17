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
		
		$.get( '/admin/statistics/goodsChartDetail/type/' + type +'/point/' + selTimeStmp + '/timeType/' + selTimeType , function( ret ){
			$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div.overlay' ).hide();
			if( 1 != ret.state )
			{
				switch( type )
				{
					case 'amt':
						var amtChart = echarts.init( document.getElementById('goods-amt') , 'macarons' );
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
						            name:'销售金额',
						            type:'line',
						            data:ret.datas,
						        },
						    ]
						});
					break;
					case 'sale':
						var saleChart = echarts.init( document.getElementById('gooods-sales') , 'macarons' );
						saleChart.setOption({
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
						            name:'销售量',
						            type:'line',
						            data:ret.datas,
						        },
						    ]
						});

					break;
					case 'glance':
						var glanceChart = echarts.init( document.getElementById('goods-glance') , 'macarons' );
						glanceChart.setOption({
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
						            name:'浏览量',
						            type:'line',
						            data:ret.glance,
						        },
						    ]
						});
					break;
					case 'collect':
						var othersChart = echarts.init( document.getElementById( 'goods-collects') , 'macarons' );
						othersChart.setOption({
							title:{
								text: statTime+' 商品收藏、好评率统计图',
								x: 'center',
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
						            name:'收藏量',
						            type:'line',
						            data:ret.collect,
						        },
						        {
						            name:'好评率',
						            type:'line',
						            data:ret.fovourite,
						        },
						    ]
						});
					break;
					case 'source':
						var sourceChart = echarts.init( document.getElementById( 'goods-source') , 'macarons' );
						sourceChart.setOption({
							title:{
								text: ret.title,
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
						            name:'百度',
						            type:'bar',
						            data:ret.baidu,
						        },
						        {
						            name:'搜狗',
						            type:'bar',
						            data:ret.sougou,
						        },
						        {
						            name:'谷歌',
						            type:'bar',
						            data:ret.google,
						        },
						        {
						            name:'360',
						            type:'bar',
						            data:ret.qihu,
						        },
						    ]
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
//	else
//	{
//		$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div' ).find( 'p.dis_message' ).html( '未知错误,获取信息失败.' );
//		$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div' ).find( 'p.dis_message' ).parent( 'div' ).parent( 'div' ).fadeIn( 1000 );
//		setTimeout( function(){
//			$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div' ).find( 'p.dis_message' ).parent( 'div' ).parent( 'div' ).fadeOut( 500 );
//		}, 3000 );
//	}
	
}
