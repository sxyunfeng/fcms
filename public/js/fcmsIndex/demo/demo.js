/**
 *	Demo Js
 */
/*( function(){
	
	if( !userInfo ){
		var userInfo = '';
	}
	
	if( !userInfo || !userGroup ){
		toastr.error( '数据初始化失败' );
		$( 'table tbody' ).html( '<tr><td colspan="7" align="center">没有数据</td></tr>' );
		return;
	}
	userInfo.length > 10 && $( '.pager' ).show();
	
	loadList();
	
	var group = '<li groupId="-1"><a>全部分组</a></li>';
	for( var j in userGroup ){
		group += '<li groupId="'+ j +'"><a>'+ userGroup[j] +'</a></li>';
	}
	$( '.list-filter ul' ).html( group );
} )();*/

function loadList( searchName, groupId ){
	var str = '';
	for( var i in userInfo ){
		var user = userInfo[i];
		var string = '<tr userId="'+ i +'">'+
			'<td>'+ user.loginname +'</td>'+
			'<td>'+ user.nickname +'</td>'+
			'<td>'+ user.name +'</td>'+
			'<td>'+ userGroup[user.groupid] +'</td>'+
			'<td>'+ user.email +'</td>'+
			'<td>'+ userStatus[user.status] +'</td>'+
			'<td><span class="glyphicon glyphicon-pencil" title="修改" role="modify"></span>'+
	  		'<span class="glyphicon glyphicon-trash" title="删除" role="delete"></span></td></tr>';
		if( searchName || undefined !== groupId ){
			if( searchName && undefined !== groupId ){
				( searchName == user.loginname ) && ( groupId == user.groupid ) && ( str += string );
			}else if( searchName ){
				( searchName == user.loginname ) && ( str += string );
			}else{
				( groupId == user.groupid ) && ( str += string );
			}
		}else{
			str += string;
		}
	}
	
	str = str ? str : '<tr><td colspan="7" align="center">没有数据</td></tr>';
	$( 'table tbody' ).html( str );
}

//新建
$( '.list-addbtn' ).click( function(){
	location.href = '/admin/index/showAddDemo';
} );

//刷新
$( '.list-refresh' ).click( function(){
	location.reload();
} );

//搜索
$( '.list-search input' ).keydown( function( e ){
	var searchName = '';
	if( 13 == e.keyCode ){
		searchName = $.trim( $( this ).val() );
		var groupId = parseInt( $( '#list-filter-text' ).attr( 'groupId' ) );
		loadList( searchName, -1 == groupId ? undefined : groupId );
	}
} );
//重置搜索框
$( '.list-search span' ).click( function(){
	$( '.list-search input' ).val( '' );
} );
 
//过滤框
$( '.list-filter ul li' ).click( function(){
	var seledId = parseInt( $( this ).attr( 'groupId' ) );
	var groupId = parseInt( $( '#list-filter-text' ).attr( 'groupId' ) );
	
	if( seledId === groupId ){
		return;
	}else{
		loadList( $.trim( $( '.list-search input' ).val() ), -1 == seledId ? undefined : seledId );
		$( '#list-filter-text' ).attr( 'groupId', seledId );
		$( '#list-filter-text' ).html( userGroup[seledId] ? userGroup[seledId] : '全部分组' );
	}
} );

//删除
$( '.table span' ).delegate( '', 'click', function(){
	var $this = $( this );
	if( 'delete' == $( this ).attr( 'role' ) ){
		$( '#confirmModal' ).modal( 'show' );
		$( '#confirmModal button' ).click( function(){
			 if( parseInt( $( this ).attr( 'confirm' ) ) ){
				 $this.parent().parent().remove();
				 var userId = parseInt( $this.parent().parent().attr( 'userId' ) );
				 delete userInfo[userId];
			 } 
		})
	}
} );



















