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
					<small>Module Privilege User Level - List</small>
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
                                    <h3 class="box-title">Module Privilege User Level - List</h3>
									<div class="col-xs-12">
										<input class="btn btn-primary btn-sm" type="button" value="Add" onclick="window.location = '<?php echo BASE_URL_BACKEND;?>/access/newprivilege/<?php echo $id;?>'">
										<input class="btn btn-primary btn-sm" type="button" value="Back" onclick="window.location = '<?php echo BASE_URL_BACKEND;?>/access/'">
									</div>
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
                                                <th>Module Name</th>
												<?php
											   foreach($ListPrivilege as $privilege){
													echo "<th align=\"center\">".$privilege['privilege_name']."</th>";
											   }
											   ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											if(count($ListAccessModule) > 0){
											$no=0;
												foreach($ListAccessModule as $accessmodule){
													$no++;
											?>
											<tr>
                                                  <td><?php echo $no;?></td>
												  <td><?php echo $accessmodule['module_group_name']." - ".$accessmodule['module_name'];?></td>
												  <?php
													foreach($accessmodule['access'] as $access){
														echo "<td align=\"center\">";
														if($access['is_privilege'] == 1) {
															if($access['access_privilege_status'] == 1) {?>
																<a class="btn-success btn-sm" href="<?php echo BASE_URL_BACKEND."/access/active/".$access['access_privilege_id']."/".$id;?>"><span class="glyphicon glyphicon-ok"></span></a> &nbsp; 
															<?php } else { ?>
																<a class="btn-danger btn-sm" href="<?php echo BASE_URL_BACKEND."/access/active/".$access['access_privilege_id']."/".$id;?>"><span class="glyphicon glyphicon-remove"></span></a> &nbsp;
															<?php }
														} else {
															echo "&nbsp;";
														}
														echo "</td>";
													}
												 ?>
                                            </tr>
											<?php } ?>
											<?php } else {?>
											<tr>
												<td align="center" colspan="10">Data Not Found</td>
											</tr>
											<?php } ?>
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
</html	