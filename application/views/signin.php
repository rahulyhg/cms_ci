<!DOCTYPE html>
<html lang="en" class="bg-black">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo IMAGES_BASE_URL; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />

    <title>Dashboard - Login - <?php echo PROJECT_NAME;?></title>
	
	<!-- bootstrap 3.0.2 -->
	<link href="<?php echo CSS_BASE_URL; ?>/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- font Awesome -->
	<link href="<?php echo CSS_BASE_URL; ?>/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="<?php echo CSS_BASE_URL; ?>/AdminLTE.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo JS_BASE_URL; ?>/html5shiv.js"></script>
    <script src="<?php echo JS_BASE_URL; ?>/respond.min.js"></script>
    <![endif]-->
</head>

<body class="bg-black">
	<div class="form-box" id="login-box">
		<div class="header">Dashboard</div>
		<form action="<?php echo BASE_URL_BACKEND; ?>/cekLogin" method="POST">
			<div class="body bg-gray">
				<?php if(isset($error)){ ?>
				<div class="form-group">
					<p style="color: #ff6c60;"><?php echo $error;?></p>
				</div>
				<?php } ?>
				<!--<p align="center"><img src="<?php echo IMAGES_BASE_URL;?>/logo.png" alt="logo"></p>-->
				<div class="form-group">
					<input type="text" name="username" class="form-control" placeholder="User Name or Email"/>
				</div>
				<div class="form-group">
					<input type="password" name="password" class="form-control" placeholder="Password"/>
				</div> 
				<?php if($wrong >= 2){ ?>
				<div class="form-group">
					<span id="captcha"><?php echo $captcha;?></span> <a class="btn btn-sm" title="Refresh Security Code" id="refresh"><i class="fa fa-fw fa-refresh"></i></a>
				</div>
				<div class="form-group">
					<input name="capctha" type="text" class="form-control" placeholder="Security Code">
				</div>
				<?php } ?>
				<div class="form-group">
					<input type="checkbox" name="remember" id="idRemember" value="1"/> Remember me
				</div>
			</div>
			<div class="footer">                                                               
				<button name="tbSignin" type="submit" class="btn bg-red btn-block" value="Sign in">Sign me in</button>  
			</div>
		</form>
	</div>


	<!-- jQuery 2.0.2 -->
	<script src="<?php echo JS_BASE_URL; ?>/jquery-2.0.2.min.js" type="text/javascript"></script>
	<!-- Bootstrap -->
	<script src="<?php echo JS_BASE_URL; ?>/bootstrap.min.js" type="text/javascript"></script>        
	
	<script type="text/javascript">
	$(document).ready(function(){
	  $("#refresh").click(function(){
		$.ajax({
			url: "<?php echo BASE_URL_BACKEND; ?>/signin/reload_captcha",
			success: function(data){
				$("#captcha").html(data);
			}
		});
	  });
	});
	</script>
</body>
</html>
