<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.min.css" />
<link rel="stylesheet" href="/css/cms/default/main.css" />
<link rel="stylesheet" href="/css/cms/default/list.css">
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
			        <li data-id="<?php echo $menu['id']; ?>" class="<?php if( false != $mid && false != $menu['relid'] && $mid == $menu[ 'relid' ] ) echo 'active'; ?> dropdown self_dropdown_toggle__<?php echo $i; ?>">
			          <?php  if( false != $menu['url'] ){ ?>
			          <a href="<?php echo $menu['url'];?>" class="dropdown <?php if( false != $mid && false != $menu['relid'] && $mid == $menu[ 'relid' ] ) echo ''; else echo 'self_dropdown_toggle__' . $i;  ?>" target="<?php if( isset( $menu[ 'target' ] ) && 0 != $menu['target'] ) echo '_blank'; ?>" data-toggle="<?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) echo 'dropdown'; ?>" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $menu['name']; ?></a>
			          <?php } else if( isset( $menu['relid'] ) && false == $menu['relid'] ) { ?>
			          <a href="<?php echo $this->menu->getListLink(); ?>" class="dropdown <?php if( false != $mid && false != $menu['relid'] && $mid == $menu[ 'relid' ] ) echo ''; else echo 'self_dropdown_toggle__' . $i;  ?>" target="<?php if( isset( $menu[ 'target' ] ) && 0 != $menu['target'] ) echo '_blank'; ?>" data-toggle="<?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) echo 'dropdown'; ?>" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $menu['name']; ?></a>
			          <?php } else if( isset( $menu['relid'] ) && false != $menu['relid'] ) { ?>
			          <a href="<?php echo $this->menu->getListLink( 'artcate', $menu['relid'] ); ?>" class="dropdown <?php if( false != $mid && false != $menu['relid'] && $mid == $menu[ 'relid' ] ) echo ''; else echo 'self_dropdown_toggle__' . $i;  ?>" target="<?php if( isset( $menu[ 'target' ] ) && 0 != $menu['target'] ) echo '_blank'; ?>" data-toggle="<?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) echo 'dropdown'; ?>" role="button" aria-haspopup="true" aria-expanded="false" class="_fcms_static_" ><?php echo $menu['name']; ?></a>
			          <?php } else { ?>
			          <a href="<?php echo $this->menu->getListLink(); ?>" class="dropdown <?php if( false != $mid && false != $menu['relid'] && $mid == $menu[ 'relid' ] ) echo ''; else echo 'self_dropdown_toggle__' . $i;  ?>" target="<?php if( isset( $menu[ 'target' ] ) && 0 != $menu['target'] ) echo '_blank'; ?>" data-toggle="<?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) echo 'dropdown'; ?>" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $menu['name']; ?></a>
			          <?php }?>
			          <?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) { ?>
			          <ul class="dropdown-menu self_dropdown_menu__<?php echo $i; ?>">
			          	<?php  foreach( $menu['children'] as $ch ) { ?>
			          	<li data-pid="<?php echo $ch['pid'];?>">
			          		<?php if( false != $ch[ 'url' ] ){ ?>
			          		<a data-category="<?php echo $ch['pid'];?>" href="<?php echo $ch[ 'url' ];?>" target="<?php if( isset( $ch[ 'target' ] ) && 0 != $ch['target'] ) echo '_blank';?>"><?php echo $ch['name'];?></a>
							<?php }else if( isset( $ch['relid'] ) && false == $ch['relid'] ){ ?>
							<a data-category="<?php echo $ch['pid'];?>" href="<?php echo $this->menu->getListLink(); ?>" target="<?php if( isset( $ch[ 'target' ] ) && 0 != $ch['target'] ) echo '_blank';?>" class="_fcms_static_"><?php echo $ch['name'];?></a>
							<?php } else if( isset( $ch['relid'] ) && false != $ch['relid'] ){?>
							<a data-category="<?php echo $ch['relid'];?>" href="<?php echo $this->menu->getListLink( 'artcate' , $ch[ 'relid'] );?>" target="<?php if( isset( $ch[ 'target' ] ) && 0 != $ch['target'] ) echo '_blank';?>" class="_fcms_static_"><?php echo $ch['name'];?></a>
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
	
	
	<?php
	$catid = $mid?$mid:0;
	$catinfo = $this->article->getCateInfo( $catid );
	?>
	<!-- 文章列表 -->
	<div class="container">
	
		<div style="margin:10px 0;">
			<ol class="breadcrumb self_breadcrumb self_nopadding">
			  <li><a href="<?php if( isset( $cpryp->domain ) )echo $cpryp->domain; else echo 'http://' . $_SERVER['HTTP_HOST']; ?>">网站首页</a></li>
			  <li class="active"><?php if( false != $catid && false != $catinfo ) echo $catinfo->name; else echo '我的文章';?></li>
			</ol>
		</div>
	</div>
	
	<div class="container">
		<div class="row self_nomargin">
			<div class="col-md-8 self_white_area">
			  <?php 
				$list = $this->article->getCateArticles( $catid , $curPage );
				if( count( $list ) > 0 )
				{
					$i = 0;
					foreach( $list->items as $row )
					{
			  ?>
				<div class="self_artical" style="<?php if( 0 == $i ) echo 'border:none;'; ?>">
				
					<div class="page-header" style="margin-bottom:10px;">
						<h3>
						<a href="<?php echo $this->article->getListLink( 'article', $row->id ); ?>" target="_blank" title="<?php echo $row->title; ?>" class="_fcms_static_"><?php echo mb_substr( $row->title , 0 , 22 , 'UTF-8' ); ?></a>
						</h3>
						<div class="self_list_author">
							<span>作者：<?php if( false != $row->author ) echo $row->author; else echo '佚名'; ?>&nbsp;&nbsp;&nbsp;&nbsp;
							<?php if( false != $row->uptime ) echo date( 'Y-m-d', strtotime( $row->uptime ) ); else echo date( 'Y-m-d', strtotime( $row->addtime ) ); ?></span>
						</div>
					</div>
					
					<div class="row">
						<?php if( isset( $row->face ) && false != $row->face ){ ?>
						<div class="col-md-3">
							<a href="<?php echo $this->article->getListLink( 'article', $row->id ); ?>" target="_blank" class="thumbnail" class="_fcms_static_">
								<img src="<?php echo $row->face; ?>" alt="<?php echo $row->title; ?>">
							</a>
						</div>
						<?php } ?>
						<div class="<?php if( isset( $row->face ) && false != $row->face ) echo 'col-md-9'; else echo 'col-md-12';?>">
							<p><?php echo $row->description ?></p>
							<div class="self_list_buttons">
								<a class="btn btn-danger">点击收藏</a> 
								<a class="btn btn-default" target="_blank" href="<?php echo $this->article->getListLink( 'article', $row->id ); ?>" class="_fcms_static_">查看详情</a>
							</div>
						</div>
					</div>
				
				</div>
				<?php
				    	$i++;
					}
				?>
				<!-- 分页 -->
				<?php if( $list->total_pages > 1){ ?>
                <nav class="text-right" >
                    <ul class="pagination pagination-sm" style="margin-top:0"> 
                        <li class="<?php if( $list->current == 1 ) echo 'disabled'?>"><a href="/cms/index/list/cid/<?php echo $catid;?>/page/<?php echo $list->before; ?>" class="_fcms_static_">&laquo;</a></li>
                        <?php if ( 1 != $list->current && 1 != $list->before ){ ?>
                        <li><a href="/cms/index/list/cid/<?php echo $mid;?>" class="_fcms_static_">1</a></li>
                        <?php } ?>
                        <?php if( $list->before != $list->current ){?>
                        <li><a href="/cms/index/list/cid/<?php echo $catid;?>/page/<?php echo $list->before;?>" class="_fcms_static_"><span ><?php echo $list->before ?></span></a></li>
                        <?php } ?>
                        <li class="active"><a href="/cms/index/list/cid/<?php echo $catid;?>/page/<?php echo $list->current;?>" class="_fcms_static_"><span ><?php echo $list->current ?></span></a></li>
                        <?php if( $list->next != $list->current ) { ?>
                        <li><a href="/cms/index/list/cid/<?php echo $catid;?>/page/<?php echo $list->next;?>" class="_fcms_static_"><?php echo $list->next ?></a></li>
                        <?php } ?>
                        <?php if ( $list->next  < $list->last - 1 ) { ?>
                        <li><a>...</a></li>
                        <?php } ?>
                        <?php if( $list->last != $list->next  ){?>
                        <li><a href="/cms/index/list/cid/<?php echo $catid;?>/page/<?php echo $list->last;?>" class="_fcms_static_"><?php echo $list->last;?></a></li>
                        <?php } ?>
                        <li class="<?php if ( $list->current == $list->last ) echo 'disabled';?>"><a href="/cms/index/list/cid/<?php echo $catid;?>/page/<?php echo $list->next; ?>" class="_fcms_static_">&raquo;</a></li>
                    </ul>
                </nav>
				<?php } ?>
				<?php } ?>
			</div>
			
			<?php $result = $this->article->getCatAndArtList( 2 ); ?>
			<div class="col-md-3" style="margin-left:20px;width:370px;">
				
				<div class="row self_sidebar self_white_area">
					<div class="col-md-12">
						<?php if( false != $result && count( $result ) > 0  ) { ?>
						<div>
							<div class="page-header">
								<h4><?php if( false != $result['cateinfo']->name ) echo $result['cateinfo']->name; ?></h4>
							</div>
							<?php 
								if( isset( $result['artlist'] ) && !empty( $result['artlist'] ) )
								{
							?>
							<ul class="list-group">
								<?php foreach( $result['artlist'] as $row ){ ?>
								<li class="list-group-item">
									<span class="glyphicon glyphicon-bookmark"></span>&nbsp;&nbsp;&nbsp;
									<a href="<?php echo $this->article->getListLink( 'article', $row->id ); ?>" title="<?php echo $row->title; ?>" class="_fcms_static_"><?php echo mb_substr($row->title , 0 , 15 , 'UTF-8' ); ?></a>
								</li>
								<?php }?>
							</ul>
							<?php } ?>
						</div>
						<?php }?>
					</div>
				</div>
				
				<div class="row self_sidebar self_white_area">
					<div class="col-md-12">
						<div>
							<div class="page-header">
								<h4>广告位</h4>
							</div>
							<a href="/" class="thumbnail">
								<img src="/img/cms/default/artical3.png" alt="文章缩略图">
							</a>
						</div>
					</div>
				</div>

			</div>
			
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
					<p><a href="#">友情链接</a></p>
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
<script src="/js/cms/default/optNav.js"></script>
<script type="text/javascript">
var sign = <?php if( false != $mid ) echo $mid; else echo 0;?>;
$(function(){
	if( false != sign )
	{
		$( 'ul.navbar-nav li ul li' ).each(function(){
			var catregory = $(this).find( 'a' ).attr( 'data-category' );
			if( false != catregory && catregory == sign )
			{
				var chpid = $(this).attr( 'data-pid' );
				$( 'ul.navbar-nav li' ).each(function(){
					var pcte = $(this).attr( 'data-id' );
					if( false != pcte && pcte == chpid )
					{
						$(this).addClass( 'active' ).siblings( 'li' ).removeClass( 'active' );
					}
				});
			}
		});
	}
});
</script>
</body>
</html>
	
