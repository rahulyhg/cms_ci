<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends CI_Controller {
	public $arrMenu = array();
	public $data;
	public $module = "Module";
	public $section = 'access';
	public $module_id = 5;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('Model_module','Model_module_group','Model_logcms'));
		$this->load->helper(array('menu','accessprivilege'));

		if(empty($_SESSION['admin_data']) && !isset($_COOKIE['cms_user_id'])){
			session_destroy();
			setcookie('cms_user_id', '', 1, '/');
			redirect(BASE_URL_BACKEND."/signin");
			exit();
		}

		//Check Cookie
		if(isset($_COOKIE['cms_user_id'])) {
			checkCookieLogin($_COOKIE['cms_user_id']);
		}
		
		if($_SESSION['admin_data']['user_level_id'] != 1) echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
		
		//get menu from helper menu
		$this->arrMenu = menu();
		$this->data = array();
        $this->data['ListMenu'] = $this->arrMenu;
		$this->data['CountMenu'] = count($this->arrMenu);
	}
	
	public function index()
	{
		$this->view();
	}
	
	public function ajax_load(){
		error_reporting(0);
		
		if (!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		} 
		
		$where = "";
		$orderBy = "";
		
		$orderBy 					= "ORDER BY module_group_id ASC, module_order_value ASC, module_id DESC";
		$cond 						= $where." ".$orderBy;
		$rsLogCMS					= $this->Model_module->getListModule($cond);
		$iFilteredTotal 			= count($rsLogCMS);
		
		$no = 1;
		if(count($rsLogCMS) > 0){
			foreach($rsLogCMS as $key => $value){
				$rsLogCMS[$key]['no'] = $no++;
				$rsLogCMS[$key]['module_order_value_text'] = '<input type="text" class="form-control" name="order['.$value['module_id'].']" size="1" maxlength="2" style="text-align:center;" value="'.$value['module_order_value'].'" onKeyPress="return isNumberKey(event)">';
				$btnActive = '<input type="hidden" name="moduleid['.$value['module_id'].']" value="'.$value['module_id'].'"><a class="btn-success btn-sm" title="Click to Inactive" href="'.BASE_URL_BACKEND.'/module/active/'.$value['module_id'].'"><span class="glyphicon glyphicon-ok"></span></a> &nbsp; ';
				if($value['module_active_status'] == 0) {
					$btnActive = '<input type="hidden" name="moduleid['.$value['module_id'].']" value="'.$value['module_id'].'"><a class="btn-danger btn-sm" title="Click to Active" href="'.BASE_URL_BACKEND.'/module/active/'.$value['module_id'].'"><span class="glyphicon glyphicon-remove"></span></a> &nbsp; ';
				}  
				
				$btnEdit = '<a class="btn-primary btn-sm" title="Click to Edit" href="'.BASE_URL_BACKEND.'/module/edit/'.$value['module_id'].'"><span class="glyphicon glyphicon-pencil"></span></a> &nbsp;'; 
				$btnDelete = '<a class="btn-danger btn-sm" title="Click to Delete" onclick="var answer = confirm(\'delete module '.$value['module_name'].' ?\'); if (answer){window.location = \''.BASE_URL_BACKEND.'/module/delete/'.$value['module_id'].'\';}"><span class="glyphicon glyphicon-trash"></span></i></a> &nbsp;'; 
				$btnPrivilege = '<a class="btn-warning btn-sm" title="Click to Privilege Module" href="'.BASE_URL_BACKEND.'/module/listmoduleprivilege/'.$value['module_id'].'"><span class="glyphicon glyphicon-lock"></span></i></a> &nbsp;'; 
				
				$rsLogCMS[$key]['module_action'] = $btnActive.$btnEdit.$btnDelete.$btnPrivilege;
			}	
		}	
		
		$cond 						= $orderBy;
		$rsLogCMSTotal				= $this->Model_module->getListModule($cond);
		$iTotal 					= count($rsLogCMSTotal);   

		$results = array(
				"sEcho" => 1,
				"iTotalRecords" => $iFilteredTotal,
				"iTotalDisplayRecords" => $iTotal,
				"aaData"=>$rsLogCMS);

		echo json_encode($results);
	}	
	
	public function view(){
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;

		$this->load->view('header',$this->data);
		$this->load->view('module/list',$this->data);
	}
	
	function active($id){
		$id = $this->security->xss_clean(secure_input($id));
		if ($id == '') {
			redirect(BASE_URL_BACKEND."/module");
			exit();
		}
		
		$rsModule = $this->Model_module->getModule($id);
		$module_name = $rsModule[0]['module_name'];
		$active_status = abs($rsModule[0]['module_active_status']-1);
		
		$active = $this->Model_module->activeModule($id);
		
		if($active_status == 1){
			$log_module = "Active ".$this->module;
		} else {
			$log_module = "Inactive ".$this->module;
		}
		
		$log_value = $id." | ".$module_name." | ".$active_status;
		$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
		
		redirect(BASE_URL_BACKEND."/module");
	}
	
	function delete($id=''){
		$id = $this->security->xss_clean(secure_input($id));
		
		if(empty($id)){
			redirect(BASE_URL_BACKEND."/module");
			exit();
		}
		
		$rsModule = $this->Model_module->getModule($id);
		$module_name = $rsModule[0]['module_name'];
		
		$delete = $this->Model_module->deleteModule($id);
		
		$log_module = "Delete ".$this->module;
		
		$log_value = $id." | ".$module_name;
		$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
		
		redirect(BASE_URL_BACKEND."/module");
	}
	
	function deleteSelectedData($id=''){
		$id = $this->security->xss_clean(secure_input($id));
		
		if(empty($id)){
			redirect(BASE_URL_BACKEND."/module");
			exit();
		}
		
		$delete = $this->Model_module->deleteSelectedModule($id);
		$log_module = "Delete Selected ".$this->module;
		$log_value = $id;
		$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
		
		redirect(BASE_URL_BACKEND."/module");
	}
	
	public function add(){
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsListGroup = $this->Model_module_group->getListGroup(" WHERE module_group_active_status = 1 AND module_group_id <> 1");
		$this->data["ListGroup"] = $rsListGroup;
		$this->data["CountListGroup"] = count($rsListGroup);
		
		$modulegroupid = "";
		$this->data["modulegroupid"] = $modulegroupid;
		
		$this->load->view('header',$this->data);
		$this->load->view('module/add',$this->data);
	}
	
	function doAdd(){
		$tb = $_POST['tbSave'];
		if (!$tb) {
			redirect(BASE_URL_BACKEND."/module");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsListGroup = $this->Model_module_group->getListGroup(" WHERE module_group_active_status = 1 AND module_group_id <> 1");
		$this->data["ListGroup"] = $rsListGroup;
		$this->data["CountListGroup"] = count($rsListGroup);
		
		$modulegroupid = $_POST['module_group_id'];
		$modulename = $this->security->xss_clean(secure_input($_POST['modulename']));
		$modulepath = $this->security->xss_clean(secure_input($_POST['modulepath']));
		
		$pesan = array();
		// Validasi data
		if ($modulegroupid=="0") {
			$pesan[] = 'Group Name has not been choose';
		} else if ($modulename=="") {
			$pesan[] = 'Module Name is empty';
		} else if ($modulepath=="") {
			$pesan[] = 'Module Controller is empty';
		}
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
				
				$this->data['modulegroupid']=$modulegroupid;
				$this->data['modulename']=$modulename;
				$this->data['modulepath']=$modulepath;
				
				$this->load->view('header',$this->data);
				$this->load->view('module/add',$this->data);
			}
		} else {
			$cekModule = $this->Model_module->checkModule($modulename,$modulegroupid);
			$countModule = count($cekModule);
			
			if ($countModule > 0 ) {
				$this->data['error']='Module Name '.$modulename.' already exist';
				
				$this->data['modulegroupid']=$modulegroupid;
				$this->data['modulename']=$modulename;
				$this->data['modulepath']=$modulepath;
				
				$this->load->view('header',$this->data);
				$this->load->view('module/add',$this->data);
			} else {
				$insert = $this->Model_module->insertModule($modulename,$modulepath,$modulegroupid);
				redirect(BASE_URL_BACKEND."/module/");
			}
			
		}
	}
	
	public function edit($id){	
		if (empty($id)) {
			redirect(BASE_URL_BACKEND."/module");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsListGroup = $this->Model_module_group->getListGroup(" WHERE module_group_active_status = 1 AND module_group_id <> 1");
		$this->data["ListGroup"] = $rsListGroup;
		$this->data["CountListGroup"] = count($rsListGroup);
		
		$rsModule = $this->Model_module->getModule($id);  // mengambil database dari model untuk dikirim ke view
		$countModule = count($rsModule);
		
		$this->data['rsModule'] = $rsModule;
		$this->data['countModule'] = $countModule;
		
		if($countModule == 0){
			redirect(BASE_URL_BACKEND."/module");
			exit();
		}
		
		$this->load->view('header',$this->data);
		$this->load->view('module/edit',$this->data);
	}
	
	public function doEdit($id){
		$tb = $_POST['tbEdit'];
		if (!$tb OR $id == '') {
			redirect(BASE_URL_BACKEND."/module");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsListGroup = $this->Model_module_group->getListGroup(" WHERE module_group_active_status = 1 AND module_group_id <> 1");
		$this->data["ListGroup"] = $rsListGroup;
		$this->data["CountListGroup"] = count($rsListGroup);
		
		$rsModule = $this->Model_module->getModule($id);  // mengambil database dari model untuk dikirim ke view
		$countModule = count($rsModule);
		
		$this->data['rsModule'] = $rsModule;
		$this->data['countModule'] = $countModule;
		
		$modulegroupid = $_POST['module_group_id'];
		$modulename = $this->security->xss_clean(secure_input($_POST['modulename']));
		$modulenameOld = $this->security->xss_clean(secure_input($_POST['modulenameOld']));
		$modulepath = $this->security->xss_clean(secure_input($_POST['modulepath']));
		
		$pesan = array();
		// Validasi data
		if ($modulegroupid=="0") {
			$pesan[] = 'Group Name has not been choose';
		} else if ($modulename=="") {
			$pesan[] = 'Module Name is empty';
		} else if ($modulepath=="") {
			$pesan[] = 'Module Controller is empty';
		}
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
				
				$this->data['modulegroupid']=$modulegroupid;
				$this->data['modulename']=$modulename;
				$this->data['modulepath']=$modulepath;
				
				$this->load->view('header',$this->data);
				$this->load->view('module/edit',$this->data);
			}
		} else {
			$cekModule = $this->Model_module->checkModule($modulename,$modulegroupid);
			$countModule = count($cekModule);
			
			if($modulename == $modulenameOld){
				$countModule = 0;
			}
			
			if ($countModule > 0 ) {
				$this->data['error'] = 'Module Name '.$modulename.' already exist';
				
				$this->data['modulegroupid']=$modulegroupid;
				$this->data['modulename']=$modulename;
				$this->data['modulepath']=$modulepath;
				
				$this->load->view('header',$this->data);
				$this->load->view('module/edit',$this->data);
			} else {
				$insert = $this->Model_module->updateModule($id,$modulename,$modulepath,$modulegroupid);
				redirect(BASE_URL_BACKEND."/module/");
			}
		}
	}

	
	public function listmoduleprivilege($id){	
		if (empty($id)) {
			redirect(BASE_URL_BACKEND."/module");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsModule = $this->Model_module->getModule($id);
		$this->data['id'] = $id;
		$this->data['modulename'] = $rsModule[0]['module_name'];
		
		$rsListModulePrivilege = $this->Model_module->getListModulePrivilege(" WHERE a.module_id = ".$id);
		$this->data['ListModulePrivilege'] = $rsListModulePrivilege;
		$this->data['countModulePrivilege'] = count($rsListModulePrivilege);
		
		$this->load->view('header',$this->data);
		$this->load->view('module/listprivilege',$this->data);
		
	}
	
	public function addmoduleprivilege($id){
		if (empty($id)) {
			redirect(BASE_URL_BACKEND."/module");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$this->data['id'] = $id;
		$rsModule = $this->Model_module->getModule($id);
		$this->data['id'] = $id;
		$this->data['modulename'] = $rsModule[0]['module_name'];
		
		$rsListPrivilege = $this->Model_module->getPrivilege();
		$this->data['ListPrivilege'] = $rsListPrivilege;
		$this->data['countListPrivilege'] = count($rsListPrivilege);
		
		$this->load->view('header',$this->data);
		$this->load->view('module/addprivilege',$this->data);
	}
	
	public function doAddmoduleprivilege(){
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$privilegeid = @$_POST['privilegeid'];
		$id = $_POST['moduleid'];
		
		
		
		$rsModule = $this->Model_module->getModule($id);
		$this->data['id'] = $id;
		$this->data['modulename'] = $rsModule[0]['module_name'];
		
		$rsListPrivilege = $this->Model_module->getPrivilege();
		$this->data['ListPrivilege'] = $rsListPrivilege;
		$this->data['countListPrivilege'] = count($rsListPrivilege);
		
		$pesan = array();
		// Validasi data
		if ($privilegeid=="") {
			$pesan[] = 'Privilege Name has not been choose';
		} 
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
				
				$this->data['privilegeid'] = $privilegeid;
				
				$this->load->view('header',$this->data);
				$this->load->view('module/addprivilege',$this->data);
			}	
		} else {
			$rsDeleteModulePrivilege = $this->Model_module->deleteModulePrivilege($id);
			foreach ($privilegeid as $p_id) {
				$moduleprivilegeid = $this->Model_module->insertModulePrivilege($id,$p_id);
			}
			redirect(BASE_URL_BACKEND."/module/listmoduleprivilege/".$id);
		}
	}
	
	public function deletemoduleprivilege($id,$moduleid){
		$delete = $this->Model_module->deleteModulePrivilegeOne($id);
		redirect(BASE_URL_BACKEND."/module/listmoduleprivilege/".$moduleid);
	}
	
	public function doOrder(){
		$order = $this->security->xss_clean($_POST['order']);
		
		if($order == ""){
			redirect(BASE_URL_BACKEND."/module/");
			exit();
		} 
		
		foreach($order as $id => $ordervalue){
			$this->Model_module->updateOrderModule($id,$ordervalue);
		}
		
		redirect(BASE_URL_BACKEND."/module/");
	}
}