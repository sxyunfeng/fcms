/*
 * sidebar手风琴插件
 */

/**
 * 菜单下标
 * 0：一级菜单下标
 * 1：二级菜单下标
 * 2：三级菜单下标
 */ 
var menuIndex = [ -1, -1, -1 ];
$( document ).ready( function(){
	
	//记录点击的一级菜单下标
	var firstMenuIndex = -1;
	
	var firstId = '';
	var secondId = '';
	var thirdId = '';
	
	$( '#bsc_menu_first' ).delegate( 'li > span', 'click', function(){
		if(accordionOpt.accordion){
			//收起未选中的子菜单
			if(!$(this).parent().find("ul").is(':visible') ){
				parents = $(this).parent().parents("ul");
				visible = $( '#bsc_menu_first' ).find("ul:visible");
				visible.each(function(visibleIndex){
					var close = true;
					parents.each(function(parentIndex){
						if(parents[parentIndex] == visible[visibleIndex]){
							close = false;
							return false;
						}
					});
					if(close){
						if($(this).parent().find("ul") != visible[visibleIndex]){
							$(visible[visibleIndex]).slideUp(accordionOpt.speed, function(){
								$(this).parent("li").find( "span a span:first" ).html( accordionOpt.closedSign );
							});
						}
					}
				});
			}else{
				if( 'bsc_menu_first' == $( this ).parent().parent().attr( 'class' ) ){
					if( menuIndex[0] != $( this ).parent().index()
							|| menuIndex[1] != $( this ).next().children( 'li' ).children( 'ul:visible' ).parent().index() ){
						$( this ).next().children( 'li' ).children( 'ul:visible' ).slideUp(accordionOpt.speed, function(){
							$(this).parent("li").find( "span a span:first" ).html( accordionOpt.closedSign );
						});
					}
				}
			}
		}
		
		//设置点击样式及展开标记
		var $tm = $( this );
		$( '.bsc_menu li' ).each( function(){
			$( this ).children( 'span' ).attr( 'active', '0' ).children( 'a' ).css( 'color', '' ).find( 'span' ).css( 'color','' );
			$( this ).children( 'span' ).find( 'i' ).remove();
			if( 'bsc_menu_first' == $(this).parent().attr( 'class' ) ){
				$( this ).children( 'span' ).children( 'a' ).css( 'font-weight', '' );
			}
		} );
		do{
			$tm.attr( 'active', '1' ).children( 'a' ).css( 'color', '#4e99c7' ).children( 'span' )
				.children( 'span' ).css( 'color', '#4e99c7' );
			var className = $tm.parent().parent().attr( 'class' );
			if( 'bsc_menu_first' == className ){
				$tm.children( 'a' ).css( 'font-weight', 700 );
				break;
			}else if( 'bsc_menu_second' == className ){
				$tm.append( '<i></i>' );
				$tm.find( 'i' ).css( {
					'background': 'url(/public/img/admin/fcms/redArrow.png) no-repeat',
					'background-size': '6px 15px' 
				} );
			}
		}while( $tm = $tm.parent().parent().parent().children( 'span' ) )
			
		//各级菜单
		var menu = '';
		//父ul类名，可判断当前菜单为几级菜单
		var className = $(this).parent().parent().attr( 'class' );
		//所点击菜单的链接
		var src = '';
		//所加载页面的同步或异步方式(1为同步，0为异步)
		var loadMode = 1;
		//所加载页面的模块名，默认为admin
		var loadModule = 'admin';
		//加载子页面，同时计算右侧高亮边框样式
		switch( className ){
			case 'bsc_menu_first':
				//设置一级菜单背景色
				if( -1 != firstMenuIndex && $(this).parent().index() != firstMenuIndex ){
					var $t = $(this);
					setTimeout( function(){
						$( '.bsc_menu_first' ).children( 'li:eq('+ firstMenuIndex +')' ).children( 'span' )
							.css( 'background-color', '#F7F7F7' );
						$t.css( 'background-color', '#fff' );
						firstMenuIndex = $t.parent().index();
					}, accordionOpt.speed - 100 );
				}else{
					$(this).css( 'background-color', '#fff' );
					firstMenuIndex = $(this).parent().index();
				}
				
				var firstMenu = '';
				var secondMenu = '';
				//获取菜单id值
				firstId = parseInt( $( this ).attr( 'menu_id' ) );
				if( !$(this).parent().find( 'ul' ).size() && ( firstMenu = leftMenu[firstId]['sub'] ) ){
					//有二级菜单时加载该菜单
					//定义二级菜单最右边的下拉箭头
					var arrow = "<span style='position:absolute;right:10px;width:10px;height:10px;font-size:9px;'>"
						+ accordionOpt.closedSign + "</span>";
					for( var id in firstMenu ){
						secondMenu += "<li><span menu_id='" + id + "'><a>" + firstMenu[id]['name'] 
								+ ( firstMenu[id]['sub'] ? arrow : '' ) + "</a></span></li>";
					}
					
					secondMenu && $( this ).parent().append( "<ul class='bsc_menu_second' style='display:none;'>" 
							+ secondMenu + "</ul>" );
				}
				
				if( !$(this).parent().find( 'ul' ).size() ){
					$( '.bsc_highlight_border' ).show();
					//无ul
					menuIndex[0] = $(this).parent().index();
					setHighlightBorder( menuIndex[0] * 40, 40, 6 );
					//重置二级，三级下标
					menuIndex[2] = menuIndex[1] = -1;
					
					menu = leftMenu[firstId];
					//如果无子菜单则给链接赋值
					src = leftMenu[firstId]['src'];
					loadMode = leftMenu[firstId]['loadmode'];
					loadModule = leftMenu[firstId]['module'];
					//无二级菜单时直接加载相应iframe（区分同步或异步加载方式）
					setTimeout( function(){
						loadIframe( src, firstId, loadMode, loadModule );
					}, accordionOpt.speed );
					//加载面包屑
					loadNav( leftMenu, firstId, secondId, thirdId, 'bsc_menu_first' );
				}else{
					//有ul
					if( menuIndex[0] > $(this).parent().index() ){
						//当前子菜单 在 原子菜单之前
						if( $(this).parent().find( 'ul' ).is( ':visible' ) ){
							//当前子菜单展开
							setHighlightBorder( menuIndex[0] * 40, 40, 6 );
						}else{
							//当前子菜单闭合
							var top = $( this ).next().children( 'li' ).size() + 
								$( '.bsc_menu_first > li:eq('+ menuIndex[0] +')' ).index();
							setHighlightBorder( top * 40, 40, 6 );
						}
					}else{
						if( menuIndex[0] == $(this).parent().index() 
								&& !$(this).next().is( ':visible' ) ){
							//当前子菜单 == 原子菜单
							var openMenu = -1;
							//记录当前子菜单中呈展开状态的二级菜单的下标
							$(this).next().children( 'li' ).each( function(){
								if( 'block' == $(this).children( 'ul' ).css( 'display' ) ){
									openMenu = $(this).index();
									return;
								}
							} );
							
							var $ts = $(this).next().children( 'li:eq('+ menuIndex[1] +')' );//$thisSecond
							if( -1 == openMenu ){
								//无展开二级菜单
								setHighlightBorder( menuIndex[0] * 40, 
										( $(this).next().children( 'li' ).size() + 1 ) * 40, ( menuIndex[1] + 1 ) * 40 + 6 );
							}else{
								//有展开二级菜单
								//子菜单个数  0:二级子菜单个数  1:三级子菜单个数
								var count = [];
								count[0] = $( this ).next().children( 'li' ).size();
								count[1] = $( this ).next().children( 'li:eq('+ openMenu +')' ).find( 'ul' ).children( 'li' ).size();
								if( openMenu == menuIndex[1] ){
									setHighlightBorder( menuIndex[0] * 40, ( count[0] + count[1] + 1 ) * 40, 
											( menuIndex[1] + menuIndex[2] + 2 ) * 40 + 6 );
									//设置三级菜单样式
									$ts.find( 'li:eq('+ menuIndex[2] +')' ).children( 'span' )
										.attr( 'active', '1' ).children( 'a' ).css( 'color', '#4e99c7' ).children( 'span' )
										.children( 'span' ).css( 'color', '#4e99c7' );
								}else if( openMenu > menuIndex[1] ){
									//展开的二级菜单 在 原二级菜单之后
									setHighlightBorder( menuIndex[0] * 40, ( count[0] + count[1] + 1 ) * 40, 
											( menuIndex[1] + 1 ) * 40 + 6 );
								}else{
									//展开的二级菜单 在 原二级菜单之前
									setHighlightBorder( menuIndex[0] * 40, ( count[0] + count[1] + 1 ) * 40, 
											( count[1] + menuIndex[1] + 1 ) * 40 + 6 );
								}
							}
							//设置二级菜单样式
							$(this).next().children( 'li:eq('+ menuIndex[1] +')' ).children( 'span' )
								.attr( 'active', '1' ).children( 'a' ).css( 'color', '#4e99c7' ).children( 'span' )
								.children( 'span' ).css( 'color', '#4e99c7' );
							//设置左侧图标
							$ts.children( 'span' ).append( '<i></i>' );
							$ts.children( 'span' ).find( 'i' ).css( {
								'background': 'url(/public/img/admin/fcms/redArrow.png) no-repeat',
								'background-size': '6px 15px' 
							} );
						}else if( -1 != menuIndex[0] ){
							//当前子菜单 在 原子菜单之后
							var sonUl = $( '.bsc_menu_first' ).children( 'li:eq('+ menuIndex[0] +')' ).children( 'ul' );
							if( sonUl.size() && sonUl.is( ':visible' ) ){
								setHighlightBorder( menuIndex[0] * 40, 40, 6 );
							}
						}
					}
				}
				break;
			case 'bsc_menu_second':
				//定义三级菜单
				var thirdMenu = '';
				secondId = parseInt( $( this ).attr( 'menu_id' ) );
				var prevMenu = leftMenu[firstId]['sub'][secondId]['sub'];
				
				if( !$(this).parent().find( 'ul' ).size() && prevMenu ){
					//有三级菜单时加载该菜单
					for( var id in prevMenu ){
						thirdMenu += "<li><span menu_id='" + id + "'><a>" + prevMenu[id]['name'] + "</a></span></li>";
					}
					thirdMenu && $( this ).parent().append( "<ul class='bsc_menu_third' style='display:none;'>" 
							+ thirdMenu + "</ul>" );
				}
				
				if( !$(this).parent().find( 'ul' ).size() ){
					$( '.bsc_highlight_border' ).show();
					//无子菜单
					menuIndex[0] = $(this).parent().parent().parent().index();
					menuIndex[1] = $(this).parent().index();
					setHighlightBorder( menuIndex[0] * 40, ( $(this).parent().parent().children( 'li' ).size() + 1 ) * 40,
							( menuIndex[1] + 1 ) * 40 + 6 );
					//重置三级下标
					menuIndex[2] = -1;
					
					menu = leftMenu[firstId]['sub'][secondId]
					//如果没有子菜单则给链接赋值
					src = leftMenu[firstId]['sub'][secondId]['src'];
					//无三级菜单时直接加载相应iframe
					loadMode = leftMenu[firstId]['sub'][secondId]['loadmode'];
					loadModule = leftMenu[firstId]['sub'][secondId]['module'];
					setTimeout( function(){
						loadIframe( src, secondId, loadMode, loadModule );
					}, accordionOpt.speed );
					//加载面包屑
					loadNav( leftMenu, firstId, secondId, thirdId, 'bsc_menu_second' );
				}else{
					//有子菜单
					if( menuIndex[0] == $(this).parent().parent().parent().index() ){
						//当前一级菜单 == 原一级菜单
						if( $(this).parent().find( 'ul' ).is( ':visible' ) ){
							//当前子菜单展开
							setHighlightBorder( menuIndex[0] * 40, ( $(this).parent().parent().children( 'li' ).size() + 1 ) * 40,
									( menuIndex[1] + 1 ) * 40 + 6 );
						}else{
							//当前子菜单闭合
							var count = [];
							count[0] = $( this ).parent().parent().children( 'li' ).size();
							count[1] = $( this ).next().children( 'li' ).size();
							if( menuIndex[1] > $(this).parent().index() ){
								//当前二级子菜单 在 原二级子菜单 之前
								setHighlightBorder( -1, ( count[0] + count[1] + 1 ) * 40, 
										( menuIndex[1] + count[1] + 1 ) * 40 + 6 );
							}else{
								if( menuIndex[1] == $(this).parent().index()
										 && !$(this).next().is( ':visible' ) && -1 != menuIndex[2] ){
									//当前二级子菜单 == 原二级子菜单，且有已选三级子菜单
									setHighlightBorder( menuIndex[0] * 40, ( count[0] + count[1] + 1 ) * 40, 
											( menuIndex[1] + menuIndex[2] + 2 ) * 40 + 6 );
									//设置三级菜单样式
									$(this).next().children( 'li:eq('+ menuIndex[2] +')' ).children( 'span' )
										.attr( 'active', '1' ).children( 'a' ).css( 'color', '#4e99c7' );
								}else{
									//当前二级子菜单 在 原二级子菜单 之后
									setHighlightBorder( menuIndex[0] * 40, ( count[0] + count[1] + 1 ) * 40, 
											( menuIndex[1] + 1 ) * 40 + 6 );
								}
							}
						}
					}else{
						//原子菜单闭合
						var count = [];
						count[0] = $( this ).parent().parent().children( 'li' ).size();
						count[1] = $( this ).next().children( 'li' ).size();
						if( menuIndex[0] > $(this).parent().parent().parent().index() ){
							//当前子菜单 在 原子菜单 之前
							if( $(this).parent().find( 'ul' ).is( ':visible' ) ){
								//当前二级菜单展开
								setHighlightBorder( ( menuIndex[0] + count[0] ) * 40, -1, 6 );
							}else{
								//当前二级菜单闭合
								setHighlightBorder( ( menuIndex[0] + count[0] + count[1] ) * 40, -1, 6 );
							}
						}
					}
				}
				
				break;
			case 'bsc_menu_third':
				$( '.bsc_highlight_border' ).show();
				menuIndex[0] = $(this).parent().parent().parent().parent().parent().index();
				menuIndex[1] = $(this).parent().parent().parent().index();
				menuIndex[2] = $(this).parent().index();
				var count = [];
				count[0] = $( this ).parent().parent().parent().parent().children( 'li' ).size();
				count[1] = $( this ).parent().parent().children( 'li' ).size();
				setHighlightBorder( menuIndex[0] * 40, ( count[0] + count[1] + 1 ) * 40, 
						( menuIndex[1] + menuIndex[2] + 2 ) * 40 + 6 );
				
				thirdId = parseInt( $( this ).attr( 'menu_id' ) );
				
				menu = leftMenu[firstId]['sub'][secondId]['sub'][thirdId];
				src = leftMenu[firstId]['sub'][secondId]['sub'][thirdId]['src'];
				loadMode = leftMenu[firstId]['sub'][secondId]['sub'][thirdId]['loadmode'];
				loadModule = leftMenu[firstId]['sub'][secondId]['sub'][thirdId]['module'];
				//三级菜单点击后直接加载相应iframe
				setTimeout( function(){
					loadIframe( src, thirdId, loadMode, loadModule );
				}, accordionOpt.speed );
				//加载面包屑
				loadNav( leftMenu, firstId, secondId, thirdId, 'bsc_menu_third' );
				break;
			default:
				return;
		}
		
		//展开或收起菜单
		if($(this).parent().find("ul:first").is(":visible")){
			$(this).parent().find("ul:first").slideUp(accordionOpt.speed, function(){
				$(this).parent("li").find("span a span:first").delay(accordionOpt.speed).html(accordionOpt.closedSign);
				var menuHeight = 230 + parseInt( $( '.bsc_menu_first' ).css( 'height' ) );
				sidebarHeight = windowHeight > menuHeight ? windowHeight : menuHeight;
				if( sidebarHeight > contentHeight ){
					var height = sidebarHeight;
					setTimeout( function(){
						$( '.bsc_iframe:visible' ).css( 'height', height );
						$( '.bsc_iframe:visible' ).contents().find( 'body' ).css( 'height', height );
					}, accordionOpt.speed );
				}else{
					var height = contentHeight;
				}
				$( '.bsc_sidebar' ).animate( { 'height': height }, accordionOpt.speed );
			});
		}else{
			$(this).parent().find("ul:first").slideDown(accordionOpt.speed, function(){
				$(this).parent("li").find("span a span:first").delay(accordionOpt.speed).html(accordionOpt.openedSign);
				var menuHeight = 230 + parseInt( $( '.bsc_menu_first' ).css( 'height' ) );
				sidebarHeight = windowHeight > menuHeight ? windowHeight : menuHeight;
				if( sidebarHeight > contentHeight ){
					var height = sidebarHeight;
					setTimeout( function(){
						$( '.bsc_iframe:visible' ).css( 'height', height );
						$( '.bsc_iframe:visible' ).contents().find( 'body' ).css( 'height', height );
					}, accordionOpt.speed - 100 );
					
				}else{
					var height = contentHeight;
				}
				$( '.bsc_sidebar' ).animate( { 'height': height }, accordionOpt.speed );
			});
		}
	});
	
	/**
	 * 设置右侧高亮边框样式
	 */
	function setHighlightBorder( borderTop, borderHeight, borderDivTop ){
		var option = {};
		-1 != borderTop && ( option['top'] = borderTop );
		-1 != borderHeight && ( option['height'] = borderHeight );
		$( '.bsc_highlight_border' ).animate( option, accordionOpt.speed );
		$( '.bsc_highlight_border div' ).animate( { top : borderDivTop + 'px' }, accordionOpt.speed );
	}
	
} );




