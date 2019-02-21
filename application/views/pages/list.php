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
											<input class="btn btn-primary btn-sm" type="button" value="Add" onclick="window.location = '<?php echo BASE_URL_BACKEND;?>/pages/add/'">
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

								<form class="form-inline" role="form" method="post" name="frmSearch" action="<?php echo BASE_URL_BACKEND."/pages/view"; ?>">
								  <div class="panel-body">
									 <div class="col-lg-10">
										  <div class="form-group">
											  <select name="searchby" id="search-by" size="1" class="form-control">
												<option value="">Choose a search</option>
												<option value="pages_title" <?php if($searchby == "pages_title") { echo "selected"; }?> >Pages Title</option>
												<option value="pages_short_desc" <?php if($searchby == "pages_desc") { echo "selected"; }?> >Pages Description</option>
											</select>
										  </div>
										  <div class="form-group">
											  <input type="text" class="form-control" name="searchkey" placeholder="Keyword" value="<?php if(!empty($searchkey)){echo $searchkey;} ?>">
										  </div>
										  &nbsp;<input class="btn btn-success btn-sm" name="tbSearch" type="submit" value="Search">&nbsp;&nbsp;<label>Total : <?php echo $total;?></label>
									</div>
									<div class="col-lg-2" align="right">
										<div class="form-group">
											<select name="perpage" id="perpage" size="1" aria-controls="editable-sample" class="form-control xsmall">
												<option value="<?php echo PER_PAGE;?>" <?php if($perpage == "50") { echo "selected"; }?>>50</option>
												<option value="100" <?php if($perpage == "100") { echo "selected"; }?>>100</option>
												<option value="200" <?php if($perpage == "200") { echo "selected"; }?>>100</option>
											</select> 
										</div>
									</div>
								  </div>
								</form>

								<div class="box-body table-responsive">
                                    <form name="formAssignment" method="POST" action="" onsubmit="return false;">
									<table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
											  <th width="5">No</th>
											  <th>Pages Title</th>
											  <th>Pages URL</th>
											  <th>Pages Images</th>
											  <th>Create Date</th>
											  <th width="140">Action</th>
										    </tr>
                                        </thead>
                                        <tbody>
                                            <?php
												if(count($ListPages) > 0){
												$no=0;
												foreach($ListPages as $pages){
													$no++;
											?>
											<tr>
                                                  <td><?php echo $no;?></td>
												  <td><?php echo $pages['pages_title'];?></td>
												  <td width="15">
													<?php echo BASE_URL."/".generateAlias($pages['pages_title'])?>
												  </td>
												  <td><?php 
													if(!empty($pages['pages_image'])){
													$pages_image_thumbs = BASE_URL.str_replace('/admin/images','/admin/.thumbs/images',$pages['pages_image']);
													$pages_image = BASE_URL.$pages['pages_image'];
													?>
													<a id="viewBackend" href="#viewDataImage<?php echo $pages['pages_id'];?>">
														<img src="<?php echo $pages_image_thumbs;?>">
													</a>
													<div style="display: none;">
														<div id="viewDataImage<?php echo $pages['pages_id'];?>">
															<img src="<?php echo $pages_image;?>" >
														</div>
													</div>
													<?php } ?>
												  </td>
												  <td><?php echo $pages['pages_create_date'];?></td>
												  <td>
													<?php if($publish){ ?>
														<?php if($pages['pages_active_status'] == 1) {?>
															<a class="btn-success btn-sm" title="Click to Inactive" href="<?php echo BASE_URL_BACKEND."/pages/active/".$pages['pages_id'];?>"><span class="glyphicon glyphicon-ok"></span></a> &nbsp; 
														<?php } else { ?>
															<a class="btn-danger btn-sm" title="Click to Active" href="<?php echo BASE_URL_BACKEND."/pages/active/".$pages['pages_id'];?>"><span class="glyphicon glyphicon-remove"></span></a> &nbsp;
														<?php } ?>
													<?php } ?>
													
													<?php if($edit){ ?>
														<a class="btn-primary btn-sm" title="Click to Edit" href="<?php echo BASE_URL_BACKEND;?>/pages/edit/<?php echo $pages['pages_id'];?>"><span class="glyphicon glyphicon-pencil"></span></a> &nbsp; 
													<?php } ?>
													
													<?php if($delete){ ?>
														<a class="btn-danger btn-sm" title="Click to Delete" onclick="var answer = confirm('delete <?php echo $pages['pages_title'];?> ?'); if (answer){window.location = '<?php echo BASE_URL_BACKEND;?>/pages/delete/<?php echo $pages['pages_id'];?>';}"><span class="glyphicon glyphicon-trash"></span></a> &nbsp;
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
									</form>
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
	
	<script language="javascript">
	$(document).ready(function() {
		$("#perpage").change(function() {
			var n = $(this).val();
			frmSearch.submit();
		});
	});
	</script>
</body>
</html	