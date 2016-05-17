//js 

$('#tabs a').click(function (e) {
  if( $( this ).parent().index() === 0 )
      return;
  e.preventDefault();
  $(this).tab( 'show' );
});

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
	if( false != selTimeStmp && false !== selTimeType && false != type )
	{
		$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div.overlay' ).show();
		
		$.get( '/admin/statistics/getAdsPoint/point/' + selTimeStmp + '/timeType/' + selTimeType + '/type/' + type , function( ret ){
			$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div.overlay' ).hide();
			if( 1 != ret.state )
			{
				$( item ).parent( 'div' ).parent( 'div' ).parent( 'div' ).siblings( 'div.box-body' ).find( 'canvas' ).remove();//移除之前画布
				switch( type )
				{
					case 'all':
						var adClkChart = echarts.init( document.getElementById('adsclk-chart') , 'macarons' );
						adClkChart.setOption({
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
						            name:'点击次数',
						            type:'line',
						            data:ret.click,
						        },
						    ]
						});
						
					break;
					case 'gender':
						var clkCateChart = echarts.init( document.getElementById( 'gender-chart') , 'macarons' );
						clkCateChart.setOption({
							title:{
								text: ret.title,
								x: 'center',
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
						            name:'总人数',
						            type:'line',
						            data:ret.mems,
						        },
						        {
						            name:'女会员',
						            type:'line',
						            data:ret.female,
						        },
						        {
						            name:'男会员',
						            type:'line',
						            data: ret.male,
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
