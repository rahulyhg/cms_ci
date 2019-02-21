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
									<div class="col-xs-12">
										<?php if($add){ ?>
											<input class="btn btn-primary btn-sm" type="button" value="Add" onclick="window.location = '<?php echo BASE_URL_BACKEND;?>/banner/add/'">
										<?php } ?>
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
											  <th width="150">Name</th>
											  <th width="120">Type</th>
											  <th width="80">Images</th>
											  <th width="120">URL</th>
											  <th width="80">Create Date</th>
											  <th width="120">Action</th>
										    </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											if(count($ListBanner) > 0){
											$no=0;
												foreach($ListBanner as $banner){
													$no++;
											?>
											<tr>
                                                  <td><?php echo $no;?></td>
												  <td><?php echo $banner['banner_name'];?></td>
												  <td>
												  <?php 
												  if($banner['banner_type']==1){
													echo "Home";
												  } else if($banner['banner_type']==2){
													echo "Pricing";
												  } else if($banner['banner_type']==3){
													echo "Service Retina";
												  } else if($banner['banner_type']==4){
													echo "Service Cataract";
												  } else if($banner['banner_type']==5){
													echo "Service LASIK";
												  } else if($banner['banner_type']==6){
													echo "Promo Cataract";
												  } else if($banner['banner_type']==7){
													echo "Promo LASIK";
												  } else if($banner['banner_type']==8){
													echo "Service Cost LASIK";
												  }
												  ?>
												  </td>
												  <td><?php 
													$banner_image_thumbs = BASE_URL.str_replace('/admin/images','/admin/.thumbs/images',$banner['banner_images']);
													$banner_image = BASE_URL.$banner['banner_images'];
													?>
													<a id="viewBackend" href="#viewDataImage<?php echo $banner['banner_id'];?>">
														<img src="<?php echo $banner_image_thumbs;?>">
													</a>
													<div style="display: none;">
														<div id="viewDataImage<?php echo $banner['banner_id'];?>">
															<img src="<?php echo $banner_image;?>" >
														</div>
													</div>
													</td>
													<td><?php echo $banner['banner_url'];?></td>
													<td><?php echo $banner['banner_create_date'];?></td>
													<td align="center">
														<?php if($publish){ ?>
															<?php if($banner['banner_active_status'] == 1) {?>
																<a class="btn-success btn-sm" title="Click to Inactive" href="<?php echo BASE_URL_BACKEND."/banner/active/".$banner['banner_id'];?>"><span class="glyphicon glyphicon-ok"></span></a> &nbsp; 
															<?php } else { ?>
																<a class="btn-danger btn-sm" title="Click to Active" href="<?php echo BASE_URL_BACKEND."/banner/active/".$banner['banner_id'];?>"><span class="glyphicon glyphicon-remove"></a> &nbsp;
															<?php } ?>
														<?php } ?>
														<?php if($edit){ ?>
															<a class="btn-primary btn-sm" title="Click to Edit" href="<?php echo BASE_URL_BACKEND;?>/banner/edit/<?php echo $banner['banner_id'];?>"><span class="glyphicon glyphicon-pencil"></span></a> &nbsp; 
														<?php } ?>
														<?php if($delete){ ?>
															<a class="btn-danger btn-sm" title="Click to Delete" onclick="var answer = confirm('delete <?php echo $banner['banner_name'];?> ?'); if (answer){window.location = '<?php echo BASE_URL_BACKEND;?>/banner/delete/<?php echo $banner['banner_id'];?>';}"><span class="glyphicon glyphicon-trash"></span></a> &nbsp;
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
	
	<!-- fancybox -->
	<script src="<?php echo TOOLS_BASE_URL; ?>/fancybox/source/jquery.fancybox.js"></script>
	<link href="<?php echo TOOLS_BASE_URL; ?>/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
	<script type="text/javascript">
	$(function() {
		//fancybox
		jQuery("a#viewBackend").fancybox({
			'overlayShow'		: true,
			'transitionIn'		: 'elastic',
			'transitionOut'		: 'elastic',
			'width'				: '100%',
			'height'			: '100%'
		});
	});
	</script>
	<!-- end fancybox -->

	<!-- page script -->
	<script type="text/javascript">
		<?php if(count($ListBanner) > 0){ ?>
		$(function() {
			$("#example1").dataTable({
				"iDisplayLength" : <?php echo PER_PAGE; ?>,
				"aLengthMenu": [[50, 100, 200], [50, 100, 200]],
				"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0, 2, 3, 4, 6 ] } ], 
			});
		});
		<?php } ?>
	</script>
</body>
</html>