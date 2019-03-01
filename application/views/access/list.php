<body class="skin-black">
	<script language="javascript">
		function updateOrder(){
			var frm = document.formAssignment;
			var answer = confirm('are you sure want to update order?');
			
			if(answer){
				frm.action = '<?php echo BASE_URL_BACKEND;?>/module/doOrder';
				frm.submit();
			} else {
				return false;
			}
		}
	</script>
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
					<small>User Level - List</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo BASE_URL_BACKEND;?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="<?php echo BASE_URL_BACKEND;?>/access">Access</a></li>
					<li class="active">List</li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
				  <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
								<div class="box-header">
                                    <h3 class="box-title">User Level - List</h3>
                                </div><!-- /.box-header -->
								<?php if(isset($error)){ ?>
								<div class="panel-body">
								  <div class="form-group has-error">
									  <label for="inputError" class="col-sm-2 control-label col-lg-2"><?php echo $error;?></label>
								  </div>
								</div>
								<?php } ?>
								<div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5">No</th>
                                                <th>User Level</th>
											    <th width="150">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<form name="formAssignment" method="POST" action="" onsubmit="return false;">
                                            <?php
											if(count($ListUserLevel) > 0){
											$no=0;
												foreach($ListUserLevel as $access){
													$no++;
											?>
											<tr>
												  <td><?php echo $no;?></td>
												  <td><?php echo $access['user_level_name'];?></td>
												  <td align="center">
													<a class="btn-warning btn-sm" title="Click to Privilege User Level Module" href="<?php echo BASE_URL_BACKEND;?>/access/listprivilege/<?php echo $access['user_level_id'];?>"><span class="glyphicon glyphicon-user"></span></a> &nbsp;									 
												  </td>
											  </tr>
											<tr>
											<?php } ?>
											<?php } else {?>
											<tr>
												<td align="center" colspan="10">Data Not Found</td>
											</tr>
											<?php } ?>
											</form>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
							</div>
						</div>
						<!-- page end-->
				  </div>
			</section>
			<!--main content end-->
		</aside><!-- /.right-side -->
	</div><!-- ./wrapper -->
		
	<!-- DATA TABES SCRIPT -->
	<script src="<?php echo JS_BASE_URL; ?>/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
	<script src="<?php echo JS_BASE_URL; ?>/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
	<!-- AdminLTE App -->
	<script src="<?php echo JS_BASE_URL; ?>/AdminLTE/app.js" type="text/javascript"></script>
	
	<script src="<?php echo JS_BASE_URL; ?>/functionGlobal.js" type="text/javascript"></script> 
</body>
</html>	