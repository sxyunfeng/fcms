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
			<?php foreach( $flink as $link ){ ?>
				<span><a href="<?php echo $link->url;?>" title="<?php echo $link->name; ?>" target="<?php if( !$link->target ){ echo '_blank'; } ?>" rel="<?php if( 0 == $link->nofollow ) echo 'nofollow'; ?>"><?php echo $link->name; ?></a></span>
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
