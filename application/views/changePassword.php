<body class="skin-black">
	<?php include VIEWS_PATH_BACKEND."/menu.php"; ?>
	
	<div class="wrapper row-offcanvas row-offcanvas-left">
		<!-- Left side column. contains the logo and sidebar -->
		<?php include VIEWS_PATH_BACKEND."/leftMenu.php"; ?>

		<!-- Right side column. Contains the navbar and content of the page -->
		<aside class="right-side">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Change Password 
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo BASE_URL_BACKEND;?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Change Password</li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
				  <section class="wrapper">
					  <!-- page start-->
					  <div class="row ">
						  <div class="col-lg-12">
							  <div class="box box-primary">
								  <section class="panel">
									  <header class="panel-heading">
										  Change Password
									  </header>
									  <div class="panel-body">
										  <form name="formchangepassword" action="<?php echo BASE_URL_BACKEND.'/doChangePassword'; ?>" method="post" class="form-horizontal" role="form">
											  <?php if(isset($error)){ ?>
											  <div class="form-group has-error">
												  <div class="col-lg-12">
													<label for="inputError" class="control-label"><?php echo $error;?></label>
												  </div>
											  </div>
											  <?php } ?>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Old Password</label>
												  <div class="col-lg-4">
													  <input name="oldpassword" type="password" class="form-control" placeholder="Old Password">
												  </div>
											  </div>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">New Password</label>
												  <div class="col-lg-4">
													  <input name="newpassword" type="password" class="form-control" placeholder="New Password">
												  </div>
											  </div>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Retype Password</label>
												  <div class="col-lg-4">
													  <input name="retypenewpassword" type="password" class="form-control" placeholder="Retype Password">
												  </div>
											  </div>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">&nbsp;</label>
												  <div class="col-lg-4">
													  <span id="captcha"><?php echo $captcha;?></span> <a class="btn btn-sm" title="Refresh Security Code" id="refresh"><i class="icon-refresh"></i></a>
												  </div>
											  </div>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Security Code</label>
												  <div class="col-lg-4">
													  <input name="capctha" type="text" class="form-control" placeholder="Security Code">
												  </div>
											  </div>
											  <div class="form-group">
												  <div class="col-lg-offset-2 col-lg-10">
													  <input name="tbSave" class="btn btn-info btn-sm" type="submit" value="Save">&nbsp;
													  <input name="cancel" class="btn btn-info btn-sm" type="button" value="Cancel" onClick="location.href='<?php echo BASE_URL_BACKEND.'/home'; ?>'">
												  </div>
											  </div>
										  </form>
									  </div>
								  </section>
							  </div>  
						  </div>
					  </div>
					  <!-- page end-->
				  </section>
			</section>
			<!--main content end-->
		</aside><!-- /.right-side -->
	</div><!-- ./wrapper -->
		
	<!-- AdminLTE App -->
	<script src="<?php echo JS_BASE_URL; ?>/AdminLTE/app.js" type="text/javascript"></script>
	
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="<?php echo JS_BASE_URL; ?>/AdminLTE/dashboard.js" type="text/javascript"></script>
	
	<script src="<?php echo JS_BASE_URL; ?>/functionGlobal.js" type="text/javascript"></script> 
</body>
</html>