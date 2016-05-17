//主配置项 js

$(function(){
	
 	$( 'input[name="column"]' ).each(function(){
 		if( iColumnIndex ==  $(this).val() )
 			$(this).attr( 'checked' , true ).siblings().removeAttr( 'checked' );
 	});
 	$( 'input[name="list"]' ).each(function(){
 		if( iColumnList ==  $(this).val() )
 			$(this).attr( 'checked' , true ).siblings().removeAttr( 'checked' );
 	});
 	$( 'input[name="detail"]' ).each(function(){
 		if( iColumnDetail ==  $(this).val() )
 			$(this).attr( 'checked' , true ).siblings().removeAttr( 'checked' );
 	});
 	//点击设置 checked 属性
 	$( 'input[name="column"]' ).click(function(){
 		$(this).attr( 'checked' , true ).siblings().removeAttr( 'checked' );
 	});
 	$( 'input[name="list"]' ).click(function(){
 		$(this).attr( 'checked' , true ).siblings().removeAttr( 'checked' );
 	});
 	$( 'input[name="detail"]' ).click(function(){
 		$(this).attr( 'checked' , true ).siblings().removeAttr( 'checked' );
 	});
	
	$( 'i.cacheDelete' ).click(function(){
		var optid = $( this ).parent().parent( 'td' ).attr( 'data-id' );
		if( false == optid )
		{
			$( '#dis_message' ).html( '参数配置错误,请刷新后再试...' );
			$( '#dis_message' ).parent().parent().addClass( 'alert-danger' ).removeClass( 'alert-success' );
			$( '#dis_message' ).parent().parent().fadeIn( 500 );
			setTimeout( function(){
				$( '#dis_message' ).parent().parent().fadeOut( 1000 );
			}, '3000' );
		}

	});
	
	
	/*-------------- 基本配置信息 ------------------*/
	$( '#btnBase' ).click(function(){
		
		var objParams = new Object();
		objParams.ctime = $( '#columnTime' ).val();
		objParams.ltime	= $( '#listTime' ).val();
		objParams.dtime = $( '#detailTime' ).val();
		objParams.sign	= $( 'input[name="time_id"]' ).val();
		objParams.type	= 1;
		
		$.post( '/admin/staticcache/save' , objParams , function( ret ){
			if( 1 != ret.state )
			{
				$( '#dis_message' ).html( ret.msg );
				$( '#dis_message' ).parent().parent().addClass( 'alert-success' ).removeClass( 'alert-danger' );
				$( '#dis_message' ).parent().parent().fadeIn( 500 );
				setTimeout( function(){
					$( '#dis_message' ).parent().parent().fadeOut( 1000 );
				}, '3000' );
				
				$( '#columnTime' ).val( ret.optdata.index );
				$( '#listTime' ).val( ret.optdata.list );
				$( '#detailTime' ).val( ret.optdata.detail );
				$( 'input[name="time_id"]' ).val( ret.optdata.id );
			}
			else
			{
				$( '#dis_message' ).html( ret.msg );
				$( '#dis_message' ).parent().parent().addClass( 'alert-danger' ).removeClass( 'alert-success' );
				$( '#dis_message' ).parent().parent().fadeIn( 500 );
				setTimeout( function(){
					$( '#dis_message' ).parent().parent().fadeOut( 1000 );
				}, '3000' );
			}
		}, 'json' );
		
	});
	
	/*------------------ 驱动配置  --------------------*/
	$( '#btnDriver' ).click(function(){
		
		var objParams = new Object();
		$( 'input[name="column"]' ).each(function(){
			if( "checked" == $(this).attr( 'checked' ) )
				objParams.cdriver = $(this).val();
		});
		$( 'input[name="list"]' ).each(function(){
			if( "checked" == $(this).attr( 'checked' ) )
				objParams.ldriver = $(this).val();
		});
		$( 'input[name="detail"]' ).each(function(){
			if( "checked" == $(this).attr( 'checked' ) )
				objParams.ddriver = $(this).val();
		});
		objParams.sign	= $( 'input[name="driver_id"]' ).val();
		objParams.type	= 2;
		
		$.post( '/admin/staticcache/save' , objParams , function( ret ){
			if( 1 != ret.state )
			{
				$( '#dis_message' ).html( ret.msg );
				$( '#dis_message' ).parent().parent().addClass( 'alert-success' ).removeClass( 'alert-danger' );
				$( '#dis_message' ).parent().parent().fadeIn( 500 );
				setTimeout( function(){
					$( '#dis_message' ).parent().parent().fadeOut( 1000 );
				}, '3000' );
				
				$( 'input[name="column"]' ).val( ret.optdata.index );
				$( 'input[name="list"]' ).val( ret.optdata.list );
				$( 'input[name="detail"]' ).val( ret.optdata.detail );
				$( 'input[name="driver_id"]' ).val( ret.optdata.id );
			}
			else
			{
				$( '#dis_message' ).html( ret.msg );
				$( '#dis_message' ).parent().parent().addClass( 'alert-danger' ).removeClass( 'alert-success' );
				$( '#dis_message' ).parent().parent().fadeIn( 500 );
				setTimeout( function(){
					$( '#dis_message' ).parent().parent().fadeOut( 1000 );
				}, '3000' );
			}
		}, 'json' );
		
	});
	
	/*---------------------- 存储配置 -----------------------*/
	$( '#btnStorage' ).click(function(){
		
		var objParams = new Object();
		objParams.cstorage = $( '#cStorage' ).val();
		objParams.lstorage	= $( '#lStorage' ).val();
		objParams.dstorage = $( '#dStorage' ).val();
		objParams.sign	= $( 'input[name="storage_id"]' ).val();
		objParams.type	= 3;
		
		$.post( '/admin/staticcache/save' , objParams , function( ret ){
			if( 1 != ret.state )
			{
				$( '#dis_message' ).html( ret.msg );
				$( '#dis_message' ).parent().parent().addClass( 'alert-success' ).removeClass( 'alert-danger' );
				$( '#dis_message' ).parent().parent().fadeIn( 500 );
				setTimeout( function(){
					$( '#dis_message' ).parent().parent().fadeOut( 1000 );
				}, '3000' );
				
				$( '#columnTime' ).val( ret.optdata.index );
				$( '#listTime' ).val( ret.optdata.list );
				$( '#detailTime' ).val( ret.optdata.detail );
				$( 'input[name="storage_id"]' ).val( ret.optdata.id );
			}
			else
			{
				$( '#dis_message' ).html( ret.msg );
				$( '#dis_message' ).parent().parent().addClass( 'alert-danger' ).removeClass( 'alert-success' );
				$( '#dis_message' ).parent().parent().fadeIn( 500 );
				setTimeout( function(){
					$( '#dis_message' ).parent().parent().fadeOut( 1000 );
				}, '3000' );
			}
		}, 'json' );
	});
});