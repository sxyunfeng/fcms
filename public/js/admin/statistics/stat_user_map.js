function getCityList( item, pid )
{
	if( false == pid  )
	{
		$( '#dis_message' ).html( '参数配置错误,请强制刷新后再试.' );
		$( '#dis_message' ).parent( 'div' ).parent( 'div' ).fadeIn( 1000 );
		setTimeout( function(){
			$( '#dis_message' ).parent( 'div' ).parent( 'div' ).fadeOut( 500 );
		}, 3000 );
	}
	
	var selTimeStmp = $.trim( $( '.input-group' ).find( 'input[type="text"]' ).val() );
	var selTimeType = $.trim( $( '.input-group' ).find( 'select' ).val() );
	if( false != selTimeStmp || false != selTimeType )
		var setUrl = '/admin/statistics/getCityList/pid/' + pid + '/point/' + selTimeStmp + '/timeType/' + selTimeType;
	else
		var setUrl = '/admin/statistics/getCityList/pid/' + pid;

	$.get(  setUrl , function( ret ){
		 if( 1 != ret.state )
		 {
			var iLen = count( ret.data );
			var tableList = '';
			for( var i=0; i<iLen; i++ )
			{
				tableList += '<tr><td>'+parseInt( i+1 )+'</td><td style="text-align:center">' + ret.data[i]['city'] + '</td><td style="text-align:center">' + ret.data[i]['num'] + '</td><td>'+ ret.data[i]['time']+'</td></tr>' ;
			}
			
			if( 1 != ret.type )
				var title = ret.selTime + ' ' + $.trim( $(item).find( 'td.pname' ).html() +'会员分布明细' );
			else
				var title =  $.trim( $(item).find( 'td.pname' ).html() +'会员分布明细' )
			$( '#myModalLabel' ).html(  title );
			$( '#cityList' ).html( tableList );	
			$( '#myModal' ).modal( 'show' );
		 }
		 else
		 {
			 $( '#dis_message' ).html( ret.msg );
				$( '#dis_message' ).parent( 'div' ).parent( 'div' ).fadeIn( 1000 );
				setTimeout( function(){
					$( '#dis_message' ).parent( 'div' ).parent( 'div' ).fadeOut( 500 );
				}, 3000 );
		 }
	}, 'json');
}

function count(o){
    var t = typeof o;
    if(t == 'string'){
            return o.length;
    }else if(t == 'object'){
            var n = 0;
            for(var i in o){
                    n++;
            }
            return n;
    }
    return false;
}; 

//选择   年 月 日 时 段  日期插件
function showDatePicker( item )
{
	$( item ).find( 'i' ).addClass( 'fa-2x' );
	$( item ).prev( 'div.input-group' ).show();
	
	//清除input / select 框
	//$(item).next( 'div.input-group' ).find( 'input[type="text"]' ).val( '' );
	//$(item).next( 'div.input-group' ).find( 'select' ).val( 0 );

	$( item ).prev( 'div' ).find( 'div.input-group>input[type="text"]' ).datetimepicker({
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

function getDetails( item )
{
	$( item ).parent( 'div.input-group' ).siblings( 'span' ).find( 'i' ).removeClass( 'fa-2x' );
	$( item ).parent( 'div.input-group' ).hide();
	
	var selTimeStmp = $.trim( $( item ).parent().find( 'input[type="text"]' ).val() );
	var selTimeType = $.trim( $( item ).parent().find( 'select' ).val() );
	if( false != selTimeStmp && false !== selTimeType )
	{
		$( '#adsList .loading' ).show();
		$.get( '/admin/statistics/getListMaps/point/' + selTimeStmp + '/timeType/' + selTimeType , function( ret ){
			$( '#adsList .loading' ).hide();
			if( 1 != ret.state )
			{
				$( '#provinceList tr' ).remove();
				var iLen = ret.data.length;
				var strAppend = '';
				for( var i =0; i<iLen; i++)
				{
					if( false != ret.data[i].son )
					{
						if( ret.data[i].num > 30000 )
							var strTr = '<tr onclick="getCityList( this , '+ ret.data[i].pid +' ); " class="danger" style="cursor:pointer">';
						else
							var strTr = '<tr onclick="getCityList( this , '+ ret.data[i].pid +' ); " style="cursor:pointer">';
					}
					else
						var strTr = '<tr>';
					
					strAppend += strTr + 
								 '<td style="text-align:center">'+ parseInt(i+1) +'</td>' +
								 '<td class="pname" style="text-align:center">'+ ret.data[i].pname +'</td>' +
								 '<td style="text-align:center">'+ ret.data[i].num +'</td>' +
								 '<td style="text-align:center"></td>' +
								 '</tr>';
				}
				
				if( 1 != ret.type )
					var title = ret.selTime + ' 省市会员分布一览表';
				else
					var title = '省市会员分布一览表';
				
				$( '#mapTitle' ).html( title );
				$( 'tbody#provinceList' ).append( strAppend );
			}
			else
			{
				$( '#dis_message' ).html( ret.msg );
				$( '#dis_message' ).parent( 'div' ).parent( 'div' ).fadeIn( 1000 );
				setTimeout( function(){
					$( '#dis_message' ).parent( 'div' ).parent( 'div' ).fadeOut( 500 );
				}, 3000 );
			}
		}, 'json');
	}
}