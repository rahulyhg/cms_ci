<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller {
	public $arrMenu = array();
	public $data;
	public $privilege = array();
	public $section = 2; //get module group id from database
	public $module_id = 7; //get module id from database
	public $module = "General";
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('Model_general','Model_logcms'));
		$this->load->helper(array('funcglobal','menu','accessprivilege'));
		
		//Check Cookie
		if(isset($_COOKIE['cms_user_id'])) {
			checkCookieLogin($_COOKIE['cms_user_id']);
		}
		
		if(empty($_SESSION['admin_data']) && !isset($_COOKIE['cms_user_id'])){
			session_destroy();
			setcookie('cms_user_id', '', 1, '/');
			redirect(BASE_URL_BACKEND."/signin");
			exit();
		}
	
		//get menu from helper menu
		$this->arrMenu = menu();
		$this->data = array();
        $this->data['ListMenu'] = $this->arrMenu;
        $this->data['CountMenu'] = count($this->arrMenu);
		
		//check privilege module
		$this->privilege = accessprivilegeuserlevel($_SESSION['admin_data']['user_level_id'], $this->module_id);
		$this->breadcrump = breadCrump($this->module_id);
	}
	
	public function index()
	{
		$this->view();
	}
	
	function view(){
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		$this->data['breadcrump'] = $this->breadcrump;
		
		$searchkey = "";
		$searchby = "";
		$where = "";
		$orderBy = "";
		$perpage = "";
		
		if(isset($_POST["tbSearch"])){
			$_SESSION["searchkey".$this->module_id] = '';
			$_SESSION["searchby".$this->module_id] = '';
			$_SESSION["perpage".$this->module_id] = '';
			
			$searchkey = $this->security->xss_clean(secure_input($_POST['searchkey']));
			$searchby = $this->security->xss_clean(secure_input($_POST['searchby']));
			$perpage = $this->security->xss_clean(secure_input($_POST['perpage']));
			
			$pesan = array();

			if ($searchkey=="") {
				$pesan[] = 'Keyword search is empty';
			} else if ($searchby=="") {
				$pesan[] = 'Search by has not been choose';
			}
			
			if (! count($pesan)==0 ) {
				foreach ($pesan as $indeks=>$pesan_tampil) {
					$_SESSION["searchkey".$this->module_id] = '';
					$_SESSION["searchby".$this->module_id] = '';
					$_SESSION["perpage".$this->module_id] = '';
				}
			} else {
				$_SESSION["searchkey".$this->module_id] = $searchkey;
				$_SESSION["searchby".$this->module_id] = $searchby;
				$_SESSION["perpage".$this->module_id] = $perpage;

				if(isset($_POST['searchkey'])){
					$searchkey = $_SESSION["searchkey".$this->module_id];
				}
				if(isset($_POST['searchby'])){
					$searchby = $_SESSION["searchby".$this->module_id];
				}
				
				if($searchkey != "" && $searchby != ""){
					$where   =   " WHERE ".$searchby." LIKE '%". $searchkey ."%' ";
				}
			}	
		} else {
			$searchkey = @$_SESSION["searchkey".$this->module_id];
			$searchby = @$_SESSION["searchby".$this->module_id];
			
			if($searchkey != "" && $searchby != ""){
				$where   =   " WHERE ".$searchby." LIKE '%". $searchkey ."%' ";
			}
			
			if(isset($_POST['perpage'])){
				$perpage = $this->security->xss_clean(secure_input($_POST['perpage'])); 
				$_SESSION["perpage".$this->module_id] = $perpage;
			} else {
				$perpage = @$_SESSION["perpage".$this->module_id];
				
				if($perpage == ""){
					$perpage = PER_PAGE;
				}
			}
		}
		
		$orderBy = "ORDER BY general_id DESC";
		
		$cond 			= $where." ".$orderBy;
		$rsUserLevel	= $this->Model_general->getListGeneral($cond);
		$base_url		= BASE_URL_BACKEND."/general/view/";
		$total_rows		= count($rsUserLevel);
		$per_page		= $perpage;
		
		$this->data['paging']		= pagging($base_url , $total_rows, $per_page);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
		$start = $per_page*$page - $per_page;
		if ($start<0) $start = 0;
		//$cond .= " LIMIT ".$start.",".$per_page;
		$this->data["ListGeneral"] = $this->Model_general->getListGeneral($cond);
		
		$this->data['searchkey'] = $searchkey;
		$this->data['searchby'] = $searchby;
		$this->data['perpage'] = $perpage;
		
		$this->data['total'] = $total_rows;
		
		//extract privilege
		$this->data["list"] = $this->privilege[0];
		$this->data["view"] = $this->privilege[1];
		$this->data["add"] = $this->privilege[2];
		$this->data["edit"] = $this->privilege[3];
		$this->data["publish"] = $this->privilege[4];
		$this->data["approve"] = $this->privilege[5];
		$this->data["delete"] = $this->privilege[6];
		$this->data["order"] = $this->privilege[7];
		
		if($this->data["list"] == 0){
			echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
			die;
		}
		
		$this->load->view('header',$this->data);
		$this->load->view('general/list');
	}
	
	public function edit($id){
		if (empty($id)) {
			redirect(BASE_URL_BACKEND."/general");
			exit();
		}

		//extract privilege
		$this->data["edit"] = $this->privilege[3];
		
		if($this->data["edit"] == 0){
			echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
			die;
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		$this->data['breadcrump'] = $this->breadcrump;
		
		$rsGeneral = $this->Model_general->getGeneral($id);  // mengambil database dari model untuk dikirim ke view
		$countGeneral = count($rsGeneral);
		
		$this->data['rsGeneral'] = $rsGeneral;
		$this->data['countGeneral'] = $countGeneral;
		
		$this->load->view('header',$this->data);
		$this->load->view('general/edit',$this->data);
	}
	
	public function doEdit($id){
		$tb = $_POST['tbEdit'];
		if (!$tb OR $id == '') {
			redirect(BASE_URL_BACKEND."/general");
			exit();
		}
		
		//extract privilege
		$this->data["approve"] = $this->privilege[3];
		
		if($this->data["approve"] == 0){
			echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
			die;
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		$this->data['breadcrump'] = $this->breadcrump;
		
		$rsGeneral = $this->Model_general->getGeneral($id);  // mengambil database dari model untuk dikirim ke view
		$countGeneral = count($rsGeneral);
		
		$this->data['rsGeneral'] = $rsGeneral;
		$this->data['countGeneral'] = $countGeneral;
		
		$generaltitle = $this->security->xss_clean(secure_input($_POST['generaltitle']));
		$generaldescription = $this->security->xss_clean(secure_input($_POST['generaldescription']));
		$generalkeywords = $this->security->xss_clean(secure_input($_POST['generalkeywords']));
		$doctorscheduleName = secure_input_editor($_POST['doctorscheduleName']);
		$generalfacebook = secure_input_editor(@$_POST['generalfacebook']);
		$generaltwitter = secure_input_editor(@$_POST['generaltwitter']);
		$generalcsphonenumber = secure_input_editor(@$_POST['generalcsphonenumber']);
		$generalcsemail = secure_input_editor(@$_POST['generalcsemail']);

		$pesan = array();
		// Validasi data
		if ($generaltitle=="") {
			$pesan[] = 'Title is empty';
		} else if ($generaldescription=="") {
			$pesan[] = 'Description is empty';
		} else if ($generalkeywords=="") {
			$pesan[] = 'Keywords is empty';
		} else if ($generalcsphonenumber=="") {
			$pesan[] = 'Custumer Care Phone Number is empty';
		} else if ($generalcsemail=="") {
			$pesan[] = 'Custumer Care Email is empty';
		} 
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
				
				$this->data['generaltitle']=$generaltitle;
				$this->data['generaldescription']=$generaldescription;
				$this->data['generalkeywords']=$generalkeywords;
				$this->data['generalfacebook']=$generalfacebook;
				$this->data['generaltwitter']=$generaltwitter;
				$this->data['generalcsphonenumber']=$generalcsphonenumber;
				$this->data['generalcsemail']=$generalcsemail;
				
				$this->load->view('header',$this->data);
				$this->load->view('general/edit',$this->data);
			}
		} else {
			$update = $this->Model_general->updateGeneral($id,$generaltitle,$generaldescription,$generalkeywords,$generalfacebook,$generaltwitter,$generalcsphonenumber,$generalcsemail);
			
			$log_module = "Edit ".$this->module;
			$log_value = $id." | ".$generaltitle." | ".$generaldescription." | ".$generalkeywords." | ".$generalfacebook." | ".$generaltwitter." | ".$generalcsphonenumber." | ".$generalcsemail;
			$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
			
			//Cache JSON Meta
			$rsGeneral			= $this->Model_general->getListGeneral(" ORDER BY general_id DESC LIMIT 1 ");
			$countGeneral		= count($rsGeneral);
			createCache($rsGeneral,"meta");
			//End Cache JSON Meta 
			
			redirect(BASE_URL_BACKEND."/general");
		}	
	}
}