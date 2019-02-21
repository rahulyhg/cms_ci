<header class="header">
	<a href="<?php echo BASE_URL_BACKEND; ?>" class="logo">
		<!--<img src="<?php echo IMAGES_BASE_URL;?>/logo_picmix.png" alt="logo" width="100">-->
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button-->
		<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		<div class="navbar-right">
			<ul class="nav navbar-nav">
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="glyphicon glyphicon-user"></i>
						<span><?php echo $admin_data['user_name'];?> <i class="caret"></i></span>
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header bg-light-blue">
							<?php if($_SESSION['admin_data']['user_level_id']==8) { ?>
								<img src="<?php echo $_SESSION['admin_data']['user_avatar'];?>" class="img-circle" alt="User Image" />
							<?php } else { ?>
								<?php if(!empty($_SESSION['admin_data']['user_avatar'])) { ?>
									<img src="<?php echo BASE_URL."/assets/upload/avatar/".$_SESSION['admin_data']['user_avatar'];?>" class="img-circle" alt="User Image" />
								<?php } else { ?>
									<img src="<?php echo BASE_URL."/assets/upload/avatar/profile.png";?>" class="img-circle" alt="User Image" />
								<?php } ?>
							<?php } ?>
							<p>
								<?php echo $admin_data['user_name'];?> - <?php echo $admin_data['user_level_name'];?>
								<small>Registered since <?php echo $admin_data['user_create_date'];?></small>
							</p>
						</li>
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left">
								<?php if($_SESSION['admin_data']['user_level_id']==8) { ?>
									<a href="<?php echo BASE_URL_BACKEND; ?>/partner_profile/changeProfile" class="btn btn-default btn-flat">Profile</a>
									<a href="<?php echo BASE_URL_BACKEND; ?>/partner_profile/changePassword" class="btn btn-default btn-flat">Password</a>
								<?php } else { ?>
									<a href="<?php echo BASE_URL_BACKEND; ?>/changeProfile" class="btn btn-default btn-flat">Profile</a>
									<a href="<?php echo BASE_URL_BACKEND; ?>/changePassword" class="btn btn-default btn-flat">Password</a>
								<?php } ?>
							</div>
							<div class="pull-right">
								<a href="<?php echo BASE_URL_BACKEND; ?>/signout" class="btn btn-default btn-flat">Sign out</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>
