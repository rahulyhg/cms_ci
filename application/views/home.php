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
					Dashboard
					<small>Control panel</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Dashboard</li>
				</ol>
			</section>
			<!-- Main content -->
			<section class="content box box-warning">
            	<?php if($_SESSION['admin_data']['user_level_id']!=7 && $_SESSION['admin_data']['user_level_id']!=8){ ?>
				<!-- Small boxes (Stat box) -->
				<div class="row">
					<div class="col-md-12">
						<div class="small-box">
							<div class="box-header">
								<h3 class="box-title">Register Users From</h3>
							</div>
						</div>
					</div><!-- /.col -->
					<div class="col-md-12">
						<div>
							<div class="box-body chart-responsive">
								<div class="chart" id="sosmed-chart" style="height: 300px; position: relative;"></div>
							</div><!-- /.box-body -->
						</div>
					</div><!-- /.col -->
					<div class="col-lg-6 col-xs-12">
						<div>
							<div class="box-header">
								<h3 class="box-title">Sex</h3>
							</div>
							<div class="box-body chart-responsive">
								<div class="chart" id="sex-chart" style="height: 300px; position: relative;"></div>
							</div><!-- /.box-body -->
						</div>
					</div><!-- /.col -->
					<div class="col-lg-6 col-xs-12">
						<div>
							<div class="box-header">
								<h3 class="box-title">Age</h3>
							</div>
							<div class="box-body chart-responsive">
								<div class="chart" id="age-chart" style="height: 300px; position: relative;"></div>
							</div><!-- /.box-body -->
						</div>
					</div><!-- /.col -->
					<div class="col-lg-4 col-xs-12">
						<!-- small box -->
						<div class="small-box bg-blue">
							<div class="inner">
								<h3>
									 <?php echo number_format(86969, 0, ",", "."); ?>
								</h3>
								<p>
									Total Users Connect Facebook
								</p>
							</div>
							<div class="icon">
								<i class="fa fa-fw fa-facebook"></i>
							</div>
							<a href="#" class="small-box-footer">
								&nbsp;
							</a>
						</div>
					</div><!-- ./col -->
					<div class="col-lg-4 col-xs-12">
						<!-- small box -->
						<div class="small-box bg-aqua">
							<div class="inner">
								<h3>
									<?php echo number_format(43982, 0, ",", "."); ?>
								</h3>
								<p>
									Total Users Connect Twitter
								</p>
							</div>
							<div class="icon">
								<i class="fa fa-fw fa-twitter"></i>
							</div>
							<a href="#" class="small-box-footer">
								&nbsp;
							</a>
						</div>
					</div>
					<div class="col-lg-4 col-xs-12">
						<!-- small box -->
						<div class="small-box bg-red">
							<div class="inner">
								<h3>
									<?php echo number_format(43252, 0, ",", "."); ?>
								</h3>
								<p>
									Total Users Connect Google
								</p>
							</div>
							<div class="icon">
								<i class="fa fa-fw fa-google-plus"></i>
							</div>
							<a href="#" class="small-box-footer">
								&nbsp;
							</a>
						</div>
					</div><!-- ./col -->
					
					<div class="col-lg-6 col-xs-12">
						<!-- small box -->
						<div class="small-box bg-aqua">
							<div class="inner">
								<h3>
									 <?php echo number_format(4235252, 0, ",", "."); ?>
								</h3>
								<p>
									Total Users
								</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
							<a href="#" class="small-box-footer">
								&nbsp;
							</a>
						</div>
					</div><!-- ./col -->
					<div class="col-lg-6 col-xs-12">
						<!-- small box -->
						<div class="small-box bg-yellow">
							<div class="inner">
								<h3>
									<?php echo number_format(3525252, 0, ",", "."); ?>
								</h3>
								<p>
									Total Photo & Video
								</p>
							</div>
							<div class="icon">
								<i class="ion ion-android-image"></i>
							</div>
							<a href="#" class="small-box-footer">
								&nbsp;
							</a>
						</div>
					</div><!-- ./col -->

					<div class="col-lg-2 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-green">
							<div class="inner">
								<h3>
									<?php echo number_format(5325, 0, ",", "."); ?>
								</h3>
								<p>
									Blacberry
								</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
							<a href="#" class="small-box-footer">
								<?php echo date("d F Y"); ?> <i class="fa fa-arrow-circle-right"></i>
							</a>
						</div>
					</div>
					<div class="col-lg-2 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-red">
							<div class="inner">
								<h3>
									<?php echo number_format(53253, 0, ",", "."); ?>
								</h3>
								<p>
									Android
								</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
							<a href="#" class="small-box-footer">
								<?php echo date("d F Y"); ?> <i class="fa fa-arrow-circle-right"></i>
							</a>
						</div>
					</div>
					<div class="col-lg-2 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-blue">
							<div class="inner">
								<h3>
									<?php echo number_format(53253, 0, ",", "."); ?>
								</h3>
								<p>
									IPhone
								</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
							<a href="#" class="small-box-footer">
								<?php echo date("d F Y"); ?> <i class="fa fa-arrow-circle-right"></i>
							</a>
						</div>
					</div>
					<div class="col-lg-2 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-purple">
							<div class="inner">
								<h3>
									<?php echo number_format(5325, 0, ",", "."); ?>
								</h3>
								<p>
									Blacberry 10
								</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
							<a href="#" class="small-box-footer">
								<?php echo date("d F Y"); ?> <i class="fa fa-arrow-circle-right"></i>
							</a>
						</div>
					</div>
					<div class="col-lg-2 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-teal">
							<div class="inner">
								<h3>
									<?php echo number_format(5235, 0, ",", "."); ?>
								</h3>
								<p>
									Windows Phone
								</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
							<a href="#" class="small-box-footer">
								<?php echo date("d F Y"); ?> <i class="fa fa-arrow-circle-right"></i>
							</a>
						</div>
					</div>
					<div class="col-lg-2 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-maroon">
							<div class="inner">
								<h3>
									<?php echo number_format(5325, 0, ",", "."); ?>
								</h3>
								<p>
									J2ME & Nokia X
								</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
							<a href="#" class="small-box-footer">
								<?php echo date("d F Y"); ?> <i class="fa fa-arrow-circle-right"></i>
							</a>
						</div>
					</div>
				</div><!-- /.row -->

				
				<!-- top row -->
				<div class="row">
					<div class="col-xs-12 connectedSortable">
						
					</div><!-- /.col -->
				</div>
				<!-- /.row -->
                <?php } else { ?>
                Welcome to the dashboard
                <?php } ?>
			</section><!-- /.content -->
		</aside><!-- /.right-side -->
	</div><!-- ./wrapper -->
		
	<!-- Morris.js charts -->
	<script src="<?php echo JS_BASE_URL; ?>/raphael-min.js"></script>
	<script src="<?php echo JS_BASE_URL; ?>/plugins/morris/morris.min.js" type="text/javascript"></script>
	<link href="<?php echo CSS_BASE_URL; ?>/morris/morris.css" rel="stylesheet" type="text/css" />
	
	<!-- AdminLTE App -->
	<script src="<?php echo JS_BASE_URL; ?>/AdminLTE/app.js" type="text/javascript"></script>
	
	<!-- page script -->
	<script type="text/javascript">
		$(function() {
			"use strict";
			
			// LINE CHART
			var line = new Morris.Line({
				element: 'sosmed-chart',
				resize: true,
				data: [
					{tgl: '02/07/2019',total: 1378,fb: 860,google: 518},
					{tgl: '02/08/2019',total: 1223,fb: 762,google: 461},
					{tgl: '02/09/2019',total: 1035,fb: 621,google: 414},
					{tgl: '02/10/2019',total: 1060,fb: 620,google: 440},
					{tgl: '02/11/2019',total: 1212,fb: 761,google: 451},
					{tgl: '02/12/2019',total: 1407,fb: 840,google: 567},
					{tgl: '02/13/2019',total: 1549,fb: 911,google: 638},
					{tgl: '02/14/2019',total: 1101,fb: 652,google: 449},
					{tgl: '02/15/2019',total: 915,fb: 535,google: 380},
					{tgl: '02/16/2019',total: 342,fb: 181,google: 161},
					{tgl: '02/17/2019',total: 251,fb: 156,google: 95},
					{tgl: '02/18/2019',total: 252,fb: 138,google: 114},
					{tgl: '02/19/2019',total: 252,fb: 136,google: 116},
					{tgl: '02/20/2019',total: 253,fb: 136,google: 117},				],
				parseTime: false,
				xkey: 'tgl',
				ykeys: ['total','fb', 'google'],
				labels: ['Total','Facebook SMS', 'Google'],
				lineColors: ['#cccccc','#3c8dbc', '#f56954'],
				fillOpacity: 0.6,
				hideHover: 'auto'
			});
			
			//DONUT CHART
			var donut = new Morris.Donut({
				element: 'sex-chart',
				resize: true,
				colors: ["#00a65a", "#f56954"],
				data: [
					{label: "Male", value: 301318},
					{label: "Female", value: 150474}
				],
				hideHover: 'auto'
			});
			
			//BAR CHART
			var bar = new Morris.Bar({
				element: 'age-chart',
				resize: true,
				data: [
					{y: '<17', a: 24209},
					{y: '17-24', a: 197972},
					{y: '25-34', a: 162340},
					{y: '35-44', a: 52766},
					{y: '45-54', a: 10631},
					{y: '55-64', a: 2394},
					{y: '65>', a: 1474},
				],

				barColors: ['#01a8fe'],
				xkey: 'y',
				ykeys: ['a'],
				labels: ['Age'],
				hideHover: 'auto'
			});
			
		});	
	</script>
</body>
</html>	