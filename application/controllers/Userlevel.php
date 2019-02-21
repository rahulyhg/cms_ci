<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userlevel extends CI_Controller {
	public $arrMenu = array();
	public $data;
	public $module = "User Level";
	public $section = 'access';
	public $module_id = 3;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('Model_userlevel','Model_logcms'));
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
		
		$orderBy 					= "ORDER BY user_level_id DESC";
		$cond 						= $where." ".$orderBy;
		$rsLogCMS					= $this->Model_userlevel->getListUserLevel($cond);
		$iFilteredTotal 			= count($rsLogCMS);
		
		if(count($rsLogCMS) > 0){
			foreach($rsLogCMS as $key => $value){
				$btnActive = '<input type="hidden" name="userlevelid['.$value['user_level_id'].']" value="'.$value['user_level_id'].'"><a class="btn-success btn-sm" title="Click to Inactive" href="'.BASE_URL_BACKEND.'/userlevel/active/'.$value['user_level_id'].'"><span class="glyphicon glyphicon-ok"></span></a> &nbsp; ';
				if($value['user_level_active_status'] == 0) {
					$btnActive = '<input type="hidden" name="userlevelid['.$value['user_level_id'].']" value="'.$value['user_level_id'].'"><a class="btn-danger btn-sm" title="Click to Active" href="'.BASE_URL_BACKEND.'/userlevel/active/'.$value['user_level_id'].'"><span class="glyphicon glyphicon-remove"></span></a> &nbsp; ';
				}  
				
				$btnEdit = '<a class="btn-primary btn-sm" title="Click to Edit" href="'.BASE_URL_BACKEND.'/userlevel/edit/'.$value['user_level_id'].'"><span class="glyphicon glyphicon-pencil"></span></a> &nbsp;'; 
				$btnDelete = '<a class="btn-danger btn-sm" title="Click to Delete" onclick="var answer = confirm(\'delete user level '.$value['user_level_name'].' ?\'); if (answer){window.location = \''.BASE_URL_BACKEND.'/userlevel/delete/'.$value['user_level_id'].'\';}"><span class="glyphicon glyphicon-trash"></span></i></a> &nbsp;'; 
				
				$rsLogCMS[$key]['user_level_action'] = $btnActive.$btnEdit.$btnDelete;
			}	
		}	
		
		$cond 						= $orderBy;
		$rsLogCMSTotal				= $this->Model_userlevel->getListUserLevel($cond);
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
		$this->load->view('userlevel/list',$this->data);
	}
	
	function active($id){
		$id = $this->security->xss_clean(secure_input($id));
		
		if ($id == '') {
			redirect(BASE_URL_BACKEND."/userlevel");
			exit();
		}
		
		$rsUserLevel = $this->Model_userlevel->getUserLevel($id); 
		$userlevelname = $rsUserLevel[0]['user_level_name'];
		$userlevelactive = abs($rsUserLevel[0]['user_level_active_status']-1);
		
		$active = $this->Model_userlevel->activeUserLevel($id);
		
		if($userlevelactive == 1){
			$log_module = "Active ".$this->module;
		} else {
			$log_module = "Inactive ".$this->module;
		}
		$log_value = $id." | ".$userlevelname." | ".$userlevelactive;
		$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
		
		redirect(BASE_URL_BACKEND."/userlevel");
	}
	
	function delete($id){
		$id = $this->security->xss_clean(secure_input($id));
		
		if(empty($id)){
			redirect(BASE_URL_BACKEND."/userlevel");
			exit();
		}
		
		$rsUserLevel = $this->Model_userlevel->getUserLevel($id); 
		$userlevelname = $rsUserLevel[0]['user_level_name'];
		
		$delete = $this->Model_userlevel->deleteUserLevel($id);
		
		$log_module = "Delete ".$this->module;
		$log_value = $id." | ".$userlevelname;
		$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
		
		redirect(BASE_URL_BACKEND."/userlevel");
	}
	
	public function add(){
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$this->load->view('header',$this->data);
		$this->load->view('userlevel/add',$this->data);
	}
	
	function doAdd(){
		$tb = $_POST['tbSave'];
		if (!$tb) {
			redirect(BASE_URL_BACKEND."/userlevel");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$userlevelname = $this->security->xss_clean(secure_input($_POST['userlevelname']));
		$userleveldesc = $this->security->xss_clean(secure_input($_POST['userleveldesc']));
		
		$pesan = array();
		// Validasi data
		if ($userlevelname=="") {
			$pesan[] = 'User Level Name is empty';
		} else if ($userleveldesc=="") {
			$pesan[] = 'User Level Description is empty';
		}
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
				
				$this->data['userlevelname']=$userlevelname;
				$this->data['userleveldesc']=$userleveldesc;
				
				$this->load->view('header',$this->data);
				$this->load->view('userlevel/add',$this->data);
			}
		} else {
			$cekUserLevel = $this->Model_userlevel->checkUserLevel($userlevelname);
			$countUserLevel = count($cekUserLevel);
			
			if ($countUserLevel > 0 ) {
				$this->data['error']='User Level Name '.$userlevelname.' already exist';
				
				$this->data['userlevelname']=$userlevelname;
				$this->data['userleveldesc']=$userleveldesc;
				
				$this->load->view('header',$this->data);
				$this->load->view('userlevel/add',$this->data);
			} else {
				$insert = $this->Model_userlevel->insertUserLevel($userlevelname,$userleveldesc);
				
				$log_module = "Add ".$this->module;
				$log_value = $userlevelname." | ".$userleveldesc;
				$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
				
				redirect(BASE_URL_BACKEND."/userlevel/");
			}
			
		}
	}
	
	public function edit($id){	
		if (empty($id)) {
			redirect(BASE_URL_BACKEND."/userlevel");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsUserLevel = $this->Model_userlevel->getUserLevel($id);  // mengambil database dari model untuk dikirim ke view
		$countUserLevel = count($rsUserLevel);
		
		$this->data['rsUserLevel'] = $rsUserLevel;
		$this->data['countUserLevel'] = $countUserLevel;
		
		if($countUserLevel == 0){
			redirect(BASE_URL_BACKEND."/userlevel");
			exit();
		}
		
		$this->load->view('header',$this->data);
		$this->load->view('userlevel/edit',$this->data);
	}
	
	public function doEdit($id){
		$tb = $_POST['tbEdit'];
		if (!$tb OR $id == '') {
			redirect(BASE_URL_BACKEND."/userlevel");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsUserLevel = $this->Model_userlevel->getUserLevel($id);  // mengambil database dari model untuk dikirim ke view
		$countUserLevel = count($rsUserLevel);
		
		$this->data['rsUserLevel'] = $rsUserLevel;
		$this->data['countUserLevel'] = $countUserLevel;
		
		
		$userlevelname = $this->security->xss_clean(secure_input($_POST['userlevelname']));
		$userlevelnameOld = $this->security->xss_clean(secure_input($_POST['userlevelnameOld']));
		$userleveldesc = $this->security->xss_clean(secure_input($_POST['userleveldesc']));
		
		$pesan = array();
		// Validasi data
		if ($userlevelname=="") {
			$pesan[] = 'User Level Name is empty';
		} else if ($userleveldesc=="") {
			$pesan[] = 'User Level Description is empty';
		}
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
				
				$this->data['userlevelname']=$userlevelname;
				$this->data['userleveldesc']=$userleveldesc;
				
				$this->load->view('header',$this->data);
				$this->load->view('userlevel/edit',$this->data);
			}
		} else {
			$cekUserLevel = $this->Model_userlevel->checkUserLevel($userlevelname);
			$countUserLevel = count($cekUserLevel);
			
			if($userlevelname == $userlevelnameOld){
				$countUserLevel = 0;
			}
			
			if ($countUserLevel > 0 ) {
				$this->data['error'] = 'User Level Name '.$userlevelname.' already exist';
				
				$this->data['userlevelname'] = $userlevelname;
				$this->data['userleveldesc'] = $userleveldesc;
				
				$this->load->view('header',$this->data);
				$this->load->view('userlevel/edit',$this->data);
			} else {
				$insert = $this->Model_userlevel->updateUserLevel($id,$userlevelname,$userleveldesc);
				
				$log_module = "Edit ".$this->module;
				$log_value = $id." | ".$userlevelname." | ".$userleveldesc;
				$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
				
				redirect(BASE_URL_BACKEND."/userlevel/");
			}
		}
	}
}