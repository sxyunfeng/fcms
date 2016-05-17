/**
 * 首页
 */
/*------------手风琴参数配置-----------*/
var accordionOpt = { 
	accordion: true,//交叉合起
    speed: 300,//延时时间，单位毫秒
    closedSign: "<span class='glyphicon glyphicon-chevron-right'></span>",//菜单关闭图标
    openedSign: "<span class='glyphicon glyphicon-chevron-down'></span>" //菜单展开
};

var windowHeight = 0;//浏览器文档显示区窗口高度
var sidebarHeight = 0;//左侧菜单栏高
var contentHeight = 0;//iframe内容页高

$( document ).ready( function(){
	( function(){
		//用于页面加载时输出所有一级菜单
		var firstMenu = '';
		//一级菜单展开箭头
		var arrow = "<span style='position:absolute;right:10px;" +
				"width:10px;height:10px;font-size:9px;'>" + accordionOpt.closedSign + "</span>";
		//默认后台首页id为2
		var homeId = 2;
		for( var id in leftMenu ){
			var menu = leftMenu[ id ];
			//一级菜单
			firstMenu += '<li><span menu_id="' + id + '"><a><b></b>' + menu.name 
				+ ( menu['sub'] ? arrow : '' ) + '</a></span></li>';
			//找到后台首页id
			if( 'index/fcmshome' == leftMenu[id]['src'] && 'admin' == leftMenu[id]['module'] ){
				homeId = id;
			}
		}
		
		/*------------初始加载首页iframe及面包屑-----------*/
		//iframe内容
		$( '.bsc_content' ).html( '<iframe src="/admin/index/fcmshome" iframe_id="' + homeId 
				+ '" class="bsc_iframe bsc_iframe_show" frameborder="0" scrolling="no" marginheight="0"' +
				' marginwidth="0" onload="iframeStyle( 1 )"></iframe>' );
		//面包屑内容
		$( '.bsc_nav_position' ).html( '<span class="glyphicon glyphicon-home"></span><span class="bsc_space"></span>首页' );
		//如果leftMenu为空，那么只显示首页
		if( !firstMenu ){
			firstMenu = '<li><span><a><b></b>首页</a></span></li>';
		}
		$( '.bsc_menu_first' ).html( firstMenu );
		
		//设置一级菜单图标
		var offsetX = 0;
		$( '.bsc_menu_first > li' ).each( function(){
			var $this = $( this ).find( 'span > a > b' );
			$this.css( 'background-position', '-'+ offsetX +'px -0px' );
			offsetX += 17;
		} );
	} )();
	
	/*------------切换头部选项按钮-----------*/
	$( '.bsc_op_btn' ).click( function(){
		var boxes = [ 'msg', 'set', 'user' ];
		var box = $( this ).attr( 'box' );
		for( var i in boxes ){
			if( boxes[i] == box ){
				$( '.bsc_dropdown_menu_' + boxes[i] ).slideToggle( 150 );
			}else{
				$( '.bsc_dropdown_menu_' + boxes[i] ).slideUp( 100 );
			}
		}
	} );
	
	/*------------点击非选项按钮 或 非选项框时，隐藏头部选项框-----------*/
	$( 'html' ).click( function( event ){
		var classes = [ 'glyphicon glyphicon-envelope', 'glyphicon glyphicon-cog', 'glyphicon glyphicon-user' ];
		var className = event.target.className;
		if( className && ( 'bsc_op_btn' == className || -1 != $.inArray( className, classes )  ) ){
			return;
		}else{
			var childClass = event.target.firstChild;
			if( childClass && -1 != $.inArray( childClass.className, classes ) ){
				return;
			}
		}
		$( '.bsc_dropdown_menu_msg' ).slideUp( 100 );
		$( '.bsc_dropdown_menu_set' ).slideUp( 100 );
		$( '.bsc_dropdown_menu_user' ).slideUp( 100 );
	} );

	
	$( "iframe.bsc_iframe_show" ).load( function(){
		var $this = $( this );

		/*------------点击iframe中的内容也隐藏头部选项框-----------*/
		$this.contents().on( 'click',function(){
			$( 'html', parent.document ).click();
		} );
		
		/*------------F5刷新页面仍停留在当前页面-----------*/
		$this.contents().keydown( function( e ){
			if( e.keyCode === 116 ){
				$this.attr( 'src', $this.attr( 'src' ) );
		    	return false;
		    }
		} );
		
	} );
	
	/*------------菜单悬停样式-----------*/
	$( '.bsc_menu' ).delegate( 'li > span', 'mouseover', function(){
		$( this ).find( 'a' ).css( { 'color' : '#4E99C7' } );
		if( 'bsc_menu_second' == $(this).parent().parent().attr( 'class' ) && !$(this).find( 'i' ).size() ){
			$(this).append( '<i></i>' );
		}
	});
	$( '.bsc_menu' ).delegate( 'li > span', 'mouseleave', function(){
		if( !parseInt( $( this ).attr( 'active' ) ) ){
			$( this ).find( 'a' ).css( { 'color' : '' } );
			$(this).find( 'i' ).remove();
		}
	});
	
	/*------------F5刷新页面仍停留在当前页面-----------*/
	$( window ).keydown( function( e ){
	    if( e.keyCode === 116 ){
	    	$( 'iframe.bsc_iframe_show' ).attr( 'src', $( 'iframe.bsc_iframe_show' ).attr( 'src' ) );
	    	return false;
	    }
	} );
	
	//特殊页面加载选项
	var loadOptions = {
			'userInfo':{
				'src': 'index/userInfo',
				'iframeId': -1,
				'loadMode': 1,
				'controller': 'admin'
			},
			'site':{
				'src': 'sitesetting/index',
				'iframeId': -2,
				'loadMode': 0,
				'controller': 'admin'
			},
			'static':{
				'src': 'staticcache/index',
				'iframeId': -3,
				'loadMode': 0,
				'controller': 'admin'
			}
	};
	
	/*------------点击头像和右上角个人资料按钮进入个人信息页面-----------*/
	$( '.bsc_user .img, .bsc_op_userinfo' ).on( 'click', function(){
		$( '.bsc_nav_position' ).html( "<span class='glyphicon glyphicon-home'></span><span class='bsc_space'>首页<span class='bsc_space'></span>><span class='bsc_space'></span>个人资料" );
		loadIframe( loadOptions['userInfo']['src'], loadOptions['userInfo']['iframeId'], 
				loadOptions['userInfo']['loadMode'], loadOptions['userInfo']['controller'] );
		resetMenuStyle();
	} );
	
	/*------------进入站点管理-----------*/
	$( '.bsc_set_site' ).on( 'click', function(){
		$( '.bsc_nav_position' ).html( "<span class='glyphicon glyphicon-home'></span><span class='bsc_space'>首页<span class='bsc_space'></span>><span class='bsc_space'></span>站点管理" );
		loadIframe( loadOptions['site']['src'], loadOptions['site']['iframeId'], 
				loadOptions['site']['loadMode'], loadOptions['site']['controller'] );
		resetMenuStyle();
	} );
	
	/*------------进入静态化中心-----------*/
	$( '.bsc_set_static' ).on( 'click', function(){
		$( '.bsc_nav_position' ).html( "<span class='glyphicon glyphicon-home'></span><span class='bsc_space'>首页<span class='bsc_space'></span>><span class='bsc_space'></span>静态化中心" );
		loadIframe( loadOptions['static']['src'], loadOptions['static']['iframeId'], 
				loadOptions['static']['loadMode'], loadOptions['static']['controller'] );
		resetMenuStyle();
	} );
	
	/*------------退出登录-----------*/
	$( '.bsc_op_logout' ).click( function(){
		$.confirm( { title: '是否退出登录？', confirm: function(){
			location.href = "/admin/login/logout";
        } } );
	} );
	
	/*------------回到前台首页-----------*/
	$( '.bsc_op_back' ).click( function(){
		window.open( '/cms/index/index' );
	} );
	
	//设置页面高度
	sidebarHeight = 150 + parseInt( $( '.bsc_menu_first' ).css( 'height' ) );
	setPageHeight();
} );

/**
 * 进入特殊页面，取消菜单栏高亮边框
 */
function resetMenuStyle(){
	$( '.bsc_menu_first > li' ).each( function(){
		var $this = $( this );
		if( parseInt( $this.children( 'span' ).attr( 'active' ) ) ){
			$this.children( 'ul:visible' ).slideUp( accordionOpt.speed, function(){
				$( this ).parent("li").find( "span a span:first" ).html( accordionOpt.closedSign );
			});
			//重置一级菜单样式
			$this.children( 'span' ).attr( 'active', 0 );
			$this.children( 'span' ).children( 'a' ).css({ 'color': '', 'font-weight': '' });
			
			//重置二级菜单样式
			$this.children( 'ul' ).children( 'li' ).each( function(){
				var $t = $( this );
				if( parseInt( $t.children( 'span' ).attr( 'active' ) ) ){
					/*** 预留收起二级菜单功能 ***/
					
					$t.children( 'span' ).attr( 'active', 0 );
					$t.children( 'span' ).children( 'a' ).css('color', '' );
					return false;
				}
			} );
			
			return false;
		}
	} );
	
	$( '.bsc_highlight_border' ).hide();
	//重置菜单下标
	menuIndex = [ -1, -1, -1 ];
}

/**
 * 设置页面高度
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
 * scrollState为0时不回到顶部，为1时回到顶部
 */
function iframeStyle( scrollState ){
	var screenWidth = $( window ).width();//屏幕宽
	var sidebarWidth = $( '.bsc_sidebar' ).outerWidth( true );//菜单栏宽
	var iframeWidth = screenWidth - sidebarWidth;//内容页宽
	contentHeight = $( "iframe.bsc_iframe_show" ).contents().find( 'body' ).innerHeight();
    //处理文章编辑器
    var editor = $( "iframe.bsc_iframe_show" ).contents().find( '#articleContent #edui1_iframeholder' );
    if( editor.length )
    {
        var editorHeight = editor.height();
        if( editorHeight > contentHeight - 400 )
        {
            contentHeight = editorHeight + 400;
        }
    }

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

/**
 * 加载Iframe
 */
function loadIframe( src, iframeId, loadMode, loadModule ){
	
	//如果容器中已有iframe存在，则先隐藏所有的iframe
	if( $( 'iframe' ).length ){
		$( 'iframe' ).each( function(){
			//如果为特殊页面
			if( 0 > parseInt( $( this ).attr( 'iframe_id' ) ) ){
				if( parseInt( loadMode ) ){
					//同步or异步加载，0为异步，1为同步，默认为0异步
			  		$( "iframe[ iframe_id='" + iframeId + "' ]" ).attr( 'src', $( ".bsc_content > iframe[ iframe_id='" + iframeId + "' ]" ).attr( 'src' ) );
				}
			}
  			$( this ).removeClass( 'bsc_iframe_show' ).addClass( 'bsc_iframe_hide' );
  		} );
	}
	
	if( $( "iframe[iframe_id='" + iframeId + "']" ).length ){
		//如果该iframe已存在
		if( !$( "iframe[iframe_id='" + iframeId + "']" ).hasClass( 'bsc_iframe_show' ) ){
			//如果该iframe未显示，则显示所点击的iframe（未显示则无动作）
	  		$( "iframe[ iframe_id='" + iframeId + "' ]" ).removeClass( 'bsc_iframe_hide' ).addClass( 'bsc_iframe_show' );
		}
		iframeStyle( 1 );
	}else{
		//如果该iframe不存在，则加载该iframe
		var iframeStr = '<iframe src="/' + loadModule + '/' + src + '" iframe_id="' + iframeId +
				'" class="bsc_iframe bsc_iframe_show" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" onload="iframeStyle( 1 )"></iframe>';
  		$( '.bsc_content' ).append( iframeStr );
  		//更换当前show的iframe后也可以通过点击iframe来关闭右上角打开的菜单
  		$( "iframe.bsc_iframe_show" ).load( function(){
  			var $this = $( this );
  			$this.contents().on( 'click', function(){
  				$( 'html', parent.document ).click();
  			} );
  			/*------------F5刷新页面仍停留在当前页面-----------*/
  			$this.contents().keydown( function( e ){
  			    if( e.keyCode === 116 ){
  			    	$this.attr( 'src', $this.attr( 'src' ) );
  			    	return false;
  			    }
  			} );
  		} );
	}
	if( parseInt( loadMode ) ){
		//同步or异步加载，0为异步，1为同步，默认为0异步
  		$( "iframe[ iframe_id='" + iframeId + "' ]" ).attr( 'src', $( ".bsc_content > iframe[ iframe_id='" + iframeId + "' ]" ).attr( 'src' ) );
	}
}

/**
 * 加载面包屑
 */
function loadNav( leftMenu, firstId, secondId, thirdId, className ){
	var homePage = '<span class="glyphicon glyphicon-home"></span><span class="bsc_space"></span>首页';
	var nav = '';
	switch ( className ){
		case 'bsc_menu_first':
			nav = leftMenu[ firstId ][ 'name' ];
			nav = '后台首页' == nav ? '' : '<span class="bsc_space"></span>><span class="bsc_space"></span>' + nav;
			break;
		case 'bsc_menu_second':
			nav = '<span class="bsc_space"></span>><span class="bsc_space"></span>' + leftMenu[ firstId ][ 'name' ] + '<span class="bsc_space"></span>><span class="bsc_space"></span>' 
			+ leftMenu[ firstId ][ 'sub' ][ secondId ][ 'name' ];
			break;
		case 'bsc_menu_third':
			nav = '<span class="bsc_space"></span>><span class="bsc_space"></span>' + leftMenu[ firstId ][ 'name' ] + '<span class="bsc_space"></span>><span class="bsc_space"></span>' 
			+ leftMenu[ firstId ][ 'sub' ][ secondId ][ 'name' ] + '<span class="bsc_space"></span>><span class="bsc_space"></span>' 
			+ leftMenu[ firstId ][ 'sub' ][ secondId ][ 'sub' ][ thirdId ][ 'name' ];
			break;
	}
	$( '.bsc_nav_position' ).html( homePage + nav );
}




