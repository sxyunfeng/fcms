	<!-- 最上方欢迎+登录+注册条 -->
	<div class="container self_header" >
		<div class="col-md-6 col-xs-6 text-left self_nopadding">
			<span>欢迎来到  <?php if( isset( $cpryp->name ) && false != $cpryp->name ) echo $cpryp->name; else echo '我的FCMS网站'; ?></span>
		</div>
		<!-- <div class="col-md-6 col-xs-6 text-right self_nopadding" id="loginAndRegister">
			<a href="#" data-toggle="modal" data-target="#modal" onclick="showLoginPage()">登录</a>
			<span>|</span>
			<a href="#" data-toggle="modal" data-target="#modal" onclick="showRegisterPage()">注册</a>
		</div> -->
		
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
	       		<a class="navbar-brand" href="<?php if( $cpryp->domain )echo 'http://' . $cpryp->domain; else echo 'http://'. $_SERVER['HTTP_HOST']; ?>">
	       			<img alt="Brand" style="max-height:60px;" src="<?php if( isset( $cpryp->logo ) && false != $cpryp->logo )echo $cpryp->logo; else echo '/img/cms/default/logo2.png'; ?>">
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
			        <li data-id="<?php echo $menu['id']; ?>" class="<?php if( isset( $highlights ) && null != $menu[ 'relid' ]  && $highlights == $menu[ 'relid' ]  ) echo 'active'; else if( isset( $highlights ) && isset( $menu[ 'relartid' ] ) && $light == $menu[ 'relartid' ] ) echo 'active'; ?> dropdown self_dropdown_toggle__<?php echo $i; ?>">
			          <?php  if( isset( $menu[ 'relartid' ] ) && $menu['url'] && !$menu[ 'relartid' ] ){ ?>
			          <a href="<?php echo $menu['url'];?>" class="dropdown-toggle self_dropdown_toggle__<?php echo $i; ?>" target="<?php if( isset( $menu[ 'target' ] ) && 0 != $menu['target'] ) echo '_blank'; ?>" data-toggle="<?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) echo 'dropdown'; ?>" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $menu['name']; ?></a>
			          <?php } else if( isset( $menu[ 'relartid' ] ) && $menu[ 'relartid' ] ) { ?>
			          <a href="<?php echo $menu['url'];?>" class="dropdown self_dropdown_toggle__<?php echo $i;  ?>" target="<?php if( isset( $menu[ 'target' ] ) && 0 != $menu['target'] ) echo '_blank'; ?>" data-toggle="<?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) echo 'dropdown'; ?>" role="button" aria-haspopup="true" aria-expanded="false" class="_fcms_static_"><?php echo $menu['name']; ?></a>
			          <?php } else if( isset( $menu['relid'] ) && false == $menu['relid'] ) {?>
			          <a href="<?php echo $this->menu->getListLink(); ?>" class="dropdown-toggle self_dropdown_toggle__<?php echo $i; ?>" target="<?php if( isset( $menu[ 'target' ] ) && 0 != $menu['target'] ) echo '_blank'; ?>" data-toggle="<?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) echo 'dropdown'; ?>" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $menu['name']; ?></a>
			          <?php } else if( isset( $menu['relid'] ) && false != $menu['relid'] ) { ?>
			          <a href="<?php echo $this->menu->getListLink( 'artcate', $menu['relid'] ); ?>" class="dropdown-toggle self_dropdown_toggle__<?php echo $i; ?>" target="<?php if( isset( $menu[ 'target' ] ) && 0 != $menu['target'] ) echo '_blank'; ?>" data-toggle="<?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) echo 'dropdown'; ?>" role="button" aria-haspopup="true" aria-expanded="false" class="_fcms_static_" ><?php echo $menu['name']; ?></a>
			          <?php }else{ ?>
			          <a href="<?php echo $this->menu->getListLink(); ?>" class="dropdown <?php if( false != $mid && false != $menu['relid'] && $mid == $menu[ 'relid' ] ) echo ''; else echo 'self_dropdown_toggle__' . $i;  ?>" target="<?php if( isset( $menu[ 'target' ] ) && 0 != $menu['target'] ) echo '_blank'; ?>" data-toggle="<?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) echo 'dropdown'; ?>" role="button" aria-haspopup="true" aria-expanded="false" ><?php echo $menu['name']; ?></a>
			          <?php } ?>
			          <?php if( isset( $menu['children'] ) && count( $menu['children'] ) > 0 ) { ?>
			          <ul class="dropdown-menu self_dropdown_menu__<?php echo $i; ?>">
			          	<?php  foreach( $menu['children'] as $ch ) { ?>
			          	<li data-pid="<?php echo $ch['pid'];?>">
			          		<?php if( $ch[ 'url' ] && !$ch[ 'relartid' ] ){ ?>
			          		<a data-aid="<?php if( isset( $ch[ 'relartid' ] ) ) echo $ch[ 'relartid' ]; ?>" data-category="<?php echo $ch['pid'];?>" href="<?php echo $ch[ 'url' ];?>" target="<?php if( isset( $ch[ 'target' ] ) && 0 != $ch['target'] ) echo '_blank';?>"><?php echo $ch['name'];?></a>
			          		<?php } else if( isset( $ch[ 'relartid' ] ) && $ch[ 'relartid' ] ) { ?>
			          		<a data-aid="<?php if( isset( $ch[ 'relartid' ] ) ) echo $ch[ 'relartid' ]; ?>" data-category="<?php echo $ch['pid'];?>" href="<?php echo $ch[ 'url' ];?>" target="<?php if( isset( $ch[ 'target' ] ) && 0 != $ch['target'] ) echo '_blank';?>" class="_fcms_static_"><?php echo $ch['name'];?></a>
							<?php }else if( isset( $ch['relid'] ) && false == $ch['relid'] ){ ?>
							<a data-aid="<?php if( isset( $ch[ 'relartid' ] ) ) echo $ch[ 'relartid' ]; ?>" data-category="<?php echo $ch['pid'];?>" href="<?php echo $this->menu->getListLink(); ?>" target="<?php if( isset( $ch[ 'target' ] ) && 0 != $ch['target'] ) echo '_blank';?>" class="_fcms_static_"><?php echo $ch['name'];?></a>
							<?php } else if( isset( $ch['relid'] ) && false != $ch['relid'] ){?>
							<a data-aid="<?php if( isset( $ch[ 'relartid' ] ) ) echo $ch[ 'relartid' ]; ?>" data-category="<?php echo $ch['pid'];?>" href="<?php echo $this->menu->getListLink( 'artcate' , $ch[ 'relid'] );?>" target="<?php if( isset( $ch[ 'target' ] ) && 0 != $ch['target'] ) echo '_blank';?>" class="_fcms_static_"><?php echo $ch['name'];?></a>
							<?php } else if(  isset( $ch[ 'relartid' ] ) && $ch[ 'relartid' ]) {?>
							<a data-aid="<?php if( isset( $ch[ 'relartid' ] ) ) echo $ch[ 'relartid' ]; ?>" data-category="<?php echo $ch['pid'];?>" href="<?php echo $this->menu->getListLink();?>" target="<?php if( isset( $ch[ 'target' ] ) && 0 != $ch['target'] ) echo '_blank';?>" class="_fcms_static_"><?php echo $ch['name'];?></a>
							<?php } ?>
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
