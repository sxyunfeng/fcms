/**
 * 
 */

//返回上一页
function backForward(){
    history.back( -1 );
}

//向指定ID输入指定信息
function inputInfo( id, info ){
	$( "#"+id ).html( info );
}

//向指定ID输入对号或错号
function inputCorrect( id ){
	$( "#"+id ).html( "<span class='glyphicon glyphicon-ok' style='color:green;'></span>" );
}

function inputWrong( id ){
	$( "#"+id ).html( "<span class='glyphicon glyphicon-remove' style='color:red;'></span>" );
}

//检查所有必选扩展项是否通过，通过则可以进行下一步
function checkAllId(){
	
	var str = $( ".necessaryItem" ).html();
	
	var isSuccess = true;
	
    $( '.necessaryItem' ).each( function(){
    	
    	if( ! $( this ).find( '.glyphicon-ok' ).length )
		{
			isSuccess = false;
		}
    	
    } );
    if( ! isSuccess )
	{
    	alert( "请完善必选项后再进行下一步操作！" );
	}
	return isSuccess;
	
}