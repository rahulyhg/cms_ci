<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_cms extends CI_Controller {
	public $arrMenu = array();
	public $data;
	public $privilege = array();
	public $module = "Logs";
	public $section = 'access';
	public $module_id = 7;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('Model_logcms'));
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
		$where = "";
		$orderBy = "";
		
		$orderBy 					= "ORDER BY log_id_cms DESC";
		$cond 						= $where." ".$orderBy;
		$rsLogCMS					= $this->Model_logcms->getListLogCMS($cond);
		$iFilteredTotal 			= count($rsLogCMS);
		
		$cond 						= $orderBy;
		$rsLogCMSTotal				= $this->Model_logcms->getListLogCMS($cond);
		$iTotal 					= count($rsLogCMSTotal);   

		$results = array(
				"sEcho" => 1,
				"iTotalRecords" => $iFilteredTotal,
				"iTotalDisplayRecords" => $iTotal,
				"aaData"=>$rsLogCMS);

		echo json_encode($results);
	}	
	
	function view(){
		$admin_data = $_SESSION['admin_data'];
		$this->data['admin_data'] = $admin_data;
		$this->data['section'] = $this->section; 
		$this->data['modul_id'] = $this->module_id;
		
		$this->load->view('header',$this->data);
		$this->load->view('log_cms/list');
	}
}