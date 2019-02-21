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
					<small><?php echo $breadcrump['module_name']; ?> - Edit</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo BASE_URL_BACKEND;?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="<?php echo BASE_URL_BACKEND;?>/<?php echo $breadcrump['module_path']; ?>"><?php echo $breadcrump['module_name']; ?></a></li>
					<li class="active">Edit</li>
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
										  <h3 class="box-title"><?php echo $breadcrump['module_group_name']; ?> - <?php echo $breadcrump['module_name']; ?> - Edit</h3>
									  </header>
									  <div class="panel-body">
										  <form name="form1" action="<?php echo BASE_URL_BACKEND.'/banner/doEdit/'.$rsBanner[0]['banner_id']; ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
											  <?php if(isset($error)){ ?>
											  <div class="form-group has-error">
												  <div class="col-lg-12">
													<label for="inputError" class="control-label"><?php echo $error;?></label>
												  </div>
											  </div>
											  <?php } ?>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Banner Title</label>
												  <div class="col-lg-4">
													  <input name="bannername" type="text" class="form-control" placeholder="Banner Name" value="<?php echo $rsBanner[0]['banner_name']; ?>">
													  <input name="bannernameOld" type="hidden" value="<?php echo $rsBanner[0]['banner_name']; ?>">
												 </div>
											  </div>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Banner Type</label>
												  <div class="col-lg-4">
													  <select name="bannertype" id="bannertypeid" class="form-control" style="width:auto;">
														<option value="0">Choose a banner type</option>
														<option value="1" <?php if($rsBanner[0]['banner_type'] == 1) { echo "selected"; }?>>Home</option>
														<p class="help-block" style="color:#00F;">width and height optimal is 791px x 322px (Home)</p>
													  </select>
												  </div>
											  </div>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Banner Images</label>
												  <?php
													$banner_image_thumbs = BASE_URL.str_replace('/admin/images','/admin/.thumbs/images',$rsBanner[0]['banner_images']);
													$banner_image = BASE_URL.$rsBanner[0]['banner_images'];
													?>
												  <div class="col-lg-4">
													  <div style="margin-bottom:10px;" class="imageurl"><img src="<?php echo $banner_image; ?>" style="max-width:400px; padding:5px; border:solid 1px #ccc;"></div>
													  <input type="text" name="bannersimageurl" readonly="readonly" id="imageurl" class="form-control" value="<?php echo $banner_image ?>">
													  <div style="margin-right:10px;">
															<a onClick="openKCFinder('imageurl');" id="link-file" class="link">Browse</a>
															<a onClick="reset_value('imageurl');" id="link-file" class="link">Reset</a>
													  </div>
													  <p class="help-block" style="color:#00F;">width and height optimal is 960px x 385px (Home)</p>
												  </div>
											  </div>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Banner URL</label>
												  <div class="col-lg-4">
													  <input name="bannerurl" type="text" class="form-control" placeholder="Banner URL" value="<?php echo $rsBanner[0]['banner_url']; ?>">
												 </div>
											  </div>
											  <div class="form-group">
												  <div class="col-lg-offset-2 col-lg-10">
													  <input name="tbEdit" class="btn btn-info btn-sm" type="submit" value="Save">&nbsp;
													  <input name="cancel" class="btn btn-info btn-sm" type="button" value="Cancel" onClick="location.href='<?php echo BASE_URL_BACKEND.'/banner'; ?>'">
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
	
	<script src="<?php echo JS_BASE_URL; ?>/functionGlobal.js" type="text/javascript"></script>

</body>
</html>