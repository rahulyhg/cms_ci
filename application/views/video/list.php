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
                                    <h3 class="box-title"><?php echo $breadcrump['module_name']; ?> - List</h3>
									<div class="col-xs-12">
										<?php if($add){ ?>
										<input class="btn btn-primary btn-sm" type="button" value="Add" onclick="window.location = '<?php echo BASE_URL_BACKEND;?>/video/add/'">
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
								
								<form class="form-inline" role="form" method="post" name="frmSearch" action="<?php echo BASE_URL_BACKEND."/video/view"; ?>">
									<div class="panel-body">
									 <div class="col-lg-10">
										  <div class="form-group">
											  <select name="searchby" id="search-by" size="1" class="form-control">
												<option value="">Choose a search</option>
												<option value="video_name" <?php if($searchby == "video_name") { echo "selected"; }?> >Name</option>
											</select>
										  </div>
										  <div class="form-group">
											  <input type="text" class="form-control" name="searchkey" placeholder="Keyword" value="<?php if(!empty($searchkey)){echo $searchkey;} ?>">
										  </div>
										  &nbsp;<input class="btn btn-primary btn-sm" name="tbSearch" type="submit" value="Search">&nbsp;&nbsp;<label>Total : <?php echo $total;?></label>
									</div>
									<div class="col-lg-2" align="right">
										<div class="form-group">
											<select name="perpage" id="perpage" size="1" aria-controls="editable-sample" class="form-control xsmall">
												<option value="<?php echo PER_PAGE;?>" <?php if($perpage == "50") { echo "selected"; }?>><?php echo PER_PAGE;?></option>
												<option value="100" <?php if($perpage == "100") { echo "selected"; }?>>100</option>
												<option value="200" <?php if($perpage == "200") { echo "selected"; }?>>200</option>
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
											   <th>Name</th>
											   <th>Video</th>
											   <th>Cover</th>
											   <th width="150">Action</th>
                                            </tr>
                                        </thead>
										<tbody>
                                            <?php
											if(count($ListQuestion) > 0){
											$no=0;
												foreach($ListQuestion as $article){
													$no++;
											?>
											<tr>
                                                  <td><?php echo $no;?></td>
												  <td><?php echo $article['video_name']; ?></td>
												  <td align="center">
												  <?php 
												  $videourl = BASE_URL.'/assets/upload/video/'. $article['video_file'];	
												  ?>
												  
												  <a href="<?php echo $videourl;?>" target="_blank">Open Video</a>
												  </td>
												  <td align="center">
												  <?php 
												  $coverurl = BASE_URL.'/assets/upload/video/'. $article['video_cover'];	
												  ?>
												  
												  <img src="<?php echo $coverurl;?>" width="100">
												  </td>
												  <td align="center">
													<?php if($edit){ ?>
														<a class="btn-primary btn-sm" title="Click to Edit" href="<?php echo BASE_URL_BACKEND;?>/video/edit/<?php echo $article['video_id'];?>"><span class="glyphicon glyphicon-pencil"></span></a> &nbsp; 
													<?php } ?>
													
													<?php if($delete){ ?>
														<a class="btn-danger btn-sm" title="Click to Delete" onclick="var answer = confirm('delete <?php echo $article['video_name'];?> ?'); if (answer){window.location = '<?php echo BASE_URL_BACKEND;?>/video/delete/<?php echo $article['video_id'];?>';}"><span class="glyphicon glyphicon-trash"></span></a> &nbsp;
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
								
								<?php echo($paging); ?>
							</div>
						</div>
						<!-- page end-->
				  </div>
			</section>
			<!--main content end-->
		</aside><!-- /.right-side -->
	</div><!-- ./wrapper -->
	
	<!-- AdminLTE App -->
	<script src="<?php echo JS_BASE_URL; ?>/AdminLTE/app.js" type="text/javascript"></script>
	
	<script src="<?php echo JS_BASE_URL; ?>/functionGlobal.js" type="text/javascript"></script> 
</body>
</html>