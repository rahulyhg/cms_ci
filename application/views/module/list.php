<body class="skin-black">
	<script language="javascript">
		function updateOrder(){
			var frm = document.formAssignment;
			var answer = confirm('are you sure want to update order?');
			
			if(answer){
				frm.action = '<?php echo BASE_URL_BACKEND;?>/module/doOrder';
				frm.submit();
			} else {
				return false;
			}
		}
	</script>
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
					<small>Module - List</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo BASE_URL_BACKEND;?>"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="<?php echo BASE_URL_BACKEND;?>/module">Module</a></li>
					<li class="active">List</li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
				  <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
								<div class="box-header">
                                    <h3 class="box-title">Module - List</h3>
									<div class="col-xs-12">
										<input class="btn btn-primary btn-sm" type="button" value="Add" onclick="window.location = '<?php echo BASE_URL_BACKEND;?>/module/add/'">
										<input class="btn btn-primary btn-sm" type="button" value="Order" onClick="javascript:updateOrder()">
									</div>
                                </div><!-- /.box-header -->
								<?php if(isset($error)){ ?>
								<div class="panel-body">
								  <div class="form-group has-error">
									  <label for="inputError" class="col-sm-2 control-label col-lg-2"><?php echo $error;?></label>
								  </div>
								</div>
								<?php } ?>
								<div class="box-body table-responsive">
                                    <form name="formAssignment" method="POST" action="" onsubmit="return false;">
									<table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
												<th width="5">No</th>
                                                <th>Module ID</th>
                                                <th>Module Name</th>
												<th>Group ID</th>
												<th>Module Group</th>
												<th>Module Controller</th>
												<th>Create Date</th>
												<th>Sorted</th>
												<th>Sorting</th>
												<th width="180">Action</th>
                                            </tr>
                                        </thead>
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
	
	<!-- page script -->
	<script type="text/javascript">
		$(document).ready(function() {
			table<?php echo $modul_id; ?> = $('#example1').dataTable({
				"bProcessing": false,
                "bServerSide": false,
				"bStateSave": true,
				"iDisplayLength" : <?php echo PER_PAGE; ?>,
				"aLengthMenu": [[50, 100, 200], [50, 100, 200]], 
				"aaSorting": [[ 0, 'asc' ]], 
				"sAjaxSource": "<?php echo BASE_URL_BACKEND;?>/module/ajax_load",
				"sServerMethod": "POST",
				"aoColumnDefs": [
								  { 'bSortable': false, 'aTargets': [ 0, 4, 5, 6, 7, 8, 9 ] },
								  { 'bSearchable': false, 'aTargets': [ 0, 5, 6, 7, 8, 9 ] },
							    ],
				"sServerMethod": "POST",
				"aoColumns": [
								{ mData: '' } ,
								{ mData: 'module_id', bVisible:false } ,
								{ mData: 'module_name' } ,
								{ mData: 'module_group_id', bVisible:false },
								{ mData: 'module_group_name' },
								{ mData: 'module_path' },
								{ mData: 'module_create_date' },
								{ mData: 'module_order_value', bVisible:false },
								{ mData: 'module_order_value_text', sClass: 'text-center' },
								{ mData: 'module_action', sClass: 'text-center' },
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