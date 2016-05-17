//js 
$('#tabs a').click(function (e) {
  if( $( this ).parent().index() === 0 )
      return;
  e.preventDefault();
  $(this).tab( 'show' );
});

//用户消费金额
function showAmtChart( item, id )
{
  	if( false == id )
  	{
  		$( '#dis_message' ).html( '参数配置错误,请强制刷新后再试.' );
		$( '#dis_message' ).parent( 'div' ).parent( 'div' ).fadeIn( 1000 );
		setTimeout( function(){
			$( '#dis_message' ).parent( 'div' ).parent( 'div' ).fadeOut( 500 );
		}, 3000 );
	}
	
	$( '#userList' ).find( 'div.loading' ).show();
	$.get( '/admin/statistics/getItemAmt/uid/' + id, function( ret ){
		$( '#userList' ).find( 'div.loading' ).hide();
		if( 1 != ret.state )
		{
			$( '#amtid' ).val( id );
			
			$( '#userList' ).removeClass( 'active' );
			$( '#showOrderChartInfo' ).removeClass( 'active' );
			$( '#showAmtChartInfo' ).addClass( 'active' );
			
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
			            name:'总增长',
			            type:'line',
			            data:ret.amtAdds,
			            markPoint : {
			                data : [
			                    {type : 'max', name: '最大值'},
			                    {type : 'min', name: '最小值'}
			                ]
			            },
			        },
			    ]
			});
		}
		else
		{
			$( '#show_msg' ).html( ret.msg );
			$( '#show_msg' ).parent( 'div' ).parent( 'div' ).fadeIn( 1000 );
			setTimeout( function(){
				$( '#show_msg' ).parent( 'div' ).parent( 'div' ).fadeOut( 500 );
			}, 3000 );
		}
	}, 'json');
    
}

//用户订单量
function showOrderChart( item , id )
{
	if( false == id )
  	{
  		$( '#dis_message' ).html( '参数配置错误,请强制刷新后再试.' );
		$( '#dis_message' ).parent( 'div' ).parent( 'div' ).fadeIn( 1000 );
		setTimeout( function(){
			$( '#dis_message' ).parent( 'div' ).parent( 'div' ).fadeOut( 500 );
		}, 3000 );
	}
	
	$( '#userList' ).find( 'div.loading' ).show();
	$.get( '/admin/statistics/getItemOrder/uid/' + id, function( ret ){
		$( '#userList' ).find( 'div.loading' ).hide();
		if( 1 != ret.state )
		{
			$( '#orderid' ).val( id );
			
			$( '#userList' ).removeClass( 'active' );
			$( '#showAmtChartInfo' ).removeClass( 'active' );
			$( '#showOrderChartInfo' ).addClass( 'active' );
			
			var orderChart = echarts.init( document.getElementById('order_chart') , 'macarons' );
			orderChart.setOption({
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
			            name:'订单量',
			            type:'line',
			            data:ret.orderAdds,
			            markPoint : {
			                data : [
			                    {type : 'max', name: '最大值'},
			                    {type : 'min', name: '最小值'}
			                ]
			            },
			        },
			    ]
			});
		}
		else
		{
			$( '#show_msg' ).html( ret.msg );
			$( '#show_msg' ).parent( 'div' ).parent( 'div' ).fadeIn( 1000 );
			setTimeout( function(){
				$( '#show_msg' ).parent( 'div' ).parent( 'div' ).fadeOut( 500 );
			}, 3000 );
		}
	}, 'json');
	
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

	var selTimeStmp = $.trim( $( item ).parent().find( 'input[type="text"]' ).val() );//时间戳
	var selTimeType = $.trim( $( item ).parent().find( 'select' ).val() );//选择查看的类型
	if( false != selTimeStmp && false !== selTimeType )
	{
		$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div.overlay' ).show();
		
		switch( type )
		{
			case 'order':
				var orderid = $( '#orderid' ).val();
				var setUrl = '/admin/statistics/getItemOrder/uid/' + orderid + '/point/' + selTimeStmp + '/timeType/' + selTimeType;
			break;
			case 'amt':
				var amtid = $( '#amtid' ).val();
				var setUrl = '/admin/statistics/getItemAmt/uid/' + amtid +'/point/' + selTimeStmp + '/timeType/' + selTimeType;
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
						case 'order':
							var orderChart = echarts.init( document.getElementById('order_chart') , 'macarons' );
							orderChart.setOption({
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
							            name:'订单量',
							            type:'line',
							            data:ret.orderAdds,
							        },
							    ]
							});
						break;
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
							            name:'总增长',
							            type:'line',
							            data:ret.amtAdds,
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
