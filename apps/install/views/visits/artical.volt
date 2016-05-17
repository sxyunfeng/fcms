<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>文章页面</title>
</head>
<body>
访问次数：<span id="artical_visits"></span>

<script src="/js/jquery/jquery-1.11.1.min.js"></script>
<script>
$( document ).ready( function(){
	$.post( '/install/Visits/redisInput', { 'driver':$( '#methodSelect' ).val() }, function( res ){
		$( '#artical_visits' ).html( res );
	}, 'json' );
} );
</script>
</body>
</html>