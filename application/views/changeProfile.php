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
					Change Profile 
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo BASE_URL_BACKEND;?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Change Profile</li>
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
										  Change Profile
									  </header>
									  <div class="panel-body">
										  <form name="formchangepassword" action="<?php echo BASE_URL_BACKEND.'/doChangeProfile'; ?>" method="post" class="form-horizontal" role="form">
											  <?php if(isset($error)){ ?>
											  <div class="form-group has-error">
												  <div class="col-lg-12">
													<label for="inputError" class="control-label"><?php echo $error;?></label>
												  </div>
											  </div>
											  <?php } ?>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Username</label>
												  <div class="col-lg-4">
													  <input name="userid" type="hidden" value="<?php echo $rsUser['user_id'];?>">
													  <input name="username" type="text" class="form-control" placeholder="Username" value="<?php echo $rsUser['user_name'];?>">
													  <input name="usernameOld" type="hidden" value="<?php echo $rsUser['user_name'];?>">
												  </div>
											  </div>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email</label>
												  <div class="col-lg-4">
													  <input name="email" type="text" class="form-control" placeholder="Email" value="<?php echo $rsUser['user_email'];?>">
													  <input name="emailOld" type="hidden" value="<?php echo $rsUser['user_email'];?>">
												  </div>
											  </div>
											  <?php if(!empty($rsUser['user_avatar'])) {?>
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">&nbsp;</label>
												  <div class="col-lg-4">
													  <img src="<?php echo BASE_URL."/assets/upload/avatar/".$rsUser['user_avatar'];?>" class="img-circle" width="100" alt="Profile <?php echo $rsUser['user_name'];?>" title="Profile" >
												  </div>
											  </div>
											  <?php } ?>
											  <input name="avatarOld" type="hidden" value="<?php echo $rsUser['user_avatar'];?>">
											  <div class="form-group">
												  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Avatar</label>
												  <div class="col-lg-4">
														<input name="avatar" id="avatar" type="hidden" class="form-control">
														<input type='hidden' class='sesi-from' value='<?php echo rand(0,100).rand(10,500).date('dym') ?>' >
														<div class='dropzone avatar_user well'></div>

												   </div>
											  </div>
											  <div class="form-group">
												  <div class="col-lg-offset-2 col-lg-10" style="margin-top:-25px;";>
													  <input name="tbSave" class="btn btn-info btn-sm" type="submit" value="Save">&nbsp;
													  <input name="cancel" class="btn btn-info btn-sm" type="button" value="Cancel" onClick="location.href='<?php echo BASE_URL_BACKEND.'/home'; ?>'">
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
	
	<!-- Dropzone -->
	<link href="<?php echo TOOLS_BASE_URL; ?>/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo TOOLS_BASE_URL; ?>/dropzone/dropzone.min.js" type="text/javascript"></script>
	
	<script type="text/javascript">
        Dropzone.autoDiscover = false;
		
		var sedang_upload_avatar=false;
		var avatar_terupload=false;
		var file_temp_telah_terhapus=false;
		var sesi=$('.sesi-from').val();
		
		var AvatarBaru=new Dropzone(".avatar_user", { url: "<?php echo BASE_URL_BACKEND.'/ajaxUploadProfile'; ?>" ,
                                                      maxFilesize: 3,
                                                      maxFiles: 1,
                                                      method:'post',
                                                      acceptedFiles:"image/*",
                                                      paramName:"userfile",
													  headers: {sesi:"2"},
                                                      addRemoveLinks: true,
                                                      dictDefaultMessage:"Upload your avatar <br> (215px x 215px)",
                                                      dictInvalidFileType:"File type not allowed",
                                                      dictRemoveFile:"Cancel"
                                                    });
		AvatarBaru.on("sending",function(a,b,c){
			a.token=sesi;
			c.append('token_foto',sesi);
			//console.log('mengirim');
			//console.log('sedang_upload_avatar:'+sedang_upload_avatar);
		})
		AvatarBaru.on("success",function(a,b,c){
			sedang_upload_avatar=false;
			avatar_terupload=true;
			file_temp_telah_terhapus=false;
			//console.log('success');
			//console.log('sedang_upload_avatar:'+sedang_upload_avatar);
			//console.log('avatar_terupload:'+avatar_terupload);
			//console.log(a.token);
			var filename = b;
			$("#avatar").val(filename);
			a.token=filename;
		})
		
		AvatarBaru.on("error",function(a,b){ 
			sedang_upload_avatar=false;
			avatar_terupload=(avatar_terupload)?true:avatar_terupload;
			//console.log('error');
			//console.log('sedang_upload_avatar:'+sedang_upload_avatar);
			//console.log('avatar_terupload:'+avatar_terupload);
		})

		AvatarBaru.on("canceled",function(){
			sedang_upload_avatar=false;
			avatar_terupload=false;
		})
		
		AvatarBaru.on("removedfile",function(a){
			//console.log(JSON.stringify(a));
			if(a.status=='success'){
				avatar_terupload=false;
				var token=a.token;
				//console.log(token);
				$.ajax({
					type:"POST",
					url:"<?php echo BASE_URL_BACKEND.'/ajaxRemoveProfile'; ?>",
					data:{foto_token:token},
					cache:false,
					success:function(data){
					  file_temp_telah_terhapus=true;
					}
				})
			}
			
			//console.log(avatar_terupload);
		})
	
	</script>
</body>
</html	