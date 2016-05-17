//js 

//查看商品明细
function showCurrentChart( item , id , type )
{
	if( false == id || false == type )
  	{
  		$( '#dis_message' ).html( '参数配置错误,请强制刷新后再试.' );
		$( '#dis_message' ).parent( 'div' ).parent( 'div' ).fadeIn( 1000 );
		setTimeout( function(){
			$( '#dis_message' ).parent( 'div' ).parent( 'div' ).fadeOut( 500 );
		}, 3000 );
	}
	
	$( '#goodsList' ).find( 'div.loading' ).show();
	
	$.get( '/admin/statistics/getItemGood/uid/' + id + '/type/' + type , function( ret ){
		$( '#goodsList' ).find( 'div.loading' ).hide();
		if( 1 != ret.state )
		{
			$( '#goodsList' ).removeClass( 'active' );
			switch( type )
			{
				case 'amt':
					$( '#showSaleChartInfo' ).removeClass( 'active' );
					$( '#showGlanceChartInfo' ).removeClass( 'active' );
					$( '#showCollectChartInfo' ).removeClass( 'active' );
					$( '#showSourceChartInfo' ).removeClass( 'active' );
					
					$( '#showAmtChartInfo' ).addClass( 'active' );
					
					$( '#amt_id' ).val( id );
					var amtChart = echarts.init( document.getElementById('amt_chart') , 'macarons' );
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
					            markPoint : {
					                data : [
					                    {type : 'max', name: '最大值'},
					                    {type : 'min', name: '最小值'}
					                ]
					            },
					        },
					    ]
					});
				break;
				case 'sale':
					$( '#showAmtChartInfo' ).removeClass( 'active' );
					$( '#showGlanceChartInfo' ).removeClass( 'active' );
					$( '#showCollectChartInfo' ).removeClass( 'active' );
					$( '#showSourceChartInfo' ).removeClass( 'active' );
					
					$( '#showSaleChartInfo' ).addClass( 'active' );
					
					$( '#sale_id' ).val( id );
					var saleChart = echarts.init( document.getElementById('sale_chart') , 'macarons' );
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
					            markPoint : {
					                data : [
					                    {type : 'max', name: '最大值'},
					                    {type : 'min', name: '最小值'}
					                ]
					            },
					        },
					    ]
					});
				break;
				case 'glance':
					$( '#showSaleChartInfo' ).removeClass( 'active' );
					$( '#showAmtChartInfo' ).removeClass( 'active' );
					$( '#showCollectChartInfo' ).removeClass( 'active' );
					$( '#showSourceChartInfo' ).removeClass( 'active' );
					
					$( '#showGlanceChartInfo' ).addClass( 'active' );
					
					$( '#glance_id' ).val( id );
					var glanceChart = echarts.init( document.getElementById('glance_chart') , 'macarons' );
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
					            markPoint : {
					                data : [
					                    {type : 'max', name: '最大值'},
					                    {type : 'min', name: '最小值'}
					                ]
					            },
					        },
					    ]
					});
				break;
				case 'collect':
					$( '#showSaleChartInfo' ).removeClass( 'active' );
					$( '#showGlanceChartInfo' ).removeClass( 'active' );
					$( '#showAmtChartInfo' ).removeClass( 'active' );
					$( '#showSourceChartInfo' ).removeClass( 'active' );
					
					$( '#showCollectChartInfo' ).addClass( 'active' );
					
					$( '#collect_id' ).val( id );
					var othersChart = echarts.init( document.getElementById( 'collect_chart') , 'macarons' );
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
					            data:ret.fovourite,
					            markPoint : {
					                data : [
					                    {type : 'max', name: '最大值'},
					                    {type : 'min', name: '最小值'}
					                ]
					            },
					        },
					    ]
					});
				break;
				case 'source':
					$( '#showSaleChartInfo' ).removeClass( 'active' );
					$( '#showGlanceChartInfo' ).removeClass( 'active' );
					$( '#showAmtChartInfo' ).removeClass( 'active' );
					$( '#showCollectChartInfo' ).removeClass( 'active' );
					$( '#showSourceChartInfo' ).addClass( 'active' );
					
					$( '#source_id' ).val( id );
					
					var sourceChart = echarts.init( document.getElementById( 'source_chart') , 'macarons' );
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
					            markPoint : {
					                data : [
					                    {type : 'max', name: '最大值'},
					                ]
					            },
					        },
					        {
					            name:'搜狗',
					            type:'bar',
					            data:ret.sougou,
					            markPoint : {
					                data : [
					                    {type : 'max', name: '最大值'},
					                ]
					            },
					        },
					        {
					            name:'谷歌',
					            type:'bar',
					            data:ret.google,
					            markPoint : {
					                data : [
					                    {type : 'max', name: '最大值'},
					                ]
					            },
					        },
					        {
					            name:'360',
					            type:'bar',
					            data:ret.qihu,
					            markPoint : {
					                data : [
					                    {type : 'max', name: '最大值'},
					                ]
					            },
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
			$( '#show_msg' ).html( ret.msg );
			$( '#show_msg' ).parent( 'div' ).parent( 'div' ).fadeIn( 1000 );
			setTimeout( function(){
				$( '#show_msg' ).parent( 'div' ).parent( 'div' ).fadeOut( 500 );
			}, 3000 );
		}
		
	}, 'json' );
	
}


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
	
	switch( type )
	{
		case 'amt':
			var uid = $( '#amt_id' ).val();
		break;
		case 'sale':
			var uid = $( '#sale_id' ).val();
		break;
		case 'glance':
			var uid = $( '#glance_id' ).val();
		break;
		case 'collect':
			var uid = $( '#collect_id' ).val();
		break;
		case 'source':
			var uid = $( '#source_id' ).val();
		break;
	}
	
	if( false != selTimeStmp && false !== selTimeType )
	{
		$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div.overlay' ).show();
		
		$.get( '/admin/statistics/getItemGood/uid/' + uid +'/type/' + type +'/point/' + selTimeStmp + '/timeType/' + selTimeType , function( ret ){
			$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div.overlay' ).hide();
			if( 1 != ret.state && false != ret.xalias )
			{
				$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div.box-body' ).find( 'canvas' ).remove();//移除之前画布
				switch( type )
				{
					case 'amt':
						var amtChart = echarts.init( document.getElementById('amt_chart') , 'macarons' );
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
						var saleChart = echarts.init( document.getElementById('sale_chart') , 'macarons' );
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
						var glanceChart = echarts.init( document.getElementById('glance_chart') , 'macarons' );
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
						$( '#showSaleChartInfo' ).removeClass( 'active' );
						$( '#showGlanceChartInfo' ).removeClass( 'active' );
						$( '#showAmtChartInfo' ).removeClass( 'active' );
						$( '#showSourceChartInfo' ).removeClass( 'active' );
						
						$( '#showCollectChartInfo' ).addClass( 'active' );
						
						var othersChart = echarts.init( document.getElementById( 'collect_chart') , 'macarons' );
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
						var sourceChart = echarts.init( document.getElementById( 'source_chart') , 'macarons' );
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
				$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div' ).find( 'p.dis_message' ).html( '对不起,  <strong>' + selTimeStmp + '</strong>  暂无统计数据.' );
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
