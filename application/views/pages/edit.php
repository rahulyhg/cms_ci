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
										  <form name="form1" action="<?php echo BASE_URL_BACKEND.'/pages/doEdit/'.$rsPages[0]['pages_id']; ?>" method="post" class="form-horizontal" role="form">
											  <?php if(isset($error)){ ?>
											  <div class="form-group has-error">
												  <div class="col-lg-12">
													<label for="inputError" class="control-label"><?php echo $error;?></label>
												  </div>
											  </div>
											  <?php } ?>

											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Pages Title</label>
												  <div class="col-lg-4">
													  <input name="pagestitle" type="text" class="form-control" placeholder="Pages Title" value="<?php echo $rsPages[0]['pages_title']; ?>">
													  <input name="pagestitleOld" type="hidden" value="<?php echo $rsPages[0]['pages_title']; ?>">
												 </div>
											  </div>
											  <div class="form-group">
												  <label for="inputDescription" class="col-lg-2 col-sm-2 control-label">Pages Short Description</label>
												  <div class="col-lg-10">
													  <textarea id="IDpagesshortdesc" name="pagesshortdesc" class="form-control" placeholder="Pages Short Description" rows="4"><?php echo $rsPages[0]['pages_short_desc']; ?></textarea>
													  <script>
															CKEDITOR.replace( 'IDpagesshortdesc', {
																toolbar: [
																	{ name: 'document', items : [ 'Source'] },
																	{ name: 'insert', items : [ 'Table','HorizontalRule','SpecialChar','PageBreak'] },
																	{ name: 'colors',      items : [ 'TextColor','BGColor' ] },
																	{ name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
																	{ name: 'paragraph', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', '-', 'NumberedList','BulletedList'] },
																 ],
																width : 900,
																height: 200
															});
														</script>
												 </div>
											  </div>
											  <div class="form-group">
												  <label for="inputDescription" class="col-lg-2 col-sm-2 control-label">Pages Description</label>
												  <div class="col-lg-10">
													  <textarea id="IDpagesdesc" name="pagesdesc" class="form-control ckeditor" placeholder="Pages Description" rows="7"><?php echo $rsPages[0]['pages_desc']; ?></textarea>
														<script>
															CKEDITOR.replace( 'IDpagesdesc', {
																toolbar: [
																	{ name: 'document', items : [ 'Source'] },
																	{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
																	{ name: 'insert', items : [ 'Image','Table','HorizontalRule','SpecialChar','PageBreak'] },'/',
																	{ name: 'styles', items : [ 'Styles','Format' ] },
																	{ name: 'colors',      items : [ 'TextColor','BGColor' ] },
																	{ name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
																	{ name: 'paragraph', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', '-', 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote' ] },
																 ],
																width : 900,
																height: 300,
																contentsCss : ["<?php echo CSS_BASE_URL;?>/style.css"]
															});
														</script>
												  </div>
											  </div>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Pages Images</label>
												  <?php
													$pages_image_thumbs = BASE_URL.str_replace('/admin/images','/admin/.thumbs/images',$rsPages[0]['pages_image']);
													if(!empty($rsPages[0]['pages_image'])){
														$pages_image = BASE_URL.$rsPages[0]['pages_image'];
													} else {
														$pages_image = "";
													}
													?>
												  <div class="col-lg-4">
													  <div style="margin-bottom:10px;" class="imageurl"><?php if(!empty($rsPages[0]['pages_image'])){ ?><img src="<?php echo $pages_image; ?>" style="max-width:400px; padding:5px; border:solid 1px #ccc;"><?php } ?></div>
													  <input type="text" name="pagesimageurl" readonly="readonly" id="imageurl" class="form-control" value="<?php echo $pages_image ?>">
													  <p class="help-block">width and height optimal is 400px x 400px</p>
													  <div style="margin-right:10px;">
															<a onClick="openKCFinder('imageurl');" id="link-file" class="link">Browse</a>
															<a onClick="reset_value('imageurl');" id="link-file" class="link">Reset</a>
														</div>
												  </div>
											  </div>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Pages Alias URL</label>
												  <div class="col-lg-4">
													  <input name="pagesalias" type="text" class="form-control" placeholder="Pages Alias" value="<?php echo $rsPages[0]['pages_alias']; ?>">
													  <input name="newsaliasOld" type="hidden" value="<?php echo $rsPages[0]['pages_alias']; ?>">
												 </div>
											  </div>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Pages Meta Description</label>
												  <div class="col-lg-4">
													  <input name="pagesmetadescription" type="text" class="form-control" placeholder="Pages Meta Description" value="<?php echo $rsPages[0]['pages_meta_description']; ?>">
												 </div>
											  </div>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Pages Meta Keywords</label>
												  <div class="col-lg-4">
													  <input name="pagesmetakeywords" type="text" class="form-control" placeholder="Pages Meta Keywords" value="<?php echo $rsPages[0]['pages_meta_keywords']; ?>">
												 </div>
											  </div>
											  <div class="form-group">
												  <div class="col-lg-offset-2 col-lg-10">
													  <input name="tbEdit" class="btn btn-info btn-sm" type="submit" value="Save">&nbsp;
													  <input name="cancel" class="btn btn-info btn-sm" type="button" value="Cancel" onClick="location.href='<?php echo BASE_URL_BACKEND.'/pages'; ?>'">
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
</html	