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
					<small><?php echo $breadcrump['module_name']; ?> - Add</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo BASE_URL_BACKEND;?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="<?php echo BASE_URL_BACKEND;?>/<?php echo $breadcrump['module_path']; ?>"><?php echo $breadcrump['module_name']; ?></a></li>
					<li class="active">Add</li>
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
										  <h3 class="box-title"><?php echo $breadcrump['module_name']; ?> - Add</h3>
									  </header>
									  <div class="panel-body">
										  <form name="form1" action="<?php echo BASE_URL_BACKEND.'/video/doAdd'; ?>" method="POST" class="form-horizontal" enctype="multipart/form-data">
										  <!--<form name="form1" id="myForm" action="" method="POST" class="form-horizontal" enctype="multipart/form-data">-->
											  <?php if(isset($error)){ ?>
											  <div class="form-group has-error">
												  <div class="col-lg-12">
													<label for="inputError" class="control-label"><?php echo $error;?></label>
												  </div>
											  </div>
											  <?php } ?>
											  <div class="form-group has-error" id="divError" style="display:none;">
												  <div class="col-lg-12">
													<label for="inputError" class="control-label" id="msgErr"></label>
												  </div>
											  </div>
											  
											  <div class="form-group">
												  <label for="inputDescription" class="col-lg-2 col-sm-2 control-label">Name</label>
												  <div class="col-lg-6">
													  <input name="name" id="IDname" type="text" class="form-control" placeholder="Name" value="<?php if(!empty($name)){echo $name;} ?>" autocomplete="off">
												  </div>
											  </div>
											  <div class="form-group">
												<label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Video File</label>
												<div class="col-lg-6">
													<div class="input-group">
														<label class="input-group-btn">
															<span class="btn btn-warning btn-md">
																Browse&hellip; <input type="file" id="video" accept=".mp4" name="video" style="display: none;">
															</span>
														</label>
														<input type="text" class="form-control input-md" readonly>
													</div>	
												</div>
											  </div>
											  <div class="form-group">
												<label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Cover File</label>
												<div class="col-lg-6">
													<div class="input-group">
														<label class="input-group-btn">
															<span class="btn btn-warning btn-md">
																Browse&hellip; <input type="file" id="cover" accept=".jpg, .jpeg" name="cover" style="display: none;">
															</span>
														</label>
														<input type="text" class="form-control input-md" readonly>
													</div>	
												</div>
											  </div>
											  <div class="progress" style="display:none">
													<div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
														<span class="sr-only">0%</span>
													</div>
											  </div>
											  <div class="form-group">
												  <div class="col-lg-offset-2 col-lg-10">
													  <input name="tbSave" class="btn btn-info btn-sm" type="submit" value="Save">&nbsp;
													  <!--<input name="tbSave" class="btn btn-info btn-sm" type="submit" value="Save" id="btnSave">&nbsp;-->
													  <input name="cancel" class="btn btn-info btn-sm" type="button" value="Cancel" onClick="location.href='<?php echo BASE_URL_BACKEND.'/video'; ?>'">
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
	
	<style>
	.progress-bar {
	  float: left;
	  width: 0;
	  height: 100%;
	  font-size: 12px;
	  line-height: 20px;
	  color: #fff;
	  text-align: center;
	  background-color: #337ab7;
	  -webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
			  box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
	  -webkit-transition: width .6s ease;
		   -o-transition: width .6s ease;
			  transition: width .6s ease;
	}
	.progress-striped .progress-bar,
	.progress-bar-striped {
	  background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
	  background-image:      -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
	  background-image:         linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
	  -webkit-background-size: 40px 40px;
			  background-size: 40px 40px;
	}
	.progress.active .progress-bar,
	.progress-bar.active {
	  -webkit-animation: progress-bar-stripes 2s linear infinite;
		   -o-animation: progress-bar-stripes 2s linear infinite;
			  animation: progress-bar-stripes 2s linear infinite;
	}
	</style>
	
	<!-- page script -->
	<script type="text/javascript">
		$(function() {
			$(document).on('change', ':file', function() {
				var input = $(this),
					numFiles = input.get(0).files ? input.get(0).files.length : 1,
					label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
				input.trigger('fileselect', [numFiles, label]);
			});
		});
		
		$(document).ready(function() {
			$(':file').on('fileselect', function(event, numFiles, label) {
				var input = $(this).parents('.form-group').find(':text'), log = numFiles > 1 ? numFiles + ' files selected' : label;

				if( input.length ) {
					input.val(log);
				} else {
					if( log ) alert(log);
				}
			});
			
			$('#myForm').on('submit', function(event){
				event.preventDefault();
				
				$('#btnSave').attr('disabled','disabled');

				var formData = new FormData($('form')[0]);

				$.ajax({
					xhr : function() {
						var xhr = new window.XMLHttpRequest();
						xhr.upload.addEventListener('progress', function(e){
							if(e.lengthComputable){
								console.log('Bytes Loaded : ' + e.loaded);
								console.log('Total Size : ' + e.total);
								console.log('Persen : ' + (e.loaded / e.total));
								
								var percent = Math.round((e.loaded / e.total) * 100);
								
								$('#progressBar').attr('aria-valuenow', percent).css('width', percent + '%').text(percent + '%');
							}
						});
						return xhr;
					},
					type : 'POST',
					url : '<?php echo BASE_URL?>/video/doAddAjax',
					data : formData,
					dataType: 'json',
					processData : false,
					contentType : false,
					beforeSend: function ( xhr ) {    
						 $('.progress').show();
					},
					error: function( xhr, tStatus, err ) {
						alert("e :" + tStatus + " " + err);
					},
					success : function(response){
						console.log('Response : ' + response);
						
						$('form')[0].reset();
						$('.progress').hide();
						
						if(response.status == 1){
							$("#divError").hide();
							window.location.href = '<?php echo BASE_URL?>/video';
						} else {
							$("#msgErr").text(response.msg);
							$("#divError").show();
							$("#btnSave").removeAttr("disabled");
							$('#progressBar').attr('aria-valuenow', percent).css('width', '0%').text('0%');
						}
					}
				}); 
			});
		});
	</script>		
</body>
</html>