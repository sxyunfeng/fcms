/**
 * 
 */
var n = 0;

function showPercentage()
{
	$.get( '/install/index/showPercentage', function( res ){
		$( '#self_percentage' ).html( res );
		if( res == '100%' || n == 2 ){
			$( '#self_percentage' ).html( "100%&nbsp;&nbsp;<span class='glyphicon glyphicon-ok' style='color:green;'>" );
		}
	}, 'json' );
}

function startInstall()
{
	//得到是否添加了示例信息的数据库文件类型
	var sqlId = ( ( true === document.getElementById( "exampleData" ).checked ) ? 1 : 0 );
	//为n赋初值
	!n && ( n = 1 );
	//开始安装后禁止再点击开始安装和上一步，并出现"安装中，请稍候"和等待图片
	$( '#self_waiting' ).html( '正在配置中，请稍候' );
	$( '#self_waiting_img' ).css( 'display', 'block' );
	$( '.self_start' ).attr( 'disabled', 'disabled');
	$( '.self_forward' ).attr( 'disabled', 'disabled');
	$( '#self_step1' ).html( "第一步，导入数据库信息&nbsp;&nbsp;" );
	
	var int = setInterval( function(){
		if( n == 1 ){
			showPercentage();
		}
		if( n && n != 0 && n != 1 ){
			window.clearInterval( int );
			$( '#self_percentage' ).html( "100%&nbsp;&nbsp;<span class='glyphicon glyphicon-ok' style='color:green;'>" );
		}
	}, 1000 ); 
	
	$.ajax( {
		type:'GET',
		url: '/install/index/installStep/step/' + n + '/sqlId/' + sqlId,
		timeout: 0,
		dataType: 'json',
		cache:false,
		async:true,
		success:function( res ){
			n = res.n; 
			//当出错后可以点击上一步和下一步
			if( res.status == 1 || res.status == 2 || res.status == 3 || res.status == 4 || res.status == 5 || res.status == 6 || res.status == 7 || res.status == 8 || res.status == 9 )
			{
				$( '#self_step1' ).html( '' );
				$( '.self_forward' ).removeAttr( 'disabled' );
				$( '#self_percentage' ).html( '' );
				$( '#self_waiting' ).html( '请检查问题并刷新页面后继续安装' );
				$( '#self_waiting_img' ).css( 'display', 'none' );
			}
			//将错误信息输出到输出框中
			$( '.self_license_content' ).append( res.msg );
			//n从1开始循环的次数
			var times = 5;
			//如果n小于4则继续请求后台
			if( n < times )
			{
				startInstall();
			}
			//如果n=5则说明完成了4次请求，配置成功
			else if( n == times )
			{
				$( '#self_waiting' ).html( 'FCMS配置成功，正在跳转请稍候' );
				$( '#self_waiting_img' ).css( 'display', 'none' );
				setTimeout( "location.href = '/admin/finalfcmsinstall/index'", 2000 );
			}
		}
		
	} );
	
}












