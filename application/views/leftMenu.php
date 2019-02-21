<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="image" align="center">
				<?php if($_SESSION['admin_data']['user_level_id']==8) { ?>
					<img src="<?php echo $_SESSION['admin_data']['user_avatar'];?>" class="img-circle" alt="User Image" />
				<?php } else { ?>
					<?php if(!empty($_SESSION['admin_data']['user_avatar'])) { ?>
						<img src="<?php echo BASE_URL."/assets/upload/avatar/".$_SESSION['admin_data']['user_avatar'];?>" class="img-circle" alt="User Image" />
					<?php } else { ?>
						<img src="<?php echo BASE_URL."/assets/upload/avatar/profile.png";?>" class="img-circle" alt="User Image" />
					<?php } ?>
				<?php } ?>	
			</div>
			<div class="info" align="center">
				<p><?php echo $admin_data['user_name'];?></p>
			</div>
		</div>

		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="active">
				<a href="<?php echo BASE_URL_BACKEND; ?>/home">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			<?php if($_SESSION['admin_data']['user_level_id'] == 1) {?>
			<li class="treeview <?php if($section == 'access'){echo 'active"'; }?>">
				<a href="#">
					<i class="fa fa-laptop"></i>
					<span>Access</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li <?php if($modul_id == '3'){ echo ' class="active"'; } ?>><a href="<?php echo BASE_URL_BACKEND; ?>/userlevel"><i class="fa fa-angle-double-right"></i> User Level</a></li>
					<li <?php if($modul_id == '2'){ echo ' class="active"'; } ?>><a href="<?php echo BASE_URL_BACKEND; ?>/user"><i class="fa fa-angle-double-right"></i> User</a></li>
					<li <?php if($modul_id == '4'){ echo ' class="active"'; } ?>><a href="<?php echo BASE_URL_BACKEND; ?>/module_group"><i class="fa fa-angle-double-right"></i> Module Group</a></li>
					<li <?php if($modul_id == '5'){ echo ' class="active"'; } ?>><a href="<?php echo BASE_URL_BACKEND; ?>/module"><i class="fa fa-angle-double-right"></i> Module</a></li>
					<li <?php if($modul_id == '6'){ echo ' class="active"'; } ?>><a href="<?php echo BASE_URL_BACKEND; ?>/access"><i class="fa fa-angle-double-right"></i> Access</a></li>
					<li <?php if($modul_id == '7'){ echo ' class="active"'; } ?>><a href="<?php echo BASE_URL_BACKEND; ?>/log_cms"><i class="fa fa-angle-double-right"></i> Logs</a></li>
				</ul>
			</li>
			<?php } ?>
			
			<?php if(count($ListMenu) > 0) { ?>
			<?php foreach($ListMenu as $menu){ ?>
			<li class="treeview <?php if($section != $menu['module_group_id']){echo ''; } else {echo 'active'; }?>">
				<a href="#">
					<i class="fa fa-folder"></i>
					<span><?php echo $menu['module_group_name'];?></span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<?php if(count($menu['module']) > 0) { ?>
				<ul class="treeview-menu">
					<?php foreach($menu['module'] as $module){ ?>
					<?php if($module['access_privilege_status'] == 1){?>
						<li <?php if($modul_id == $module['module_id']){ echo 'class="active"'; } ?>><a href="<?php echo BASE_URL_BACKEND; ?>/<?php echo $module['module_path']?>"><i class="fa fa-angle-double-right"></i> <?php echo $module['module_name']?></a></li>
					<?php } ?>
					<?php } ?>
				</ul>
				<?php } ?>
			</li>
			<?php } ?>
			<?php } ?>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>