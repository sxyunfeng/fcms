
// js for static sites 

$( function(){
   /* -------------  全站静态化  ------------------*/
	$( '#staticSite' ).click(function(){
		
		$( '#confirmModal' ).modal( 'show' );
	
		$( '#continueBtn' ).click(function(){
			
			$( '#confirmModal' ).modal( 'hide' );
			
			$( '#myModal' ).modal({
				   keyboard: false,
				   backdrop:'static',
			   	});
				
				$( '#myModal' ).on( 'hide.bs.modal' , function(){
				   if( 100 != $( 'div.progress-bar' ).attr( 'aria-valuenow' ) )
				   {
					   if( confirm( "您确认要终止此次操作吗?" ) )
						   return true;
					   else
						   return false;
				   }
			   	});
				
				//ajax 请求操作静态化
				$.get( '/admin/statics/sites' , function( ret ){
				   if( 1 != ret.state )
				   {
					    runLoading();
					    $( '#myModal' ).modal( 'hide' );
				   }
				   else
				   {
					    $( '#myModal' ).unbind( 'hide.bs.modal' );
					    $( '#myModal' ).modal( 'hide' );
				   }
				   
				   	$( '#dis_message' ).html( ret.msg );
					$( '#dis_message' ).parent().parent().addClass( 'alert-success' ).removeClass( 'alert-danger' );
					$( '#dis_message' ).parent().parent().fadeIn( 500 );
					setTimeout( function(){
						$( '#dis_message' ).parent().parent().fadeOut( 1000 );
					}, '3000' );
				   
				}, 'json' );
				
		});
   	});
   
	/* -------------  继续静态化  ------------------*/
   	$( '#staticPart' ).click(function(){
	   $( '#myModal' ).modal({
		   keyboard: false,
		   backdrop:'static',
	   });
	   
	   $( '#myModal' ).on( 'hide.bs.modal' , function(){
		   if( 100 != $( 'div.progress-bar' ).attr( 'aria-valuenow' ) )
		   {
			   if( confirm( "您确认要终止此次操作吗?" ) )
				   return true;
			   else
				   return false;
		   }
	   });
	   
	   //ajax 请求操作静态化
	   $.get( '/admin/statics/part' , function( ret ){
		   if( 1 != ret.state )
		   {
			    runLoading();
			    $( '#myModal' ).modal( 'hide' );
		   }
		   else
		   {
			   $( '#myModal' ).unbind( 'hide.bs.modal' );
			   $( '#myModal' ).modal( 'hide' );
		   }
		   
		   	$( '#dis_message' ).html( ret.msg );
			$( '#dis_message' ).parent().parent().addClass( 'alert-success' ).removeClass( 'alert-danger' );
			$( '#dis_message' ).parent().parent().fadeIn( 500 );
			setTimeout( function(){
				$( '#dis_message' ).parent().parent().fadeOut( 1000 );
			}, '3000' );
		   
	   }, 'json' );
	   
   	});
   
   
	/* -------------  单片文章静态化  ------------------*/
   	$( 'i.articlesStatics' ).click(function(){
   		
	   $( '#myModal' ).modal({
		   keyboard: false,
		   backdrop:'static',
	   });
	   
	   $( '#myModal' ).on( 'hide.bs.modal' , function(){
		   if( 100 != $( 'div.progress-bar' ).attr( 'aria-valuenow' ) )
		   {
			   if( confirm( "您确认要终止此次操作吗?" ) )
				   return true;
			   else
				   return false;
		   }
	   });
	   
	   var id = $(this).parent().parent( 'td' ).attr( 'data-id' );
	   if( false == id )
	   {
		   alert( '参数设置失败,请刷新后再试...' );
		   return false;
	   }
	   //ajax 请求操作静态化
	   $.get( '/admin/statics/artStatic/aid/' + id , function( ret ){
		   if( 1 != ret.state )
		   {
			   runLoading();
			   $( '#myModal' ).modal( 'hide' );
		   }
		   else
		   {
			   $( '#myModal' ).unbind( 'hide.bs.modal' );
			   $( '#myModal' ).modal( 'hide' );
			   alert( ret.msg );
		   }
	   }, 'json' );
	   
   	});
   
});
    
function runLoading()
{
	for( var i=40; i <=100 ; i +=1 )
	{
		$( 'div.progress-bar' ).css( 'width' , i+'%' );
		$( 'div.progress-bar' ).attr( 'aria-valuenow' , i );
	}
}
    