<!DOCTYPE html>
<html lang="en">
<head>
<title>Dashboard - <?php echo PROJECT_NAME;?></title>
<meta charset="utf-8">
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo IMAGES_BASE_URL; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />

<!-- bootstrap 3.0.2 -->
<link href="<?php echo CSS_BASE_URL; ?>/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- font Awesome -->
<link href="<?php echo CSS_BASE_URL; ?>/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link href="<?php echo CSS_BASE_URL; ?>/ionicons.min.css" rel="stylesheet" type="text/css" />
<!-- Morris chart -->
<link href="<?php echo CSS_BASE_URL; ?>/morris/morris.css" rel="stylesheet" type="text/css" />
<!-- jvectormap -->
<link href="<?php echo CSS_BASE_URL; ?>/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
<!-- fullCalendar -->
<link href="<?php echo CSS_BASE_URL; ?>/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
<!-- Daterange picker -->
<link href="<?php echo CSS_BASE_URL; ?>/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<!-- DATA TABLES -->
<link href="<?php echo CSS_BASE_URL; ?>/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="<?php echo CSS_BASE_URL; ?>/AdminLTE.css" rel="stylesheet" type="text/css" />

<!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
<!--[if lt IE 9]>
<script src="<?php echo JS_BASE_URL; ?>/html5shiv.js"></script>
<script src="<?php echo JS_BASE_URL; ?>/respond.min.js"></script>
<![endif]-->

<!-- jQuery 2.0.2 -->
<script src="<?php echo JS_BASE_URL; ?>/jquery-2.0.2.min.js" type="text/javascript"></script>
<!-- jQuery UI 1.10.3 -->
<script src="<?php echo JS_BASE_URL; ?>/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="<?php echo JS_BASE_URL; ?>/bootstrap.min.js" type="text/javascript"></script>

<!-- ckeditor and kcfinder -->
<script src="<?php echo TOOLS_BASE_URL; ?>/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
function openKCFinder(field) {
	window.KCFinder = {
		callBack: function(url) {
			document.getElementById(field).value = url;
			$( "."+field ).html('<img src="'+url+'" style="max-width:400px; padding:5px; border:solid 1px #ccc;">');
			window.KCFinder = null;
		}
	};
	window.open('<?php echo TOOLS_BASE_URL; ?>/kcfinder/browse.php?type=images', 'kcfinder_textbox',
		'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
		'resizable=1, scrollbars=0, width=800, height=600'
	);
}

function reset_value(field) {
	document.getElementById(field).value = '';
	$("."+field).html('');
}
</script>
<!-- end ckeditor and kcfinder -->

</head>