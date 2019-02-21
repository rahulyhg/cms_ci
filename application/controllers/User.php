<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	public $arrMenu = array();
	public $data = array();
	public $module = "User";
	public $section = 'access';
	public $module_id = 2;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('Model_user','Model_userlevel','Model_logcms'));
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
		
		$orderBy 					= "ORDER BY user_id DESC";
		$cond 						= $where." ".$orderBy;
		$rsLogCMS					= $this->Model_user->getListUser($cond);
		$iFilteredTotal 			= count($rsLogCMS);
		
		if(count($rsLogCMS) > 0){
			foreach($rsLogCMS as $key => $value){
				$btnActive = '<input type="hidden" name="userid['.$value['user_id'].']" value="'.$value['user_id'].'"><a class="btn-success btn-sm" title="Click to Inactive" href="'.BASE_URL_BACKEND.'/user/active/'.$value['user_id'].'"><span class="glyphicon glyphicon-ok"></span></a> &nbsp; ';
				if($value['user_active_status'] == 0) {
					$btnActive = '<input type="hidden" name="userid['.$value['user_id'].']" value="'.$value['user_id'].'"><a class="btn-danger btn-sm" title="Click to Active" href="'.BASE_URL_BACKEND.'/user/active/'.$value['user_id'].'"><span class="glyphicon glyphicon-remove"></span></a> &nbsp; ';
				}  
				
				$btnEdit = '<a class="btn-primary btn-sm" title="Click to Edit" href="'.BASE_URL_BACKEND.'/user/edit/'.$value['user_id'].'"><span class="glyphicon glyphicon-pencil"></span></a> &nbsp;'; 
				$btnDelete = '<a class="btn-danger btn-sm" title="Click to Delete" onclick="var answer = confirm(\'delete user '.$value['user_name'].' ?\'); if (answer){window.location = \''.BASE_URL_BACKEND.'/user/delete/'.$value['user_id'].'\';}"><span class="glyphicon glyphicon-trash"></span></i></a> &nbsp;'; 
				
				$rsLogCMS[$key]['user_action'] = $btnActive.$btnEdit.$btnDelete;
			}	
		}	
		
		$cond 						= $orderBy;
		$rsLogCMSTotal				= $this->Model_user->getListUser($cond);
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
		$this->load->view('user/list',$this->data);
	}
	
	function active($id){
		$id = $this->security->xss_clean(secure_input($id));
		
		if ($id == '') {
			redirect(BASE_URL_BACKEND."/user");
			exit();
		}
		
		$rsUser = $this->Model_user->getUser($id);
		$user_name = $rsUser[0]['user_name'];
		$useractive = abs($rsUser[0]['user_active_status']-1);
		
		$active = $this->Model_user->activeUser($id);
		
		if($useractive == 1){
			$log_module = "Active ".$this->module;
		} else {
			$log_module = "Inactive ".$this->module;
		}
		$log_value = $id." | ".$user_name." | ".$useractive;
		$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
		
		redirect(BASE_URL_BACKEND."/user");
	}
	
	function delete($id=''){
		$id = $this->security->xss_clean(secure_input($id));
		
		if(empty($id)){
			redirect(BASE_URL_BACKEND."/user");
			exit();
		}
		
		$rsUser = $this->Model_user->getUser($id);
		$user_name = $rsUser[0]['user_name'];
		
		$delete = $this->Model_user->deleteUser($id);
		$log_module = "Delete ".$this->module;

		$log_value = $id." | ".$user_name;
		$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
		
		redirect(BASE_URL_BACKEND."/user");
	}
	
	public function add(){
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsListUserLevel = $this->Model_userlevel->getListUserLevel(" WHERE user_level_active_status = 1");
		$this->data["ListUserLevel"] = $rsListUserLevel;
		$this->data["CountUserLevel"] = count($rsListUserLevel);
		
		$userlevelid = "";
		$this->data["userlevelid"] = $userlevelid;

		$this->load->view('header',$this->data);
		$this->load->view('user/add',$this->data);
	}
	
	public function doAdd(){
		$tb = $_POST['tbSave'];
		if (!$tb) {
			redirect(BASE_URL_BACKEND."/user");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsListUserLevel = $this->Model_userlevel->getListUserLevel(" WHERE user_level_active_status = 1");
		$this->data["ListUserLevel"] = $rsListUserLevel;
		$this->data["CountUserLevel"] = count($rsListUserLevel);
		
		$userlevelid = $_POST['userlevelid'];
		$username = $this->security->xss_clean(secure_input($_POST['username']));
		$email = $this->security->xss_clean(secure_input($_POST['email']));
		$password = $this->security->xss_clean(secure_input_password($_POST['password']));
		$length_password = strlen($password);
		$retypepassword = $this->security->xss_clean(secure_input_password($_POST['retypepassword']));
		
		$pattern = "/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD";
		
		$pesan = array();
		// Validasi data
		if ($userlevelid=="0") {
			$pesan[] = 'User Level has not been choose';
		}else if ($username=="") {
			$pesan[] = 'User Name is empty';
		} else if ($email=="") {
			$pesan[] = 'Email is empty';
		} else if ($password=="") {
			$pesan[] = 'Password is empty';
		} else if ($retypepassword=="") {
			$pesan[] = 'Retype Password is empty';
		} else if(!preg_match($pattern, $email)){
			$pesan[] = 'Email is not valid';
		} else if ($length_password < 6) {
			$pesan[] = 'Minimum password is six character';
		} else if ($password != $retypepassword) {
			$pesan[] = 'Password not same with Retype Password';
		}
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;

				$this->data['userlevelid']=$userlevelid;
				$this->data['username']=$username;
				$this->data['email']=$email;
				
				$this->load->view('header',$this->data);
				$this->load->view('user/add',$this->data);
			}
		} else { 
			$cekUser = $this->Model_user->checkUser($username);
			$countUser = count($cekUser);
			
			if ($countUser > 0 ) {
				$this->data['error']='User Name '.$username.' already exist';
				
				$this->data['userlevelid']=$userlevelid;
				$this->data['username']=$username;
				$this->data['email']=$email;
				
				$this->load->view('header',$this->data);
				$this->load->view('user/add',$this->data);
			} else {
				$insert = $this->Model_user->insertUser($userlevelid,$username,$email,$password);
				
				$log_module = "Add ".$this->module;
				$log_value = $userlevelid." | ".$username." | ".$email;
				$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
				
				redirect(BASE_URL_BACKEND."/user/");
			}
		}
	}
	
	public function edit($id){	
		if (empty($id)) {
			redirect(BASE_URL_BACKEND."/user");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsListUserLevel = $this->Model_userlevel->getListUserLevel(" WHERE user_level_active_status = 1");
		$this->data["ListUserLevel"] = $rsListUserLevel;
		$this->data["CountUserLevel"] = count($rsListUserLevel);
		
		$rsUser = $this->Model_user->getUser($id);  // mengambil database dari model untuk dikirim ke view
		$countUser = count($rsUser);
		
		$this->data['rsUser'] = $rsUser;
		$this->data['countUser'] = $countUser;
		
		$this->load->view('header',$this->data);
		$this->load->view('user/edit',$this->data);
	}
	
	public function doEdit($id){
		$tb = $_POST['tbEdit'];
		if (!$tb OR $id == '') {
			redirect(BASE_URL_BACKEND."/user");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsListUserLevel = $this->Model_userlevel->getListUserLevel(" WHERE user_level_active_status = 1");
		$this->data["ListUserLevel"] = $rsListUserLevel;
		$this->data["CountUserLevel"] = count($rsListUserLevel);
		
		$rsUser = $this->Model_user->getUser($id);  // mengambil database dari model untuk dikirim ke view
		$countUser = count($rsUser);
		
		$this->data['rsUser'] = $rsUser;
		$this->data['countUser'] = $countUser;
		
		$userlevelid = $_POST['userlevelid'];
		$username = $this->security->xss_clean(secure_input($_POST['username']));
		$usernameOld = $this->security->xss_clean(secure_input($_POST['usernameOld']));
		$email = $this->security->xss_clean(secure_input($_POST['email']));
		
		$pattern = "/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD";
		
		$pesan = array();
		// Validasi data
		if ($userlevelid=="0") {
			$pesan[] = 'User Level has not been choose';
		}else if ($username=="") {
			$pesan[] = 'User Name is empty';
		} else if ($email=="") {
			$pesan[] = 'Email is empty';
		} else if(!preg_match($pattern, $email)){
			$pesan[] = 'Email is not valid';
		} 
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
				
				$this->data['userlevelid']=$userlevelid;
				$this->data['username']=$username;
				$this->data['email']=$email;
				
				$this->load->view('header',$this->data);
				$this->load->view('user/edit',$this->data);
			}
		} else {
			$cekUser = $this->Model_user->checkUser($username);
			$countUser = count($cekUser);
			
			if($username == $usernameOld){
				$countUser = 0;
			}
			
			if ($countUser > 0 ) {
				$this->data['error'] = 'User name '.$username.' already exist';
				
				$this->data['userlevelid']=$userlevelid;
				$this->data['username']=$username;
				$this->data['email']=$email;
				
				$this->load->view('header',$this->data);
				$this->load->view('user/edit',$this->data);
			} else {
				$insert = $this->Model_user->updateUser($id,$username,$email,$userlevelid);
				
				$log_module = "Edit ".$this->module;
				$log_value = $id." | ".$userlevelid." | ".$username." | ".$email;
				$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
				
				redirect(BASE_URL_BACKEND."/user/");
			}
		}
	}
}