//js for fcms public


//登录、注册弹出框
function showRegisterPage(){
	$( "#loginPage" ).attr( "class", "hide" );
	$( "#registerPage" ).attr( "class", "show" );
}
function showLoginPage(){
	$( "#loginPage" ).attr( "class", "show" );
	$( "#registerPage" ).attr( "class", "hide" );
}

$( document ).ready( function(){
	//幻灯片播放
	$( "#myCarousel" ).carousel({
		interval: 3000
	} );

	//回到顶部
	$( ".self_returntotop" ).hide();
	if( $( window ).scrollTop() > 100 ){
		$( ".self_returntotop" ).fadeIn( 0 );
	}else{
		$( ".self_returntotop" ).fadeOut( 0 );
	}
	$( window ).scroll( function (){
		if( $( window ).scrollTop() > 100 ){
			$( ".self_returntotop" ).fadeIn( 100 );
		}else{
			$( ".self_returntotop" ).fadeOut( 100 );
		}
	} );
	$( ".self_returntotop" ).click( function(){
		$( "body,html" ).animate( {scrollTop:0}, 300 );
	} );

	/** 绑定搜索事件 */
	$( '#search' ).find( 'input[name="key"]' ).keydown(function( e ){
		if( ( e.ctrlKey && 13 == e.keyCode) || 13 == e.keyCode )
			searchActions();
	});
	$( '#search' ).find( 'span.input-group-addon' ).click(function(){
		searchActions();
	});

	/** 导航点击 */
	$( 'ul.navbar-nav li' ).each(function(){
		var menus = $(this).find( 'ul.dropdown-menu' ).length;
		if( false != menus && menus > 0 )
		{
			$(this).click(function(){
				
				var target = $(this).find( '>a' ).attr( 'target' );
				if( false == target || 'self' == target )
					location.href = $(this).find( '>a' ).attr( 'href' );
				else
					window.open( $(this).find( '>a' ).attr( 'href' ) );
			});
		}
	});

} );

//清除导航条hover、focus样式
function clearDropdownStyle(){
	$( ".dropdown_toggle" ).attr( "style","color:#000;background-color:#fff;" );
}

//循环构建单行条下拉菜单及样式
for( var i = 1; i < 5; ++i ){
	$( ( ".self_dropdown__" + i ) ).bind( {
		click:function(){
			var iIndex = parseInt( this.className.split( "__" )[1] );
			$( ".self_dropdown_menu__" + iIndex ).attr( "style","display:block" );
			$( ".self_dropdown_toggle__" + iIndex ).attr( "style","color:#fff;background-color:#d60000;" );
		},
		mouseover:function(){
			var iIndex = parseInt( this.className.split( "__" )[1] );
			$( ".self_dropdown_menu__" + iIndex ).attr( "style","display:block" );
			$( ".self_dropdown_toggle__" + iIndex ).attr( "style","color:#fff;background-color:#d60000;" );
		},
		mouseout:function(){
			var iIndex = parseInt( this.className.split( "__" )[1] );
			$( ".self_dropdown_menu__" + iIndex ).attr( "style","display:none" );
			$( ".self_dropdown_toggle__" + iIndex ).attr( "style","color:#000;background-color:#fff;" );
		}
	} );
}

/**  查询结果页面 */
function searchActions()
{
	var key = $( 'input[name="key"]' ).val();
	if( false == key )
		return false;
	else
		window.open( "/cms/search/index/key/" + encodeURI( key ) );
}

/** 文章收藏 */
function setArticleFavs( item , id )
{
	if( false == id )
		return false;
	
	
	$( item ).parent( 'p' ).before( '<div class="alert alert-success" role="alert">oK! 喜欢成功...</div>' );
	
	setTimeout( function(){
		$( item ).parent( 'p' ).siblings( 'div.alert-success' ).remove();
	} , 1000 );
	
}
