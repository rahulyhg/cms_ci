<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {
	public $arrMenu = array();
	public $data;
	public $privilege = array();
	public $section = 3; //get module group id from database
	public $module_id = 9; //get module id from database
	public $alias_category = "pages";
	public $module = "Pages";
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('Model_pages','Model_alias','Model_logcms'));
		$this->load->helper(array('menu','accessprivilege','alias'));
		
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
		
		$orderBy = "ORDER BY pages_id DESC";
		
		$cond 			= $where." ".$orderBy;
		$rsUserLevel	= $this->Model_pages->getListPages($cond);
		$base_url		= BASE_URL_BACKEND."/pages/view/";
		$total_rows		= count($rsUserLevel);
		$per_page		= $perpage;
		
		$this->data['paging']		= pagging($base_url , $total_rows, $per_page);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
		$start = $per_page*$page - $per_page;
		if ($start<0) $start = 0;
		$cond .= " LIMIT ".$start.",".$per_page;
		$ListPages = $this->Model_pages->getListPages($cond);
		
		$this->data["ListPages"] = $ListPages;
		
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
		$this->load->view('pages/list');
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
		$this->load->view('pages/add',$this->data);
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
			redirect(BASE_URL_BACKEND."/pages");
			exit();
		}
		
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		$this->data['breadcrump'] = $this->breadcrump;
		
		$pagestitle = $this->security->xss_clean(secure_input($_POST['pagestitle']));
		$pagesshortdesc = secure_input_editor($_POST['pagesshortdesc']);
		$pagesdesc = secure_input_editor($_POST['pagesdesc']);
		$pagesimageurl = $this->security->xss_clean(secure_input($_POST['pagesimageurl']));
		$pagesalias = $this->security->xss_clean(secure_input($_POST['pagesalias']));
		$pagesmetadescription = $this->security->xss_clean(secure_input($_POST['pagesmetadescription']));
		$pagesmetakeywords = $this->security->xss_clean(secure_input($_POST['pagesmetakeywords']));
		
		$pesan = array();
		// Validasi data
		if ($pagestitle=="") {
			$pesan[] = 'Pages Title is empty';
		} else if ($pagesdesc=="") {
			$pesan[] = 'Pages Description is empty';
		} 
		
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
				
				$this->data['pagestitle']=$pagestitle;
				$this->data['pagesshortdesc']=$pagesshortdesc;
				$this->data['pagesdesc']=$pagesdesc;
				$this->data['pagesimageurl']=$pagesimageurl;
				$this->data['pagesalias']=$pagesalias;
				$this->data['pagesmetadescription']=$pagesmetadescription;
				$this->data['pagesmetakeywords']=$pagesmetakeywords;
					
				$this->load->view('heder',$this->data);
				$this->load->view('pages/add',$this->data);
			}
		} else {
			$cekPages = $this->Model_pages->checkPages($pagestitle);
			$countPages = count($cekPages);
			
			if ($countPages > 0 ) {
				$this->data['error']='Pages Title '.$pagestitle.' already exist';
				
				$this->data['pagestitle']=$pagestitle;
				$this->data['pagesshortdesc']=$pagesshortdesc;
				$this->data['pagesdesc']=$pagesdesc;
				$this->data['pagesimageurl']=$pagesimageurl;
				$this->data['pagesalias']=$pagesalias;
				$this->data['pagesmetadescription']=$pagesmetadescription;
				$this->data['pagesmetakeywords']=$pagesmetakeywords;
				
				$this->load->view('header',$this->data);
				$this->load->view('pages/add',$this->data);
			} else {
				$pagesimageurl = str_replace(BASE_URL,"",$pagesimageurl);
				$countAlias = 0;
				
				if(!empty($pagesalias)) {
					$alias = generateAlias($pagesalias);
					$cekAlias = $this->Model_alias->checkAliasCategory($alias,$this->alias_category);
					$countAlias = count($cekAlias);
				} else {
					$alias = generateAlias($pagestitle);
					$cekAlias = $this->Model_alias->checkAliasCategory($alias,$this->alias_category);
					$countAlias = count($cekAlias);
				}
				
				if ($countAlias > 0 ) {
					$this->data['error']='Alias '.$alias.' already exist from title '.$pagestitle.'';
				
					$this->data['pagestitle']=$pagestitle;
					$this->data['pagesshortdesc']=$pagesshortdesc;
					$this->data['pagesdesc']=$pagesdesc;
					$this->data['pagesimageurl']=$pagesimageurl;
					$this->data['pagesalias']=$pagesalias;
					$this->data['pagesmetadescription']=$pagesmetadescription;
					$this->data['pagesmetakeywords']=$pagesmetakeywords;
				
					$this->load->view('header',$this->data);
					$this->load->view('pages/add',$this->data);
				} else {				
					$pagesid = $this->Model_pages->insertPages($pagestitle,$pagesdesc,$pagesimageurl,$pagesalias,$pagesmetadescription,$pagesmetakeywords,$pagesshortdesc);
					if(!empty($pagesid)) {
						$aliasid = $this->Model_alias->insertAlias($pagesid,$this->alias_category,$alias,"pages/detail/".$pagesid);
					}
					
					$log_module = "Add ".$this->module;
					$log_value = $pagesid." | ".$pagestitle." | ".$pagesshortdesc." | ".$pagesdesc." | ".$pagesimageurl." | ".$pagesalias." | ".$pagesmetadescription." | ".$pagesmetakeywords;
					$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
					
					redirect(BASE_URL_BACKEND."/pages");
				}
				
			}	
		}	
	}
	
	function active($id){
		if (empty($id)) {
			redirect(BASE_URL_BACKEND."/pages");
			exit();
		}
		
		//extract privilege
		$this->data["publish"] = $this->privilege[4];
		
		if($this->data["publish"] == 0){
			echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
			die;
		}
		
		$rsPages = $this->Model_pages->getPages($id); 
		$title = $rsPages[0]['pages_title'];
		$active_status = abs($rsPages[0]['pages_active_status']-1);
		
		$active = $this->Model_pages->activePages($id);
		createRouteAlias(); //create route alias
		
		if($active_status == 1){
			$log_module = "Active ".$this->module;
		} else {
			$log_module = "Inactive ".$this->module;
		}
		$log_value = $id." | ".$title." | ".$active_status;
		$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
		
		//Cache JSON Pages
		$ListPages = $this->generatePages();
		createCache($ListPages,"pages");
		//End Cache JSON Pages

		redirect(BASE_URL_BACKEND."/pages");
		
	}
	
	function delete($id){
		if (empty($id)) {
			redirect(BASE_URL_BACKEND."/pages");
			exit();
		}
		
		//extract privilege
		$this->data["delete"] = $this->privilege[6];
		
		if($this->data["delete"] == 0){
			echo "<script>alert('Can\'t Access Module');window.location.href='".BASE_URL_BACKEND."/home';</script>";
			die;
		}
		
		$rsPages = $this->Model_pages->getPages($id); 
		$title = $rsPages[0]['pages_title'];
		
		$delete = $this->Model_pages->deletePages($id);
		$delete_alias = $this->Model_alias->deleteAlias($id, $this->alias_category);
		createRouteAlias(); //create route alias
		
		$log_module = "Delete ".$this->module;
		$log_value = $id." | ".$title;
		$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
		
		//Cache JSON Pages
		$ListPages = $this->generatePages();
		createCache($ListPages,"pages");
		//End Cache JSON Pages
		
		redirect(BASE_URL_BACKEND."/pages");
	}
	
	public function edit($id){
		if (empty($id)) {
			redirect(BASE_URL_BACKEND."/pages");
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
		
		$rsPages = $this->Model_pages->getPages($id);  // mengambil database dari model untuk dikirim ke view
		$countPages = count($rsPages);
		
		$this->data['rsPages'] = $rsPages;
		$this->data['countPages'] = $countPages;
		
		$this->load->view('header',$this->data);
		$this->load->view('pages/edit',$this->data);
	}
	
	public function doEdit($id){
		$tb = $_POST['tbEdit'];
		if (!$tb OR $id == '') {
			redirect(BASE_URL_BACKEND."/pages");
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
		
		$rsPages = $this->Model_pages->getPages($id);  // mengambil database dari model untuk dikirim ke view
		$countPages = count($rsPages);
		
		$this->data['rsPages'] = $rsPages;
		$this->data['countPages'] = $countPages;
		
		$pagestitle = $this->security->xss_clean(secure_input($_POST['pagestitle']));
		$pagesshortdesc = secure_input_editor($_POST['pagesshortdesc']);
		$pagestitleOld = $this->security->xss_clean(secure_input($_POST['pagestitleOld']));
		$pagesdesc = secure_input_editor($_POST['pagesdesc']);
		$pagesimageurl = $this->security->xss_clean(secure_input($_POST['pagesimageurl']));
		$pagesalias = $this->security->xss_clean(secure_input(@$_POST['pagesalias']));
		$pagesmetadescription = $this->security->xss_clean(secure_input($_POST['pagesmetadescription']));
		$pagesmetakeywords = $this->security->xss_clean(secure_input($_POST['pagesmetakeywords']));
		
		$pesan = array();
		// Validasi data
		if ($pagestitle=="") {
			$pesan[] = 'Pages Title is empty';
		} else if ($pagesdesc=="") {
			$pesan[] = 'Pages Description is empty';
		} 
		
		
		if (! count($pesan)==0 ) {
			foreach ($pesan as $indeks=>$pesan_tampil) {
				$this->data['error'] = $pesan_tampil;
				
				$this->load->view('header',$this->data);
				$this->load->view('pages/edit',$this->data);
			}
		} else {
			$cekPages = $this->Model_pages->checkPages($pagestitle);
			$countPages = count($cekPages);
			
			if($pagestitle == $pagestitleOld){
				$countPages = 0;
			}
			
			if ($countPages > 0 ) {
				$this->data['error']='Pages Title '.$pagestitle.' already exist';

				$this->load->view('header',$this->data);
				$this->load->view('pages/edit',$this->data);
			} else {
				$pagesimageurl = str_replace(BASE_URL,"",$pagesimageurl);
				$countAlias = 0;
				
				if(!empty($pagesalias)) {
					$alias = generateAlias($pagesalias);
					$cekAlias = $this->Model_alias->checkAliasCategory($alias,$this->alias_category);
					$countAlias = count($cekAlias);
				} else {
					$alias = generateAlias($pagestitle);
					$cekAlias = $this->Model_alias->checkAliasCategory($alias,$this->alias_category);
					$countAlias = count($cekAlias);
				}
				
				if($pagestitle == $pagestitleOld){
					$countAlias = 0;
				}
				
				if ($countAlias > 0 ) {
					$this->data['error']='Alias '.$alias.' already exist from title '.$pagestitle.'';
					
					$this->load->view('header',$this->data);
					$this->load->view('pages/edit',$this->data);
				} else {				
					$update = $this->Model_pages->updatePages($id,$pagestitle,$pagesdesc,$pagesimageurl,$pagesalias,$pagesmetadescription,$pagesmetakeywords,$pagesshortdesc);
					if($update) {
						$this->Model_alias->updateAlias($id,$alias,$this->alias_category);
					}
					
					createRouteAlias(); //create route alias
					
					$log_module = "Edit ".$this->module;
					$log_value = $id." | ".$pagestitle." | ".$pagesshortdesc." | ".$pagesdesc." | ".$pagesimageurl." | ".$pagesalias." | ".$pagesmetadescription." | ".$pagesmetakeywords;
					$insertlog = $this->Model_logcms->insertLogCMS($log_module,$log_value);
					
					//Cache JSON Pages
					$ListPages = $this->generatePages();
					createCache($ListPages,"pages");
					//End Cache JSON Pages
					
					redirect(BASE_URL_BACKEND."/pages");
				}
			}	
		}
		
	}
	
	function generatePages(){
		$rsPages			= $this->Model_pages->getListPagesAlias();
		
		return $rsPages;
	}
	
}