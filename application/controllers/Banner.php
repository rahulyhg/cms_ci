<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends CI_Controller {
	public $arrMenu = array();
	public $data;
	public $privilege = array();
	public $section = 3; //get module group id from database
	public $module_id = 8; //get module id from database
	public $module = "Banner";
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('Model_banner','Model_logcms'));
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
	
	public function viewdatatables(){
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		$this->data['breadcrump'] = $this->breadcrump;
		
		$where = "";
		$orderBy = "";
		
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
		
		$orderBy = "ORDER BY banner_id DESC";
		
		$cond 				= $where." ".$orderBy;
		$rsBanner			= $this->Model_banner->getListBanner($cond);
		$this->data["ListBanner"] = $rsBanner;
		
		$this->load->view('header',$this->data);
		$this->load->view('banner/list_datatables');
	}
	
	function view(){
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		$this->data['breadcrump'] = $this->breadcrump;
		
		$searchkey = "";
		$searchby = "";
		$searchkeynew = "";
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
		
		$orderBy = "ORDER BY banner_id DESC";
		
		$cond 				= $where." ".$orderBy;
		$rsBanner			= $this->Model_banner->getListBanner($cond);
		$base_url			= BASE_URL_BACKEND."/banner/view/";
		$total_rows			= count($rsBanner);
		$per_page			= $perpage;
		
		$this->data['paging']		= pagging($base_url , $total_rows, $per_page);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
		$start = $per_page*$page - $per_page;
		if ($start<0) $start = 0;
		$cond .= " LIMIT ".$start.",".$per_page;
		$this->data["ListBanner"] = $this->Model_banner->getListBanner($cond);
		
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
		
		$this->data['searchkey'] = $searchkey;
		$this->data['searchby'] = $searchby;
		$this->data['perpage'] = $perpage;
		
		$this->data['total'] = $total_rows;
		
		$this->load->view('header',$this->data);
		$this->load->view('banner/list');
	}
	
	public function add(){
		//extract privilege
		$this->data["add"] = $this->privilege[2];
		
		if($this->data["add"] == 0){
			echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
			die;
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		$this->data['breadcrump'] = $this->breadcrump;
		
		$this->load->view('header',$this->data);
		$this->load->view('banner/add',$this->data);
	}
	
	public function doAdd(){
		//extract privilege
		$this->data["add"] = $this->privilege[2];
		
		if($this->data["add"] == 0){
			echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
			die;
		}
		
		$tb = $_POST['tbSave'];
		if (!$tb) {
			redirect(BASE_URL_BACKEND."/banner");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		$this->data['breadcrump'] = $this->breadcrump;
		
		$bannername = $this->security->xss_clean(secure_input($_POST['bannername']));
		$bannertype = $_POST['bannertype'];
		$bannersimageurl = $this->security->xss_clean(secure_input($_POST['bannersimageurl']));
		$bannerurl = $this->security->xss_clean(secure_input(@$_POST['bannerurl']));
		
		$patern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
		
		$pesan = array();
		// Validasi data
		if ($bannername=="") {
			$pesan[] = 'Banner Name is empty';
		} else if ($bannertype=="0") {
			$pesan[] = 'Banner Type is not selected';
		} else if ($bannersimageurl=="") {
			$pesan[] = 'Banner Image is empty';
		} 
		
		if(!empty($bannerurl)){
			if (!preg_match($patern, $bannerurl)) {
				$pesan[] = 'Banner URL is not valid format';
			}
		}
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
				
				$this->data['bannername']=$bannername;
				$this->data['bannertype']=$bannertype;
				$this->data['bannersimageurl']=$bannersimageurl;
				$this->data['bannerurl']=$bannerurl;
				
				$this->load->view('backend/header',$this->data);
				$this->load->view('backend/banner/add',$this->data);
			}
		} else {
			$bannersimageurl = str_replace(BASE_URL,"",$bannersimageurl);
			$bannerid = $this->Model_banner->insertBanner($bannername,$bannersimageurl,$bannertype,$bannerurl);
			
			$log_module = "Add ".$this->module;
			$log_value = $bannerid." | ".$bannername." | ".$bannersimageurl." | ".$bannertype." | ".$bannerurl;
			$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
			
			redirect(BASE_URL_BACKEND."/banner");
		}	
	}
	
	function active($id){
		if (empty($id)) {
			redirect(BASE_URL_BACKEND."/banner");
			exit();
		}
		
		//extract privilege
		$this->data["publish"] = $this->privilege[4];
		
		if($this->data["publish"] == 0){
			echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
			die;
		}
		
		$rsBanner = $this->Model_banner->getBanner($id); 
		$title = $rsBanner[0]['banner_name'];
		$active_status = abs($rsBanner[0]['banner_active_status']-1);
		
		$active = $this->Model_banner->activeBanner($id);
		
		if($active_status == 1){
			$log_module = "Active ".$this->module;
		} else {
			$log_module = "Inactive ".$this->module;
		}
		$log_value = $id." | ".$title." | ".$active_status;
		$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
		
		redirect(BASE_URL_BACKEND."/banner");
	}
	
	function delete($id){
		if (empty($id)) {
			redirect(BASE_URL_BACKEND."/banner");
			exit();
		}
		
		//extract privilege
		$this->data["delete"] = $this->privilege[6];
		
		if($this->data["delete"] == 0){
			echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
			die;
		}
		
		$rsBanner = $this->Model_banner->getBanner($id); 
		$title = $rsBanner[0]['banner_name'];
		
		$delete = $this->Model_banner->deleteBanner($id);
		
		$log_module = "Delete ".$this->module;
		$log_value = $id." | ".$title;
		$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
		
		redirect(BASE_URL_BACKEND."/banner");
	}
	
	public function edit($id){
		if (empty($id)) {
			redirect(BASE_URL_BACKEND."/banner");
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
		
		$rsBanner = $this->Model_banner->getBanner($id);  // mengambil database dari model untuk dikirim ke view
		$countBanner = count($rsBanner);
		
		$this->data['rsBanner'] = $rsBanner;
		$this->data['countBanner'] = $countBanner;
		
		$this->load->view('header',$this->data);
		$this->load->view('banner/edit',$this->data);
	}
	
	public function doEdit($id){
		$tb = $_POST['tbEdit'];
		if (!$tb OR $id == '') {
			redirect(BASE_URL_BACKEND."/banner");
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
		
		$rsBanner = $this->Model_banner->getBanner($id);  // mengambil database dari model untuk dikirim ke view
		$countBanner = count($rsBanner);
		
		$this->data['rsBanner'] = $rsBanner;
		$this->data['countBanner'] = $countBanner;
		
		$bannername = $this->security->xss_clean(secure_input($_POST['bannername']));
		$bannernameOld = $this->security->xss_clean(secure_input($_POST['bannernameOld']));
		$bannertype = $_POST['bannertype'];
		$bannersimageurl = $this->security->xss_clean(secure_input($_POST['bannersimageurl']));
		$bannerurl = $this->security->xss_clean(secure_input(@$_POST['bannerurl']));
		
		$patern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
		
		$pesan = array();
		// Validasi data
		if ($bannername=="") {
			$pesan[] = 'Banner Name is empty';
		} else if ($bannertype=="0") {
			$pesan[] = 'Banner Type is not selected';
		} else if ($bannersimageurl=="") {
			$pesan[] = 'Banner Image is empty';
		} 
		
		if(!empty($bannerurl)){
			if (!preg_match($patern, $bannerurl)) {
				$pesan[] = 'Banner URL is not valid format';
			}
		}
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
				
				$this->data['bannername']=$bannername;
				$this->data['bannertype']=$bannertype;
				$this->data['bannersimageurl']=$bannersimageurl;
				$this->data['bannerurl']=$bannerurl;
				
				$this->load->view('header',$this->data);
				$this->load->view('banner/edit',$this->data);
			}
		} else {
			$bannersimageurl = str_replace(BASE_URL,"",$bannersimageurl);
			$update = $this->Model_banner->updateBanner($id,$bannername,$bannersimageurl,$bannertype,$bannerurl);
			
			$log_module = "Edit ".$this->module;
			$log_value = $id." | ".$bannername." | ".$bannersimageurl." | ".$bannertype." | ".$bannerurl;
			$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
			
			redirect(BASE_URL_BACKEND."/banner");	
		}
		
	}
}