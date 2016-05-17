<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css" />
<link rel="stylesheet" href="/css/cms/default/main.css" />
<link rel="stylesheet"  href="/css/admin/font-awesome.min.css" >
<link rel="stylesheet" href="/css/cms/default/lightbox.css" />
<?php  $cpryp = $this->site->getWebSiteInfo(); ?>
<?php if( isset( $cpryp->name ) && false != $cpryp ){  ?>
<meta content="<?php echo $cpryp->name;?>" name="title">
<?php } ?>
<?php if( isset( $cpryp->seodescr ) && false != $cpryp ){ ?>
<meta content="<?php echo $cpryp->seodescr;?>" name="description">
<?php }?>
<?php if( isset( $cpryp->seokey ) && false != $cpryp ) { ?>
<meta content="<?php echo $cpryp->seokey;?>" name="Keywords">
<?php } ?>
<title>
	<?php if( isset( $cpryp->name ) && false != $cpryp->name ) echo $cpryp->name; else echo '我的FCMS网站'; ?>
</title>
<style>
a.btn-default:hover{
	background-color:#c9302c;
	border-color:#ac2925;
	color:#fff;
}
</style>
</head>
<body>
	<!-- 返回顶部 -->
	<div class="self_returntotop">
		<span class="glyphicon glyphicon-circle-arrow-up"></span>
	</div>
	
	<!-- 最上方欢迎+登录+注册条 -->
	<div class="container self_header" >
		<div class="col-md-6 col-xs-6 text-left self_nopadding">
			<span>欢迎来到  <?php if( isset( $cpryp->name ) && false != $cpryp->name ) echo $cpryp->name; else echo '我的FCMS网站'; ?></span>
		</div>
		<!-- 
		<div class="col-md-6 col-xs-6 text-right self_nopadding" id="loginAndRegister">
			<a href="#" data-toggle="modal" data-target="#modal" onclick="showLoginPage()">登录</a>
			<span>|</span>
			<a href="#" data-toggle="modal" data-target="#modal" onclick="showRegisterPage()">注册</a>
		</div>
		 -->
	</div>
	
	<!-- 登录与注册 -->
	<div class="modal fade" id="modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body" >
					
					<!-- 登录弹出框 -->
					<div id="loginPage" class="show">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<div class="container-fluid">
							<div class="row">
							
								<div class="col-md-7 col-xs-7" >
									<div class="page-header">
										<h3>欢迎来到FCMS <small>感受飞一般的速度</small></h3>
									</div>
									
									<div class="row">
										<div class="col-md-12 col-xs-12">
											<form method="post" action="#">
												<div class="form-group">
													<label for="username" class="sr-only">用户名：</label>
													<input type="text" class="form-control" id="username" placeholder="请输入用户名">
												</div>
												<div class="form-group">
													<label for="password" class="sr-only">密码：</label>
													<input type="password" class="form-control" id="password" placeholder="请输入密码">
												</div>
												<div class="checkbox">
													<button type="submit" class="btn btn-default">登录</button>
												    <label>
												    	<input type="checkbox" checked>下次自动登录
												    </label>
												    &nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="#">忘记密码？</a>
												</div>
											</form>
										</div>
									</div>
									
								</div>
									
								<div class="col-md-5 col-xs-5">
									<div class="page-header">
										<h4 class="text-center">用合作账号直接登录</h4>
									</div>
									<div class="center-block" style="max-width:180px">
										<button class="btn btn-danger btn-block">用QQ账号登录</button>
										<button class="btn btn-danger btn-block">用微信账号登录</button>
									</div>
									<br/>
									<p class="text-center">还没有注册？<a class="btn btn-default" onclick="showRegisterPage()">免费注册</a></p>
								</div>
							</div>
						</div>
					</div>
					
					<!-- 注册弹出框 -->
					<div id="registerPage" class="hide">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-7 col-xs-7">
									<div class="page-header">
										<h3>免费注册&nbsp;<small>感受飞一般的速度</small></h3>
									</div>
									<div class="row">
										<div class="col-md-10 col-xs-10">
											<div class="form-group">
												<form method="post" action="#">
													<div class="form-group">
														<label class="sr-only">用户名：</label>
														<input type="text" class="form-control" placeholder="请输入用户名">
													</div>
													<div class="form-group">
														<label class="sr-only">密码：</label>
														<input type="password" class="form-control" placeholder="请输入密码">
													</div>
													<div class="form-group">
														<label class="sr-only">确认密码：</label>
														<input type="text" class="form-control" placeholder="请再次确认密码">
													</div>
													<div class="form-group">
														<label class="sr-only">验证码：</label>
														<input type="text" class="form-control" placeholder="请输入验证码">
													</div>
												</form>
											</div>
										</div>
										<div class="col-md-12 col-xs-12">
											<div class="checkbox">
											<button class="btn btn-default" type="submit">快速注册</button>
												<label for=""><input type="checkbox" checked>同意注册协议</label>
											</div>
										</div>
										
									</div>
								</div>
								<div class="col-md-5 col-xs-5" style="padding-top:30px;">
									<div class="page-header">
										<h4 class="text-center">用合作账号直接登录</h4>
									</div>
									<div class="center-block" style="max-width:180px">
										<button class="btn btn-danger btn-block">用QQ账号登录</button>
										<button class="btn btn-danger btn-block">用微信账号登录</button>
									</div>
									<br/>
									<p class="text-center">已有账号？<a class="btn btn-default" onclick="showLoginPage()">直接登录</a></p>
								</div>
							</div>
						</div>
					</div>
					
					
				</div>
			</div>
		</div>
	</div>
	
	<!-- 导航条 -->
	<div class="navbar navbar-default self_navbar">
		
		<div class="container">
			
			<div class="navbar-header">
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-responsive-collapse">
			        <span class="sr-only">Toggle Navigation</span>
			        <!-- 下面几行内容是显示当页面左线后当行条最后边出现的那个三条横线的ICON的 -->
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
	       		</button>
	       		<a class="navbar-brand" href="<?php if( isset( $cpryp->domain ) )echo $cpryp->domain; else echo $_SERVER['HTTP_HOST']; ?>">
	       			<img alt="Brand" src="<?php if( isset( $cpryp->logo ) && false != $cpryp->logo )echo $cpryp->logo; else echo '/img/cms/default/logo2.png'; ?>">
	     		</a>
			</div>
			
			<div class="collapse navbar-collapse navbar-responsive-collapse self_nopadding" style="color:#e8e8e8;">
	        	<ul class="nav navbar-nav">
	        	<?php 
					$menus = $this->menu->getMenus();  
					if( false != $menus && !empty( $menus ) )
					{ 
						$i=1;
						foreach( $menus as $menu )
						{
				?>
			        <li class="<?php if( 1 == $i ) echo 'active'; ?> dropdown self_dropdown_toggle__<?php echo $i; ?>">
			          <?php  if( false != $menu['url'] ){ ?>
			          <a href="<?php echo $menu['url'];?>" class="dropdown-toggle self_dropdown_toggle__<?php echo $i; ?>" target="<?php if( isset( $menu[ 'target' ] ) && 0 != $menu['target'] ) echo '_blank'; ?>" data-toggle="<?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) echo 'dropdown'; ?>" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $menu['name']; ?></a>
			          <?php } else if( isset( $menu['relid'] ) && false == $menu['relid'] ) { ?>
			          <a href="<?php echo $this->menu->getListLink(); ?>" class="dropdown-toggle self_dropdown_toggle__<?php echo $i; ?>" target="<?php if( isset( $menu[ 'target' ] ) && 0 != $menu['target'] ) echo '_blank'; ?>" data-toggle="<?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) echo 'dropdown'; ?>" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $menu['name']; ?></a>
			          <?php } else if( isset( $menu['relid'] ) && false != $menu['relid'] ) { ?>
			          <a href="<?php echo $this->menu->getListLink( 'artcate', $menu['relid'] ); ?>" class="dropdown-toggle self_dropdown_toggle__<?php echo $i; ?>" target="<?php if( isset( $menu[ 'target' ] ) && 0 != $menu['target'] ) echo '_blank'; ?>" data-toggle="<?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) echo 'dropdown'; ?>" role="button" aria-haspopup="true" aria-expanded="false" class="_fcms_static_" ><?php echo $menu['name']; ?></a>
			           <?php } else { ?>
			          <a href="<?php echo $this->menu->getListLink(); ?>" class="dropdown <?php if( false != $mid && false != $menu['relid'] && $mid == $menu[ 'relid' ] ) echo ''; else echo 'self_dropdown_toggle__' . $i;  ?>" target="<?php if( isset( $menu[ 'target' ] ) && 0 != $menu['target'] ) echo '_blank'; ?>" data-toggle="<?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) echo 'dropdown'; ?>" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $menu['name']; ?></a>
			          <?php }?>
			          <?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) { ?>
			          <ul class="dropdown-menu self_dropdown_menu__<?php echo $i; ?>">
			          	<?php  foreach( $menu['children'] as $ch ) { ?>
			          	<li>
			          		<?php if( false != $ch[ 'url' ] ){ ?>
			          		<a href="<?php echo $ch[ 'url' ];?>" target="<?php if( isset( $ch[ 'target' ] ) && 0 != $ch['target'] ) echo '_blank';?>"><?php echo $ch['name'];?></a>
							<?php }else if( isset( $ch['relid'] ) && false == $ch['relid'] ){ ?>
							<a href="<?php echo $this->menu->getListLink(); ?>" target="<?php if( isset( $ch[ 'target' ] ) && 0 != $ch['target'] ) echo '_blank';?>" class="_fcms_static_"><?php echo $ch['name'];?></a>
							<?php } else if( isset( $ch['relid'] ) && false != $ch['relid'] ){?>
							<a href="<?php echo $this->menu->getListLink( 'artcate' , $ch[ 'relid'] );?>" target="<?php if( isset( $ch[ 'target' ] ) && 0 != $ch['target'] ) echo '_blank';?>" class="_fcms_static_"><?php echo $ch['name'];?></a>
							<?php }?>
			          	</li>
			          	<?php } ?>
			          </ul>
			          <?php } ?>
			        </li>
			     <?php
			     		 $i++; 
						}
					 } 
				?>
			 	</ul>
			 	
			 	<div class="navbar-form navbar-right" id="search">
				 	<div class="form-group input-group">
					  <input type="text" class="form-control" name="key">
					  <span class="input-group-addon" style="cursor:pointer;"><span class="glyphicon glyphicon-search"></span></span>
					</div>
				</div>
				
	  		</div>
	  		
		</div>
		
	</div>
	
	<!-- 轮播图 -->
	<!-- <div class="container" style="margin-top:10px;"> -->
		<div id="myCarousel" class="carousel slide">
	        <ol class="carousel-indicators">
	           <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	           <li data-target="#myCarousel" data-slide-to="1"></li>
	           <li data-target="#myCarousel" data-slide-to="2"></li>
	        </ol>
	        <div class="carousel-inner">
	            <div class="item active">
	                <a href="#"><img src="/img/cms/default/banner1.png" alt="banner1"></a>
	            </div>
	            <div class="item">
	                <a href="#"><img src="/img/cms/default/banner2.png" alt="banner2"></a>
	            </div>
	            <div class="item">
	            	<a href="#"><img src="/img/cms/default/banner3.png" alt="banner3"></a>
	            </div>
			</div>
	        <a class="left carousel-control" href="#myCarousel" data-slide="prev"></a>
	        <a class="right carousel-control" href="#myCarousel" data-slide="next"></a>
	    </div>
    <!-- </div> -->
    
	<!-- 详情展示 -->
	<div class="container">
	
		<div class="page-header">
	    	<h3>
	    		<span class="glyphicon glyphicon-send" aria-hidden="true" style="font-size:20px;"></span>&nbsp;&nbsp;&nbsp;<a>新鲜资讯</a>
	    		<a href="/"><small class="self_subtitle">功能汇总</small></a>
	    		<a href="/"><small class="self_subtitle">产品介绍&nbsp;&nbsp;&nbsp;</small></a>
	    		<a href="/"><small class="self_subtitle">FCMS特点&nbsp;&nbsp;&nbsp;</small></a>
	    	</h3>
	    	
	    </div>
		
		<div class="row masonry">
		<?php 
			$news = $this->article->getLatestArts();
			if( isset( $news ) && !empty( $news ) )
			{
				foreach( $news as $row )
				{
		?>
			<div class="col-sm-6 col-md-4 item">
				<div class="thumbnail">
					<?php if( false != $row->face ){ ?>
					<a href="<?php echo $this->article->getListLink( 'article', $row->id );?>" target="_blank" class="_fcms_static_"><img src="<?php if( false != $row->face ) echo $row->face; ?>" ></a>
					<?php } ?>
					<div class="caption">
						<h3><?php echo $row->title;?></h3>
						<p style="line-height:25px;height:75px;overflow:hidden;"><?php echo $row->description; ?></p>
						<p>
							<a href="<?php echo $this->article->getListLink( 'article', $row->id );?>" target="_blank" class="btn btn-danger" role="button" class="_fcms_static_">查看详情</a> 
							<a href="javascript:void( 0 );"  class="btn btn-default" role="button"><i class="fa fa-heart-o fa-lg"></i> 点击收藏</a>
						</p>
					</div>
				</div>
			</div>
		<?php
			}
		 }
		?>
		</div>
	</div>
	
	<!-- 最下方 -->
	<div class="container-fluid self_footer">
	
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-4 col-lg-3">
					<p><strong><a>FCMS</a></strong></p>
					<p><a href="#">关于我们</a></p>
					<p><a href="#">联系方式</a></p>
					<p><a href="#">法律条款</a></p>
					<p><a href="#">帮助中心</a></p>
					<p><a href="#">意见反馈</a></p>
				</div>
				<div class="col-sm-6 col-md-4 col-lg-3">
					<p><strong><a>产品相关</a></strong></p>
					<p><a href="#">华尔商城</a></p>
				</div>
				<div class="col-sm-6 col-md-4 col-lg-3">
					<p><strong><a>品牌合作</a></strong></p>
					<p><a href="#">华尔商城</a></p>
				</div>
				<div class="col-sm-6 col-md-4 col-lg-3">
					<p><strong><a>关注我们</a></strong></p>
					<p><a href="#">移动应用</a></p>
					<p><a href="#">新浪微博</a></p>
					<p><a href="#">腾讯微博</a></p>
					<p><a href="#">关注微信</a></p>
				</div>
			</div>
		</div>
		
		<div class="container">
			<div class="page-header self_link_header">
		    	<strong style="font-size:16px;"><a>友情连接</a></strong>
		    </div>
		    <?php 
				$flink = $this->flink->getFriendLink();
				if( count( $flink ) > 0 && false != $flink  ){
			?>
			<div class="row self_link_content">
			<?php foreach( $flink as $link ){  ?>
				<span><a href="<?php echo $link->url;?>" title="<?php echo $link->name; ?>" target="<?php if( 1 == $link->target ) echo '_blank'; ?>" rel="<?php if( 0 == $link->nofollow ) echo 'nofollow'; ?>"><?php echo $link->name; ?></a></span>
			<?php } ?>
			</div>
			<?php } ?>
		</div>
		
		<div class="container self_footer_bottom">
			<?php
				if( isset( $cpryp->copyright ) && false != $cpryp->copyright )
					echo $cpryp->copyright;
			    if( isset( $cpryp->static_code ) && false != $cpryp->static_code )
					echo $cpryp->static_code;
			?>
			<p>最佳分辨率1366*768，建议使用Chrome、Firefox、Safari、ie9版本浏览器。</p>
		</div>
		
	</div>

<script src="/js/jquery/jquery-1.11.1.min.js"></script>
<script src="/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="/js/cms/default/html5shiv.js"></script>
<script src="/js/cms/default/respond.js"></script>
<script src="/js/cms/default/masonry.pkgd.js"></script>
<script src="/js/cms/default/lightbox.js"></script>
<script src="/js/cms/default/imagesloaded.pkgd.js"></script>
<script src="/js/cms/default/optNav.js"></script>
<script type="text/javascript">
$(function() {
	var masonryNode = $('div.masonry');
	masonryNode.imagesLoaded(function(){
    masonryNode.masonry({
        itemSelector: '.item',
            isFitWidth: false
        });
    }); 
});
</script>
</body>
</html>
