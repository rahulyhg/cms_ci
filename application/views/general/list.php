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
					<?php echo $breadcrump['module_group_name']; ?> 
					<small><?php echo $breadcrump['module_name']; ?> - List</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo BASE_URL_BACKEND;?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="<?php echo BASE_URL_BACKEND;?>/<?php echo $breadcrump['module_path']; ?>"><?php echo $breadcrump['module_name']; ?></a></li>
					<li class="active">List</li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
				  <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
								<div class="box-header">
                                    <h3 class="box-title"><?php echo $breadcrump['module_group_name']; ?> - <?php echo $breadcrump['module_name']; ?> - List</h3>
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
                                                 <th>Meta Title</th>
											     <th>Meta Description</th>
											     <th>Meta Keywords</th>
											     <th width="150">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											if(count($ListGeneral) > 0){
											$no=0;
												foreach($ListGeneral as $general){
													$no++;
											?>
											<tr>
                                                  <td><?php echo $no;?></td>
												  <td><?php echo $general['general_title'];?></td>
												  <td><?php echo $general['general_description'];?></td>
												  <td><?php echo $general['general_keyword'];?></td>
												  <td align="center">
													<?php if($edit){?>
														<a class="btn-primary btn-sm" title="Click to Edit" href="<?php echo BASE_URL_BACKEND;?>/general/edit/<?php echo $general['general_id'];?>"><span class="glyphicon glyphicon-pencil"></span></a> &nbsp; 
													<?php } ?>
												  </td>
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
	
	<!-- page script -->
	<script type="text/javascript">
		<?php if(count($ListGeneral) > 0){ ?>
		$(function() {
			$("#example1").dataTable({
				"iDisplayLength" : <?php echo PER_PAGE; ?>,
				"aLengthMenu": [[50, 100, 200], [50, 100, 200]],
				"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0, 4 ] } ], 
			});
		});
		<?php } ?>
	</script>
</body>
</html>