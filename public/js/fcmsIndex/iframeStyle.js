/**
 * iframe样式自适应
 */
var windowHeight = 0;//浏览器文档显示区窗口高度
var sidebarHeight = 0;//左侧菜单栏高
var contentHeight = 0;//iframe内容页高

$( document ).ready( function(){
	//设置页面高度
	sidebarHeight = 230 + parseInt( $( '.bsc_menu_first' ).css( 'height' ) );
	setPageHeight();
} );

/**
 * 设置页面高度（自动）
 */
function setPageHeight(){
	windowHeight = window.innerHeight - 85;
	if( windowHeight > sidebarHeight ){
		var height = sidebarHeight = windowHeight;
	}else{
		var height = sidebarHeight;
	}
	$( '.bsc_sidebar' ).css( 'height', height );
}
$( window ).resize( function(){
	if( sidebarHeight > contentHeight ){
		setPageHeight();
		var height = sidebarHeight;
	}else{
		var height = contentHeight;
		$( '.bsc_sidebar' ).css( 'height', height );
	}
	$( '.bsc_iframe:visible' ).css( 'height', height );
	$( '.bsc_iframe:visible' ).contents().find( 'body' ).css( 'height', height );
	iframeStyle( 0 );
} );

$( $( '.bsc_iframe:visible' ).css( 'height' ) ).resize( function(){
	if( sidebarHeight > contentHeight ){
		setPageHeight();
		var height = sidebarHeight;
	}else{
		var height = contentHeight;
		$( '.bsc_sidebar' ).css( 'height', height );
	}
	$( '.bsc_iframe:visible' ).css( 'height', height );
	$( '.bsc_iframe:visible' ).contents().find( 'body' ).css( 'height', height );
} );


/**
 * 设置iframe样式(需要手动触发的)
 */
function iframeStyle( scrollState ){
	var screenWidth = $( window ).width();//屏幕宽
	var sidebarWidth = $( '.bsc_sidebar' ).outerWidth( true );//菜单栏宽
	var iframeWidth = screenWidth - sidebarWidth;//内容页宽
	contentHeight = $( "iframe.bsc_iframe_show" ).contents().find( 'body' ).innerHeight();
	
	$( '.bsc_iframe:visible' ).css( 'width', iframeWidth );
	
	if( contentHeight - sidebarHeight > 0 ){
		$( '.bsc_sidebar' ).css( 'height', contentHeight );
		$( '.bsc_iframe:visible' ).css( 'height', contentHeight );
	}else{
		$( '.bsc_sidebar' ).css( 'height', sidebarHeight );
		$( '.bsc_iframe:visible' ).css( 'height', sidebarHeight );
	}
	
	//滚动条回到顶部
	if( scrollState ){
		$( document ).scrollTop( 0 );
	}
	
}
