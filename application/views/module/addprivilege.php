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
					Access 
					<small>Module - Add Privilege</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo BASE_URL_BACKEND;?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="<?php echo BASE_URL_BACKEND;?>/module">Module</a></li>
					<li class="active">Add Privilege</li>
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
										  Module - Add Privilege
									  </header>
									  <div class="panel-body">
										  <form name="form1" action="<?php echo BASE_URL_BACKEND.'/module/doAddmoduleprivilege'; ?>" method="post" class="form-horizontal" role="form">
										  <?php if(isset($error)){ ?>
										  <div class="form-group has-error">
											  <div class="col-lg-12">
												<label for="inputError" class="control-label"><?php echo $error;?></label>
											  </div>
										  </div>
										  <?php } ?>
										  <div class="form-group">
											  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Module Name</label>
											  <div class="col-lg-4">
												  <input name="modulename" readonly type="text" class="form-control" placeholder="Module Name" value="<?php echo $modulename;?>">
												  <input name="moduleid" type="hidden" value="<?php echo $id;?>">
											  </div>
										  </div>
										  <div class="form-group ">
											  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Privilege Name</label>
											  <div class="col-lg-10">
												  <?php foreach($ListPrivilege as $privilege){ ?>
												  <label class="checkbox-inline">
													  <input type="checkbox" name="privilegeid[]" id="inlineCheckbox1" value="<?php echo $privilege['privilege_id'];?>">&nbsp;<?php echo $privilege['privilege_name'];?>
												  </label><br>
												  <?php } ?>
											  </div>
										  </div>
										  <div class="form-module">
											  <div class="col-lg-offset-2 col-lg-10">
												  <input name="tbSave" class="btn btn-info btn-sm" type="submit" value="Save">&nbsp;
												  <input name="cancel" class="btn btn-info btn-sm" type="button" value="Cancel" onClick="location.href='<?php echo BASE_URL_BACKEND.'/module/listmoduleprivilege/'.$id; ?>'">
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
		
	<!-- Morris.js charts -->
	<script src="<?php echo JS_BASE_URL; ?>/raphael-min.js"></script>
	<script src="<?php echo JS_BASE_URL; ?>/plugins/morris/morris.min.js" type="text/javascript"></script>
	<!-- Sparkline -->
	<script src="<?php echo JS_BASE_URL; ?>/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
	<!-- jvectormap -->
	<script src="<?php echo JS_BASE_URL; ?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
	<script src="<?php echo JS_BASE_URL; ?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
	<!-- fullCalendar -->
	<script src="<?php echo JS_BASE_URL; ?>/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
	<!-- jQuery Knob Chart -->
	<script src="<?php echo JS_BASE_URL; ?>/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
	<!-- daterangepicker -->
	<script src="<?php echo JS_BASE_URL; ?>/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script src="<?php echo JS_BASE_URL; ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
	<!-- iCheck -->
	<script src="<?php echo JS_BASE_URL; ?>/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
	
	<!-- AdminLTE App -->
	<script src="<?php echo JS_BASE_URL; ?>/AdminLTE/app.js" type="text/javascript"></script>
	
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="<?php echo JS_BASE_URL; ?>/AdminLTE/dashboard.js" type="text/javascript"></script>
	
	<script src="<?php echo JS_BASE_URL; ?>/functionGlobal.js" type="text/javascript"></script> 
</body>
</html>	