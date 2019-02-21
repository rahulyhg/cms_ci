<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Access extends CI_Controller {
	public $arrMenu = array();
	public $data;
	public $section = 'access';
	public $module_id = 6;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('Model_userlevel','Model_access','Model_module','Model_logcms'));
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
	
	public function view(){
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$searchkey = "";
		$searchby = "";
		$where = "";
		$orderBy = "";
		
		
		if(isset($_POST["tbSearch"])){
			$_SESSION["searchkey".$this->module_id] = '';
			$_SESSION["searchby".$this->module_id] = '';
			$_SESSION["perpage".$this->module_id] = '';
			
			$searchkey = $this->security->xss_clean(secure_input($_POST['searchkey']));
			$searchby = $this->security->xss_clean(secure_input($_POST['searchby']));
			
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
		}
		
		$orderBy = "ORDER BY user_level_id ASC";
		
		$cond 			= $where." ".$orderBy;
		$rsUserLevel	= $this->Model_userlevel->getListUserLevel($cond);
		$base_url		= BASE_URL_BACKEND."/access/view/";
		$total_rows		= count($rsUserLevel);
		$per_page		= PER_PAGE;
		
		$this->data['paging']		= pagging($base_url , $total_rows, $per_page);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
		$start = $per_page*$page - $per_page;
		if ($start<0) $start = 0;
		$cond .= " LIMIT ".$start.",".$per_page;
		$this->data["ListUserLevel"] = $this->Model_userlevel->getListUserLevel($cond);
		
		$this->data['searchkey'] = $searchkey;
		$this->data['searchby'] = $searchby;
		
		$this->load->view('header',$this->data);
		$this->load->view('access/list',$this->data);
	}
	
	public function listprivilege($id){
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsUserLevel = $this->Model_userlevel->getUserLevel($id);
		$this->data["user_level_name"] = $rsUserLevel[0]['user_level_name'];
		$this->data["id"] = $id;
		
		$rsListPrivilege = $this->Model_access->getListPrivilege(" ORDER BY privilege_id");
		$this->data["ListPrivilege"] = $rsListPrivilege;
		$this->data["CountListPrivilege"] = count($rsListPrivilege);
		
		$arrListModuleAccess = array();
		$rsListModuleAccess = $this->Model_access->getListModuleAccessPrivilege(" WHERE module_active_status = 1 AND module_group_active_status = 1 AND c.user_level_id = ".$id." ORDER BY b.module_group_id");

		for($i=0; $i<count($rsListModuleAccess); $i++){
			$arrListModuleAccess[$i]['module_id'] = $rsListModuleAccess[$i]['module_id'];
			$arrListModuleAccess[$i]['module_name'] = $rsListModuleAccess[$i]['module_name'];
			$arrListModuleAccess[$i]['module_path'] = $rsListModuleAccess[$i]['module_path'];
			$arrListModuleAccess[$i]['module_active_status'] = $rsListModuleAccess[$i]['module_active_status'];
			$arrListModuleAccess[$i]['module_order_value'] = $rsListModuleAccess[$i]['module_order_value'];
			$arrListModuleAccess[$i]['module_group_id'] = $rsListModuleAccess[$i]['module_group_id'];
			$arrListModuleAccess[$i]['module_group_name'] = $rsListModuleAccess[$i]['module_group_name'];
			$arrListModuleAccess[$i]['user_level_id'] = $rsListModuleAccess[$i]['user_level_id'];
			$arrListModuleAccess[$i]['access_active_status'] = $rsListModuleAccess[$i]['access_active_status'];
			$arrListModuleAccess[$i]['access_id'] = $rsListModuleAccess[$i]['access_id'];
			
			$rsListAccessPrivilege = $this->Model_access->getListAccessPrivilege(" WHERE access_id = ".$rsListModuleAccess[$i]['access_id']." ORDER BY privilege_id");
			for($j=0; $j<count($rsListAccessPrivilege); $j++){
				$rsListPrivilegeModule = $this->Model_access->getListPrivilegeModule($arrListModuleAccess[$i]['module_id'],$rsListAccessPrivilege[$j]['privilege_id']);
				$countListPrivilegeModule = count($rsListPrivilegeModule);
				$rsListAccessPrivilege[$j]['is_privilege'] = $countListPrivilegeModule;
			}
			$arrListModuleAccess[$i]['access'] = $rsListAccessPrivilege;
		}
		
		$this->data["ListAccessModule"] = $arrListModuleAccess;
		$this->data["CountAccessModule"] = count($arrListModuleAccess);
		
		$this->load->view('header',$this->data);
		$this->load->view('access/listprivilege',$this->data);
	}
	
	public function newprivilege($id){
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsUserLevel = $this->Model_userlevel->getUserLevel($id);
		$this->data["user_level_name"] = $rsUserLevel[0]['user_level_name'];
		$this->data["id"] = $id;
		
		$rsListModule = $this->Model_access->getListModulePrivilege(" WHERE module_active_status = 1 AND module_group_active_status = 1 ORDER BY b.module_group_id");
	
		for($i=0; $i<count($rsListModule); $i++){
			$rsListAccess = $this->Model_access->getListAccess($id,$rsListModule[$i]['module_id']);
			$countListAccess = count($rsListAccess);
			if($countListAccess == 1){
				$rsListModule[$i]['is_selected'] = 1;
			} else {
				$rsListModule[$i]['is_selected'] = 0;
			}
		}
		
		$this->data["ListModule"] = $rsListModule;
		$this->data["CountListModule"] = count($rsListModule);
		
		$this->load->view('header',$this->data);
		$this->load->view('access/newprivilege',$this->data);
	}
	
	public function doNewprivilege($id){
		$tb = $_POST['tbSave'];
		if (!$tb) {
			redirect(BASE_URL_BACKEND."/access/newprivilege/".$id);
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$rsUserLevel = $this->Model_userlevel->getUserLevel($id);
		$this->data["user_level_name"] = $rsUserLevel[0]['user_level_name'];
		$this->data["id"] = $id;
		
		$rsListModule = $this->Model_access->getListModulePrivilege(" WHERE module_active_status = 1 AND module_group_active_status = 1 ORDER BY b.module_group_id");
	
		for($i=0; $i<count($rsListModule); $i++){
			$rsListAccess = $this->Model_access->getListAccess($id,$rsListModule[$i]['module_id']);
			$countListAccess = count($rsListAccess);
			if($countListAccess == 1){
				$rsListModule[$i]['is_selected'] = 1;
			} else {
				$rsListModule[$i]['is_selected'] = 0;
			}
		}
		
		$this->data["ListModule"] = $rsListModule;
		$this->data["CountListModule"] = count($rsListModule);
		
		$moduleid = @$_POST['moduleid'];
		$userlevelid = $_POST['userlevelid'];
		
		$pesan = array();
		// Validasi data
		if ($moduleid=="") {
			$pesan[] = 'Module Privilege  has not been choose';
		}
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
				
				$this->load->view('header',$this->data);
				$this->load->view('access/newprivilege',$this->data);
			}
		} else { 
			foreach($moduleid as $m_id){
				$rsListPrivilege = $this->Model_access->getListPrivilege(" ORDER BY privilege_id");
				
				$rsListAccessPrivilege = $this->Model_access->getAccess($userlevelid,$m_id);
				$countListAccessPrivilege = count($rsListAccessPrivilege);
				
				if($countListAccessPrivilege < 1){
					$accessid = $this->Model_access->insertAccess($userlevelid,$m_id);
					
					if(!empty($accessid)){
						for($i=0; $i<count($rsListPrivilege); $i++){
							$privilege_id = $rsListPrivilege[$i]['privilege_id'];
							$accessprivilegeid = $this->Model_access->insertAccessPrivilege($accessid,$privilege_id);
						}	
					}
				}
			}
			redirect(BASE_URL_BACKEND."/access/listprivilege/".$id);
		}
	}
	
	function active($moduleprivilegeid, $id){
		if ($id == '') {
			redirect(BASE_URL_BACKEND."/access/listprivilege/".$id);
			exit();
		}
		
		$active = $this->Model_access->activeAccessPrivilege($moduleprivilegeid);
		redirect(BASE_URL_BACKEND."/access/listprivilege/".$id);
	}
}