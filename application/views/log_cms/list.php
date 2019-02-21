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
					Access 
					<small>Logs - List</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo BASE_URL_BACKEND;?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="<?php echo BASE_URL_BACKEND;?>/log_cms">Logs</a></li>
					<li class="active">List</li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
				  <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
								<div class="box-header">
                                    <h3 class="box-title">Access - List</h3>
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
                                                 <th>No.</th>
												 <th>Log ID</th>
                                                 <th>Module</th>
											     <th>Action</th>
											     <th>User</th>
											     <th>Create Date</th>
                                            </tr>
                                        </thead>
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
	
	<!-- page script -->
	<script type="text/javascript">
		$(document).ready(function() {
			table<?php echo $modul_id; ?> = $('#example1').dataTable({
				"bProcessing": false,
                "bServerSide": false,
				"iDisplayLength" : <?php echo PER_PAGE; ?>,
				"aLengthMenu": [[50, 100, 200], [50, 100, 200]],
				"aaSorting": [[ 0, 'desc' ]],  
				"sAjaxSource": "<?php echo BASE_URL_BACKEND;?>/log_cms/ajax_load",
				"sServerMethod": "POST",
				"aoColumnDefs": [
								  { 'bSortable': false, 'aTargets': [ 0, 3 ] },
								  { 'bSearchable': false, 'aTargets': [ 0, 3 ] },
							    ],
				"aoColumns": [
								{ mData: '' } ,
								{ mData: 'log_id_cms', bVisible:false } ,
								{ mData: 'log_module' } ,
								{ mData: 'log_value' },
								{ mData: 'user_name' },
								{ mData: 'log_create_date' },
							],
				"fnRowCallback" : function(nRow, aData, iDisplayIndex, iDisplayIndexFull){
									$("td:first", nRow).html(iDisplayIndexFull +1);
									return nRow;
								  },
				"fnInitComplete" : function(){
                            setTimeout(function(){
                                if(window.localStorage.pagestate<?php echo $modul_id; ?> == "back"){
                                    table<?php echo $modul_id; ?>.page(window.localStorage.lastpage).draw(false);
                                    window.localStorage.pagestate<?php echo $modul_id; ?> = "";
                                }
                            },10);
                        },
			});
		});
	</script>
</body>
</html	