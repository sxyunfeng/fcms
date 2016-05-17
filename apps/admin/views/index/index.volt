<!DOCTYPE html>
<html lang="zh_CN" style="overflow: hidden;">
    <head>
    	
    	<link rel='icon' href='/public/favicon.ico' mce_href='/public/favicon.ico' type='image/x-icon'>
		<link rel='shortcut icon' href='/public/favicon.ico' mce_href='/public/favicon.ico' type='image/x-icon'>
    	
        <link rel="stylesheet" href="/css/admin/base.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge">
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta charset="utf-8">
        <title>FCMS</title>
        <meta name="description" content="This is page-header " >
        <meta name="keywords" content="商城">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/css/admin/theme.css" >
        <link rel="stylesheet" href="/css/admin/font-awesome.min.css"  >
        <link rel="stylesheet" href="/css/admin/simplebootadminindex.css"> 

        <style type="text/css">
            #screen{
                margin-right:0.6%;
                margin-top:0.3%;
            }
            .navbar .nav_shortcuts .btn{margin-top: 5px;}
            .fa { margin-right: 5px;}
            /*-----------------导航hack--------------------*/
            .nav-list>li.open{position: relative; }
             .nav-list span, .nav-list i, .nav-list a { cursor:pointer; }
            .nav-list>li.open .normal {display: inline-block !important;}
            .nav-list>li.open a {padding-left: 7px;}
            .nav-list>li .submenu>li>a {background: #fff;}
            /*.nav-list>li .submenu>li a>[class*="fa-"]:first-child{left:20px; }*/
            /*.nav-list>li ul.submenu ul.submenu>li a>[class*="fa-"]:first-child{left:30px;}*/
            /*----------------导航hack--------------------*/

        </style>
    </head>
    
    <body style="min-width:900px;" screen_capture_injected="true" >
        <div style="display: none;" id="loading"><i class="loadingicon"></i><span>正在加载...</span></div>
        <!--  loadding -->
        <div id="right_tools_wrapper">
            <span id="refresh_wrapper" title="刷新当前页"><i class="fa fa-refresh right_tool_icon"></i></span>
        </div>
        <!--  loadding -->

        <div class="navbar">
            <!--  top icon -->
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a href="" class="brand"> <small>  <img src="/img/admin/fcms/logo1.png" style="width:120px;">  </small> </a>
                    <!--				<div class="pull-left nav_shortcuts">
                                        <a class="btn btn-small btn-success" href="#" title="分类管理">
                                            <i class="fa fa-th"></i>
                                        </a>
                                        <a class="btn btn-small btn-info" href="#" title="文章管理">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-small btn-warning" href="/" title="前台首页" target="_blank">
                                            <i class="fa fa-home"></i>
                                        </a>
                                        <a class="btn btn-small btn-danger" href="#" title="清除缓存">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </div>-->
                    <!--  top icon -->

                    <!--  user avatars -->
                    <ul class="nav simplewind-nav pull-right">
                        <li class="light-blue">
                            <a data-toggle="dropdown" href="#" id="topRightMenu" class="dropdown-toggle">
                                <!--<img class="nav-user-photo" src="" alt="admin">-->
                                <span class="user-info">
									<small>欢迎,</small>
									<?php if( isset( $nickName ) ) echo $nickName;elseif( isset( $loginName ) ) echo $loginName;else echo 'visitor'; ?>
                                </span>
								<i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer" style="margin-top:10px;" >
                                
                                <!--<li><a href="#"><i class="fa fa-cog"></i>站点管理</a></li>-->
                                <li><a href="javascript:openapp('/admin/users/edit?id={{ uid | e }}','index_user','个人资料')"><i class="fa fa-user"></i>个人资料</a></li>
                                <!--<li class="divider"></li>-->
                                <li><a href="/admin/login/logout"><i class="fa fa-power-off"></i>退出</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!--  user avatars -->
                </div>
            </div>
        </div>
      
        <div class="main-container container-fluid">
            <div class="sidebar" id="sidebar">
                <div style="height: 180px; overflow: auto;" id="nav_wraper">
                    <!--  nav bar list -->

                    <ul class="nav nav-list">
                            <?php if( isset( $leftMenu ) && !empty( $leftMenu ) ){ ?>
                            {% for first in leftMenu %}
                            <li>
                                <a <?php if( ! isset($first[ 'sub' ]) ) {?> onclick="openapp('<?php if( $first[ 'src' ] )  echo '/'. $first[ 'module' ] .'/' . $first[ 'src' ] ;
                            else echo '#'; ?>','menusFirst{{ first[ 'id' ] }}','{{ first[ 'name' ] }}');" <?php } ?>class="dropdown-toggle">
                                    {% if first[ 'descr'] %}
                                    <i class="fa fa-{{ first[ 'descr' ] }} normal"></i>
                                    {% else %}
                                    <i class="fa fa-home normal"></i>
                                    {% endif %}
                                    <span class="menu-text normal">{{ first[ 'name' ] }}</span>
                                    <b class="arrow fa fa-angle-right normal"></b>
                                 
                                </a>
                                    <?php if( isset( $first[ 'sub' ] ) && !empty( $first[ 'sub' ] ) ){ ?>
                                    <ul class="submenu">
                                        {% for second in first[ 'sub' ] %}
                                        <li>
                                            <a <?php if( ! isset( $second[ 'sub']) ) { ?>onclick="openapp( '<?php if( $second[ 'src' ] ) echo '/'. $second[ 'module'] .'/' . $second[ 'src' ] ;
                                            else echo '#'; ?>' , 'menusSecond{{ second[ 'id' ] }}' , '{{ second[ 'name' ] }}');" <?php }?> class="dropdown-toggle">
                                            <?php if( isset( $second[ 'sub' ] ) && !empty( $second[ 'sub' ] ) ){ ?>
                                                    <i class="fa fa-caret-right"></i>
                                            <?php } ?>
                                                <span class="menu-text">{{ second[ 'name' ] }}</span>
                                                <b class="arrow fa fa-angle-right"></b>
                                            </a>
                                             <?php if( isset( $second[ 'sub' ] ) && !empty( $second[ 'sub' ] ) ){ ?>
                                                <ul class="submenu">
                                                    {% for third in second[ 'sub' ] %}
                                                    <li>
                                                        <a onclick="openapp( '<?php if( $third[ 'src' ] ) echo '/' . $third[ 'module' ] .'/'. $third[ 'src' ] ;
                                                         else echo '#'; ?>' , 'menusThird{{ third[ 'id' ] }}' , '{{ third[ 'title' ] }}' )">
                                                            <i class="fa fa-angle-double-right"></i>
                                                            <span class="menu-text">{{ third[ 'name' ] }}</span>
                                                        </a>
                                                    </li>
                                                    {% endfor %}
                                                </ul>	
                                            <?php } ?>
                                        </li>
                                        {% endfor %}
                                    </ul>	
                             <?php } ?>
                            </li>
                            {% endfor %}
                        <?php } ?>
                    </ul>
                    <!--  nav bar list -->
                </div>
            </div>

            <!--  main -->
            <div class="main-content">
                <div class="breadcrumbs" id="breadcrumbs">
                    <a style="display: none;" id="task-pre" class="task-changebt">←</a>
                    <div style="width: 118px;" id="task-content">
                        <ul style="width: 118px;" class="macro-component-tab" id="task-content-inner">
                            <li class="macro-component-tabitem noclose" app-id="menusFirst2" app-url="/admin/index/show" app-name="首页">
                                <span class="macro-tabs-item-text">首页</span>
                            </li>
                        </ul>
                        <div style="clear:both;"></div>
                    </div>
                    <a style="display: none;" id="task-next" class="task-changebt">→</a>
                </div>
                <div style="height: 648px;" class="page-content" id="content">
                    <iframe src="/admin/index/show" style="width:100%;height: 100%;" id="appiframe-menusFirst2" class="appiframe" frameborder="0"></iframe>
                </div>
            </div>
        </div>
        <div class="sr-only" id="order" onclick="openapp('/admin/orders/index','order_index','订单');"></div>
        <div class="sr-only" id="return" onclick="openapp('/admin/returns/index','returns_index','退货');"></div>

        <script src="/js/jquery/jquery-1.11.1.min.js"></script>
        <script src="/js/admin/index.js"></script>
        <script src="/public/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script>
    var b = $( "#sidebar" ).hasClass( "menu-min" );
    var a = "ontouchend" in document;
    $( "#sidebar" ).on( "click", function( g ){
        var clickMenu = $( g.target ).closest( "a" ); //点击的菜单
       
        if( !clickMenu || clickMenu.length == 0 ){
            return true;
        }
        if( !clickMenu.hasClass( "dropdown-toggle" ) ){
            if( b && "click" == "tap" && clickMenu.get( 0 ).parentNode.parentNode == this ){
                var h = f.find( ".menu-text" ).get( 0 );
                if( g.target != h && !$.contains( h, g.target ) ){
                    return false;
                }
            }
            return;
        }
        var cMenu = clickMenu.next().get( 0 ); //子菜单
        if( ! cMenu ) //没有子菜单
        {
            return true;
        }
        if( !$( cMenu ).is( ":visible" ) )
        {
            clickMenu.find( '.fa-angle-right' ).addClass( 'fa-angle-down' ).removeClass( 'fa-angle-right' ); //箭头向下
            var pMenu = $( cMenu.parentNode ).closest( "ul" ); //父菜单
            if( b && pMenu.hasClass( "nav-list" ) ){
                return;
            }

            $( '.open .submenu' ).slideUp( 150 ).parent().removeClass( 'open' );
        } else { //显示
            clickMenu.find( '.fa-angle-down' ).addClass( 'fa-angle-right' ).removeClass( 'fa-angle-down' ); //箭头向右
        }
        if( b && $( cMenu.parentNode.parentNode ).hasClass( "nav-list" ) ){
            return false;
        }
        $( cMenu ).slideToggle( 150 ).parent().toggleClass( "open" ); //显示子菜单
        return true;
    } );
    
    $( '#topRightMenu' ).click( function(){
        $( this ).siblings().toggle();
    });
    $( "*" ).click( function(){
    	if( $( 'li.light-blue' ).hasClass( 'open' ) )
    	{
    		$( this ).removeClass( 'open' );
    		$( '#topRightMenu' ).attr( 'aria-expanded', 'false' );
    		$( 'ul.user-menu' ).css( 'display', 'none' );
    	}
    	
    } );
    $( '.user-menu' ).click( function(){
       $( this ).toggle();
    })
   
        </script>
    </body>
</html>