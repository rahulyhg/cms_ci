<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_group extends CI_Controller {
	public $arrMenu = array();
	public $data;
	public $module = "Module Group";
	public $section = 'access';
	public $module_id = 4;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('Model_module_group','Model_logcms'));
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
		
		$orderBy 					= "ORDER BY module_group_order_value ASC, module_group_id DESC";
		$cond 						= $where." ".$orderBy;
		$rsLogCMS					= $this->Model_module_group->getListGroup($cond);
		$iFilteredTotal 			= count($rsLogCMS);
		
		if(count($rsLogCMS) > 0){
			foreach($rsLogCMS as $key => $value){
				$rsLogCMS[$key]['module_group_order_value_text'] = '<input type="text" class="form-control" name="order['.$value['module_group_id'].']" size="1" maxlength="2" style="text-align:center;" value="'.$value['module_group_order_value'].'" onKeyPress="return isNumberKey(event)">';
				$btnActive = '<input type="hidden" name="modulegroupid['.$value['module_group_id'].']" value="'.$value['module_group_id'].'"><a class="btn-success btn-sm" title="Click to Inactive" href="'.BASE_URL_BACKEND.'/module_group/active/'.$value['module_group_id'].'"><span class="glyphicon glyphicon-ok"></span></a> &nbsp; ';
				if($value['module_group_active_status'] == 0) {
					$btnActive = '<input type="hidden" name="moduleid['.$value['module_group_id'].']" value="'.$value['module_group_id'].'"><a class="btn-danger btn-sm" title="Click to Active" href="'.BASE_URL_BACKEND.'/module_group/active/'.$value['module_group_id'].'"><span class="glyphicon glyphicon-remove"></span></a> &nbsp; ';
				}  
				
				$btnEdit = '<a class="btn-primary btn-sm" title="Click to Edit" href="'.BASE_URL_BACKEND.'/module_group/edit/'.$value['module_group_id'].'"><span class="glyphicon glyphicon-pencil"></span></a> &nbsp;'; 
				$btnDelete = '<a class="btn-danger btn-sm" title="Click to Delete" onclick="var answer = confirm(\'delete module group '.$value['module_group_name'].' ?\'); if (answer){window.location = \''.BASE_URL_BACKEND.'/module_group/delete/'.$value['module_group_id'].'\';}"><span class="glyphicon glyphicon-trash"></span></i></a> &nbsp;'; 
				
				$rsLogCMS[$key]['module_group_action'] = $btnActive.$btnEdit.$btnDelete;
			}	
		}	
		
		$cond 						= $orderBy;
		$rsLogCMSTotal				= $this->Model_module_group->getListGroup($cond);
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
		$this->load->view('module_group/list',$this->data);
	}
	
	function active($id){
		$id = $this->security->xss_clean(secure_input($id));
		if ($id == '') {
			redirect(BASE_URL_BACKEND."/module_group");
			exit();
		}
		
		$rsGroup = $this->Model_module_group->getGroup($id);  // mengambil database dari model untuk dikirim ke view
		$module_group_name = $rsGroup[0]['module_group_name'];
		$active_status = abs($rsGroup[0]['module_group_active_status']-1);
		
		$active = $this->Model_module_group->activeGroup($id);
		
		if($active_status == 1){
			$log_module = "Active ".$this->module;
		} else {
			$log_module = "Inactive ".$this->module;
		}
		
		$log_value = $id." | ".$module_group_name." | ".$active_status;
		$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
		
		redirect(BASE_URL_BACKEND."/module_group");
	}
	
	function delete($id=''){
		$id = $this->security->xss_clean(secure_input($id));
		
		if(empty($id)){
			redirect(BASE_URL_BACKEND."/module_group");
			exit();
		}
		
		$rsGroup = $this->Model_module_group->getGroup($id); 
		$module_group_name = $rsGroup[0]['module_group_name'];
		
		$delete = $this->Model_module_group->deleteGroup($id);
		$log_module = "Delete ".$this->module;
		
		$log_value = $id." | ".$module_group_name;
		$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
		
		redirect(BASE_URL_BACKEND."/module_group");
	}
	
	public function add(){
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$this->load->view('header',$this->data);
		$this->load->view('module_group/add',$this->data);
	}
	
	function doAdd(){
		$tb = $_POST['tbSave'];
		if (!$tb) {
			redirect(BASE_URL_BACKEND."/module_group");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$groupname = $this->security->xss_clean(secure_input($_POST['groupname']));
		
		$pesan = array();
		// Validasi data
		if ($groupname=="") {
			$pesan[] = 'Module Group Name is empty';
		} 
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
				
				$this->data['groupname']=$groupname;
				
				$this->load->view('header',$this->data);
				$this->load->view('module_group/add',$this->data);
			}
		} else {
			$cekGroup = $this->Model_module_group->checkGroup($groupname);
			$countGroup = count($cekGroup);
			
			if ($countGroup > 0 ) {
				$this->data['error']='Module Group Name '.$groupname.' already exist';
				
				$this->data['groupname']=$groupname;
				
				$this->load->view('header',$this->data);
				$this->load->view('module_group/add',$this->data);
			} else {
				$insert = $this->Model_module_group->insertGroup($groupname);
				redirect(BASE_URL_BACKEND."/module_group/");
			}
			
		}
	}
	
	public function edit($id){	
		if (empty($id)) {
			redirect(BASE_URL_BACKEND."/module_group");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsGroup = $this->Model_module_group->getGroup($id);  // mengambil database dari model untuk dikirim ke view
		$countGroup = count($rsGroup);
		
		$this->data['rsGroup'] = $rsGroup;
		$this->data['countGroup'] = $countGroup;
		
		if($countGroup == 0){
			redirect(BASE_URL_BACKEND."/module_group");
			exit();
		}
		
		$this->load->view('header',$this->data);
		$this->load->view('module_group/edit',$this->data);
	}
	
	public function doEdit($id){
		$tb = $_POST['tbEdit'];
		if (!$tb OR $id == '') {
			redirect(BASE_URL_BACKEND."/module_group");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsGroup = $this->Model_module_group->getGroup($id);  // mengambil database dari model untuk dikirim ke view
		$countGroup = count($rsGroup);
		
		$this->data['rsGroup'] = $rsGroup;
		$this->data['countGroup'] = $countGroup;
		
		
		$groupname = $this->security->xss_clean(secure_input($_POST['groupname']));
		$groupnameOld = $this->security->xss_clean(secure_input($_POST['groupnameOld']));
		
		$pesan = array();
		// Validasi data
		if ($groupname=="") {
			$pesan[] = 'Module Group Name is empty';
		} 
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
				
				$this->data['groupname']=$groupname;
				
				$this->load->view('header',$this->data);
				$this->load->view('module_group/edit',$this->data);
			}
		} else {
			$cekGroup = $this->Model_module_group->checkGroup($groupname);
			$countGroup = count($cekGroup);
			
			if($groupname == $groupnameOld){
				$countGroup = 0;
			}
			
			if ($countGroup > 0 ) {
				$this->data['error'] = 'Module Group Name '.$groupname.' already exist';
				
				$this->data['groupname'] = $groupname;
				
				$this->load->view('header',$this->data);
				$this->load->view('module_group/edit',$this->data);
			} else {
				$insert = $this->Model_module_group->updateGroup($id,$groupname);
				redirect(BASE_URL_BACKEND."/module_group/");
			}
		}
	}
	
	public function doOrder(){
		
		$order = $this->security->xss_clean($_POST['order']);
		
		if($order == ""){
			redirect(BASE_URL_BACKEND."/module_group/");
			exit();
		} 
		
		foreach($order as $id => $ordervalue){
			$this->Model_module_group->updateOrderGroup($id,$ordervalue);
		}
		
		redirect(BASE_URL_BACKEND."/module_group/");
	}
}